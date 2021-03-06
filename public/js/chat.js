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
        idAttribute: 'id'
    });

    this.MessagesCollection = Backbone.Collection.extend({

        url: function() {
            return '/messages/history/' + app.activeUser.get('id');
        },
        model: this.MessageModel,

        getHistory: function(){
            app.collections.messages.reset();
            this.fetch({
                success: this.fetchSuccess,
                error: this.fetchError
            })
        },

        fetchSuccess: function(collection, response) {
            console.log('fetch success');
            console.log(collection.length);
            if(collection.length == 0){
                console.log('in if');
                $(app.ui.messagesContainer).find('#messages').html('History is empty');
            }
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

        initialize: function(){
            this.model.on('change', this.render, this);
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
            var user_name = app.activeUser.get('first_name') + ' ' + app.activeUser.get('last_name');
            $(app.ui.messagesContainer).find('#active-user').html("<h3>Chat with user " + user_name + "</h3>");
            $(app.ui.messagesContainer).find('#messages').html('Loading history...');
            if (app.views.messagesView == undefined){
                app.views.messagesView = new app.MessagesView({
                    collection: app.collections.messages,
                    el: app.ui.messagesContainer
                });
            }
            else
                app.views.messagesView.render();
        }
    });

    this.UsersView = Backbone.View.extend({
        render: function() {
            this.$el.find('#users-container').html('');
            this.collection.each(function(user){
                this.renderUserView(user)
            }, this);
            return this;
        },

        initialize: function(){
            this.$el.find('#users-container').html('');
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
                author: author.toJSON(),
                thisUser: app.thisUser.toJSON()
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
            this.$el.find('#messages').html('');
            this.collection.each(function(person){
                this.renderMessageView(person)
            }, this);
            return this; // returning this for chaining..
        },

        initialize: function(){
            this.$el.find('#messages').html('');
            console.log('init messages view');
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
                    id: message.cid
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

        Backbone.on('socket:currentUser', function(e){
            var data = e.data;
            app.thisUser = new app.UserModel(data);
        });

        Backbone.on('socket:friends', function(e){
            console.log('friends');
            var data = e.data;
            console.log(data);
            var friends = data.result;
            friends.forEach( function(friend){
                var friendModel = new app.UserModel(friend);
                app.collections.users.add(friendModel);
            });
            var usersView = new app.UsersView({
                collection: app.collections.users,
                el: app.ui.usersContainer
            });
            usersView.render();

            var AppRouter = Backbone.Router.extend({
                routes: {
                    "user/:id": "selectUser"
                }
            });

            var appRouter = new AppRouter;
            appRouter.on('route:selectUser', function(id){
                app.activeUser = app.collections.users.get(id);
                app.collections.messages.getHistory();
                var user_name = app.activeUser.get('first_name') + ' ' + app.activeUser.get('last_name');
                $(app.ui.messagesContainer).find('#active-user').html("<h3>Chat with user " + user_name + "</h3>");
                $(app.ui.messagesContainer).find('#messages').html('Loading history...');
                app.views.messagesView = new app.MessagesView({
                    collection: app.collections.messages,
                    el: app.ui.messagesContainer
                });
            });

            Backbone.history.start();

        })

        Backbone.on('socket:message', function(e){
            var data = e.data;
            var id = e.id;
            if(id != undefined){
                var message = app.collections.messages.get(id);
                message.set('id', data.id);
            } else {
                var message = new app.MessageModel(data);
                app.collections.messages.add(message);
            }
        });

        Backbone.on('socket:onlineNow', function(e){
            var id = e.id;
            var user = app.collections.users.get(id);
            user.set('isOnline', true);
        });

        Backbone.on('socket:offlineNow', function(e){
            var id = e.id;
            var user = app.collections.users.get(id);
            user.set('isOnline', false);
        });

        Backbone.on('socket:open', function(e){
            app.socket = socket;
            app.collections.users = new app.UsersCollection();
            app.collections.messages = new app.MessagesCollection();

            $(app.ui.usersContainer).find('#users-container').html('loading friends...');
            app.collections.users.getUsers();
        });
    }

    this.init(socket, mainContainer);
}

$(function() {

    var socket = new SocketConnection('localhost:7778');
    var chat = new Chat(socket.getSocket('localhost:7778'), '');

    $('.nav-tabs a').click(function (e) {
        e.preventDefault();
    });

});