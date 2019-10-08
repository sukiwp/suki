<?php
/**
 * Customizer settings: WooCommerce > Products Grid
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'woocommerce_products_grid';

// Rows gutter
$key = 'woocommerce_products_grid_rows_gutter';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Rows gutter', 'suki' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'max'  => 40,
			'step' => 1,
		),
		'em' => array(
			'min'  => 0,
			'max'  => 3,
			'step' => 0.05,
		),
	),
	'priority'    => 10,
) ) );

// Columns gutter
$key = 'woocommerce_products_grid_columns_gutter';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Columns gutter', 'suki' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'max'  => 40,
			'step' => 1,
		),
		'em' => array(
			'min'  => 0,
			'max'  => 3,
			'step' => 0.05,
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
	'label'       => esc_html__( 'Grid Item', 'suki' ),
	'priority'    => 20,
) ) );

// Alignment
$key = 'woocommerce_products_grid_text_alignment';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Alignment', 'suki' ),
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
$key = 'woocommerce_products_grid_item_add_to_cart';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $key, array(
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
		'label'       => esc_html_x( 'More Options Available', 'Suki Pro upsell', 'suki' ),
		'url'         => esc_url( add_query_arg( array( 'utm_source' => 'suki-customizer', 'utm_medium' => 'learn-more', 'utm_campaign' => 'theme-upsell' ), SUKI_PRO_URL ) ),
		'features'    => array(
			esc_html_x( 'Grid Item\'s Styles', 'Suki Pro upsell', 'suki' ),
			esc_html_x( 'Product Quick View Popup', 'Suki Pro upsell', 'suki' ),
			esc_html_x( 'Alternate Hover Image', 'Suki Pro upsell', 'suki' ),
		),
		'priority'    => 90,
	) ) );
}