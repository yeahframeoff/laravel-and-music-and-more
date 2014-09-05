try {
    var id = 1;
    if (!WebSocket) {
        console.log("no websocket support");
    } else {
        socket = new WebSocket("ws://localhost:7778/");
        var id = 1;
        socket.addEventListener("open", function (e) {
            Backbone.trigger("socket:open", {socket: e});
        });
        socket.addEventListener("error", function (e) {
            console.log(e);
            Backbone.trigger("socket:error", {socket: e});
        });
        socket.addEventListener("message", function (e) {
            var type = JSON.parse(e.data).type;
            Backbone.trigger("socket:" + type, {data: e});
        });
        window.socket = socket; // debug
    }
} catch (e) {
    console.log("exception: " + e);
}