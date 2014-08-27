Message = Backbone.Model.extend({

});

Messages = Backbone.Collection.extend({
    model: Message
});

User = Backbone.Model.extend({
    collection: Messages
});

Users = Backbone.Collection.extend({
    model: User
})

MessagesView = Backbone.View.extend({
    events: {
        "click button": "send"
    },

    render: function() {
        var source = $('#messagesTemplate').html();
        var template = Handlebars.compile(source);
        var html = template(this.collection.toJSON());
        this.$el.html(html);
    },

    initialize: function(){
        this.collection.on('add', this.render, this)
    },
    send: function(){
        console.log(this);
        socket.send(JSON.stringify({
            type: 'message',
            data: this.$el.find('input').val()
        }));
    }
});

UserRouter = Backbone.Router.extend ({
    routes: {
        ':id': 'userLoad'
    },
    userLoad: function (id) {
        socket.send(JSON.stringify({
            type: 'user',
            data: id
        }));
    }
});

var appRouter = new UserRouter();

Backbone.history.start();


try {
    var id = 1;
    if (!WebSocket) {
        console.log("no websocket support");
    } else {
        socket = new WebSocket("ws://127.0.0.1:7778/");
        var id = 1;
        socket.addEventListener("open", function (e) {
            console.log("open: ", e);
        });
        socket.addEventListener("error", function (e) {
            console.log("error: ", e);
        });
        socket.addEventListener("message", function (e) {
            var data = JSON.parse(e.data);
            console.log(data);
            var message = new Message({user_name: data.user.name, message: data.message.data})
            messages.add(message);
        });
        window.socket = socket; // debug
    }
} catch (e) {
    console.log("exception: " + e);
}

var messages = new Messages();

var message1 = new Message({user_name: 'Alex', message: 'Hello, world!'})
var message2 = new Message({user_name: 'Denis', message: 'Hi!'})

var messagesView = new MessagesView({
    collection: messages,
    el: ".messagesContainer"
})

messages.add(message1);
messages.add(message2);
messagesView.render();

$(function() {

    $('.nav-tabs a').click(function (e) {
        $(this).tab('show');
    });

});