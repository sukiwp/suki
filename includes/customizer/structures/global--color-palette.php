<?php
/**
 * Customizer settings: Global Modules > Color Palette
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

for ( $i = 1; $i <= 8; $i++ ) {
	// Color.
	$key = 'color_palette_' . $i;
	$wp_customize->add_setting(
		$key,
		array(
			'default'           => suki_array_value( $defaults, $key ),
			'transport'         => 'postMessage',
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'text' ),
		)
	);
	$wp_customize->add_control(
		new Suki_Customize_Color_Control(
			$wp_customize,
			$key,
			array(
				'section'     => $section,
				'has_palette' => false,
				'priority'    => $i * 10,
			)
		)
	);

	// Color name.
	$key = 'color_palette_' . $i . '_name';
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
			'section'     => $section,
			'input_attrs' => array(
				/* translators: %d: color number */
				'placeholder' => sprintf( esc_html__( 'Theme Color %d', 'suki' ), $i ),
			),
			'priority'    => $i * 10,
		)
	);
}
