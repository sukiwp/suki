/**
 * Custom section
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

wp.customize.sectionConstructor['suki-builder'] = wp.customize.Section.extend( {
	ready: function() {
		const section = this;

		const panelId = section.panel.get();

		if ( '' !== panelId ) {
			wp.customize.panel( panelId, ( panel ) => {
				panel.expanded.bind( ( isExpanded ) => {
					if ( isExpanded ) {
						section.controls().forEach( (control) => {
							if ( 'resolved' !== control.deferred.embedded.state() ) {
								control.embed();

								if ( control.actuallyEmbed ) {
									control.actuallyEmbed();
								}
							}
						} );
						section.contentContainer[0].classList.add( 'active' );
					} else {
						section.contentContainer[0].classList.remove( 'active' );
					}
				} );
			} )
		}

		section.contentContainer[0].querySelector( '.suki-builder-section__toggle__hide' ).addEventListener( 'click', ( e ) => {
			e.preventDefault();
			
			section.contentContainer[0].classList.add( 'hidden' );
			document.activeElement.blur();
		} );
		
		section.contentContainer[0].querySelector( '.suki-builder-section__toggle__show' ).addEventListener( 'click', ( e ) => {
			e.preventDefault();
			
			section.contentContainer[0].classList.remove( 'hidden' );
			document.activeElement.blur();
		} );
	}
} );