var socket = window.socket;

function Chat(socket, mainContainer)
{
    this.ui = {

    };

    this.MessageModel = Backbone.Model.extend({

    });

    this.MessagesCollection = Backbone.Collection.extend({

        initialize: function(models, options) {
            this.id = options.id;
            this.thisUser = options.thisUser;
            this.recieverUser = options.recieverUser;
        },

        url: function() {
            return '/messages/history/' + this.id;
        },
        model: this.MessageModel,

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

    this.UserModel = Backbone.Model.extend({

    });

    this.UsersCollection = Backbone.Collection.extend({
        model: this.UserModel
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
            console.log(this);


            this.MessageItemView = Backbone.View.extend({
                render: function() {
                    var source = $('#message-template').html();
                    var html = _.template(source, {model: this.model.toJSON()});
                    this.$el.html(html);
                    return this;
                }
            });

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
                    data: {
                        data: messageText,
                        user_id: this.collection.recieverUser.get('user_id')
                    }
                }));
            }
        },
        renderMessageView: function(message){
            console.log(this);
            var messageView = new this.MessageItemView({ model: message });
            this.$el.find('#messages').append(messageView.render().el);
            return this;
        }
    });

    this.init = function(socket, mainContainer){
        Backbone.on('socket:message', function(e){
            var data = e.data;
            var btn = $('.send');
            console.log(data.id, btn.attr('data-to'));
            if (btn.attr('data-to') == data.id){
                var message = new MessageModel({user_name: btn.attr('user-name'), message: data.message});
                messages.add(message);
            }
        });

        var thisUser = new this.UserModel(window.thisUser);
        var recieverUser = new this.UserModel(window.recieverUser);

        var messages = new this.MessagesCollection([], {
            id: recieverUser.get('user_id'),
            thisUser: thisUser,
            recieverUser: recieverUser
        });

        messages.getHistory();
        //console.log(messages);

        var messagesView = new this.MessagesView({
            collection: messages,
            el: "#messagesContainer"
        });
    }

    this.init(socket, mainContainer);
}

$(function() {

    var chat = new Chat(window.socket, '');

    $('.nav-tabs a').click(function (e) {
        $(this).tab('show');
    });

});