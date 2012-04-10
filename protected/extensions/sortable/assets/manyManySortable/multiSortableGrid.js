(function($)
{
    $.widget('CmsUI.multiSortableGrid', $.CmsUI.gridBase, {
        _version:0.1,

        // default options
        options:{
            id:null,
            cat_id:null,
            url:null,
            model:null,

            menuBlock:null,
            offsetX:8,
            offsetY:8,
            speed:'fast'
        },
        parent:function()
        {
            return $.CmsUI.gridBase.prototype;
        },
        _create:function()
        {
            this.parent()._create.call(this);
        },
        _initHandlers:function()
        {
            this.parent()._initHandlers.call(this);

            this._initSortable();
        },
        _initSortable:function()
        {
            var self = this;

            $('tbody.sc', self.element).sortable($.extend(self.defaultSortable, {
                connectWith:"tbody.pct",
                update:function(event, ui)
                {
                    if ($(ui.item).parent('.pct').length)
                    {
                        return true;
                    }

                    var prev = -1,
                        curr = -1,
                        next = -1,
                        nextItem = $(ui.item).next(),
                        prevItem = $(ui.item).prev();

                    if (prevItem.length && prevItem.children(".pk").length)
                    {
                        prev = prevItem.children(".pk").attr('id').split('_')[1];
                    }
                    curr = $(".pk", ui.item).attr('id').split('_')[1];
                    if (nextItem.length && nextItem.children(".pk").length)
                    {
                        next = nextItem.children(".pk").attr('id').split('_')[1];
                    }

                    if (curr == -1)
                    {
                        return true;
                    }
                    $.post(self.options.url, {
                        el:prev + "." + curr + "." + next,
                        model:self.options.model,
                        cat_id:self.options.cat_id
                    });
                }
            })).disableSelection();

            $('tbody.pct', self.element).sortable($.extend(self.defaultSortable, {
                connectWith:"tbody.sc",
                receive:function(event, ui)
                {
                    $("#pct_empty").hide();
                    $.post(self.options.url, {
                        in_pocket:$(".pk", ui.item).attr('id').split('_')[1],
                        model:self.options.model,
                        cat_id:self.options.cat_id
                    });
                },
                remove:function(event, ui)
                {
                    if ($('.pct .pk', $(ui.item).parent().parent()).length == 0)
                    {
                        $("#pct_empty").show();
                    }
                }
            })).disableSelection();
        }
    });
})
    (jQuery);
