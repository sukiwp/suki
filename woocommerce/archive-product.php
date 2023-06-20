<?php
/**
 * WooCommerce products archive template.
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
	'
	<!-- wp:group {
		"layout":{
			"type":"default"
		}
	} --><div class="wp-block-group">

		<!-- wp:woocommerce/legacy-template {
			"template":"archive-product",
			"align":"none"
		} /-->

	</div><!-- /wp:group -->
	',
	'shop'
);

/**
 * Footer template
 */
get_footer();
