<?php
/**
 * Customizer settings: WooCommerce > Single Product
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'woocommerce_product_single'; // Assumed

/**
 * ====================================================
 * Layout
 * ====================================================
 */

// Breadcrumb
$key = 'woocommerce_single_breadcrumb';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Show breadcrumb', 'suki' ),
	'priority'    => 10,
) ) );

/**
 * ====================================================
 * Images
 * ====================================================
 */

// Heading: Gallery
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_woocommerce_single_gallery', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Gallery', 'suki' ),
	'priority'    => 20,
) ) );

// Show gallery
$key = 'woocommerce_single_gallery';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Show gallery', 'suki' ),
	'priority'    => 20,
) ) );

// Gallery column width
$key = 'woocommerce_single_gallery_width';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	// 'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Gallery column Width', 'suki' ),
	'units'       => array(
		'%' => array(
			'min'  => 25,
			'max'  => 75,
			'step' => 0.05,
		),
	),
	'priority'    => 20,
) ) );

// Gallery column gap
$key = 'woocommerce_single_gallery_gap';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Gap with summary column', 'suki' ),
	'units'       => array(
		'%' => array(
			'min'  => 0,
			'max'  => 10,
			'step' => 1,
		),
		'px' => array(
			'min'  => 0,
			'max'  => 100,
			'step' => 1,
		),
	),
	'priority'    => 20,
) ) );

// Enable zoom
$key = 'woocommerce_single_gallery_zoom';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Enable zoom', 'suki' ),
	'priority'    => 20,
) ) );

// Enable lightbox
$key = 'woocommerce_single_gallery_lightbox';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Enable lightbox', 'suki' ),
	'priority'    => 20,
) ) );

/**
 * ====================================================
 * Tabs
 * ====================================================
 */

// Heading: Tabs
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_woocommerce_single_tabs', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Tabs', 'suki' ),
	'priority'    => 40,
) ) );

// Show tabs
$key = 'woocommerce_single_tabs';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Show tabs', 'suki' ),
	'priority'    => 40,
) ) );


/**
 * ====================================================
 * Up-Sells
 * ====================================================
 */

// Heading: Up-Sells
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_woocommerce_single_up_sells', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Up-Sells', 'suki' ),
	'priority'    => 50,
) ) );

// Show up-sells
$key = 'woocommerce_single_up_sells';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Show up-sells', 'suki' ),
	'description' => esc_html__( 'Display up-sells as configured on Edit Product page > Product Data > Linked Products > Up-sells.', 'suki' ),
	'priority'    => 50,
) ) );

// Up-sells columns
$key = 'woocommerce_single_up_sells_grid_columns';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Columns', 'suki' ),
	'units'       => array(
		'' => array(
			'min'  => 1,
			'max'  => 6,
			'step' => 1,
			'label' => 'col',
		),
	),
	'priority'    => 50,
) ) );

/**
 * ====================================================
 * Related
 * ====================================================
 */

// Heading: Related Products
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_woocommerce_single_related', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Related Products', 'suki' ),
	'priority'    => 60,
) ) );

// Show related products
$key = 'woocommerce_single_related';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Show related products', 'suki' ),
	'description' => esc_html__( 'Display linked products and similar products within same categories or tags. Products that have been displayed on "Up-sells" section will not be included.', 'suki' ),
	'priority'    => 60,
) ) );

// Related products posts per page
$key = 'woocommerce_single_related_posts_per_page';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'number' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'number',
	'section'     => $section,
	'label'       => esc_html__( 'Max products shown', 'suki' ),
	'description' => esc_html__( '0 = disabled; -1 = show all.', 'suki' ),
	'input_attrs' => array(
		'min'  => -1,
		'max'  => 12,
		'step' => 1,
	),
	'priority'    => 60,
) );

// Related products columns
$key = 'woocommerce_single_related_grid_columns';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Columns', 'suki' ),
	'units'       => array(
		'' => array(
			'min'  => 1,
			'max'  => 6,
			'step' => 1,
			'label' => 'col',
		),
	),
	'priority'    => 60,
) ) );

/**
 * ====================================================
 * Suki Pro Upsell
 * ====================================================
 */

if ( suki_show_pro_teaser() ) {
	$wp_customize->add_control( new Suki_Customize_Control_Pro_Teaser( $wp_customize, 'pro_teaser_woocommerce_single', array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => esc_html_x( 'More Options Available', 'Suki Pro upsell', 'suki' ),
		'url'         => esc_url( add_query_arg( array( 'utm_source' => 'suki-customizer', 'utm_medium' => 'learn-more', 'utm_campaign' => 'theme-upsell' ), SUKI_PRO_URL ) ),
		'features'    => array(
			esc_html_x( 'AJAX Add To Cart', 'Suki Pro upsell', 'suki' ),
			esc_html_x( 'More Gallery Layouts', 'Suki Pro upsell', 'suki' ),
		),
		'priority'    => 90,
	) ) );
}