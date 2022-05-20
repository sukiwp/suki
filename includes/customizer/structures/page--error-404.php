<?php
/**
 * Customizer settings: Other Pages > 404 Page
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$section = 'suki_section_error_404';

/**
 * ====================================================
 * Layout
 * ====================================================
 */

// Heading: Layout.
$wp_customize->add_control(
	new Suki_Customize_Heading_Control(
		$wp_customize,
		'heading_error_404_layout',
		array(
			'section'  => $section,
			'settings' => array(),
			'label'    => esc_html__( 'Layout', 'suki' ),
			'priority' => 10,
		)
	)
);

// Image.
$key = 'error_404_image';
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
			'label'     => esc_html__( 'Image', 'suki' ),
			'mime_type' => 'image',
			'priority'  => 10,
		)
	)
);

// Width.
$key = 'error_404_image_width';
$wp_customize->add_setting(
	$key,
	array(
		'default'           => suki_array_value( $defaults, $key ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimension' ),
	)
);
$wp_customize->add_control(
	new Suki_Customize_Dimension_Control(
		$wp_customize,
		$key,
		array(
			'section'  => $section,
			'label'    => esc_html__( 'Width', 'suki' ),
			'units'    => array(
				'px'  => array(
					'min'  => 0,
					'step' => 1,
				),
				'em'  => array(
					'min'  => 0,
					'step' => 0.01,
				),
				'rem' => array(
					'min'  => 0,
					'step' => 0.01,
				),
				'%'   => array(
					'min'  => 0,
					'step' => 0.01,
				),
			),
			'priority' => 10,
		)
	)
);

// ------
$wp_customize->add_control(
	new Suki_Customize_HR_Control(
		$wp_customize,
		'hr_error_404_text',
		array(
			'section'  => $section,
			'settings' => array(),
			'priority' => 10,
		)
	)
);

// Title text.
$key = 'error_404_title_text';
$wp_customize->add_setting(
	$key,
	array(
		'default'           => suki_array_value( $defaults, $key ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'text' ),
	)
);
$wp_customize->add_control(
	$key,
	array(
		'section'  => $section,
		'label'    => esc_html__( 'Title text', 'suki' ),
		'priority' => 10,
	)
);

// Description.
$key = 'error_404_description_text';
$wp_customize->add_setting(
	$key,
	array(
		'default'           => suki_array_value( $defaults, $key ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'textarea' ),
	)
);
$wp_customize->add_control(
	$key,
	array(
		'type'     => 'textarea',
		'section'  => $section,
		'label'    => esc_html__( 'Description', 'suki' ),
		'priority' => 10,
	)
);

// Search bar.
$key = 'error_404_search_bar';
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
			'label'    => esc_html__( 'Show search bar', 'suki' ),
			'priority' => 10,
		)
	)
);

// Show "Back to Home" button.
$key = 'error_404_home_button';
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
			'label'    => esc_html__( 'Show Back to Home button', 'suki' ),
			'priority' => 10,
		)
	)
);

// Button text.
$key = 'error_404_home_button_text';
$wp_customize->add_setting(
	$key,
	array(
		'default'           => suki_array_value( $defaults, $key ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'text' ),
	)
);
$wp_customize->add_control(
	$key,
	array(
		'section'  => $section,
		'priority' => 10,
	)
);