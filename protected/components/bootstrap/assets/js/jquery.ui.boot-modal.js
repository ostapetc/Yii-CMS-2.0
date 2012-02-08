/*!
 * BootModal jQuery UI widget file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @see http://twitter.github.com/bootstrap
 */

( function( $ ) {
	"use strict" // set strict mode

	/**
	 * BootModal class.
	 * @class jQuery.ui.bootModal
	 * @augments jQuery.ui.bootWidget
	 */
	var widget = $.extend( {}, $.ui.bootWidget.prototype, {
		/**
		 * The name of the widget.
		 * @type String
		 */
		name: 'modal',
		/**
		 * The backdrop element.
		 * @type Object
		 */
		backdrop: null,
		/**
		 * Indicates whether this modal is visible.
		 * @type Boolean
		 */
		visible: false,
		/**
		 * Widget options.
		 * - backdropClose: Indicates whether clicking on the backdrop closes the modal.
		 * - buttons: Button configurations.
		 * - closeTime: The duration for closing the modal.
		 * - escapeClose: Indicates whether pressing escape closes the modal.
		 * - open: Indicates whether to open the modal on initialization.
		 * - openTime: The duration for opening the modal.
		 * - title: The modal title text.
		 * @type Object
		 */
		options: {
			backdropClose: false,
			buttons: [],
			closeTime: 350,
			escapeClose: false,
			open: false,
			openTime: 1000,
			title: ''
		},
		/**
		 * Creates the widget.
		 * @private
		 */
		_create: function() {
			var	header = this._createHeader(),
				body = this._createBody(),
				footer = this._createFooter();

			this.element.remove()
				.html( '' );

			header.appendTo( this.element );
			body.appendTo( this.element );
			footer.appendTo( this.element );
			this.element.addClass( 'modal' )
				.hide()
				.appendTo( 'body' );
		},
		/**
		 * Initializes the widget.
		 * @private
		 */
		_init: function() {
			var self = this;

			if ( this.options.open ) {
				this.open();
			}

			if ( this.options.escapeClose ) {
				$( document ).bind( 'keyup.bootModal', function ( event ) {
					if ( event.which === 27 ) {
						self.close();
					}
				})
			}
		},
		/**
		 * Opens the modal.
		 */
		open: function() {
			if ( !this.visible ) {
				var backdrop = this._getBackdrop();
				backdrop.show();
				this.element.fadeIn( this.options.openTime );
				this.visible = true;
			}

			return this;
		},
		/**
		 * Closes the modal.
		 */
		close: function() {
			var self = this;

			if ( this.visible ) {
				this.element.fadeOut( this.options.closeTime, function() {
					var backdrop = self._getBackdrop();
					backdrop.hide();
				});
				this.visible = false;
			}

			return this;
		},
		/**
		 * Creates the modal header element.
		 * @return {Object} The element.
		 * @private
		 */
		_createHeader: function() {
			var header = $( '<div class="modal-header">' );

			$( '<h3>' )
				.html( this.options.title )
				.appendTo( header );

			var closeLink = this._createCloseLink();
			closeLink.prependTo( header );

			return header;
		},
		/**
		 * Creates the modal body element.
		 * @return {Object} The element.
		 * @private
		 */
		_createBody: function() {
			return $( '<div class="modal-body">' )
				.html( this.element.html() );
		},
		/**
		 * Creates the modal footer element.
		 * @return {Object} The element.
		 * @private
		 */
		_createFooter: function() {
			var i, l, config, button,
				footer = $( '<div class="modal-footer">' );

			for ( i = 0, l = this.options.buttons.length; i < l; ++i ) {
				config = this.options.buttons[ i ];
				button = this._createButton( config );
				button.prependTo( footer );
			}

			return footer;
		},
		/**
		 * Creates a button element from the given config array.
		 * @param {Array} config The button config.
		 * @returns {Object} The element.
		 * @private
		 */
		_createButton: function( config ) {
			var button = $( '<button>' ),
				property;

			for ( property in config ) {
				switch ( property ) {
					case 'class':
						button.addClass( config[ property ] );
						break;

					case 'click':
						button.bind( 'click', config[ property ] );
						break;

					case 'label':
						button.html( config[ property ] );
						break;

					default:
				}
			}

			return button;
		},
		/**
		 * Creates a close link for this modal.
		 * @returns {Object} The element.
		 * @private
		 */
		_createCloseLink: function() {
			var self = this;

			return $( '<a class="close" href="#">x</a>' )
				.bind( 'click', function( event ) {
					self.close();
					event.preventDefault();
					return false;
				} );
		},
		/**
		 * Returns the backdrop element creating it if it doesn't exist.
		 * @returns {Object} The element.
		 * @private
		 */
		_getBackdrop: function() {
			var self = this,
				backdrop = $( '.modal-backdrop' );

			if ( backdrop.length === 0 ) {
				backdrop = $( '<div class="modal-backdrop">' )
					.hide()
					.appendTo( 'body' );

				if ( this.options.backdropClose ) {
					backdrop.bind( 'click', function( event ) {
						self.close();
						event.preventDefault();
						return false;
					} );
				}
			}

			return backdrop;
		},
		/**
		 * Destroys the widget.
		 * @private
		 */
		_destroy: function() {
			if ( this.options.escapeClose ) {
				$( document ).unbind( 'keyup.bootModal' );
			}
		}
	} );

	/**
	 * BootModal jQuery UI widget.
	 */
	$.widget( 'ui.bootModal', widget );

} )( jQuery );