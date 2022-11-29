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
		'transport'         => 'postMessage',
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

// ------
$wp_customize->add_control(
	new Suki_Customize_HR_Control(
		$wp_customize,
		'hr_boxed_page',
		array(
			'section'  => $section,
			'settings' => array(),
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

// Outside background color.
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
			'section'  => $section,
			'label'    => esc_html__( 'Outside background color', 'suki' ),
			'priority' => 10,
		)
	)
);

// Outside background image.
$key      = 'outside_bg';
$settings = array(
	'image'      => $key . '_image',
	'attachment' => $key . '_attachment',
	'repeat'     => $key . '_repeat',
	'size'       => $key . '_size',
	'position'   => $key . '_position',
);
foreach ( $settings as $setting ) {
	$wp_customize->add_setting(
		$setting,
		array(
			'default'           => suki_array_value( $defaults, $setting ),
			'transport'         => 'postMessage',
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'background' ),
		)
	);
}
$wp_customize->add_control(
	new Suki_Customize_Background_Control(
		$wp_customize,
		$key,
		array(
			'settings' => $settings,
			'section'  => $section,
			'label'    => esc_html__( 'Outside background image', 'suki' ),
			'priority' => 10,
		)
	)
);
