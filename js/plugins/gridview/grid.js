(function($)
{
    $.widget('CmsUI.grid', $.CmsUI.gridBase, {
        _version:0.1,

        // default options
        options:{
            mass_removal:false,
            filter_hint:false
        },
        parent:function()
        {
            return $.CmsUI.gridBase.prototype;
        },
        _create:function()
        {
            this.parent()._create.call(this);
        },
        _initHandlers:function(e, data)
        {
            this.parent()._initHandlers.call(this);

            var self = this;
            self._initSwitchPageSize();
            self._initPageSizer();
            self._initSettingsIcon();

            if (self.options.mass_removal)
            {
                self._initMassRemoval();
            }
        },
        _initPageSizer:function()
        {
            if ($('.pager_select').length == 0)
            {
                return;
            }

            var self = this;
            if ($.fn.chosen != undefined)
            {
                $('.pager_select', self.element).chosen({
                    'allow_single_deselect':false
                });
            }
        },
        _initMassRemoval:function()
        {
            var self = this;
            $('#mass_remove_button').click(function()
            {
                var $checkboxes = $('.object_checkbox:checked', self.element);

                if ($checkboxes.length > 0)
                {
                    if (!confirm('Вы уверены, что хотите удалить отмеченные элементы?'))
                    {
                        return false;
                    }

                    blockUI();
                    var grid_id = self.element.attr('id');

                    $checkboxes.each(function()
                    {
                        var action = $(this).closest('tr').find('.delete').attr('href');

                        $.fn.yiiGridView.update(grid_id, {
                            type:'POST',
                            url:action,
                            success:null
                        });
                    });

                    $(document).ajaxStop(function()
                    {
                        unblockUI();
                        $.fn.yiiGridView.update(grid_id);
                        $(this).unbind('ajaxStop');
                    });
                }
                else
                {
                    showMsg('Отметьте элементы!');
                }
            });
        },
        _initSwitchPageSize:function()
        {
            var self = this;
            $('.pager_select', self.element).change(function()
            {
                location.href = '?per_page=' + $(this).val();
            });

        },
        _initSettingsIcon: function() {
            var grid      = this.element.find('table');
            var model_id  = grid.attr('model_id');
            var widget_id = grid.attr('widget_id');

            $('.filters td:last').html('<a href="/main/widgetAdmin/columnsManage/model_id/' + model_id + '/widget_id/' + widget_id + '" class="columns-settings">колонки</a>');
        }
    });
})(jQuery);


