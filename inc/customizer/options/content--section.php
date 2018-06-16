<?php
/**
 * Customizer settings: Content & Sidebar > Content Section
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'suki_section_content';

/**
 * ====================================================
 * Layout
 * ====================================================
 */

// Section container
$wp_customize->add_control( new Suki_Customize_Control_Blank( $wp_customize, 'content_container', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Section container', 'suki' ),
	'description' => sprintf(
		/* translators: %s: link to "Page Settings" section. */
		esc_html__( 'You can set different section container on each page type via  %s.', 'suki' ),
		'<a href="' . esc_url( add_query_arg( 'autofocus[panel]', 'suki_panel_page_settings' ) ) . '" class="suki-customize-goto-control">' . esc_html__( 'Page Settings', 'suki' ) . '</a>'
	),
	'priority'    => 10,
) ) );

// Section padding
$id = 'content_section_padding';
$settings = array(
	$id,
	$id . '__tablet',
	$id . '__mobile',
);
foreach ( $settings as $setting ) {
	$wp_customize->add_setting( $setting, array(
		'default'     => suki_array_value( $defaults, $setting ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimensions' ),
	) );
}
$wp_customize->add_control( new Suki_Customize_Control_Dimensions( $wp_customize, $id, array(
	'settings'    => $settings,
	'section'     => $section,
	'label'       => esc_html__( 'Section padding', 'suki' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'max'  => 300,
			'step' => 1,
		),
	),
	'priority'    => 10,
) ) );