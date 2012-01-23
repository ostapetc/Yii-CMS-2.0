$.widget('cmsUI.crop', {
    options: {
        version : '1.0'
    },
    _create: function() {
        this._jCropInit();
        
    },
    _jCropInit: function() {
        this.element.Jcrop(this.options.jCrop);
    }

});
