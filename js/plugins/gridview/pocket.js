(function($)
{
    $.widget('CmsUI.pocket', $.CmsUI.gridBase, {
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

        }
    });
})
    (jQuery);
