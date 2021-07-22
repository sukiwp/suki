<?php
/**
 * Customizer control's conditional display.
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$add = array();

/**
 * ====================================================
 * WooCommerce > Products Catalog Page
 * ====================================================
 */

$add['product_archive_title_text'] =
$add['product_archive_tax_title_text'] = array(
	array(
		'setting'  => 'product_archive_content_header',
		'operator' => 'contain',
		'value'    => 'title',
	),
);

/**
 * ====================================================
 * WooCommerce > Cart Page
 * ====================================================
 */

$add['notice_cart_2_columns'] = array(
	array(
		'setting'  => 'woocommerce_cart_layout',
		'value'    => '2-columns',
	),
);

$add['woocommerce_cart_cross_sells_position'] =
$add['woocommerce_cart_cross_sells_grid_columns'] = array(
	array(
		'setting'  => 'woocommerce_cart_cross_sells',
		'value'    => 1,
	),
);

/**
 * ====================================================
 * WooCommerce > Checkout Page
 * ====================================================
 */

$add['notice_checkout_2_columns'] = array(
	array(
		'setting'  => 'woocommerce_checkout_layout',
		'value'    => '2-columns',
	),
);

return $add;