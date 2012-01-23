(function($)
{
    $.fn.tipClear = function()
    {
        var elements = $(this).find('input[type=text], textarea');
        elements.each(function()
        {
            var el = $(this), text = el.data('label');
            if (el.val() == text)
            {
                el.val('');
            }
        });
    };

    $.fn.tipInput = function()
    {
        var form = $(this), elements = form.find('input[type=text], textarea');
        elements.each(function()
        {
            var el = $(this), text = el.data('label');

            if (el.val().length == 0)
            {
                el.val(text).addClass('has-hint');
            }

            el.blur(
                function()
                {
                    if (el.val() == '')
                    {
                        el.val(text).addClass('has-hint');
                    }
                }).focus(function()
                {
                    if (el.val() == text)
                    {
                        el.val('').removeClass('has-hint');
                    }
                });

        });
        form.submit(function()
        {
            form.tipClear();
        });
    };
})(jQuery);