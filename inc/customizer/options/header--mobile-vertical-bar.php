<?php
/**
 * Customizer settings: Header > Mobile Drawer (Popup)
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'suki_section_header_mobile_vertical_bar';

/**
 * ====================================================
 * Layout
 * ====================================================
 */

// Position
$id = 'header_mobile_vertical_bar_position';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $id, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Position', 'suki' ),
	'choices'     => array(
		'left'  => is_rtl() ? esc_html__( 'Right - RTL', 'suki' ) : esc_html__( 'Left', 'suki' ),
		'right' => is_rtl() ? esc_html__( 'Left - RTL', 'suki' ) : esc_html__( 'Right', 'suki' ),
	),
	'priority'    => 10,
) );

// Elements alignment
$id = 'header_mobile_vertical_bar_alignment';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $id, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Elements alignment', 'suki' ),
	'choices'     => array(
		'left'   => is_rtl() ? esc_html__( 'Right - RTL', 'suki' ) : esc_html__( 'Left', 'suki' ),
		'center' => esc_html__( 'Center', 'suki' ),
		'right'  => is_rtl() ? esc_html__( 'Left - RTL', 'suki' ) : esc_html__( 'Right', 'suki' ),
	),
	'priority'    => 10,
) );

// Width
$id = 'header_mobile_vertical_bar_width';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'slider' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Width', 'suki' ),
	'units'       => array(
		'px' => array(
			'min'   => 120,
			'max'   => 400,
			'step'  => 1,
		),
	),
	'priority'    => 10,
) ) );

// Items gap
$id = 'header_mobile_vertical_bar_items_gap';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'slider' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, 'header_mobile_vertical_bar_items_gap', array(
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
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_header_mobile_vertical_bar_typography', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Typography', 'suki' ),
	'priority'    => 20,
) ) );

// Text typography
$settings = array(
	'font_family'    => 'header_mobile_vertical_bar_font_family',
	'font_weight'    => 'header_mobile_vertical_bar_font_weight',
	'font_style'     => 'header_mobile_vertical_bar_font_style',
	'text_transform' => 'header_mobile_vertical_bar_text_transform',
	'font_size'      => 'header_mobile_vertical_bar_font_size',
	'line_height'    => 'header_mobile_vertical_bar_line_height',
	'letter_spacing' => 'header_mobile_vertical_bar_letter_spacing',
);
foreach ( $settings as $id ) {
	$wp_customize->add_setting( $id, array(
		'default'     => suki_array_value( $defaults, $id ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'typography' ),
	) );
}
$wp_customize->add_control( new Suki_Customize_Control_Typography( $wp_customize, 'header_mobile_vertical_bar_typography', array(
	'settings'    => $settings,
	'section'     => $section,
	'label'       => esc_html__( 'Text typography', 'suki' ),
	'priority'    => 20,
) ) );

// Icon size
$id = 'header_mobile_vertical_bar_icon_size';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
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
	'priority'    => 25,
) ) );

/**
 * ====================================================
 * Colors
 * ====================================================
 */

// Heading: Colors
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_header_mobile_vertical_bar_colors', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Colors', 'suki' ),
	'priority'    => 30,
) ) );

// Colors
$colors = array(
	'header_mobile_vertical_bar_section_bg_color'      => esc_html__( 'Background color', 'suki' ),
	'header_mobile_vertical_bar_section_border_color'  => esc_html__( 'Border color', 'suki' ),
	'header_mobile_vertical_bar_text_color'            => esc_html__( 'Text color', 'suki' ),
	'header_mobile_vertical_bar_link_text_color'       => esc_html__( 'Link color', 'suki' ),
	'header_mobile_vertical_bar_link_hover_text_color' => esc_html__( 'Link color :hover', 'suki' ),
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