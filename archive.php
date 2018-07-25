<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

suki_main_content_open();

if ( have_posts() ) :

	/**
	 * Hook: suki/frontend/before_main
	 *
	 * @hooked suki_content_header - 10
	 */
	do_action( 'suki/frontend/before_main' );
	?>
	
	<div id="loop" class="suki-loop <?php echo esc_attr( implode( ' ', apply_filters( 'suki/frontend/loop_classes', array() ) ) ); ?>">
		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();

			// Render post content using selected layout on Customizer.
			get_template_part( 'template-parts/content', suki_get_theme_mod( 'blog_index_loop_mode' ) );

		endwhile;
		?>
	</div>

	<?php
	/**
	 * Hook: suki/frontend/after_main
	 * 
	 * @hooked suki_loop_navigation - 10
	 */
	do_action( 'suki/frontend/after_main' );

else :

	get_template_part( 'template-parts/content', 'none' );

endif;

suki_main_content_close();

get_sidebar();

get_footer();
