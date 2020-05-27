<?php
/**
 * Customizer settings: Global Settings > Performance
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'suki_section_performance';

/**
 * ====================================================
 * Performance
 * ====================================================
 */

// Disable emoji scripts
$key = 'disable_emoji';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Disable emoji scripts', 'suki' ),
	'description' => esc_html__( 'If you don\'t use Emoji in your website at all, you can disable the default emoji scripts to improve the performance.', 'suki' ),
	'priority'    => 10,
) ) );