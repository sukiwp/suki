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

/**
 * ====================================================
 * Suki Pro Upsell
 * ====================================================
 */

if ( suki_show_pro_teaser() ) {
	$wp_customize->add_control( new Suki_Customize_Control_Pro_Teaser( $wp_customize, 'pro_teaser_social_icons', array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => esc_html_x( 'More Options Available', 'Suki Pro upsell', 'suki' ),
		'url'         => esc_url( add_query_arg( array( 'utm_source' => 'suki-customizer', 'utm_medium' => 'learn-more', 'utm_campaign' => 'theme-upsell' ), SUKI_PRO_URL ) ),
		'features'    => array(
			esc_html_x( 'Replace default social icons with custom icons', 'Suki Pro upsell', 'suki' ),
			esc_html_x( 'Add more (custom) social icons', 'Suki Pro upsell', 'suki' ),
		),
		'priority'    => 90,
	) ) );
}