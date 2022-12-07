<?php
/**
 * Customizer settings: Header > Social Links
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$section = 'suki_section_header_social';

/**
 * ====================================================
 * Social Links
 * ====================================================
 */

// Heading: Social Links.
$wp_customize->add_control(
	new Suki_Customize_Heading_Control(
		$wp_customize,
		'heading_header_social',
		array(
			'section'     => $section,
			'settings'    => array(),
			'label'       => esc_html__( 'Social Links', 'suki' ),
			'description' => sprintf(
				/* translators: %s: link to "Global Modules" section. */
				esc_html__( 'You can edit Social Media URLs via %s.', 'suki' ),
				'<a href="' . esc_attr( add_query_arg( 'autofocus[section]', 'suki_section_social', remove_query_arg( 'autofocus' ) ) ) . '" class="suki-jump-to-control-link">' . esc_html__( 'Global Modules', 'suki' ) . '</a>'
			),
			'priority'    => 10,
		)
	)
);

// Social links.
$key = 'header_social_links';
$wp_customize->add_setting(
	$key,
	array(
		'default'           => suki_array_value( $defaults, $key ),
		'transport'         => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'multiselect' ),
	)
);
$wp_customize->add_control(
	new Suki_Customize_MultiSelect_Control(
		$wp_customize,
		$key,
		array(
			'section'     => $section,
			'label'       => esc_html__( 'Active links', 'suki' ),
			'choices'     => suki_get_social_media_types( true ),
			'is_sortable' => true,
			'priority'    => 10,
		)
	)
);

/**
 * ====================================================
 * Selective Refresh
 * ====================================================
 */

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial(
		$key,
		array(
			'selector'            => '.suki-header-social',
			'container_inclusive' => true,
			'render_callback'     => function() {
				suki_header_element( 'social' );
			},
			'fallback_refresh'    => false,
		)
	);
}

// Social links target.
$key = 'header_social_links_target';
$wp_customize->add_setting(
	$key,
	array(
		'default'           => suki_array_value( $defaults, $key ),
		'transport'         => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
	)
);
$wp_customize->add_control(
	$key,
	array(
		'type'     => 'select',
		'section'  => $section,
		'label'    => esc_html__( 'Open links in', 'suki' ),
		'choices'  => array(
			'self'  => esc_html__( 'Same tab', 'suki' ),
			'blank' => esc_html__( 'New tab', 'suki' ),
		),
		'priority' => 10,
	)
);
