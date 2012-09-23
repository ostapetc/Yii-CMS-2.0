$(function () {
    var to_user_id = $('#Message_to_user_id').val();
    var content    = $('#simple-content');

    var socket = io.connect('127.0.0.1:8888');
    socket.on('connect', function () {});
    socket.on('new message', function (res) {
        $('.items').append(res.view);
    });

    $('#message-form').submit(function() {
        var params = {
            'Message[text]'       : $.trim($('#Message_text').val().stripTags()),
            'Message[to_user_id]' : to_user_id
        }

        if (params['Message[text]']) {
            $.post('/social/message/create', params, function(view) {
                $('.items').append(view);
                $('#Message_to_user_id').val('');
                socket.emit('new message', { 'view' : view });
            });
        }

        return false;
    });
});