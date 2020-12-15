<?php
/**
 * Customizer settings: Global Modules > Breadcrumb
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
	'label'       => esc_html__( 'Breadcrumb module', 'suki' ),
	'description' => esc_html__( 'Choose whether to use theme\'s breadcrumb or other breadcrumb modules from supported 3rd party plugins. If you use 3rd party plugin, make sure you have installed and configured the plugin correctly. Otherwise, the breadcrumb might not show properly.', 'suki' ),
	'choices'     => array(
		''                 => esc_html__( 'Theme\'s Breadcrumb', 'suki' ),
		'rank-math'        => esc_html__( 'Rank Math', 'suki' ),
		'seopress'         => esc_html__( 'SEOPress (pro version)', 'suki' ),
		'yoast-seo'        => esc_html__( 'Yoast SEO', 'suki' ),
		'breadcrumb-navxt' => esc_html__( 'Breadcrumb NavXT', 'suki' ),
		'breadcrumb-trail' => esc_html__( 'Breadcrumb Trail', 'suki' ),
	),
	'priority'    => 10,
) );