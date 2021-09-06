<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

				/**
				 * Content
				 */
				if ( apply_filters( 'suki/frontend/show_content_wrapper', true ) ) {
					/**
					 * Content - closing tag
					 */
					suki_content_close();
				}

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