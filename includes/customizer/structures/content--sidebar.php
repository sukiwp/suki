<?php
/**
 * Customizer settings: Global Layout > Sidebar Area
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$section = 'suki_section_sidebar';

/**
 * ====================================================
 * Layout
 * ====================================================
 */

// Heading: Layout.
$wp_customize->add_control(
	new Suki_Customize_Heading_Control(
		$wp_customize,
		'heading_sidebar_layout',
		array(
			'section'  => $section,
			'settings' => array(),
			'label'    => esc_html__( 'Layout', 'suki' ),
			'priority' => 10,
		)
	)
);

// Sidebar width.
$key = 'sidebar_width';
$wp_customize->add_setting(
	$key,
	array(
		'default'           => suki_array_value( $defaults, $key ),
		'transport'         => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimension' ),
	)
);
$wp_customize->add_control(
	new Suki_Customize_Dimension_Control(
		$wp_customize,
		$key,
		array(
			'section'  => $section,
			'label'    => esc_html__( 'Width', 'suki' ),
			'units'    => array(
				'px'  => array(
					'min'  => 150,
					'step' => 1,
				),
				'em'  => array(
					'min'  => 10,
					'step' => 0.01,
				),
				'rem' => array(
					'min'  => 0,
					'step' => 0.01,
				),
				'%'   => array(
					'min'  => 10,
					'step' => 0.01,
				),
			),
			'priority' => 10,
		)
	)
);

// Sidebar gap.
$key = 'sidebar_gap';
$wp_customize->add_setting(
	$key,
	array(
		'default'           => suki_array_value( $defaults, $key ),
		'transport'         => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimension' ),
	)
);
$wp_customize->add_control(
	new Suki_Customize_Dimension_Control(
		$wp_customize,
		$key,
		array(
			'section'  => $section,
			'label'    => esc_html__( 'Gap with main content', 'suki' ),
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
			'priority' => 10,
		)
	)
);

/**
 * ====================================================
 * Widgets
 * ====================================================
 */

// Heading: Widgets.
$wp_customize->add_control(
	new Suki_Customize_Heading_Control(
		$wp_customize,
		'heading_sidebar_widgets',
		array(
			'section'  => $section,
			'settings' => array(),
			'label'    => esc_html__( 'Widgets', 'suki' ),
			'priority' => 30,
		)
	)
);

// Widgets style.
$key = 'sidebar_widgets_mode';
$wp_customize->add_setting(
	$key,
	array(
		'default'           => suki_array_value( $defaults, $key ),
		'transport'         => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
	)
);
$wp_customize->add_control(
	$key,
	array(
		'type'     => 'select',
		'section'  => $section,
		'label'    => esc_html__( 'Widgets style', 'suki' ),
		'choices'  => array(
			'merged'    => esc_html__( 'Merged in one box', 'suki' ),
			'separated' => esc_html__( 'Separate boxes', 'suki' ),
		),
		'priority' => 30,
	)
);

// Gap between widgets.
$key = 'sidebar_widgets_gap';
$wp_customize->add_setting(
	$key,
	array(
		'default'           => suki_array_value( $defaults, $key ),
		'transport'         => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimension' ),
	)
);
$wp_customize->add_control(
	new Suki_Customize_Dimension_Control(
		$wp_customize,
		$key,
		array(
			'section'  => $section,
			'label'    => esc_html__( 'Gap between widgets', 'suki' ),
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
			'priority' => 30,
		)
	)
);

// Padding.
$key      = 'sidebar_padding';
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
			'priority' => 30,
		)
	)
);

// Border.
$key = 'sidebar_border';
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
			'priority' => 30,
		)
	)
);

// Border radius.
$key = 'sidebar_border_radius';
$wp_customize->add_setting(
	$key,
	array(
		'default'           => suki_array_value( $defaults, $key ),
		'transport'         => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimension' ),
	)
);
$wp_customize->add_control(
	new Suki_Customize_Dimension_Control(
		$wp_customize,
		$key,
		array(
			'section'  => $section,
			'label'    => esc_html__( 'Border radius', 'suki' ),
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
			'priority' => 30,
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
		'heading_sidebar_typography',
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
	'font_family'            => 'sidebar_font_family',
	'font_weight'            => 'sidebar_font_weight',
	'font_style'             => 'sidebar_font_style',
	'text_transform'         => 'sidebar_text_transform',
	'font_size'              => 'sidebar_font_size',
	'line_height'            => 'sidebar_line_height',
	'letter_spacing'         => 'sidebar_letter_spacing',

	'font_size__tablet'      => 'sidebar_font_size__tablet',
	'line_height__tablet'    => 'sidebar_line_height__tablet',
	'letter_spacing__tablet' => 'sidebar_letter_spacing__tablet',

	'font_size__mobile'      => 'sidebar_font_size__mobile',
	'line_height__mobile'    => 'sidebar_line_height__mobile',
	'letter_spacing__mobile' => 'sidebar_letter_spacing__mobile',
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
		'sidebar_typography',
		array(
			'settings' => $settings,
			'section'  => $section,
			'label'    => esc_html__( 'Text typography', 'suki' ),
			'priority' => 40,
		)
	)
);

// Info.
$wp_customize->add_control(
	new Suki_Customize_Notice_Control(
		$wp_customize,
		'notice_sidebar_widget_title',
		array(
			'section'     => $section,
			'settings'    => array(),
			'description' => esc_html__( 'Looking for widget title configuration? Using the Block-based Widgets editor, you can add and configure a Heading block as a widget title.', 'suki' ),
			'priority'    => 40,
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
		'heading_sidebar_colors',
		array(
			'section'  => $section,
			'settings' => array(),
			'label'    => esc_html__( 'Colors', 'suki' ),
			'priority' => 50,
		)
	)
);

// Shadow.
$key = 'sidebar_shadow';
$wp_customize->add_setting(
	$key,
	array(
		'default'           => suki_array_value( $defaults, $key ),
		'transport'         => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'shadow' ),
	)
);
$wp_customize->add_control(
	new Suki_Customize_Shadow_Control(
		$wp_customize,
		$key,
		array(
			'section'  => $section,
			'label'    => esc_html__( 'Shadow', 'suki' ),
			'exclude'  => array( 'position' ),
			'priority' => 50,
		)
	)
);

// Colors.
$colors = array(
	'sidebar_bg_color'              => esc_html__( 'Background color', 'suki' ),
	'sidebar_border_color'          => esc_html__( 'Border color', 'suki' ),
	'sidebar_text_color'            => esc_html__( 'Text color', 'suki' ),
	'sidebar_link_text_color'       => esc_html__( 'Link text color', 'suki' ),
	'sidebar_link_hover_text_color' => esc_html__( 'Link text color :hover', 'suki' ),
);
foreach ( $colors as $key => $label ) {
	$wp_customize->add_setting(
		$key,
		array(
			'default'           => suki_array_value( $defaults, $key ),
			'transport'         => 'postMessage',
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'text' ),
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
