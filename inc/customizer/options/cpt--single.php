<?php
/**
 * Customizer settings: Other Pages > Single [Custom Post Type] Page
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

foreach ( Suki_Customizer::instance()->get_all_page_settings_types() as $ps_type => $ps_data ) {
	// Only process singular pages.
	if ( ! preg_match( '/_single/', $ps_type ) ) {
		continue;
	}

	// Extract the post type slug from $ps_type.
	$post_type_slug = preg_replace( '/_single/', '', $ps_type );

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
		'default'     => suki_array_value( $defaults, $key ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'multiselect' ),
	) );
	$wp_customize->add_control( new Suki_Customize_Control_Sortable( $wp_customize, $key, array(
		'section'     => $section,
		// 'label'       => esc_html__( 'Elements', 'suki' ),
		'choices'     => array(
			'entry-title' => esc_html__( 'Title', 'suki' ),
			'breadcrumb'  => esc_html__( 'Breadcrumb', 'suki' ),
		),
		'priority'    => 10,
	) ) );

	// Alignment
	$key = $option_prefix . '_content_header_alignment';
	$wp_customize->add_setting( $key, array(
		'default'     => suki_array_value( $defaults, $key ),
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

	/**
	 * ====================================================
	 * Featured Image
	 * ====================================================
	 */

	if ( post_type_supports( $post_type_slug, 'thumbnail' ) ) {
		// Heading: Featured Image
		$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_' . $option_prefix . '_content_thumbnail', array(
			'section'     => $section,
			'settings'    => array(),
			'label'       => esc_html__( 'Featured Image', 'suki' ),
			'priority'    => 20,
		) ) );

		// Display
		$key =  $option_prefix . '_content_thumbnail';
		$wp_customize->add_setting( $key, array(
			'default'     => suki_array_value( $defaults, $key ),
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
		) );
		$wp_customize->add_control( $key, array(
			'type'        => 'select',
			'section'     => $section,
			'label'       => esc_html__( 'Display', 'suki' ),
			'choices'     => array(
				''       => esc_html__( 'Disabled', 'suki' ),
				'before' => esc_html__( 'Before Content Header', 'suki' ),
				'after'  => esc_html__( 'After Content Header', 'suki' ),
			),
			'priority'    => 20,
		) );

		// Wide alignment
		$key =  $option_prefix . '_content_thumbnail_wide';
		$wp_customize->add_setting( $key, array(
			'default'     => suki_array_value( $defaults, $key ),
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
		) );
		$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $key, array(
			'section'     => $section,
			'label'       => esc_html__( 'Wide alignment', 'suki' ) . ' <span class="suki-tooltip suki-tooltip-bottom" tabindex="0" data-tooltip="' . esc_attr__( 'Only works on Narrow content container.', 'suki' ) . '"><span class="dashicons dashicons-info"></span></span>',
			'priority'    => 20,
		) ) );
	}
}