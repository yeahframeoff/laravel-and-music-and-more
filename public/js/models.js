var MessageModel = Backbone.Model.extend({

});

var MessagesCollection = Backbone.Collection.extend({

    initialize: function(models, options) {
        this.id = options.id;
        this.thisUser = options.thisUser;
        this.recieverUser = options.recieverUser;
    },

    url: function() {
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
            if(collection.thisUser.get('id') == id){
                model.set({user_name: collection.thisUser.get('name')})
            } else {
                model.set({user_name: collection.recieverUser.get('name')})
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
        "click button": "send",
        "keypress input": "send"
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
    send: function(e){
        if( e.which != 13 )
            return;
        var messageText = this.$el.find('input').val();
        this.$el.find('input').val('');
        if (messageText.length != 0){
            var message = new MessageModel({user_name: this.collection.thisUser.get('name'), message: messageText});
            this.collection.add(message);
            socket.send(JSON.stringify({
                type: 'message',
                data: messageText,
                user: this.collection.recieverUser.get('user_id')
            }));
        }
    },
    renderMessageView: function(message){
        messageView = new MessageItemView({ model: message });
        this.$el.find('#messages').append(messageView.render().el);
        return this;
    }
});