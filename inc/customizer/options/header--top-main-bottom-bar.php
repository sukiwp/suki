<?php
/**
 * Customizer settings:
 * - Header > Top Bar
 * - Header > Main Bar
 * - Header > Bottom Bar
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

foreach ( array( 'top_bar', 'main_bar', 'bottom_bar' ) as $type ) {
	
	$section = 'suki_section_header_' . $type;

	/**
	 * ====================================================
	 * Layout
	 * ====================================================
	 */
	
	// Section container
	$id = 'header_' . $type . '_container';
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

	// Height
	$id = 'header_' . $type . '_height';
	$wp_customize->add_setting( $id, array(
		'default'     => suki_array_value( $defaults, $id ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'slider' ),
	) );
	$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $id, array(
		'section'     => $section,
		'label'       => esc_html__( 'Height', 'suki' ),
		'units'       => array(
			'px' => array(
				'min'   => 20,
				'max'   => 120,
				'step'  => 1,
			),
		),
		'priority'    => 10,
	) ) );

	// Padding
	$id = 'header_' . $type . '_padding';
	$wp_customize->add_setting( $id, array(
		'default'     => suki_array_value( $defaults, $id ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimensions' ),
	) );
	$wp_customize->add_control( new Suki_Customize_Control_Dimensions( $wp_customize, $id, array(
		'section'     => $section,
		'label'       => esc_html__( 'Padding', 'suki' ),
		'units'       => array(
			'px' => array(
				'min'  => 0,
				'max'  => 120,
				'step' => 1,
			),
		),
		'priority'    => 10,
	) ) );

	// Border
	$id = 'header_' . $type . '_border';
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

	// Items gap
	$id = 'header_' . $type . '_items_gap';
	$wp_customize->add_setting( $id, array(
		'default'     => suki_array_value( $defaults, $id ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'slider' ),
	) );
	$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $id, array(
		'section'     => $section,
		'label'       => esc_html__( 'Gap between elements', 'suki' ),
		'units'       => array(
			'px' => array(
				'min'   => 0,
				'max'   => 40,
				'step'  => 1,
			),
		),
		'priority'    => 10,
	) ) );

	/**
	 * ====================================================
	 * Typography
	 * ====================================================
	 */

	// Heading: Typography
	$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_header_' . $type . '_typography', array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => esc_html__( 'Typography', 'suki' ),
		'priority'    => 20,
	) ) );

	// Text typography
	$settings = array(
		'font_family'    => 'header_' . $type . '_font_family',
		'font_weight'    => 'header_' . $type . '_font_weight',
		'font_style'     => 'header_' . $type . '_font_style',
		'text_transform' => 'header_' . $type . '_text_transform',
		'font_size'      => 'header_' . $type . '_font_size',
		'line_height'    => 'header_' . $type . '_line_height',
		'letter_spacing' => 'header_' . $type . '_letter_spacing',
	);
	foreach ( $settings as $id ) {
		$wp_customize->add_setting( $id, array(
			'default'     => suki_array_value( $defaults, $id ),
			'transport'   => 'postMessage',
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'typography' ),
		) );
	}
	$wp_customize->add_control( new Suki_Customize_Control_Typography( $wp_customize, 'header_' . $type . '_typography', array(
		'settings'    => $settings,
		'section'     => $section,
		'label'       => esc_html__( 'Text typography', 'suki' ),
		'priority'    => 20,
	) ) );

	/**
	 * ====================================================
	 * Colors
	 * ====================================================
	 */

	// Heading: Colors
	$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_header_' . $type . '_colors', array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => esc_html__( 'Colors', 'suki' ),
		'priority'    => 30,
	) ) );

	// Colors
	$colors = array(
		'header_' . $type . '_section_bg_color'      => esc_html__( 'Background color', 'suki' ),
		'header_' . $type . '_section_border_color'  => esc_html__( 'Border color', 'suki' ),
		'header_' . $type . '_text_color'            => esc_html__( 'Text color', 'suki' ),
		'header_' . $type . '_link_text_color'       => esc_html__( 'Link color', 'suki' ),
		'header_' . $type . '_link_hover_text_color' => esc_html__( 'Link color :hover', 'suki' ),
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
	 * Suki Pro Upsell
	 * ====================================================
	 */

	if ( suki_show_pro_teaser() ) {
		$wp_customize->add_control( new Suki_Customize_Control_Pro( $wp_customize, 'pro_teaser_header_' . $type, array(
			'section'     => $section,
			'settings'    => array(),
			'label'       => esc_html_x( 'More Options on Suki Pro', 'Suki Pro upsell', 'suki' ),
			'url'         => SUKI_PRO_URL,
			'features'    => array(
				esc_html_x( 'More typography options', 'Suki Pro upsell', 'suki' ),
				esc_html_x( 'Menu highlight effects', 'Suki Pro upsell', 'suki' ),
				esc_html_x( 'Icon size', 'Suki Pro upsell', 'suki' ),
			),
			'priority'    => 90,
		) ) );
	}
}