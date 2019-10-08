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
 * Posts Layout
 * ====================================================
 */

// Posts layout
$key = 'blog_index_loop_mode';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_RadioImage( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Posts layout', 'suki' ),
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
	'priority'    => 10,
) ) );

// Grid columns
$key = 'blog_index_grid_columns';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Columns', 'suki' ),
	'units'       => array(
		'' => array(
			'min'  => 2,
			'max'  => 4,
			'step' => 1,
			'label' => 'col',
		),
	),
	'priority'    => 10,
) ) );

// Rows gutter
$key = 'blog_index_grid_rows_gutter';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Rows gutter', 'suki' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'max'  => 40,
			'step' => 1,
		),
		'em' => array(
			'min'  => 0,
			'max'  => 3,
			'step' => 0.05,
		),
	),
	'priority'    => 10,
) ) );

// Columns gutter
$key = 'blog_index_grid_columns_gutter';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Columns gutter', 'suki' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'max'  => 40,
			'step' => 1,
		),
		'em' => array(
			'min'  => 0,
			'max'  => 3,
			'step' => 0.05,
		),
	),
	'priority'    => 10,
) ) );

// ------
$wp_customize->add_control( new Suki_Customize_Control_HR( $wp_customize, 'hr_blog_index_navigation', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 10,
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
	'priority'    => 10,
) );