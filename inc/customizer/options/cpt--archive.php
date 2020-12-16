<?php
/**
 * Customizer settings: Other Pages > [Custom Post Type] Archive Page
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

foreach ( Suki_Customizer::instance()->get_all_page_settings_types() as $ps_type => $ps_data ) {
	// Only process archive pages.
	if ( ! preg_match( '/_archive/', $ps_type ) ) {
		continue;
	}

	// Extract the post type slug from $ps_type.
	$post_type_slug = preg_replace( '/_archive/', '', $ps_type );

	// Only process custom post types that have no dedicated options.
	if ( in_array( $post_type_slug, apply_filters( 'suki/customizer/auto_page_options/excluded_post_types', array( 'post' ) ) ) ) {
		continue;
	}

	$section = suki_array_value( $ps_data, 'section' );
	$option_prefix = $ps_type;

	/**
	 * ====================================================
	 * Content Header
	 * ====================================================
	 */

	// Heading: Content Header
	$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_' . $option_prefix . '_content_header', array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => esc_html__( 'Content Header', 'suki' ),
		'priority'    => 10,
	) ) );

	// Elements
	$key = $option_prefix . '_content_header';
	$wp_customize->add_setting( $key, array(
		'default'     => suki_array_value( $defaults, $key, array( 'archive-title', 'archive-description' ) ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'multiselect' ),
	) );
	$wp_customize->add_control( new Suki_Customize_Control_Sortable( $wp_customize, $key, array(
		'section'     => $section,
		// 'label'       => esc_html__( 'Elements', 'suki' ),
		'choices'     => array(
			'archive-title'       => esc_html__( 'Title', 'suki' ),
			'archive-description' => esc_html__( 'Description', 'suki' ),
			'breadcrumb'          => esc_html__( 'Breadcrumb', 'suki' ),
		),
		'layout'      => 'block',
		'priority'    => 10,
	) ) );

	// Alignment
	$key = $option_prefix . '_content_header_alignment';
	$wp_customize->add_setting( $key, array(
		'default'     => suki_array_value( $defaults, $key, 'left' ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
	) );
	$wp_customize->add_control( new Suki_Customize_Control_RadioImage( $wp_customize, $key, array(
		'section'     => $section,
		// 'label'       => esc_html__( 'Alignment', 'suki' ),
		'choices'     => array(
			'left'   => array(
				'label' => '<span class="dashicons dashicons-editor-align' . ( is_rtl() ? 'right' : 'left' ) . '"></span>',
			),
			'center' => array(
				'label' => '<span class="dashicons dashicons-editor-aligncenter"></span>',
			),
			'right'  => array(
				'label' => '<span class="dashicons dashicons-editor-align' . ( is_rtl() ? 'left' : 'right' ) . '"></span>',
			),
		),
		'priority'    => 10,
	) ) );
}