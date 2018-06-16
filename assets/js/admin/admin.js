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
		 * Admin Field
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
		 * Suki > Settings
		 */

		// Custom Fonts
		// $( '.suki-admin-custom-fonts' ).on( 'change', '.suki-admin-custom-font-variants select', function( e ) {
		// 	var values = $( this ).val(),
		// 	    $scope = $( this ).closest( '.suki-admin-custom-font' );

		// 	// Hide all variants.
		// 	$scope.find( '.suki-admin-custom-font-variant' ).hide();
			
		// 	// Show selected variants.
		// 	if ( values ) {
		// 		for ( var i = 0; i < values.length; i++ ) {
		// 			$target = $scope.find( '.suki-admin-custom-font-variant[data-variant="' + values[ i ] + '"]' );
		// 			$target.show();
		// 		}
		// 	}
		// });

		$( '.suki-admin-custom-fonts' ).on( 'change', '.suki-admin-custom-font-variants input', function( e ) {
			var $scope = $( this ).closest( '.suki-admin-custom-font' ),
			    $target = $scope.find( '.suki-admin-custom-font-variant[data-variant="' + this.value + '"]' );

			if ( this.checked ) {
				$target.show();
			} else {
				$target.hide();
			}
		});

		/**
		 * Suki > Demo Templates
		 */
		$( '.suki-admin-demo-templates' ).on( 'click', '.themes .theme', function( e ) {
			e.preventDefault();

			if ( SukiDemoTemplates ) {
				var slug = $( this ).attr( 'data-slug' ),
				    $popup = $( '#suki-admin-demo-template-single' );

				if ( undefined !== SukiDemoTemplates.templates[ slug ] ) {
					var template = SukiDemoTemplates.templates[ slug ];

					$popup.find( '.suki-admin-demo-template-name' ).html( template.name );
				}
			}
		});

		/**
		 * Suki > Tools
		 */

		// Regenerate CSS
		$( '.suki-admin-tools' ).on( 'click', '.suki-admin-regenerate-css-button', function( e ) {
			e.preventDefault();

			var $button = $( this ),
			    $status_loading = $button.siblings( '.suki-status-loading' ),
			    $status_success = $button.siblings( '.suki-status-success' );

			$button.addClass( 'loading' ).prop( 'disabled', true );
			$status_loading.show();
			$status_success.hide();

			$.post( ajaxurl, {
				action: 'suki_regenerate_css',
				_wpnonce: $button.data( 'nonce' ),
			} ).done( function() {
				$status_loading.hide();
				$status_success.show();
				$button.removeClass( 'loading' ).prop( 'disabled', false );
			} );
		});

		// Export Customizer settings
		$( '.suki-admin-tools' ).on( 'click', '.suki-admin-export-customizer-button', function( e ) {
			e.preventDefault();

			var $button = $( this );

			$button.addClass( 'loading' ).prop( 'disabled', true );

			$.post( ajaxurl, {
				action: 'suki_export_customizer',
				_wpnonce: $button.data( 'nonce' ),
			} ).done( function( response ) {
				// Download string to file using JS.
				// ref: https://stackoverflow.com/questions/3665115/create-a-file-in-memory-for-user-to-download-not-through-server#answer-18197341
				var downloadLink = document.createElement( 'a' );
				downloadLink.setAttribute( 'href', 'data:text/plain;charset=utf-8,' + encodeURIComponent( response.data.content ) );
				downloadLink.setAttribute( 'download', response.data.filename );
				downloadLink.style.display = 'none';
				document.body.appendChild( downloadLink );
				downloadLink.click();
				document.body.removeChild( downloadLink );

				$button.removeClass( 'loading' ).prop( 'disabled', false );
			} );
		});

		// Import Customizer settings
		$( '.suki-admin-tools' ).on( 'click', '.suki-admin-import-customizer-button', function( e ) {
			e.preventDefault();

			var $button = $( this ),
			    $textarea = $button.prev(),
			    empty_text = $button.data( 'empty' ),
			    $status_loading = $button.siblings( '.suki-status-loading' ),
			    $status_success = $button.siblings( '.suki-status-success' ),
			    $status_error = $button.siblings( '.suki-status-error' );

			$status_success.hide();
			$status_error.hide();

			if ( 0 < $textarea.val().length ) {
				$button.addClass( 'loading' ).prop( 'disabled', true );
				$status_loading.show();

				$.post( ajaxurl, {
					action: 'suki_import_customizer',
					_wpnonce: $button.data( 'nonce' ),
					code: $textarea.val(),
				} ).done( function( response ) {
					$status_loading.hide();
					$button.removeClass( 'loading' ).prop( 'disabled', false );
					if ( response.success ) {
						$status_success.show();
					} else {
						$status_error.show();
					}
				} );
			} else {
				alert( empty_text );
			}
		});

		// Reset Customizer settings
		$( '.suki-admin-tools' ).on( 'click', '.suki-admin-reset-customizer-button', function( e ) {
			e.preventDefault();

			var $button = $( this ),
			    confirm_text = $button.data( 'confirm' ),
			    $status_loading = $button.siblings( '.suki-status-loading' ),
			    $status_success = $button.siblings( '.suki-status-success' );

			$status_success.hide();

			if ( confirm( confirm_text ) ) {
				$button.addClass( 'loading' ).prop( 'disabled', true );
				$status_loading.show();

				$.post( ajaxurl, {
					action: 'suki_reset_customizer',
					_wpnonce: $button.data( 'nonce' ),
				} ).done( function() {
					$status_loading.hide();
					$status_success.show();
					$button.removeClass( 'loading' ).prop( 'disabled', false );
				} );
			}
		});

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