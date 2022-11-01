wp.customize.bind( 'ready', () => {
	document.getElementById( 'customize-controls' ).addEventListener( 'click', ( e ) => {
		if ( ! e.target.closest( '.suki-jump-to-control-link' ) ) {
			return;
		}

		e.preventDefault();

		const url = new URL( e.target );

		if ( url.searchParams.get( 'autofocus[control]' ) ) {
			wp.customize.control( url.searchParams.get( 'autofocus[control]' ) ).focus();
		} else if ( url.searchParams.get( 'autofocus[section]' ) ) {
			wp.customize.section( url.searchParams.get( 'autofocus[section]' ) ).focus();
		} else if ( url.searchParams.get( 'autofocus[panel]' ) ) {
			wp.customize.panel( url.searchParams.get( 'autofocus[panel]' ) ).focus();
		}
	} );
} );
