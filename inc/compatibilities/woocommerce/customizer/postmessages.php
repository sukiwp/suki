<?php
/**
 * Customizer & Front-End modification rules for WooCommerce.
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$add = array();

/**
 * ====================================================
 * General Elements > Body (Base)
 * ====================================================
 */

$add['body_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce nav.woocommerce-pagination ul li a, .woocommerce .woocommerce-breadcrumb, .woocommerce .woocommerce-breadcrumb a, .woocommerce div.product .woocommerce-tabs ul.tabs li a, .woocommerce-account .suki-woocommerce-MyAccount-sidebar a',
		'property' => 'color',
	),
);
$add['link_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce .woocommerce-error .button, .woocommerce .woocommerce-info .button, .woocommerce .woocommerce-message .button',
		'property' => 'color',
	),
	array(
		'type'     => 'css',
		'element'  => '.woocommerce nav.woocommerce-pagination ul li a:hover, .woocommerce nav.woocommerce-pagination ul li a:focus, .woocommerce div.product .woocommerce-tabs ul.tabs li a:hover, .woocommerce div.product .woocommerce-tabs ul.tabs li a:focus, .woocommerce .woocommerce-breadcrumb a:hover, .woocommerce .woocommerce-breadcrumb a:focus, .woocommerce-account .suki-woocommerce-MyAccount-sidebar a:hover, .woocommerce-account .suki-woocommerce-MyAccount-sidebar a:focus',
		'property' => 'color',
	),
);
$add['link_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce .woocommerce-error .button:hover, .woocommerce .woocommerce-error .button:focus, .woocommerce .woocommerce-info .button:hover, .woocommerce .woocommerce-info .button:focus, .woocommerce .woocommerce-message .button:hover, .woocommerce .woocommerce-message .button:focus',
		'property' => 'color',
	),
);
$add['subtle_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce .woocommerce-error, .woocommerce .woocommerce-info, .woocommerce .woocommerce-message, #add_payment_method #payment ul.payment_methods li, .woocommerce-cart #payment ul.payment_methods li, .woocommerce-checkout #payment ul.payment_methods li',
		'property' => 'background-color',
	),
);

/**
 * ====================================================
 * General Elements > Headings
 * ====================================================
 */

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$add['h3_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => '.woocommerce div.product .woocommerce-tabs .panel > h2:first-child, .woocommerce div.product .woocommerce-tabs #reviews #comments > h2, .woocommerce div.product .products h2, .woocommerce .cart-collaterals h2, .woocommerce .checkout h3',
			'property' => str_replace( '_', '-', $prop),
		),
	);
}
$add['heading_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce div.product #reviews #comments ol.commentlist li .comment-text p.meta .woocommerce-review__author, .woocommerce div.product #reviews #comments ol.commentlist li .comment-text p.meta .woocommerce-review__author a, .woocommerce div.product p.price, .woocommerce div.product span.price, .woocommerce div.product .woocommerce-tabs ul.tabs li.active a, .woocommerce-account .woocommerce-MyAccount-navigation li.is-active a',
		'property' => 'color',
	),
);
$add['heading_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce div.product #reviews #comments ol.commentlist li .comment-text p.meta .woocommerce-review__author a:hover, .woocommerce div.product #reviews #comments ol.commentlist li .comment-text p.meta .woocommerce-review__author a:focus',
		'property' => 'color',
	),
);

/**
 * ====================================================
 * General Elements > Small Title
 * ====================================================
 */

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$add['small_title_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => '.woocommerce div.product .woocommerce-tabs .panel > h2:first-child, .woocommerce div.product .woocommerce-tabs #reviews #comments > h2, .woocommerce div.product .products h2, .woocommerce .cart-collaterals h2, .woocommerce .checkout h3',
			'property' => str_replace( '_', '-', $prop),
		),
	);
}
$add['small_title_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce div.product .woocommerce-tabs .panel > h2:first-child, .woocommerce div.product .woocommerce-tabs #reviews #comments > h2, .woocommerce div.product .related.products h2, .woocommerce .cart-collaterals h2, .woocommerce .checkout h3',
		'property' => 'color',
	),
);

