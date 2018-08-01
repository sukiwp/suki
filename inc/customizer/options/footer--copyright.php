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

// Copyright
$id = 'footer_copyright_content';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'html' ),
) );
$wp_customize->add_control( $id, array(
	'type'        => 'textarea',
	'section'     => $section,
	'label'       => esc_html__( 'Copyright Text', 'suki' ),
	'description' => esc_html__( 'Available tags: {{year}}, {{sitename}}, {{themeauthor}}', 'suki' ),
	'priority'    => 10,
) );

// Selective Refresh
if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( $id, array(
		'selector'            => '.suki-footer-copyright',
		'container_inclusive' => true,
		'render_callback'     => 'suki_footer_element__copyright',
		'fallback_refresh'    => false,
	) );
}