<?php
/**
 * Customizer settings: WooCommerce > Products Grid
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'woocommerce_products_grid';

/**
 * ====================================================
 * Layout
 * ====================================================
 */

// Grid columns gutter
$id = 'woocommerce_products_grid_columns_gutter';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'slider' ),
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

// ------
$wp_customize->add_control( new Suki_Customize_Control_HR( $wp_customize, 'hr_woocommerce_products_grid_add_to_cart', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 10,
) ) );

// Product Add to cart
$id = 'woocommerce_products_grid_item_add_to_cart';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Show "add to cart"', 'suki' ),
	'priority'    => 10,
) ) );

/**
 * ====================================================
 * Suki Pro Upsell
 * ====================================================
 */

if ( suki_show_pro_teaser() ) {
	$wp_customize->add_control( new Suki_Customize_Control_Pro_Teaser( $wp_customize, 'pro_teaser_woocommerce_index', array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => esc_html_x( 'More Options on Suki Pro', 'Suki Pro upsell', 'suki' ),
		'url'         => SUKI_PRO_URL,
		'features'    => array(
			esc_html_x( 'More typography options', 'Suki Pro upsell', 'suki' ),
			esc_html_x( 'More products grid item styles', 'Suki Pro upsell', 'suki' ),
		),
		'priority'    => 90,
	) ) );
}