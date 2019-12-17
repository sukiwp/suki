<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
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
 * @hooked suki_search_header - 10
 */
do_action( 'suki/frontend/before_main' );

if ( have_posts() ) :
	
	?>
	<div id="loop" class="suki-loop suki-loop-search">
		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();

			// Render post content using "content-search" layout on Customizer.
			suki_get_template_part( 'entry', 'search' );

		endwhile;
		?>
	</div>
	<?php

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