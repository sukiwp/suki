<?php
/**
 * Customizer settings: Page Header (Title Bar)
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'suki_section_page_header';

/**
 * ====================================================
 * Layout
 * ====================================================
 */

// Enable Page Header
$id = 'page_header';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Enable Page Header', 'suki' ),
	'priority'    => 10,
) ) );

// ------
$wp_customize->add_control( new Suki_Customize_Control_HR( $wp_customize, 'hr_page_header_layout', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 10,
) ) );

// Section container
$id = 'page_header_container';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $id, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Section container', 'suki' ),
	'choices'     => array(
		'default'            => esc_html__( 'Fixed width container', 'suki' ),
		'full-width'         => esc_html__( 'Full container', 'suki' ),
		'full-width-padding' => esc_html__( 'Full container with side padding', 'suki' ),
	),
	'priority'    => 10,
) );

// Padding
$id = 'page_header_padding';
$settings = array(
	$id,
	$id . '__tablet',
	$id . '__mobile',
);
foreach ( $settings as $setting ) {
	$wp_customize->add_setting( $setting, array(
		'default'     => suki_array_value( $defaults, $setting ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimensions' ),
	) );
}
$wp_customize->add_control( new Suki_Customize_Control_Dimensions( $wp_customize, $id, array(
	'settings'    => $settings,
	'section'     => $section,
	'label'       => esc_html__( 'Padding', 'suki' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'max'  => 120,
			'step' => 1,
		),
	),
	'priority'    => 10,
) ) );

// Border
$id = 'page_header_border';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimensions' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Dimensions( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Border', 'suki' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'max'  => 8,
			'step' => 1,
		),
	),
	'priority'    => 10,
) ) );

// ------
$wp_customize->add_control( new Suki_Customize_Control_HR( $wp_customize, 'hr_page_header_elements', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 10,
) ) );

// Page title & breadcrumb layout
$id = 'page_header_layout';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $id, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Page title & breadcrumb layout', 'suki' ),
	'choices'     => array(
		'center'     => esc_html__( 'Centered (all)', 'suki' ),
		'left'       => is_rtl() ? esc_html__( 'Right (all)', 'suki' ) : esc_html__( 'Left (all)', 'suki' ),
		'right'      => is_rtl() ? esc_html__( 'Left (all)', 'suki' ) : esc_html__( 'Right (all)', 'suki' ),
		'left-right' => is_rtl() ? esc_html__( 'Right title -- Left breadcrumb', 'suki' ) : esc_html__( 'Left title -- Right breadcrumb', 'suki' ),
		'right-left' => is_rtl() ? esc_html__( 'Left title -- Right breadcrumb', 'suki' ) : esc_html__( 'Right title -- Left breadcrumb', 'suki' ),
	),
	'priority'    => 10,
) );

// Show page title
$id = 'page_header_title';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Show page title', 'suki' ),
	'priority'    => 10,
) ) );

// Show breadcrumb
$id = 'page_header_breadcrumb';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Show breadcrumb', 'suki' ),
	'description' => esc_html__( 'You need to install an additional plugin in order to display breadcrumb functionality. Please choose one from the available plugins below. The selected plugin must be installed and active.', 'suki' ),
	'priority'    => 10,
) ) );

// Breadcrumb plugin
$id = 'breadcrumb_plugin';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $id, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => '',
	'choices'     => array(
		'breadcrumb-trail' => esc_html__( 'Breadcrumb Trail', 'suki' ),
		'breadcrumb-navxt' => esc_html__( 'Breadcrumb NavXT', 'suki' ),
		'yoast-seo'        => esc_html__( 'Yoast SEO', 'suki' ),
	),
	'priority'    => 10,
) );

// Selective Refresh
if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( 'page_header', array(
		'settings'            => array(
			'page_header_title',
			'page_header_breadcrumb',
			'breadcrumb_plugin',
		),
		'selector'            => '.suki-page-header',
		'container_inclusive' => true,
		'render_callback'     => 'suki_page_header',
		'fallback_refresh'    => false,
	) );
}

/**
 * ====================================================
 * Typography
 * ====================================================
 */

// Heading: Typography
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_page_header_typography', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Typography', 'suki' ),
	'priority'    => 20,
) ) );

// Page title typography
$settings = array(
	'font_family'    => 'page_header_title_font_family',
	'font_weight'    => 'page_header_title_font_weight',
	'font_style'     => 'page_header_title_font_style',
	'text_transform' => 'page_header_title_text_transform',
	'font_size'      => 'page_header_title_font_size',
	'line_height'    => 'page_header_title_line_height',
	'letter_spacing' => 'page_header_title_letter_spacing',

	'font_size__tablet'      => 'page_header_title_font_size__tablet',
	'line_height__tablet'    => 'page_header_title_line_height__tablet',
	'letter_spacing__tablet' => 'page_header_title_letter_spacing__tablet',

	'font_size__mobile'      => 'page_header_title_font_size__mobile',
	'line_height__mobile'    => 'page_header_title_line_height__mobile',
	'letter_spacing__mobile' => 'page_header_title_letter_spacing__mobile',
);
foreach ( $settings as $id ) {
	$wp_customize->add_setting( $id, array(
		'default'     => suki_array_value( $defaults, $id ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'typography' ),
	) );
}
$wp_customize->add_control( new Suki_Customize_Control_Typography( $wp_customize, 'page_header_title_typography', array(
	'settings'    => $settings,
	'section'     => $section,
	'label'       => esc_html__( 'Page title typography', 'suki' ),
	'priority'    => 20,
) ) );

