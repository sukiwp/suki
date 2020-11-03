<?php
/**
 * Content header template.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<div class="<?php echo esc_attr( implode( ' ', apply_filters( 'suki/frontend/content_header_classes', array( 'content-header' ) ) ) ); ?>">
	<?php
	/**
	 * Hook: suki/frontend/content_header
	 */
	do_action( 'suki/frontend/content_header' );
	?>
</div>