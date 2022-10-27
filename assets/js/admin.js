/**
 * Admin page javascript
 *
 * @param {jQuery} $
 */
( function( $ ) {
	'use strict';

	const $body = $( 'body' );

	$( function() {
		/**
		 * Admin Fields
		 */

		// Upload control
		$body.on( 'click', '.suki-admin-upload-control-button', function( e ) {
			e.preventDefault();

			const $button = $( this );
			const $control = $button.closest( '.suki-admin-upload-control' );
			let frame = $control.data( 'wpmedia' );

			// Check if media lirbrary frame is already declared.
			if ( frame ) {
				frame.open();
				return;
			}

			// Declare media library frame.
			frame = wp.media.frames.file_frame = wp.media( {
				title: $control.attr( 'data-title' ),
				button: {
					text: $control.attr( 'data-button' ),
				},
				multiple: false,
			} );

			// Handle Choose button
			frame.on( 'select', function() {
				const $input = $control.find( 'input' );
				const file = frame.state().get( 'selection' ).first().toJSON();

				$input.val( file.url );
			} );

			frame.open();

			$control.data( 'wpmedia', frame );
		} );

		if ( $.fn.select2 ) {
			$( '.suki-admin-multiselect-control' ).select2();
		}

		// Color control
		if ( $.fn.wpColorPicker ) {
			$( '.suki-admin-color-control' ).find( 'input' ).wpColorPicker();
		}

		// Dependency fields
		$body.on( 'change', '.suki-admin-dependent-field', function() {
			const $field = $( this );
			const $settings = $( '[data-dependency="' + $field.attr( 'name' ) + '"]' );
			const value = this.value;

			$settings.hide();
			$settings.each( function() {
				const $setting = $( this );
				const requirements = $setting.attr( 'data-value' ).split( ',' );
				const found = -1 < requirements.indexOf( value ) ? true : false;

				switch ( $setting.attr( 'data-operator' ) ) {
					case '!=':
						if ( ! found ) {
							$setting.show();
						}
						break;

					default:
						if ( found ) {
							$setting.show();
						}
						break;
				}
			} );
		} );
		$( '.suki-admin-dependent-field' ).trigger( 'change' );

		/**
		 * Metabox tabs
		 */

		$( '.suki-admin-metabox' ).each( function() {
			const $metabox = $( this );
			const $navigation = $metabox.find( '.suki-admin-metabox-nav' );
			const $panels = $metabox.find( '.suki-admin-metabox-panels' );

			$navigation.on( 'click', '.suki-admin-metabox-nav-item a', function( e ) {
				e.preventDefault();

				const $link = $( this );
				const $target = $panels.children( $link.attr( 'href' ) );

				if ( $target && ! $target.hasClass( 'active' ) ) {
					$navigation.children( '.suki-admin-metabox-nav-item.active' ).removeClass( 'active' );
					$link.parent( '.suki-admin-metabox-nav-item' ).addClass( 'active' );

					$panels.children( '.suki-admin-metabox-panel.active' ).removeClass( 'active' );
					$target.addClass( 'active' );
				}
			} );

			$metabox.trigger( 'suki-admin-metabox.ready', this );
		} );

		/**
		 * Rating notice close button
		 */

		$( '.suki-rating-notice' ).on( 'click', '.suki-rating-notice-close', function() {
			const $link = $( this );
			const $notice = $link.closest( '.suki-rating-notice' );
			const repeat = $link.attr( 'data-suki-rating-notice-repeat' );

			// Run AJAX to set data after closing the notice.
			$.ajax( {
				method: 'POST',
				dataType: 'JSON',
				url: ajaxurl,
				data: {
					action: 'suki_rating_notice_close',
					repeat_after: repeat,
					_ajax_nonce: sukiAdminData.ajax_nonce,
				},
			} );

			// Always remove the notice on current page.
			$notice.fadeTo( 100, 0, function() {
				$notice.slideUp( 100, function() {
					$notice.remove();
				} );
			} );
		} );

		/**
		 * "Suki Sites Import" plugin installation from theme's dashboard page.
		 */

		$( '[data-js="install-sites-import-plugin"]' ).on( 'click', function() {
			const $button = $( this );

			$button.prop( 'disabled', 'disabled' );
			$button.addClass( 'disabled' );
			$button.html( sukiAdminData.strings.installing );

			return $.ajax( {
				method: 'POST',
				dataType: 'JSON',
				url: ajaxurl + '?do=suki_install_sites_import_plugin',
				cache: false,
				data: {
					action: 'suki_install_sites_import_plugin',
					plugin_slug: 'suki-sites-import',
					_ajax_nonce: sukiAdminData.ajax_nonce,
				},
			} )
				.done( function( response ) {
					if ( response.success ) {
						$button.html( sukiAdminData.strings.redirecting_to_demo_list );

						window.location = sukiAdminData.sitesImportPageURL;
					} else {
						// eslint-disable-next-line no-alert
						alert( sukiAdminData.strings.error_installing_plugin );
					}
				} );
		} );
	} );
}( jQuery ) );
