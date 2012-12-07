$(function() {
    $('.modal-link').live('click', function(e) {
        e.preventDefault();

        var action_url = $(this).attr('href');

        if (action_url.indexOf('?') != -1)
        {
            action_url += '&modal=1'
        }
        else
        {
            action_url += '?modal=1'
        }

        $('#modal-window').modal('hide');

        $('body').append(action_url, function() {
            var modal = $('#modal-window').modal({show: true});
        });
    });
});