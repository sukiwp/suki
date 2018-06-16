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
		'element'  => '.woocommerce nav.woocommerce-pagination ul li a, .woocommerce div.product .woocommerce-tabs ul.tabs li a, .woocommerce-account .woocommerce-MyAccount-navigation a',
		'property' => 'color',
	),
);
$add['link_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce .woocommerce-breadcrumb a:hover, .woocommerce .woocommerce-breadcrumb a:focus, .woocommerce nav.woocommerce-pagination ul li a:hover, .woocommerce nav.woocommerce-pagination ul li a:focus, .woocommerce div.product .woocommerce-tabs ul.tabs li.active a, .woocommerce div.product .woocommerce-tabs ul.tabs li a:hover, .woocommerce div.product .woocommerce-tabs ul.tabs li a:focus, .woocommerce-account .woocommerce-MyAccount-navigation a:hover, .woocommerce-account .woocommerce-MyAccount-navigation a:focus',
		'property' => 'color',
	),
	array(
		'type'     => 'css',
		'element'  => '.woocommerce div.product .woocommerce-tabs ul.tabs li.active a, .woocommerce-account .woocommerce-MyAccount-navigation ul li.is-active a',
		'property' => 'border-color',
	),
	array(
		'type'     => 'css',
		'element'  => '.woocommerce .widget_price_filter .ui-slider .ui-slider-range, .woocommerce .widget_price_filter .ui-slider .ui-slider-handle',
		'property' => 'background-color',
	),
	array(
		'type'     => 'css',
		'element'  => '.suki-header-shopping-cart .shopping-cart-count',
		'property' => 'background-color',
	),
);
$add['subtle_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce-error, .woocommerce-info, .woocommerce-message, #add_payment_method #payment, .woocommerce-cart #payment, .woocommerce-checkout #payment',
		'property' => 'background-color',
	),
);

/**
 * ====================================================
 * General Elements > Headings
 * ====================================================
 */

$add['heading_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce div.product #reviews #comments ol.commentlist li .comment-text p.meta .woocommerce-review__author, .woocommerce div.product #reviews #comments ol.commentlist li .comment-text p.meta .woocommerce-review__author a, .woocommerce div.product p.price, .woocommerce div.product span.price',
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
 * General Elements > Titles & Meta
 * ====================================================
 */

$add['entry_title_meta_alignment'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce div.product .products > h2, .woocommerce .cart-collaterals h2',
		'property' => 'text-align',
	),
);
foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$add['title_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => '.woocommerce div.product .product_title',
			'property' => str_replace( '_', '-', $prop),
		),
	);
}
$add['title_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce div.product .product_title',
		'property' => 'color',
	),
);
foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$add['small_title_' . $prop ] = array(
		array(
			'type'     => 'css',
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
foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$add['meta_' . $prop ] = array(
		array(
			'type'     => 'css',
			'element'  => '.woocommerce div.product .woocommerce-product-rating .woocommerce-review-link, .woocommerce div.product .product_meta, .woocommerce #reviews #comments ol.commentlist li .comment-text .woocommerce-review__published-date',
			'property' => str_replace( '_', '-', $prop),
		),
	);
}
$add['meta_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce .woocommerce-breadcrumb, .woocommerce .woocommerce-breadcrumb a, .woocommerce nav.woocommerce-pagination ul li span.current, .woocommerce div.product .woocommerce-product-rating .woocommerce-review-link, .woocommerce div.product .product_meta, .woocommerce div.product .product_meta a, .woocommerce #reviews #comments ol.commentlist li .comment-text .woocommerce-review__published-date',
		'property' => 'color',
	),
);
$add['meta_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce .woocommerce-breadcrumb a:hover, .woocommerce .woocommerce-breadcrumb a:focus, .woocommerce div.product .woocommerce-product-rating .woocommerce-review-link:hover, .woocommerce div.product .woocommerce-product-rating .woocommerce-review-link:focus, .woocommerce div.product .product_meta a:hover, .woocommerce div.product .product_meta a:focus',
		'property' => 'color',
	),
);

/**
 * ====================================================
 * General Elements > Form Inputs
 * ====================================================
 */

