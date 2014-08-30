var socket = window.socket;

var MessageModel = Backbone.Model.extend({

});

var MessagesCollection = Backbone.Collection.extend({

    initialize: function(models, options) {
        this.id = options.id;
    },

    url: function() {
        console.log(this);
        return '/messages/history/' + this.id;
    },
    model: MessageModel,

    getHistory: function(){
        this.fetch({
            success: this.fetchSuccess,
            error: this.fetchError
        })
    },

    fetchSuccess: function (collection, response) {
        collection.each(function(model){
            var id = model.get('from_user_id');
            if(thisUser.get('id') == id){
                model.set({user_name: thisUser.get('name')})
            } else {
                model.set({user_name: recieverUser.get('name')})
            }
        });
        console.log(collection.models);
    },

    fetchError: function (collection, response) {
        console.log('error');
        console.log(response);
    }
});

var UserModel = Backbone.Model.extend({

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
        this.listenTo(this.collection, 'add', this.renderMessageView);
        //this.collection.on('add', this.render, this)
    },
    send: function(){
        var messageText = this.$el.find('input').val();
        if (messageText.length != 0){
            var message = new MessageModel({user_name: thisUser.get('name'), message: messageText});
            messages.add(message);
            socket.send(JSON.stringify({
                type: 'message',
                data: messageText,
                user: recieverUser.get('user_id')
            }));
        }
    },
    renderMessageView: function(message){
        messageView = new MessageItemView({ model: message });
        this.$el.find('#messages').append(messageView.render().el);
        return this;
    }
});

Backbone.on('socket:message', function(e){
    var data = JSON.parse(e.data.data);
    var btn = $('.send');
    console.log(data.id, btn.attr('data-to'));
    if (btn.attr('data-to') == data.id){
        var message = new MessageModel({user_name: btn.attr('user-name'), message: data.message});
        messages.add(message);
    }
});

var thisUser = new UserModel(thisUser);
var recieverUser = new UserModel(recieverUser);

var messages = new MessagesCollection([], {id: recieverUser.get('user_id')});
messages.getHistory();
console.log(messages);

var message1 = new MessageModel({user_name: 'Alex', message: 'Hello, world!'});
var message2 = new MessageModel({user_name: 'Denis', message: 'Hi!'});

var messagesView = new MessagesView({
    collection: messages,
    el: "#messagesContainer"
});

messages.add(message1);
messages.add(message2);

$(function() {

    $('.nav-tabs a').click(function (e) {
        $(this).tab('show');
    });

});