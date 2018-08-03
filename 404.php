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
 */
do_action( 'suki/frontend/before_main' );

?>
<section class="error-404 not-found">
	<div class="page-content">
		<h1><?php esc_html_e( 'Page Not Found', 'suki' ); ?></h1>
		<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try searching?', 'suki' ); ?></p>
		<?php get_search_form(); ?>
	</div>
</section>
<?php

/**
 * Hook: suki/frontend/after_main
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