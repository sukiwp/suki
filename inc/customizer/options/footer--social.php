<?php
/**
 * Customizer settings: Footer > Social Links
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'suki_section_footer_social';

/**
 * ====================================================
 * Social Links
 * ====================================================
 */

// Heading: Social Links
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_footer_social', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Social Links', 'suki' ),
	'description' => sprintf(
		/* translators: %s: link to "Global Settings" section. */
		esc_html__( 'You can edit Social Media URLs via %s.', 'suki' ),
		'<a href="' . esc_attr( add_query_arg( 'autofocus[panel]', 'suki_panel_global_settings', remove_query_arg( 'autofocus' ) ) ) . '" class="suki-customize-goto-control">' . esc_html__( 'Global Settings', 'suki' ) . '</a>'
	),
	'priority'    => 10,
) ) );

// Social links
$key = 'footer_social_links';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'multiselect' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Builder( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Active links', 'suki' ),
	'choices'     => suki_get_social_media_types(),
	'priority'    => 10,
) ) );

// Selective Refresh
if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( 'footer_social_links', array(
		'selector'            => '.suki-footer-social',
		'container_inclusive' => true,
		'render_callback'     => 'suki_footer_element__social',
		'fallback_refresh'    => false,
	) );
}

// Social links target
$key = 'footer_social_links_target';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Open links in', 'suki' ),
	'choices'     => array(
		'self'  => esc_html__( 'Same tab', 'suki' ),
		'blank' => esc_html__( 'New tab', 'suki' ),
	),
	'priority'    => 10,
) );