$.widget('cmsUI.singleFileUpload', $.cmsUIBase.singleFileUpload, {
    
    coords:{
        x:0, y:0,
        x2:0, y2:0,
        w:0, h:0
    },
    options:{
        version:'1.0',
        cropOptions:{},
        cropImageWidth:400,
        cropUrl:''
    },
    _create:function() {
        $.cmsUIBase.singleFileUpload.prototype._create.call(this); //base constructor
    },

    crop:function(e, params, callback)
    {
        var widget = this;

        $.post(
            widget.options.cropUrl,
            {
                coords:widget.coords,
                previewWidth:widget.options.cropImageWidth
            },
            function(data)
            {
                var table = widget.render(data);
                table.find('img').attr('width', widget.options.cropImageWidth);

                callback.call(widget);
            },
            'json'
        );
    },
    setWatermark:function(e, params, callback)
    {

    },
    rotate:function(e, params, callback)
    {

    },
    saveCoords:function(coords)
    {
        this.coords = coords;
    },
    initOtherPlugins:function(html, img)
    {
        this._jCropInit(img);
    },
    _getToolbar:function() {
        return [
            {
                selector:'.crop',
                handler:this.crop,
                params:{},
                icon:'ui-icon-scissors'
            },
            {
                selector:'.lt',
                handler:this.setWatermark,
                params: {position:'lt'},
                icon: 'ui-icon-arrowthick-1-nw'
            },
            {
                selector:'.rt',
                handler:this.setWatermark,
                params: {position:'rt'},
                icon: 'ui-icon-arrowthick-1-ne'
            },
            {
                selector:'.lb',
                handler:this.setWatermark,
                params: {position:'lb'},
                icon: 'ui-icon-arrowthick-1-sw'
            },
            {
                selector:'.rb',
                handler:this.setWatermark,
                params: {position:'rb'},
                icon: 'ui-icon-arrowthick-1-se'
            },
            {
                selector:'.center',
                handler:this.setWatermark,
                params: {position:'center'},
                icon: 'ui-icon-bullet'
            },
            {
                selector:'.rotate-r',
                handler: this.rotate,
                params: {side:'right'},
                icon: 'ui-icon-arrowreturnthick-1-w'
            },
            {
                selector:'.rotate-l',
                handler: this.rotate,
                params: {side:'left'},
                icon: 'ui-icon-arrowreturnthick-1-e'
            }
        ]
    },
    _buttonsInit: function(tmpl)
    {
        var toolbar = this._getToolbar(),
            wrapper = tmpl.find('.toolbar:first'),
            widget = this;
        for (var i in toolbar)
        {
            var button = toolbar[i];
            wrapper.find(button.selector+':first').button({
                text  : false,
                icons : {primary : button.icon}
            }).click(widget._toolbarButtonClick(button));
        }
    },

    _jCropInit:function()
    {
        var widget = this;

        this.img.Jcrop({
            onSelect:function(coords)
            {
                widget.saveCoords(coords);
            }
        });
    }
});
