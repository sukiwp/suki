<?php
/**
 * Customizer settings: Global Settings > Contact Information
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'suki_section_contact_info';

/**
 * ====================================================
 * Links
 * ====================================================
 */

$links = suki_get_contact_info_details();
ksort( $links );

foreach ( $links as $slug => $label ) {
	// Social media link
	$id = 'contact_info_' . $slug;
	$wp_customize->add_setting( $id, array(
		'default'     => suki_array_value( $defaults, $id ),
	//	'sanitize_callback' =>  array( 'Suki_Customizer_Sanitization', 'number' ),
	) );
	$wp_customize->add_control( $id, array(
		'section'     => $section,
		'label'       => $label,
		'priority'    => 10,
	) );
}
