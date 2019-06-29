<?php
/**
 * Customizer settings: General Styles > Title
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'suki_section_title';

// Typography
$settings = array(
	'font_family'    => 'title_font_family',
	'font_weight'    => 'title_font_weight',
	'font_style'     => 'title_font_style',
	'text_transform' => 'title_text_transform',
	'font_size'      => 'title_font_size',
	'line_height'    => 'title_line_height',
	'letter_spacing' => 'title_letter_spacing',

	'font_size__tablet'      => 'title_font_size__tablet',
	'line_height__tablet'    => 'title_line_height__tablet',
	'letter_spacing__tablet' => 'title_letter_spacing__tablet',

	'font_size__mobile'      => 'title_font_size__mobile',
	'line_height__mobile'    => 'title_line_height__mobile',
	'letter_spacing__mobile' => 'title_letter_spacing__mobile',
);
foreach ( $settings as $key ) {
	$wp_customize->add_setting( $key, array(
		'default'     => suki_array_value( $defaults, $key ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'typography' ),
	) );
}
$wp_customize->add_control( new Suki_Customize_Control_Typography( $wp_customize, 'title_typography', array(
	'settings'    => $settings,
	'section'     => $section,
	'label'       => esc_html__( 'Title typography', 'suki' ),
	'priority'    => 10,
) ) );

// ------
$wp_customize->add_control( new Suki_Customize_Control_HR( $wp_customize, 'hr_title_colors', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 10,
) ) );

// Colors
$colors = array(
	'title_text_color'       => esc_html__( 'Title text color', 'suki' ),
	'title_hover_text_color' => esc_html__( 'Title link text color :hover', 'suki' ),
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