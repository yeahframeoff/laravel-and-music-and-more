var app;

function Chat(socket, mainContainer)
{
    this.collections = {};
    this.models = {};
    this.views = {};
    this.thisUser = {};
    this.activeUser = {};

    this.ui = {
        sendButton: '.send',
        messagesContainer: '#messages-container',
        usersContainer: '#users-main-container'
    };

    this.MessageModel = Backbone.Model.extend({
        idAttribute: '_id'
    });

    this.MessagesCollection = Backbone.Collection.extend({

        url: function() {
            return '/messages/history/' + app.activeUser.get('id');
        },
        model: this.MessageModel,

        getHistory: function(){
            app.collections.messages.reset();
            this.fetch({
                error: this.fetchError
            })
        },

        fetchError: function (collection, response) {
            console.log('error');
            console.log(response);
        }
    });

    this.UserModel = Backbone.Model.extend({
        idAttribute: 'id'
    });

    this.UsersCollection = Backbone.Collection.extend({
        model: this.UserModel,

        getUsers: function(){
            app.socket.send(JSON.stringify({
                type: 'getFriends',
                data: ''
            }));
        }
    });

    this.UserItemView = Backbone.View.extend({
        events: {
            "click": "userSelect"
        },

        render: function() {
            var source = $('#user-template').html();
            var html = _.template(source, {model: this.model.toJSON()});
            this.$el.html(html);
            return this;
        },

        userSelect: function() {
            app.activeUser = this.model;
            app.collections.messages.getHistory();
            var messagesView = new app.MessagesView({
                collection: app.collections.messages,
                el: app.ui.messagesContainer
            });
        }
    });

    this.UsersView = Backbone.View.extend({
        render: function() {
            this.collection.each(function(user){
                this.renderUserView(user)
            }, this);
            return this;
        },

        initialize: function(){
            this.listenTo(this.collection, 'add', app.renderUserView);
        },

        renderUserView: function(user){
            var userView = new app.UserItemView({model: user});
            this.$el.find('#users-container').append(userView.render().el);
            return this;
        }
    });

    this.MessageItemView = Backbone.View.extend({

        initialize: function(){
            this.model.on('change', this.render, this);
        },

        render: function() {
            var from_user_id = this.model.get("from_user_id");
            //?????????????????
            var author = (from_user_id == app.thisUser.get('id')) ? app.thisUser : app.collections.users.get(from_user_id);
            var source = $('#message-template').html();
            var html = _.template(source, {
                model: this.model.toJSON(),
                author: author.toJSON()
            });
            this.$el.html(html);
            return this;
        }
    });

    this.MessagesView = Backbone.View.extend({
        events: {
            "click button": "send",
            "keypress input": "send"
        },

        render: function() {
            this.collection.each(function(person){
                this.renderMessageView(person)
            }, this);
            return this; // returning this for chaining..
        },

        initialize: function(){
            this.listenTo(this.collection, 'add', this.renderMessageView);
        },
        send: function(e){
            if( e.which != 13 )
                return;
            var messageText = this.$el.find('input').val();
            this.$el.find('input').val('');
            if (messageText.length != 0){
                var message = new app.MessageModel({
                    from_user_id: app.thisUser.get('id'),
                    to_user_id: app.activeUser.get('id'),
                    message: messageText
                });
                app.collections.messages.add(message);
                socket.send(JSON.stringify({
                    type: 'message',
                    data: message.toJSON(),
                    cid: message.cid
                }));
            }
        },
        renderMessageView: function(message){
            var messageView = new app.MessageItemView({
                model: message
            });
            this.$el.find('#messages').append(messageView.render().el);
            return this;
        }
    });

    this.init = function(socket, mainContainer){
        app = this;

        var usersCollection = new this.UsersCollection();
        var messages = new this.MessagesCollection();

        app.socket = socket;
        app.collections.users = usersCollection;
        app.collections.messages = messages;

        usersCollection.getUsers();

        Backbone.on('socket:currentUser', function(e){
            var data = e.data;
            app.thisUser = new app.UserModel(data);
        });

        Backbone.on('socket:friends', function(e){
            var data = e.data;
            var online = data.result.online;
            var offline = data.result.offline;
            var friends = online.concat(offline);
            friends.forEach( function(friend){
                var friendModel = new app.UserModel(friend);
                usersCollection.add(friendModel);
            });
            var usersView = new app.UsersView({
                collection: usersCollection,
                el: app.ui.usersContainer
            });
            usersView.render();
        })

        Backbone.on('socket:message', function(e){
            var data = e.data;
            if(data.cid != undefined){
                var message = app.collections.messages.get(data.cid);
                message.set('id', data.id);
            } else {
                var message = new app.MessageModel(data);
                app.collections.messages.add(message);
            }
        });
    }

    this.init(socket, mainContainer);
}

var socket = new SocketConnection('localhost:7778');
$(function() {

    var chat = new Chat(socket.getSocket('localhost:7778'), '');

    $('.nav-tabs a').click(function (e) {
        e.preventDefault();
    });

});