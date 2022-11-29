<?php
/**
 * Customizer settings: Footer > Bottom Bar
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$section = 'suki_section_footer_bottom_bar';

/**
 * ====================================================
 * Layout
 * ====================================================
 */

// Merge inside Main Bar.
$key = 'footer_bottom_bar_merged';
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
			'label'    => esc_html__( 'Merge inside Widgets Bar wrapper', 'suki' ),
			'priority' => 10,
		)
	)
);

// Merged gap.
$key = 'footer_bottom_bar_merged_gap';
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
			'label'    => esc_html__( 'Gap with Widgets Bar content', 'suki' ),
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

// ------
$wp_customize->add_control(
	new Suki_Customize_HR_Control(
		$wp_customize,
		'hr_footer_bottom_bar_merged',
		array(
			'section'  => $section,
			'settings' => array(),
			'priority' => 10,
		)
	)
);

// Layout.
$key = 'footer_bottom_bar_container';
$wp_customize->add_setting(
	$key,
	array(
		'default'           => suki_array_value( $defaults, $key ),
		'transport'         => 'postMessage',
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
	)
);
$wp_customize->add_control(
	new Suki_Customize_RadioImage_Control(
		$wp_customize,
		$key,
		array(
			'section'  => $section,
			'label'    => esc_html__( 'Layout', 'suki' ),
			'choices'  => array(
				'narrow' => array(
					'label' => esc_html__( 'Narrow', 'suki' ),
				),
				'wide'   => array(
					'label' => esc_html__( 'Wide', 'suki' ),
				),
				'full'   => array(
					'label' => esc_html__( 'Full', 'suki' ),
				),
			),
			'priority' => 10,
		)
	)
);

// Padding.
$key      = 'footer_bottom_bar_padding';
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
			'priority' => 10,
		)
	)
);

// Border.
$key = 'footer_bottom_bar_border';
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
			'priority' => 10,
		)
	)
);

// Items gap.
$key = 'footer_bottom_bar_items_gap';
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
			'label'    => esc_html__( 'Spacing between elements', 'suki' ),
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
 * Typography
 * ====================================================
 */

// Heading: Typography.
$wp_customize->add_control(
	new Suki_Customize_Heading_Control(
		$wp_customize,
		'heading_footer_bottom_bar_typography',
		array(
			'section'  => $section,
			'settings' => array(),
			'label'    => esc_html__( 'Typography', 'suki' ),
			'priority' => 20,
		)
	)
);

// Text typography.
$settings = array(
	'font_family'            => 'footer_bottom_bar_font_family',
	'font_weight'            => 'footer_bottom_bar_font_weight',
	'font_style'             => 'footer_bottom_bar_font_style',
	'text_transform'         => 'footer_bottom_bar_text_transform',
	'font_size'              => 'footer_bottom_bar_font_size',
	'line_height'            => 'footer_bottom_bar_line_height',
	'letter_spacing'         => 'footer_bottom_bar_letter_spacing',

	'font_size__tablet'      => 'footer_bottom_bar_font_size__tablet',
	'line_height__tablet'    => 'footer_bottom_bar_line_height__tablet',
	'letter_spacing__tablet' => 'footer_bottom_bar_letter_spacing__tablet',

	'font_size__mobile'      => 'footer_bottom_bar_font_size__mobile',
	'line_height__mobile'    => 'footer_bottom_bar_line_height__mobile',
	'letter_spacing__mobile' => 'footer_bottom_bar_letter_spacing__mobile',
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
		'footer_bottom_bar_typography',
		array(
			'settings' => $settings,
			'section'  => $section,
			'label'    => esc_html__( 'Text typography', 'suki' ),
			'priority' => 20,
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
		'heading_footer_bottom_bar_colors',
		array(
			'section'  => $section,
			'settings' => array(),
			'label'    => esc_html__( 'Colors', 'suki' ),
			'priority' => 30,
		)
	)
);

// Colors.
$colors = array(
	'footer_bottom_bar_bg_color'              => esc_html__( 'Background color', 'suki' ),
	'footer_bottom_bar_border_color'          => esc_html__( 'Border color', 'suki' ),
	'footer_bottom_bar_text_color'            => esc_html__( 'Text color', 'suki' ),
	'footer_bottom_bar_link_text_color'       => esc_html__( 'Link text color', 'suki' ),
	'footer_bottom_bar_link_hover_text_color' => esc_html__( 'Link text color :hover', 'suki' ),
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
				'priority' => 30,
			)
		)
	);
}