$add['input_padding'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce table.cart td.actions .coupon .input-text',
		'property' => 'padding',
	),
);
$add['input_border'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce table.cart td.actions .coupon .input-text',
		'property' => 'border-width',
	),
);
$add['input_border_radius' ] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce table.cart td.actions .coupon .input-text',
		'property' => 'border-radius',
	),
);
foreach ( array( 'bg' => 'background-color', 'border' => 'border-color', 'text' => 'color' ) as $key => $prop ) {
	$add['input_' . $key . '_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.woocommerce table.cart td.actions .coupon .input-text',
			'property' => $prop,
		),
	);
}
foreach ( array( 'bg' => 'background-color', 'border' => 'border-color', 'text' => 'color' ) as $key => $prop ) {
	$add['input_focus_' . $key . '_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.woocommerce table.cart td.actions .coupon .input-text:focus',
			'property' => $prop,
		),
	);
}

/**
 * ====================================================
 * General Elements > Buttons
 * ====================================================
 */

$add['button_padding'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce input.button:disabled[disabled]',
		'property' => 'padding',
	),
	array(
		'type'     => 'css',
		'element'  => '.woocommerce #respond input#submit.disabled, .woocommerce #respond input#submit:disabled, .woocommerce #respond input#submit:disabled[disabled], .woocommerce a.button.disabled, .woocommerce a.button:disabled, .woocommerce a.button:disabled[disabled], .woocommerce button.button.disabled, .woocommerce button.button:disabled, .woocommerce button.button:disabled[disabled], .woocommerce input.button.disabled, .woocommerce input.button:disabled, .woocommerce input.button:disabled[disabled]',
		'property' => 'padding',
	),
	array(
		'type'     => 'css',
		'element'  => '.woocommerce-cart .wc-proceed-to-checkout a.checkout-button',
		'property' => 'padding',
		'function' => array(
			'name' => 'scale_dimensions',
			'args' => array( 1.2 ),
		),
	),
);
$add['button_border'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce input.button:disabled[disabled]',
		'property' => 'border-width',
	),
);
$add['button_border_radius'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce input.button:disabled[disabled]',
		'property' => 'border-radius',
	),
	array(
		'type'     => 'css',
		'element'  => '.woocommerce-cart .wc-proceed-to-checkout a.checkout-button',
		'property' => 'border-radius',
		'function' => array(
			'name' => 'scale_dimensions',
			'args' => array( 1.2 ),
		),
	),
);
foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'letter_spacing' ) as $prop ) {
	$property = str_replace( '_', '-', $prop );
	$array = array();

	$array[] = array(
		'type'     => 'font_family' === $prop ? 'font' : 'css',
		'element'  => '.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce input.button:disabled[disabled]',
		'property' => $property,
	);

	// Large button
	if ( in_array( $prop, array( 'font_size', 'letter_spacing' ) ) ) {
		$array[] = array(
			'type'     => 'css',
			'element'  => '.woocommerce-cart .wc-proceed-to-checkout a.checkout-button',
			'property' => $property,
			'function' => array(
				'name' => 'scale_dimensions',
				'args' => array( 1.2 ),
			),
		);
	}

	$add['button_' . $prop ] = $array;
}

foreach ( array( 'bg' => 'background-color', 'border' => 'border-color', 'text' => 'color' ) as $key => $prop ) {
	$add['button_' . $key . '_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce input.button:disabled, .woocommerce input.button, .woocommerce input.button:disabled[disabled]',
			'property' => $prop,
		),
		array(
			'type'     => 'css',
			'element'  => '.woocommerce #respond input#submit.disabled, .woocommerce #respond input#submit:disabled, .woocommerce #respond input#submit:disabled[disabled], .woocommerce a.button.disabled, .woocommerce a.button:disabled, .woocommerce a.button:disabled[disabled], .woocommerce button.button.disabled, .woocommerce button.button:disabled, .woocommerce button.button:disabled[disabled], .woocommerce input.button.disabled, .woocommerce input.button:disabled, .woocommerce input.button:disabled[disabled]',
			'property' => $prop,
		),
		array(
			'type'     => 'css',
			'element'  => '.woocommerce .widget_shopping_cart .buttons a, .woocommerce.widget_shopping_cart .buttons a',
			'property' => $prop,
		),
	);
}
foreach ( array( 'bg' => 'background-color', 'border' => 'border-color', 'text' => 'color' ) as $key => $prop ) {
	$add['button_hover_' . $key . '_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.woocommerce #respond input#submit:hover, .woocommerce #respond input#submit:focus, .woocommerce a.button:hover, .woocommerce a.button:focus, .woocommerce button.button:hover, .woocommerce button.button:focus, .woocommerce input.button:hover, .woocommerce input.button:focus, .woocommerce input.button:disabled:hover, .woocommerce input.button:disabled:focus, .woocommerce input.button:disabled[disabled]:hover, .woocommerce input.button:disabled[disabled]:focus',
			'property' => $prop,
		),
		array(
			'type'     => 'css',
			'element'  => '.woocommerce #respond input#submit.disabled:hover, .woocommerce #respond input#submit:disabled:hover, .woocommerce #respond input#submit:disabled[disabled]:hover, .woocommerce a.button.disabled:hover, .woocommerce a.button:disabled:hover, .woocommerce a.button:disabled[disabled]:hover, .woocommerce button.button.disabled:hover, .woocommerce button.button:disabled:hover, .woocommerce button.button:disabled[disabled]:hover, .woocommerce input.button.disabled:hover, .woocommerce input.button:disabled:hover, .woocommerce input.button:disabled[disabled]:hover',
			'property' => $prop,
		),
		array(
			'type'     => 'css',
			'element'  => '.woocommerce .widget_shopping_cart .buttons a:hover, .woocommerce .widget_shopping_cart .buttons a:focus, .woocommerce.widget_shopping_cart .buttons a:hover, .woocommerce.widget_shopping_cart .buttons a:focus',
			'property' => $prop,
		),
	);
}

