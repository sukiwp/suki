/**
 * Static sections
 */

wp.customize.sectionConstructor[ 'suki-pro-link' ] =
wp.customize.sectionConstructor[ 'suki-pro-teaser' ] =
wp.customize.sectionConstructor[ 'suki-spacer' ] = wp.customize.Section.extend( {
	// No events for this type of section.
	attachEvents() {},

	// Always make the section active.
	isContextuallyActive() {
		return true;
	},
} );

/**
 * Builder section
 */
wp.customize.sectionConstructor[ 'suki-builder' ] = wp.customize.Section.extend( {
	initAllControls() {
		const section = this;

		section.controls().forEach( ( control ) => {
			if ( 'resolved' !== control.deferred.embedded.state() ) {
				control.embed();

				if ( control.actuallyEmbed ) {
					control.actuallyEmbed();
				}
			}
		} );

		section.initialized = true;
	},

	resizePreview() {
		const section = this;

		if ( ! section.initialized ) {
			return;
		}

		if ( 1324 <= window.innerWidth && section.contentContainer[ 0 ].classList.contains( 'active' ) && ! section.contentContainer[ 0 ].classList.contains( 'hidden' ) ) {
			let originalHeight;

			switch ( wp.customize.previewedDevice.get() ) {
				case 'tablet':
					originalHeight = '1024px'; // Custom mobile view height as defined in the theme's CSS.
					break;

				case 'mobile':
					originalHeight = '812px'; // Custom mobile view height as defined in the theme's CSS.
					break;

				default:
					originalHeight = '100%';
					break;
			}

			wp.customize.previewer.container[ 0 ].style.height = 'min( calc(100% - ' + ( section.contentContainer[ 0 ].getBoundingClientRect().height + 'px' ) + '), ' + originalHeight + ' )';
		} else {
			wp.customize.previewer.container[ 0 ].style.height = null;
		}
	},

	ready() {
		const section = this;

		section.initialized = false;

		// Bind this.
		this.resizePreview = this.resizePreview.bind( this );

		const panelId = section.panel.get();

		if ( '' !== panelId ) {
			// If section is inside a panel, bind panel expanded.

			wp.customize.panel( panelId, ( panel ) => {
				panel.expanded.bind( ( isExpanded ) => {
					if ( isExpanded ) {
						section.initAllControls();
						section.contentContainer[ 0 ].classList.add( 'active' );

						window.addEventListener( 'resize', section.resizePreview );
						section.resizePreview();
					} else {
						section.contentContainer[ 0 ].classList.remove( 'active' );

						window.removeEventListener( 'resize', section.resizePreview );
						section.resizePreview();
					}
				} );
			} );
		} else {
			// Init section right away.

			section.initAllControls();
			section.contentContainer[ 0 ].classList.add( 'active' );

			window.addEventListener( 'resize', section.resizePreview );
			section.resizePreview();
		}

		// Handler for hide builder button.
		section.contentContainer[ 0 ].querySelector( '.suki-builder-section__toggle__hide' ).addEventListener( 'click', ( e ) => {
			e.preventDefault();

			section.contentContainer[ 0 ].classList.add( 'hidden' );

			section.resizePreview();
		} );

		// Handler for show builder button.
		section.contentContainer[ 0 ].querySelector( '.suki-builder-section__toggle__show' ).addEventListener( 'click', ( e ) => {
			e.preventDefault();

			section.contentContainer[ 0 ].classList.remove( 'hidden' );

			section.resizePreview();
		} );

		wp.customize.bind( 'ready', function() {
			wp.customize.previewedDevice.bind( () => {
				section.resizePreview();
			} );
		} );
	},
} );
