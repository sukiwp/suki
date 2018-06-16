<?php
/**
 * Customizer settings: Page Settings
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

foreach ( $page_sections as $key => $title ) {
	$section = 'suki_section_' . $key . '_page';
	$option_key = 'suki_' . $key . '_page_settings';

	// Get default value (array) of the option key.
	$default = suki_array_value( $defaults, $option_key, array() );
	if ( ! is_array( $default ) ) {
		$default = array();
	}

	/**
	 * ====================================================
	 * Content Layout
	 * ====================================================
	 */

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
		'label'       => esc_html__( 'Content section container', 'suki' ),
		'choices'     => array(
			'default'            => esc_html__( 'Fixed width container', 'suki' ),
			'full-width'         => esc_html__( 'Full container', 'suki' ),
			'full-width-padding' => esc_html__( 'Full container with edge tolerance padding', 'suki' ),
		),
		'priority'    => 10,
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
			'left-sidebar'  => is_rtl() ? esc_html__( 'Right Sidebar - RTL', 'suki' ) : esc_html__( 'Left Sidebar', 'suki' ),
			'right-sidebar' => is_rtl() ? esc_html__( 'Left Sidebar - RTL', 'suki' ) : esc_html__( 'Right Sidebar', 'suki' ),
		),
		'priority'    => 10,
	) );

	/**
	 * ====================================================
	 * Suki Pro Teaser
	 * ====================================================
	 */

	if ( suki_show_pro_teaser() ) {
		$wp_customize->add_control( new Suki_Customize_Control_Pro( $wp_customize, 'pro_teaser_' . $key . '_page_settings_header_overlay', array(
			'section'     => $section,
			'settings'    => array(),
			'label'       => esc_html_x( 'Activate Transparent Header', 'Suki Pro teaser', 'suki' ),
			'url'         => 'https://sukiwp.com/pro/modules/transparent-header/',
			'priority'    => 90,
		) ) );

		$wp_customize->add_control( new Suki_Customize_Control_Pro( $wp_customize, 'pro_teaser_' . $key . '_page_settings_header_alt_colors', array(
			'section'     => $section,
			'settings'    => array(),
			'label'       => esc_html_x( 'Activate Alternative Header Colors', 'Suki Pro teaser', 'suki' ),
			'url'         => 'https://sukiwp.com/pro/modules/alternative-header-colors/',
			'priority'    => 90,
		) ) );

		$wp_customize->add_control( new Suki_Customize_Control_Pro( $wp_customize, 'pro_teaser_' . $key . '_page_settings_disable_elements', array(
			'section'     => $section,
			'settings'    => array(),
			'label'       => esc_html_x( 'Disable Elements', 'Suki Pro teaser', 'suki' ),
			'url'         => 'https://sukiwp.com/pro/modules/disable-elements/',
			'priority'    => 90,
		) ) );
	}
}