/**
 * ====================================================
 * General Elements > Meta Info
 * ====================================================
 */

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$add['meta_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => '.woocommerce div.product .woocommerce-product-rating, .woocommerce div.product .product_meta, .woocommerce #reviews #comments ol.commentlist li .comment-text .woocommerce-review__published-date',
			'property' => str_replace( '_', '-', $prop),
		),
	);
}
$add['meta_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce nav.woocommerce-pagination ul li span.current, .woocommerce div.product .product_meta, .woocommerce #reviews #comments ol.commentlist li .comment-text .woocommerce-review__published-date',
		'property' => 'color',
	),
);
$add['meta_link_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce div.product .woocommerce-product-rating a, .woocommerce div.product .product_meta a',
		'property' => 'color',
	),
);
$add['meta_link_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce div.product .woocommerce-product-rating a:hover, .woocommerce div.product .woocommerce-product-rating a:focus, .woocommerce div.product .product_meta a:hover, .woocommerce div.product .product_meta a:focus',
		'property' => 'color',
	),
);

/**
 * ====================================================
 * General Elements > Form Input
 * ====================================================
 */

$add['input_padding'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce table.cart td.actions .coupon .input-text, .woocommerce #content table.cart td.actions .coupon .input-text, .woocommerce-page table.cart td.actions .coupon .input-text, .woocommerce-page #content table.cart td.actions .coupon .input-text',
		'property' => 'padding',
	),
);
$add['input_border'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce table.cart td.actions .coupon .input-text, .woocommerce #content table.cart td.actions .coupon .input-text, .woocommerce-page table.cart td.actions .coupon .input-text, .woocommerce-page #content table.cart td.actions .coupon .input-text',
		'property' => 'border-width',
	),
);
$add['input_border_radius' ] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce table.cart td.actions .coupon .input-text, .woocommerce #content table.cart td.actions .coupon .input-text, .woocommerce-page table.cart td.actions .coupon .input-text, .woocommerce-page #content table.cart td.actions .coupon .input-text',
		'property' => 'border-radius',
	),
);
foreach ( array( 'bg' => 'background-color', 'border' => 'border-color', 'text' => 'color' ) as $key => $prop ) {
	$add['input_' . $key . '_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.woocommerce table.cart td.actions .coupon .input-text, .woocommerce #content table.cart td.actions .coupon .input-text, .woocommerce-page table.cart td.actions .coupon .input-text, .woocommerce-page #content table.cart td.actions .coupon .input-text',
			'property' => $prop,
		),
	);
}
foreach ( array( 'bg' => 'background-color', 'border' => 'border-color', 'text' => 'color' ) as $key => $prop ) {
	$add['input_focus_' . $key . '_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.woocommerce table.cart td.actions .coupon .input-text, .woocommerce #content table.cart td.actions .coupon .input-text, .woocommerce-page table.cart td.actions .coupon .input-text, .woocommerce-page #content table.cart td.actions .coupon .input-text:focus',
			'property' => $prop,
		),
	);
}

/**
 * ====================================================
 * General Elements > Button
 * ====================================================
 */

