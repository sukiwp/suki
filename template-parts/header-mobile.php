<?php
/**
 * Mobile header sections template.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div id="mobile-header" class="<?php suki_element_class( 'header_mobile', array( 'suki-header-mobile', 'suki-hide-on-desktop' ) ); ?>">
	<?php
	// Mobile Header Main Bar.
	suki_header_mobile__main_bar();

	// Mobile Header Popup.
	suki_header_mobile__popup();
	?>
</div>
