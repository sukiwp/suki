<?php
/**
 * Customizer settings: WooCommerce > Store Notice
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$defaults = Suki_Customizer::instance()->get_setting_defaults();

$section = 'woocommerce_store_notice';

/**
 * ====================================================
 * Colors
 * ====================================================
 */

// ------
$wp_customize->add_control( new Suki_Customize_Control_HR( $wp_customize, 'hr_woocommerce_store_notice', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 20,
) ) );

// Colors
$colors = array(
	'woocommerce_demo_store_notice_bg_color'   => esc_html__( 'Background color', 'suki' ),
	'woocommerce_demo_store_notice_text_color' => esc_html__( 'Text color', 'suki' ),
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
		'priority'    => 20,
	) ) );
}