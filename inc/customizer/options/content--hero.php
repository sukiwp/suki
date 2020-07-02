<?php
/**
 * Customizer settings: Hero Section
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'suki_section_hero';

/**
 * ====================================================
 * Enable / Disable
 * ====================================================
 */

// Enable
$key = 'hero';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Enable', 'suki' ) . ' <span class="suki-global-default-badge suki-tooltip" tabindex="0" data-tooltip="' . esc_attr__( 'You can enable or disable this option on each individual page.', 'suki-pro' ) . '"><span class="dashicons dashicons-admin-site-alt3"></span> ' . esc_html__( 'Global', 'suki' ) . '</span>',
	'description' => esc_html__( 'When enabled, the current page\'s title, description, meta, and breadcrumb will be displayed inside the Hero section.', 'suki' ),
	'priority'    => 10,
) ) );

/**
 * ====================================================
 * Layout
 * ====================================================
 */

// Heading: Layout
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_hero_layout', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Layout', 'suki' ),
	'priority'    => 20,
) ) );

// Container width
$key = 'hero_container';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_RadioImage( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Container width', 'suki' ),
	'choices'     => array(
		'default'    => array(
			'label' => esc_html__( 'Normal', 'suki' ),
			'image' => SUKI_IMAGES_URL . '/customizer/hero-container--default.svg',
		),
		'full-width' => array(
			'label' => esc_html__( 'Full width', 'suki' ),
			'image' => SUKI_IMAGES_URL . '/customizer/hero-container--full-width.svg',
		),
		'narrow'     => array(
			'label' => esc_html__( 'Narrow', 'suki' ),
			'image' => SUKI_IMAGES_URL . '/customizer/hero-container--narrow.svg',
		),
	),
	'priority'    => 20,
) ) );

// Minimal height
$key = 'hero_height';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Minimal height', 'suki' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'max'  => 1000,
			'step' => 1,
		),
		'vh' => array(
			'min'  => 0,
			'max'  => 100,
			'step' => 0.5,
		),
	),
	'priority'    => 20,
) ) );

// Padding
$key = 'hero_padding';
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
		'%' => array(
			'min'  => 0,
			'step' => 1,
		),
	),
	'priority'    => 20,
) ) );

// Border
$key = 'hero_border';
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

// Alignment
$key = 'hero_alignment';
$wp_customize->add_setting( $key, array(
	'default'     => suki_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Alignment', 'suki' ),
	'choices'     => array(
		'left'   => is_rtl() ? esc_html__( 'Right', 'suki' ) : esc_html__( 'Left', 'suki' ),
		'center' => esc_html__( 'Center', 'suki' ),
		'right'  => is_rtl() ? esc_html__( 'Left', 'suki' ) : esc_html__( 'Right', 'suki' ),
	),
	'priority'    => 20,
) );

/**
 * ====================================================
 * Typography
 * ====================================================
 */

// Heading: Typography
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_hero_typography', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Typography', 'suki' ),
	'priority'    => 40,
) ) );

// Title typography
$settings = array(
	'font_family'    => 'hero_title_font_family',
	'font_weight'    => 'hero_title_font_weight',
	'font_style'     => 'hero_title_font_style',
	'text_transform' => 'hero_title_text_transform',
	'font_size'      => 'hero_title_font_size',
	'line_height'    => 'hero_title_line_height',
	'letter_spacing' => 'hero_title_letter_spacing',

	'font_size__tablet'      => 'hero_title_font_size__tablet',
	'line_height__tablet'    => 'hero_title_line_height__tablet',
	'letter_spacing__tablet' => 'hero_title_letter_spacing__tablet',

	'font_size__mobile'      => 'hero_title_font_size__mobile',
	'line_height__mobile'    => 'hero_title_line_height__mobile',
	'letter_spacing__mobile' => 'hero_title_letter_spacing__mobile',
);
foreach ( $settings as $key ) {
	$wp_customize->add_setting( $key, array(
		'default'     => suki_array_value( $defaults, $key ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'typography' ),
	) );
}
$wp_customize->add_control( new Suki_Customize_Control_Typography( $wp_customize, 'hero_title_typography', array(
	'settings'    => $settings,
	'section'     => $section,
	'label'       => esc_html__( 'Title typography', 'suki' ),
	'priority'    => 40,
) ) );

// Description typography
$settings = array(
	'font_family'    => 'hero_font_family',
	'font_weight'    => 'hero_font_weight',
	'font_style'     => 'hero_font_style',
	'text_transform' => 'hero_text_transform',
	'font_size'      => 'hero_font_size',
	'line_height'    => 'hero_line_height',
	'letter_spacing' => 'hero_letter_spacing',

	'font_size__tablet'      => 'hero_font_size__tablet',
	'line_height__tablet'    => 'hero_line_height__tablet',
	'letter_spacing__tablet' => 'hero_letter_spacing__tablet',

	'font_size__mobile'      => 'hero_font_size__mobile',
	'line_height__mobile'    => 'hero_line_height__mobile',
	'letter_spacing__mobile' => 'hero_letter_spacing__mobile',
);
foreach ( $settings as $key ) {
	$wp_customize->add_setting( $key, array(
		'default'     => suki_array_value( $defaults, $key ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'typography' ),
	) );
}
$wp_customize->add_control( new Suki_Customize_Control_Typography( $wp_customize, 'hero_title_typography', array(
	'settings'    => $settings,
	'section'     => $section,
	'label'       => esc_html__( 'Description typography', 'suki' ),
	'priority'    => 40,
) ) );

