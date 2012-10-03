$.widget('cmsUI.fileupload', $.blueimpUI.fileupload, {

    options: {
        version: '1.0',
        existFilesUrl: '',
        autoUpload: true,
        prependFiles: true,
        previewFileTypes: /^$/,
        previewAsCanvas: false,
        uploadTemplate: function(o)
        {
            return $.tmpl($('#template-upload'), o.files);
        },
        downloadTemplate: function(o)
        {
            if (o.files)
            {
                for (var i in o.files)
                {
                    if (!o.files[i].preview)
                    {
                        continue;
                    }
                    if (o.files[i].preview.type == 'iframe')
                    {
                        o.files[i].preview = '<iframe src="' + o.files[i].preview.val + '" width="100%"></iframe>';
                    }
                    else if (o.files[i].preview.type == 'img')
                    {
                        o.files[i].preview = '<img src="' + o.files[i].preview.val + '" width="100%"></img>';
                    }
                }
            }
            return $.tmpl($('#template-download'), o.files);
        }
    },
    _create: function()
    {
        $.blueimpUI.fileupload.prototype._create.call(this); //base constructor
        //no inherited css styles
        $('body')
//            .append(this.element)
            .append('#'+this.options.uploadTemplateId)
            .append('#'+this.options.downloadTemplateId);


        this._loadExistingFiles();
        this._sortableInit();
        this._jeditableInit();
        this._adaptationToBrowser();
    },
    _renderExtendedProgress: function(data)
    {
        return this._formatBitrate(data.bitrate) + ' | ' +
            this._formatTime(
                (data.total - data.loaded) * 8 / data.bitrate
            )
    },
    _loadExistingFiles: function()
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
    _sortableInit: function()
    {
        var widget = this;
        this.element.find('.files tbody').sortable({
            handle: '.dnd-handler',
            placeholder: 'placeholder',
            start: function(event, ui)
            {
                ui.placeholder.html("<td colspan='100%'>&nbsp;</td>");
                ui.placeholder.css('height', ui.item.height());
            },
            update: function(event, ui)
            {
                $.post(widget.options.sortableSaveUrl, $(this).sortable('serialize'));
            }
        });

    },
    _jeditableInit: function()
    {
        this.element.delegate('.editable', 'click', function()
        {
            var self = $(this);
            if (self.data('editable'))
            {
                return false;
            }
            self.data('editable', true);
            var action = self.data('save-url'),
                options = {
                    submitdata: {'attr': self.data('attr')},
                    name: self.data('attr'),
                    type: self.data('editable-type'),
                    rows: 3,
                    //                    cols:16,
                    width: '220px',
                    onblur: 'ignore',
                    submit: '<i class="icon-ok-btn"></i>',
                    cancel: '<i class="icon-cancel-btn"></i>',
                    indicator: '<i class="icon-loader"></i>',
                    placeholder: 'Кликните для редактирования'
                    //                    callback:function()
                    //                    {
                    //                        self.addClass('editable');
                    //                    }
                };

            self.children('span').editable(action, options).click();
            return false;
        });
        this.element.delegate('form', 'submit', function()
        {
            return false;
        });
    },
    _adaptationToBrowser: function()
    {
        //if browser not support dnd
        if (!Modernizr.draganddrop)
        {
            this.element.find('.drop-zone').remove();
        }
    }
});
