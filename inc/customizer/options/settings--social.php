<?php
/**
 * Customizer settings: Global Settings > Social Media URLs
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'suki_section_social';

/**
 * ====================================================
 * Links
 * ====================================================
 */

$links = suki_get_social_media_types();
ksort( $links );
	
foreach ( $links as $slug => $label ) {
	// Social media link
	$key = 'social_' . $slug;
	$wp_customize->add_setting( $key, array(
		'default'     => suki_array_value( $defaults, $key ),
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( $key, array(
		'section'     => $section,
		'label'       => $label,
		'priority'    => 10,
	) );
}