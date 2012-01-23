(function($)
{
    $.widget('CmsUI.allInOneInput', $.CmsUI.buttonSet, {
        _version:0.1,

        version:function()
        {
            return this._version
        },
        options:{
            divider:';',
            addButtonText:'Добавить возможное значение',

            wrapper:null,
            addButton:null
        },

        _create:function()
        {
            var self = this;
            self.element.hide();

            self.options.wrapper = $('<ul style="float:left" class="all-in-one-input">').sortable({
                stop:function(event, ui)
                {
                    self._serialize()
                }
            });

            self.options.addButton = self._makePlusButton($('<span>'),
                self.options.addButtonText).click(function()
                {
                    self.openDialog();
                });

            self.options.addButton.insertAfter(self.element);
            self.options.wrapper.insertAfter(self.element);

            self.element.val().split(self.options.divider).map(function(o, i)
            {
                if (o.length > 0)
                {
                    return self.add($.trim(o));
                }
            });
        },
        add:function(text)
        {
            var self = this,
                li = self._makeCloseButton($('<li>'), text).click(function()
                {
                    self.remove(this);
                });

            self.options.wrapper.append(li);
            self._serialize();
            return text;
        },
        remove:function(item)
        {
            if (confirm("Удаление одного из возможных значений может повлечь за собой безвозвратную потерю данных, если где либо используется это значение, то оно будет потеряно"))
            {
                $(item).remove();
                this._serialize();
            }
        },
        _serialize:function()
        {
            var arr = new Array;
            this.options.wrapper.find('.ui-button-text').each(function(o, i)
            {
                var text = $(this).text();
                if (text.length > 0)
                {
                    arr.push(text)
                }
            });
            this.element.val(arr.join(this.options.divider));
        },
        openDialog:function()
        {
            var self = this;
            $('<div><input class="text"/></div>').dialog({
                minWidth:'455px',
                width:'455px',
                modal:true,
                title:self.options.addButtonText,
                buttons:{ "Ok":function()
                {
                    self.add($(this).find('input').val());
                    $(this).dialog("close");
                }}
            });
        }
    });
})(jQuery);