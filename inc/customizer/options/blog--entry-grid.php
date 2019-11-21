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
 * Layout
 * ====================================================
 */

// Grid columns
$key = 'blog_index_grid_columns';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Columns', 'suki' ),
	'units'       => array(
		'' => array(
			'min'  => 2,
			'max'  => 4,
			'step' => 1,
			'label' => 'col',
		),
	),
	'priority'    => 10,
) ) );

// Rows gutter
$key = 'blog_index_grid_rows_gutter';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Rows gutter', 'suki' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'max'  => 40,
			'step' => 1,
		),
		'em' => array(
			'min'  => 0,
			'max'  => 3,
			'step' => 0.05,
		),
	),
	'priority'    => 10,
) ) );

// Columns gutter
$key = 'blog_index_grid_columns_gutter';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Columns gutter', 'suki' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'max'  => 40,
			'step' => 1,
		),
		'em' => array(
			'min'  => 0,
			'max'  => 3,
			'step' => 0.05,
		),
	),
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
	'priority'    => 50,
) );

// Header meta text
$key = 'entry_grid_header_meta';
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
 * Content
 * ====================================================
 */

// Heading: Content
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_entry_grid_content', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Content', 'suki' ),
	'priority'    => 40,
) ) );

// Entry grid excerpt length
$key = 'entry_grid_excerpt_length';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Excerpt words limit', 'suki' ),
	'units'       => array(
		'' => array(
			'min'  => 0,
			'max'  => 200,
			'step' => 1,
			'label' => 'wrd',
		),
	),
	'priority'    => 40,
) ) );

// Read more text
$key = 'entry_grid_read_more_text';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'text' ),
) );
$wp_customize->add_control( $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Read more text', 'suki' ),
	'description' => esc_html__( 'Leave empty to disable read more link.', 'suki' ),
	'priority'    => 40,
) );

// Read more display
$key = 'entry_grid_read_more_display';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Read more display', 'suki' ),
	'choices'     => array(
		'text'   => esc_html__( 'Text', 'suki' ),
		'button' => esc_html__( 'Button', 'suki' ),
	),
	'priority'    => 40,
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
	'priority'    => 50,
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
	'choices'     => array(
		'footer-meta' => esc_html__( 'Footer Meta', 'suki' ),
	),
	'layout'      => 'block',
	'priority'    => 50,
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
	'priority'    => 50,
) );

// Footer meta text
$key = 'entry_grid_footer_meta';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'text' ),
) );
$wp_customize->add_control( $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Footer meta text', 'suki' ),
	'description' => esc_html__( 'Available tags: {{date}}, {{categories}}, {{tags}}, {{author}}, {{avatar}}, {{comments}}', 'suki' ),
	'priority'    => 50,
) );