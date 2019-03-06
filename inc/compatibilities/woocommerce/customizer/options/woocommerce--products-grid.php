<?php
/**
 * Customizer settings: WooCommerce > Products Grid
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'woocommerce_products_grid';

// Grid columns gutter
$id = 'woocommerce_products_grid_columns_gutter';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Grid columns gutter', 'suki' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'max'  => 40,
			'step' => 1,
		),
	),
	'priority'    => 10,
) ) );

/**
 * ====================================================
 * Grid Item
 * ====================================================
 */

// Heading: Grid Item
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_woocommerce_products_grid_item', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Grid Item', 'suki-pro' ),
	'priority'    => 20,
) ) );

// Text alignment
$id = 'woocommerce_products_grid_text_alignment';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $id, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Text alignment', 'suki' ),
	'choices'     => array(
		'left'   => is_rtl() ? esc_html__( 'Right', 'suki' ) : esc_html__( 'Left', 'suki' ),
		'center' => esc_html__( 'Center', 'suki' ),
		'right'  => is_rtl() ? esc_html__( 'Left', 'suki' ) : esc_html__( 'Right', 'suki' ),
	),
	'priority'    => 20,
) );

/**
 * ====================================================
 * Add to Cart
 * ====================================================
 */

// Heading: Add to Cart
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_woocommerce_products_grid_item_add_to_cart', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Add to Cart', 'suki' ),
	'priority'    => 50,
) ) );

// Show "add to cart" button
$id = 'woocommerce_products_grid_item_add_to_cart';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Show "add to cart" button', 'suki' ),
	'priority'    => 50,
) ) );

/**
 * ====================================================
 * Suki Pro Upsell
 * ====================================================
 */

if ( suki_show_pro_teaser() ) {
	$wp_customize->add_control( new Suki_Customize_Control_Pro_Teaser( $wp_customize, 'pro_teaser_woocommerce_products_grid', array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => esc_html_x( 'More Options on Suki Pro', 'Suki Pro upsell', 'suki' ),
		'url'         => SUKI_PRO_URL,
		'features'    => array(
			esc_html_x( 'Change grid item\'s style', 'Suki Pro upsell', 'suki' ),
			esc_html_x( 'Enable alternate hover image', 'Suki Pro upsell', 'suki' ),
			esc_html_x( 'Enable quick view popup', 'Suki Pro upsell', 'suki' ),
		),
		'priority'    => 90,
	) ) );
}