<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Header
 */
get_header();

if ( is_singular() ) {
	/**
	 * Hook: suki/frontend/single
	 *
	 * @hooked suki_single - 10
	 */
	do_action( 'suki/frontend/single' );
}
elseif ( is_archive() || is_home() ) {
	/**
	 * Hook: suki/frontend/archive
	 *
	 * @hooked suki_archive - 10
	 */
	do_action( 'suki/frontend/archive' );
}
elseif ( is_search() ) {
	/**
	 * Hook: suki/frontend/archive
	 *
	 * @hooked suki_search - 10
	 */
	do_action( 'suki/frontend/archive' );
}
else {
	/**
	 * Hook: suki/frontend/single
	 *
	 * @hooked suki_404 - 10
	 */
	do_action( 'suki/frontend/single' );
}

/**
 * Footer
 */
get_footer();
