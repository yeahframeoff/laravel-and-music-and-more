var socket = window.socket;

var MessageModel = Backbone.Model.extend({

});

var MessagesCollection = Backbone.Collection.extend({
    model: MessageModel
});

var UserModel = Backbone.Model.extend({
    collection: MessagesCollection
});

var UsersCollection = Backbone.Collection.extend({
    model: UserModel
})

var MessageItemView = Backbone.View.extend({
    render: function() {
        var source = $('#messageTemplate').html();
        var template = Handlebars.compile(source);
        var html = template(this.model.toJSON());
        this.$el.html(html);
        return this;
    }
})

var MessagesView = Backbone.View.extend({
    events: {
        "click button": "send"
    },

    render: function() {
        this.collection.each(function(person){
            this.renderMessageView(person);
        }, this);
        return this; // returning this for chaining..
    },

    initialize: function(){
        //this.collection.on('add', this.render, this)
    },
    send: function(){
        console.log(this);
        socket.send(JSON.stringify({
            type: 'message',
            data: this.$el.find('input').val()
        }));
    },
    renderMessageView: function(message){
        messageView = new MessageItemView({ model: message });
        this.$el.find('#messages').append(messageView.render().el);
        return this;
    }
});

var messages = new MessagesCollection();

var message1 = new MessageModel({user_name: 'Alex', message: 'Hello, world!'})
var message2 = new MessageModel({user_name: 'Denis', message: 'Hi!'})

var messagesView = new MessagesView({
    collection: messages,
    el: "#messagesContainer"
})

messages.add(message1);
messages.add(message2);
messagesView.render();

$(function() {

    $('.nav-tabs a').click(function (e) {
        $(this).tab('show');
    });

});