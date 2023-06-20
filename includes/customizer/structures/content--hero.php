<?php
/**
 * Customizer settings: Hero Section
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$section = 'suki_section_hero';

/**
 * ====================================================
 * Enable / Disable
 * ====================================================
 */

// Enable hero section.
$key = 'hero';
$wp_customize->add_setting(
	$key,
	array(
		'default'           => suki_array_value( $defaults, $key ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
	)
);
$wp_customize->add_control(
	new Suki_Customize_Toggle_Control(
		$wp_customize,
		$key,
		array(
			'section'     => $section,
			'label'       => esc_html__( 'Enable hero section', 'suki' ),
			'description' => esc_html__( 'Display content header in a separate section just before the content section.', 'suki' ),
			'priority'    => 10,
		)
	)
);

/**
 * ====================================================
 * Layout
 * ====================================================
 */

// Heading: Layout.
$wp_customize->add_control(
	new Suki_Customize_Heading_Control(
		$wp_customize,
		'heading_hero_layout',
		array(
			'section'  => $section,
			'settings' => array(),
			'label'    => esc_html__( 'Layout', 'suki' ),
			'priority' => 20,
		)
	)
);

// Container width.
$key = 'hero_container';
$wp_customize->add_setting(
	$key,
	array(
		'default'           => suki_array_value( $defaults, $key ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
	)
);
$wp_customize->add_control(
	new Suki_Customize_RadioImage_Control(
		$wp_customize,
		$key,
		array(
			'section'  => $section,
			'label'    => esc_html__( 'Container width', 'suki' ),
			'choices'  => array(
				'inherit' => array(
					'label' => esc_html__( 'Same with Content section', 'suki' ),
				),
				'narrow'  => array(
					'label' => esc_html__( 'Narrow', 'suki' ),
				),
				'wide'    => array(
					'label' => esc_html__( 'Wide', 'suki' ),
				),
				'full'    => array(
					'label' => esc_html__( 'Full', 'suki' ),
				),
			),
			'priority' => 20,
		)
	)
);

// Minimal height.
$key      = 'hero_height';
$settings = array(
	$key,
	$key . '__tablet',
	$key . '__mobile',
);
foreach ( $settings as $setting ) {
	$wp_customize->add_setting(
		$setting,
		array(
			'default'           => suki_array_value( $defaults, $setting ),
			'transport'         => 'postMessage',
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimension' ),
		)
	);
}
$wp_customize->add_control(
	new Suki_Customize_Dimension_Control(
		$wp_customize,
		$key,
		array(
			'settings' => $settings,
			'section'  => $section,
			'label'    => esc_html__( 'Minimal height', 'suki' ),
			'units'    => array(
				'px'  => array(
					'min'  => 0,
					'step' => 1,
				),
				'em'  => array(
					'min'  => 0,
					'step' => 0.01,
				),
				'rem' => array(
					'min'  => 0,
					'step' => 0.01,
				),
				'vh'  => array(
					'min'  => 0,
					'step' => 0.01,
				),
			),
			'priority' => 20,
		)
	)
);

// Padding.
$key      = 'hero_padding';
$settings = array(
	$key,
	$key . '__tablet',
	$key . '__mobile',
);
foreach ( $settings as $setting ) {
	$wp_customize->add_setting(
		$setting,
		array(
			'default'           => suki_array_value( $defaults, $setting ),
			'transport'         => 'postMessage',
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimensions' ),
		)
	);
}
$wp_customize->add_control(
	new Suki_Customize_Dimensions_Control(
		$wp_customize,
		$key,
		array(
			'settings' => $settings,
			'section'  => $section,
			'label'    => esc_html__( 'Padding', 'suki' ),
			'units'    => array(
				'px'  => array(
					'min'  => 0,
					'step' => 1,
				),
				'em'  => array(
					'min'  => 0,
					'step' => 0.01,
				),
				'rem' => array(
					'min'  => 0,
					'step' => 0.01,
				),
				'%'   => array(
					'min'  => 0,
					'step' => 0.01,
				),
			),
			'priority' => 20,
		)
	)
);

// Border.
$key = 'hero_border';
$wp_customize->add_setting(
	$key,
	array(
		'default'           => suki_array_value( $defaults, $key ),
		'transport'         => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimensions' ),
	)
);
$wp_customize->add_control(
	new Suki_Customize_Dimensions_Control(
		$wp_customize,
		$key,
		array(
			'section'  => $section,
			'label'    => esc_html__( 'Border', 'suki' ),
			'units'    => array(
				'px'  => array(
					'min'  => 0,
					'step' => 1,
				),
				'em'  => array(
					'min'  => 0,
					'step' => 0.01,
				),
				'rem' => array(
					'min'  => 0,
					'step' => 0.01,
				),
			),
			'priority' => 20,
		)
	)
);

/**
 * ====================================================
 * Typography
 * ====================================================
 */

// Heading: Typography.
$wp_customize->add_control(
	new Suki_Customize_Heading_Control(
		$wp_customize,
		'heading_hero_typography',
		array(
			'section'  => $section,
			'settings' => array(),
			'label'    => esc_html__( 'Typography', 'suki' ),
			'priority' => 40,
		)
	)
);

// Text typography.
$settings = array(
	'font_family'            => 'hero_font_family',
	'font_weight'            => 'hero_font_weight',
	'font_style'             => 'hero_font_style',
	'text_transform'         => 'hero_text_transform',
	'font_size'              => 'hero_font_size',
	'line_height'            => 'hero_line_height',
	'letter_spacing'         => 'hero_letter_spacing',

	'font_size__tablet'      => 'hero_font_size__tablet',
	'line_height__tablet'    => 'hero_line_height__tablet',
	'letter_spacing__tablet' => 'hero_letter_spacing__tablet',

	'font_size__mobile'      => 'hero_font_size__mobile',
	'line_height__mobile'    => 'hero_line_height__mobile',
	'letter_spacing__mobile' => 'hero_letter_spacing__mobile',
);
foreach ( $settings as $key ) {
	$wp_customize->add_setting(
		$key,
		array(
			'default'           => suki_array_value( $defaults, $key ),
			'transport'         => 'postMessage',
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'typography' ),
		)
	);
}
$wp_customize->add_control(
	new Suki_Customize_Typography_Control(
		$wp_customize,
		'hero_typography',
		array(
			'settings' => $settings,
			'section'  => $section,
			'label'    => esc_html__( 'Text typography', 'suki' ),
			'priority' => 40,
		)
	)
);

// Title typography.
$settings = array(
	'font_family'            => 'hero_title_font_family',
	'font_weight'            => 'hero_title_font_weight',
	'font_style'             => 'hero_title_font_style',
	'text_transform'         => 'hero_title_text_transform',
	'font_size'              => 'hero_title_font_size',
	'line_height'            => 'hero_title_line_height',
	'letter_spacing'         => 'hero_title_letter_spacing',

	'font_size__tablet'      => 'hero_title_font_size__tablet',
	'line_height__tablet'    => 'hero_title_line_height__tablet',
	'letter_spacing__tablet' => 'hero_title_letter_spacing__tablet',

	'font_size__mobile'      => 'hero_title_font_size__mobile',
	'line_height__mobile'    => 'hero_title_line_height__mobile',
	'letter_spacing__mobile' => 'hero_title_letter_spacing__mobile',
);
foreach ( $settings as $key ) {
	$wp_customize->add_setting(
		$key,
		array(
			'default'           => suki_array_value( $defaults, $key ),
			'transport'         => 'postMessage',
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'typography' ),
		)
	);
}
$wp_customize->add_control(
	new Suki_Customize_Typography_Control(
		$wp_customize,
		'hero_title_typography',
		array(
			'settings' => $settings,
			'section'  => $section,
			'label'    => esc_html__( 'Title typography', 'suki' ),
			'priority' => 40,
		)
	)
);

