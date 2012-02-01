(function($)
{
    /**
     * Этот плагин берет на себя работу по синхронизации с плагином Yii,
     * а так же предоставляет простой API для реализации на его основе своих плагинов
     *
     * Плагин изначально вызывает метод _initHandlers
     * используйте его для инициализации своих скриптов
     * После ajaxUpdate(метод yiiGridView) этот метод будет вызван повторно,
     * поэтому нет необходимости использовать live или delegate
     *
     * На одну таблицу можо вешать неограниченное количество плагинов основанных на CmsUI.gridBase
     * Но, т.к. мы зависим от yiiGridView, то инициализация этих плагинов, должна произойти
     * после инициализации yiiGridView
     * Т.е. если вы хотите проинициализировать плагин из какой-либо колонки,
     * то для этого в компоненте GridView предусмотренно событие onRegisterScript.
     * В методе init колонки, используйте $this->grid->onRegisterScript = array($this, 'registerScript');
     * и в методе registerScript вашего класса регистрируйте любые скрипты.
     */
    $.widget('CmsUI.gridBase', {
        _version:0.1,

        version:function()
        {
            return this._version
        },

        // default options
        options:{
        },
        _create:function()
        {
            var self = this,
                id = self.element.attr('id');

            var func = self.element.yiiGridView.settings[id].afterAjaxUpdate;
            self.element.yiiGridView.settings[id].afterAjaxUpdate = function(id, data)
            {
                if (func != undefined)
                {
                    func(id, data);
                }
                self.element = $('#' + id); //because yiiGridView make replaceWith on our element
                self._initHandlers();
            };
            self._initHandlers();
        },
        _initHandlers:function()  //there run functions for initialize some event handlers
        {
        },
        update:function()
        {
            var self = this,
                id = self.element.attr('id');
            $.fn.yiiGridView.update(id);
        },


        //default settings for plugins
        //default options for sortable
        defaultSortable:{
            axis:"y",
            revert:true,
            cursor:"pointer",
            items:'tr',
            delay:100,
            distance:5,
            opacity:0.8,
            handle:".positioner",
            forcePlaceholderSize:true,
            forceHelperSize:true,
            helper:function(e, ui)
            {
                ui.children().each(function()
                {
                    $(this).width($(this).width());
                });
                return ui;
            },
            tolerance:"pointer",
            placeholder:'placeholder',
            //            helper:'clone',
            start:function(event, ui)
            {
                ui.placeholder.html("<td colspan='100%'>&nbsp;</td>");
                ui.placeholder.css('height', ui.item.height());
            }
        },

        defaultJeditable:{
            indicator:'<img src=\'/images/admin/ajax-loader.gif\'>',
            tooltip:'Клик для редактирования...',
            event:'click',
            style:'inherit',
            width:'50px'
        }
    });
})(jQuery);


