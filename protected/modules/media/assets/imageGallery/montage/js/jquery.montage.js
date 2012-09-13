/**
 * jQuery Montage plugin
 * http://www.codrops.com/
 *
 * Copyright 2011, Pedro Botelho
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 *
 * Date: Tue Aug 30 2011
 */
(function( window, $, undefined ) {
	
	/*
	* Array.max, Array.min 
	* @John Resig
	* http://ejohn.org/blog/fast-javascript-maxmin/
	*/
	
	// function to get the Max value in array
    Array.max 					= function( array ){
        return Math.max.apply( Math, array );
    };

    // function to get the Min value in array
    Array.min 					= function( array ){
       return Math.min.apply( Math, array );
    };
	
	/*
	* smartresize: debounced resize event for jQuery
	*
	* latest version and complete README available on Github:
	* https://github.com/louisremi/jquery.smartresize.js
	*
	* Copyright 2011 @louis_remi
	* Licensed under the MIT license.
	*/

	var $event = $.event, resizeTimeout;

	$event.special.smartresize 	= {
		setup: function() {
			$(this).bind( "resize", $event.special.smartresize.handler );
		},
		teardown: function() {
			$(this).unbind( "resize", $event.special.smartresize.handler );
		},
		handler: function( event, execAsap ) {
			// Save the context
			var context = this,
				args 	= arguments;

			// set correct event type
			event.type = "smartresize";

			if ( resizeTimeout ) { clearTimeout( resizeTimeout ); }
			resizeTimeout = setTimeout(function() {
				jQuery.event.handle.apply( context, args );
			}, execAsap === "execAsap"? 0 : 50 );
		}
	};

	$.fn.smartresize 			= function( fn ) {
		return fn ? this.bind( "smartresize", fn ) : this.trigger( "smartresize", ["execAsap"] );
	};
	
	// ======================= imagesLoaded Plugin ===============================
	// https://github.com/desandro/imagesloaded

	// $('#my-container').imagesLoaded(myFunction)
	// execute a callback when all images have loaded.
	// needed because .load() doesn't work on cached images

	// callback function gets image collection as argument
	//  `this` is the container

	// original: mit license. paul irish. 2010.
	// contributors: Oren Solomianik, David DeSandro, Yiannis Chatzikonstantinou

	$.fn.imagesLoaded 			= function( callback ) {
		var $images = this.find('img'),
			len 	= $images.length,
			_this 	= this,
			blank 	= 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==';

		function triggerCallback() {
			callback.call( _this, $images );
		}

		function imgLoaded() {
			if ( --len <= 0 && this.src !== blank ){
				setTimeout( triggerCallback );
				$images.unbind( 'load error', imgLoaded );
			}
		}

		if ( !len ) {
		    triggerCallback();
		}

		$images.bind( 'load error',  imgLoaded ).each( function() {
		    // cached images don't fire load sometimes, so we reset src.
		    if (this.complete || this.complete === undefined){
				var src = this.src;
				// webkit hack from http://groups.google.com/group/jquery-dev/browse_thread/thread/eee6ab7b2da50e1f
				// data uri bypasses webkit log warning (thx doug jones)
				this.src = blank;
				this.src = src;
		    }
		});

		return this;
	};	
	
	$.Montage 					= function( options, element ) {
		this.element 	= $( element ).show();
		this.cache		= {};
		this.heights	= new Array();
		this._create( options );
	};
	
	$.Montage.defaults 			= {
		liquid					: true, // if you use percentages (or no width at all) for the container's width, then set this to true
										// this will set the body's overflow-y to scroll ( fix for the scrollbar's width problem ) 
		margin					: 1,	// space between images.
		minw					: 70,	// the minimum width that a picture should have.
		minh					: 20,	// the minimum height that a picture should have.
		maxh					: 250,	// the maximum height that a picture should have.
		alternateHeight			: false,// alternate the height value for every row. If true this has priority over defaults.fixedHeight.
		alternateHeightRange	: {		// the height will be a random value between min and max.
			min	: 100,
			max	: 300
		},
		fixedHeight				: null,	// if the value is set this has priority over defaults.minsize. All images will have this height.
		minsize					: false,// minw,minh are irrelevant. Chosen height is the minimum one available.
		fillLastRow				: false	// if true, there will be no gaps in the container. The last image will fill any white space available
    };
	
	$.Montage.prototype 		= {
		_getImageWidth		: function( $img, h ) {
			var i_w	= $img.width(),	i_h	= $img.height(), r_i = i_h / i_w;
			return Math.ceil( h / r_i );
		},
		_getImageHeight		: function( $img, w ) {
			var i_w = $img.width(), i_h = $img.height(), r_i = i_h / i_w;
			return Math.ceil( r_i * w );
		},
		_chooseHeight		: function() {
			// get the minimum height
			if( this.options.minsize ) {
				return Array.min( this.heights );
			}
			// otherwise get the most repeated heights. From those choose the minimum.
			var result 	= {}, 
				max 	= 0, 
				res, val, min;
				
			for( var i = 0, total = this.heights.length; i < total; ++i ) {
				var val	= this.heights[i], inc = ( result[val] || 0 ) + 1;
				
				if( val < this.options.minh || val > this.options.maxh ) continue;
				
				result[val] = inc;
				
				if( inc >= max ) { 
					max = inc; res = val;
				}
			}
			for (var i in result) {
				if (result[i] === max) {
					val = i;
					min = min || val;
					
					if(min < this.options.minh)
						min = null;
					else if (min > val)
						min = val;
					if(min === null) 
						min = val;
				}
			}
			if(min === undefined) min = this.heights[0];
			
			res = min;
			
			return res;
		},
		_stretchImage		: function( $img ) {
			var prevWrapper_w	= $img.parent().width(),
				new_w 			= prevWrapper_w + this.cache.space_w_left,
				crop 			= {
					x 	: new_w,
					y	: this.theHeight
				};
			
			var new_image_w		= $img.width() + this.cache.space_w_left,
				new_image_h		= this._getImageHeight( $img, new_image_w );
			
			this._cropImage( $img, new_image_w, new_image_h, crop );
			this.cache.space_w_left = this.cache.container_w;
			// if this.options.alternateHeight is true, change row / change height
			if( this.options.alternateHeight)	
				this.theHeight			= Math.floor( Math.random()*( this.options.alternateHeightRange.max - this.options.alternateHeightRange.min + 1 ) + this.options.alternateHeightRange.min );		
		},
		_updatePrevImage	: function( $nextimg ) {
			var $prevImage 		= this.element.find('img.montage:last');
			
			this._stretchImage( $prevImage );
			
			this._insertImage( $nextimg );
		},
		_insertImage		: function( $img ) {
			// width the image should have with height = this.theHeight.
			var new_w = this._getImageWidth( $img, this.theHeight );
			
			// use the minimum height available if this.options.minsize = true.
			if( this.options.minsize && !this.options.alternateHeight ) {
				if( this.cache.space_w_left <= this.options.margin * 2 ) {
					this._updatePrevImage( $img );
				}
				else {
					if( new_w > this.cache.space_w_left ) {
						var crop = { x : this.cache.space_w_left, y : this.theHeight };
						this._cropImage( $img, new_w, this.theHeight, crop );
						this.cache.space_w_left = this.cache.container_w;
						$img.addClass('montage');
					}	
					else {
						var crop = { x 	: new_w, y : this.theHeight };
						this._cropImage( $img, new_w, this.theHeight, crop );
						this.cache.space_w_left -= new_w;
						$img.addClass('montage');
					}
				}	
			}
			else {
				// the width is lower than the minimum width allowed.
				if( new_w < this.options.minw ) {
					// the minimum width allowed is higher than the space left to fill the row.
					// need to resize the previous (last) item in that row.
					if( this.options.minw > this.cache.space_w_left ) {
						this._updatePrevImage( $img );
					} 
					else {
						var new_w = this.options.minw, new_h = this._getImageHeight( $img, new_w ), crop = { x : new_w, y : this.theHeight };
						this._cropImage( $img, new_w, new_h, crop );
						this.cache.space_w_left -= new_w;
						$img.addClass('montage');
					}
				}
				else {
					// the new width is higher than the space left but the space left is lower than the minimum width allowed.
					// need to resize the previous (last) item in that row.
					if( new_w > this.cache.space_w_left && this.cache.space_w_left < this.options.minw ) {
						this._updatePrevImage( $img );
					}	
					else if( new_w > this.cache.space_w_left && this.cache.space_w_left >= this.options.minw ) {
						var crop = {x : this.cache.space_w_left, y : this.theHeight};
						this._cropImage( $img, new_w, this.theHeight, crop );
						this.cache.space_w_left = this.cache.container_w;
						// if this.options.alternateHeight is true, change row / change height
						if( this.options.alternateHeight)
							this.theHeight	= Math.floor( Math.random()*( this.options.alternateHeightRange.max - this.options.alternateHeightRange.min + 1 ) + this.options.alternateHeightRange.min );
						$img.addClass('montage');
					}	
					else {
						var crop = { x : new_w, y : this.theHeight};
						this._cropImage( $img, new_w, this.theHeight, crop );
						this.cache.space_w_left -= new_w;
						$img.addClass('montage');
					}	
				}
			}
		},
		_cropImage			: function( $img, w, h, cropParam ) {
			// margin value
			var dec = this.options.margin * 2;
			
			var $wrapper	= $img.parent('a');
			
			// resize the image
			this._resizeImage( $img, w, h );
			
			// adjust the top / left values to slice the image without loosing the its ratio
			$img.css({
				left	: - ( w - cropParam.x ) / 2 + 'px',
				top		: - ( h - cropParam.y ) / 2 + 'px'
			});	
			
			// wrap the image in a <a> element
			$wrapper.addClass('am-wrapper').css({
				width	: cropParam.x - dec + 'px',
				height	: cropParam.y + 'px',
				margin  : this.options.margin
			});
		},
		_resizeImage		: function( $img, w, h ) {
			$img.css( { width : w + 'px', height : h + 'px' } );
		},
		_reload				: function() {
			// container's width
			var new_el_w = this.element.width();
			
			// if different, something changed...
			if( new_el_w !== this.cache.container_w ) {
				this.element.hide();
				this.cache.container_w		= new_el_w;
				this.cache.space_w_left 	= new_el_w;
				var instance 				= this;
				instance.$imgs.removeClass('montage').each( function(i) {
					instance._insertImage( $(this) );
				});
				if( instance.options.fillLastRow && instance.cache.space_w_left !== instance.cache.container_w ) {
					instance._stretchImage( instance.$imgs.eq( instance.totalImages - 1 ) );
				}	
				instance.element.show();
			}
		},
		_create 			: function( options ) {
			this.options 	= $.extend( true, {}, $.Montage.defaults, options );
			
			var instance 		= this,
				el_w 			= instance.element.width();
			
			instance.$imgs		= instance.element.find('img');
			instance.totalImages= instance.$imgs.length;
			
			// solve the scrollbar width problem.
			if( instance.options.liquid )
				$('html').css( 'overflow-y', 'scroll' );
			
			// save the heights of all images.
			if( !instance.options.fixedHeight ) {
				instance.$imgs.each( function(i) {
					var $img	= $(this), img_w = $img.width();
					
					// if images have width > instance.options.minw then "resize" image.
					if( img_w < instance.options.minw && !instance.options.minsize ) {
						var new_h = instance._getImageHeight( $img, instance.options.minw );
						instance.heights.push( new_h );
					}
					else {
						instance.heights.push( $img.height() );
					}	
				});
			}
			
			// calculate which height to use for each image.
			instance.theHeight			= ( !instance.options.fixedHeight && !instance.options.alternateHeight ) ? instance._chooseHeight() : instance.options.fixedHeight;
			
			if( instance.options.alternateHeight )
				instance.theHeight		= Math.floor( Math.random() * ( instance.options.alternateHeightRange.max - instance.options.alternateHeightRange.min + 1 ) + instance.options.alternateHeightRange.min );
				
			// save some values.
			instance.cache.container_w	= el_w;
			// space left to fill the row.
			instance.cache.space_w_left = el_w;
			
			// wrap the images with the right sizes.
			instance.$imgs.each( function(i) {
				instance._insertImage( $(this) );
			});
			
			if( instance.options.fillLastRow && instance.cache.space_w_left !== instance.cache.container_w ) {
				instance._stretchImage( instance.$imgs.eq( instance.totalImages - 1 ) );
			}
			
			// window resize event : reload the container.
			$(window).bind('smartresize.montage', function() { 
				instance._reload();
			});
		},
		add					: function( $images, callback ) {
			// adds one or more images to the container
			var $images_stripped	= $images.find('img');
			this.$imgs 		= this.$imgs.add( $images_stripped );
			this.totalImages= this.$imgs.length;
			this._add( $images, callback );
		},
		_add				: function( $images, callback ) {
			var instance	= this;
			$images.find('img').each( function(i) {
				instance._insertImage( $(this) );
			});
			
			if( instance.options.fillLastRow && instance.cache.space_w_left !== instance.cache.container_w )
				instance._stretchImage( instance.$imgs.eq( instance.totalImages - 1 ) );
			
			if ( callback ) callback.call( $images );
		},
		destroy				: function( callback ) {
			this._destroy( callback );
		},
		_destroy 			: function( callback ) {
			this.$imgs.removeClass('montage').css({
				position	: '',
				width		: '',
				height		: '',
				left		: '',
				top			: ''
			}).unwrap();
			
			if( this.options.liquid )
				$('html').css( 'overflow', '' );
			
			this.element.unbind('.montage').removeData('montage');

			$(window).unbind('.montage');
			
			if ( callback ) callback.call();
		},
		option				: function( key, value ) {
			// set options AFTER initialization:
			if ( $.isPlainObject( key ) ){
				this.options = $.extend( true, this.options, key );
			} 
		}
	};
	
	// taken from jquery.masonry
	// 	 https://github.com/desandro/masonry
	// helper function for logging errors
	// $.error breaks jQuery chaining
	var logError 				= function( message ) {
		if ( this.console ) {
			console.error( message );
		}
	};
	
	// Structure taken from jquery.masonry
	// 	 https://github.com/desandro/masonry
	// =======================  Plugin bridge  ===============================
	// leverages data method to either create or return $.Montage constructor
	// A bit from jQuery UI
	//   https://github.com/jquery/jquery-ui/blob/master/ui/jquery.ui.widget.js
	// A bit from jcarousel 
	//   https://github.com/jsor/jcarousel/blob/master/lib/jquery.jcarousel.js

	$.fn.montage 				= function( options ) {
		if ( typeof options === 'string' ) {
			// call method
			var args = Array.prototype.slice.call( arguments, 1 );

			this.each(function() {
				var instance = $.data( this, 'montage' );
				if ( !instance ) {
					logError( "cannot call methods on montage prior to initialization; " +
					"attempted to call method '" + options + "'" );
					return;
				}
				if ( !$.isFunction( instance[options] ) || options.charAt(0) === "_" ) {
					logError( "no such method '" + options + "' for montage instance" );
					return;
				}
				// apply method
				instance[ options ].apply( instance, args );
			});
		} 
		else {
			this.each(function() {
				var instance = $.data( this, 'montage' );
				if ( instance ) {
					// apply options & reload
					instance.option( options || {} );
					instance._reload();
				} 
				else {
					// initialize new instance
					$.data( this, 'montage', new $.Montage( options, this ) );
				}
			});
		}
		
		return this;
	};
	
})( window, jQuery );