// Breadcrumb typography.
$settings = array(
	'font_family'            => 'hero_breadcrumb_font_family',
	'font_weight'            => 'hero_breadcrumb_font_weight',
	'font_style'             => 'hero_breadcrumb_font_style',
	'text_transform'         => 'hero_breadcrumb_text_transform',
	'font_size'              => 'hero_breadcrumb_font_size',
	'line_height'            => 'hero_breadcrumb_line_height',
	'letter_spacing'         => 'hero_breadcrumb_letter_spacing',

	'font_size__tablet'      => 'hero_breadcrumb_font_size__tablet',
	'line_height__tablet'    => 'hero_breadcrumb_line_height__tablet',
	'letter_spacing__tablet' => 'hero_breadcrumb_letter_spacing__tablet',

	'font_size__mobile'      => 'hero_breadcrumb_font_size__mobile',
	'line_height__mobile'    => 'hero_breadcrumb_line_height__mobile',
	'letter_spacing__mobile' => 'hero_breadcrumb_letter_spacing__mobile',
);
foreach ( $settings as $key ) {
	$wp_customize->add_setting(
		$key,
		array(
			'default'           => suki_array_value( $defaults, $key ),
			'transport'         => 'postMessage',
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'typography' ),
		)
	);
}
$wp_customize->add_control(
	new Suki_Customize_Typography_Control(
		$wp_customize,
		'hero_breadcrumb_typography',
		array(
			'settings' => $settings,
			'section'  => $section,
			'label'    => esc_html__( 'Breadcrumb typography', 'suki' ),
			'priority' => 40,
		)
	)
);

