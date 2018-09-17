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
$id = 'page_layout';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $id, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Page layout', 'suki' ),
	'choices'     => array(
		'full-width' => esc_html__( 'Full width', 'suki' ),
		'boxed'      => esc_html__( 'Boxed', 'suki' ),
	),
	'priority'    => 10,
) );

// ------
$wp_customize->add_control( new Suki_Customize_Control_HR( $wp_customize, 'hr_page_container_colors', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 10,
) ) );

// Page background color
$id = 'page_bg_color';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'color' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Color( $wp_customize, $id, array(
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
$id = 'container_width';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Content wrapper width', 'suki' ),
	'description' => esc_html__( 'The maximum width of center content wrapper.', 'suki' ),
	'units'       => array(
		'px' => array(
			'min'  => 500,
			'max'  => 1600,
			'step' => 1,
		),
	),
	'priority'    => 20,
) ) );

// Section side padding
$id = 'edge_padding';
$settings = array(
	$id,
	$id . '__tablet',
	$id . '__mobile',
);
foreach ( $settings as $setting ) {
	$wp_customize->add_setting( $setting, array(
		'default'     => suki_array_value( $defaults, $setting ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimension' ),
	) );
}
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $id, array(
	'settings'    => $settings,
	'section'     => $section,
	'label'       => esc_html__( 'Section side padding', 'suki' ),
	'description' => esc_html__( 'Padding on left & right side of each section to prevent collision between content and edges.', 'suki' ),
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
$id = 'boxed_page_width';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $id, array(
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
$id = 'boxed_page_shadow';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'shadow' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Shadow( $wp_customize, $id, array(
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
$id = 'outside_bg_color';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'color' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Color( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Outside background color', 'suki' ),
	'priority'    => 30,
) ) );

// Outside background image
$id = 'outside_bg_image';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'image' ),
) );
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Outside background image', 'suki' ),
	'mime_type'   => 'image',
	'priority'    => 30,
) ) );

// Outside background position
$id = 'outside_bg_position';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $id, array(
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
$id = 'outside_bg_size';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $id, array(
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
$id = 'outside_bg_repeat';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $id, array(
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
$id = 'outside_bg_attachment';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $id, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Outside background attachment', 'suki' ),
	'choices'     => array(
		'scroll' => esc_html__( 'Scroll', 'suki' ),
		'fixed'  => esc_html__( 'Fixed', 'suki' ),
	),
	'priority'    => 30,
) );