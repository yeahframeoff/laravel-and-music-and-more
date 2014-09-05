var socket = window.socket;

$.getScript("/public/js/models.js", function() {

    Backbone.on('socket:message', function(e){
        var data = JSON.parse(e.data.data);
        var btn = $('.send');
        console.log(data.id, btn.attr('data-to'));
        if (btn.attr('data-to') == data.id){
            var message = new MessageModel({user_name: btn.attr('user-name'), message: data.message});
            messages.add(message);
        }
    });

    var thisUser = new UserModel(window.thisUser);
    var recieverUser = new UserModel(window.recieverUser);

    var messages = new MessagesCollection([], {
        id: recieverUser.get('user_id'),
        thisUser: thisUser,
        recieverUser: recieverUser
    });

    messages.getHistory();
    //console.log(messages);

    var messagesView = new MessagesView({
        collection: messages,
        el: "#messagesContainer"
    });
});


$(function() {

    $('.nav-tabs a').click(function (e) {
        $(this).tab('show');
    });

});