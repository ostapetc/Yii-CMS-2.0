var users = {}

var io = require('socket.io').listen(8888);

io.set('log level', 3);

io.sockets.on('connection', function (socket) {
    socket.emit('request_user_id');

    socket.on('response_user_id', function(data) {
        if (data.user_id) {
            users[data.user_id] = data.id;
        }
    });

    socket.on('new_message', function (data) {
        if (users[data.to_user_id] != undefined) {
            io.sockets.socket(users[data.to_user_id]).emit('new_message', data);
        }
    });

    socket.on('disconnect', function () {});
});