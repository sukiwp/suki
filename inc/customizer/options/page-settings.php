<?php
/**
 * Customizer settings: Page Settings
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

foreach ( $page_sections as $type => $title ) {
	$section = 'suki_section_' . $type . '_page';
	$option_key = 'page_settings_' . $type;

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
				esc_html_x( 'Activate Transparent Header', 'Suki Pro upsell', 'suki' ),
				esc_html_x( 'Activate Alternative Header Colors', 'Suki Pro upsell', 'suki' ),
				esc_html_x( 'Disable Elements', 'Suki Pro upsell', 'suki' ),
			),
			'priority'    => 90,
		) ) );
	}
}