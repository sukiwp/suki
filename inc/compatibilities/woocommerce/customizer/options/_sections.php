<?php
/**
 * Customizer sections: WooComerce
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

// Panel
$panel = 'woocommerce';
$wp_customize->get_panel( $panel )->priority = 182;

// Store Notice
$wp_customize->get_section( 'woocommerce_store_notice' )->priority = 1;

// ------
$wp_customize->add_section( new Suki_Customize_Section_Spacer( $wp_customize, 'suki_section_spacer_woocommerce_pages', array(
	'panel'       => $panel,
	'priority'    => 9,
) ) );

// Single Product
$wp_customize->add_section( 'woocommerce_product_single', array(
	'title'       => esc_html__( 'Single Product', 'suki' ),
	'panel'       => $panel,
	'priority'    => 11, // Place it under the 'Product Catalog' section
) );

// Shopping Cart
$wp_customize->add_section( 'woocommerce_cart', array(
	'title'       => esc_html__( 'Shopping Cart', 'suki' ),
	'panel'       => $panel,
	'priority'    => 19, // Place it under the 'Product Catalog' section
) );

// Checkout
$wp_customize->get_section( 'woocommerce_checkout' )->priority = 20;

// ------
$wp_customize->add_section( new Suki_Customize_Section_Spacer( $wp_customize, 'suki_section_spacer_woocommerce_others', array(
	'panel'       => $panel,
	'priority'    => 80,
) ) );

// Product Images
$wp_customize->get_section( 'woocommerce_product_images' )->priority = 81;

// Other Elements
$wp_customize->add_section( 'woocommerce_products_grid', array(
	'title'       => esc_html__( 'Products Grid', 'suki' ),
	'description' => esc_html__( 'Global styles for products grid as used in main product catalog page, related products, up-sells, cross-sells, and products shortcodes.', 'suki' ),
	'panel'       => $panel,
	'priority'    => 89,
) );

// Other Elements
$wp_customize->add_section( 'suki_section_woocommerce_elements', array(
	'title'       => esc_html__( 'Other Elements', 'suki' ),
	'panel'       => $panel,
	'priority'    => 90,
) );