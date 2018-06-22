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
	/* translators: %d: number of HTML element. */
	'label'       => sprintf( esc_html__( 'HTML %d', 'suki' ), 1 ),
	'priority'    => 10,
) ) );

// Content
$id = 'header_html_1_content';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'html' ),
) );
$wp_customize->add_control( $id, array(
	'type'        => 'textarea',
	'section'     => $section,
	'description' => esc_html__( 'Plain text, HTML tags, and shortcode are allowed.', 'suki' ),
	'priority'    => 10,
) );

// Selective Refresh
if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( $id, array(
		'selector'            => '.suki-header-html-1',
		'container_inclusive' => true,
		'render_callback'     => call_user_func( 'suki_header_element', 'html-1' ),
		'fallback_refresh'    => false,
	) );
}

/**
 * ====================================================
 * Suki Pro Teaser
 * ====================================================
 */

if ( suki_show_pro_teaser() ) {
	$wp_customize->add_control( new Suki_Customize_Control_Pro( $wp_customize, 'pro_teaser_header_html_2', array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => esc_html_x( 'HTML 2', 'Suki Pro teaser', 'suki' ),
		'url'         => 'https://sukiwp.com/pro/modules/header/',
		'priority'    => 90,
	) ) );

	$wp_customize->add_control( new Suki_Customize_Control_Pro( $wp_customize, 'pro_teaser_header_html_3', array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => esc_html_x( 'HTML 3', 'Suki Pro teaser', 'suki' ),
		'url'         => 'https://sukiwp.com/pro/modules/header/',
		'priority'    => 90,
	) ) );
}