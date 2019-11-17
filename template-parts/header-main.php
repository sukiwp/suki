<?php
/**
 * Main header sections template.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<div id="header" class="<?php echo esc_attr( implode( ' ', apply_filters( 'suki/frontend/header_classes', array( 'suki-header-main', 'suki-header' ) ) ) ); ?>">
	<?php
	// Top Bar (if not merged)
	if ( ! intval( suki_get_theme_mod( 'header_top_bar_merged' ) ) ) {
		suki_main_header__bar( 'top' );
	}

	// Main Bar
	suki_main_header__bar( 'main' );

	// Bottom Bar (if not merged)
	if ( ! intval( suki_get_theme_mod( 'header_bottom_bar_merged' ) ) ) {
		suki_main_header__bar( 'bottom' );
	}
	?>
</div> 