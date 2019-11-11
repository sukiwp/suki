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
 * Grid Item
 * ====================================================
 */

// Heading: Content
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_entry_grid_content', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Content', 'suki' ),
	'priority'    => 10,
) ) );

// Entry grid excerpt length
$key = 'entry_grid_excerpt_length';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Content / excerpt words limit', 'suki' ),
	'units'       => array(
		'' => array(
			'min'  => 0,
			'max'  => 200,
			'step' => 1,
		),
	),
	'hide_units'  => true,
	'priority'    => 10,
) ) );

/**
 * ====================================================
 * Featured Media
 * ====================================================
 */

// Heading: Featured Media
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_entry_grid_featured_media', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Featured Media', 'suki' ),
	'priority'    => 20,
) ) );

// Featured media position
$key = 'entry_grid_featured_media_position';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Featured media position', 'suki' ),
	'choices'     => array(
		'before-entry-header' => esc_html__( 'Before Post Header', 'suki' ),
		'after-entry-header'  => esc_html__( 'After Post Header', 'suki' ),
	),
	'priority'    => 20,
) );

/**
 * ====================================================
 * Post Header
 * ====================================================
 */

// Heading: Post Header
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_entry_grid_header', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Post Header', 'suki' ),
	'priority'    => 30,
) ) );

// Elements to display
$key = 'entry_grid_header';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'multiselect' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Builder( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Elements to display', 'suki' ),
	'description' => esc_html__( 'Add and move elements as you wish. Leave it blank to disable.', 'suki' ),
	'choices'     => array(
		'header-meta' => esc_html__( 'Header Meta', 'suki' ),
		'title'       => esc_html__( 'Title', 'suki' ),
	),
	'layout'      => 'block',
	'priority'    => 30,
) ) );

// Alignment
$key = 'entry_grid_header_alignment';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Alignment', 'suki' ),
	'choices'     => array(
		'left'   => is_rtl() ? esc_html__( 'Right', 'suki' ) : esc_html__( 'Left', 'suki' ),
		'center' => esc_html__( 'Center', 'suki' ),
		'right'  => is_rtl() ? esc_html__( 'Left', 'suki' ) : esc_html__( 'Right', 'suki' ),
	),
	'priority'    => 30,
) );

// Header meta format
$key = 'entry_grid_header_meta';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'text' ),
) );
$wp_customize->add_control( $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Header meta format', 'suki' ),
	'description' => esc_html__( 'Available tags: {{date}}, {{categories}}, {{tags}}, {{author}}, {{avatar}}, {{comments}}.', 'suki' ),
	'priority'    => 30,
) );

/**
 * ====================================================
 * Post Footer
 * ====================================================
 */

// Heading: Post Footer
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_entry_grid_meta', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Post Footer', 'suki' ),
	'priority'    => 40,
) ) );

// Elements to display
$key = 'entry_grid_footer';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'multiselect' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Builder( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Elements to display', 'suki' ),
	'description' => esc_html__( 'Add and move elements as you wish. Leave it blank to disable.', 'suki' ),
	'choices'     => array(
		'footer-meta' => esc_html__( 'Footer Meta', 'suki' ),
	),
	'layout'      => 'block',
	'priority'    => 40,
) ) );

// Alignment
$key = 'entry_grid_footer_alignment';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Alignment', 'suki' ),
	'choices'     => array(
		'left'   => is_rtl() ? esc_html__( 'Right', 'suki' ) : esc_html__( 'Left', 'suki' ),
		'center' => esc_html__( 'Center', 'suki' ),
		'right'  => is_rtl() ? esc_html__( 'Left', 'suki' ) : esc_html__( 'Right', 'suki' ),
	),
	'priority'    => 40,
) );

// Footer meta format
$key = 'entry_grid_footer_meta';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'text' ),
) );
$wp_customize->add_control( $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Footer meta format', 'suki' ),
	'description' => esc_html__( 'Available tags: {{date}}, {{categories}}, {{tags}}, {{author}}, {{avatar}}, {{comments}}', 'suki' ),
	'priority'    => 40,
) );