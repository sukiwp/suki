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
 * Primary - opening tag
 */
suki_primary_open();

/**
 * Hook: suki/frontend/before_main
 */
do_action( 'suki/frontend/before_main' );

while ( have_posts() ) : the_post();

	// Render post content using "post-content" layout.
	suki_get_template_part( 'post-content' );

endwhile;

/**
 * Hook: suki/frontend/after_main
 * 
 * @hooked suki_post_author_bio - 10
 * @hooked suki_post_navigation - 15
 * @hooked suki_comments - 20
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