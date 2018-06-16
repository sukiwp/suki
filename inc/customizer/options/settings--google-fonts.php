<?php
/**
 * Customizer settings: Global Settings > Google Fonts
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

// Additional subsets
$id = 'google_fonts_subsets';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'multiselect' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_MultiCheck( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Additional character subsets', 'suki' ),
	'description' => esc_html__( '"Latin" character subset is included by default.', 'suki' ),
	'choices'     => suki_get_google_fonts_subsets(),
	'priority'    => 10,
) ) );