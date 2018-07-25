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

get_header();

suki_main_content_open();

if ( have_posts() ) :

	/**
	 * Hook: suki/frontend/before_main
	 * 
	 * @hooked suki_search_page_header - 10
	 */
	do_action( 'suki/frontend/before_main' );
	?>

	<div id="loop" class="suki-loop suki-loop-search">
		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();

			// Render post content.
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

	get_template_part( 'template-parts/content', 'none' );

endif;

suki_main_content_close();

get_sidebar();

get_footer();
