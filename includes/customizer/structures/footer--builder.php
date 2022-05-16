<?php
/**
 * Customizer settings: Footer > Builder
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$section = 'suki_section_footer_builder';

/**
 * ====================================================
 * Builder
 * ====================================================
 */

// Widgets columns.
$key = 'footer_widgets_bar';
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
		'label'    => esc_html__( 'Widgets columns', 'suki' ),
		'choices'  => array(
			0 => esc_html__( '-- Disabled --', 'suki' ),
			1 => esc_html__( '1 column', 'suki' ),
			2 => esc_html__( '2 columns', 'suki' ),
			3 => esc_html__( '3 columns', 'suki' ),
			4 => esc_html__( '4 columns', 'suki' ),
			5 => esc_html__( '5 columns', 'suki' ),
			6 => esc_html__( '6 columns', 'suki' ),
		),
		'priority' => 10,
	)
);

// ------
$wp_customize->add_control(
	new Suki_Customize_HR_Control(
		$wp_customize,
		'hr_footer_builder',
		array(
			'section'  => $section,
			'settings' => array(),
			'priority' => 20,
		)
	)
);

/**
 * Filter: suki/dataset/footer_builder/areas
 *
 * @param array Array of areas for Footer Builder.
 */
$areas = apply_filters(
	'suki/dataset/footer_builder/areas',
	array(
		'bottom_left'   => esc_html__( 'Left', 'suki' ),
		'bottom_center' => esc_html__( 'Center', 'suki' ),
		'bottom_right'  => esc_html__( 'Right', 'suki' ),
	)
);

/**
 * Filter: suki/dataset/footer_builder/elements
 *
 * @param array Array of elements for Footer Builder.
 */
$choices = apply_filters(
	'suki/dataset/footer_builder/elements',
	array(
		'copyright' => array(
			'icon'              => 'editor-code',
			'label'             => esc_html__( 'Copyright', 'suki' ),
			'unsupported_areas' => array(),
		),
		'menu-1'    => array(
			'icon'              => 'admin-links',
			/* translators: %s: instance number. */
			'label'             => sprintf( esc_html__( 'Footer Menu %s', 'suki' ), 1 ),
			'unsupported_areas' => array(),
		),
		'html-1'    => array(
			'icon'              => 'editor-code',
			/* translators: %s: instance number. */
			'label'             => sprintf( esc_html__( 'HTML %s', 'suki' ), 1 ),
			'unsupported_areas' => array(),
		),
		'social'    => array(
			'icon'              => 'twitter',
			'label'             => esc_html__( 'Social', 'suki' ),
			'unsupported_areas' => array(),
		),
	)
);

// Bottom bar elements.
$key      = 'footer_elements';
$settings = array();
foreach ( $areas as $slug => $label ) {
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
			'label'    => esc_html__( 'Bottom bar elements', 'suki' ),
			'areas'    => $areas,
			'choices'  => $choices,
			'priority' => 20,
		)
	)
);
