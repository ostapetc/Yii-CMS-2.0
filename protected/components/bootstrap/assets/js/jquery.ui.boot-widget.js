/*!
 * Bootstrap Widget jQuery UI widget file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @see http://twitter.github.com/bootstrap
 */

(function($) {
	"use strict" // set strict mode

	/**
	 * BootWidget class.
	 * @class jQuery.ui.bootWidget
	 */
	var widget = {
		/**
		 * The name of the widget.
		 * @type String
		 */
		name: 'widget',
		/**
		 * Destroys the widget.
		 * @private
		 */
		_destroy: function() {
			// Base class does nothing.
		}
	};

	/**
	 * BootWidget jQuery UI widget.
	 * The base widget for all Bootstrap widgets.
	 */
	$.widget( 'ui.bootWidget', widget );

})(jQuery);