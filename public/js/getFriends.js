socket = window.socket;

$(function() {
    Backbone.on('socket:open', function(e){
        socket.send(JSON.stringify({
            type: 'getFriends'
        }));
    });

    Backbone.on('socket:friends', function(e){
        var data = JSON.parse(e.data.data);
        var online = data.result.online;
        var offline = data.result.offline;

        var source = $('#userTemplate').html();
        var template = Handlebars.compile(source);

        console.log(data);
        online.forEach(function(user){
            user.online = 'online';
            var html = template(user);
            $("#usersContainer").append(html);
            console.log('online');
        });

        offline.forEach(function(user){
            user.online = 'offline';
            var html = template(user);
            $("#usersContainer").append(html);
            console.log('offline');
        });

    })
});