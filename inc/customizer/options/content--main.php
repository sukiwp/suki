<?php
/**
 * Customizer settings: Content & Sidebar > Main Content
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'suki_section_main';

/**
 * ====================================================
 * Layout
 * ====================================================
 */

// Padding
$id = 'content_padding';
$settings = array(
	$id,
	$id . '__tablet',
	$id . '__mobile',
);
foreach ( $settings as $setting ) {
	$wp_customize->add_setting( $setting, array(
		'default'     => suki_array_value( $defaults, $setting ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimensions' ),
	) );
}
$wp_customize->add_control( new Suki_Customize_Control_Dimensions( $wp_customize, $id, array(
	'settings'    => $settings,
	'section'     => $section,
	'label'       => esc_html__( 'Padding', 'suki' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'max'  => 150,
			'step' => 1,
		),
	),
	'priority'    => 10,
) ) );

// Border
$id = 'content_border';
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
			'max'  => 8,
			'step' => 1,
		),
	),
	'priority'    => 10,
) ) );

// ------
$wp_customize->add_control( new Suki_Customize_Control_HR( $wp_customize, 'hr_narrow_content', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 10,
) ) );

// Narrow Content width
$id = 'narrow_content_width';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'slider' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Narrow Content max width', 'suki' ),
	'units'       => array(
		'px' => array(
			'min'  => 600,
			'max'  => 1000,
			'step' => 1,
		),
	),
	'priority'    => 10,
) ) );

/**
 * ====================================================
 * Colors
 * ====================================================
 */

// ------
$wp_customize->add_control( new Suki_Customize_Control_HR( $wp_customize, 'hr_content_colors', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 30,
) ) );

// Colors
$id = 'content_bg_color';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'color' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Color( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Content Box BG color', 'suki' ),
	'priority'    => 30,
) ) );
