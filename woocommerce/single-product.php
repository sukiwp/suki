<?php
/**
 * WooCommerce single product template.
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
	'<!-- wp:woocommerce/legacy-template {
		"template":"single-product"
	} /-->',
	'shop'
);

/**
 * Footer template
 */
get_footer();
