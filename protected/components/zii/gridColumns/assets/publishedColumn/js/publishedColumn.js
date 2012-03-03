(function($)
{

    var defaultOptions = {
        html_true: null,
        html_false: null,
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
            $(this).html(value ? options.html_true : options.html_false);
            return false;
        });
    };

})(jQuery);