<?php
/**
 * Customizer settings: Global Settings > Contact Details
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'suki_section_contact_details';

/**
 * ====================================================
 * Links
 * ====================================================
 */

$links = suki_get_contact_details_details();
ksort( $links );

foreach ( $links as $slug => $label ) {
	// Social media link
	$id = 'contact_details_' . $slug;
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
