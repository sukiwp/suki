<?php
/**
 * Customizer settings: Page Canvas & Wrapper
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'suki_section_page_container';

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
 * Content Wrapper
 * ====================================================
 */

// Heading: Content Wrapper
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_section_container', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Content Wrapper', 'suki' ),
	'priority'    => 20,
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
	'priority'    => 20,
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
	'priority'    => 20,
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
	'priority'    => 30,
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
	'priority'    => 30,
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
	'priority'    => 30,
) ) );

// ------
$wp_customize->add_control( new Suki_Customize_Control_HR( $wp_customize, 'hr_boxed_page_outside', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 30,
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
	'priority'    => 30,
) ) );

// Outside background image
$key = 'outside_bg_image';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'image' ),
) );
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Outside background image', 'suki' ),
	'mime_type'   => 'image',
	'priority'    => 30,
) ) );

// Outside background position
$key = 'outside_bg_position';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Outside background position', 'suki' ),
	'choices'     => array(
		'left top'      => esc_html__( 'Left top', 'suki' ),
		'left center'   => esc_html__( 'Left center', 'suki' ),
		'left bottom'   => esc_html__( 'Left bottom', 'suki' ),
		'center top'    => esc_html__( 'Center top', 'suki' ),
		'center center' => esc_html__( 'Center center', 'suki' ),
		'center bottom' => esc_html__( 'Center bottom', 'suki' ),
		'right top'     => esc_html__( 'Right top', 'suki' ),
		'right center'  => esc_html__( 'Right center', 'suki' ),
		'right bottom'  => esc_html__( 'Right bottom', 'suki' ),
	),
	'priority'    => 30,
) );

// Outside background size
$key = 'outside_bg_size';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Outside background size', 'suki' ),
	'choices'     => array(
		'auto'    => esc_html__( 'Default', 'suki' ),
		'cover'   => esc_html__( 'Cover', 'suki' ),
		'contain' => esc_html__( 'Contain', 'suki' ),
	),
	'priority'    => 30,
) );

// Outside background repeat
$key = 'outside_bg_repeat';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Outside background repeat', 'suki' ),
	'choices'     => array(
		'no-repeat' => esc_html__( 'No repeat', 'suki' ),
		'repeat-x'  => esc_html__( 'Repeat X (horizontally)', 'suki' ),
		'repeat-y'  => esc_html__( 'Repeat Y (vertically)', 'suki' ),
		'repeat'    => esc_html__( 'Repeat both axis', 'suki' ),
	),
	'priority'    => 30,
) );

// Outside background attachment
$key = 'outside_bg_attachment';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Outside background attachment', 'suki' ),
	'choices'     => array(
		'scroll' => esc_html__( 'Scroll', 'suki' ),
		'fixed'  => esc_html__( 'Fixed', 'suki' ),
	),
	'priority'    => 30,
) );