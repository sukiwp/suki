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

// Layout
$id = 'content_container';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $id, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Layout', 'suki' ),
	'choices'     => array(
		'default'    => esc_html__( 'Full width section, wrapped content', 'suki' ),
		'full-width' => esc_html__( 'Full width content', 'suki' ),
	),
	'priority'    => 10,
) );

// Content & sidebar layout
$id = 'content_layout';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $id, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Content & sidebar layout', 'suki' ),
	'choices'     => array(
		'wide'          => esc_html__( 'Full content, no sidebar', 'suki' ),
		'narrow'        => esc_html__( 'Narrow content, no sidebar', 'suki' ),
		'left-sidebar'  => is_rtl() ? esc_html__( 'Right sidebar', 'suki' ) : esc_html__( 'Left sidebar', 'suki' ),
		'right-sidebar' => is_rtl() ? esc_html__( 'Left sidebar', 'suki' ) : esc_html__( 'Right sidebar', 'suki' ),
	),
	'priority'    => 10,
) );

// Notice overridable via page settings
$wp_customize->add_control( new Suki_Customize_Control_Blank( $wp_customize, 'notice_override_content_layout', array(
	'section'     => $section,
	'settings'    => array(),
	'description' => sprintf(
		/* translators: %s: link to "Page Settings" section. */
		esc_html__( 'Settings above are global default, optionally you can set different layout for each page type via %s.', 'suki' ),
		'<a href="' . esc_url( add_query_arg( 'autofocus[panel]', 'suki_panel_page_settings' ) ) . '" class="suki-customize-goto-control">' . esc_html__( 'Page Settings', 'suki' ) . '</a>'
	),
	'priority'    => 10,
) ) );

// ------
$wp_customize->add_control( new Suki_Customize_Control_HR( $wp_customize, 'hr_content_layout', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 10,
) ) );

// Padding
$id = 'content_padding';
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
	'label'       => esc_html__( 'Padding', 'suki' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'step' => 1,
		),
		'%' => array(
			'min'  => 0,
			'step' => 0.01,
		),
	),
	'priority'    => 10,
) ) );

// ------
$wp_customize->add_control( new Suki_Customize_Control_HR( $wp_customize, 'hr_content_narrow', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 10,
) ) );

// Narrow content max width
$id = 'content_narrow_width';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Narrow content max width', 'suki' ),
	'description' => esc_html__( 'Narrow content is a single column centered layout for main content (without sidebar). Narrow content should have less width than the content wrapper width.', 'suki' ),
	'units'       => array(
		'px' => array(
			'min'  => 600,
			'max'  => 1600,
			'step' => 1,
		),
	),
	'priority'    => 10,
) ) );