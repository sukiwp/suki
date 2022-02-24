<?php
/**
 * Closing tag for: Content section without sidebar template.
 * Opening tag: content-open.php.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
	</main>

	<?php
	/**
	 * Hook: suki/frontend/after_content
	 */
	do_action( 'suki/frontend/after_content' );
	?>
</div>
