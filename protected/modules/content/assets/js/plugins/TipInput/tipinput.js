(function($)
{
    $.fn.tipInput = function()
    {
        var text = $(this).val();
        $(this)
            .blur(function()
            {
                if ($(this).val() == '')
                {
                    $(this).val(text);
                }
            })
            .focus(function()
            {
                if ($(this).val() == text)
                {
                    $(this).val('');
                }
            });
    };
})(jQuery);