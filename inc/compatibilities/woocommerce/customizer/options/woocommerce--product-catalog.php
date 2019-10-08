<?php
/**
 * Customizer settings: WooCommerce > Shop (Products Catalog) Page
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'woocommerce_product_catalog';

/**
 * ====================================================
 * Layout
 * ====================================================
 */

// Heading: Layout
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_woocommerce_index_grid', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Layout', 'suki' ),
	'priority'    => 20,
) ) );

// Loop posts per page
$key = 'woocommerce_index_posts_per_page';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'number' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'number',
	'section'     => $section,
	'label'       => esc_html__( 'Max products per page', 'suki' ),
	'description' => esc_html__( 'Empty / 0 = disabled; -1 = Show all.', 'suki' ),
	'input_attrs' => array(
		'min'  => -1,
		'step' => 1,
	),
	'priority'    => 20,
) );

// Loop columns
$key = 'woocommerce_index_grid_columns';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Grid columns', 'suki' ),
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

// ------
$wp_customize->add_control( new Suki_Customize_Control_HR( $wp_customize, 'hr_woocommerce_index_elements', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 20,
) ) );

// Page header title
$key = 'woocommerce_index_page_title';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Show page header title', 'suki' ),
	'priority'    => 20,
) ) );

// Breadcrumb
$key = 'woocommerce_index_breadcrumb';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Show breadcrumb', 'suki' ),
	'priority'    => 20,
) ) );

// Show products count
$key = 'woocommerce_index_results_count';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Show products count', 'suki' ),
	'priority'    => 20,
) ) );

// Show products count
$key = 'woocommerce_index_sort_filter';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Show products sort filter', 'suki' ),
	'priority'    => 20,
) ) );

if ( suki_show_pro_teaser() ) {
	$wp_customize->add_control( new Suki_Customize_Control_Pro_Teaser( $wp_customize, 'pro_teaser_woocommerce_products_grid', array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => esc_html_x( 'More Options Available', 'Suki Pro upsell', 'suki' ),
		'url'         => esc_url( add_query_arg( array( 'utm_source' => 'suki-customizer', 'utm_medium' => 'learn-more', 'utm_campaign' => 'theme-upsell' ), SUKI_PRO_URL ) ),
		'features'    => array(
			esc_html_x( 'Off-Canvas Filters', 'Suki Pro upsell', 'suki' ),
		),
		'priority'    => 90,
	) ) );
}