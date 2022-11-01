wp.customize.bind( 'ready', () => {
	document.getElementById( 'customize-controls' ).addEventListener( 'click', ( e ) => {
		if ( ! e.target.closest( '.suki-responsive-tabs__button' ) ) {
			return;
		}

		e.preventDefault();

		const button = e.target.closest( '.suki-responsive-tabs__button' );

		wp.customize.previewedDevice.set( button.dataset.device );
	} );

	wp.customize.previewedDevice.bind( ( device ) => {
		const targetDevice = 'desktop' === device ? 'desktop' : 'tablet';
		const buttons = document.querySelectorAll( '.suki-responsive-tabs__button' );

		buttons.forEach( ( button ) => {
			if ( targetDevice === button.dataset.device ) {
				button.classList.add( 'nav-tab-active', 'active' );
			} else {
				button.classList.remove( 'nav-tab-active', 'active' );
			}
		} );
	} );
} );
