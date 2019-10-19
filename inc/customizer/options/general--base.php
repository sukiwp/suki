<?php
/**
 * Customizer settings: General Styles > Body (Base)
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'suki_section_base';

// Body (base) text typography
$settings = array(
	'font_family'    => 'body_font_family',
	'font_weight'    => 'body_font_weight',
	'font_style'     => 'body_font_style',
	'text_transform' => 'body_text_transform',
	'font_size'      => 'body_font_size',
	'line_height'    => 'body_line_height',
	'letter_spacing' => 'body_letter_spacing',

	'font_size__tablet'      => 'body_font_size__tablet',
	'line_height__tablet'    => 'body_line_height__tablet',
	'letter_spacing__tablet' => 'body_letter_spacing__tablet',

	'font_size__mobile'      => 'body_font_size__mobile',
	'line_height__mobile'    => 'body_line_height__mobile',
	'letter_spacing__mobile' => 'body_letter_spacing__mobile',
);
foreach ( $settings as $key ) {
	$wp_customize->add_setting( $key, array(
		'default'     => suki_array_value( $defaults, $key ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'typography' ),
	) );
}
$wp_customize->add_control( new Suki_Customize_Control_Typography( $wp_customize, 'body_typography', array(
	'settings'    => $settings,
	'section'     => $section,
	'label'       => esc_html__( 'Body (base) text typography', 'suki' ),
	'responsive'  => true,
	'priority'    => 10,
) ) );

// Enable font smoothing
$key = 'font_smoothing';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Enable font smoothing', 'suki' ),
	'description' => esc_html__( 'For better font rendering on OSX browsers (recommended).', 'suki' ),
	'priority'    => 10,
) ) );

// ------
$wp_customize->add_control( new Suki_Customize_Control_HR( $wp_customize, 'hr_base_colors', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 10,
) ) );

// Colors
$colors = array(
	'body_text_color'       => esc_html__( 'Text color', 'suki' ),
);
foreach ( $colors as $key => $label ) {
	$wp_customize->add_setting( $key, array(
		'default'     => suki_array_value( $defaults, $key ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'color' ),
	) );
	$wp_customize->add_control( new Suki_Customize_Control_Color( $wp_customize, $key, array(
		'section'     => $section,
		'label'       => $label,
		'priority'    => 10,
	) ) );
}