<?php
/**
 * Customizer settings: Global Configurations > Google Fonts
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

// Global Configurations > Google Fonts.
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
 * Global Configurations > Google Fonts
 * ====================================================
 */

// Info.
$wp_customize->add_control(
	new Suki_Customize_Notice_Control(
		$wp_customize,
		'notice_google_fonts',
		array(
			'section'     => $section,
			'settings'    => array(),
			'description' => esc_html__( 'After adding or removing Google Fonts, please publish your changes and then reload the Customizer to load the Google Fonts.', 'suki' ),
			'priority'    => 10,
		)
	)
);

// Info.
$wp_customize->add_control(
	new Suki_Customize_Notice_Control(
		$wp_customize,
		'notice_google_fonts_2',
		array(
			'section'     => $section,
			'settings'    => array(),
			'description' => esc_html__( 'The selected Google Fonts will be loaded on all pages. For performance sake, please choose 3 fonts at maximum.', 'suki' ),
			'priority'    => 10,
		)
	)
);

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
			'section'  => $section,
			'label'    => esc_html__( 'Google Fonts', 'suki' ),
			'choices'  => $google_fonts_choices,
			'priority' => 10,
		)
	)
);

// ------
$wp_customize->add_control(
	new Suki_Customize_HR_Control(
		$wp_customize,
		'hr_google_fonts',
		array(
			'section'  => $section,
			'settings' => array(),
			'priority' => 20,
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
