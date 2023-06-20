<?php
/**
 * Customizer settings: Global Configurations > Color Palette
 *
 * @package Suki Pro
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$section = 'suki_section_color_palette';

/**
 * ====================================================
 * Color Palette
 * ====================================================
 */

$colors = array(
	'base'        => esc_html__( 'Base', 'suki' ),
	'base_2'      => esc_html__( 'Base 2', 'suki' ),
	'base_3'      => esc_html__( 'Base 3', 'suki' ),
	'contrast'    => esc_html__( 'Contrast', 'suki' ),
	'contrast_2'  => esc_html__( 'Contrast 2', 'suki' ),
	'contrast_3'  => esc_html__( 'Contrast 3', 'suki' ),
	'primary'     => esc_html__( 'Primary', 'suki' ),
	'primary_2'   => esc_html__( 'Primary 2', 'suki' ),
	'secondary'   => esc_html__( 'Secondary', 'suki' ),
	'secondary_2' => esc_html__( 'Secondary 2', 'suki' ),
);

foreach ( $colors as $slug => $label ) {
	// Color.
	$key = 'color_' . $slug;
	$wp_customize->add_setting(
		$key,
		array(
			'default'           => suki_array_value( $defaults, $key ),
			'transport'         => 'postMessage',
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'color' ),
		)
	);
	$wp_customize->add_control(
		new Suki_Customize_Color_Control(
			$wp_customize,
			$key,
			array(
				'section'     => $section,
				'label'       => $label,
				'has_palette' => false,
				'priority'    => 10,
			)
		)
	);
}
