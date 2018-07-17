<?php
/**
 * Customizer settings: Header > Contact Info
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'suki_section_header_contact_info';

/**
 * ====================================================
 * Contact Info
 * ====================================================
 */

// Heading: Contact Info
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_header_contact_info', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Contact Info', 'suki' ),
	'description' => '<a href="' . esc_url( add_query_arg( 'autofocus[section]', 'suki_section_contact_info' ) ) . '" class="suki-customize-goto-control button button-secondary">' . esc_html__( 'Edit contact_info Media URLs', 'suki' ) . '</a>',
	'priority'    => 10,
) ) );

// ------
$wp_customize->add_control( new Suki_Customize_Control_HR( $wp_customize, 'hr_header_contact_info', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 10,
) ) );

// Social links
$id = 'header_contact_info_links';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'multiselect' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Builder( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Active links', 'suki' ),
	'choices'    => suki_get_contact_info_details(),
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
