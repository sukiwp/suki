<?php
/**
 * Customizer sections: WooComerce
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

// Header Builder -- Cart
$wp_customize->add_section( 'suki_section_header_cart', array(
	'title'       => esc_html__( 'Shopping Cart', 'suki' ),
	'panel'       => 'suki_panel_header',
	'priority'    => 30,
) );

// Panel
$panel = 'woocommerce';
$wp_customize->get_panel( $panel )->priority = 142;

// ------
$wp_customize->add_section( new Suki_Customize_Section_Spacer( $wp_customize, 'suki_section_spacer_woocommerce_pages', array(
	'title'       => esc_html__( 'Pages', 'suki' ),
	'panel'       => $panel,
	'priority'    => 10,
) ) );

// Products Catalog
$wp_customize->get_section( 'woocommerce_product_catalog' )->title = esc_html__( 'Products Catalog Page', 'suki' );
$wp_customize->get_section( 'woocommerce_product_catalog' )->priority = 11;

// Single Product
$wp_customize->add_section( 'woocommerce_product_single', array(
	'title'       => esc_html__( 'Single Product Page', 'suki' ),
	'panel'       => $panel,
	'priority'    => 11, // Place it under the 'Shop (Products Catalog) Page' section
) );

// Cart
$wp_customize->add_section( 'woocommerce_cart', array(
	'title'       => esc_html__( 'Cart Page', 'suki' ),
	'panel'       => $panel,
	'priority'    => 11, // Place it under the 'Shop (Products Catalog) Page' section
) );

// Checkout
$wp_customize->get_section( 'woocommerce_checkout' )->title = esc_html__( 'Checkout Page', 'suki' );
$wp_customize->get_section( 'woocommerce_checkout' )->priority = 12;

// ------
$wp_customize->add_section( new Suki_Customize_Section_Spacer( $wp_customize, 'suki_section_spacer_woocommerce_general', array(
	'title'       => esc_html__( 'General', 'suki' ),
	'panel'       => $panel,
	'priority'    => 20,
) ) );

// General Elements
$wp_customize->add_section( 'suki_section_woocommerce_elements', array(
	'title'       => esc_html__( 'General Elements', 'suki' ),
	'panel'       => $panel,
	'priority'    => 21,
) );

// Breadcrumb
$wp_customize->add_section( 'woocommerce_breadcrumb', array(
	'title'       => esc_html__( 'Breadcrumb', 'suki' ),
	'panel'       => $panel,
	'priority'    => 21,
) );

// Products Grid
$wp_customize->add_section( 'woocommerce_products_grid', array(
	'title'       => esc_html__( 'Products Grid', 'suki' ),
	'description' => esc_html__( 'Global styles for products grid as used in main product catalog page, related products, up-sells, cross-sells, and products shortcodes.', 'suki' ),
	'panel'       => $panel,
	'priority'    => 21,
) );

// Product Images
$wp_customize->get_section( 'woocommerce_product_images' )->priority = 28;

// Store Notice
$wp_customize->get_section( 'woocommerce_store_notice' )->priority = 29;

if ( suki_show_pro_teaser() ) {
	// More Options Available
	$wp_customize->add_section( new Suki_Customize_Section_Pro_Teaser( $wp_customize, 'suki_section_teaser_pro_upsell_woocommerce', array(
		'title'       => esc_html_x( 'More Options Available', 'Suki Pro upsell', 'suki' ),
		'panel'       => $panel,
		'url'         => esc_url( add_query_arg( array( 'utm_source' => 'suki-customizer', 'utm_medium' => 'learn-more', 'utm_campaign' => 'theme-upsell' ), SUKI_PRO_WEBSITE_URL ) ),
		'features'    => array(
			esc_html_x( 'AJAX Add to Cart', 'Suki Pro upsell', 'suki' ),
			esc_html_x( 'Product Alternate Hover Image', 'Suki Pro upsell', 'suki' ),
			esc_html_x( 'Product Quick View Popup', 'Suki Pro upsell', 'suki' ),
			esc_html_x( 'Off-Canvas Filters', 'Suki Pro upsell', 'suki' ),
			esc_html_x( 'Checkout Optimization', 'Suki Pro upsell', 'suki' ),
		),
		'priority'    => 90,
	) ) );
}