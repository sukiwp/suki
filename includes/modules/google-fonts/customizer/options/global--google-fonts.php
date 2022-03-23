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
			'section'     => $section,
			'label'       => esc_html__( 'Load Google Fonts locally', 'suki' ),
			'description' => esc_html__( 'Theme will automatically download all Google Fonts you have chosen into your server and serve the fonts locally.', 'suki' ),
			'priority'    => 10,
		)
	)
);
