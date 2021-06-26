<?php
/**
 * Customizer settings: Header > Cart
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'suki_section_header_cart';

// Anchor for Cart Link element
$wp_customize->add_control( new Suki_Customize_Control_Blank( $wp_customize, 'heading_header_cart_link', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 10,
) ) );

// Anchor for Cart Dropdown element
$wp_customize->add_control( new Suki_Customize_Control_Blank( $wp_customize, 'heading_header_cart_dropdown', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 10,
) ) );

// Cart amount
$key = 'header_cart_amount';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Cart amount', 'suki' ),
	'choices'     => array(
		''       => esc_html__( 'Hidden', 'suki' ),
		'before' => esc_html__( 'Before icon', 'suki' ),
		'after'  => esc_html__( 'After icon', 'suki' ),
	),
	'priority'    => 10,
) );

// Cart amount visibility
$key = 'header_cart_amount_visibility';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'multiselect' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_MultiCheck( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Cart amount visibility', 'suki' ),
	'choices'     => array(
		'desktop' => esc_html__( 'Desktop', 'suki' ),
		'tablet'  => esc_html__( 'Tablet', 'suki' ),
		'mobile'  => esc_html__( 'Mobile', 'suki' ),
	),
	'priority'    => 10,
) ) );

// ------
$wp_customize->add_control( new Suki_Customize_Control_HR( $wp_customize, 'hr_header_cart_count', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 10,
) ) );

// Selective Refresh
if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( 'header_cart_link', array(
		'settings'            => array(
			'header_cart_amount',
			'header_cart_amount_visibility',
		),
		'selector'            => '.suki-header-cart-link',
		'container_inclusive' => true,
		'render_callback'     => function() {
			suki_header_element( 'cart-link' );
		},
		'fallback_refresh'    => false,
	) );

	$wp_customize->selective_refresh->add_partial( 'header_cart_dropdown', array(
		'settings'            => array(
			'header_cart_amount',
			'header_cart_amount_visibility',
		),
		'selector'            => '.suki-header-cart-dropdown',
		'container_inclusive' => true,
		'render_callback'     => function() {
			suki_header_element( 'cart-dropdown' );
		},
		'fallback_refresh'    => false,
	) );
}

/**
 * ====================================================
 * Colors
 * ====================================================
 */

// Colors
$colors = array(
	'header_cart_count_bg_color'   => esc_html__( 'Cart count BG color', 'suki' ),
	'header_cart_count_text_color' => esc_html__( 'Cart count text color', 'suki' ),
);
foreach ( $colors as $key => $label ) {
	$wp_customize->add_setting( $key, array(
		'default'     => suki_array_value( $defaults, $key ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'color' ),
	) );
	$wp_customize->add_control( new Suki_Customize_Control_Color( $wp_customize, $key, array(
		'section'     => $section,
		'label'       => $label,
		'priority'    => 20,
	) ) );
}