// Breadcrumb typography
$settings = array(
	'font_family'    => 'page_header_breadcrumb_font_family',
	'font_weight'    => 'page_header_breadcrumb_font_weight',
	'font_style'     => 'page_header_breadcrumb_font_style',
	'text_transform' => 'page_header_breadcrumb_text_transform',
	'font_size'      => 'page_header_breadcrumb_font_size',
	'line_height'    => 'page_header_breadcrumb_line_height',
	'letter_spacing' => 'page_header_breadcrumb_letter_spacing',

	'font_size__tablet'      => 'page_header_breadcrumb_font_size__tablet',
	'line_height__tablet'    => 'page_header_breadcrumb_line_height__tablet',
	'letter_spacing__tablet' => 'page_header_breadcrumb_letter_spacing__tablet',

	'font_size__mobile'      => 'page_header_breadcrumb_font_size__mobile',
	'line_height__mobile'    => 'page_header_breadcrumb_line_height__mobile',
	'letter_spacing__mobile' => 'page_header_breadcrumb_letter_spacing__mobile',
);
foreach ( $settings as $id ) {
	$wp_customize->add_setting( $id, array(
		'default'     => suki_array_value( $defaults, $id ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'typography' ),
	) );
}
$wp_customize->add_control( new Suki_Customize_Control_Typography( $wp_customize, 'page_header_breadcrumb_typography', array(
	'settings'    => $settings,
	'section'     => $section,
	'label'       => esc_html__( 'Breadcrumb typography', 'suki' ),
	'priority'    => 20,
) ) );

/**
 * ====================================================
 * Colors
 * ====================================================
 */

// Heading: Colors
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_page_header_colors', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Colors', 'suki' ),
	'priority'    => 30,
) ) );

// Colors
$colors = array(
	'page_header_bg_color'                         => esc_html__( 'Background color', 'suki' ),
	'page_header_border_color'                     => esc_html__( 'Border color', 'suki' ),
	'page_header_title_text_color'                 => esc_html__( 'Page title text color', 'suki' ),
	'page_header_breadcrumb_text_color'            => esc_html__( 'Breadcrumb text color', 'suki' ),
	'page_header_breadcrumb_link_text_color'       => esc_html__( 'Breadcrumb link text color', 'suki' ),
	'page_header_breadcrumb_link_hover_text_color' => esc_html__( 'Breadcrumb link text color :hover', 'suki' ),
);
foreach ( $colors as $id => $label ) {
	$wp_customize->add_setting( $id, array(
		'default'     => suki_array_value( $defaults, $id ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'color' ),
	) );
	$wp_customize->add_control( new Suki_Customize_Control_Color( $wp_customize, $id, array(
		'section'     => $section,
		'label'       => $label,
		'priority'    => 30,
	) ) );
}

/**
 * ====================================================
 * Background
 * ====================================================
 */

// Heading: Background (Global)
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_page_header_background', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Background (Global)', 'suki' ),
	'priority'    => 40,
) ) );

// Background image
$id = 'page_header_bg_image';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'image' ),
) );
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Background image', 'suki' ),
	'mime_type'   => 'image',
	'priority'    => 40,
) ) );

// Background position
$id = 'page_header_bg_position';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $id, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Background position', 'suki' ),
	'choices'     => array(
		'left top'      => esc_html__( 'Left top', 'suki' ),
		'left center'   => esc_html__( 'Left center', 'suki' ),
		'left bottom'   => esc_html__( 'Left bottom', 'suki' ),
		'center top'    => esc_html__( 'Center top', 'suki' ),
		'center center' => esc_html__( 'Center center', 'suki' ),
		'center bottom' => esc_html__( 'Center bottom', 'suki' ),
		'right top'     => esc_html__( 'Right top', 'suki' ),
		'right center'  => esc_html__( 'Right center', 'suki' ),
		'right bottom'  => esc_html__( 'Right bottom', 'suki' ),
	),
	'priority'    => 40,
) );

// Background size
$id = 'page_header_bg_size';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $id, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Background size', 'suki' ),
	'choices'     => array(
		'auto'    => esc_html__( 'Default', 'suki' ),
		'cover'   => esc_html__( 'Cover', 'suki' ),
		'contain' => esc_html__( 'Contain', 'suki' ),
	),
	'priority'    => 40,
) );

// Background repeat
$id = 'page_header_bg_repeat';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $id, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Background repeat', 'suki' ),
	'choices'     => array(
		'no-repeat' => esc_html__( 'No repeat', 'suki' ),
		'repeat-x'  => esc_html__( 'Repeat X (horizontally)', 'suki' ),
		'repeat-y'  => esc_html__( 'Repeat Y (vertically)', 'suki' ),
		'repeat'    => esc_html__( 'Repeat both axis', 'suki' ),
	),
	'priority'    => 40,
) );

// Background attachment
$id = 'page_header_bg_attachment';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $id, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Background attachment', 'suki' ),
	'choices'     => array(
		'scroll' => esc_html__( 'Scroll', 'suki' ),
		'fixed'  => esc_html__( 'Fixed', 'suki' ),
	),
	'priority'    => 40,
) );

// Background overlay
$id = 'page_header_bg_overlay_opacity'; 
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'slider' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Background color overlay opacity', 'suki' ),
	'units'       => array(
		'' => array(
			'min'  => 0,
			'max'  => 1,
			'step' => 0.05,
		),
	),
	'hide_units'  => true,
	'priority'    => 40,
) ) );