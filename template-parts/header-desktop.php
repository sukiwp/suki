<?php
/**
 * Main header sections template.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div id="header" class="<?php suki_element_class( 'header', array( 'suki-header-desktop', 'suki-show-on-desktop' ) ); ?>">
	<?php
	// Header Top Bar (if not merged).
	if ( ! intval( suki_get_theme_mod( 'header_top_bar_merged' ) ) ) {
		suki_header_desktop__top_bar();
	}

	// Header Main Bar.
	suki_header_desktop__main_bar();

	// Header Bottom Bar (if not merged).
	if ( ! intval( suki_get_theme_mod( 'header_bottom_bar_merged' ) ) ) {
		suki_header_desktop__bottom_bar();
	}
	?>
</div>
