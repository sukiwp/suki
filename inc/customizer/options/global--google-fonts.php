<?php
/**
 * Customizer settings: Global Modules > Google Fonts
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'suki_section_google_fonts';

/**
 * ====================================================
 * Google Fonts
 * ====================================================
 */

// Language font subsets
$key = 'google_fonts_subsets';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'multiselect' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_MultiCheck( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Language font subsets', 'suki' ),
	'description' => esc_html__( '"Latin" subset is included by default.', 'suki' ),
	'choices'     => suki_get_google_fonts_subsets(),
	'priority'    => 10,
) ) );