<?php
/**
 * Customizer settings: Blog > Post Layout: Grid
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'suki_section_entry_grid';

/**
 * ====================================================
 * Grid Layout
 * ====================================================
 */

// Grid columns
$id = 'blog_index_grid_columns';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'slider' ),
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

// Gap between columns
$id = 'blog_index_grid_columns_gap';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'slider' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Gap between columns', 'suki' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'max'  => 40,
			'step' => 1,
		),
	),
	'priority'    => 10,
) ) );

// Heading: Grid Item
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_entry_grid_item', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Grid Item', 'suki' ),
	'priority'    => 10,
) ) );

// Featured media position
$id = 'entry_grid_featured_media_position';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $id, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Featured media position', 'suki' ),
	'choices'     => array(
		'before-entry-header' => esc_html__( 'Before Post Header', 'suki' ),
		'after-entry-header'  => esc_html__( 'After Post Header', 'suki' ),
	),
	'priority'    => 10,
) );

// Post header elements
$id = 'entry_grid_header';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'refresh',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'multiselect' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Builder( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Post header elements', 'suki' ),
	'choices'     => apply_filters( 'suki_customizer_entry_grid_header_elements', array(
		'header-meta'    => esc_html__( 'Header Meta', 'suki' ),
		'title'          => esc_html__( 'Title', 'suki' ),
	) ),
	'layout'      => 'block',
	'priority'    => 10,
) ) );

// Post header alignment
$id = 'entry_grid_header_alignment';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $id, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Post header alignment', 'suki' ),
	'choices'     => array(
		'left'   => is_rtl() ? esc_html__( 'Right - RTL', 'suki' ) : esc_html__( 'Left', 'suki' ),
		'center' => esc_html__( 'Center', 'suki' ),
		'right'  => is_rtl() ? esc_html__( 'Left - RTL', 'suki' ) : esc_html__( 'Right', 'suki' ),
	),
	'priority'    => 10,
) );

// Post header meta elements
$id = 'entry_grid_header_meta';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'refresh',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'multiselect' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Builder( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Header meta elements', 'suki' ),
	'choices'     => suki_get_entry_meta_elements(),
	'priority'    => 10,
) ) );

// Post footer meta elements
$id = 'entry_grid_footer_meta';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'refresh',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'multiselect' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Builder( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Footer meta elements', 'suki' ),
	'choices'     => suki_get_entry_meta_elements(),
	'priority'    => 10,
) ) );

// Entry grid excerpt length
$id = 'entry_grid_excerpt_length';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'refresh',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'slider' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Excerpt length', 'suki' ),
	'units'       => array(
		'' => array(
			'min'  => 0,
			'max'  => 200,
			'step' => 1,
			'label' => 'chr',
		),
	),
	'priority'    => 10,
) ) );