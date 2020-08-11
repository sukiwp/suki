<?php
/**
 * Customizer settings: Global Settings > Breadcrumb
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'suki_section_breadcrumb';

/**
 * ====================================================
 * Breadcrumb
 * ====================================================
 */

// Breadcrumb plugin
$key = 'breadcrumb_plugin';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Breadcrumb plugin', 'suki' ),
	'description' => esc_html__( 'Choose the plugin you want to use to handle the breadcrumb functionality. Make sure you have installed the plugin and configured the breadcrumb feature on the plugin\'s settings page.', 'suki' ),
	'choices'     => array(
		''                 => esc_html__( 'Disabled', 'suki' ),
		'rank-math'        => esc_html__( 'Rank Math', 'suki' ),
		'seopress'         => esc_html__( 'SEOPress (pro version)', 'suki' ),
		'yoast-seo'        => esc_html__( 'Yoast SEO', 'suki' ),
		'breadcrumb-navxt' => esc_html__( 'Breadcrumb NavXT', 'suki' ),
		'breadcrumb-trail' => esc_html__( 'Breadcrumb Trail', 'suki' ),
	),
	'priority'    => 10,
) );