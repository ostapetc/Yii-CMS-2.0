/*!
 * BootTabbed jQuery UI widget file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @see http://twitter.github.com/bootstrap
 */

( function( $ ) {
	"use strict" // set strict mode

	/**
	 * BootTabbed class.
	 * @class jQuery.ui.bootTabbed
	 * @augments jQuery.ui.bootWidget
	 */
	var widget = $.extend( {}, $.ui.bootWidget.prototype, {
		/**
		 * The name of the widget.
		 * @type String
		 */
		name: 'tabs',
		/**
		 * Widget options.
		 * @type Object
		 */
		options: {
		},
		/**
		 * Creates the widget.
		 * @private
		 */
		_create: function() {
            var self = this,
                title = this.element.attr( 'data-title' ) || this.element.attr( 'title' );

            this.element.on('click', function( event ) {
                self._tab( event );
            });
		},
		/**
		 * Activates or de-activates a single tab.
		 * @param {HTMLElement} element The element.
		 * @param {HTMLElement} container The container.
		 * @private
		 */
        _activate: function( element, container ) {
            container.find( '> .active' )
				.removeClass( 'active' )
				.find( '> .dropdown-menu > .active' )
				.removeClass( 'active' );

            element.addClass( 'active' );

            if ( element.parent( '.dropdown-menu' ) ) {
                element.closest( 'li.dropdown' ).addClass( 'active' );
            }
        },
		/**
		 * Activates a specific tab.
		 * @param {Event} event The click event.
		 * @private
		 */
        _tab: function( event ) {
            var ul = this.element.closest( 'ul:not(.dropdown-menu)' ),
                href = this.element.attr( 'href' ),
                previous, pane;

            if ( /^#\w+/.test( href ) ) {
                event.preventDefault();

                if ( !this.element.parent( 'li' ).hasClass( 'active' ) ) {
                    previous = ul.find( '.active a' ).last()[ 0 ];
                    pane = $( href );

                    this._activate( this.element.parent( 'li' ), ul );
                    this._activate( pane, pane.parent() );

                    this.element.trigger( {
                        type: 'change',
                        relatedTarget: previous
                    } );
                }
            }
        }
	} );

	/**
	 * BootTabbed jQuery UI widget.
	 */
	$.widget( 'ui.bootTabbed', widget );

} )( jQuery );