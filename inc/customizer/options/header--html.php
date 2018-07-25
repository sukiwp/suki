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
		'render_callback'     => 'suki_header_element__html_1',
		'fallback_refresh'    => false,
	) );
}

/**
 * ====================================================
 * Suki Pro Upsell
 * ====================================================
 */

if ( suki_show_pro_teaser() ) {
	$wp_customize->add_control( new Suki_Customize_Control_Pro_Teaser( $wp_customize, 'pro_teaser_header_html', array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => esc_html_x( 'More Options on Suki Pro', 'Suki Pro upsell', 'suki' ),
		'url'         => SUKI_PRO_URL,
		'features'    => array(
			esc_html_x( 'Additional "HTML 2" element on Header Builder', 'Suki Pro upsell', 'suki' ),
			esc_html_x( 'Additional "HTML 3" element on Header Builder', 'Suki Pro upsell', 'suki' ),
		),
		'priority'    => 90,
	) ) );
}