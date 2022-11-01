import './index.scss';

import './builder';

/**
 * Static sections
 */

wp.customize.sectionConstructor[ 'suki-pro-link' ] =
wp.customize.sectionConstructor[ 'suki-pro-teaser' ] =
wp.customize.sectionConstructor[ 'suki-responsive-tabs' ] =
wp.customize.sectionConstructor[ 'suki-spacer' ] = wp.customize.Section.extend( {
	// No events for this type of section.
	attachEvents() {},

	// Always make the section active.
	isContextuallyActive() {
		return true;
	},
} );
