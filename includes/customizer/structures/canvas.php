<?php
/**
 * Customizer settings: Page Canvas
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$section = 'suki_section_page_canvas';

/**
 * ====================================================
 * Canvas
 * ====================================================
 */

// Canvas size.
$key = 'page_layout';
$wp_customize->add_setting(
	$key,
	array(
		'default'           => suki_array_value( $defaults, $key ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
	)
);
$wp_customize->add_control(
	new Suki_Customize_RadioImage_Control(
		$wp_customize,
		$key,
		array(
			'section'  => $section,
			'label'    => esc_html__( 'Canvas size', 'suki' ),
			'choices'  => array(
				'full-width' => array(
					'label' => esc_html__( 'Full width', 'suki' ),
					'image' => trailingslashit( SUKI_IMAGES_URL ) . 'customizer/page-layout--full-width.svg',
				),
				'boxed'      => array(
					'label' => esc_html__( 'Boxed', 'suki' ),
					'image' => trailingslashit( SUKI_IMAGES_URL ) . 'customizer/page-layout--boxed.svg',
				),
			),
			'columns'  => 3,
			'priority' => 10,
		)
	)
);

// Canvas box max width.
$key = 'boxed_page_width';
$wp_customize->add_setting(
	$key,
	array(
		'default'           => suki_array_value( $defaults, $key ),
		'transport'         => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimension' ),
	)
);
$wp_customize->add_control(
	new Suki_Customize_Dimension_Control(
		$wp_customize,
		$key,
		array(
			'section'  => $section,
			'label'    => esc_html__( 'Canvas box max width', 'suki' ),
			'units'    => array(
				'px'  => array(
					'min'  => 600,
					'step' => 1,
				),
				'em'  => array(
					'min'  => 40,
					'step' => 0.01,
				),
				'rem' => array(
					'min'  => 40,
					'step' => 0.01,
				),
			),
			'priority' => 10,
		)
	)
);

// Canvas background color.
$key = 'page_bg_color';
$wp_customize->add_setting(
	$key,
	array(
		'default'           => suki_array_value( $defaults, $key ),
		'transport'         => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'color' ),
	)
);
$wp_customize->add_control(
	new Suki_Customize_Color_Select_Control(
		$wp_customize,
		$key,
		array(
			'section'  => $section,
			'label'    => esc_html__( 'Canvas background color', 'suki' ),
			'priority' => 10,
		)
	)
);

// Canvas box shadow.
$key = 'boxed_page_shadow';
$wp_customize->add_setting(
	$key,
	array(
		'default'           => suki_array_value( $defaults, $key ),
		'transport'         => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'shadow' ),
	)
);
$wp_customize->add_control(
	new Suki_Customize_Shadow_Control(
		$wp_customize,
		$key,
		array(
			'section'  => $section,
			'label'    => esc_html__( 'Canvas box shadow', 'suki' ),
			'priority' => 10,
		)
	)
);

/**
 * ====================================================
 * Outside Background
 * ====================================================
 */

// Heading: Outside Background.
$wp_customize->add_control(
	new Suki_Customize_Heading_Control(
		$wp_customize,
		'heading_outside_bg',
		array(
			'section'  => $section,
			'settings' => array(),
			'label'    => esc_html__( 'Outside Background', 'suki' ),
			'priority' => 20,
		)
	)
);

// Background image.
$key = 'outside_bg_image';
$wp_customize->add_setting(
	$key,
	array(
		'default'           => suki_array_value( $defaults, $key ),
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	new WP_Customize_Media_Control(
		$wp_customize,
		$key,
		array(
			'section'   => $section,
			'label'     => esc_html__( 'Background image', 'suki' ),
			'mime_type' => 'image',
			'priority'  => 20,
		)
	)
);

// Fixed background.
$key = 'outside_bg_parallax';
$wp_customize->add_setting(
	$key,
	array(
		'default'           => suki_array_value( $defaults, $key ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
	)
);
$wp_customize->add_control(
	new Suki_Customize_Toggle_Control(
		$wp_customize,
		$key,
		array(
			'section'  => $section,
			'label'    => esc_html__( 'Fixed background', 'suki' ),
			'priority' => 20,
		)
	)
);

// Repeat background.
$key = 'outside_bg_repeat';
$wp_customize->add_setting(
	$key,
	array(
		'default'           => suki_array_value( $defaults, $key ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
	)
);
$wp_customize->add_control(
	new Suki_Customize_Toggle_Control(
		$wp_customize,
		$key,
		array(
			'section'  => $section,
			'label'    => esc_html__( 'Repeat background', 'suki' ),
			'priority' => 20,
		)
	)
);

// ------
$wp_customize->add_control(
	new Suki_Customize_HR_Control(
		$wp_customize,
		'hr_outside_bg_color',
		array(
			'section'  => $section,
			'settings' => array(),
			'priority' => 20,
		)
	)
);

// Background color.
$key = 'outside_bg_color';
$wp_customize->add_setting(
	$key,
	array(
		'default'           => suki_array_value( $defaults, $key ),
		'transport'         => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'color' ),
	)
);
$wp_customize->add_control(
	new Suki_Customize_Color_Select_Control(
		$wp_customize,
		$key,
		array(
			'section'     => $section,
			'label'       => esc_html__( 'Background / Overlay color', 'suki' ),
			'description' => esc_html__( 'When background image is specified, this color will be used as overlay color.', 'suki' ),
			'priority'    => 20,
		)
	)
);

// Overlay Opacity.
$key = 'outside_bg_color_overlay_dim';
$wp_customize->add_setting(
	$key,
	array(
		'default'           => suki_array_value( $defaults, $key ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'number' ),
	)
);
$wp_customize->add_control(
	new Suki_Customize_Slider_Control(
		$wp_customize,
		$key,
		array(
			'section'  => $section,
			'label'    => esc_html__( 'Overlay Opacity', 'suki' ),
			'min'      => 0,
			'max'      => 100,
			'step'     => 10,
			'priority' => 20,
		)
	)
);
