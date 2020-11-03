<?php
/**
 * Customizer settings: Blog > Post Layout: Default
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'suki_section_entry_default';

// Items gap
$key = 'blog_index_default_items_gap';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Items gap', 'suki' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'max'  => 300,
			'step' => 1,
		),
		'em' => array(
			'min'  => 0,
			'max'  => 20,
			'step' => 0.05,
		),
	),
	'priority'    => 10,
) ) );

/**
 * ====================================================
 * Entry Wrapper
 * ====================================================
 */

// Heading: Entry Wrapper
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_entry_item', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Entry Wrapper', 'suki' ),
	'priority'    => 20,
) ) );

// Padding
$key = 'entry_padding';
$settings = array(
	$key,
	$key . '__tablet',
	$key . '__mobile',
);
foreach ( $settings as $setting ) {
	$wp_customize->add_setting( $setting, array(
		'default'     => suki_array_value( $defaults, $setting ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimensions' ),
	) );
}
$wp_customize->add_control( new Suki_Customize_Control_Dimensions( $wp_customize, $key, array(
	'settings'    => $settings,
	'section'     => $section,
	'label'       => esc_html__( 'Padding', 'suki' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'step' => 1,
		),
		'em' => array(
			'min'  => 0,
			'step' => 0.05,
		),
	),
	'priority'    => 20,
) ) );

// Border
$key = 'entry_border';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimensions' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Dimensions( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Border', 'suki' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'step' => 1,
		),
	),
	'priority'    => 20,
) ) );

// Border radius
$key = 'entry_border_radius';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Border radius', 'suki' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'max'  => 40,
			'step' => 1,
		),
	),
	'priority'    => 20,
) ) );

/**
 * ====================================================
 * Entry Header
 * ====================================================
 */

// Heading: Entry Header
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_entry_header', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Entry Header', 'suki' ),
	'priority'    => 30,
) ) );

// Elements
$key = 'entry_header';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'multiselect' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Builder( $wp_customize, $key, array(
	'section'     => $section,
	// 'label'       => esc_html__( 'Elements', 'suki' ),
	'choices'     => array(
		'header-meta'    => esc_html__( 'Header Meta', 'suki' ),
		'title'          => esc_html__( 'Title', 'suki' ),
		'featured-media' => esc_html__( 'Featured Media', 'suki' ),
	),
	'layout'      => 'block',
	'priority'    => 30,
) ) );

// Alignment
$key = 'entry_header_alignment';
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
	'priority'    => 30,
) ) );

// Header meta text
$key = 'entry_header_meta';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'text' ),
) );
$wp_customize->add_control( $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Header meta text', 'suki' ),
	'description' => esc_html__( 'Available tags: {{date}}, {{categories}}, {{tags}}, {{author}}, {{avatar}}, {{comments}}.', 'suki' ),
	'priority'    => 30,
) );

// Featured media ignores padding
$key = 'entry_featured_media_ignore_padding';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Featured media ignores padding', 'suki' ),
	'priority'    => 30,
) ) );

/**
 * ====================================================
 * Entry Content
 * ====================================================
 */

// Heading: Entry Content
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_entry_content', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Entry Content', 'suki' ),
	'priority'    => 40,
) ) );

// Entry excerpt length
$key = 'entry_excerpt_length';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Excerpt words limit', 'suki' ),
	'description' => esc_html__( 'Fill with 0 to disable excerpt.', 'suki' ),
	'units'       => array(
		'' => array(
			'min'  => 0,
			'max'  => 200,
			'step' => 1,
			'label' => 'wrd',
		),
	),
	'priority'    => 40,
) ) );

// Read more
$key = 'entry_read_more_display';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Read more', 'suki' ),
	'choices'     => array(
		''       => esc_html__( 'None', 'suki' ),
		'text'   => esc_html__( 'Text', 'suki' ),
		'button' => esc_html__( 'Button', 'suki' ),
	),
	'priority'    => 40,
) );

// Read more text
$key = 'entry_read_more_text';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'text' ),
) );
$wp_customize->add_control( $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Read more text', 'suki' ),
	'input_attrs' => array(
		'placeholder' => esc_html__( 'Read more', 'suki' ),
	),
	'priority'    => 40,
) );

/**
 * ====================================================
 * Entry Footer
 * ====================================================
 */

// Heading: Entry Footer
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_entry_meta', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Entry Footer', 'suki' ),
	'priority'    => 50,
) ) );

// Elements
$key = 'entry_footer';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'multiselect' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Builder( $wp_customize, $key, array(
	'section'     => $section,
	// 'label'       => esc_html__( 'Elements', 'suki' ),
	'choices'     => array(
		'footer-meta' => esc_html__( 'Footer Meta', 'suki' ),
	),
	'layout'      => 'block',
	'priority'    => 50,
) ) );

// Alignment
$key = 'entry_footer_alignment';
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
	'priority'    => 50,
) ) );

// Footer meta text
$key = 'entry_footer_meta';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'text' ),
) );
$wp_customize->add_control( $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Footer meta text', 'suki' ),
	'description' => esc_html__( 'Available tags: {{date}}, {{categories}}, {{tags}}, {{author}}, {{avatar}}, {{comments}}', 'suki' ),
	'priority'    => 50,
) );

/**
 * ====================================================
 * Colors
 * ====================================================
 */

// Heading: Colors
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_entry_colors', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Colors', 'suki' ),
	'priority'    => 80,
) ) );

// Colors
$colors = array(
	'entry_bg_color'     => esc_html__( 'Background color', 'suki' ),
	'entry_border_color' => esc_html__( 'Border color', 'suki' ),
);
foreach ( $colors as $key => $label ) {
	$wp_customize->add_setting( $key, array(
		'default'     => suki_array_value( $defaults, $key ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'color' ),
	) );
	$wp_customize->add_control( new Suki_Customize_Control_Color( $wp_customize, $key, array(
		'section'     => $section,
		'label'       => $label,
		'priority'    => 80,
	) ) );
}

// Shadow
$key = 'entry_shadow';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'shadow' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Shadow( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Shadow', 'suki' ),
	'exclude'     => array( 'position' ),
	'priority'    => 80,
) ) );