/**
 * ====================================================
 * Colors
 * ====================================================
 */

// Heading: Colors.
$wp_customize->add_control(
	new Suki_Customize_Heading_Control(
		$wp_customize,
		'heading_hero_colors',
		array(
			'section'  => $section,
			'settings' => array(),
			'label'    => esc_html__( 'Colors', 'suki' ),
			'priority' => 50,
		)
	)
);

// Colors.
$colors = array(
	'hero_border_color'                     => esc_html__( 'Border color', 'suki' ),
	'hero_text_color'                       => esc_html__( 'Text color', 'suki' ),
	'hero_link_text_color'                  => esc_html__( 'Link text color', 'suki' ),
	'hero_link_hover_text_color'            => esc_html__( 'Link text color :hover', 'suki' ),
	'hero_title_text_color'                 => esc_html__( 'Title text color', 'suki' ),
	'hero_breadcrumb_text_color'            => esc_html__( 'Breadcrumb text color', 'suki' ),
	'hero_breadcrumb_link_text_color'       => esc_html__( 'Breadcrumb link text color', 'suki' ),
	'hero_breadcrumb_link_hover_text_color' => esc_html__( 'Breadcrumb link text color :hover', 'suki' ),
);
foreach ( $colors as $key => $label ) {
	$wp_customize->add_setting(
		$key,
		array(
			'default'           => suki_array_value( $defaults, $key ),
			'transport'         => 'postMessage',
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'color' ),
		)
	);
	$wp_customize->add_control(
		new Suki_Customize_Color_Select_Control(
			$wp_customize,
			$key,
			array(
				'section'  => $section,
				'label'    => $label,
				'priority' => 50,
			)
		)
	);
}

/**
 * ====================================================
 * Background
 * ====================================================
 */

// Heading: Background.
$wp_customize->add_control(
	new Suki_Customize_Heading_Control(
		$wp_customize,
		'heading_hero_bg',
		array(
			'section'  => $section,
			'settings' => array(),
			'label'    => esc_html__( 'Background', 'suki' ),
			'priority' => 60,
		)
	)
);

// Background image.
$key = 'hero_bg_image';
$wp_customize->add_setting(
	$key,
	array(
		'default'           => suki_array_value( $defaults, $key ),
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	new WP_Customize_Media_Control(
		$wp_customize,
		$key,
		array(
			'section'   => $section,
			'label'     => esc_html__( 'Background image', 'suki' ),
			'mime_type' => 'image',
			'priority'  => 60,
		)
	)
);

// Fixed background.
$key = 'hero_bg_parallax';
$wp_customize->add_setting(
	$key,
	array(
		'default'           => suki_array_value( $defaults, $key ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
	)
);
$wp_customize->add_control(
	new Suki_Customize_Toggle_Control(
		$wp_customize,
		$key,
		array(
			'section'  => $section,
			'label'    => esc_html__( 'Fixed background', 'suki' ),
			'priority' => 60,
		)
	)
);

// Repeat background.
$key = 'hero_bg_repeat';
$wp_customize->add_setting(
	$key,
	array(
		'default'           => suki_array_value( $defaults, $key ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
	)
);
$wp_customize->add_control(
	new Suki_Customize_Toggle_Control(
		$wp_customize,
		$key,
		array(
			'section'  => $section,
			'label'    => esc_html__( 'Repeat background', 'suki' ),
			'priority' => 60,
		)
	)
);

// ------
$wp_customize->add_control(
	new Suki_Customize_HR_Control(
		$wp_customize,
		'hr_hero_bg_color',
		array(
			'section'  => $section,
			'settings' => array(),
			'priority' => 60,
		)
	)
);

// Background color.
$key = 'hero_bg_color';
$wp_customize->add_setting(
	$key,
	array(
		'default'           => suki_array_value( $defaults, $key ),
		'transport'         => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'color' ),
	)
);
$wp_customize->add_control(
	new Suki_Customize_Color_Select_Control(
		$wp_customize,
		$key,
		array(
			'section'     => $section,
			'label'       => esc_html__( 'Background / Overlay color', 'suki' ),
			'description' => esc_html__( 'When background image is specified, this color will be used as overlay color.', 'suki' ),
			'priority'    => 60,
		)
	)
);

// Overlay Opacity.
$key = 'hero_bg_color_overlay_dim';
$wp_customize->add_setting(
	$key,
	array(
		'default'           => suki_array_value( $defaults, $key ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'number' ),
	)
);
$wp_customize->add_control(
	new Suki_Customize_Slider_Control(
		$wp_customize,
		$key,
		array(
			'section'  => $section,
			'label'    => esc_html__( 'Overlay Opacity', 'suki' ),
			'min'      => 0,
			'max'      => 100,
			'step'     => 10,
			'priority' => 60,
		)
	)
);
