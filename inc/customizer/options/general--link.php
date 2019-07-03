<?php
/**
 * Customizer settings: General Styles > Link
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'suki_section_link';

// Typography
$settings = array(
	'font_weight'    => 'link_font_weight',
	'font_style'     => 'link_font_style',
	'text_transform' => 'link_text_transform',
);
foreach ( $settings as $key ) {
	$wp_customize->add_setting( $key, array(
		'default'     => suki_array_value( $defaults, $key ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'typography' ),
	) );
}
$wp_customize->add_control( new Suki_Customize_Control_Typography( $wp_customize, 'link_typography', array(
	'settings'    => $settings,
	'section'     => $section,
	'label'       => esc_html__( 'Link typography', 'suki' ),
	'priority'    => 20,
) ) );

// ------
$wp_customize->add_control( new Suki_Customize_Control_HR( $wp_customize, 'hr_link_colors', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 20,
) ) );

// Colors
$colors = array(
	'link_text_color'       => esc_html__( 'Link text color', 'suki' ),
	'link_hover_text_color' => esc_html__( 'Link text color :hover', 'suki' ),
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
		'priority'    => 20,
	) ) );
}