<?php
/**
 * Customizer settings: Blog > Post Layout: Grid
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$section = 'suki_section_entry_grid';

/**
 * ====================================================
 * Layout
 * ====================================================
 */

// Grid columns.
$key = 'blog_index_grid_columns';
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
			'label'    => esc_html__( 'Columns', 'suki' ),
			'min'      => 2,
			'max'      => 4,
			'step'     => 1,
			'priority' => 10,
		)
	)
);

// Rows gap.
$key = 'blog_index_grid_rows_gap';
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
			'label'    => esc_html__( 'Rows gap', 'suki' ),
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

// Columns gap.
$key = 'blog_index_grid_columns_gap';
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
			'label'    => esc_html__( 'Columns gap', 'suki' ),
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
 * Entry Wrapper
 * ====================================================
 */

// Heading: Entry Wrapper.
$wp_customize->add_control(
	new Suki_Customize_Heading_Control(
		$wp_customize,
		'heading_entry_grid_item',
		array(
			'section'  => $section,
			'settings' => array(),
			'label'    => esc_html__( 'Entry Wrapper', 'suki' ),
			'priority' => 20,
		)
	)
);

// Padding.
$key      = 'entry_grid_padding';
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
$key = 'entry_grid_border';
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

// Border radius.
$key = 'entry_grid_border_radius';
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
			'priority' => 20,
		)
	)
);

// Make items in a row to be in same height.
$key = 'entry_grid_same_height';
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
			'label'    => esc_html__( 'Same height items in a row', 'suki' ),
			'priority' => 20,
		)
	)
);

/**
 * ====================================================
 * Entry Header
 * ====================================================
 */

// Heading: Entry Header.
$wp_customize->add_control(
	new Suki_Customize_Heading_Control(
		$wp_customize,
		'heading_entry_grid_header',
		array(
			'section'  => $section,
			'settings' => array(),
			'label'    => esc_html__( 'Entry Header', 'suki' ),
			'priority' => 30,
		)
	)
);

// Elements.
$key = 'entry_grid_header';
$wp_customize->add_setting(
	$key,
	array(
		'default'           => suki_array_value( $defaults, $key ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'multiselect' ),
	)
);
$wp_customize->add_control(
	new Suki_Customize_MultiSelect_Control(
		$wp_customize,
		$key,
		array(
			'section'     => $section,
			'label'       => esc_html__( 'Elements', 'suki' ),
			'choices'     => apply_filters(
				'suki/dataset/entry_grid_header_elements',
				array(
					'header-meta' => esc_html__( 'Header Meta', 'suki' ),
					'title'       => esc_html__( 'Title', 'suki' ),
				)
			),
			'is_sortable' => true,
			'priority'    => 30,
		)
	)
);

// Alignment.
$key = 'entry_grid_header_alignment';
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
			'label'    => esc_html__( 'Alignment', 'suki' ),
			'choices'  => array(
				'left'   => array(
					'label' => esc_html__( 'Left', 'suki' ),
				),
				'center' => array(
					'label' => esc_html__( 'Center', 'suki' ),
				),
				'right'  => array(
					'label' => esc_html__( 'Right', 'suki' ),
				),
			),
			'priority' => 30,
		)
	)
);

// Header meta text.
$key = 'entry_grid_header_meta';
$wp_customize->add_setting(
	$key,
	array(
		'default'           => suki_array_value( $defaults, $key ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'text' ),
	)
);
$wp_customize->add_control(
	$key,
	array(
		'section'     => $section,
		'label'       => esc_html__( 'Header meta text', 'suki' ),
		'description' => esc_html__( 'Available tags: {{date}}, {{categories}}, {{tags}}, {{author}}, {{avatar}}, {{comments}}.', 'suki' ),
		'priority'    => 30,
	)
);

/**
 * ====================================================
 * Entry Thumbnail
 * ====================================================
 */

// Heading: Entry Thumbnail.
$wp_customize->add_control(
	new Suki_Customize_Heading_Control(
		$wp_customize,
		'heading_entry_grid_thumbnail',
		array(
			'section'  => $section,
			'settings' => array(),
			'label'    => esc_html__( 'Entry Thumbnail', 'suki' ),
			'priority' => 40,
		)
	)
);

// Display.
$key = 'entry_grid_thumbnail_position';
$wp_customize->add_setting(
	$key,
	array(
		'default'           => suki_array_value( $defaults, $key ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
	)
);
$wp_customize->add_control(
	$key,
	array(
		'type'     => 'select',
		'section'  => $section,
		'label'    => esc_html__( 'Display', 'suki' ),
		'choices'  => array(
			''       => esc_html__( 'Disabled', 'suki' ),
			'before' => esc_html__( 'Before Content Header', 'suki' ),
			'after'  => esc_html__( 'After Content Header', 'suki' ),
		),
		'priority' => 40,
	)
);

// Image size.
$key = 'entry_grid_thumbnail_size';
$wp_customize->add_setting(
	$key,
	array(
		'default'           => suki_array_value( $defaults, $key ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
	)
);
$wp_customize->add_control(
	$key,
	array(
		'type'     => 'select',
		'section'  => $section,
		'label'    => esc_html__( 'Image size', 'suki' ),
		'choices'  => suki_get_all_image_sizes(),
		'priority' => 40,
	)
);

// Ignore padding.
$key = 'entry_grid_thumbnail_ignore_padding';
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
			'label'    => esc_html__( 'Ignore padding', 'suki' ),
			'priority' => 40,
		)
	)
);

