(function($)
{
    $.widget('CmsUI.multiAutocomplete', $.CmsUI.buttonSet, {
        _version:0.1,

        version:function()
        {
            return this._version
        },

        // default options
        options:{
            //            label:'-- Select --',
            minWidth:200,
            maxWidth:400,
            scroll:0,
            url:null
            //
        },

        items:[],
        input:{},
        list:{},
        wrapper:{},
        url:null,
        cache:{},

        _create:function()
        {
            var self = this,
                $select = self.element.hide();

            self.wrapper = $('<div class="multiselect-wrapper">').insertAfter($select);
            self.list = $('<div>').appendTo(self.wrapper);
            self.input = $('<input type="text" class="text ui-multiautocomplete-input" />')
                .attr({
                    // workaround to close menu on blur
                    tabIndex:-1
                })
//                .html('<span class="ui-multiselect-label" style="display: inline-block; margin: 2px; padding: 1px;"></span>')
                .appendTo(self.wrapper)
                .autocomplete({
                    delay:0,
                    minLength:0,
                    source:function(request, response)
                    {
                        var term = request.term;
                        if (term in self.cache)
                        {
                            response(self.cache[ term ]);
                            return;
                        }

                        lastXhr = $.getJSON(self.options.url, request, function(data, status, xhr)
                        {
                            self.cache[ term ] = data;
                            if (xhr === lastXhr)
                            {
                                response(data);
                            }
                        });

                    },
                    focus:function()
                    {
                        return false;
                    },
                    select:function(ev, ui)
                    {
                        if ($.inArray(ui.item, self.items) === -1)
                        {
                            self.select(ui.item);
                        }


                        return false;
                    }
                })
                .addClass('ui-widget ui-widget-content ui-corner')
                .css({
                    display:'inline-block',
                    minWidth:self.options.minWidth,
                    maxWidth:self.options.maxWidth || 'auto',
                    padding:1,
                    verticalAlign:'middle'
                })
                .click(function()
                {
                    //self.button.trigger('click');
                });

            self.input.focus(function()
            {
                self.input.autocomplete('search', self.input.val());
            });

            $.each(self.element.children(), function(i, o)
            {
                if (o.selected)
                {
                    self.select({
                        value:$(o).attr('value'),
                        label:$(o).text()
                    });
                }
            });

        }, // _create


        destroy:function()
        {
            this.input.remove();
            this.button.remove();
            this.element.show();
            $.Widget.prototype.destroy.call(this);
        }, // destroy

        select:function(item)
        {
            var self = this;

            self.items.push(item);

            var option;
            if ((option = self.element.find('[value=' + item.value + ']')).length > 0)
            {
                option.attr('selected', 'selected');
            }
            else
            {
                option = $('<option selected="selected"></option>').attr('value',
                    item.value).text(item.label);
                self.element.append(option);
            }

            self._makeCloseButton('<span class="ui-multiselect-item">', item.label)
                .children('.ui-icon-close')
                .click(
                function()
                {
                    $(this).parent().remove();
                    self.deselect(item);
                    return false;
                }).end().appendTo(self.list);

        }, // select
        deselect:function(item)
        {
            var self = this;

            self.element.children('[value=' + item.value + ']').removeAttr('selected');
            self.items.splice($.inArray(item, self.items), 1);

            //                self.cache.push(item);

//            if (!self.input.children('.ui-multiselect-item').length)
//            {
//                self.input.children('.ui-multiselect-label').show();
//            }
        } // deselect

    })
})(jQuery)