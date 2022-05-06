/**
 * Spacer section
 */

wp.customize.SukiSpacerSection = wp.customize.Section.extend( {
	// No events for this type of section.
	attachEvents: function () {},

	// Always make the section active.
	isContextuallyActive: function () {
		return true;
	}
} );

wp.customize.sectionConstructor['suki-spacer'] = wp.customize.SukiSpacerSection;