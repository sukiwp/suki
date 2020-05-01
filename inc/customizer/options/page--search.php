<?php
/**
 * Customizer settings: Other Pages > Search Page
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'suki_section_search';

/**
 * ====================================================
 * Featured Media
 * ====================================================
 */

// Title text
$key = 'search_results_title';
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

// Show search bar
$key = 'search_results_search_bar';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Show search bar', 'suki' ),
	'priority'    => 10,
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
	'priority'    => 10,
	'input_attrs' => array(
		'placeholder' => esc_html__( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'suki' ),
	),
) );