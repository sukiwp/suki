<?php
/**
 * Customizer settings: General Styles > Headings
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'suki_section_headings';

for ( $i = 1; $i <= 4; $i++ ) {
	// Heading %s typography
	$settings = array(
		'font_family'    => 'h' . $i . '_font_family',
		'font_weight'    => 'h' . $i . '_font_weight',
		'font_style'     => 'h' . $i . '_font_style',
		'text_transform' => 'h' . $i . '_text_transform',
		'font_size'      => 'h' . $i . '_font_size',
		'line_height'    => 'h' . $i . '_line_height',
		'letter_spacing' => 'h' . $i . '_letter_spacing',

		'font_size__tablet'      => 'h' . $i . '_font_size__tablet',
		'line_height__tablet'    => 'h' . $i . '_line_height__tablet',
		'letter_spacing__tablet' => 'h' . $i . '_letter_spacing__tablet',

		'font_size__mobile'      => 'h' . $i . '_font_size__mobile',
		'line_height__mobile'    => 'h' . $i . '_line_height__mobile',
		'letter_spacing__mobile' => 'h' . $i . '_letter_spacing__mobile',
	);
	foreach ( $settings as $key ) {
		$wp_customize->add_setting( $key, array(
			'default'     => suki_array_value( $defaults, $key ),
			'transport'   => 'postMessage',
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'typography' ),
		) );
	}
	$wp_customize->add_control( new Suki_Customize_Control_Typography( $wp_customize, 'h' . $i . '_typography', array(
		'settings'    => $settings,
		'section'     => $section,
		/* translators: %1$s: heading level number. */
		'label'       => sprintf( esc_html__( 'Heading %1$s (H%1$s) typography', 'suki' ), $i ),
		'priority'    => 10,
	) ) );
}

// ------
$wp_customize->add_control( new Suki_Customize_Control_HR( $wp_customize, 'hr_headings_colors', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 10,
) ) );

// Colors
$colors = array(
	'heading_text_color'       => esc_html__( 'Heading text color', 'suki' ),
	'heading_hover_text_color' => esc_html__( 'Heading link text color :hover', 'suki' ),
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