<?php
/**
 * Customizer settings: Footer > Copyright
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'suki_section_footer_copyright';

/**
 * ====================================================
 * Copyright
 * ====================================================
 */

// Heading: HTML
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_footer_copyright', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Copyright', 'suki' ),
	'priority'    => 10,
) ) );

// Copyright
$key = 'footer_copyright_content';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'html' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'textarea',
	'section'     => $section,
	'label'       => esc_html__( 'Copyright Text', 'suki' ),
	'description' => esc_html__( 'Available tags: {{year}}, {{sitename}}, {{theme}}, {{theme_author}}.', 'suki' ),
	'priority'    => 10,
) );

// Selective Refresh
if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( $key, array(
		'selector'            => '.suki-footer-copyright',
		'container_inclusive' => true,
		'render_callback'     => 'suki_footer_element__copyright',
		'fallback_refresh'    => false,
	) );
}