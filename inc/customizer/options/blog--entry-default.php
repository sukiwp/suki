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
 * Default Layout
 * ====================================================
 */

// Featured media position
$id = 'entry_featured_media_position';
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
	'priority'    => 10,
) );

// Featured media ignore padding
$id = 'entry_featured_media_ignore_padding';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Remove padding on featured media', 'suki' ),
	'description' => sprintf(
		/* translators: %s: menu path to main content's padding setting. */
		esc_html__( 'If you set padding on %s, enabling this option will make your featured media disregard the padding.', 'suki' ),
		'<a href="' . esc_url( add_query_arg( 'autofocus[section]', 'suki_section_main' ) ) . '" class="suki-customize-goto-control">' . esc_html__( 'Main Content Area', 'suki' ) . '</a>'
	),
	'priority'    => 10,
) ) );

// Post header elements
$id = 'entry_header';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'multiselect' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Builder( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Post header elements', 'suki' ),
	'choices'     => apply_filters( 'suki/customizer/entry_header_elements', array(
		'header-meta'    => esc_html__( 'Header Meta', 'suki' ),
		'title'          => esc_html__( 'Title', 'suki' ),
	) ),
	'layout'      => 'block',
	'priority'    => 10,
) ) );

// Post header alignment
$id = 'entry_header_alignment';
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
	'priority'    => 10,
) );

// ------
$wp_customize->add_control( new Suki_Customize_Control_HR( $wp_customize, 'hr_entry_meta', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 10,
) ) );

// Post header meta
$id = 'entry_header_meta';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'text' ),
) );
$wp_customize->add_control( $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Header meta', 'suki' ),
	'description' => esc_html__( 'Available tags: {{date}}, {{categories}}, {{tags}}, {{author}}, {{avatar}}, {{comments}}', 'suki' ),
	'priority'    => 10,
) );

// Post footer meta
$id = 'entry_footer_meta';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'text' ),
) );
$wp_customize->add_control( $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Footer meta', 'suki' ),
	'description' => esc_html__( 'Available tags: {{date}}, {{categories}}, {{tags}}, {{author}}, {{avatar}}, {{comments}}', 'suki' ),
	'priority'    => 10,
) );