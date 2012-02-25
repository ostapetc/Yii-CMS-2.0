(function($)
{

    var defaultOptions = {
        icon_true: null,
        icon_false: null,
        title_false: null,
        title_false: null,
        model: null,
        attribute: null
    };

    $.fn.publishedColumn = function(options)
    {
        options = $.extend(defaultOptions, options);
        $(this).delegate('.published_icon', 'click', function()
        {
            var value = $(this).data('value');
            $.post($(this).attr('href'), {
                'id': $(this).data('id'),
                'value': value = value ? 0 : 1,
                'attribute': options.attribute,
                'model': options.model
            });

            $(this).data('value', value);
            $(this).find('img').attr('src', value ? options.icon_true : options.icon_false);
            $(this).attr('title', value ? options.title_true : options.title_false);
            return false;
        });
    };

})(jQuery);