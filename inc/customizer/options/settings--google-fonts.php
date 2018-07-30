<?php
/**
 * Customizer settings: Global Settings > Google Fonts
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'suki_section_google_fonts';

/**
 * ====================================================
 * Google Fonts
 * ====================================================
 */

// Google Fonts privacy policy
$wp_customize->add_control( new Suki_Customize_Control_Blank( $wp_customize, 'content_container', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Google Fonts privacy policy', 'suki' ),
	'description' => '<p>' . esc_html__( 'By default, theme would use Google Fonts API to serve Google Fonts on frontend. There are chances that some data of you and your visitor might be collected by Google. If you do not accept this, you can use this plugin to self-host the fonts on your own server:', 'suki' ) . '</p><p><a href="' . admin_url( 'plugin-install.php?s=selfhost-google-fonts&tab=search&type=term' ) . '">' . esc_html__( 'Self-Hosted Google Fonts', 'suki' ) . '</a></p>',
	'priority'    => 10,
) ) );

// Additional subsets
$id = 'google_fonts_subsets';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'multiselect' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_MultiCheck( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Additional character subsets', 'suki' ),
	'description' => esc_html__( '"Latin" character subset is included by default.', 'suki' ),
	'choices'     => suki_get_google_fonts_subsets(),
	'priority'    => 10,
) ) );