$(document).ready(function()
{
    var urlField = $('#MenuSection_url'),
        urlInfoField = $('#MenuSection_url_info');

    var change = function()
    {
        if ($(this).val())
        {
            urlField.val('').attr('disabled', true);
        }
        else
        {
            urlField.attr('disabled', false);
        }
    };
    change.call(urlInfoField);
    urlInfoField.change(change);
});