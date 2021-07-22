<?php
/**
 * Customizer settings: Content & Sidebar > Main Column
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'suki_section_main';

/**
 * ====================================================
 * Layout
 * ====================================================
 */

// Heading: Layout
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_content_main_layout', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Layout', 'suki' ),
	'priority'    => 10,
) ) );

// Padding
$key = 'content_main_padding';
$settings = array(
	$key,
	$key . '__tablet',
	$key . '__mobile',
);
foreach ( $settings as $setting ) {
	$wp_customize->add_setting( $setting, array(
		'default'     => suki_array_value( $defaults, $setting ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimensions' ),
	) );
}
$wp_customize->add_control( new Suki_Customize_Control_Dimensions( $wp_customize, $key, array(
	'settings'    => $settings,
	'section'     => $section,
	'label'       => esc_html__( 'Padding', 'suki' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'step' => 1,
		),
		'em' => array(
			'min'  => 0,
			'step' => 0.01,
		),
		'%' => array(
			'min'  => 0,
			'step' => 0.01,
		),
	),
	'priority'    => 10,
) ) );

// Border
$key = 'content_main_border';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimensions' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Dimensions( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Border', 'suki' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'step' => 1,
		),
	),
	'priority'    => 10,
) ) );

/**
 * ====================================================
 * Typography
 * ====================================================
 */

// // Heading: Typography
// $wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_content_main_typography', array(
// 	'section'     => $section,
// 	'settings'    => array(),
// 	'label'       => esc_html__( 'Typography', 'suki' ),
// 	'description' => sprintf(
// 		/* translators: %s: link to "Base" section. */
// 		esc_html__( 'Inherit the Base typography settings.', 'suki' ),
// 		'<a href="' . esc_attr( add_query_arg( 'autofocus[section]', 'suki_section_body', remove_query_arg( 'autofocus' ) ) ) . '" class="suki-customize-goto-control">' . esc_html__( 'Base', 'suki' ) . '</a>'
// 	),
// 	'priority'    => 20,
// ) ) );

/**
 * ====================================================
 * Colors
 * ====================================================
 */

// Heading: Colors
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_content_main_colors', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Colors', 'suki' ),
	'priority'    => 30,
) ) );

// Colors
$colors = array(
	'content_main_bg_color'     => esc_html__( 'Content Box BG color', 'suki' ),
	'content_main_border_color' => esc_html__( 'Content Box border color', 'suki' ),
);
foreach ( $colors as $key => $label ) {
	$wp_customize->add_setting( $key, array(
		'default'     => suki_array_value( $defaults, $key ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'color' ),
	) );
	$wp_customize->add_control( new Suki_Customize_Control_Color( $wp_customize, $key, array(
		'section'     => $section,
		'label'       => $label,
		'priority'    => 30,
	) ) );
}