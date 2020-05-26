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
 * WooCommerce > Cart Page
 * ====================================================
 */

$add['notice_cart_2_columns'] = array(
	array(
		'setting'  => 'woocommerce_cart_layout',
		'value'    => '2-columns',
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