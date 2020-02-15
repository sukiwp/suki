<?php
/**
 * Scoll to top button template.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<a href="#page" class="<?php echo esc_attr( implode( ' ', apply_filters( 'suki/frontend/scroll_to_top_classes', array( 'suki-scroll-to-top' ) ) ) ); ?>">
	<?php suki_icon( 'chevron-up' ); ?>
	<span class="screen-reader-text"><?php esc_html_e( 'Back to Top', 'suki' ); ?></span>
</a>