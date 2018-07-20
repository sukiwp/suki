<?php
/**
 * Customizer settings: Page Settings
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

foreach ( Suki_Customizer::instance()->get_all_page_settings_types() as $type => $type_data ) {
	$section = 'suki_section_page_settings_' . $type;
	$option_key = 'page_settings_' . $type;

	// Get default value (array) of the option key.
	$default = suki_array_value( $defaults, $option_key, array() );
	if ( ! is_array( $default ) ) {
		$default = array();
	}

	/**
	 * ====================================================
	 * Header
	 * ====================================================
	 */

	// Heading: Header
	$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_page_settings_' . $type . '_header', array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => esc_html__( 'Header', 'suki' ),
		'priority'    => 10,
	) ) );

	// Disable header
	$key = 'disable_header';
	$id = $option_key . '[' . $key . ']';
	$wp_customize->add_setting( $id, array(
		'default'     => suki_array_value( $default, $key, 0 ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
	) );
	$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $id, array(
		'section'     => $section,
		'label'       => esc_html__( 'Disable header', 'suki' ),
		'priority'    => 10,
	) ) );

	// Disable mobile header
	$key = 'disable_mobile_header';
	$id = $option_key . '[' . $key . ']';
	$wp_customize->add_setting( $id, array(
		'default'     => suki_array_value( $default, $key, 0 ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
	) );
	$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $id, array(
		'section'     => $section,
		'label'       => esc_html__( 'Disable mobile header', 'suki' ),
		'priority'    => 10,
	) ) );

	/**
	 * ====================================================
	 * Page Header
	 * ====================================================
	 */

	// Heading: Page Header
	$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_page_settings_' . $type . '_page_header', array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => esc_html__( 'Page Header', 'suki' ),
		'priority'    => 20,
	) ) );

	// Disable page header
	$key = 'disable_page_header';
	$id = $option_key . '[' . $key . ']';
	$wp_customize->add_setting( $id, array(
		'default'     => suki_array_value( $default, $key, 0 ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
	) );
	$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $id, array(
		'section'     => $section,
		'label'       => esc_html__( 'Disable page header', 'suki' ),
		'priority'    => 20,
	) ) );

	// ------
	$wp_customize->add_control( new Suki_Customize_Control_HR( $wp_customize, 'hr_page_settings_' . $type . '_page_header', array(
		'section'     => $section,
		'settings'    => array(),
		'priority'    => 20,
	) ) );

	// Custom page title
	$key = 'custom_page_title';
	$id = $option_key . '[' . $key . ']';
	$wp_customize->add_setting( $id, array(
		'default'     => suki_array_value( $defaults, $id ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'text' ),
	) );
	$wp_customize->add_control( $id, array(
		'section'     => $section,
		'label'       => esc_html__( 'Override default page title text', 'suki' ),
		'priority'    => 20,
	) );

	// Keep main content title displayed
	$key = 'page_header_keep_content_header';
	$id = $option_key . '[' . $key . ']';
	$wp_customize->add_setting( $id, array(
		'default'     => suki_array_value( $default, $key, 0 ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
	) );
	$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $id, array(
		'section'     => $section,
		'label'       => esc_html__( 'Keep main content title displayed', 'suki' ),
		'description' => esc_html__( 'By default, when page header is active, the page title on content section would be hidden. Enabling this would make the page title on content section remains displayed.', 'suki' ),
		'priority'    => 20,
	) ) );

	/**
	 * ====================================================
	 * Content
	 * ====================================================
	 */

	// Heading: Content
	$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_page_settings_' . $type . '_content', array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => esc_html__( 'Content', 'suki' ),
		'priority'    => 30,
	) ) );

	// Section container
	$key = 'content_container';
	$id = $option_key . '[' . $key . ']';
	$wp_customize->add_setting( $id, array(
		'default'     => suki_array_value( $default, $key, 'default' ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
	) );
	$wp_customize->add_control( $id, array(
		'type'        => 'select',
		'section'     => $section,
		'label'       => esc_html__( 'Section container', 'suki' ),
		'choices'     => array(
			'default'            => esc_html__( 'Fixed width container', 'suki' ),
			'full-width'         => esc_html__( 'Full container', 'suki' ),
			'full-width-padding' => esc_html__( 'Full container with side padding', 'suki' ),
		),
		'priority'    => 30,
	) );

	// Content layout
	$key = 'content_layout';
	$id = $option_key . '[' . $key . ']';
	$wp_customize->add_setting( $id, array(
		'default'     => suki_array_value( $default, $key, 'right-sidebar' ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
	) );
	$wp_customize->add_control( $id, array(
		'type'        => 'select',
		'section'     => $section,
		'label'       => esc_html__( 'Content layout', 'suki' ),
		'choices'     => array(
			'wide'          => esc_html__( 'Wide Content', 'suki' ),
			'narrow'        => esc_html__( 'Narrow Content', 'suki' ),
			'left-sidebar'  => is_rtl() ? esc_html__( 'Right Sidebar', 'suki' ) : esc_html__( 'Left Sidebar', 'suki' ),
			'right-sidebar' => is_rtl() ? esc_html__( 'Left Sidebar', 'suki' ) : esc_html__( 'Right Sidebar', 'suki' ),
		),
		'priority'    => 30,
	) );

	// ------
	$wp_customize->add_control( new Suki_Customize_Control_HR( $wp_customize, 'hr_page_settings_' . $type . '_content_header', array(
		'section'     => $section,
		'settings'    => array(),
		'priority'    => 30,
	) ) );

	// Disable main content title
	$key = 'disable_content_header';
	$id = $option_key . '[' . $key . ']';
	$wp_customize->add_setting( $id, array(
		'default'     => suki_array_value( $default, $key, 0 ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
	) );
	$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $id, array(
		'section'     => $section,
		'label'       => esc_html__( 'Disable main content title', 'suki' ),
		'priority'    => 30,
	) ) );

	/**
	 * ====================================================
	 * Footer
	 * ====================================================
	 */

	// Heading: Footer
	$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_page_settings_' . $type . '_footer', array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => esc_html__( 'Footer', 'suki' ),
		'priority'    => 40,
	) ) );

	// Disable footer widgets
	$key = 'disable_footer_widgets';
	$id = $option_key . '[' . $key . ']';
	$wp_customize->add_setting( $id, array(
		'default'     => suki_array_value( $default, $key, 0 ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
	) );
	$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $id, array(
		'section'     => $section,
		'label'       => esc_html__( 'Disable footer widgets', 'suki' ),
		'priority'    => 40,
	) ) );

	// Disable footer bottom
	$key = 'disable_footer_bottom';
	$id = $option_key . '[' . $key . ']';
	$wp_customize->add_setting( $id, array(
		'default'     => suki_array_value( $default, $key, 0 ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
	) );
	$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $id, array(
		'section'     => $section,
		'label'       => esc_html__( 'Disable footer bottom', 'suki' ),
		'priority'    => 40,
	) ) );

	/**
	 * ====================================================
	 * Suki Pro Upsell
	 * ====================================================
	 */

	if ( suki_show_pro_teaser() ) {
		$wp_customize->add_control( new Suki_Customize_Control_Pro( $wp_customize, 'pro_teaser_page_settings_' . $type, array(
			'section'     => $section,
			'settings'    => array(),
			'label'       => esc_html_x( 'More Options on Suki Pro', 'Suki Pro upsell', 'suki' ),
			'url'         => SUKI_PRO_URL,
			'features'    => array(
				esc_html_x( 'Activate transparent header on this page', 'Suki Pro upsell', 'suki' ),
				esc_html_x( 'Activate alternative header colors on this page', 'Suki Pro upsell', 'suki' ),
				esc_html_x( 'Hide some elements on this page', 'Suki Pro upsell', 'suki' ),
			),
			'priority'    => 90,
		) ) );
	}
}