// Meta typography
$settings = array(
	'font_family'    => 'hero_meta_font_family',
	'font_weight'    => 'hero_meta_font_weight',
	'font_style'     => 'hero_meta_font_style',
	'text_transform' => 'hero_meta_text_transform',
	'font_size'      => 'hero_meta_font_size',
	'line_height'    => 'hero_meta_line_height',
	'letter_spacing' => 'hero_meta_letter_spacing',

	'font_size__tablet'      => 'hero_meta_font_size__tablet',
	'line_height__tablet'    => 'hero_meta_line_height__tablet',
	'letter_spacing__tablet' => 'hero_meta_letter_spacing__tablet',

	'font_size__mobile'      => 'hero_meta_font_size__mobile',
	'line_height__mobile'    => 'hero_meta_line_height__mobile',
	'letter_spacing__mobile' => 'hero_meta_letter_spacing__mobile',
);
foreach ( $settings as $key ) {
	$wp_customize->add_setting( $key, array(
		'default'     => suki_array_value( $defaults, $key ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'typography' ),
	) );
}
$wp_customize->add_control( new Suki_Customize_Control_Typography( $wp_customize, 'hero_title_typography', array(
	'settings'    => $settings,
	'section'     => $section,
	'label'       => esc_html__( 'Meta typography', 'suki' ),
	'priority'    => 40,
) ) );

// Breadcrumb typography
$settings = array(
	'font_family'    => 'hero_breadcrumb_font_family',
	'font_weight'    => 'hero_breadcrumb_font_weight',
	'font_style'     => 'hero_breadcrumb_font_style',
	'text_transform' => 'hero_breadcrumb_text_transform',
	'font_size'      => 'hero_breadcrumb_font_size',
	'line_height'    => 'hero_breadcrumb_line_height',
	'letter_spacing' => 'hero_breadcrumb_letter_spacing',

	'font_size__tablet'      => 'hero_breadcrumb_font_size__tablet',
	'line_height__tablet'    => 'hero_breadcrumb_line_height__tablet',
	'letter_spacing__tablet' => 'hero_breadcrumb_letter_spacing__tablet',

	'font_size__mobile'      => 'hero_breadcrumb_font_size__mobile',
	'line_height__mobile'    => 'hero_breadcrumb_line_height__mobile',
	'letter_spacing__mobile' => 'hero_breadcrumb_letter_spacing__mobile',
);
foreach ( $settings as $key ) {
	$wp_customize->add_setting( $key, array(
		'default'     => suki_array_value( $defaults, $key ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'typography' ),
	) );
}
$wp_customize->add_control( new Suki_Customize_Control_Typography( $wp_customize, 'hero_breadcrumb_typography', array(
	'settings'    => $settings,
	'section'     => $section,
	'label'       => esc_html__( 'Breadcrumb typography', 'suki' ),
	'priority'    => 40,
) ) );

/**
 * ====================================================
 * Colors
 * ====================================================
 */

// Heading: Colors
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_hero_colors', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Colors', 'suki' ),
	'priority'    => 50,
) ) );

// Colors
$colors = array(
	'hero_bg_color'                         => esc_html__( 'Background color', 'suki' ),
	'hero_border_color'                     => esc_html__( 'Border color', 'suki' ),
	'hero_title_text_color'                 => esc_html__( 'Title text color', 'suki' ),
	'hero_breadcrumb_text_color'            => esc_html__( 'Breadcrumb text color', 'suki' ),
	'hero_breadcrumb_link_text_color'       => esc_html__( 'Breadcrumb link text color', 'suki' ),
	'hero_breadcrumb_link_hover_text_color' => esc_html__( 'Breadcrumb link text color :hover', 'suki' ),
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
		'priority'    => 50,
	) ) );
}

// /**
//  * ====================================================
//  * Background
//  * ====================================================
//  */

// // Heading: Background Image (Global Default)
// $wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_hero_background', array(
// 	'section'     => $section,
// 	'settings'    => array(),
// 	'label'       => esc_html__( 'Background Image (Global Default)', 'suki' ),
// 	'priority'    => 60,
// ) ) );

// // Background image
// $key = 'hero_bg_image';
// $wp_customize->add_setting( $key, array(
// 	'default'     => suki_array_value( $defaults, $key ),
// 	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'image' ),
// ) );
// $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $key, array(
// 	'section'     => $section,
// 	'label'       => esc_html__( 'Background image', 'suki' ),
// 	'mime_type'   => 'image',
// 	'priority'    => 60,
// ) ) );

// // Background attachment
// $key = 'hero_bg_attachment';
// $wp_customize->add_setting( $key, array(
// 	'default'     => suki_array_value( $defaults, $key ),
// 	'transport'   => 'postMessage',
// 	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
// ) );
// $wp_customize->add_control( $key, array(
// 	'type'        => 'select',
// 	'section'     => $section,
// 	'label'       => esc_html__( 'Background attachment', 'suki' ),
// 	'choices'     => array(
// 		'scroll' => esc_html__( 'Scroll', 'suki' ),
// 		'fixed'  => esc_html__( 'Fixed', 'suki' ),
// 	),
// 	'priority'    => 60,
// ) );

// // Colors
// $key = 'hero_bg_overlay_color';
// $wp_customize->add_setting( $key, array(
// 	'default'     => suki_array_value( $defaults, $key ),
// 	'transport'   => 'postMessage',
// 	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'color' ),
// ) );
// $wp_customize->add_control( new Suki_Customize_Control_Color( $wp_customize, $key, array(
// 	'section'     => $section,
// 	'label'       => esc_html__( 'Background overlay color', 'suki' ),
// 	'priority'    => 60,
// ) ) );