<?php
/**
 * Footer template.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
				<?php
				/**
				 * Hook: suki/frontend/before_footer
				 */
				do_action( 'suki/frontend/before_footer' );

				/**
				 * Footer
				 */
				suki_footer();

				/**
				 * Hook: suki/frontend/after_footer
				 */
				do_action( 'suki/frontend/after_footer' );
				?>
			</div>
		</div>

		<?php
		/**
		 * Hook: suki/frontend/after_canvas
		 */
		do_action( 'suki/frontend/after_canvas' );

		/**
		 * Hook: wp_footer
		 */
		wp_footer();
		?>
	</body>
</html>
