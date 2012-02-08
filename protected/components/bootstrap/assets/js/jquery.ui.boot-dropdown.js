/*!
 * BootDropdown jQuery UI widget file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @see http://twitter.github.com/bootstrap
 */

( function( $ ) {
	"use strict" // set strict mode

	/**
	 * BootDropdown class.
	 * @class jQuery.ui.bootDropdown
	 * @augments jQuery.ui.bootWidget
	 */
	var widget = $.extend( {}, $.ui.bootWidget.prototype, {
		/**
		 * The name of the widget.
		 * @type String
		 */
		name: 'dropdown',
		/**
		 * Widget options.
		 * - trigger: Trigger type. Valid values are 'click' and 'hover', default to 'click'.
		 * - open: Whether to open the dropdown by default.
		 * @type Object
		 */
		options: {
			trigger: 'click',
			open: false
		},
		/**
		 * Creates the widget.
		 */
		_create: function() {
			var self = this,
				parent = this.element.parent(),
				dropdown = parent.find( '.dropdown-menu' ),
				items = parent.find( '.dropdown-menu > li' );

			if (!this.options.open) {
				self.close();
			}

			if ( this.options.trigger === 'click' ) {
				this.element.toggle( function() {
					self.open();
				}, function() {
					self.close();
				} );
			} else {
				this.element.on( 'mouseenter', function() {
					self.open();
				} );

				dropdown.on( 'mouseleave', function() {
					self.close();
				} );
			}

			items.on( 'click', function() {
				self.close();
			} );
		},
		/**
		 * Opens the dropdown menu.
		 */
		open: function() {
			var dropdown = this.element.parent();
			dropdown.addClass( 'open' );

			return this;
		},
		/**
		 * Closes the dropdown menu.
		 */
		close: function() {
			var dropdown = this.element.parent();
			dropdown.removeClass( 'open' );

			return this;
		}
	} );

	/**
	 * BootDropdown jQuery UI widget.
	 */
	$.widget( 'ui.bootDropdown', widget );

} )( jQuery );