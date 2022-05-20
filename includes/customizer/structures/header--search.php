<?php
/**
 * Customizer settings: Header > Search
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$section = 'suki_section_header_search';

/**
 * ====================================================
 * Search Bar
 * ====================================================
 */

// Heading: Search Bar.
$wp_customize->add_control(
	new Suki_Customize_Heading_Control(
		$wp_customize,
		'heading_header_search_bar',
		array(
			'section'  => $section,
			'settings' => array(),
			'label'    => esc_html__( 'Search Bar', 'suki' ),
			'priority' => 10,
		)
	)
);

// Search bar width.
$key = 'header_search_bar_width';
$wp_customize->add_setting(
	$key,
	array(
		'default'           => suki_array_value( $defaults, $key ),
		'transport'         => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimension' ),
	)
);
$wp_customize->add_control(
	new Suki_Customize_Dimension_Control(
		$wp_customize,
		$key,
		array(
			'section'  => $section,
			'label'    => esc_html__( 'Bar width', 'suki' ),
			'units'    => array(
				'px' => array(
					'min'  => 100,
					'step' => 1,
				),
			),
			'priority' => 10,
		)
	)
);

/**
 * ====================================================
 * Search Dropdown
 * ====================================================
 */

// Heading: Search Dropdown.
$wp_customize->add_control(
	new Suki_Customize_Heading_Control(
		$wp_customize,
		'heading_header_search_dropdown',
		array(
			'section'  => $section,
			'settings' => array(),
			'label'    => esc_html__( 'Search Dropdown', 'suki' ),
			'priority' => 20,
		)
	)
);

// Search bar width.
$key = 'header_search_dropdown_width';
$wp_customize->add_setting(
	$key,
	array(
		'default'           => suki_array_value( $defaults, $key ),
		'transport'         => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimension' ),
	)
);
$wp_customize->add_control(
	new Suki_Customize_Dimension_Control(
		$wp_customize,
		$key,
		array(
			'section'  => $section,
			'label'    => esc_html__( 'Dropdown width', 'suki' ),
			'units'    => array(
				'px'  => array(
					'min'  => 150,
					'step' => 1,
				),
				'em'  => array(
					'min'  => 10,
					'step' => 0.01,
				),
				'rem' => array(
					'min'  => 10,
					'step' => 0.01,
				),
			),
			'priority' => 20,
		)
	)
);

/**
 * ====================================================
 * Suki Pro Upsell
 * ====================================================
 */

if ( suki_show_pro_teaser() ) {
	$wp_customize->add_control(
		new Suki_Customize_Pro_Teaser_Control(
			$wp_customize,
			'pro_teaser_header_search',
			array(
				'section'  => $section,
				'settings' => array(),
				'label'    => esc_html_x( 'More Options Available in Suki Pro', 'Suki Pro upsell', 'suki' ),
				'url'      => esc_url(
					add_query_arg(
						array(
							'utm_source'   => 'suki-customizer',
							'utm_medium'   => 'learn-more',
							'utm_campaign' => 'theme-upsell',
						),
						SUKI_PRO_WEBSITE_URL
					)
				),
				'features' => array(
					esc_html_x( 'WooCommerce Products Search', 'Suki Pro upsell', 'suki' ),
				),
				'priority' => 90,
			)
		)
	);
}