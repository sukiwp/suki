<?php
/**
 * Customizer settings: Footer > Bottom Bar
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'suki_section_footer_bottom_bar';

/**
 * ====================================================
 * Layout
 * ====================================================
 */

// Section container
$id = 'footer_bottom_bar_container';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $id, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Section container', 'suki' ),
	'choices'     => array(
		'default'            => esc_html__( 'Fixed width container', 'suki' ),
		'full-width'         => esc_html__( 'Full container', 'suki' ),
		'full-width-padding' => esc_html__( 'Full container with edge tolerance padding', 'suki' ),
		'contained'          => esc_html__( 'Contained section', 'suki' ),
	),
	'priority'    => 10,
) );

// Padding
$id = 'footer_bottom_bar_padding';
$settings = array(
	$id,
	$id . '__tablet',
	$id . '__mobile',
);
foreach ( $settings as $setting ) {
	$wp_customize->add_setting( $setting, array(
		'default'     => suki_array_value( $defaults, $setting ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimensions' ),
	) );
}
$wp_customize->add_control( new Suki_Customize_Control_Dimensions( $wp_customize, $id, array(
	'settings'    => $settings,
	'section'     => $section,
	'label'       => esc_html__( 'Padding', 'suki' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'max'  => 110,
			'step' => 1,
		),
	),
	'priority'    => 10,
) ) );

// Border
$id = 'footer_bottom_bar_border';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimensions' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Dimensions( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Border', 'suki' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'max'  => 8,
			'step' => 1,
		),
	),
	'priority'    => 10,
) ) );

/**
 * ====================================================
 * Colors
 * ====================================================
 */

// Heading: Colors
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_footer_bottom_bar_colors', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Colors', 'suki' ),
	'priority'    => 30,
) ) );

// Colors
$colors = array(
	'footer_bottom_bar_section_bg_color'        => esc_html__( 'Background color', 'suki' ),
	'footer_bottom_bar_section_border_color'    => esc_html__( 'Border color', 'suki' ),
	'footer_bottom_bar_text_color'              => esc_html__( 'Text color', 'suki' ),
	'footer_bottom_bar_link_text_color'         => esc_html__( 'Link text color', 'suki' ),
	'footer_bottom_bar_link_hover_text_color'   => esc_html__( 'Link hover text color', 'suki' ),
);
foreach ( $colors as $id => $label ) {
	$wp_customize->add_setting( $id, array(
		'default'     => suki_array_value( $defaults, $id ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'color' ),
	) );
	$wp_customize->add_control( new Suki_Customize_Control_Color( $wp_customize, $id, array(
		'section'     => $section,
		'label'       => $label,
		'priority'    => 30,
	) ) );
}

/**
 * ====================================================
 * Suki Pro Teaser
 * ====================================================
 */

if ( suki_show_pro_teaser() ) {
	$wp_customize->add_control( new Suki_Customize_Control_Pro( $wp_customize, 'pro_teaser_footer_bottom_bar_typography', array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => esc_html_x( 'Typography', 'Suki Pro teaser', 'suki' ),
		'url'         => 'https://sukiwp.com/pro/modules/typography/',
		'priority'    => 90,
	) ) );

	$wp_customize->add_control( new Suki_Customize_Control_Pro( $wp_customize, 'pro_teaser_footer_bottom_bar_icon_typography', array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => esc_html_x( 'Icon Size', 'Suki Pro teaser', 'suki' ),
		'url'         => 'https://sukiwp.com/pro/modules/typography/',
		'priority'    => 90,
	) ) );
}