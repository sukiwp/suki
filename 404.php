<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>

<div id="primary" class="content-area narrow">
	<main id="main" class="site-main" role="main">
		<?php
		/**
		 * Hook: suki_before_main
		 * 
		 * @hooked suki_404_page_header - 10
		 */
		do_action( 'suki_before_main' );
		?>

		<section class="error-404 not-found">
			<div class="page-content">
				<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'suki' ); ?></p>
				<?php get_search_form(); ?>
			</div>
		</section>

		<?php
		/**
		 * Hook: suki_after_main
		 */
		do_action( 'suki_after_main' );
		?>

	</main>
</div>

<?php
get_footer();
