<?php
/**
 * Customizer settings: Other Pages > Static Page
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$section = 'suki_section_page_single';

/**
 * ====================================================
 * Content Header
 * ====================================================
 */

// Heading: Content Header.
$wp_customize->add_control(
	new Suki_Customize_Heading_Control(
		$wp_customize,
		'heading_page_single_content_header',
		array(
			'section'  => $section,
			'settings' => array(),
			'label'    => esc_html__( 'Content Header', 'suki' ),
			'priority' => 10,
		)
	)
);

/**
 * Filter: suki/dataset/page_single_content_header_elements
 *
 * @param array $elements Elements array.
 */
$elements = apply_filters(
	'suki/dataset/page_single_content_header_elements',
	array(
		'title'       => esc_html__( 'Title', 'suki' ),
		'header-meta' => esc_html__( 'Header Meta', 'suki' ),
	)
);

// Elements.
$key = 'page_single_content_header';
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
			'section'     => $section,
			'label'       => esc_html__( 'Elements', 'suki' ),
			'choices'     => $elements,
			'is_sortable' => true,
			'priority'    => 10,
		)
	)
);

// Alignment.
$key = 'page_single_content_header_alignment';
$wp_customize->add_setting(
	$key,
	array(
		'default'           => suki_array_value( $defaults, $key ),
		'transport'         => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
	)
);
$wp_customize->add_control(
	new Suki_Customize_RadioImage_Control(
		$wp_customize,
		$key,
		array(
			'section'  => $section,
			'label'    => esc_html__( 'Alignment', 'suki' ),
			'choices'  => array(
				'left'   => array(
					'label' => esc_html__( 'Left', 'suki' ),
				),
				'center' => array(
					'label' => esc_html__( 'Center', 'suki' ),
				),
				'right'  => array(
					'label' => esc_html__( 'Right', 'suki' ),
				),
			),
			'priority' => 10,
		)
	)
);

/**
 * ====================================================
 * Featured Image
 * ====================================================
 */

// Heading: Featured Image.
$wp_customize->add_control(
	new Suki_Customize_Heading_Control(
		$wp_customize,
		'heading_page_single_content_thumbnail',
		array(
			'section'  => $section,
			'settings' => array(),
			'label'    => esc_html__( 'Featured Image', 'suki' ),
			'priority' => 20,
		)
	)
);

// Featured image.
$key = 'page_single_content_thumbnail_position';
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
		'label'    => esc_html__( 'Display', 'suki' ),
		'choices'  => array(
			''       => esc_html__( 'Disabled', 'suki' ),
			'before' => esc_html__( 'Before Content Header', 'suki' ),
			'after'  => esc_html__( 'After Content Header', 'suki' ),
		),
		'priority' => 20,
	)
);

// Wide alignment.
$key = 'page_single_content_thumbnail_wide';
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
			'section'  => $section,
			'label'    => esc_html__( 'Wide alignment on Narrow container', 'suki' ),
			'priority' => 20,
		)
	)
);
