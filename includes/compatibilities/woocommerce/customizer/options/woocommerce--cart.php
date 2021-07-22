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
 * Content Layout
 * ====================================================
 */

// Heading: Content Layout
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_woocommerce_cart_layout', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Content Layout', 'suki' ),
	'priority'    => 10,
) ) );

// Cart layout
$key = 'woocommerce_cart_layout';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_RadioImage( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Cart layout', 'suki' ),
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

// 2 columns notice
$wp_customize->add_control( new Suki_Customize_Control_Blank( $wp_customize, 'notice_cart_2_columns', array(
	'section'     => $section,
	'settings'    => array(),
	'description' => '<div class="notice notice-info notice-alt inline"><p>' . esc_html__( 'When using 2 Columns layout, it\'s recommended to set the container width to "Normal" or "Full width" and also hide the sidebar via the "Individual Page Settings" meta box available on the page editor.', 'suki' ) . '</p></div>',
	'priority'    => 11,
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

// Cross-sells position
$key = 'woocommerce_cart_cross_sells_position';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Cross-sells position', 'suki' ),
	'choices'     => array(
		'after_cart_table' => esc_html__( 'Before cart total', 'suki' ),
		'after_cart'       => esc_html__( 'After cart total', 'suki' ),
	),
	'priority'    => 20,
) );

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

// Heading: Individual Page Settings
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_page_settings_woocommerce_cart', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Individual Page Settings', 'suki' ),
	'description' => '<a href="' . esc_url( get_edit_post_link( wc_get_page_id( 'cart' ) ) ) . '" class="button button-secondary">' . esc_html__( 'Go to Page Editor', 'suki' ) . '</a>',
	'priority'    => 100,
) ) );

if ( suki_show_pro_teaser() ) {
	$wp_customize->add_control( new Suki_Customize_Control_Pro_Teaser( $wp_customize, 'pro_teaser_woocommerce_cart', array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => esc_html_x( 'More Options Available in Suki Pro', 'Suki Pro upsell', 'suki' ),
		'url'         => esc_url( add_query_arg( array( 'utm_source' => 'suki-customizer', 'utm_medium' => 'learn-more', 'utm_campaign' => 'theme-upsell' ), SUKI_PRO_WEBSITE_URL ) ),
		'features'    => array(
			esc_html_x( 'Sticky checkout button on mobile', 'Suki Pro upsell', 'suki' ),
		),
		'priority'    => 190,
	) ) );
}