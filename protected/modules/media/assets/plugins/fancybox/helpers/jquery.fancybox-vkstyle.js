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

        },

        onUpdate: function()
        {
            $('.layer-overlay').css({
                height: $(window).height()
            });
        },
        beforeShow: function(opts)
        {
            var overlay = $('.fancybox-overlay').css('overflow-y', 'scroll');

            $('body').css({
                'overflow-y' : 'hidden',
                'margin-right': '15px'
            });

            var layer_margin = $('#layer-margin').length ? $('#layer-margin') : $('<div id="layer-margin">').css('height', '100px');
            $('.fancybox-wrap').prependTo(overlay).append(layer_margin);

            //comments
            var comments_widget = $('#' + opts.comment_widget_id);
            F.current.skin.append(comments_widget.show());
            comments_widget.commentList('bindToLink', F.current.element);
            comments_widget.commentList('setLoading');
            comments_widget.commentList('loadCommentsList');
        },
        beforeClose: function(opts)
        {
            $('body').append($('#' + opts.comment_widget_id).hide());
            $('.fancybox-overlay').css('overflow-y', 'hidden');
        },
        afterClose: function ()
        {
            $('body').css({
                'overflow-y': 'auto',
                'margin-right': '0'
            });
        }
    };

}(jQuery));