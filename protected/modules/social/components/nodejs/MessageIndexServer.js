var users = {}

var io = require('socket.io').listen(8888);

io.set('log level', 3);

io.sockets.on('connection', function (socket) {
    socket.emit('request_user_id');

    socket.on('response_user_id', function(res) {
        users[res.user_id] = socket.id;
    });

    socket.on('new message', function (res) {
        io.sockets.socket(users[res.to_user_id]).emit('new message', res);
        //socket[res.socket_id].emit('new message', res);
    });

    socket.on('disconnect', function () {});
});