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
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) :
			
			/**
			 * Hook: suki_before_main
			 * 
			 * @hooked suki_search_page_header - 10
			 */
			do_action( 'suki_before_main' );
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
			 * Hook: suki_after_main
			 * 
			 * @hooked suki_loop_navigation - 10
			 */
			do_action( 'suki_after_main' );

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

	</main>
</div>

<?php
get_sidebar();
get_footer();
