<?php
/**
 * Customizer settings: Other Pages > Search Page
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'suki_section_search_results';

/**
 * ====================================================
 * Content Header
 * ====================================================
 */

// Heading: Content Header
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_search_results_header', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Content Header', 'suki' ),
	'priority'    => 10,
) ) );

// Elements
$key = 'search_results_content_header';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'multiselect' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Sortable( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Elements', 'suki' ),
	'choices'     => array(
		'search-title' => esc_html__( 'Title', 'suki' ),
		'search-form'  => esc_html__( 'Search Form', 'suki' ),
		'breadcrumb'   => esc_html__( 'Breadcrumb', 'suki' ),
	),
	'priority'    => 10,
) ) );

// Title text
$key = 'search_results_title_text';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'text' ),
) );
$wp_customize->add_control( $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Title text', 'suki' ),
	'description' => esc_html__( 'Use {{keyword}} to display search keyword.', 'suki' ),
	'priority'    => 10,
	'input_attrs' => array(
		'placeholder' => esc_html__( 'Search results for: "{{keyword}}"', 'suki' ),
	),
) );

/**
 * ====================================================
 * Posts Layout
 * ====================================================
 */

// Heading: Results List
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_search_results_layout', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Results List', 'suki' ),
	'priority'    => 20,
) ) );

// No results found text
$key = 'search_results_not_found_text';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'textarea' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'textarea',
	'section'     => $section,
	'label'       => esc_html__( 'No results found text', 'suki' ),
	'priority'    => 20,
	'input_attrs' => array(
		'placeholder' => esc_html__( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'suki' ),
	),
) );