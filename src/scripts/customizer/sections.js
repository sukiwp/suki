/**
 * Static sections
 */

wp.customize.sectionConstructor['suki-pro-link'] =
wp.customize.sectionConstructor['suki-pro-teaser'] =
wp.customize.sectionConstructor['suki-spacer'] = wp.customize.Section.extend( {
	// No events for this type of section.
	attachEvents: function () {},

	// Always make the section active.
	isContextuallyActive: function () {
		return true;
	}
} );

/**
 * Builder section
 */
wp.customize.sectionConstructor['suki-builder'] = wp.customize.Section.extend( {
	initAllControls: function() {
		const section = this;

		section.controls().forEach( ( control ) => {
			if ( 'resolved' !== control.deferred.embedded.state() ) {
				control.embed();
				
				if ( control.actuallyEmbed ) {
					control.actuallyEmbed();
				}
			}
		} );
	},

	resizePreview: function() {
		const section = this;

		if ( ! section.contentContainer[0].classList.contains( 'active' ) ) {
			return;
		}

		console.log( section.id + ' -- ' + section.contentContainer[0].getBoundingClientRect().height );
		
		if ( 1324 <= window.innerWidth && ! section.contentContainer[0].classList.contains( 'hidden' ) ) {
			wp.customize.previewer.container[0].style.height = 'calc(100% - ' + ( section.contentContainer[0].getBoundingClientRect().height + 'px' ) + ')' ;
		} else {
			wp.customize.previewer.container[0].style.height = null;
		}
	},

	ready: function() {
		const section = this;

		// Bind this.
		this.resizePreview = this.resizePreview.bind( this );

		const panelId = section.panel.get();

		// If section is inside a panel, bind panel expanded.
		if ( '' !== panelId ) {
			wp.customize.panel( panelId, ( panel ) => {
				panel.expanded.bind( ( isExpanded ) => {
					if ( isExpanded ) {
						section.initAllControls();
						section.contentContainer[0].classList.add( 'active' );

						window.addEventListener( 'resize', section.resizePreview );
						section.resizePreview();
					} else {
						section.contentContainer[0].classList.remove( 'active' );
						
						window.removeEventListener( 'resize', section.resizePreview );
						section.resizePreview();
					}
				} );
			} )
		}
		// Init section right away.
		else {
			section.initAllControls();
			section.contentContainer[0].classList.add( 'active' );

			window.addEventListener( 'resize', section.resizePreview );
			section.resizePreview();
		}

		// Handler for hide builder button.
		section.contentContainer[0].querySelector( '.suki-builder-section__toggle__hide' ).addEventListener( 'click', ( e ) => {
			e.preventDefault();
			
			section.contentContainer[0].classList.add( 'hidden' );
			document.activeElement.blur();

			section.resizePreview();
		} );
		
		// Handler for show builder button.
		section.contentContainer[0].querySelector( '.suki-builder-section__toggle__show' ).addEventListener( 'click', ( e ) => {
			e.preventDefault();
			
			section.contentContainer[0].classList.remove( 'hidden' );
			document.activeElement.blur();

			section.resizePreview();
		} );

		wp.customize.bind( 'ready', function() {
			wp.customize.previewedDevice.bind( ( device ) => {
				section.resizePreview();
			} );
		} );
	}
} );