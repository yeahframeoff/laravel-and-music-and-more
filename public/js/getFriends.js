socket = window.socket;

$(function() {
    Backbone.on('socket:open', function(e){
        socket.send(JSON.stringify({
            type: 'getFriends',
            data: ''
        }));
    });

    Backbone.on('socket:friends', function(e){
        var data = e.data;
        var online = data.result.online;
        var offline = data.result.offline;

        var source = $('#user-template').html();
        var template = Handlebars.compile(source);

        console.log(data);
        online.forEach(function(user){
            user.online = 'online';
            var html = _.template(source, {model: user});
            $("#users-container").append(html);
            console.log('online');
        });

        offline.forEach(function(user){
            user.online = 'offline';
            var html = _.template(source, {model: user});
            $("#users-container").append(html);
            console.log('offline');
        });

    })
});