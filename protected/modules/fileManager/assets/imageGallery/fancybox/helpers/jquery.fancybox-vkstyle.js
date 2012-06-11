/*!
 * Vk style gallery
 * version: 1.0.0
 * @requires fancyBox v2.0 or later
 * @autor Alexey Sharov
 */
(function($)
{
    //Shortcut for fancyBox object
    var F = $.fancybox;

    //Add helper object
    F.helpers.vkstyle = {
        init: function(opts)
        {
            var that = this;

//            for (var n = 0; n < F.group.length; n++)
//            {
//                list += '<li><a style="width:' + thumbWidth + 'px;height:' + thumbHeight + 'px;" href="javascript:jQuery.fancybox.jumpto(' + n + ');"></a></li>';
//            }
//            $.each(F.group, function(i)
//            {
//                $("<img />").load(function()
//                {
//                    var width = this.width,
//                        height = this.height,
//                        widthRatio, heightRatio, parent;
//
//                    if (!that.list || !width || !height)
//                    {
//                        return;
//                    }
//
//                    widthRatio = width / thumbWidth;
//                    heightRatio = height / thumbHeight;
//                    parent = that.list.children().eq(i).find('a');
//
//                    if (widthRatio >= 1 && heightRatio >= 1)
//                    {
//                        if (widthRatio > heightRatio)
//                        {
//                            width = Math.floor(width / heightRatio);
//                            height = thumbHeight;

//                        }
//                        else
//                        {
//                            width = thumbWidth;
//                            height = Math.floor(height / widthRatio);
//                        }
//                    }
//
//                    $(this).css({
//                        width: width,
//                        height: height,
//                        top: Math.floor(thumbHeight / 2 - height / 2),
//                        left: Math.floor(thumbWidth / 2 - width / 2)
//                    });
//
//                    parent.width(thumbWidth).height(thumbHeight);
//
//                    $(this).hide().appendTo(parent).fadeIn(300);
//
//                }).attr('src', thumbSource(F.group[ i ]));
//            });
//
//            this.width = this.list.children().eq(0).outerWidth(true);
//
//            this.list.width(this.width * (F.group.length + 1)).css('left',
//                Math.floor($(window).width() * 0.5 - (F.current.index * this.width + this.width * 0.5)));
        },

        onUpdate: function()
        {
            $('.layer-overlay').css({
                height: $(window).height()
            });
        },
        beforeShow: function(opts)
        {
            alert(F.current);
            var overlay = $('.layer-overlay').length ? $('.layer-overlay') : $('<div class=\"layer-overlay\">').css({
                height: $(window).height()
            }).appendTo('body');
            $('body').css('overflow', 'hidden');

            var layer_margin = $('#layer-margin').length ? $('#layer-margin') : $('<div id="layer-margin">').css('height',
                '100px');
            $('.fancybox-wrap').prependTo(overlay).append(layer_margin);

            var widget = opts.additionalWidget;
            if (widget)
            {
                $('.fancybox-skin').append($('<br/>'));
                $('.fancybox-skin').append($('#' + widget));
                $('.fancybox-skin').append($('<br/>'));
            }
        },
        afterClose: function()
        {
            $('body').css('overflow', 'auto');
            $('.layer-overlay').hide();
        }
    };

}(jQuery));