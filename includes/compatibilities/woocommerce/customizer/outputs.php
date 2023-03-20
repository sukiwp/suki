<?php
/**
 * Customizer setting outputs.
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$add = array();

/**
 * ====================================================
 * WooCommerce > Store Notice
 * ====================================================
 */

$add['woocommerce_demo_store_notice_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce-store-notice',
		'property' => 'background-color',
	),
);

$add['woocommerce_demo_store_notice_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce-store-notice',
		'property' => 'color',
	),
);

/**
 * ====================================================
 * WooCommerce > Products Grid
 * ====================================================
 */

$add['woocommerce_products_grid_rows_gap'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce ul.products',
		'property' => '--row-gap',
	),
);

$add['woocommerce_products_grid_columns_gap'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce ul.products',
		'property' => '--column-gap',
	),
);

$add['woocommerce_products_grid_text_alignment'] = array(
	array(
		'type'    => 'class',
		'element' => '.woocommerce ul.products',
		'pattern' => 'suki-products--item-alignment-$',
	),
);

/**
 * ====================================================
 * WooCommerce > Single Product Page
 * ====================================================
 */

$add['woocommerce_single_gallery_width'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce div.product',
		'property' => '--gallery-width',
	),
);

$add['woocommerce_single_gallery_gap'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce div.product',
		'property' => '--gallery-gap',
	),
);

/**
 * ====================================================
 * WooCommerce > Other Elements
 * ====================================================
 */

$add['woocommerce_sale_badge_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce span.onsale',
		'property' => 'background-color',
	),
);

$add['woocommerce_sale_badge_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce span.onsale',
		'property' => 'color',
	),
);

$add['woocommerce_review_star_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce .star-rating',
		'property' => 'color',
	),
);

$props = array(
	'bg'     => 'background-color',
	'border' => 'border-color',
	'text'   => 'text-color',
);

foreach ( $props as $key => $prop ) {
	$add[ 'woocommerce_alt_button_' . $key . '_color' ] = array(
		array(
			'type'     => 'css',
			'element'  => '.woocommerce',
			'property' => '--button-alt--' . $prop,
		),
	);
}

foreach ( $props as $key => $prop ) {
	$add[ 'woocommerce_alt_button_hover_' . $key . '_color' ] = array(
		array(
			'type'     => 'css',
			'element'  => '.woocommerce',
			'property' => '--button-alt--' . $prop . '--focus',
		),
	);
}

return $add;
