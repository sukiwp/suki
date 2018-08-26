<?php
/**
 * Customizer settings: Content & Sidebar > Sidebar Area
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'suki_section_sidebar';

/**
 * ====================================================
 * Layout
 * ====================================================
 */

// Sidebar width
$id = 'sidebar_width';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'slider' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Width', 'suki' ),
	'units'       => array(
		'%' => array(
			'min'  => 15,
			'max'  => 40,
			'step' => 0.05,
		),
		'px' => array(
			'min'  => 150,
			'max'  => 400,
			'step' => 1,
		),
	),
	'priority'    => 10,
) ) );

// Sidebar gap
$id = 'sidebar_gap';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'slider' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Gap with main content', 'suki' ),
	'units'       => array(
		'%' => array(
			'min'  => 0,
			'max'  => 10,
			'step' => 0.01,
		),
		'px' => array(
			'min'  => 0,
			'max'  => 100,
			'step' => 1,
		),
	),
	'priority'    => 10,
) ) );

/**
 * ====================================================
 * Widgets
 * ====================================================
 */

// Heading: Widgets
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_sidebar_widgets', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Widgets', 'suki' ),
	'priority'    => 10,
) ) );

// Widgets mode
$id = 'sidebar_widgets_mode';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $id, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Widgets style', 'suki' ),
	'choices'     => array(
		'merged'    => esc_html__( 'Merged in one box', 'suki' ),
		'separated' => esc_html__( 'Separate boxes', 'suki' ),
	),
	'priority'    => 10,
) );

// Gap between widgets
$id = 'sidebar_widgets_gap';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'slider' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Gap between widgets', 'suki' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'max'  => 80,
			'step' => 1,
		),
	),
	'priority'    => 10,
) ) );

// Padding
$id = 'sidebar_padding';
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
			'max'  => 150,
			'step' => 1,
		),
	),
	'priority'    => 10,
) ) );

// Border
$id = 'sidebar_border';
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
 * Typography
 * ====================================================
 */

// Heading: Typography
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_sidebar_typography', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Typography', 'suki' ),
	'priority'    => 20,
) ) );

// Text typography
$settings = array(
	'font_family'    => 'sidebar_font_family',
	'font_weight'    => 'sidebar_font_weight',
	'font_style'     => 'sidebar_font_style',
	'text_transform' => 'sidebar_text_transform',
	'font_size'      => 'sidebar_font_size',
	'line_height'    => 'sidebar_line_height',
	'letter_spacing' => 'sidebar_letter_spacing',
);
foreach ( $settings as $id ) {
	$wp_customize->add_setting( $id, array(
		'default'     => suki_array_value( $defaults, $id ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'typography' ),
	) );
}
$wp_customize->add_control( new Suki_Customize_Control_Typography( $wp_customize, 'sidebar_typography', array(
	'settings'    => $settings,
	'section'     => $section,
	'label'       => esc_html__( 'Text typography', 'suki' ),
	'priority'    => 20,
) ) );

// Text typography
$settings = array(
	'font_family'    => 'sidebar_font_family',
	'font_weight'    => 'sidebar_font_weight',
	'font_style'     => 'sidebar_font_style',
	'text_transform' => 'sidebar_text_transform',
	'font_size'      => 'sidebar_font_size',
	'line_height'    => 'sidebar_line_height',
	'letter_spacing' => 'sidebar_letter_spacing',

	'font_size__tablet'      => 'sidebar_font_size__tablet',
	'line_height__tablet'    => 'sidebar_line_height__tablet',
	'letter_spacing__tablet' => 'sidebar_letter_spacing__tablet',

	'font_size__mobile'      => 'sidebar_font_size__mobile',
	'line_height__mobile'    => 'sidebar_line_height__mobile',
	'letter_spacing__mobile' => 'sidebar_letter_spacing__mobile',
);
foreach ( $settings as $id ) {
	$wp_customize->add_setting( $id, array(
		'default'     => suki_array_value( $defaults, $id ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'typography' ),
	) );
}
$wp_customize->add_control( new Suki_Customize_Control_Typography( $wp_customize, 'sidebar_typography', array(
	'settings'    => $settings,
	'section'     => $section,
	'label'       => esc_html__( 'Text typography', 'suki' ),
	'priority'    => 20,
) ) );

// Widget title typography
$settings = array(
	'font_family'    => 'sidebar_widget_title_font_family',
	'font_weight'    => 'sidebar_widget_title_font_weight',
	'font_style'     => 'sidebar_widget_title_font_style',
	'text_transform' => 'sidebar_widget_title_text_transform',
	'font_size'      => 'sidebar_widget_title_font_size',
	'line_height'    => 'sidebar_widget_title_line_height',
	'letter_spacing' => 'sidebar_widget_title_letter_spacing',

	'font_size_tablet'      => 'sidebar_widget_title_font_size__tablet',
	'line_height_tablet'    => 'sidebar_widget_title_line_height__tablet',
	'letter_spacing_tablet' => 'sidebar_widget_title_letter_spacing__tablet',

	'font_size_mobile'      => 'sidebar_widget_title_font_size__mobile',
	'line_height_mobile'    => 'sidebar_widget_title_line_height__mobile',
	'letter_spacing_mobile' => 'sidebar_widget_title_letter_spacing__mobile',
);
foreach ( $settings as $id ) {
	$wp_customize->add_setting( $id, array(
		'default'     => suki_array_value( $defaults, $id ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'typography' ),
	) );
}
$wp_customize->add_control( new Suki_Customize_Control_Typography( $wp_customize, 'sidebar_widget_title_typography', array(
	'settings'    => $settings,
	'section'     => $section,
	'label'       => esc_html__( 'Widget title typography', 'suki' ),
	'priority'    => 20,
) ) );

// Widget title alignment
$id = 'sidebar_widget_title_alignment';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $id, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Widget title alignment', 'suki' ),
	'choices'     => array(
		'left'   => is_rtl() ? esc_html__( 'Right', 'suki' ) : esc_html__( 'Left', 'suki' ),
		'center' => esc_html__( 'Center', 'suki' ),
		'right'  => is_rtl() ? esc_html__( 'Left', 'suki' ) : esc_html__( 'Right', 'suki' ),
	),
	'priority'    => 20,
) );

// Widget title decoration
$id = 'sidebar_widget_title_decoration';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $id, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Widget title decoration', 'suki' ),
	'choices'     => array(
		'none'          => esc_html__( 'None', 'suki' ),
		'box'           => esc_html__( 'Box', 'suki' ),
		'border-bottom' => esc_html__( 'Border bottom', 'suki' ),
	),
	'priority'    => 20,
) );

/**
 * ====================================================
 * Colors
 * ====================================================
 */

// Heading: Colors
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_sidebar_colors', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Colors', 'suki' ),
	'priority'    => 30,
) ) );

// Colors
$colors = array(
	'sidebar_bg_color'                  => esc_html__( 'Background color', 'suki' ),
	'sidebar_border_color'              => esc_html__( 'Border color', 'suki' ),
	'sidebar_text_color'                => esc_html__( 'Text color', 'suki' ),
	'sidebar_link_text_color'           => esc_html__( 'Link text color', 'suki' ),
	'sidebar_link_hover_text_color'     => esc_html__( 'Link text color :hover', 'suki' ),
	'sidebar_widget_title_text_color'   => esc_html__( 'Widget title text color', 'suki' ),
	'sidebar_widget_title_bg_color'     => esc_html__( 'Widget title background color', 'suki' ),
	'sidebar_widget_title_border_color' => esc_html__( 'Widget title border color', 'suki' ),
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