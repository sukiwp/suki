<?php
/**
 * Customizer settings: Header > Social Links
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'suki_section_header_social';

/**
 * ====================================================
 * Social Links
 * ====================================================
 */

// Heading: Social Links
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_header_social', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Social Links', 'suki' ),
	'description' => sprintf(
		/* translators: %s: link to "Global Settings" section. */
		esc_html__( 'You can edit Social Media URLs via %s.', 'suki' ),
		'<a href="' . esc_url( add_query_arg( 'autofocus[panel]', 'suki_panel_global_settings' ) ) . '" class="suki-customize-goto-control">' . esc_html__( 'Global Settings', 'suki' ) . '</a>'
	),
	'priority'    => 10,
) ) );

// Social links
$id = 'header_social_links';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'multiselect' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Builder( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Active links', 'suki' ),
	'choices'    => suki_get_social_media_types(),
	'priority'    => 10,
) ) );

// Selective Refresh
if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( $id, array(
		'selector'            => '.suki-header-social',
		'container_inclusive' => true,
		'render_callback'     => 'suki_header_element__social',
		'fallback_refresh'    => false,
	) );
}

// Social links target
$id = 'header_social_links_target';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $id, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Open links in', 'suki' ),
	'choices'     => array(
		'self'  => esc_html__( 'Same tab', 'suki' ),
		'blank' => esc_html__( 'New tab', 'suki' ),
	),
	'priority'    => 10,
) );