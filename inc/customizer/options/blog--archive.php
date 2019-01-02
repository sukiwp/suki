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
$id = 'blog_index_loop_mode';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $id, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Posts layout', 'suki' ),
	'choices'     => array(
		'default' => esc_html__( 'Default (same as Single Post page)', 'suki' ),
		'grid'    => esc_html__( 'Grid', 'suki' ),
	),
	'priority'    => 10,
) );

// Grid columns
$id = 'blog_index_grid_columns';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $id, array(
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

// Columns gutter
$id = 'blog_index_grid_columns_gutter';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Columns gutter', 'suki' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'max'  => 40,
			'step' => 1,
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
$id = 'blog_index_navigation_mode';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $id, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Navigation mode', 'suki' ),
	'choices'     => array(
		'prev-next'  => esc_html__( 'Prev / Next buttons', 'suki' ),
		'pagination' => esc_html__( 'Pagination (page numbers)', 'suki' ),
	),
	'priority'    => 10,
) );

/**
 * ====================================================
 * Suki Pro Upsell
 * ====================================================
 */

// if ( suki_show_pro_teaser() ) {
// 	$wp_customize->add_control( new Suki_Customize_Control_Pro_Teaser( $wp_customize, 'pro_teaser_blog_index', array(
// 		'section'     => $section,
// 		'settings'    => array(),
// 		'label'       => esc_html_x( 'More Options on Suki Pro', 'Suki Pro upsell', 'suki' ),
// 		'url'         => SUKI_PRO_URL,
// 		'features'    => array(
// 			esc_html_x( 'More blog layouts', 'Suki Pro upsell', 'suki' ),
// 		),
// 		'priority'    => 90,
// 	) ) );
// }