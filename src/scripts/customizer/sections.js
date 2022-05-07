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