<?php
/**
 * Closing tag for: Content section with sidebar template.
 * Opening tag: content-open-with-sidebar.php.
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
		 * Sidebar
		 */
		get_sidebar();
		?>
	</div>

	<?php
	/**
	 * Hook: suki/frontend/after_content
	 */
	do_action( 'suki/frontend/after_content' );
	?>
</div>
