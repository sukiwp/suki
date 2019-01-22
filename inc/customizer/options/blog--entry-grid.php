<?php
/**
 * Customizer settings: Blog > Post Layout: Grid
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'suki_section_entry_grid';

/**
 * ====================================================
 * Grid Layout
 * ====================================================
 */

// Padding
$id = 'entry_grid_padding';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimensions' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Dimensions( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Padding', 'suki' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'max'  => 80,
			'step' => 1,
		),
	),
	'priority'    => 10,
) ) );

// Border
$id = 'entry_grid_border';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimensions' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Dimensions( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Border', 'suki' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'step' => 1,
		),
	),
	'priority'    => 10,
) ) );

// Background color
$id = 'entry_grid_bg_color';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'color' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Color( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Background color', 'suki' ),
	'priority'    => 10,
) ) );

// Heading: Featured Media
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_entry_grid_featured_media', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Featured Media', 'suki' ),
	'priority'    => 20,
) ) );

// Featured media position
$id = 'entry_grid_featured_media_position';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $id, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Featured media position', 'suki' ),
	'choices'     => array(
		'before-entry-header' => esc_html__( 'Before Post Header', 'suki' ),
		'after-entry-header'  => esc_html__( 'After Post Header', 'suki' ),
	),
	'priority'    => 20,
) );

// Featured media ignore padding
$id = 'entry_grid_featured_media_ignore_padding';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Featured media ignore padding', 'suki' ),
	'priority'    => 20,
) ) );

// Heading: Header
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_entry_grid_header', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Header', 'suki' ),
	'priority'    => 30,
) ) );

// Post header elements
$id = 'entry_grid_header';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'multiselect' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Builder( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Post header elements', 'suki' ),
	'choices'     => apply_filters( 'suki/customizer/entry_grid_header_elements', array(
		'header-meta'    => esc_html__( 'Header Meta', 'suki' ),
		'title'          => esc_html__( 'Title', 'suki' ),
	) ),
	'layout'      => 'block',
	'priority'    => 30,
) ) );

// Post header alignment
$id = 'entry_grid_header_alignment';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $id, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Post header alignment', 'suki' ),
	'choices'     => array(
		'left'   => is_rtl() ? esc_html__( 'Right', 'suki' ) : esc_html__( 'Left', 'suki' ),
		'center' => esc_html__( 'Center', 'suki' ),
		'right'  => is_rtl() ? esc_html__( 'Left', 'suki' ) : esc_html__( 'Right', 'suki' ),
	),
	'priority'    => 30,
) );

// Heading: Meta
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_entry_grid_meta', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Meta', 'suki' ),
	'priority'    => 40,
) ) );

// Post header meta
$id = 'entry_grid_header_meta';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'text' ),
) );
$wp_customize->add_control( $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Header meta', 'suki' ),
	'description' => esc_html__( 'Available tags: {{date}}, {{categories}}, {{tags}}, {{author}}, {{avatar}}, {{comments}}', 'suki' ),
	'priority'    => 40,
) );

// Post footer meta
$id = 'entry_grid_footer_meta';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'text' ),
) );
$wp_customize->add_control( $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Footer meta', 'suki' ),
	'description' => esc_html__( 'Available tags: {{date}}, {{categories}}, {{tags}}, {{author}}, {{avatar}}, {{comments}}', 'suki' ),
	'priority'    => 40,
) );

// Heading: Excerpt
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_entry_grid_excerpt', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Excerpt', 'suki' ),
	'priority'    => 50,
) ) );

// Entry grid excerpt length
$id = 'entry_grid_excerpt_length';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Excerpt length', 'suki' ),
	'units'       => array(
		'' => array(
			'min'  => 0,
			'max'  => 200,
			'step' => 1,
			'label' => 'chr',
		),
	),
	'priority'    => 50,
) ) );