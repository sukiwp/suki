<?php
/**
 * Customizer settings: Header > Logo
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'suki_section_header_logo';

/**
 * ====================================================
 * Desktop Logo
 * ====================================================
 */

// Heading: Logo
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_header_logo', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Logo', 'suki' ),
	'priority'    => 10,
) ) );

// Logo
$id = 'custom_logo';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Logo image', 'suki' ),
	'description' => esc_html__( 'Supports JPG, PNG, or SVG format', 'suki' ),
	'mime_type'   => 'image',
	'priority'    => 10,
) ) );

// Max width
$id = 'header_logo_width';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'slider' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Max width', 'suki' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'max'  => 500,
			'step' => 1,
		),
	),
	'priority'    => 10,
) ) );

/**
 * ====================================================
 * Mobile Logo
 * ====================================================
 */

// Heading: Mobile Logo
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_header_mobile_logo', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Mobile Logo', 'suki' ),
	'priority'    => 20,
) ) );

// Mobile Logo
$id = 'custom_logo_mobile';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Mobile Logo image', 'suki' ),
	'description' => esc_html__( 'Supports .JPG, .PNG, or .SVG format', 'suki' ),
	'mime_type'   => 'image',
	'priority'    => 20,
) ) );

// Max width
$id = 'header_mobile_logo_width';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'slider' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Max width', 'suki' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'max'  => 500,
			'step' => 1,
		),
	),
	'priority'    => 20,
) ) );