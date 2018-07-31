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

/**
 * Header
 */
get_header();

/**
 * Hook: suki/frontend/archive
 *
 * @hooked suki_search - 10
 */
do_action( 'suki/frontend/archive' );

/**
 * Footer
 */
get_footer();
