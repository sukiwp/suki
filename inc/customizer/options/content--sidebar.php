<?php
/**
 * Customizer settings: Sidebar
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'suki_section_sidebar';

// Widgets
$wp_customize->add_control( new Suki_Customize_Control_Blank( $wp_customize, 'sidebar_widgets', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Add / remove widgets', 'suki' ),
	'description' => '<a href="' . esc_url( add_query_arg( 'autofocus[section]', 'sidebar-widgets-sidebar' ) ) . '" class="suki-customize-goto-control button button-secondary">' . esc_html__( 'Edit Widgets on Sidebar', 'suki' ) . '</a>',
	'priority'    => 0,
) ) );

/**
 * ====================================================
 * Layout
 * ====================================================
 */

// Heading: Layout
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_sidebar_layout', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Layout', 'suki' ),
	'priority'    => 10,
) ) );

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

// Separator border
$id = 'sidebar_separator_border';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'slider' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Separator border', 'suki' ),
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

// ------
$wp_customize->add_control( new Suki_Customize_Control_HR( $wp_customize, 'hr_sidebar_layout', array(
	'section'     => $section,
	'settings'    => array(),
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
	$wp_customize->add_control( new Suki_Customize_Control_Pro( $wp_customize, 'pro_teaser_sidebar', array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => esc_html_x( 'More Options on Suki Pro', 'Suki Pro upsell', 'suki' ),
		'url'         => SUKI_PRO_URL,
		'features'    => array(
			esc_html_x( 'More typography options', 'Suki Pro upsell', 'suki' ),
			esc_html_x( 'More widget title styles', 'Suki Pro upsell', 'suki' ),
		),
		'priority'    => 90,
	) ) );
}