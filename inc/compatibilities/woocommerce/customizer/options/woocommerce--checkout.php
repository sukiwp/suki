<?php
/**
 * Customizer settings: WooCommerce > Checkout
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

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
$key = 'woocommerce_checkout_two_columns';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Use 2 columns layout', 'suki' ),
	'priority'    => 20,
) ) );

/**
 * ====================================================
 * Suki Pro Upsell
 * ====================================================
 */

if ( suki_show_pro_teaser() ) {
	$wp_customize->add_control( new Suki_Customize_Control_Pro_Teaser( $wp_customize, 'pro_teaser_woocommerce_checkout', array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => esc_html_x( 'More Options Available', 'Suki Pro upsell', 'suki' ),
		'url'         => esc_url( add_query_arg( array( 'utm_source' => 'suki-customizer', 'utm_medium' => 'learn-more', 'utm_campaign' => 'theme-upsell' ), SUKI_PRO_URL ) ),
		'features'    => array(
			esc_html_x( 'Distraction Free Mode', 'Suki Pro upsell', 'suki' ),
		),
		'priority'    => 90,
	) ) );
}