var app;

function Group(socket)
{
    this.isBroadcast;
    this.isSubscribe;
    this.socket = {};

    this.startBroadcast = function(){
        app.socket.send(JSON.stringify({
            type: 'startBroadcast',
            data: {"group_id": groupId}
        }));
    }

    this.stopBroadcast = function(){
        app.socket.send(JSON.stringify({
            type: 'stopBroadcast',
            data: {"group_id": groupId}
        }));
    }

    this.subscribe = function(){
        app.socket.send(JSON.stringify({
            type: 'subscribe',
            data: {"group_id": groupId}
        }));
    }

    this.unsubscribe = function(){
        app.socket.send(JSON.stringify({
            type: 'unsubscribe',
            data: {"group_id": groupId}
        }));
    }

    this.translateMessage = function(data){
        app.socket.send(JSON.stringify({
            type: 'translateMessage',
            data: data
        }));
    }

    this.init = function(socket){
        app = this;
        app.socket = socket;

        Backbone.on('audio:playingNow', function(e){
            console.log('playingNow');
            app.socket.send(JSON.stringify({
                type: 'translateCommand',
                data: {
                    command: 'playingNow',
                    commandData: e
                }
            }));
            console.log(e);
        });

        Backbone.on('socket:translateCommand', function(e){
            var command = e.data.command;
            console.log(command);
            switch (command){
                case 'playingNow':
                    player.playFromData(e.data.commandData)
                    break;
            }
            console.log(e);
        });

    }

    this.init(socket);
}

$(function() {

    var socket = new SocketConnection('localhost:7779/' + groupId);
    var group = new Group(socket.getSocket('localhost:7779/' + groupId));

    //TODO refactor
    $('.broadcast-btn').click(function(e){
        var active = $(this).attr('data-active');
        if(active == 1){
            group.stopBroadcast();
            $(this).html('Start broadcast');
        } else {
            group.startBroadcast();
            $(this).html('Stop broadcast');
        }
        $(this).attr('data-active', (active == 1) ? 0 : 1);
    });

    $('.subscribe-btn').click(function(e){
        var active = $(this).attr('data-active');
        if(active == 1){
            group.unsubscribe();
            $(this).html('Subscribe');
        } else {
            group.subscribe();
            $(this).html('Unsubscribe');
        }
        $(this).attr('data-active', (active == 1) ? 0 : 1);
    });

    Backbone.on('socket:translateCommand', function(e){
        var data = e.data;
        console.log(data);
    });

});