/**
 *  jQuery Very Simple Context Menu Plugin
 *  @requires jQuery v1.3 or 1.4
 *  http://intekhabrizvi.wordpress.com/
 *
 *  Copyright (c)  Intekhab A Rizvi (intekhabrizvi.wordpress.com)
 *  Licensed under GPL licenses:
 *  http://www.gnu.org/licenses/gpl.html
 *
 *  Version: 1.1
 *  Dated : 28-Jan-2010
 *  Version 1.1 : 2-Feb-2010 : Some Code Improvment
 */

(function($) {
	jQuery.fn.vscontext = function(options) {
		var defaults = {
			menuBlock : null,
			offsetX : 8,
			offsetY : 8,
			speed : 'fast'
		};
		var options = $.extend(defaults, options);
		var menu_item = '#' + options.menuBlock;

		return this.each(function() {
			$(this).bind("contextmenu", function(e) {
				return false;
			});
			$(this).mousedown(function(e) {
				var offsetX = e.pageX + options.offsetX;
				var offsetY = e.pageY + options.offsetY;
				if (e.button == "2") {

					$(menu_item).show(options.speed);
					$(menu_item).css('display', 'block');
					$(menu_item).css('top', offsetY);
					$(menu_item).css('left', offsetX);
				} else {
					//$(menu_item).hide(options.speed);
				}
			});
			$(menu_item).hover(function() {
			}, function() {
				$(menu_item).hide(options.speed);
			})

			$(".module_div").hover(function() {
			}, function() {
				$(menu_item).hide(options.speed);
			})
		});
	};
})(jQuery);
