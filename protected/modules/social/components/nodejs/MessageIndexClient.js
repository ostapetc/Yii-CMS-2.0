$(function () {
    var $messages_list = $('.messages-list');
    var to_user_id     = $('#Message_to_user_id').val();
    var content        = $('#simple-content');

    $messages_list.scrollTop($messages_list.prop('scrollHeight'));

    var socket = io.connect('127.0.0.1:8888');

    socket.on('request_user_id', function() {
        socket.emit('response_user_id', {user_id : $('#app_user_id').val()});
    });

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

        $.post('/social/message/create', params, function(res) {
            appendListAndScroll(res.view);
            $('#Message_text').val('');

            socket.emit('new message', {
                'view'         : res.view,
                'to_user_id'   : res.to_user_id,
                'from_user_id' : res.from_user_id
            });

            $submit.removeClass('sending').val('Отправить');

        }, 'json');


        return false;
    });

    function appendListAndScroll(view) {
        if ($messages_list.find('.message-tbl').length) {
            $messages_list.append(view);
            $messages_list.animate({ scrollTop: $messages_list.prop('scrollHeight') }, 'fast');
        }
        else {
            $messages_list.html(view);
        }
    }
});