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

if ( have_posts() ) :

	/**
	 * Hook: suki/frontend/before_main
	 *
	 * @hooked suki_content_header - 10
	 */
	do_action( 'suki/frontend/before_main' );
	
	?>
	<div id="loop" class="suki-loop suki-loop-search">
		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();

			// Render post content using "content-search" layout on Customizer.
			get_template_part( 'template-parts/content', 'search' );

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

	// Render no content notice.
	get_template_part( 'template-parts/content', 'none' );

endif;

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