<?php
/**
 * Customizer settings: Global Modules > Google Fonts
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$panel   = 'suki_panel_global_settings';
$section = 'suki_section_google_fonts';

/**
 * ====================================================
 * Sections
 * ====================================================
 */

// Global Modules > Google Fonts.
$wp_customize->add_section(
	$section,
	array(
		'title'    => esc_html__( 'Google Fonts', 'suki' ),
		'panel'    => $panel,
		'priority' => 20,
	)
);

/**
 * ====================================================
 * Global Modules > Google Fonts
 * ====================================================
 */

// Font subsets.
$key = 'google_fonts_subsets';
$wp_customize->add_setting(
	$key,
	array(
		'default'           => suki_array_value( $defaults, $key ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'multiselect' ),
	)
);
$wp_customize->add_control(
	new Suki_Customize_Control_MultiCheck(
		$wp_customize,
		$key,
		array(
			'section'     => $section,
			'label'       => esc_html__( 'Font subsets', 'suki' ),
			'description' => esc_html__( '"Latin" subset is included by default.', 'suki' ),
			'choices'     => Suki_Google_Fonts::instance()->get_subsets(),
			'priority'    => 10,
		)
	)
);

// Load Google Fonts locally.
$key = 'google_fonts_local';
$wp_customize->add_setting(
	$key,
	array(
		'default'           => suki_array_value( $defaults, $key ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
	)
);
$wp_customize->add_control(
	new Suki_Customize_Control_Toggle(
		$wp_customize,
		$key,
		array(
			'section'  => $section,
			'label'    => esc_html__( 'Load Google Fonts locally', 'suki' ),
			'priority' => 20,
		)
	)
);
