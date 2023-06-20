<?php
/**
 * Template Name: [Theme] Page Builder with Container
 *
 * Page template for Page Builder plugins that doesn't have their own content container / wrapper functionalities, for example:
 * - Visual Composer
 * - Site Origin
 *
 * The template use theme's default container.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

the_post();

echo do_blocks( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	'
	<!-- wp:group {
		"tagName":"main",
		"className":"site-content ' . esc_attr( 'suki-section--' . suki_get_current_page_setting( 'content_container' ) ) . '",
		"layout":{
			"type":"default"
		}
	} --><main id="content" class="wp-block-group site-content ' . esc_attr( 'suki-section--' . suki_get_current_page_setting( 'content_container' ) ) . '">

		<!-- wp:post-content /-->

	</main><!-- /wp:group -->
	'
);

get_footer();
