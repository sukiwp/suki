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

// Enable
$key = 'breadcrumb';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Enable', 'suki' ) . ' <span class="suki-global-default-badge suki-tooltip" tabindex="0" data-tooltip="' . esc_attr__( 'You can enable or disable this option on each individual page.', 'suki' ) . '"><span class="dashicons dashicons-admin-site-alt3"></span> ' . esc_html__( 'Global', 'suki' ) . '</span>',
	'description' => esc_html__( 'Breadcrumb will be automatically added just before the page title.', 'suki' ),
	'priority'    => 10,
) ) );

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