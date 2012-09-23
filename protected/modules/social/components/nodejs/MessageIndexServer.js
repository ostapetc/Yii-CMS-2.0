var io = require('socket.io').listen(8888);

io.set('log level', 3);

io.sockets.on('connection', function (socket) {
    socket.on('new message', function (res) {
        socket.broadcast.emit('new message', res);
    });

    socket.on('disconnect', function () {});
});