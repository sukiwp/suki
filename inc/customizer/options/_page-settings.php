<?php
/**
 * Customizer settings: Individual Page Layout
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

	// Heading: Individual Page Layout
	$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_page_settings_' . $ps_type, array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => esc_html__( 'Individual Page Layout', 'suki' ),
		'description' => suki_array_value( $ps_data, 'description' ),
		'priority'    => 100,
	) ) );

	/**
	 * ====================================================
	 * Content
	 * ====================================================
	 */

	if ( 'error_404' !== $ps_type ) {
		// Content container
		$subkey = 'content_container';
		$key = $option_key . '[' . $subkey . ']';
		$wp_customize->add_setting( $key, array(
			'default'     => suki_array_value( $default, $subkey ),
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
		) );
		$wp_customize->add_control( new Suki_Customize_Control_RadioImage( $wp_customize, $key, array(
			'section'     => $section,
			'label'       => esc_html__( 'Content container', 'suki' ),
			'choices'     => array(
				''           => array(
					'label' => esc_html__( '-- Global --', 'suki' ),
					'image' => SUKI_IMAGES_URL . '/customizer/default.svg',
				),
				'narrow'     => array(
					'label' => esc_html__( 'Narrow', 'suki' ),
					'image' => SUKI_IMAGES_URL . '/customizer/content-container--narrow.svg',
				),
				'default'    => array(
					'label' => esc_html__( 'Normal', 'suki' ),
					'image' => SUKI_IMAGES_URL . '/customizer/content-container--default.svg',
				),
				'full-width' => array(
					'label' => esc_html__( 'Full width', 'suki' ),
					'image' => SUKI_IMAGES_URL . '/customizer/content-container--full-width.svg',
				),
			),
			'columns'     => 4,
			'priority'    => 110,
		) ) );

		// Info
		$subkey = 'notice_narrow_content_layout';
		$key = $option_key . '[' . $subkey . ']';
		$wp_customize->add_control( new Suki_Customize_Control_Blank( $wp_customize, $key, array(
			'section'     => $section,
			'settings'    => array(),
			'description' => '<div class="notice notice-info notice-alt inline"><p>' . esc_html__( 'Narrow content layout doesn\'t support sidebar.', 'suki' ) . '</p></div>',
			'priority'    => 110,
		) ) );

		// Sidebar position
		$subkey = 'content_layout';
		$key = $option_key . '[' . $subkey . ']';
		$wp_customize->add_setting( $key, array(
			'default'     => suki_array_value( $default, $subkey ),
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
		) );
		$wp_customize->add_control( new Suki_Customize_Control_RadioImage( $wp_customize, $key, array(
			'section'     => $section,
			'label'       => esc_html__( 'Sidebar position', 'suki' ),
			'choices'     => array(
				''              => array(
					'label' => esc_html__( '-- Global --', 'suki' ),
					'image' => SUKI_IMAGES_URL . '/customizer/default.svg',
				),
				'wide'          => array(
					'label' => esc_html__( 'None', 'suki' ),
					'image' => SUKI_IMAGES_URL . '/customizer/content-sidebar-layout--wide.svg',
				),
				'right-sidebar' => array(
					'label' => is_rtl() ? esc_html__( 'Left', 'suki' ) : esc_html__( 'Right', 'suki' ),
					'image' => SUKI_IMAGES_URL . '/customizer/content-sidebar-layout--right-sidebar.svg',
				),
				'left-sidebar'  => array(
					'label' => is_rtl() ? esc_html__( 'Right', 'suki' ) : esc_html__( 'Left', 'suki' ),
					'image' => SUKI_IMAGES_URL . '/customizer/content-sidebar-layout--left-sidebar.svg',
				),
			),
			'columns'     => 4,
			'priority'    => 110,
		) ) );

		// ------
		$wp_customize->add_control( new Suki_Customize_Control_HR( $wp_customize, 'hr_page_settings_' . $ps_type . '_content_header', array(
			'section'     => $section,
			'settings'    => array(),
			'priority'    => 120,
		) ) );

		// Standard choices
		$choices = array(
			'title'       => esc_html__( 'Title', 'suki' ),
			'breadcrumb'  => esc_html__( 'Breadcrumb', 'suki' ),
		);

		// Content header elements
		$subkey = 'content_header_elements';
		$key = $option_key . '[' . $subkey . ']';
		$wp_customize->add_setting( $key, array(
			'default'     => suki_array_value( $default, $subkey ),
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'builder' ),
		) );
		$wp_customize->add_control( new Suki_Customize_Control_Builder( $wp_customize, $key, array(
			'section'     => $section,
			'label'       => esc_html__( 'Content header elements', 'suki' ),
			'choices'     => $choices,
			'layout'      => 'block',
			'priority'    => 120,
		) ) );
	}

	/**
	 * ====================================================
	 * Header
	 * ====================================================
	 */

	if ( 'error_404' !== $ps_type ) {
		// ------
		$wp_customize->add_control( new Suki_Customize_Control_HR( $wp_customize, 'hr_page_settings_' . $ps_type . '_header', array(
			'section'     => $section,
			'settings'    => array(),
			'priority'    => 130,
		) ) );
	}

	// Desktop Header
	$subkey = 'disable_header';
	$key = $option_key . '[' . $subkey . ']';
	$wp_customize->add_setting( $key, array(
		'default'     => suki_array_value( $default, $subkey ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
	) );
	$wp_customize->add_control( $key, array(
		'type'        => 'select',
		'section'     => $section,
		'label'       => esc_html__( 'Desktop Header', 'suki' ),
		'choices'     => array(
			''  => esc_html__( '&#x2714; Enabled', 'suki' ),
			'1' => esc_html__( '&#x2718; Disabled', 'suki' ),
		),
		'priority'    => 130,
	) );

	if ( 'error_404' !== $ps_type ) {
		// ------
		$wp_customize->add_control( new Suki_Customize_Control_HR( $wp_customize, 'hr_page_settings_' . $ps_type . '_header_mobile', array(
			'section'     => $section,
			'settings'    => array(),
			'priority'    => 135,
		) ) );
	}

	// Mobile Header
	$subkey = 'disable_mobile_header';
	$key = $option_key . '[' . $subkey . ']';
	$wp_customize->add_setting( $key, array(
		'default'     => suki_array_value( $default, $subkey ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
	) );
	$wp_customize->add_control( $key, array(
		'type'        => 'select',
		'section'     => $section,
		'label'       => esc_html__( 'Mobile Header', 'suki' ),
		'choices'     => array(
			''  => esc_html__( '&#x2714; Enabled', 'suki' ),
			'1' => esc_html__( '&#x2718; Disabled', 'suki' ),
		),
		'priority'    => 135,
	) );

	/**
	 * ====================================================
	 * Hero section
	 * ====================================================
	 */

	// Hero section
	$subkey = 'hero_section';
	$key = $option_key . '[' . $subkey . ']';
	$wp_customize->add_setting( $key, array(
		'default'     => suki_array_value( $default, $subkey ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
	) );
	$wp_customize->add_control( new Suki_Customize_Control_RadioImage( $wp_customize, $key, array(
		'section'     => $section,
		'label'       => esc_html__( 'Hero section', 'suki' ),
		'choices'     => array(
			''  => esc_html__( '-- Global --', 'suki' ),
			'0' => esc_html__( '&#x2718; Disabled', 'suki' ),
			'1' => esc_html__( '&#x2714; Enabled', 'suki' ),
		),
		'columns'     => 4,
		'priority'    => 140,
	) ) );

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
		'priority'    => 150,
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
		'priority'    => 150,
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
		'priority'    => 150,
	) );
}