$add['button_padding'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce #respond input#submit, .woocommerce #respond input#submit.disabled, .woocommerce #respond input#submit:disabled, .woocommerce #respond input#submit:disabled[disabled], .woocommerce #respond input#submit.alt, .woocommerce #respond input#submit.alt.disabled, .woocommerce #respond input#submit.alt:disabled, .woocommerce #respond input#submit.alt:disabled[disabled], .woocommerce a.button, .woocommerce a.button.disabled, .woocommerce a.button:disabled, .woocommerce a.button:disabled[disabled], .woocommerce a.button.alt, .woocommerce a.button.alt.disabled, .woocommerce a.button.alt:disabled, .woocommerce a.button.alt:disabled[disabled], .woocommerce button.button, .woocommerce button.button.disabled, .woocommerce button.button:disabled, .woocommerce button.button:disabled[disabled], .woocommerce button.button.alt, .woocommerce button.button.alt.disabled, .woocommerce button.button.alt:disabled, .woocommerce button.button.alt:disabled[disabled], .woocommerce input.button, .woocommerce input.button.disabled, .woocommerce input.button:disabled, .woocommerce input.button:disabled[disabled], .woocommerce input.button.alt, .woocommerce input.button.alt.disabled, .woocommerce input.button.alt:disabled, .woocommerce input.button.alt:disabled[disabled]',
		'property' => 'padding',
	),
	array(
		'type'     => 'css',
		'element'  => '.woocommerce-cart .wc-proceed-to-checkout a.checkout-button, .woocommerce #payment #place_order, .woocommerce-page #payment #place_order',
		'property' => 'padding',
		'function' => array(
			'name' => 'scale_dimensions',
			'args' => array( 1.3 ),
		),
	),
);
$add['button_border'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce #respond input#submit, .woocommerce #respond input#submit.disabled, .woocommerce #respond input#submit:disabled, .woocommerce #respond input#submit:disabled[disabled], .woocommerce #respond input#submit.alt, .woocommerce #respond input#submit.alt.disabled, .woocommerce #respond input#submit.alt:disabled, .woocommerce #respond input#submit.alt:disabled[disabled], .woocommerce a.button, .woocommerce a.button.disabled, .woocommerce a.button:disabled, .woocommerce a.button:disabled[disabled], .woocommerce a.button.alt, .woocommerce a.button.alt.disabled, .woocommerce a.button.alt:disabled, .woocommerce a.button.alt:disabled[disabled], .woocommerce button.button, .woocommerce button.button.disabled, .woocommerce button.button:disabled, .woocommerce button.button:disabled[disabled], .woocommerce button.button.alt, .woocommerce button.button.alt.disabled, .woocommerce button.button.alt:disabled, .woocommerce button.button.alt:disabled[disabled], .woocommerce input.button, .woocommerce input.button.disabled, .woocommerce input.button:disabled, .woocommerce input.button:disabled[disabled], .woocommerce input.button.alt, .woocommerce input.button.alt.disabled, .woocommerce input.button.alt:disabled, .woocommerce input.button.alt:disabled[disabled]',
		'property' => 'border-width',
	),
);
$add['button_border_radius'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce #respond input#submit, .woocommerce #respond input#submit.disabled, .woocommerce #respond input#submit:disabled, .woocommerce #respond input#submit:disabled[disabled], .woocommerce #respond input#submit.alt, .woocommerce #respond input#submit.alt.disabled, .woocommerce #respond input#submit.alt:disabled, .woocommerce #respond input#submit.alt:disabled[disabled], .woocommerce a.button, .woocommerce a.button.disabled, .woocommerce a.button:disabled, .woocommerce a.button:disabled[disabled], .woocommerce a.button.alt, .woocommerce a.button.alt.disabled, .woocommerce a.button.alt:disabled, .woocommerce a.button.alt:disabled[disabled], .woocommerce button.button, .woocommerce button.button.disabled, .woocommerce button.button:disabled, .woocommerce button.button:disabled[disabled], .woocommerce button.button.alt, .woocommerce button.button.alt.disabled, .woocommerce button.button.alt:disabled, .woocommerce button.button.alt:disabled[disabled], .woocommerce input.button, .woocommerce input.button.disabled, .woocommerce input.button:disabled, .woocommerce input.button:disabled[disabled], .woocommerce input.button.alt, .woocommerce input.button.alt.disabled, .woocommerce input.button.alt:disabled, .woocommerce input.button.alt:disabled[disabled]',
		'property' => 'border-radius',
	),
);
foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'letter_spacing' ) as $prop ) {
	$property = str_replace( '_', '-', $prop );
	$array = array();

	$array[] = array(
		'type'     => 'font_family' === $prop ? 'font' : 'css',
		'element'  => '.woocommerce #respond input#submit, .woocommerce #respond input#submit.disabled, .woocommerce #respond input#submit:disabled, .woocommerce #respond input#submit:disabled[disabled], .woocommerce #respond input#submit.alt, .woocommerce #respond input#submit.alt.disabled, .woocommerce #respond input#submit.alt:disabled, .woocommerce #respond input#submit.alt:disabled[disabled], .woocommerce a.button, .woocommerce a.button.disabled, .woocommerce a.button:disabled, .woocommerce a.button:disabled[disabled], .woocommerce a.button.alt, .woocommerce a.button.alt.disabled, .woocommerce a.button.alt:disabled, .woocommerce a.button.alt:disabled[disabled], .woocommerce button.button, .woocommerce button.button.disabled, .woocommerce button.button:disabled, .woocommerce button.button:disabled[disabled], .woocommerce button.button.alt, .woocommerce button.button.alt.disabled, .woocommerce button.button.alt:disabled, .woocommerce button.button.alt:disabled[disabled], .woocommerce input.button, .woocommerce input.button.disabled, .woocommerce input.button:disabled, .woocommerce input.button:disabled[disabled], .woocommerce input.button.alt, .woocommerce input.button.alt.disabled, .woocommerce input.button.alt:disabled, .woocommerce input.button.alt:disabled[disabled]',
		'property' => $property,
	);

	// Large button
	if ( in_array( $prop, array( 'font_size', 'letter_spacing' ) ) ) {
		$array[] = array(
			'type'     => 'css',
			'element'  => '.woocommerce-cart .wc-proceed-to-checkout a.checkout-button, .woocommerce #payment #place_order, .woocommerce-page #payment #place_order',
			'property' => $property,
			'function' => array(
				'name' => 'scale_dimensions',
				'args' => array( 1.15 ),
			),
		);
	}

	$add['button_' . $prop ] = $array;
}

