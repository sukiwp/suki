<?php
/**
 * Customizer settings: WooCommerce > Checkout
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$defaults = Suki_Customizer::instance()->get_setting_defaults();

$section = 'woocommerce_checkout'; // Assumed

/**
 * ====================================================
 * Layout
 * ====================================================
 */

// Heading: Layout
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_woocommerce_checkout_layout', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Layout', 'suki' ),
	'priority'    => 20,
) ) );

// 2 columns layout
$id = 'woocommerce_checkout_two_columns';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Use 2 columns layout', 'suki' ),
	'description' => esc_html__( 'You might need to set your Checkout Page content layout (page settings) to "Wide Content" or "Narrow Content"', 'suki' ),
	'priority'    => 20,
) ) );