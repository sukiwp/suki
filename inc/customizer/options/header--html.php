<?php
/**
 * Customizer settings: Header > HTML
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'suki_section_header_html';

/**
 * ====================================================
 * HTML 1
 * ====================================================
 */

// Heading: HTML
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_header_html_1', array(
	'section'     => $section,
	'settings'    => array(),
	/* translators: %s: number of HTML element. */
	'label'       => sprintf( esc_html__( 'HTML %s', 'suki' ), 1 ),
	'priority'    => 10,
) ) );

// Content
$key = 'header_html_1_content';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => false,
) );
$wp_customize->add_control( $key, array(
	'type'        => 'textarea',
	'section'     => $section,
	'description' => esc_html__( 'Plain text, HTML tags, and shortcode are allowed.', 'suki' ),
	'priority'    => 10,
) );

// Selective Refresh
if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( $key, array(
		'selector'            => '.suki-header-html-1',
		'container_inclusive' => true,
		'render_callback'     => 'suki_header_element__html_1',
		'fallback_refresh'    => false,
	) );
}