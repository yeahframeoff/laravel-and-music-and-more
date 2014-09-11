function SocketConnection(url)
{
    this.connections = {};
    this.currentUser = {};

    this.init = function(url)
    {
        try {
            if (!WebSocket) {
                console.log("no websocket support");
            } else {
                var socket;
                if(url in this.connections){
                    socket = this.connections[url];
                    Backbone.trigger('socket:open', {socket: socket});
                    Backbone.trigget('socket:currentUser', {data: this.currentUser});
                } else {
                    socket = new WebSocket("ws://" + url);
                    this.connections[url] = socket;
                }
                socket.addEventListener("open", function (e) {
                    Backbone.trigger("socket:open", {socket: e});
                });
                socket.addEventListener("error", function (e) {
                    console.log(e);
                    Backbone.trigger("socket:error", {socket: e});
                });
                socket.addEventListener("message", function (e) {
                    var type = JSON.parse(e.data).type;
                    var data = JSON.parse(e.data).data;
                    var id = JSON.parse(e.data).id;
                    if (type == "currentUser"){
                        this.currentUser = data;
                    }
                    console.log("type: ", type);
                    Backbone.trigger("socket:" + type, {data: data, id: id});
                });
                window.socket = socket; // debug
            }
        } catch (e) {
            console.log("exception: " + e);
        }
    };

    this.getSocket = function(url)
    {
        return this.connections[url];
    }

    this.getCurrentUser = function()
    {
        return this.currentUser;
    }

    this.init(url);
}