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

        $.get(action_url, function(html) {
            //html = html.replace('<script type="text/javascript" src="/assets/cefaa72/jquery.js"></script>', '');
            //alert(html);
            $('body').append(html);
            var modal = $('#modal-window').modal({show: true});
        });
    });

    $('#modal-window .close').live('click', function() {
        $('#modal-window').modal('hide').remove();
    });
});