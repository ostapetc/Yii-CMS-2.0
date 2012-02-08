/*!
 * BootTooltip jQuery UI widget file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @see http://twitter.github.com/bootstrap
 */

( function( $ ) {
	"use strict" // set strict mode

	// todo: fix live binder, currently it doesn't work.
	// todo: implement support for transition effects.
	/**
	 * BootTooltip class.
	 * @class jQuery.ui.bootTooltip
	 * @augments jQuery.ui.bootWidget
	 */
	var widget = $.extend( {}, $.ui.bootWidget.prototype, {
		/**
		 * The name of the widget.
		 * @type String
		 */
		name: 'tooltip',
		/**
		 * The value of the tooltip id attribute.
		 * @type String
		 */
		tooltipId: 'tooltip',
		/**
		 * Indicates whether the tooltip is visible.
		 * @type Boolean
		 */
		visible: false,
		/**
		 * Widget options.
		 * - placement: The placement of the tooltip. Valid values are: "top", "right", "bottom" and "left".
		 * - showEvent: The event for showing the tooltip.
		 * - hideEvent: The event for hiding the tooltip.
		 * - offset: Pixel offset of the tooltip.
		 * - live: Indicates whether to use jQuery.live or jQuery.on.
		 * @type Object
		 */
		options: {
			placement: 'top',
			eventIn: 'mouseenter',
			eventOut: 'mouseleave',
			title: '',
			offset: 0,
			live: false
		},
		/**
		 * Creates the widget.
		 * @private
		 */
		_create: function() {
			var self = this,
				title = this.element.attr( 'data-title' ) || this.element.attr( 'title' ) || this.options.title,
				binder = this.options.live ? 'live' : 'on';

			if ( title && title.length > 0 ) {
				this.element.removeAttr( 'title' ); // remove the title to prevent it being displayed
				this.element.attr( 'data-original-title', title );

				this.element[ binder ]( this.options.eventIn, function() {
                    self.show();
                });
				this.element[ binder ]( this.options.eventOut, function() {
                    self.hide();
                });
			}
		},
		/**
		 * Shows the tooltip.
		 */
		show: function() {
			if ( !this.visible ) {
				var tooltip = this._getTooltip(),
					position;

				tooltip.find( '.tooltip-inner' ).html( this.element.attr( 'data-original-title' ) );
				position = this._pos();
				tooltip.css( {
					top: position.top,
					left: position.left
				} ).show();

				this.visible = true;
			}

			return this;
		},
		/**
		 * Hides the tooltip.
		 */
		hide: function() {
			if ( this.visible ) {
				var tooltip = this._getTooltip();
				tooltip.hide();
				this.visible = false;
			}

			return this;
		},
		/**
		 * Toggles the tooltip.
		 */
		toggle: function() {
			if ( this.visible ) {
				this.hide();
			} else {
				this.show();
			}

			return this;
		},
		/**
		 * Calculates the position for the tooltip based on the element.
		 * @return {Object} The offset, an object with "top" and "left" properties.
		 * @private
		 */
		_pos: function() {
			var twipsy = this._getTooltip(),
				element = this.element,
				offset = element.offset(),
				top = 0,
				left = 0;

			switch ( this.options.placement ) {
				case 'top':
					top = offset.top - twipsy.outerHeight() - this.options.offset;
					left = offset.left + ( ( element.outerWidth() - twipsy.outerWidth() ) / 2 );
					break;

				case 'right':
					top = offset.top + ( ( element.outerHeight() - twipsy.outerHeight() ) / 2 );
					left = offset.left + element.outerWidth() - this.options.offset;
					break;

				case 'bottom':
					top = offset.top + element.outerHeight() + this.options.offset;
					left = offset.left + ( ( element.outerWidth() - twipsy.outerWidth() ) / 2 );
					break;

				case 'left':
					top = offset.top + ( ( element.outerHeight() - twipsy.outerHeight() ) / 2 );
					left = offset.left - twipsy.outerWidth() + this.options.offset;
					break;
			}

			return {
				left: left,
				top: top
			};
		},
		/**
		 * Creates the tooltip element and appends it to the body element.
		 * @returns {HTMLElement} The element.
		 * @private
		 */
		_createTooltip: function() {
			var tooltip = $( '<div class="tooltip in">' )
				.attr( 'id', this.tooltipId )
				.addClass( this.options.placement )
				.appendTo( 'body' )
				.hide();

			$( '<div class="tooltip-arrow">' )
				.appendTo( tooltip );

			$( '<div class="tooltip-inner">' )
				.appendTo( tooltip );

			return tooltip;
		},
		/**
		 * Returns the tooltip element from the body element.
		 * The element is created if it doesn't already exist.
		 * @return {HTMLElement} The element.
		 * @private
		 */
		_getTooltip: function() {
			var tooltip = $( '#' + this.tooltipId );

			if ( tooltip.length === 0 ) {
				tooltip = this._createTooltip();
			}

			return tooltip;
		},
		/**
		 * Destroys the widget.
		 * @private
		 */
		_destroy: function() {
			this.element.unbind( this.options.eventIn );
			this.element.unbind( this.options.eventOut );
		}
	} );

	/**
	 * BootTooltip jQuery UI widget.
	 */
	$.widget( 'ui.bootTooltip', widget );

} )( jQuery );