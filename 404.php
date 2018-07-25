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

suki_main_content_open();

/**
 * Hook: suki/frontend/before_main
 * 
 * @hooked suki_content_header - 10
 */
do_action( 'suki/frontend/before_main' );
?>

<section class="error-404 not-found">
	<div class="page-content">
		<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'suki' ); ?></p>
		<?php get_search_form(); ?>
	</div>
</section>

<?php
/**
 * Hook: suki/frontend/after_main
 */
do_action( 'suki/frontend/after_main' );

suki_main_content_close();

get_sidebar();

get_footer();
