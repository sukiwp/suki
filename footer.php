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
				 * Content - closing tag
				 */
				if ( apply_filters( 'suki/frontend/show_content_wrapper', true ) ) {
					suki_content_close();
				}

				/**
				 * Hook: suki/frontend/before_footer
				 */
				do_action( 'suki/frontend/before_footer' );

				/**
				 * Footer
				 */
				?>
				<footer id="colophon" class="site-footer suki-footer" role="contentinfo" itemtype="https://schema.org/WPFooter" itemscope>
					<?php
					/**
					 * Hook: suki/frontend/footer
					 *
					 * @hooked suki_main_footer - 10
					 */
					do_action( 'suki/frontend/footer' );
					?>
				</footer>
				<?php
				
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