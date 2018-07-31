<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
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
 * @hooked suki_single - 10
 */
do_action( 'suki/frontend/single' );

/**
 * Footer
 */
get_footer();
