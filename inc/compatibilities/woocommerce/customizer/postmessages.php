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
 * General Styles > Border & Subtle Background
 * ====================================================
 */

$add['subtle_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce .woocommerce-error, .woocommerce .woocommerce-info, .woocommerce .woocommerce-message, .woocommerce table.shop_attributes tr:nth-child(even) th, .woocommerce table.shop_attributes tr:nth-child(even) td, #add_payment_method #payment ul.payment_methods li, .woocommerce-cart #payment ul.payment_methods li, .woocommerce-checkout #payment ul.payment_methods li, .woocommerce nav.woocommerce-pagination ul li span.current, .woocommerce ul.order_details li, .woocommerce-account ol.commentlist.notes li.note',
		'property' => 'background-color',
	),
);

/**
 * ====================================================
 * General Styles > Link
 * ====================================================
 */

$add['link_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce .woocommerce-error .button, .woocommerce .woocommerce-info .button, .woocommerce .woocommerce-message .button, .woocommerce nav.woocommerce-pagination ul li a:hover, .woocommerce nav.woocommerce-pagination ul li a:focus, .woocommerce div.product .woocommerce-tabs ul.tabs li a:hover, .woocommerce div.product .woocommerce-tabs ul.tabs li a:focus, .woocommerce .woocommerce-breadcrumb a:hover, .woocommerce .woocommerce-breadcrumb a:focus, .woocommerce-account .suki-woocommerce-MyAccount-sidebar a:hover, .woocommerce-account .suki-woocommerce-MyAccount-sidebar a:focus, .woocommerce ul.products li.product a.woocommerce-loop-product__link:hover, .woocommerce ul.products li.product a.woocommerce-loop-product__link:focus, .woocommerce.widget_layered_nav_filters li a:hover, .woocommerce.widget_layered_nav_filters li a:focus',
		'property' => 'color',
	),
	array(
		'type'     => 'css',
		'element'  => '.woocommerce .star-rating, .woocommerce p.stars a',
		'property' => 'color',
	),
	array(
		'type'     => 'css',
		'element'  => '.woocommerce div.product .woocommerce-product-rating a:hover, .woocommerce div.product .woocommerce-product-rating a:focus, .woocommerce div.product .product_meta a:hover, .woocommerce div.product .product_meta a:focus',
		'property' => 'color',
	),
	array(
		'type'     => 'css',
		'element'  => '.woocommerce span.onsale',
		'property' => 'background-color',
	),
	array(
		'type'     => 'css',
		'element'  => '.woocommerce-store-notice, p.demo_store',
		'property' => 'background-color',
	),
	array(
		'type'     => 'css',
		'element'  => '.woocommerce.widget_layered_nav li.chosen a:before, .woocommerce.widget_rating_filter li.chosen a:before',
		'property' => 'background-color',
	),
	array(
		'type'     => 'css',
		'element'  => '.woocommerce.widget_price_filter .price_slider',
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

/**
 * ====================================================
 * General Styles > Headings
 * ====================================================
 */

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$element = '.woocommerce div.product .woocommerce-tabs .panel > h2:first-child, .woocommerce div.product .woocommerce-tabs #reviews #comments > h2, .woocommerce div.product .products h2, .woocommerce-cart .cross-sells h2, .woocommerce-cart .cart_totals h2, .woocommerce .checkout h3';
	$property = str_replace( '_', '-', $prop);

	$add['h3_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element,
			'property' => $property,
		),
	);

	if ( in_array( $prop, array( 'font_size', 'line_height', 'letter_spacing' ) ) ) {
		$add['h3_' . $prop . '__tablet'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 1023px)',
			),
		);
		$add['h3_' . $prop . '__mobile'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 499px)',
			),
		);
	}
}
$add['heading_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce div.product #reviews #comments ol.commentlist li .comment-text p.meta .woocommerce-review__author, .woocommerce #review_form #respond .comment-reply-title, .woocommerce ul.products li.product a.woocommerce-loop-product__link, .woocommerce div.product #reviews #comments ol.commentlist li .comment-text p.meta .woocommerce-review__author a, .woocommerce div.product p.price, .woocommerce div.product span.price, .woocommerce div.product .woocommerce-tabs ul.tabs li.active a, .woocommerce-account .woocommerce-MyAccount-navigation li.is-active a, .woocommerce nav.woocommerce-pagination ul li span.current',
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
 * General Styles > Small Title
 * ====================================================
 */

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$element = '.woocommerce div.product .woocommerce-tabs .panel > h2:first-child, .woocommerce div.product .woocommerce-tabs #reviews #comments > h2, .woocommerce div.product .products h2, .woocommerce-cart .cross-sells h2, .woocommerce-cart .cart_totals h2, .woocommerce .checkout h3';
	$property = str_replace( '_', '-', $prop);

	$add['small_title_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element,
			'property' => $property,
		),
	);

	if ( in_array( $prop, array( 'font_size', 'line_height', 'letter_spacing' ) ) ) {
		$add['small_title_' . $prop . '__tablet'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 1023px)',
			),
		);
		$add['small_title_' . $prop . '__mobile'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 499px)',
			),
		);
	}
}
$add['small_title_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce div.product .woocommerce-tabs .panel > h2:first-child, .woocommerce div.product .woocommerce-tabs #reviews #comments > h2, .woocommerce div.product .related.products h2, .woocommerce-cart .cross-sells h2, .woocommerce-cart .cart_totals h2, .woocommerce .checkout h3',
		'property' => 'color',
	),
);

