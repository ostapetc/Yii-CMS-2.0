$(function () {
    var $messages_list = $('.messages-list');
    var to_user_id     = $('#Message_to_user_id').val();
    var content        = $('#simple-content');

    $messages_list.scrollTop($messages_list.prop('scrollHeight'));

    var socket = io.connect('127.0.0.1:8888');
    socket.on('connect', function () {});
    socket.on('new message', function (res) {
        appendListAndScroll(res.view);
    });

    $('#message-form').submit(function() {
        var $submit = $(this).find('input[type="submit"]');
        var message = $.trim($('#Message_text').val().stripTags());

        if ($submit.hasClass('sending') || !message.length) {
            return false;
        }

        $submit.addClass('sending').val('Отправляем...');

        var params = {
            'Message[text]'       : message,
            'Message[to_user_id]' : to_user_id
        }

        if (params['Message[text]']) {
            $.post('/social/message/create', params, function(view) {
                appendListAndScroll(view);

                $('#Message_text').val('');
                socket.emit('new message', { 'view' : view });

                $submit.removeClass('sending').val('Отправить');
            });
        }

        return false;
    });

    function appendListAndScroll(view) {
        $messages_list.append(view);
        $messages_list.animate({ scrollTop: $messages_list.prop('scrollHeight') }, 'fast');
    }
});