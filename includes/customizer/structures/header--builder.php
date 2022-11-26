<?php
/**
 * Customizer settings: Header > Header Builder
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$section = 'suki_section_header_builder';

/**
 * ====================================================
 * Responsive tabs
 * ====================================================
 */

// Header Builder Responsive Tabs.
$wp_customize->add_control(
	new Suki_Customize_Responsive_Tabs_Control(
		$wp_customize,
		'header_builder_responsive_tabs',
		array(
			'section'  => $section,
			'settings' => array(),
			'priority' => 10,
		)
	)
);

/**
 * ====================================================
 * Desktop Header
 * ====================================================
 */

$desktop_areas   = suki_get_header_builder_areas();
$desktop_choices = suki_get_header_builder_elements();

// Desktop header.
$key      = 'header_elements';
$settings = array();
foreach ( $desktop_areas as $slug => $label ) {
	$settings[ $slug ] = $key . '_' . $slug;
}
foreach ( $settings as $setting ) {
	$wp_customize->add_setting(
		$setting,
		array(
			'default'           => suki_array_value( $defaults, $setting ),
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'builder' ),
		)
	);
}
$wp_customize->add_control(
	new Suki_Customize_Builder_Control(
		$wp_customize,
		$key,
		array(
			'settings' => $settings,
			'section'  => $section,
			'label'    => esc_html__( 'Desktop header', 'suki' ),
			'areas'    => $desktop_areas,
			'choices'  => $desktop_choices,
			'priority' => 10,
		)
	)
);

/**
 * ====================================================
 * Mobile Header
 * ====================================================
 */

// Mobile header breakpoint.
$key = 'header_mobile_visibility';
$wp_customize->add_setting(
	$key,
	array(
		'default'           => suki_array_value( $defaults, $key ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
	)
);
$wp_customize->add_control(
	$key,
	array(
		'type'     => 'select',
		'section'  => $section,
		'label'    => esc_html__( 'Mobile header breakpoint', 'suki' ),
		'choices'  => array(
			'tablet' => esc_html__( 'Below 1024px', 'suki' ),
			'mobile' => esc_html__( 'Below 768px', 'suki' ),
		),
		'priority' => 20,
	)
);

$mobile_areas   = suki_get_header_mobile_builder_areas();
$mobile_choices = suki_get_header_mobile_builder_elements();

// Mobile header.
$key      = 'header_mobile_elements';
$settings = array();
foreach ( $mobile_areas as $slug => $label ) {
	$settings[ $slug ] = $key . '_' . $slug;
}
foreach ( $settings as $setting ) {
	$wp_customize->add_setting(
		$setting,
		array(
			'default'           => suki_array_value( $defaults, $setting ),
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'builder' ),
		)
	);
}
$wp_customize->add_control(
	new Suki_Customize_Builder_Control(
		$wp_customize,
		$key,
		array(
			'settings' => $settings,
			'section'  => $section,
			'label'    => esc_html__( 'Mobile header', 'suki' ),
			'areas'    => $mobile_areas,
			'choices'  => $mobile_choices,
			'priority' => 20,
		)
	)
);