/**
 * ====================================================
 * General Styles > Meta Info
 * ====================================================
 */

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$element = '.woocommerce div.product .woocommerce-product-rating, .woocommerce div.product .product_meta, .woocommerce #reviews #comments ol.commentlist li .comment-text .woocommerce-review__published-date, .woocommerce-account ol.commentlist.notes li.note p.meta';
	$property = str_replace( '_', '-', $prop);

	$add['meta_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element,
			'property' => $property,
		),
	);

	if ( in_array( $prop, array( 'font_size', 'line_height', 'letter_spacing' ) ) ) {
		$add['meta_' . $prop . '__tablet'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 1023px)',
			),
		);
		$add['meta_' . $prop . '__mobile'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 499px)',
			),
		);
	}
}
$add['meta_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce div.product .woocommerce-product-rating, .woocommerce div.product .product_meta, .woocommerce #reviews #comments ol.commentlist li .comment-text .woocommerce-review__published-date, .woocommerce-account ol.commentlist.notes li.note p.meta',
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
 * General Styles > Button
 * ====================================================
 */

foreach ( array( 'font_size', 'letter_spacing' ) as $prop ) {
	$property = str_replace( '_', '-', $prop );
	$array = array();

	// Large button
	$array[] = array(
		'type'     => 'css',
		'element'  => '.woocommerce-cart .wc-proceed-to-checkout a.checkout-button, .woocommerce #payment #place_order',
		'property' => $property,
		'function' => array(
			'name' => 'scale_dimensions',
			'args' => array( 1.2 ),
		),
	);

	$add['button_' . $prop ] = $array;
}

$add['button_padding'] = array(
	'type'     => 'css',
	'element'  => '.woocommerce-cart .wc-proceed-to-checkout a.checkout-button, .woocommerce #payment #place_order',
	'property' => 'padding',
	'function' => array(
		'name' => 'scale_dimensions',
		'args' => array( 1.4 ),
	),
);

/**
 * ====================================================
 * Content & Sidebar > Sidebar Area
 * ====================================================
 */

$add['sidebar_link_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.sidebar .woocommerce.widget_price_filter .price_slider',
		'property' => 'color',
	),
);

/**
 * ====================================================
 * Footer > Widgets Bar
 * ====================================================
 */

$add['footer_widgets_bar_link_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-widgets-bar .woocommerce.widget_price_filter .price_slider',
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
 * WooCommerce > Products Grid
 * ====================================================
 */

$add['woocommerce_products_grid_rows_gutter'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce ul.products',
		'property' => 'margin-top',
		'pattern'  => '-$',
	),
	array(
		'type'     => 'css',
		'element'  => '.woocommerce ul.products',
		'property' => 'margin-bottom',
		'pattern'  => '-$',
	),
	array(
		'type'     => 'css',
		'element'  => '.woocommerce ul.products li.product',
		'property' => 'padding-top',
	),
	array(
		'type'     => 'css',
		'element'  => '.woocommerce ul.products li.product',
		'property' => 'padding-bottom',
	),
);

$add['woocommerce_products_grid_columns_gutter'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce ul.products',
		'property' => 'margin-left',
		'pattern'  => '-$',
	),
	array(
		'type'     => 'css',
		'element'  => '.woocommerce ul.products',
		'property' => 'margin-right',
		'pattern'  => '-$',
	),
	array(
		'type'     => 'css',
		'element'  => '.woocommerce ul.products li.product',
		'property' => 'padding-left',
	),
	array(
		'type'     => 'css',
		'element'  => '.woocommerce ul.products li.product',
		'property' => 'padding-right',
	),
);
$add['woocommerce_products_grid_text_alignment'] = array(
	array(
		'type'     => 'class',
		'element'  => '.woocommerce ul.products li.product .suki-product-wrapper',
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
		'element'  => '.woocommerce #content div.product div.images, .woocommerce div.product div.images',
		'property' => 'width',
		'media'    => '@media screen and (min-width: 1024px)',
	),
	array(
		'type'     => 'css',
		'element'  => '.woocommerce #content div.product div.images ~ div.summary, .woocommerce div.product div.images ~ div.summary',
		'property' => 'width',
		'pattern'  => 'calc(100% - $)',
		'media'    => '@media screen and (min-width: 1024px)',
	),
);

$add['woocommerce_single_gallery_gap'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce #content div.product div.images ~ div.summary, .woocommerce div.product div.images ~ div.summary',
		'property' => 'padding-left',
		'media'    => '@media screen and (min-width: 1024px)',
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
		'element'  => '.woocommerce .star-rating, .woocommerce p.stars a',
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

return $add;