/**
 * ====================================================
 * Entry Content
 * ====================================================
 */

// Heading: Entry Content.
$wp_customize->add_control(
	new Suki_Customize_Heading_Control(
		$wp_customize,
		'heading_entry_grid_content',
		array(
			'section'  => $section,
			'settings' => array(),
			'label'    => esc_html__( 'Entry Content', 'suki' ),
			'priority' => 50,
		)
	)
);

// Entry grid excerpt length.
$key = 'entry_grid_excerpt_length';
$wp_customize->add_setting(
	$key,
	array(
		'default'           => suki_array_value( $defaults, $key ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimension' ),
	)
);
$wp_customize->add_control(
	new Suki_Customize_Dimension_Control(
		$wp_customize,
		$key,
		array(
			'section'     => $section,
			'label'       => esc_html__( 'Excerpt words limit', 'suki' ),
			'description' => esc_html__( 'Fill with 0 to disable excerpt.', 'suki' ),
			'units'       => array(
				'' => array(
					'min'   => 0,
					'step'  => 1,
					'label' => 'wrd',
				),
			),
			'priority'    => 50,
		)
	)
);

// Read more.
$key = 'entry_grid_read_more_display';
$wp_customize->add_setting(
	$key,
	array(
		'default'           => suki_array_value( $defaults, $key ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
	)
);
$wp_customize->add_control(
	$key,
	array(
		'type'     => 'select',
		'section'  => $section,
		'label'    => esc_html__( 'Read more', 'suki' ),
		'choices'  => array(
			''       => esc_html__( 'None', 'suki' ),
			'text'   => esc_html__( 'Text', 'suki' ),
			'button' => esc_html__( 'Button', 'suki' ),
		),
		'priority' => 50,
	)
);

// Read more text.
$key = 'entry_grid_read_more_text';
$wp_customize->add_setting(
	$key,
	array(
		'default'           => suki_array_value( $defaults, $key ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'text' ),
	)
);
$wp_customize->add_control(
	$key,
	array(
		'section'     => $section,
		'label'       => esc_html__( 'Read more text', 'suki' ),
		'input_attrs' => array(
			'placeholder' => esc_html__( 'Read more', 'suki' ),
		),
		'priority'    => 50,
	)
);

/**
 * ====================================================
 * Entry Footer
 * ====================================================
 */

// Heading: Entry Footer.
$wp_customize->add_control(
	new Suki_Customize_Heading_Control(
		$wp_customize,
		'heading_entry_grid_meta',
		array(
			'section'  => $section,
			'settings' => array(),
			'label'    => esc_html__( 'Entry Footer', 'suki' ),
			'priority' => 60,
		)
	)
);

// Elements.
$key = 'entry_grid_footer';
$wp_customize->add_setting(
	$key,
	array(
		'default'           => suki_array_value( $defaults, $key ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'multiselect' ),
	)
);
$wp_customize->add_control(
	new Suki_Customize_MultiSelect_Control(
		$wp_customize,
		$key,
		array(
			'section'     => $section,
			'label'       => esc_html__( 'Elements', 'suki' ),
			'choices'     => apply_filters(
				'suki/dataset/entry_grid_footer_elements',
				array(
					'hr'          => '⎯⎯⎯⎯⎯',
					'footer-meta' => esc_html__( 'Footer Meta', 'suki' ),
				)
			),
			'is_sortable' => true,
			'priority'    => 60,
		)
	)
);

// Alignment.
$key = 'entry_grid_footer_alignment';
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
			'label'    => esc_html__( 'Alignment', 'suki' ),
			'choices'  => array(
				'left'   => array(
					'label' => esc_html__( 'Left', 'suki' ),
				),
				'center' => array(
					'label' => esc_html__( 'Center', 'suki' ),
				),
				'right'  => array(
					'label' => esc_html__( 'Right', 'suki' ),
				),
			),
			'priority' => 60,
		)
	)
);

// Footer meta text.
$key = 'entry_grid_footer_meta';
$wp_customize->add_setting(
	$key,
	array(
		'default'           => suki_array_value( $defaults, $key ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'text' ),
	)
);
$wp_customize->add_control(
	$key,
	array(
		'section'     => $section,
		'label'       => esc_html__( 'Footer meta text', 'suki' ),
		'description' => esc_html__( 'Available tags: {{date}}, {{categories}}, {{tags}}, {{author}}, {{avatar}}, {{comments}}', 'suki' ),
		'priority'    => 60,
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
		'heading_entry_grid_colors',
		array(
			'section'  => $section,
			'settings' => array(),
			'label'    => esc_html__( 'Colors', 'suki' ),
			'priority' => 80,
		)
	)
);

// Colors.
$colors = array(
	'entry_grid_bg_color'     => esc_html__( 'Background color', 'suki' ),
	'entry_grid_border_color' => esc_html__( 'Border color', 'suki' ),
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
				'priority' => 80,
			)
		)
	);
}

// Shadow.
$key = 'entry_grid_shadow';
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
			'props'    => array( 'h_offset', 'v_offset', 'blur', 'spread', 'color' ),
			'priority' => 80,
		)
	)
);
