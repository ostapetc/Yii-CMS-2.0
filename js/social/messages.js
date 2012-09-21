$(function() {
    console.log();

    $('#message-form').submit(function() {
        var params = {
            'Message[text]'       : $.trim($('#Message_text').val().stripTags()),
            'Message[to_user_id]' : $('#Message_to_user_id').val()
        }

        if (params['Message[text]']) {
            $.post('/social/message/create', params, function() {
                $('#Message_to_user_id').val('');
            });
        }

        return false;
    });
});