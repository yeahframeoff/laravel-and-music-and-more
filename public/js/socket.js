function SocketConnection(url)
{
    this.connections = {};

    this.init = function(url)
    {
        try {
            if (!WebSocket) {
                console.log("no websocket support");
            } else {
                var socket;
                if(url in this.connections){
                    socket = this.connections.url;
                    Backbone.trigger('socket:open');
                    Backbone.trigget('socket:currentUser');
                } else {
                    socket = new WebSocket("ws://" + url);
                    this.connections.url = socket;
                }
                $.holdReady(true)
                socket.addEventListener("open", function (e) {
                    $.holdReady(false);
                    Backbone.trigger("socket:open", {socket: e});
                });
                socket.addEventListener("error", function (e) {
                    console.log(e);
                    Backbone.trigger("socket:error", {socket: e});
                });
                socket.addEventListener("message", function (e) {
                    var type = JSON.parse(e.data).type;
                    var data = JSON.parse(e.data).data;
                    Backbone.trigger("socket:" + type, {data: data});
                });
                window.socket = socket; // debug
            }
        } catch (e) {
            console.log("exception: " + e);
        }
    };

    this.getSocket = function(url)
    {
        return this.connections.url;
    }

    this.init(url);
}