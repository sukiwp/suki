<?php
/**
 * Opening tag for: Content section with sidebar template.
 * Closing tag: content-close-with-sidebar.php.
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

	<div class="suki-content-row">
		<main id="primary" class="site-main suki-container">
