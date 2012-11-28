var io = require('socket.io').listen(8888);

io.set('log level', 3);

io.sockets.on('connection', function (socket) {
    socket.on('evv', function (data) {
        socket.emit('evv', data);
        socket.broadcast.emit('evv', data);
    });

    socket.on('disconnect', function () {

    });
});