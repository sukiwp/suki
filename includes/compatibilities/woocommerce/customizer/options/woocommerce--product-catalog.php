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
 * Content Header
 * ====================================================
 */

// Heading: Content Header
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_product_archive_content_header', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Content Header', 'suki' ),
	'priority'    => 20,
) ) );

// Elements
$key = 'product_archive_content_header';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'multiselect' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Sortable( $wp_customize, $key, array(
	'section'     => $section,
	// 'label'       => esc_html__( 'Elements', 'suki' ),
	'choices'     => apply_filters( 'suki/dataset/product_archive_content_header_elements', array(
		'title'               => esc_html__( 'Title', 'suki' ),
		'breadcrumb'          => esc_html__( 'Breadcrumb', 'suki' ),
		'archive-description' => esc_html__( 'Taxonomy Description', 'suki' ),
	) ),
	'priority'    => 20,
) ) );

// Alignment
$key = 'product_archive_content_header_alignment';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_RadioImage( $wp_customize, $key, array(
	'section'     => $section,
	// 'label'       => esc_html__( 'Alignment', 'suki' ),
	'choices'     => array(
		'left'   => array(
			'label' => '<span class="dashicons dashicons-editor-align' . ( is_rtl() ? 'right' : 'left' ) . '"></span>',
		),
		'center' => array(
			'label' => '<span class="dashicons dashicons-editor-aligncenter"></span>',
		),
		'right'  => array(
			'label' => '<span class="dashicons dashicons-editor-align' . ( is_rtl() ? 'left' : 'right' ) . '"></span>',
		),
	),
	'priority'    => 20,
) ) );

// Title text format on taxonomy archive pages
$key = 'product_archive_tax_title_text';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'text' ),
) );
$wp_customize->add_control( $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Taxonomy archive page title', 'suki' ),
	'description' => esc_html__( 'Available tags: {{taxonomy}}, {{term}}.', 'suki' ),
	'input_attrs' => array(
		'placeholder' => '{{term}}',
	),
	'priority'    => 20,
) );

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
	'priority'    => 30,
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
	'priority'    => 30,
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
	'priority'    => 30,
) ) );

// ------
$wp_customize->add_control( new Suki_Customize_Control_HR( $wp_customize, 'hr_woocommerce_index_elements', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 30,
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
	'priority'    => 30,
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
	'priority'    => 30,
) ) );
