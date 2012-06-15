$(function() {
    $('.show-modal-link').live('click', function() {
        var action_url = $(this).attr('href');
        var modal_id   = $(this).data('modal-id');
        var modal      = $('#' + modal_id).modal({show : false}) ;

        modal.modal('show');

        if (action_url.indexOf('?') != -1) {
            action_url += '&popup=1'
        }
        else {
            action_url += '?popup=1'
        }

        $.get(action_url, function(html) {
            modal.find('.modal-body').html(html);
        });

        return false;
    });
});