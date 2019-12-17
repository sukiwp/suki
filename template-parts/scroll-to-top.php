<?php
/**
 * Scoll to top button template.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<button class="<?php echo esc_attr( implode( ' ', apply_filters( 'suki/frontend/scroll_to_top_classes', array( 'suki-scroll-to-top' ) ) ) ); ?>">
	<?php suki_icon( 'chevron-up' ); ?>
</button>