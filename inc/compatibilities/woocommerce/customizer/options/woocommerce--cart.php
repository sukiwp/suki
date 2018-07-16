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
 * Cross-Sells
 * ====================================================
 */

// Heading: Cross-Sells
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_woocommerce_cart_cross_sells', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Cross-Sells', 'suki' ),
	'priority'    => 20,
) ) );

// Cross-sells
$id = 'woocommerce_cart_cross_sells';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Show cross-sells', 'suki' ),
	'description' => esc_html__( 'Display cross-sells as configured on Edit Product page > Product Data > Linked Products > Cross-sells.', 'suki' ),
	'priority'    => 20,
) ) );

// Cross-sells grid columns
$id = 'woocommerce_cart_cross_sells_grid_columns';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'slider' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $id, array(
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