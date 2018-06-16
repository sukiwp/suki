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

?>
				<?php if ( apply_filters( 'suki_print_content_wrapper', true ) ) : ?>
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>

				<?php
				/**
				 * Hook: suki_before_footer
				 */
				do_action( 'suki_before_footer', 'suki' );

				/**
				 * Hook: suki_footer
				 * 
				 * @hooked suki_footer - 10
				 */
				do_action( 'suki_footer', 'suki' );
				
				/**
				 * Hook: suki_after_footer
				 */
				do_action( 'suki_after_footer', 'suki' );
				?>
				
			</div>
		</div>

		<?php wp_footer(); ?>
	</body>
</html>
