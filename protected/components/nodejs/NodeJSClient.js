socket = io.connect("http://cmf2.ru:8888");

socket.on('request_user_id', function() {
    socket.emit('response_user_id', {user_id : $('#app_user_id').val()});
});

socket.on('new message', function (res) {
    alert(1);
});
