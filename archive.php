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
 * @hooked suki_archive_header - 10
 */
do_action( 'suki/frontend/before_main' );

if ( have_posts() ) :

	/**
	 * Hook: suki/frontend/before_loop
	 */
	do_action( 'suki/frontend/before_loop' );
	
	?>
	<div id="loop" class="<?php echo esc_attr( implode( ' ', apply_filters( 'suki/frontend/loop_classes', array( 'suki-loop' ) ) ) ); ?>">
		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();

			// Render post content using selected layout on Customizer.
			suki_get_template_part( 'entry', suki_get_theme_mod( 'blog_index_loop_mode' ) );

		endwhile;
		?>
	</div>
	<?php

	/**
	 * Hook: suki/frontend/after_loop
	 */
	do_action( 'suki/frontend/after_loop' );

else :

	// Render no content notice.
	suki_get_template_part( 'entry', 'none' );

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