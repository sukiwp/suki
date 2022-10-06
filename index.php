<?php
/**
 * Fallback global page template.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Header template
 */
get_header();

/**
 * Content
 */
suki_content(
	suki_loop(
		suki_get_current_page_setting( 'loop_layout', 'default' ),
		false,
		false
	)
);

/**
 * Footer template
 */
get_footer();
