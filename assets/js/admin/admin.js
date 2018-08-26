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
				var file = frame.state().get( 'selection' ).first().toJSON();
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
		 * Metabox tabs
		 */

		$( '.suki-admin-metabox' ).each(function() {
			var $metabox = $( this ),
			    $navigation = $metabox.find( '.suki-admin-metabox-nav' ),
			    $panels = $metabox.find( '.suki-admin-metabox-panels' );

			$navigation.on( 'click', '.suki-admin-metabox-nav-item a', function( e ) {
				e.preventDefault();

				var $link = $( this ),
				    $target = $panels.children( $link.attr( 'href' ) );

				if ( $target && ! $target.hasClass( 'active' ) ) {
					$navigation.children( '.suki-admin-metabox-nav-item.active' ).removeClass( 'active' );
					$link.parent( '.suki-admin-metabox-nav-item' ).addClass( 'active' );

					$panels.children( '.suki-admin-metabox-panel.active' ).removeClass( 'active' );
					$target.addClass( 'active' );
				}
			})
		});
	});
	
})( jQuery );