/**
 * Created by JetBrains PhpStorm.
 * User: Alex
 * Date: 04.12.11
 * Time: 12:37
 * To change this template use File | Settings | File Templates.
 */

(function($)
{
    $.widget('CmsUI.buttonSet', {
        _version:0.1,

        version:function()
        {
            return this._version
        },
        options:{
            buttonSettings:{},
            buttonStyle:{
                cursor:'pointer',
                margin:2
            },
            buttonTextStyle:{
                lineHeight:'normal',
                paddingTop:0,
                paddingBottom:0,
                paddingLeft:'.5em'
            }
        },
        _makeButton:function(element, label, buttonSettings)
        {
            this.options.buttonSettings.label = $.trim(label);
            this.options.buttonSettings = $.extend(this.options.buttonSettings, buttonSettings);
            return $(element)
                .button(this.options.buttonSettings)
                .css(this.options.buttonStyle)
                .children('.ui-button-text')
                .css(this.options.buttonTextStyle)
                .end();
        },
        _makeCloseButton:function(element, label)
        {
            this.options.buttonSettings = {
                icons:{ secondary:'ui-icon-close' }
            };
            return this._makeButton(element, label);
        },
        _makePlusButton:function(element, label)
        {
            this.options.buttonSettings = {
                icons:{ primary:'ui-icon-plus' }
            };
            this.options.buttonTextStyle.paddingLeft = '24px';

            return this._makeButton(element, label);
        }
    })
})(jQuery)