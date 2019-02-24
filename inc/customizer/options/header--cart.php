<?php
/**
 * Customizer settings: Header > Cart
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'suki_section_header_cart';

/**
 * ====================================================
 * Colors
 * ====================================================
 */

if ( ! class_exists( 'WooCommerce' ) ) {
	// Notice
	$wp_customize->add_control( new Suki_Customize_Control_Blank( $wp_customize, 'notice_header_cart', array(
		'section'     => $section,
		'settings'    => array(),
		'description' => '<div class="notice notice-warning"><p>' . esc_html__( 'Only available if WooCommerce plugin is installed and activated.', 'suki' ) . '</p></div>',
		'priority'    => 10,
	) ) );
}

// Colors
$colors = array(
	'header_cart_count_bg_color'   => esc_html__( 'Cart count BG color', 'suki' ),
	'header_cart_count_text_color' => esc_html__( 'Cart count text color', 'suki' ),
);
foreach ( $colors as $id => $label ) {
	$wp_customize->add_setting( $id, array(
		'default'     => suki_array_value( $defaults, $id ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'color' ),
	) );
	$wp_customize->add_control( new Suki_Customize_Control_Color( $wp_customize, $id, array(
		'section'     => $section,
		'label'       => $label,
		'priority'    => 10,
	) ) );
}