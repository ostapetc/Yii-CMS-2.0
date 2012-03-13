var clientOptimizer = {
    init: function () {
        clientOptimizer.lazyLoad(0);
    },
    lazyLoad: function (element, delay) {
        if (element.hasClass('loaded')) {
            return;
        }

        /*distance to document top*/
        var distY = element.offset().top;
        /*real distance to scroll top*/
        var distReal = distY - $(window).scrollTop();
        /*check if element is withing viewport*/
        if (distReal > $(window).height()) {
            /*write image an erro fallback*/
            var imgDiv = element.children('.lazy-load-wrapper');
            imgDiv.html('<img style="display:none" onload="clientOptimizer.lazyloadShow($(this));" onerror="clientOptimizer.onError($(this));")')
            .attr('width', element.data('width')).attr('height', element.data('height')).attr('src',element.data('src'));
        }
    },
    lazyloadShow: function (el) {
        el.closest('.lazy-load').addClass('loaded');
        el.parent().show();
        el.fadeIn();
    },
    triggerLoad: function (delay) {
        $('.lazyImage').each(function () {
            clientOptimizer.lazyLoad($(this), delay);
        });
    }
};


$(window).scroll(function () {
    clientOptimizer.triggerLoad(500);
});

