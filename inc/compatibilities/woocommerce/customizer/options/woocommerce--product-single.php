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
$id = 'woocommerce_single_breadcrumb';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $id, array(
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
$id = 'woocommerce_single_gallery';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Show gallery', 'suki' ),
	'priority'    => 20,
) ) );

// Gallery column width
$id = 'woocommerce_single_gallery_width';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'slider' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Gallery column Width', 'suki' ),
	'units'       => array(
		'%' => array(
			'min'  => 50,
			'max'  => 75,
			'step' => 0.05,
		),
	),
	'priority'    => 20,
) ) );

// Gallery column gap
$id = 'woocommerce_single_gallery_gap';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'slider' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Gap with summary column', 'suki' ),
	'units'       => array(
		'%' => array(
			'min'  => 0,
			'max'  => 10,
			'step' => 0.01,
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
$id = 'woocommerce_single_gallery_zoom';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Enable zoom', 'suki' ),
	'priority'    => 20,
) ) );

// Enable lightbox
$id = 'woocommerce_single_gallery_lightbox';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $id, array(
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
	'priority'    => 30,
) ) );

// Show tabs
$id = 'woocommerce_single_tabs';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Show tabs', 'suki' ),
	'priority'    => 30,
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
	'priority'    => 40,
) ) );

// Show up-sells
$id = 'woocommerce_single_up_sells';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Show up-sells', 'suki' ),
	'description' => esc_html__( 'Display up-sells as configured on Edit Product page > Product Data > Linked Products > Up-sells.', 'suki' ),
	'priority'    => 40,
) ) );

// Up-sells columns
$id = 'woocommerce_single_up_sells_grid_columns';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'slider' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $id, array(
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
	'priority'    => 40,
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
	'priority'    => 50,
) ) );

// Show related products
$id = 'woocommerce_single_related';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Show related products', 'suki' ),
	'description' => esc_html__( 'Display linked products and similar products within same categories or tags. Products that have been displayed on "Up-sells" section will not be included.', 'suki' ),
	'priority'    => 50,
) ) );

// Related products posts per page
$id = 'woocommerce_single_related_posts_per_page';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'number' ),
) );
$wp_customize->add_control( $id, array(
	'type'        => 'number',
	'section'     => $section,
	'label'       => esc_html__( 'Max products shown', 'suki' ),
	'description' => esc_html__( '0 = disabled; -1 = Show all.', 'suki' ),
	'input_attrs' => array(
		'min'  => -1,
		'max'  => 12,
		'step' => 1,
	),
	'priority'    => 50,
) );

// Related products columns
$id = 'woocommerce_single_related_grid_columns';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'slider' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $id, array(
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
 * Suki Pro Upsell
 * ====================================================
 */

if ( suki_show_pro_teaser() ) {
	$wp_customize->add_control( new Suki_Customize_Control_Pro_Teaser( $wp_customize, 'pro_teaser_woocommerce_single', array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => esc_html_x( 'More Options on Suki Pro', 'Suki Pro upsell', 'suki' ),
		'url'         => SUKI_PRO_URL,
		'features'    => array(
			esc_html_x( 'More "add to cart" styles', 'Suki Pro upsell', 'suki' ),
			esc_html_x( 'More gallery styles', 'Suki Pro upsell', 'suki' ),
			esc_html_x( 'More info tabs styles', 'Suki Pro upsell', 'suki' ),
		),
		'priority'    => 90,
	) ) );
}