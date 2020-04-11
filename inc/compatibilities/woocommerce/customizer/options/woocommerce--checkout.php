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
 * Content Layout
 * ====================================================
 */

// Heading: Content Layout
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_woocommerce_checkout_layout', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Content Layout', 'suki' ),
	'priority'    => 20,
) ) );

// Checkout form layout
$key = 'woocommerce_checkout_layout';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_RadioImage( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Checkout form layout', 'suki' ),
	'choices'     => array(
		'default' => array(
			'label' => esc_html__( 'Default', 'suki' ),
			'image' => SUKI_IMAGES_URL . '/customizer/woocommerce-checkout-layout--default.svg',
		),
		'2-columns' => array(
			'label' => esc_html__( '2 Columns', 'suki' ),
			'image' => SUKI_IMAGES_URL . '/customizer/woocommerce-checkout-layout--2-columns.svg',
		),
	),
	'priority'    => 20,
) ) );

// Heading: Dynamic Page Layout
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_page_settings_woocommerce_checkout', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Dynamic Page Layout', 'suki' ),
	'description' => '<a href="' . esc_url( get_edit_post_link( wc_get_page_id( 'checkout' ) ) ) . '">' . esc_html__( 'Available in the page editor.', 'suki' ) . '</a>',
	'priority'    => 100,
) ) );

if ( suki_show_pro_teaser() ) {
	$wp_customize->add_control( new Suki_Customize_Control_Pro_Teaser( $wp_customize, 'pro_teaser_woocommerce_checkout', array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => esc_html_x( 'More Options Available in Suki Pro', 'Suki Pro upsell', 'suki' ),
		'url'         => esc_url( add_query_arg( array( 'utm_source' => 'suki-customizer', 'utm_medium' => 'learn-more', 'utm_campaign' => 'theme-upsell' ), SUKI_PRO_URL ) ),
		'features'    => array(
			esc_html_x( 'Distraction Free Mode', 'Suki Pro upsell', 'suki' ),
		),
		'priority'    => 190,
	) ) );
}