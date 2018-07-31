<?php
/**
 * The template for displaying archive pages
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

/**
 * Hook: suki/frontend/archive
 *
 * @hooked suki_archive - 10
 */
do_action( 'suki/frontend/archive' );

/**
 * Footer
 */
get_footer();