foreach ( array( 'bg' => 'background-color', 'border' => 'border-color', 'text' => 'color' ) as $key => $prop ) {
	$add['button_' . $key . '_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.woocommerce #respond input#submit, .woocommerce #respond input#submit.disabled, .woocommerce #respond input#submit:disabled, .woocommerce #respond input#submit:disabled[disabled], .woocommerce #respond input#submit.alt, .woocommerce #respond input#submit.alt.disabled, .woocommerce #respond input#submit.alt:disabled, .woocommerce #respond input#submit.alt:disabled[disabled], .woocommerce a.button, .woocommerce a.button.disabled, .woocommerce a.button:disabled, .woocommerce a.button:disabled[disabled], .woocommerce a.button.alt, .woocommerce a.button.alt.disabled, .woocommerce a.button.alt:disabled, .woocommerce a.button.alt:disabled[disabled], .woocommerce button.button, .woocommerce button.button.disabled, .woocommerce button.button:disabled, .woocommerce button.button:disabled[disabled], .woocommerce button.button.alt, .woocommerce button.button.alt.disabled, .woocommerce button.button.alt:disabled, .woocommerce button.button.alt:disabled[disabled], .woocommerce input.button, .woocommerce input.button.disabled, .woocommerce input.button:disabled, .woocommerce input.button:disabled[disabled], .woocommerce input.button.alt, .woocommerce input.button.alt.disabled, .woocommerce input.button.alt:disabled, .woocommerce input.button.alt:disabled[disabled]',
			'property' => $prop,
		),
	);
}
foreach ( array( 'bg' => 'background-color', 'border' => 'border-color', 'text' => 'color' ) as $key => $prop ) {
	$add['button_hover_' . $key . '_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.woocommerce #respond input#submit:hover, .woocommerce #respond input#submit:focus, .woocommerce #respond input#submit.disabled:hover, .woocommerce #respond input#submit.disabled:focus, .woocommerce #respond input#submit:disabled:hover, .woocommerce #respond input#submit:disabled:focus, .woocommerce #respond input#submit:disabled[disabled]:hover, .woocommerce #respond input#submit:disabled[disabled]:focus, .woocommerce #respond input#submit.alt:hover, .woocommerce #respond input#submit.alt:focus, .woocommerce #respond input#submit.alt.disabled:hover, .woocommerce #respond input#submit.alt.disabled:focus, .woocommerce #respond input#submit.alt:disabled:hover, .woocommerce #respond input#submit.alt:disabled:focus, .woocommerce #respond input#submit.alt:disabled[disabled]:hover, .woocommerce #respond input#submit.alt:disabled[disabled]:focus, .woocommerce a.button:hover, .woocommerce a.button:focus, .woocommerce a.button.disabled:hover, .woocommerce a.button.disabled:focus, .woocommerce a.button:disabled:hover, .woocommerce a.button:disabled:focus, .woocommerce a.button:disabled[disabled]:hover, .woocommerce a.button:disabled[disabled]:focus, .woocommerce a.button.alt:hover, .woocommerce a.button.alt:focus, .woocommerce a.button.alt.disabled:hover, .woocommerce a.button.alt.disabled:focus, .woocommerce a.button.alt:disabled:hover, .woocommerce a.button.alt:disabled:focus, .woocommerce a.button.alt:disabled[disabled]:hover, .woocommerce a.button.alt:disabled[disabled]:focus, .woocommerce button.button:hover, .woocommerce button.button:focus, .woocommerce button.button.disabled:hover, .woocommerce button.button.disabled:focus, .woocommerce button.button:disabled:hover, .woocommerce button.button:disabled:focus, .woocommerce button.button:disabled[disabled]:hover, .woocommerce button.button:disabled[disabled]:focus, .woocommerce button.button.alt:hover, .woocommerce button.button.alt:focus, .woocommerce button.button.alt.disabled:hover, .woocommerce button.button.alt.disabled:focus, .woocommerce button.button.alt:disabled:hover, .woocommerce button.button.alt:disabled:focus, .woocommerce button.button.alt:disabled[disabled]:hover, .woocommerce button.button.alt:disabled[disabled]:focus, .woocommerce input.button:hover, .woocommerce input.button:focus, .woocommerce input.button.disabled:hover, .woocommerce input.button.disabled:focus, .woocommerce input.button:disabled:hover, .woocommerce input.button:disabled:focus, .woocommerce input.button:disabled[disabled]:hover, .woocommerce input.button:disabled[disabled]:focus, .woocommerce input.button.alt:hover, .woocommerce input.button.alt:focus, .woocommerce input.button.alt.disabled:hover, .woocommerce input.button.alt.disabled:focus, .woocommerce input.button.alt:disabled:hover, .woocommerce input.button.alt:disabled:focus, .woocommerce input.button.alt:disabled[disabled]:hover, .woocommerce input.button.alt:disabled[disabled]:focus',
			'property' => $prop,
		),
	);
}

