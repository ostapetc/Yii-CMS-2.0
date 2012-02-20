$.fn.alias = function(options)
{
    var title = $('#' + options.source),
        alias = $(this),
        save_btn = alias.siblings('.save_alias'),
        edit_btn = alias.siblings('.change_alias'),
        preloader = alias.siblings('.alias_preloader');

    title.syncTranslit(options);
    alias.change(function()
    {
        $('#'+alias.attr('id')+'_hidden').val(alias.val());
    });
    edit_btn.click(function()
    {
        $(this).hide();
        save_btn.show().css({display:'inline-block'});
        alias.removeAttr('disabled');
        return false;
    });
    save_btn.click(function(e)
    {
        e.preventDefault();
        var form = $(this).closest('form');
        var settings = form.data('settings');
        var name = alias.attr('name').split('[')[1].split(']')[0];
        $.each(settings.attributes, function(i, attribute)
        {
            if (attribute.name == name)
            {
                this.enableAjaxValidation = true;
                this.status = 3;

            }
        });

        form.data('settings', settings);

        preloader.show().css({display:'inline-block'});
        $.fn.yiiactiveform.validate(form, function(data)
        {

            $.each(settings.attributes, function(i, attribute)
            {
                if (attribute.name == name)
                {
                    var hasError = data != null && $.isArray(data[attribute.id]) && data[attribute.id].length > 0;
                    $.fn.yiiactiveform.updateInput(attribute, data, form);
                    preloader.hide();
                    if (!hasError)
                    {
                        save_btn.hide();
                        edit_btn.show();
                        alias.attr('disabled', 'disabled');
                    }
                }
            });
        });
        return false;
    });

    return $(this);
}