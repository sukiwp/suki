<?php
/**
 * Customizer settings: Blog > Posts Index
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'suki_section_blog_index';

/**
 * ====================================================
 * Content Header
 * ====================================================
 */

// Heading: Content Header
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_blog_index_header', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Content Header', 'suki' ),
	'priority'    => 10,
) ) );

// Alignment
$key = 'blog_index_header_alignment';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_RadioImage( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Alignment', 'suki' ),
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
 * Posts Layout
 * ====================================================
 */

// Heading: Posts Layout
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_blog_index_layout', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Posts Layout', 'suki' ),
	'priority'    => 20,
) ) );

// Posts layout
$key = 'blog_index_loop_mode';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_RadioImage( $wp_customize, $key, array(
	'section'     => $section,
	'choices'     => array(
		'default' => array(
			'label' => esc_html__( 'Default', 'suki' ),
			'image' => SUKI_IMAGES_URL . '/customizer/blog-layout--default.svg',
		),
		'grid'    => array(
			'label' => esc_html__( 'Grid', 'suki' ),
			'image' => SUKI_IMAGES_URL . '/customizer/blog-layout--grid.svg',
		),
	),
	'priority'    => 20,
) ) );

// Edit entry default
$wp_customize->add_control( new Suki_Customize_Control_Blank( $wp_customize, 'blank_edit_entry_default', array(
	'section'     => $section,
	'settings'    => array(),
	'description' => '<a href="' . esc_url( add_query_arg( 'autofocus[section]', 'suki_section_entry_default', remove_query_arg( 'autofocus' ) ) ) . '" class="suki-customize-goto-control button button-secondary">' . esc_html__( 'Edit Post Layout: Default', 'suki' ) . '</a>',
	'priority'    => 21,
) ) );

// Edit entry grid
$wp_customize->add_control( new Suki_Customize_Control_Blank( $wp_customize, 'blank_edit_entry_grid', array(
	'section'     => $section,
	'settings'    => array(),
	'description' => '<a href="' . esc_url( add_query_arg( 'autofocus[section]', 'suki_section_entry_grid', remove_query_arg( 'autofocus' ) ) ) . '" class="suki-customize-goto-control button button-secondary">' . esc_html__( 'Edit Post Layout: Grid', 'suki' ) . '</a>',
	'priority'    => 21,
) ) );

// Navigation mode
$key = 'blog_index_navigation_mode';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Navigation mode', 'suki' ),
	'choices'     => array(
		'prev-next'  => esc_html__( 'Prev / Next buttons', 'suki' ),
		'pagination' => esc_html__( 'Pagination (page numbers)', 'suki' ),
	),
	'priority'    => 25,
) );