/**
 * Admin page javascript
 */
;jQuery.noConflict();

(function( $ ) {
	"use strict";

	var $window = $( window ),
	    $document = $( document ),
	    $body = $( 'body' );
	
	$(function() {

		/**
		 * Admin Fields
		 */

		// Upload control
		$body.on( 'click', '.suki-admin-upload-control-button', function( e ) {
			e.preventDefault();

			var $button = $( this ),
			    $control = $button.closest( '.suki-admin-upload-control' ),
			    $input = $control.find( 'input' ),
			    frame = $control.data( 'wpmedia' );

			// Check if media lirbrary frame is already declared.
			if ( frame ) {
				frame.open();
				return;
			}

			// Declare media library frame.
			var frameOptions = {
				title: $control.attr( 'data-title' ),
				button: {
					text: $control.attr( 'data-button' ),
				},
				multiple: false,
			};

			if ( '' !== $control.attr( 'data-library' ) ) {
				frameOptions.library = {
					type: $control.attr( 'data-library' ).split( ',' ),
				};
			}

			frame = wp.media.frames.file_frame = wp.media( frameOptions );

			// Handle Choose button
			frame.on( 'select', function() {
				file = frame.state().get( 'selection' ).first().toJSON();
				$input.val( file.url );
			});

			frame.open();

			$control.data( 'wpmedia', frame );
		});

		if ( $.fn.select2 ) {
			$( '.suki-admin-multiselect-control' ).select2();
		}

		// Color control
		if ( $.fn.wpColorPicker ) {
			$( '.suki-admin-color-control' ).find( 'input' ).wpColorPicker();
		}

		// Repeater control
		// https://github.com/DubFriend/jquery.repeater/
		if ( $.fn.repeater ) {
			$( '.suki-admin-repeater-control' ).repeater({
				show: function() {
					var $this = $( this );

					$this.show();
					$this.find( '.suki-admin-repeater-control-hide-on-added' ).hide();

					if ( $.fn.select2 ) {
						$this.find( '.select2' ).remove();
						$this.find( '.suki-admin-multiselect-control' ).removeClass( 'select2-hidden-accessible' ).select2();
					}
				}
			});
		}

		// Dependency fields
		$body.on( 'change', '.suki-admin-dependent-field', function() {
			var $select = $( this ),
			    $settings = $( '[data-dependency="' + $select.attr( 'name' ) + '"]' ),
			    value = this.value;

			$settings.hide();
			$settings.each(function() {
				var $setting = $( this ),
				    requirements = $setting.attr( 'data-value' ).split( ',' );

				found = -1 < requirements.indexOf( value ) ? true : false;

				switch ( $setting.attr( 'data-operator' ) ) {
					case '!=':
						if ( ! found ) $setting.show();
						break;

					default:
						if ( found ) $setting.show();
						break;
				}
			});
		});
		$( '.suki-admin-dependent-field' ).trigger( 'change' );

		/**
		 * Edit page
		 */
		
		// Post Formats info
		$( '#formatdiv' ).on( 'change', 'input[name="post_format"]', function( e ) {
			$( '.suki-post-formats-info > li' ).removeClass( 'active' ).filter( '[data-format="' + this.value + '"]' ).addClass( 'active' );
		});

		// Metabox tabs
		$body.on( 'click', '.suki-metabox-tabs a', function( e ) {
			e.preventDefault();

			var $a = $( this ),
			    $target = $( $a.attr( 'href' ) );

			if ( ! $a.hasClass( 'nav-tab-active' ) ) {
				$a.siblings( 'a' ).removeClass( 'nav-tab-active' );
				$target.siblings( '.suki-metabox-panel' ).removeClass( 'active' );

				$a.addClass( 'nav-tab-active' );
				$target.addClass( 'active' );
			}
		});
	});
	
})( jQuery );