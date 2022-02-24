<?php
/**
 * Error 404 page template.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Header
 */
get_header();

/**
 * Content wrapper template -- Open
 */
suki_content_open();

/**
 * Error 404 content
 */
suki_get_template_part( 'error-404' );

/**
 * Content wrapper template -- Close
 */
suki_content_close();

/**
 * Footer
 */
get_footer();
