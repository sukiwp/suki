<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
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

			get_template_part( 'template-parts/content', 'page' );

			/**
			 * Hook: suki_after_main
			 * 
			 * @hooked suki_entry_comments - 20
			 */
			do_action( 'suki_after_main' );

		endwhile; // End of the loop.
		?>

	</main>
</div>

<?php
get_sidebar();
get_footer();
