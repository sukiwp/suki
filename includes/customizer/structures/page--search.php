<?php
/**
 * Customizer settings: Other Pages > Search Page
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$section = 'suki_section_search_results';

/**
 * ====================================================
 * Results List
 * ====================================================
 */

// Heading: Results List.
$wp_customize->add_control(
	new Suki_Customize_Heading_Control(
		$wp_customize,
		'heading_search_results_layout',
		array(
			'section'  => $section,
			'settings' => array(),
			'label'    => esc_html__( 'Results List', 'suki' ),
			'priority' => 10,
		)
	)
);

// Layout.
$key = 'search_results_use_blog_loop_layout';
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
		'label'    => esc_html__( 'Layout', 'suki' ),
		'choices'  => array(
			''  => esc_html__( 'Compact search results', 'suki' ),
			'1' => esc_html__( 'Same with Blog posts', 'suki' ),
		),
		'priority' => 10,
	)
);

/**
 * ====================================================
 * Content Header
 * ====================================================
 */

// Heading: Content Header.
$wp_customize->add_control(
	new Suki_Customize_Heading_Control(
		$wp_customize,
		'heading_search_results_content_header',
		array(
			'section'  => $section,
			'settings' => array(),
			'label'    => esc_html__( 'Content Header', 'suki' ),
			'priority' => 20,
		)
	)
);

/**
 * Filter: suki/dataset/search_results_content_header_elements
 *
 * @param array $elements Elements array.
 */
$elements = apply_filters(
	'suki/dataset/search_results_content_header_elements',
	array(
		'title'       => esc_html__( 'Title', 'suki' ),
		'search-form' => esc_html__( 'Search Form', 'suki' ),
	)
);

// Elements.
$key = 'search_results_content_header';
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
			'priority'    => 20,
		)
	)
);

// Alignment.
$key = 'search_results_content_header_alignment';
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
			'priority' => 20,
		)
	)
);

// Title text.
$key = 'search_results_title_text';
$wp_customize->add_setting(
	$key,
	array(
		'default'           => suki_array_value( $defaults, $key ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'text' ),
	)
);
$wp_customize->add_control(
	$key,
	array(
		'section'     => $section,
		'label'       => esc_html__( 'Title text', 'suki' ),
		'description' => esc_html__( 'Use {{keyword}} to display search keyword.', 'suki' ),
		'priority'    => 20,
		'input_attrs' => array(
			'placeholder' => esc_html__( 'Search results for: {{keyword}}', 'suki' ),
		),
	)
);
