var autobahn = new ab;

var connection = new autobahn.Connection({
        url: 'ws://localhost:7779',
        realm: 'realm1'
});

connection.onopen = function (session) {
    var received = 0;
    function onevent1(args) {
        console.log("Got event:", args[0]);
        received += 1;
        if (received > 5) {
            console.log("Closing ..");
            connection.close();
        }
    }
    session.subscribe('com.myapp.topic1', onevent1);
};
connection.open();