<?php
/**
 * Customizer settings: Other Pages > Static Page
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'suki_section_page_single';

/**
 * ====================================================
 * Content Header
 * ====================================================
 */

// Heading: Content Header
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_page_single_content_header', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Content Header', 'suki' ),
	'priority'    => 10,
) ) );

// Elements
$key = 'page_single_content_header';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'multiselect' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Sortable( $wp_customize, $key, array(
	'section'     => $section,
	// 'label'       => esc_html__( 'Elements', 'suki' ),
	'choices'     => apply_filters( 'suki/dataset/page_single_content_header_elements', array(
		'title'       => esc_html__( 'Title', 'suki' ),
		'breadcrumb'  => esc_html__( 'Breadcrumb', 'suki' ),
		'header-meta' => esc_html__( 'Header Meta', 'suki' ),
	) ),
	'priority'    => 10,
) ) );

// Alignment
$key = 'page_single_content_header_alignment';
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
	'priority'    => 10,
) ) );

/**
 * ====================================================
 * Featured Image
 * ====================================================
 */

// Heading: Featured Image
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_page_single_content_thumbnail', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Featured Image', 'suki' ),
	'priority'    => 20,
) ) );

// Featured image
$key = 'page_single_content_thumbnail_position';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Display', 'suki' ),
	'choices'     => array(
		''       => esc_html__( 'Disabled', 'suki' ),
		'before' => esc_html__( 'Before Content Header', 'suki' ),
		'after'  => esc_html__( 'After Content Header', 'suki' ),
	),
	'priority'    => 20,
) );

// Wide alignment
$key = 'page_single_content_thumbnail_wide';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Wide alignment on Narrow container', 'suki' ),
	'priority'    => 20,
) ) );