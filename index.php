<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
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
	 * @hooked suki_home_page_header - 10
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
