var io = require('socket.io').listen(8888);

io.set('log level', 3);

var simple = io
  .sockets
  .on('connection', function(socket) {
        socket.emit('message', { my: 'data' });

    socket.on('message', function(data) {
      socket.broadcast.send(data);
    });
    socket.on('disconnect', function() {
      // handle disconnect
    });
  });