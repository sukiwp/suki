<?php
/**
 * Customizer settings: Page Canvas & Wrapper
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'suki_section_page_canvas';

/**
 * ====================================================
 * Page Layout
 * ====================================================
 */

// Page layout
$key = 'page_layout';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_RadioImage( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Page layout', 'suki' ),
	'choices'     => array(
		'full-width' => array(
			'label' => esc_html__( 'Full width', 'suki' ),
			'image' => SUKI_IMAGES_URL . '/customizer/page-layout--full-width.svg',
		),
		'boxed'      => array(
			'label' => esc_html__( 'Boxed', 'suki' ),
			'image' => SUKI_IMAGES_URL . '/customizer/page-layout--boxed.svg',
		),
	),
	'priority'    => 10,
) ) );

// ------
$wp_customize->add_control( new Suki_Customize_Control_HR( $wp_customize, 'hr_page_container_colors', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 10,
) ) );

// Page background color
$key = 'page_bg_color';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'color' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Color( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Page background color', 'suki' ),
	'priority'    => 10,
) ) );

/**
 * ====================================================
 * Boxed Page
 * ====================================================
 */

// Heading: Boxed Page
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_boxed_page', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Boxed Page', 'suki' ),
	'priority'    => 20,
) ) );

// Boxed page width
$key = 'boxed_page_width';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Boxed page max width', 'suki' ),
	'units'       => array(
		'px' => array(
			'min'  => 500,
			'max'  => 2000,
			'step' => 1,
		),
	),
	'priority'    => 20,
) ) );

// Boxed page shadow
$key = 'boxed_page_shadow';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'shadow' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Shadow( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Boxed page shadow', 'suki' ),
	'priority'    => 20,
) ) );

// ------
$wp_customize->add_control( new Suki_Customize_Control_HR( $wp_customize, 'hr_boxed_page_outside', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 20,
) ) );

// Outside background color
$key = 'outside_bg_color';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'color' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Color( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Outside background color', 'suki' ),
	'priority'    => 20,
) ) );

// Outside background image
$key = 'outside_bg';
$settings = array(
	'image'      => $key . '_image',
	'attachment' => $key . '_attachment',
	'repeat'     => $key . '_repeat',
	'size'       => $key . '_size',
	'position'   => $key . '_position',
);
foreach ( $settings as $setting ) {
	$wp_customize->add_setting( $setting, array(
		'default'     => suki_array_value( $defaults, $setting ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'background' ),
	) );
}
$wp_customize->add_control( new Suki_Customize_Control_Background( $wp_customize, $key, array(
	'settings'    => $settings,
	'section'     => $section,
	'label'       => esc_html__( 'Outside background image', 'suki' ),
	'priority'    => 20,
) ) );

/**
 * ====================================================
 * Content Wrapper
 * ====================================================
 */

// Heading: Content Wrapper
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_section_container', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Content Wrapper', 'suki' ),
	'priority'    => 30,
) ) );

// Content wrapper width
$key = 'container_width';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Content wrapper width', 'suki' ),
	'units'       => array(
		'px' => array(
			'min'  => 600,
			'max'  => 1600,
			'step' => 1,
		),
	),
	'priority'    => 30,
) ) );

// Narrow content max width
$key = 'content_narrow_width';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Narrow content wrapper width', 'suki' ),
	'description' => esc_html__( 'Used when "narrow content" layout is active on page content. It should be less than the content wrapper width.', 'suki' ),
	'units'       => array(
		'px' => array(
			'min'  => 600,
			'max'  => 1600,
			'step' => 1,
		),
	),
	'priority'    => 30,
) ) );