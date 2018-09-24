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

	if ( $type !== 'main_bar' ) {
		// Merge inside Main Bar
		$id = 'header_' . $type . '_merged';
		$wp_customize->add_setting( $id, array(
			'default'     => suki_array_value( $defaults, $id ),
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
		) );
		$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $id, array(
			'section'     => $section,
			'label'       => esc_html__( 'Merge inside Main Bar wrapper', 'suki' ),
			'description' => esc_html__( 'If enabled, this section layout is limited inside the Main Bar content wrapper. &mdash; Main Bar must have at least 1 element.', 'suki' ),
			'priority'    => 10,
		) ) );

		// ------
		$wp_customize->add_control( new Suki_Customize_Control_HR( $wp_customize, 'hr_header_' . $type . '_merged', array(
			'section'     => $section,
			'settings'    => array(),
			'priority'    => 10,
		) ) );
	}
	
	// Layout
	$id = 'header_' . $type . '_container';
	$wp_customize->add_setting( $id, array(
		'default'     => suki_array_value( $defaults, $id ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
	) );
	$wp_customize->add_control( $id, array(
		'type'        => 'select',
		'section'     => $section,
		'label'       => esc_html__( 'Layout', 'suki' ),
		'choices'     => array(
			'default'            => esc_html__( 'Full width section, wrapped content', 'suki' ),
			'full-width'         => esc_html__( 'Full width content', 'suki' ),
			'full-width-padding' => esc_html__( 'Full width content with side padding', 'suki' ),
			'contained'          => esc_html__( 'Contained section', 'suki' ),
		),
		'priority'    => 10,
	) );

	// Height
	$id = 'header_' . $type . '_height';
	$wp_customize->add_setting( $id, array(
		'default'     => suki_array_value( $defaults, $id ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimension' ),
	) );
	$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $id, array(
		'section'     => $section,
		'label'       => esc_html__( 'Height', 'suki' ),
		'units'       => array(
			'px' => array(
				'min'   => 20,
				'max'   => 300,
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
				'step' => 1,
			),
		),
		'priority'    => 10,
	) ) );

	// Items gutter
	$id = 'header_' . $type . '_items_gutter';
	$wp_customize->add_setting( $id, array(
		'default'     => suki_array_value( $defaults, $id ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimension' ),
	) );
	$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $id, array(
		'section'     => $section,
		'label'       => esc_html__( 'Elements gutter', 'suki' ),
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

	// Menu link typography
	$settings = array(
		'font_family'    => 'header_' . $type . '_menu_font_family',
		'font_weight'    => 'header_' . $type . '_menu_font_weight',
		'font_style'     => 'header_' . $type . '_menu_font_style',
		'text_transform' => 'header_' . $type . '_menu_text_transform',
		'font_size'      => 'header_' . $type . '_menu_font_size',
		'line_height'    => 'header_' . $type . '_menu_line_height',
		'letter_spacing' => 'header_' . $type . '_menu_letter_spacing',
	);
	foreach ( $settings as $id ) {
		$wp_customize->add_setting( $id, array(
			'default'     => suki_array_value( $defaults, $id ),
			'transport'   => 'postMessage',
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'typography' ),
		) );
	}
	$wp_customize->add_control( new Suki_Customize_Control_Typography( $wp_customize, 'header_' . $type . '_menu_typography', array(
		'settings'    => $settings,
		'section'     => $section,
		'label'       => esc_html__( 'Menu link typography', 'suki' ),
		'priority'    => 20,
	) ) );

	// Menu link hover highlight
	$id = 'header_' . $type . '_menu_highlight';
	$wp_customize->add_setting( $id, array(
		'default'     => suki_array_value( $defaults, $id ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
	) );
	$wp_customize->add_control( $id, array(
		'type'        => 'select',
		'section'     => $section,
		'label'       => esc_html__( 'Menu link hover highlight', 'suki' ),
		'choices'     => array(
			'none'          => esc_html__( 'None', 'suki' ),
			'background'    => esc_html__( 'Background', 'suki' ),
			'underline'     => esc_html__( 'Underline', 'suki' ),
			'border-top'    => esc_html__( 'Border top', 'suki' ),
			'border-bottom' => esc_html__( 'Border bottom', 'suki' ),
		),
		'priority'    => 20,
	) );

	// Submenu link typography
	$settings = array(
		'font_family'    => 'header_' . $type . '_submenu_font_family',
		'font_weight'    => 'header_' . $type . '_submenu_font_weight',
		'font_style'     => 'header_' . $type . '_submenu_font_style',
		'text_transform' => 'header_' . $type . '_submenu_text_transform',
		'font_size'      => 'header_' . $type . '_submenu_font_size',
		'line_height'    => 'header_' . $type . '_submenu_line_height',
		'letter_spacing' => 'header_' . $type . '_submenu_letter_spacing',
	);
	foreach ( $settings as $id ) {
		$wp_customize->add_setting( $id, array(
			'default'     => suki_array_value( $defaults, $id ),
			'transport'   => 'postMessage',
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'typography' ),
		) );
	}
	$wp_customize->add_control( new Suki_Customize_Control_Typography( $wp_customize, 'header_' . $type . '_submenu_typography', array(
		'settings'    => $settings,
		'section'     => $section,
		'label'       => esc_html__( 'Submenu link typography', 'suki' ),
		'priority'    => 20,
	) ) );

	// Icon size
	$id = 'header_' . $type . '_icon_size';
	$wp_customize->add_setting( $id, array(
		'default'     => suki_array_value( $defaults, $id ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimension' ),
	) );
	$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $id, array(
		'section'     => $section,
		'label'       => esc_html__( 'Icon size', 'suki' ),
		'units'       => array(
			'px' => array(
				'min'  => 0,
				'max'  => 60,
				'step' => 1,
			),
		),
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
		'header_' . $type . '_bg_color'              => esc_html__( 'Background color', 'suki' ),
		'header_' . $type . '_border_color'          => esc_html__( 'Border color', 'suki' ),
		'header_' . $type . '_text_color'            => esc_html__( 'Text color', 'suki' ),
		'header_' . $type . '_link_text_color'       => esc_html__( 'Link text color', 'suki' ),
		'header_' . $type . '_link_hover_text_color' => esc_html__( 'Link text color :hover', 'suki' ),
		'header_' . $type . '_menu_highlight_color'  => esc_html__( 'Menu link highlight color', 'suki' ),
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
}