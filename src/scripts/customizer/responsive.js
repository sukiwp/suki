/**
 * Handle suki-responsive-switcher
 */

wp.customize.bind( 'ready', () => {
	document.addEventListener( 'click', ( e ) => {
		const $button = e.target.closest( '.suki-responsive-switcher__button' );
		if ( ! $button ) return;

		wp.customize.previewedDevice.set( $button.getAttribute( 'data-device' ) || 'desktop' );
	}, true );
} );