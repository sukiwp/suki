<?php
/**
 * Customizer settings: Blog > Post Layout: Default
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'suki_section_entry_default';

// Items gap
$key = 'blog_index_default_items_gap';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Items gap', 'suki' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'max'  => 300,
			'step' => 1,
		),
		'em' => array(
			'min'  => 0,
			'max'  => 20,
			'step' => 0.01,
		),
		'rem' => array(
			'min'  => 0,
			'max'  => 20,
			'step' => 0.01,
		),
	),
	'priority'    => 10,
) ) );

/**
 * ====================================================
 * Entry Header
 * ====================================================
 */

// Heading: Entry Header
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_entry_header', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Entry Header', 'suki' ),
	'priority'    => 30,
) ) );

// Elements
$key = 'entry_header';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'multiselect' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Sortable( $wp_customize, $key, array(
	'section'     => $section,
	// 'label'       => esc_html__( 'Elements', 'suki' ),
	'choices'     => apply_filters( 'suki/dataset/entry_header_elements', array(
		'header-meta' => esc_html__( 'Header Meta', 'suki' ),
		'title'       => esc_html__( 'Title', 'suki' ),
	) ),
	'priority'    => 30,
) ) );

// Alignment
$key = 'entry_header_alignment';
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
	'priority'    => 30,
) ) );

// Header meta text
$key = 'entry_header_meta';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'text' ),
) );
$wp_customize->add_control( $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Header meta text', 'suki' ),
	'description' => esc_html__( 'Available tags: {{date}}, {{categories}}, {{tags}}, {{author}}, {{avatar}}, {{comments}}.', 'suki' ),
	'priority'    => 30,
) );

/**
 * ====================================================
 * Entry Thumbnail
 * ====================================================
 */

// Heading: Entry Thumbnail
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_entry_thumbnail', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Entry Thumbnail', 'suki' ),
	'priority'    => 40,
) ) );

// Display
$key = 'entry_thumbnail_position';
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
	'priority'    => 40,
) );

// Wide alignment
$key = 'entry_thumbnail_wide';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Wide alignment on Narrow container', 'suki' ),
	'priority'    => 40,
) ) );

// Image size
$key = 'entry_thumbnail_size';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Image size', 'suki' ),
	'choices'     => suki_get_all_image_sizes(),
	'priority'    => 40,
) );

/**
 * ====================================================
 * Entry Content
 * ====================================================
 */

// Heading: Entry Content
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_entry_content', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Entry Content', 'suki' ),
	'priority'    => 50,
) ) );

// Content or excerpt
$key = 'entry_content';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Content or excerpt', 'suki' ),
	'choices'     => array(
		'content' => esc_html__( 'Content', 'suki' ),
		'excerpt' => esc_html__( 'Excerpt', 'suki' ),
	),
	'priority'    => 50,
) );

// Entry excerpt length
$key = 'entry_excerpt_length';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Excerpt words limit', 'suki' ),
	'description' => esc_html__( 'Fill with 0 to disable excerpt.', 'suki' ),
	'units'       => array(
		'' => array(
			'min'  => 0,
			'max'  => 200,
			'step' => 1,
			'label' => 'wrd',
		),
	),
	'priority'    => 50,
) ) );

// Read more
$key = 'entry_read_more_display';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Read more', 'suki' ),
	'choices'     => array(
		''       => esc_html__( 'None', 'suki' ),
		'text'   => esc_html__( 'Text', 'suki' ),
		'button' => esc_html__( 'Button', 'suki' ),
	),
	'priority'    => 50,
) );

// Read more text
$key = 'entry_read_more_text';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'text' ),
) );
$wp_customize->add_control( $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Read more text', 'suki' ),
	'input_attrs' => array(
		'placeholder' => esc_html__( 'Read more', 'suki' ),
	),
	'priority'    => 50,
) );

/**
 * ====================================================
 * Entry Footer
 * ====================================================
 */

// Heading: Entry Footer
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_entry_meta', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Entry Footer', 'suki' ),
	'priority'    => 60,
) ) );

// Elements
$key = 'entry_footer';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'multiselect' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Sortable( $wp_customize, $key, array(
	'section'     => $section,
	// 'label'       => esc_html__( 'Elements', 'suki' ),
	'choices'     => apply_filters( 'suki/dataset/entry_footer_elements', array(
		'footer-meta' => esc_html__( 'Footer Meta', 'suki' ),
	) ),
	'priority'    => 60,
) ) );

// Alignment
$key = 'entry_footer_alignment';
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
	'priority'    => 60,
) ) );

// Footer meta text
$key = 'entry_footer_meta';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'text' ),
) );
$wp_customize->add_control( $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Footer meta text', 'suki' ),
	'description' => esc_html__( 'Available tags: {{date}}, {{categories}}, {{tags}}, {{author}}, {{avatar}}, {{comments}}', 'suki' ),
	'priority'    => 60,
) );