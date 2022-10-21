<?php
/**
 * Customizer settings: Global Elements > Blockquote
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$section = 'suki_section_global_size_spacing';

// Narrow container width.
$key = 'container_narrow_width';
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
			'section'     => $section,
			'label'       => esc_html__( 'Narrow container width', 'suki' ),
			'description' => esc_html__( 'Should be smaller than the Wide container width.', 'suki' ),
			'units'       => array(
				'px'  => array(
					'min'  => 400,
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
			),
			'priority'    => 10,
		)
	)
);

// Wide container width.
$key = 'container_wide_width';
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
			'label'    => esc_html__( 'Wide container width', 'suki' ),
			'units'    => array(
				'px'  => array(
					'min'  => 600,
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
			),
			'priority' => 10,
		)
	)
);

// Block spacing.
$key = 'block_spacing';
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
			'section'     => $section,
			'label'       => esc_html__( 'Block spacing', 'suki' ),
			'description' => esc_html__( 'Global spacing between each block.', 'suki' ),
			'units'       => array(
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
			),
			'priority'    => 10,
		)
	)
);
