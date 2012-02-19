$(function()
{
    var $MenuSection_url   = $('#MenuSection_url');
    var $MenuSection_title = $('#MenuSection_title');

    $('#MenuSection_page_id').change(function()
    {
        var page_id = $(this).val();

        if (page_id)
        {
            $MenuSection_url.val('');
            $MenuSection_url.attr('disabled', true);

            $.getJSON('/content/PageAdmin/GetJsonData', {id : page_id}, function(page)
            {
                $MenuSection_title.val(page.title);
            });
        }
        else
        {
            $MenuSection_url.attr('disabled', false);
        }
    });
});
