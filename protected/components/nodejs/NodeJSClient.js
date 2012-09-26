socket = io.connect("' . $params['nodejs']['ip'] . ':' . $params['nodejs']['port'] . '");
alert(1);
socket.on('request_user_id', function() {
    socket.emit('response_user_id', {user_id : $('#app_user_id').val()});
});

socket.on('new message', function (res) {
    alert(1);
});
