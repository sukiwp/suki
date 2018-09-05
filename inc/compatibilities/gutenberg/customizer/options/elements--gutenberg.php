<?php
/**
 * Customizer settings: General Elements > Gutenberg Elements
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'suki_section_gutenberg';

// "Align Wide" negative margin
$id = 'gutenberg_alignwide_negative_margin';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'slider' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( '"Align Wide" negative margin', 'suki' ),
	'description' => esc_html__( 'This negative margin is only effective on "Narrow content" layout. Otherwise it would be ignored.', 'suki' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'max'  => 300,
			'step' => 1,
		),
	),
	'priority'    => 10,
) ) );

// Heading: Block: Columns
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_gutenberg_columns', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Block: Columns', 'suki' ),
	'priority'    => 10,
) ) );

// Columns gutter
$id = 'gutenberg_columns_gutter';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'slider' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Columns gutter', 'suki' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'max'  => 40,
			'step' => 1,
		),
	),
	'priority'    => 10,
) ) );