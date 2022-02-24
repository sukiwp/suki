<?php
/**
 * Mobile header popup template.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Fetch elements.
$elements = suki_get_theme_mod( 'header_mobile_elements_vertical_top', array() );

// Abort if no element found in this section.
if ( 1 > count( $elements ) ) {
	return;
}

?>
<div id="mobile-header-popup" class="<?php suki_element_class( 'header_mobile_vertical', array( 'suki-header-mobile-vertical', 'suki-popup' ) ); ?>">
	<div class="suki-popup-background suki-popup-close"></div>

	<div class="suki-header-mobile-vertical-bar suki-header-section-vertical suki-header-vertical-column">
		<div class="suki-header-vertical-row-top suki-header-vertical-row">
			<?php
			// Print elements.
			foreach ( $elements as $element ) {
				suki_header_element( $element );
			}
			?>
		</div>
	</div>

	<button class="suki-popup-close-icon suki-popup-close suki-toggle"><?php suki_icon( 'close' ); ?></button>
</div>
