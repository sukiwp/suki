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
	'priority'    => 10,
) ) );

// Post header elements
$id = 'entry_header';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'refresh',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'multiselect' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Builder( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Post header elements', 'suki' ),
	'choices'     => apply_filters( 'suki_customizer_entry_header_elements', array(
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
		'left'   => is_rtl() ? esc_html__( 'Right - RTL', 'suki' ) : esc_html__( 'Left', 'suki' ),
		'center' => esc_html__( 'Center', 'suki' ),
		'right'  => is_rtl() ? esc_html__( 'Left - RTL', 'suki' ) : esc_html__( 'Right', 'suki' ),
	),
	'priority'    => 10,
) );

// Post header meta elements
$id = 'entry_header_meta';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'refresh',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'multiselect' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Builder( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Header meta elements', 'suki' ),
	'choices'     => suki_get_entry_meta_elements(),
	'priority'    => 10,
) ) );

// Post footer meta elements
$id = 'entry_footer_meta';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'refresh',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'multiselect' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Builder( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Footer meta elements', 'suki' ),
	'choices'     => suki_get_entry_meta_elements(),
	'priority'    => 10,
) ) );