<?php
/**
 * Customizer settings: General Styles > Blockquote
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'suki_section_blockquote';

// Blockquote typography
$settings = array(
	'font_family'    => 'blockquote_font_family',
	'font_weight'    => 'blockquote_font_weight',
	'font_style'     => 'blockquote_font_style',
	'text_transform' => 'blockquote_text_transform',
	'font_size'      => 'blockquote_font_size',
	'line_height'    => 'blockquote_line_height',
	'letter_spacing' => 'blockquote_letter_spacing',

	'font_size__tablet'      => 'blockquote_font_size__tablet',
	'line_height__tablet'    => 'blockquote_line_height__tablet',
	'letter_spacing__tablet' => 'blockquote_letter_spacing__tablet',

	'font_size__mobile'      => 'blockquote_font_size__mobile',
	'line_height__mobile'    => 'blockquote_line_height__mobile',
	'letter_spacing__mobile' => 'blockquote_letter_spacing__mobile',
);
foreach ( $settings as $key ) {
	$wp_customize->add_setting( $key, array(
		'default'     => suki_array_value( $defaults, $key ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'typography' ),
	) );
}
$wp_customize->add_control( new Suki_Customize_Control_Typography( $wp_customize, 'blockquote_typography', array(
	'settings'    => $settings,
	'section'     => $section,
	'label'       => esc_html__( 'Blockquote typography', 'suki' ),
	'priority'    => 10,
) ) );