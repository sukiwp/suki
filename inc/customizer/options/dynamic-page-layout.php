<?php
/**
 * Customizer settings: Dynamic Page Layout
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

foreach ( Suki_Customizer::instance()->get_all_page_settings_types() as $ps_type => $ps_data ) {
	$section = suki_array_value( $ps_data, 'section' );
	$option_key = 'page_settings_' . $ps_type;

	// Get default value (array) of the option key.
	$default = suki_array_value( $defaults, $option_key, array() );
	if ( ! is_array( $default ) ) {
		$default = array();
	}

	// Heading: Dynamic Page Layout
	$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_page_settings_' . $ps_type, array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => esc_html__( 'Dynamic Page Layout', 'suki' ),
		'description' => suki_array_value( $ps_data, 'description' ),
		'priority'    => 100,
	) ) );

	/**
	 * ====================================================
	 * Content
	 * ====================================================
	 */

	// Container width
	$subkey = 'content_container';
	$key = $option_key . '[' . $subkey . ']';
	$wp_customize->add_setting( $key, array(
		'default'     => suki_array_value( $default, $subkey ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
	) );
	$wp_customize->add_control( new Suki_Customize_Control_RadioImage( $wp_customize, $key, array(
		'section'     => $section,
		'label'       => esc_html__( 'Container width', 'suki' ),
		'choices'     => array(
			''           => array(
				'label' => esc_html__( '(Default)', 'suki' ),
				'image' => SUKI_IMAGES_URL . '/customizer/default.svg',
			),
			'default'    => array(
				'label' => esc_html__( 'Normal', 'suki' ),
				'image' => SUKI_IMAGES_URL . '/customizer/content-container--default.svg',
			),
			'full-width' => array(
				'label' => esc_html__( 'Full width', 'suki' ),
				'image' => SUKI_IMAGES_URL . '/customizer/content-container--full-width.svg',
			),
			'custom'     => array(
				'label' => esc_html__( 'Custom', 'suki' ),
				'image' => SUKI_IMAGES_URL . '/customizer/content-container--full-width.svg',
			),
		),
		'priority'    => 110,
	) ) );

	// Container width -- value
	$subkey = 'content_container_width';
	$key = $option_key . '[' . $subkey . ']';
	$wp_customize->add_setting( $key, array(
		'default'     => suki_array_value( $default, $subkey ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimension' ),
	) );
	$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $key, array(
		'section'     => $section,
		// 'label'       => esc_html__( 'Container width', 'suki' ),
		'units'       => array(
			'px' => array(
				'min'   => 600,
				'max'   => 1600,
				'step'  => 1,
			),
		),
		'priority'    => 110,
	) ) );

	// Sidebar
	$subkey = 'content_layout';
	$key = $option_key . '[' . $subkey . ']';
	$wp_customize->add_setting( $key, array(
		'default'     => suki_array_value( $default, $subkey ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
	) );
	$wp_customize->add_control( new Suki_Customize_Control_RadioImage( $wp_customize, $key, array(
		'section'     => $section,
		'label'       => esc_html__( 'Sidebar', 'suki' ),
		'choices'     => array(
			''              => array(
				'label' => esc_html__( '(Default)', 'suki' ),
				'image' => SUKI_IMAGES_URL . '/customizer/default.svg',
			),
			'wide'          => array(
				'label' => esc_html__( 'None', 'suki' ),
				'image' => SUKI_IMAGES_URL . '/customizer/content-sidebar-layout--wide.svg',
			),
			'left-sidebar'  => array(
				'label' => is_rtl() ? esc_html__( 'Right', 'suki' ) : esc_html__( 'Left', 'suki' ),
				'image' => SUKI_IMAGES_URL . '/customizer/content-sidebar-layout--left-sidebar.svg',
			),
			'right-sidebar' => array(
				'label' => is_rtl() ? esc_html__( 'Left', 'suki' ) : esc_html__( 'Right', 'suki' ),
				'image' => SUKI_IMAGES_URL . '/customizer/content-sidebar-layout--right-sidebar.svg',
			),
		),
		'priority'    => 110,
	) ) );

	/**
	 * ====================================================
	 * Header
	 * ====================================================
	 */

	// ------
	$wp_customize->add_control( new Suki_Customize_Control_HR( $wp_customize, 'hr_page_settings_' . $ps_type . '_header', array(
		'section'     => $section,
		'settings'    => array(),
		'priority'    => 120,
	) ) );

	// Header
	$wp_customize->add_control( new Suki_Customize_Control_Blank( $wp_customize, 'label_page_settings_' . $ps_type . '__disable_header', array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => esc_html__( 'Header', 'suki' ),
		'priority'    => 120,
	) ) );

		// Desktop
		$subkey = 'disable_header';
		$key = $option_key . '[' . $subkey . ']';
		$wp_customize->add_setting( $key, array(
			'default'     => suki_array_value( $default, $subkey ),
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
		) );
		$wp_customize->add_control( $key, array(
			'type'        => 'select',
			'section'     => $section,
			'label'       => esc_html__( 'Desktop', 'suki' ),
			'choices'     => array(
				''  => esc_html__( '&#x2714; Enabled', 'suki' ),
				'1' => esc_html__( '&#x2718; Disabled', 'suki' ),
			),
			'priority'    => 120,
		) );

		// Mobile
		$subkey = 'disable_mobile_header';
		$key = $option_key . '[' . $subkey . ']';
		$wp_customize->add_setting( $key, array(
			'default'     => suki_array_value( $default, $subkey ),
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
		) );
		$wp_customize->add_control( $key, array(
			'type'        => 'select',
			'section'     => $section,
			'label'       => esc_html__( 'Mobile', 'suki' ),
			'choices'     => array(
				''  => esc_html__( '&#x2714; Enabled', 'suki' ),
				'1' => esc_html__( '&#x2718; Disabled', 'suki' ),
			),
			'priority'    => 120,
		) );

	/**
	 * ====================================================
	 * Footer
	 * ====================================================
	 */

	// // Heading: Footer
	// $wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_page_settings_' . $ps_type . '_footer', array(
	// 	'section'     => $section,
	// 	'settings'    => array(),
	// 	'label'       => esc_html__( 'Footer', 'suki' ),
	// 	'priority'    => 40,
	// ) ) );

	// ------
	$wp_customize->add_control( new Suki_Customize_Control_HR( $wp_customize, 'hr_page_settings_' . $ps_type . '_footer', array(
		'section'     => $section,
		'settings'    => array(),
		'priority'    => 140,
	) ) );

	// Footer widgets
	$subkey = 'disable_footer_widgets';
	$key = $option_key . '[' . $subkey . ']';
	$wp_customize->add_setting( $key, array(
		'default'     => suki_array_value( $default, $subkey ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
	) );
	$wp_customize->add_control( $key, array(
		'type'        => 'select',
		'section'     => $section,
		'label'       => esc_html__( 'Footer widgets', 'suki' ),
		'choices'     => array(
			''  => esc_html__( '&#x2714; Enabled', 'suki' ),
			'1' => esc_html__( '&#x2718; Disabled', 'suki' ),
		),
		'priority'    => 140,
	) );

	// Footer bottom
	$subkey = 'disable_footer_bottom';
	$key = $option_key . '[' . $subkey . ']';
	$wp_customize->add_setting( $key, array(
		'default'     => suki_array_value( $default, $subkey ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
	) );
	$wp_customize->add_control( $key, array(
		'type'        => 'select',
		'section'     => $section,
		'label'       => esc_html__( 'Footer bottom', 'suki' ),
		'choices'     => array(
			''  => esc_html__( '&#x2714; Enabled', 'suki' ),
			'1' => esc_html__( '&#x2718; Disabled', 'suki' ),
		),
		'priority'    => 140,
	) );
}