/**
 * ====================================================
 * Content & Sidebar > Sidebar Area
 * ====================================================
 */

$add['sidebar_gap'] = array(
	array(
		'type'     => 'css',
		'element'  => '.ltr .suki-woocommerce-checkout-2-columns .suki-woocommerce-checkout-col-2',
		'property' => 'margin-left',
		'media'    => '@media screen and (min-width: 1024px)',
	),
	array(
		'type'     => 'css',
		'element'  => '.rtl .suki-woocommerce-checkout-2-columns .suki-woocommerce-checkout-col-2',
		'property' => 'margin-right',
		'media'    => '@media screen and (min-width: 1024px)',
	),
);

$add['sidebar_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce.widget_price_filter .price_slider',
		'property' => 'color',
	),
);

/**
 * ====================================================
 * WooCommerce > Store Notice
 * ====================================================
 */

$add['woocommerce_demo_store_notice_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce-store-notice, p.demo_store',
		'property' => 'background-color',
	),
);
$add['woocommerce_demo_store_notice_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce-store-notice, p.demo_store, .woocommerce-store-notice a, p.demo_store a',
		'property' => 'color',
	),
);

/**
 * ====================================================
 * WooCommerce > Shop (Catalog) Page
 * ====================================================
 */

$add['woocommerce_products_grid_columns_gutter'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce ul.products li.product',
		'property' => 'padding',
		'pattern'  => '0 $',
	),
	array(
		'type'     => 'css',
		'element'  => '.woocommerce ul.products',
		'property' => 'margin',
		'pattern'  => '0 -$',
	),
);
$add['woocommerce_products_grid_text_alignment'] = array(
	array(
		'type'     => 'class',
		'element'  => '.woocommerce ul.products',
		'pattern'  => 'suki-text-align-$',
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
		'element'  => '.woocommerce #content div.product div.images, .woocommerce div.product div.images, .woocommerce-page #content div.product div.images, .woocommerce-page div.product div.images',
		'property' => 'width',
	),
	array(
		'type'     => 'css',
		'element'  => '.woocommerce #content div.product div.images, .woocommerce div.product div.images, .woocommerce-page #content div.product div.images, .woocommerce-page div.product div.images',
		'property' => 'min-width',
	),
);

