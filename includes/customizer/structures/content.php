<?php
/**
 * Customizer settings: Global Layout > Content Section
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$section = 'suki_section_content';

/**
 * ====================================================
 * Layout
 * ====================================================
 */

// Container width.
$key = 'content_container';
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
			'label'    => esc_html__( 'Container width', 'suki' ),
			'choices'  => array(
				'narrow' => array(
					'label' => esc_html__( 'Narrow', 'suki' ),
				),
				'wide'   => array(
					'label' => esc_html__( 'Wide', 'suki' ),
				),
				'full'   => array(
					'label' => esc_html__( 'Full', 'suki' ),
				),
			),
			'columns'  => 3,
			'priority' => 10,
		)
	)
);

// Info.
$wp_customize->add_control(
	new Suki_Customize_Notice_Control(
		$wp_customize,
		'notice_narrow_content_layout',
		array(
			'section'     => $section,
			'settings'    => array(),
			'description' => esc_html__( 'Narrow container doesn\'t support sidebar.', 'suki' ),
			'priority'    => 10,
		)
	)
);

// Sidebar.
$key = 'content_layout';
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
			'label'    => esc_html__( 'Sidebar', 'suki' ),
			'choices'  => array(
				'no-sidebar'    => array(
					'label' => esc_html__( 'Disabled', 'suki' ),
				),
				'left-sidebar'  => array(
					'label' => esc_html__( 'Left', 'suki' ),
				),
				'right-sidebar' => array(
					'label' => esc_html__( 'Right', 'suki' ),
				),
			),
			'columns'  => 3,
			'priority' => 10,
		)
	)
);

// ------
$wp_customize->add_control(
	new Suki_Customize_HR_Control(
		$wp_customize,
		'hr_content_layout',
		array(
			'section'  => $section,
			'settings' => array(),
			'priority' => 10,
		)
	)
);

// Padding.
$key      = 'content_padding';
$settings = array(
	$key,
	$key . '__tablet',
	$key . '__mobile',
);
foreach ( $settings as $setting ) {
	$wp_customize->add_setting(
		$setting,
		array(
			'default'           => suki_array_value( $defaults, $setting ),
			'transport'         => 'postMessage',
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimensions' ),
		)
	);
}
$wp_customize->add_control(
	new Suki_Customize_Dimensions_Control(
		$wp_customize,
		$key,
		array(
			'settings' => $settings,
			'section'  => $section,
			'label'    => esc_html__( 'Padding', 'suki' ),
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
