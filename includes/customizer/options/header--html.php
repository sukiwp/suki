<?php
/**
 * Customizer settings: Header > HTML
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'suki_section_header_html';

/**
 * ====================================================
 * HTML 1
 * ====================================================
 */

// Heading: HTML
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_header_html_1', array(
	'section'     => $section,
	'settings'    => array(),
	/* translators: %s: HTML element number. */
	'label'       => sprintf( esc_html__( 'HTML %s', 'suki' ), 1 ),
	'priority'    => 10,
) ) );

// Content
$key = 'header_html_1_content';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => false,
) );
$wp_customize->add_control( $key, array(
	'type'        => 'textarea',
	'section'     => $section,
	'description' => esc_html__( 'Plain text, HTML tags, and shortcode are allowed.', 'suki' ),
	'priority'    => 10,
) );

// Selective Refresh
if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( $key, array(
		'selector'            => '.suki-header-html-1',
		'container_inclusive' => true,
		'render_callback'     => function() {
			suki_header_element( 'html-1' );
		},
		'fallback_refresh'    => false,
	) );
}

/**
 * ====================================================
 * Suki Pro Upsell
 * ====================================================
 */

$features = array();
for ( $i = 2; $i <=3; $i++ ) {
	/* translators: %s: HTML element number. */
	$features[] = sprintf( esc_html_x( 'HTML %s', 'Suki Pro upsell', 'suki' ), $i );
}

if ( suki_show_pro_teaser() ) {
	$wp_customize->add_control( new Suki_Customize_Control_Pro_Teaser( $wp_customize, 'pro_teaser_header_html', array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => esc_html_x( 'More Options Available in Suki Pro', 'Suki Pro upsell', 'suki' ),
		'url'         => esc_url( add_query_arg( array( 'utm_source' => 'suki-customizer', 'utm_medium' => 'learn-more', 'utm_campaign' => 'theme-upsell' ), SUKI_PRO_WEBSITE_URL ) ),
		'features'    => $features,
		'priority'    => 90,
	) ) );
}