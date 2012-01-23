$.widget('cmsUIBase.singleFileUpload', $.blueimpUI.fileupload, {

    img:undefined,
    options:{
        version:'1.0',
        existFilesUrl:''
    },
    _create:function()
    {
        this.element.data('fileupload', this);  //using in base class
        $.blueimpUI.fileupload.prototype._create.call(this); //base constructor

        // Open download dialogs via iframes,
        // to prevent  aborting current uploads:
        //        uploader.find('.files a:not([target^=_blank])').live('click', function (e) {
        //            e.preventDefault();
        //            $(\"<iframe style='display:none;'></iframe>\")
        //                .attr('src', this.href)
        //                .appendTo('body');
        //        });
    },

    done:function(data)
    {
        this.render(data.result);
    },
    render:function(data)
    {
        var html = this._renderDownload(data),
            table = this.element.find('.files').html(html.show());

        this.img = html.find('img:first').attr('width', this.options.cropImageWidth);

        this.initOtherPlugins();
        this._buttonsInit(html);

        return table;
    },

    toolbarShowLoading:function()
    {
        this._getLoadingPanel().show();
    },
    toolbarHideLoading:function()
    {
        this._getLoadingPanel().hide();
    },
    beforeToolbarButtonClick:function()
    {
        this.toolbarShowLoading();
    },
    afterToolbarButtonClick:function()
    {
        this.toolbarHideLoading();
    },
    _getLoadingPanel:function()
    {
        return this.element.find('.toolbar:first').children('.loading:first');
    },
    _buttonsInit:function(tmpl)
    {
    },
    _initEventHandlers:function()
    {
        $.blueimpUI.fileupload.prototype._initEventHandlers.call(this);
    },

    _toolbarButtonClick:function(button)
    {
        var widget = this;
        return function(e) {
            e.preventDefault();
            widget.beforeToolbarButtonClick();
            
            button.handler.call(widget, e, button.params, widget.afterToolbarButtonClick);
        }
    },
    _loadExistingFiles:function()
    {

        var widget = this;

        $.getJSON(
            this.options.existFilesUrl,
            {},
            function(files)
            {
                widget._adjustMaxNumberOfFiles(-files.length);
                widget.render(files);
            }
        );
    }
});
