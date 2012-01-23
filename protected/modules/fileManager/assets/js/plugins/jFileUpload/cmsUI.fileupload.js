$.widget('cmsUI.fileupload', $.blueimpUI.fileupload, {
    options:{
        version:'1.0',
        existFilesUrl:''
    },
    _create:function()
    {
        $.blueimpUI.fileupload.prototype._create.call(this); //base constructor

        this._loadExistingFiles();
        this._sortableInit();
        this._jeditableInit();
        this._adaptationToBrowser();

        // Open download dialogs via iframes,
        // to prevent  aborting current uploads:
        //        uploader.find('.files a:not([target^=_blank])').live('click', function (e) {
        //            e.preventDefault();
        //            $(\"<iframe style='display:none;'></iframe>\")
        //                .attr('src', this.href)
        //                .appendTo('body');
        //        });
    },
    _loadExistingFiles:function()
    {
        var widget = this;

        $.getJSON(this.options.existFilesUrl, {}, function(files)
        {
            widget._adjustMaxNumberOfFiles(-files.length);
            widget._renderDownload(files)
                .appendTo(widget.element.find('.files'))
                .fadeIn(500, function()
                {
                    // Fix for IE7 and lower:
                    $(this).show();
                });
        });
    },
    _sortableInit:function()
    {
        var widget = this;
        this.element.find('.files tbody').sortable({
            handle:'.dnd-handler',
            update:function(event, ui)
            {
                $.post(widget.options.sortableSaveUrl, $(this).sortable('serialize'));
            }
        });

    },
    _jeditableInit:function()
    {
        this.element.delegate('.editable', 'click', function()
        {
            var self = $(this),
                action = self.data('save-url'),
                options = {
                    name:self.data('attr'),
                    type:self.data('editable-type'),
                    rows:3,
                    cols:20,
                    onblur:'ignore',
                    submit:'<img src="/images/admin/ok_16.png" />',
                    cancel:'<img src="/images/admin/cancel_16.png" />',
                    indicator:'<img src="/images/admin/ajax-loader.gif" />',
                    placeholder:'Кликните для редактирования'
//                    callback:function()
//                    {
//                        self.addClass('editable');
//                    }
                };

            self.children('span').editable(action, options).click();
            return false;
        });
    },
    _adaptationToBrowser:function()
    {
        //if browser not support dnd
        if (!Modernizr.draganddrop)
        {
            this.element.find('.drop-zone').remove();
        }
    }
});
