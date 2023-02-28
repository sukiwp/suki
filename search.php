<?php
/**
 * Search results page template.
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
	suki_loop( boolval( suki_get_theme_mod( 'search_results_use_blog_loop_layout' ) ) ? suki_get_theme_mod( 'post_archive_loop_layout' ) : 'search', false, false )
);

/**
 * Footer template
 */
get_footer();
