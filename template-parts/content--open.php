<?php
/**
 * Opening tag for: Content section without sidebar template.
 * Closing tag: content-close.php.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div id="content" class="<?php suki_element_class( 'content', array( 'suki-content', 'site-content', 'suki-container' ) ); ?>">
	<?php
	/**
	 * Hook: suki/frontend/before_content
	 */
	do_action( 'suki/frontend/before_content' );
	?>

	<main id="primary" class="site-main wp-block-group suki-container">
