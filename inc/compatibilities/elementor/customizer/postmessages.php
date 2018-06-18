<?php
/**
 * Customizer & Front-End modification rules for WooCommerce.
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$add = array();

/**
 * ====================================================
 * General Elements > Title
 * ====================================================
 */

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$element = '.elementor-size-suki-title';
	$property = str_replace( '_', '-', $prop );

	$add['title_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element,
			'property' => $property,
		),
	);
	if ( in_array( $prop, array( 'font_size', 'line_height', 'letter_spacing' ) ) ) {
		$add['title_' . $prop . '__tablet'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 767px)',
			),
		);
		$add['title_' . $prop . '__mobile'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 499px)',
			),
		);
	}
}
$add['title_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.elementor-size-suki-title',
		'property' => 'color',
	),
);
$add['title_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.elementor-size-suki-title a:hover, .elementor-size-suki-title a:focus',
		'property' => 'color',
	),
);

/**
 * ====================================================
 * General Elements > Small Title
 * ====================================================
 */

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$element = '.elementor-size-suki-small-title';
	$property = str_replace( '_', '-', $prop );

	$add['small_title_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element,
			'property' => $property,
		),
	);
	if ( in_array( $prop, array( 'font_size', 'line_height', 'letter_spacing' ) ) ) {
		$add['small_title_' . $prop . '__tablet'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 767px)',
			),
		);
		$add['small_title_' . $prop . '__mobile'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 499px)',
			),
		);
	}
}
$add['small_title_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.elementor-size-suki-small-title, .elementor-size-suki-small-title a',
		'property' => 'color',
	),
);
$add['small_title_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.elementor-size-suki-small-title a:hover, .elementor-size-suki-small-title a:focus',
		'property' => 'color',
	),
);

/**
 * ====================================================
 * General Elements > Meta
 * ====================================================
 */

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$element = '.elementor-size-suki-meta';
	$property = str_replace( '_', '-', $prop );

	$add['meta_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element,
			'property' => $property,
		),
	);
	if ( in_array( $prop, array( 'font_size', 'line_height', 'letter_spacing' ) ) ) {
		$add['meta_' . $prop . '__tablet'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 767px)',
			),
		);
		$add['meta_' . $prop . '__mobile'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 499px)',
			),
		);
	}
}
$add['meta_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.elementor-size-suki-meta, .elementor-size-suki-meta a',
		'property' => 'color',
	),
);
$add['meta_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.elementor-size-suki-meta a:hover, .elementor-size-suki-meta a:focus',
		'property' => 'color',
	),
);

/**
 * ====================================================
 * General Elements > Buttons
 * ====================================================
 */

$add['button_padding'] = array(
	array(
		'type'     => 'css',
		'element'  => '.elementor-button, .elementor-button.elementor-size-sm',
		'property' => 'padding',
	),
	array(
		'type'     => 'css',
		'element'  => '.elementor-button.elementor-size-xs',
		'property' => 'padding',
		'function' => array(
			'name' => 'scale_dimensions',
			'args' => array( 0.9 ),
		),
	),
	array(
		'type'     => 'css',
		'element'  => '.elementor-button.elementor-size-md',
		'property' => 'padding',
		'function' => array(
			'name' => 'scale_dimensions',
			'args' => array( 1.1 ),
		),
	),
	array(
		'type'     => 'css',
		'element'  => '.elementor-button.elementor-size-lg',
		'property' => 'padding',
		'function' => array(
			'name' => 'scale_dimensions',
			'args' => array( 1.2 ),
		),
	),
	array(
		'type'     => 'css',
		'element'  => '.elementor-button.elementor-size-xl',
		'property' => 'padding',
		'function' => array(
			'name' => 'scale_dimensions',
			'args' => array( 1.3 ),
		),
	),
);

$add['button_border'] = array(
	array(
		'type'     => 'css',
		'element'  => '.elementor-button',
		'property' => 'border-width',
	),
);

$add['button_border_radius'] = array(
	array(
		'type'     => 'css',
		'element'  => '.elementor-button, .elementor-button.elementor-size-sm',
		'property' => 'border-radius',
	),
	array(
		'type'     => 'css',
		'element'  => '.elementor-button.elementor-size-xs',
		'property' => 'border-radius',
		'function' => array(
			'name' => 'scale_dimensions',
			'args' => array( 0.9 ),
		),
	),
	array(
		'type'     => 'css',
		'element'  => '.elementor-button.elementor-size-md',
		'property' => 'border-radius',
		'function' => array(
			'name' => 'scale_dimensions',
			'args' => array( 1.1 ),
		),
	),
	array(
		'type'     => 'css',
		'element'  => '.elementor-button.elementor-size-lg',
		'property' => 'border-radius',
		'function' => array(
			'name' => 'scale_dimensions',
			'args' => array( 1.2 ),
		),
	),
	array(
		'type'     => 'css',
		'element'  => '.elementor-button.elementor-size-xl',
		'property' => 'border-radius',
		'function' => array(
			'name' => 'scale_dimensions',
			'args' => array( 1.3 ),
		),
	),
);
foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'letter_spacing' ) as $prop ) {
	$property = str_replace( '_', '-', $prop );
	$array = array();

	$array[] = array(
		'type'     => 'font_family' === $prop ? 'font' : 'css',
		'element'  => '.elementor-button, .elementor-button.elementor-size-sm',
		'property' => $property,
	);

	// XS button
	if ( in_array( $prop, array( 'font_size', 'letter_spacing' ) ) ) {
		$array[] = array(
			'type'     => 'css',
			'element'  => '.elementor-button.elementor-size-xs',
			'property' => $property,
			'function' => array(
				'name' => 'scale_dimensions',
				'args' => array( 0.9 ),
			),
		);
		$array[] = array(
			'type'     => 'css',
			'element'  => '.elementor-button.elementor-size-md',
			'property' => $property,
			'function' => array(
				'name' => 'scale_dimensions',
				'args' => array( 1.1 ),
			),
		);
		$array[] = array(
			'type'     => 'css',
			'element'  => '.elementor-button.elementor-size-lg',
			'property' => $property,
			'function' => array(
				'name' => 'scale_dimensions',
				'args' => array( 1.2 ),
			),
		);
		$array[] = array(
			'type'     => 'css',
			'element'  => '.elementor-button.elementor-size-xl',
			'property' => $property,
			'function' => array(
				'name' => 'scale_dimensions',
				'args' => array( 1.3 ),
			),
		);
	}

	$add['button_' . $prop ] = $array;
}

foreach ( array( 'bg' => 'background-color', 'border' => 'border-color', 'text' => 'color' ) as $key => $prop ) {
	$add['button_' . $key . '_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.elementor-widget-button.elementor-button-suki-default .elementor-button-wrapper .elementor-button',
			'property' => $prop,
		),
	);
}
foreach ( array( 'bg' => 'background-color', 'border' => 'border-color', 'text' => 'color' ) as $key => $prop ) {
	$add['button_hover_' . $key . '_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.elementor-widget-button.elementor-button-suki-default .elementor-button-wrapper .elementor-button:hover, .elementor-widget-button.elementor-button-suki-default .elementor-button-wrapper .elementor-button:focus',
			'property' => $prop,
		),
	);
}

/**
 * ====================================================
 * Content & Sidebar > Main Content
 * ====================================================
 */

$add['content_border_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.elementor-divider-separator',
		'property' => 'border-color',
	),
);

$postmessages = array_merge_recursive( $postmessages, $add );