<?php
/**
 * Customizer settings: Blog > Post Layout: Default
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'suki_section_entry_default';

/**
 * ====================================================
 * Featured Media
 * ====================================================
 */

// Heading: Featured Media
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_entry_featured_media', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Featured Media', 'suki' ),
	'priority'    => 10,
) ) );

// Featured media position
$key = 'entry_featured_media_position';
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
	'priority'    => 10,
) );

// Ignore main content area padding
$key = 'entry_featured_media_ignore_padding';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Ignore main content area padding', 'suki' ),
	'description' => sprintf(
		/* translators: %s: menu path to main content's padding setting. */
		esc_html__( 'If you set padding on %s, enabling this option will make your featured media disregard the padding.', 'suki' ),
		'<a href="' . esc_attr( add_query_arg( 'autofocus[section]', 'suki_section_main', remove_query_arg( 'autofocus' ) ) ) . '" class="suki-customize-goto-control">' . esc_html__( 'Main Content Area', 'suki' ) . '</a>'
	),
	'priority'    => 10,
) ) );

/**
 * ====================================================
 * Post Header
 * ====================================================
 */

// Heading: Post Header
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_entry_header', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Post Header', 'suki' ),
	'priority'    => 20,
) ) );

// Elements to display
$key = 'entry_header';
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
	'priority'    => 20,
) ) );

// Alignment
$key = 'entry_header_alignment';
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
	'priority'    => 20,
) );

// Header meta format
$key = 'entry_header_meta';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'text' ),
) );
$wp_customize->add_control( $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Header meta format', 'suki' ),
	'description' => esc_html__( 'Available tags: {{date}}, {{categories}}, {{tags}}, {{author}}, {{avatar}}, {{comments}}.', 'suki' ),
	'priority'    => 20,
) );

/**
 * ====================================================
 * Post Footer
 * ====================================================
 */

// Heading: Post Footer
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_entry_meta', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Post Footer', 'suki' ),
	'priority'    => 30,
) ) );

// Elements to display
$key = 'entry_footer';
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
	'priority'    => 30,
) ) );

// Alignment
$key = 'entry_footer_alignment';
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

// Footer meta format
$key = 'entry_footer_meta';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'text' ),
) );
$wp_customize->add_control( $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Footer meta format', 'suki' ),
	'description' => esc_html__( 'Available tags: {{date}}, {{categories}}, {{tags}}, {{author}}, {{avatar}}, {{comments}}', 'suki' ),
	'priority'    => 30,
) );