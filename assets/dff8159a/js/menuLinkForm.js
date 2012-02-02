$(function()
{
    var $MenuLink_url   = $('#MenuLink_url');
    var $MenuLink_title = $('#MenuLink_title');

    $('#MenuLink_page_id').change(function()
    {
        var page_id = $(this).val();

        if (page_id)
        {
            $MenuLink_url.val('');
            $MenuLink_url.attr('disabled', true);

            $.getJSON('/content/PageAdmin/GetJsonData', {id : page_id}, function(page)
            {
                $MenuLink_title.val(page.title);
            });
        }
        else
        {
            $MenuLink_url.attr('disabled', false);
        }
    });
});
