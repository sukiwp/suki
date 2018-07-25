<?php
/**
 * Customizer settings: Page Container
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

// Boxed page width
$id = 'boxed_page_width';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'slider' ),
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
	'priority'    => 10,
) ) );

// ------
$wp_customize->add_control( new Suki_Customize_Control_HR( $wp_customize, 'hr_page_container_content', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 10,
) ) );

// Container width
$id = 'container_width';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'slider' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Container width', 'suki' ),
	'description' => esc_html__( 'The maximum width of center content wrapper. This would be applied to all "Fixed width container" sections.', 'suki' ),
	'units'       => array(
		'px' => array(
			'min'  => 500,
			'max'  => 1600,
			'step' => 1,
		),
	),
	'priority'    => 10,
) ) );

// Container side padding
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
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'slider' ),
	) );
}
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $id, array(
	'settings'    => $settings,
	'section'     => $section,
	'label'       => esc_html__( 'Container side padding', 'suki' ),
	'description' => esc_html__( 'Padding on left & right side of each section to prevent collision between content and edges.', 'suki' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'max'  => 60,
			'step' => 1,
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
	'priority'    => 10,
) ) );

/**
 * ====================================================
 * Boxed Page Outside
 * ====================================================
 */

// Heading: Boxed Page Outside
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_outside', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Boxed Page Outside', 'suki' ),
	'priority'    => 20,
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
	'label'       => esc_html__( 'Background color', 'suki' ),
	'priority'    => 20,
) ) );

// Outside background image
$id = 'outside_bg_image';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Background image', 'suki' ),
	'mime_type'   => 'image',
	'priority'    => 20,
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
	'label'       => esc_html__( 'Background position', 'suki' ),
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
	'priority'    => 20,
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
	'label'       => esc_html__( 'Background size', 'suki' ),
	'choices'     => array(
		'auto'    => esc_html__( 'Default image size', 'suki' ),
		'cover'   => esc_html__( 'Cover (fill element)', 'suki' ),
		'contain' => esc_html__( 'Contain (touch element edges)', 'suki' ),
	),
	'priority'    => 20,
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
	'label'       => esc_html__( 'Background repeat', 'suki' ),
	'choices'     => array(
		'no-repeat' => esc_html__( 'No repeat', 'suki' ),
		'repeat-x'  => esc_html__( 'Repeat X (horizontally)', 'suki' ),
		'repeat-y'  => esc_html__( 'Repeat Y (vertically)', 'suki' ),
		'repeat'    => esc_html__( 'Repeat both axis', 'suki' ),
	),
	'priority'    => 20,
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
	'label'       => esc_html__( 'Background attachment', 'suki' ),
	'choices'     => array(
		'scroll' => esc_html__( 'Scroll', 'suki' ),
		'fixed'  => esc_html__( 'Fixed width', 'suki' ),
	),
	'priority'    => 20,
) );