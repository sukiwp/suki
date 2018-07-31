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
 * Hook: suki/frontend/single
 *
 * @hooked suki_404 - 10
 */
do_action( 'suki/frontend/single' );

/**
 * Footer
 */
get_footer();
