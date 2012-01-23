$(document).ready(function()
{
    $('.back_button').click(function()
    {
        location.href = $(this).attr('url');
    });

    $('.hint').each(function()
    {
        var self = $(this),
            label = self.siblings('label:first'),
            a = $('<a class="hint" href="#">')
                .aToolTip({
                    clickIt:true,
                    tipContent:self.html()
                });

        self.hide();
        self.replaceWith(a);
    });

    $('.chosen select').chosen({
        no_results_text:"Выберите один из вариантов",
        allow_single_deselect:true
    });

    /**
     * Help to add validation to new field in form, ex: add field by ajax.
     * You need write: $.fn.yiiactiveform.addFields($(form), $(fields)), and ajax validation stay working
     * It function exclude repeats
     *
     * Эта функция добавляет валидацию для новых полей в форме. Например: добавление с помощью ajax
     * Вам нужно написать: $.fn.yiiactiveform.addFields($(form), $(fields)), и ajax-валидация начнет работать
     * Эта функция исключает повторы
     */
    if ($.fn.yiiactiveform)
    {
        $.fn.yiiactiveform.addFields = function(form, fields)
        {
            var $s = form.data('settings');
            if ($s != undefined)
            {
                fields.each(function()
                {
                    var $field = $(this), has = false;
                    $.each($s.attributes, function(i, o)
                    {
                        if (o.id == $field.attr('id'))
                        {
                            has = true;
                            return false;
                        }
                    });

                    if (!has)
                    {
                        $s.attributes[$s.attributes.length] = $.extend({
                            validationDelay:$s.validationDelay,
                            validateOnChange:$s.validateOnChange,
                            validateOnType:$s.validateOnType,
                            hideErrorMessage:$s.hideErrorMessage,
                            inputContainer:$s.inputContainer,
                            errorCssClass:$s.errorCssClass,
                            successCssClass:$s.successCssClass,
                            beforeValidateAttribute:$s.beforeValidateAttribute,
                            afterValidateAttribute:$s.afterValidateAttribute,
                            validatingCssClass:$s.validatingCssClass
                        }, {
                            id:$field.attr('id'),
                            inputID:$field.attr('id'),
                            errorID:$field.attr('id') + '_em_',
                            model:$field.attr('name').split('[')[0],
                            name:$field.attr('name'),
                            enableAjaxValidation:true,
                            status:1,
                            value:$field.val()
                        });
                        form.data('settings', $s);
                    }
                });
            }
        }
    }

});
