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

/**
 * Header
 */
get_header();

/**
 * Primary - opening tag
 */
suki_primary_open();

/**
 * Hook: suki/frontend/before_main
 *
 * @hooked suki_content_header - 10
 */
do_action( 'suki/frontend/before_main' );

if ( have_posts() ) :
	
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

else :

	// Render no content notice.
	get_template_part( 'template-parts/content', 'none' );

endif;

/**
 * Hook: suki/frontend/after_main
 * 
 * @hooked suki_loop_navigation - 10
 */
do_action( 'suki/frontend/after_main' );

/**
 * Primary - closing tag
 */
suki_primary_close();

/**
 * Sidebar
 */
get_sidebar();

/**
 * Footer
 */
get_footer();