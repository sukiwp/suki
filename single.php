<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php
		while ( have_posts() ) : the_post();

			/**
			 * Hook: suki_before_main
			 */
			do_action( 'suki_before_main' );

			// Render post content in "default" layout.
			get_template_part( 'template-parts/content' );

			/**
			 * Hook: suki_after_main
			 * 
			 * @hooked suki_single_post_author_bio - 10
			 * @hooked suki_single_post_navigation - 15
			 * @hooked suki_entry_comments - 20
			 */
			do_action( 'suki_after_main' );

		endwhile; // End of the loop
		?>

	</main>
</div>

<?php
get_sidebar();
get_footer();