$add['woocommerce_single_gallery_gap'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce #content div.product div.images, .woocommerce div.product div.images, .woocommerce-page #content div.product div.images, .woocommerce-page div.product div.images',
		'property' => 'margin-right',
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
	array(
		'type'     => 'css',
		'element'  => '.woocommerce span.onsale:before, .woocommerce span.onsale:after',
		'property' => 'border-color',
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
		'element'  => '.woocommerce .star-rating:before, .woocommerce .star-rating span:before, .woocommerce p.stars a',
		'property' => 'color',
	),
);

foreach ( array( 'bg' => 'background-color', 'border' => 'border-color', 'text' => 'color' ) as $key => $prop ) {
	$add['woocommerce_alt_button_' . $key . '_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt',
			'property' => $prop,
		),
		array(
			'type'     => 'css',
			'element'  => '.woocommerce #respond input#submit.alt.disabled, .woocommerce #respond input#submit.alt:disabled, .woocommerce #respond input#submit.alt:disabled[disabled], .woocommerce a.button.alt.disabled, .woocommerce a.button.alt:disabled, .woocommerce a.button.alt:disabled[disabled], .woocommerce button.button.alt.disabled, .woocommerce button.button.alt:disabled, .woocommerce button.button.alt:disabled[disabled], .woocommerce input.button.alt.disabled, .woocommerce input.button.alt:disabled, .woocommerce input.button.alt:disabled[disabled]',
			'property' => $prop,
		),
	);
}
foreach ( array( 'bg' => 'background-color', 'border' => 'border-color', 'text' => 'color' ) as $key => $prop ) {
	$add['woocommerce_alt_button_hover_' . $key . '_color'] = array(
				array(
			'type'     => 'css',
			'element'  => '.woocommerce #respond input#submit.alt:hover, .woocommerce #respond input#submit.alt:focus, .woocommerce a.button.alt:hover, woocommerce a.button.alt:focus, .woocommerce button.button.alt:hover, .woocommerce button.button.alt:focus, .woocommerce input.button.alt:hover, .woocommerce input.button.alt:focus',
			'property' => $prop,
		),
		array(
			'type'     => 'css',
			'element'  => '.woocommerce #respond input#submit.alt.disabled:hover, .woocommerce #respond input#submit.alt.disabled:focus, .woocommerce #respond input#submit.alt:disabled:hover, .woocommerce #respond input#submit.alt:disabled:focus, .woocommerce #respond input#submit.alt:disabled[disabled]:hover, .woocommerce #respond input#submit.alt:disabled[disabled]:focus, .woocommerce a.button.alt.disabled:hover, .woocommerce a.button.alt.disabled:focus, .woocommerce a.button.alt:disabled:hover, .woocommerce a.button.alt:disabled:focus, .woocommerce a.button.alt:disabled[disabled]:hover, .woocommerce a.button.alt:disabled[disabled]:focus, .woocommerce button.button.alt.disabled:hover, .woocommerce button.button.alt.disabled:focus, .woocommerce button.button.alt:disabled:hover, .woocommerce button.button.alt:disabled:focus, .woocommerce button.button.alt:disabled[disabled]:hover, .woocommerce button.button.alt:disabled[disabled]:focus, .woocommerce input.button.alt.disabled:hover, .woocommerce input.button.alt.disabled:focus, .woocommerce input.button.alt:disabled:hover, .woocommerce input.button.alt:disabled:focus, .woocommerce input.button.alt:disabled[disabled]:hover, .woocommerce input.button.alt:disabled[disabled]:focus',
			'property' => $prop,
		),
	);
}

$postmessages = array_merge_recursive( $postmessages, $add );