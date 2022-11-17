<?php
/**
 * Customizer settings: Global Modules > Breadcrumb
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$panel   = 'suki_panel_global_settings';
$section = 'suki_section_breadcrumb';

/**
 * ====================================================
 * Sections
 * ====================================================
 */

// Section: Global Modules > Breadcrumb.
$wp_customize->add_section(
	$section,
	array(
		'title'       => esc_html__( 'Breadcrumb', 'suki' ),
		'description' => '<p>' . esc_html__( 'Breadcrumb can be added on 2 locations:', 'suki' ) . '</p><ul><li>' . esc_html__( 'Header (visible globally)', 'suki' ) . '</li><li>' . esc_html__( 'Content Header (per page type)', 'suki' ) . '</li></ul>',
		'panel'       => $panel,
		'priority'    => 15,
	)
);

/**
 * ====================================================
 * Options
 * ====================================================
 */

// Breadcrumb plugin.
$key = 'breadcrumb_plugin';
$wp_customize->add_setting(
	$key,
	array(
		'default'           => suki_array_value( $defaults, $key ),
		'transport'         => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
	)
);
$wp_customize->add_control(
	$key,
	array(
		'type'        => 'select',
		'section'     => $section,
		'label'       => esc_html__( 'Breadcrumb module', 'suki' ),
		'description' => esc_html__( 'Choose whether to use the theme\'s default breadcrumb or other breadcrumb modules from supported 3rd party plugins.', 'suki' ),
		'choices'     => array(
			''                 => esc_html__( 'Theme\'s default', 'suki' ),
			'rank-math'        => esc_html__( 'Rank Math', 'suki' ),
			'seopress'         => esc_html__( 'SEOPress (pro version)', 'suki' ),
			'yoast-seo'        => esc_html__( 'Yoast SEO', 'suki' ),
			'breadcrumb-navxt' => esc_html__( 'Breadcrumb NavXT', 'suki' ),
			'breadcrumb-trail' => esc_html__( 'Breadcrumb Trail', 'suki' ),
		),
		'priority'    => 10,
	)
);

// Info.
$wp_customize->add_control(
	new Suki_Customize_FreeText_Control(
		$wp_customize,
		'notice_breadcrumb_plugin',
		array(
			'section'     => $section,
			'settings'    => array(),
			'description' => '<div class="notice notice-info notice-alt inline"><p>' . esc_html__( 'Please make sure you have installed the plugin and configured the breadcrumb in the plugin\'s settings page. Otherwise, the breadcrumb might not show properly.', 'suki' ) . '</p></div>',
			'priority'    => 20,
		)
	)
);

// ------
$wp_customize->add_control(
	new Suki_Customize_HR_Control(
		$wp_customize,
		'hr_breadcrumb',
		array(
			'section'  => $section,
			'settings' => array(),
			'priority' => 20,
		)
	)
);

// Include home.
$key = 'breadcrumb_trail_home';
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
			'label'    => esc_html__( 'Include home', 'suki' ),
			'priority' => 20,
		)
	)
);

// Include current page.
$key = 'breadcrumb_trail_current_page';
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
			'label'    => esc_html__( 'Include current page', 'suki' ),
			'priority' => 20,
		)
	)
);

// Hide when no nested item.
$key = 'breadcrumb_hide_when_only_home_or_current';
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
			'label'    => esc_html__( 'Hide when no nested item', 'suki' ),
			'priority' => 20,
		)
	)
);
