<?php
/**
 * Customizer settings: WooCommerce > Cart
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'woocommerce_cart'; // Assumed

/**
 * ====================================================
 * Layout
 * ====================================================
 */

// Heading: Layout
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_woocommerce_cart_layout', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Layout', 'suki' ),
	'priority'    => 10,
) ) );

// Layout
$key = 'woocommerce_cart_layout';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_RadioImage( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Layout', 'suki' ),
	'choices'     => array(
		'default' => array(
			'label' => esc_html__( 'Default', 'suki' ),
			'image' => SUKI_IMAGES_URL . '/customizer/woocommerce-cart-layout--default.svg',
		),
		'2-columns' => array(
			'label' => esc_html__( '2 Columns', 'suki' ),
			'image' => SUKI_IMAGES_URL . '/customizer/woocommerce-cart-layout--2-columns.svg',
		),
	),
	'priority'    => 10,
) ) );

// ------
$wp_customize->add_control( new Suki_Customize_Control_HR( $wp_customize, 'hr_woocommerce_cart_cross_sells', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 20,
) ) );

// Cross-sells
$key = 'woocommerce_cart_cross_sells';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Show cross-sells', 'suki' ),
	'description' => esc_html__( 'Display cross-sells as configured on Edit Product page > Product Data > Linked Products > Cross-sells.', 'suki' ),
	'priority'    => 20,
) ) );

// Cross-sells grid columns
$key = 'woocommerce_cart_cross_sells_grid_columns';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Cross-sells grid columns', 'suki' ),
	'units'       => array(
		'' => array(
			'min'  => 1,
			'max'  => 6,
			'step' => 1,
			'label' => 'col',

		),
	),
	'priority'    => 20,
) ) );

/**
 * ====================================================
 * Suki Pro Upsell
 * ====================================================
 */

if ( suki_show_pro_teaser() ) {
	$wp_customize->add_control( new Suki_Customize_Control_Pro_Teaser( $wp_customize, 'pro_teaser_woocommerce_cart', array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => esc_html_x( 'More Options Available', 'Suki Pro upsell', 'suki' ),
		'url'         => esc_url( add_query_arg( array( 'utm_source' => 'suki-customizer', 'utm_medium' => 'learn-more', 'utm_campaign' => 'theme-upsell' ), SUKI_PRO_URL ) ),
		'features'    => array(
			esc_html_x( 'Sticky Checkout Button on Mobile', 'Suki Pro upsell', 'suki' ),
		),
		'priority'    => 90,
	) ) );
}