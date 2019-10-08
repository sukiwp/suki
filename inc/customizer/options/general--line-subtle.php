<?php
/**
 * Customizer settings: General Styles > Border & Subtle Background
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'suki_section_line_subtle';

// Line / border color
$key = 'border_color';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'color' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Color( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Line / border color', 'suki' ),
	'description' => esc_html__( 'Used on &lt;hr&gt; and default border color of all elements.', 'suki' ),
	'priority'    => 10,
) ) );

// Subtle color
$key = 'subtle_color';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'color' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Color( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Subtle background color', 'suki' ),
	'description' => esc_html__( 'Used as background color of &lt;code&gt;, &lt;pre&gt;, tagclouds, and archive title. Usually slightly darker or lighter than the page background color.', 'suki' ),
	'priority'    => 10,
) ) );
