/*!
 * BootAlert jQuery UI widget file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @see http://twitter.github.com/bootstrap
 */

( function( $ ) {
	"use strict" // set strict mode

	/**
	 * BootAlert class.
	 * @class jQuery.ui.bootAlert
	 * @augments jQuery.ui.bootWidget
	 */
	var widget = $.extend( {}, $.ui.bootWidget.prototype, {
		/**
		 * The name of the widget.
		 * @type String
		 */
		name: 'alert',
		/**
		 * Widget options.
		 * - keys: The valid alert types.
		 * - template: The HTML template for displaying alerts.
		 * - displayTime: The time to display each alert.
		 * - closeTime: The duration for closing each alert.
		 * @type Object
		 */
		options: {
			keys: [],
			template: '',
			displayTime: 5000,
			closeTime: 350
		},
		/**
		 * Creates the widget.
		 * @private
		 */
		_create: function() {
			var alerts = this.element.find( '.alert' );

			for ( var i = 0, l = alerts.length; i < l; ++i ) {
				var alert = $( alerts[ i ] );
				this._initAlert( alert );
			}
		},
		/**
		 * Creates a new alert message.
		 * @param {String} key The message type, e.g. 'success'.
		 * @param {String} message The message.
		 */
		alert: function( key, message ) {
			if ( this.options.keys.indexOf( key ) !== -1 ) {
				var template = this.options.template;

				template = template.replace( '{key}', key );
				template = template.replace( '{message}', message );

				var alert = $( template );
				this._initAlert( alert );
				alert.appendTo( this.element );
			}

			return this;
		},
		/**
		 * Initializes the alert by appending the close link
		 * and by setting a time out for the close callback.
		 * @param {Object} alert The alert element.
		 * @private
		 */
		_initAlert: function( alert ) {
			var self = this;

			alert.find( '.close' ).on( 'click', function( event ) {
				self.close( alert );
				event.preventDefault();
				return false;
			} );

			if ( this.options.displayTime > 0 ) {
				setTimeout( function() {
					self.close( alert );
				}, this.options.displayTime );
			}
		},
		/**
		 * Closes a specific alert message.
		 * @param {Object} alert The alert element.
		 */
		close: function( alert ) {
			if ( alert ) {
				alert.fadeOut( this.options.closeTime, function() {
					$( this ).html( '' );
				});
			}

			return this;
		}
	} );

	/**
	 * BootAlert jQuery UI widget.
	 */
	$.widget( 'ui.bootAlert', widget );

} )( jQuery );