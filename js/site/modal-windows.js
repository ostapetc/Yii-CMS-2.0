$(function()
{
    $('.modal-link').live('click', function()
    {
        var action_url = $(this).attr('href');
        var modal_id = $(this).data('modal-id') ? (this).data('modal-id') : 'modal-window';
        var title = $(this).data('title');
        var modal = $('#' + modal_id).modal({show: false});

        modal.find('h3').html(title);
        modal.modal('show');

        if (action_url.indexOf('?') != -1)
        {
            action_url += '&modal=1'
        }
        else
        {
            action_url += '?modal=1'
        }

        $.get(action_url, function(html)
        {
            modal.find('.modal-body').html(html);
        });

        return false;
    });
});