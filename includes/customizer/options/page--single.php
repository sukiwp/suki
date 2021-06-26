<?php
/**
 * Customizer settings: Other Pages > Static Page
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'suki_section_page_single';

/**
 * ====================================================
 * Featured Image
 * ====================================================
 */

// Heading: Featured Image
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_page_single_content_thumbnail', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Featured Image', 'suki' ),
	'priority'    => 20,
) ) );

// Featured image
$key = 'page_single_content_thumbnail';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
	'section'     => $section,
	// 'label'       => esc_html__( 'Display', 'suki' ),
	'choices'     => array(
		''       => esc_html__( 'Disabled', 'suki' ),
		'before' => esc_html__( 'Before Content Header', 'suki' ),
		'after'  => esc_html__( 'After Content Header', 'suki' ),
	),
	'priority'    => 20,
) );

// Wide alignment
$key = 'page_single_content_thumbnail_wide';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Wide alignment on Narrow container', 'suki' ),
	'description' => esc_attr__( 'When the section container is set to Narrow, make the Featured Image wide.', 'suki' ),
	'priority'    => 20,
) ) );