/**
 * ====================================================
 * Content & Sidebar > Main Content
 * ====================================================
 */

$add['content_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce .widget_price_filter .price_slider_wrapper .ui-widget-content',
		'property' => 'background-color',
	),
	array(
		'type'     => 'css',
		'element'  => '.woocommerce table.shop_table, #add_payment_method #payment ul.payment_methods, .woocommerce-cart #payment ul.payment_methods, .woocommerce-checkout #payment ul.payment_methods',
		'property' => 'border-color',
	),
);

/**
 * ====================================================
 * Content & Sidebar > Sidebar
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
 * WooCommerce > Products Catalog
 * ====================================================
 */

$add['woocommerce_index_grid_columns_gap'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce ul.products li.product, .woocommerce-page ul.products li.product',
		'property' => 'padding',
		'pattern'  => '0 $',
	),
	array(
		'type'     => 'css',
		'element'  => '.woocommerce .products ul, .woocommerce ul.products',
		'property' => 'margin',
		'pattern'  => '0 -$',
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

$add['woocommerce_single_up_sells_grid_columns_gap'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce div.product .up_sells.products ul.products li.product',
		'property' => 'padding',
		'pattern'  => '0 $',
	),
	array(
		'type'     => 'css',
		'element'  => '.woocommerce div.product .up_sells.products ul.products',
		'property' => 'margin',
		'pattern'  => '0 -$',
	),
);

$add['woocommerce_single_related_grid_columns_gap'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce div.product .related.products ul.products li.product',
		'property' => 'padding',
		'pattern'  => '0 $',
	),
	array(
		'type'     => 'css',
		'element'  => '.woocommerce div.product .related.products ul.products',
		'property' => 'margin',
		'pattern'  => '0 -$',
	),
);

/**
 * ====================================================
 * WooCommerce > Cart
 * ====================================================
 */

$add['woocommerce_cart_cross_sells_grid_columns_gap'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce .cart-collaterals .cross-sells ul.products li.product, .woocommerce-page .cart-collaterals .cross-sells ul.products li.product',
		'property' => 'padding',
		'pattern'  => '0 $',
	),
	array(
		'type'     => 'css',
		'element'  => '.woocommerce .cart-collaterals .cross-sells ul.products, .woocommerce-page .cart-collaterals .cross-sells ul.products',
		'property' => 'margin',
		'pattern'  => '0 -$',
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
	);
}
foreach ( array( 'bg' => 'background-color', 'border' => 'border-color', 'text' => 'color' ) as $key => $prop ) {
	$add['woocommerce_alt_button_hover_' . $key . '_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.woocommerce #respond input#submit.alt:hover, .woocommerce #respond input#submit.alt:focus, .woocommerce a.button.alt:hover, .woocommerce a.button.alt:focus, .woocommerce button.button.alt:hover, .woocommerce button.button.alt:focus, .woocommerce input.button.alt:hover, .woocommerce input.button.alt:focus',
			'property' => $prop,
		),
	);
}

$postmessages = array_merge_recursive( $postmessages, $add );