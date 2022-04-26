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
		'priority' => 15,
	)
);

/**
 * ====================================================
 * Global Modules > Google Fonts
 * ====================================================
 */

$google_fonts_list = Suki_Google_Fonts::instance()->get_fonts_list();
$google_fonts_keys = array_keys( $google_fonts_list );

$google_fonts_choices = array_combine( $google_fonts_keys, $google_fonts_keys );

// Active Google Fonts.
$key = 'google_fonts';
$wp_customize->add_setting(
	$key,
	array(
		'default'           => suki_array_value( $defaults, $key ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'multiselect' ),
	)
);

$wp_customize->add_control(
	new Suki_Customize_MultiSelect_Control(
		$wp_customize,
		$key,
		array(
			'section'     => $section,
			'label'       => esc_html__( 'Active Google Fonts', 'suki' ),
			'description' => esc_html__( 'Select the Google Fonts that you want to use. These fonts will be loaded on all pages. For performance sake, please choose 3 fonts at maximum.', 'suki' ),
			'choices'     => $google_fonts_choices,
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
	new Suki_Customize_Toggle_Control(
		$wp_customize,
		$key,
		array(
			'section'     => $section,
			'label'       => esc_html__( 'Load Google Fonts locally', 'suki' ),
			'description' => esc_html__( 'Theme will automatically download all Google Fonts you have chosen into your server and serve the fonts locally.', 'suki' ),
			'priority'    => 20,
		)
	)
);
