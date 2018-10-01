<?php
/**
 * Customizer & Front-End modification rules.
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$add = array();

/**
 * ====================================================
 * General Elements > Button
 * ====================================================
 */

$add['button_padding'] = array(
	array(
		'type'     => 'css',
		'element'  => '.wp-block-button .wp-block-button__link',
		'property' => 'padding',
	),
);
$add['button_border'] = array(
	array(
		'type'     => 'css',
		'element'  => '.wp-block-button .wp-block-button__link',
		'property' => 'border-width',
	),
);
$add['button_border_radius'] = array(
	array(
		'type'     => 'css',
		'element'  => '.wp-block-button .wp-block-button__link',
		'property' => 'border-radius',
	),
);
foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'letter_spacing' ) as $prop ) {
	$element = '.wp-block-button .wp-block-button__link';
	$property = str_replace( '_', '-', $prop );

	$add['button_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element,
			'property' => $property,
		),
	);
}
foreach ( array( 'bg' => 'background-color', 'border' => 'border-color', 'text' => 'color' ) as $key => $prop ) {
	$add['button_' . $key . '_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.wp-block-button .wp-block-button__link',
			'property' => $prop,
		),
	);
}
foreach ( array( 'bg' => 'background-color', 'border' => 'border-color', 'text' => 'color' ) as $key => $prop ) {
	$add['button_hover_' . $key . '_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.wp-block-button .wp-block-button__link:hover, .wp-block-button .wp-block-button__link:focus',
			'property' => $prop,
		),
	);
}

/**
 * ====================================================
 * Page Canvas & Wrapper
 * ====================================================
 */

$add['boxed_page_width'] = array(
	array(
		'type'     => 'css',
		'element'  => 'body.suki-page-layout-boxed .suki-content-layout-narrow .alignfull, body.suki-page-layout-boxed .suki-content-layout-wide .alignfull',
		'property' => 'width',
	),
	array(
		'type'     => 'css',
		'element'  => 'body.suki-page-layout-boxed .suki-content-layout-narrow .wp-block-columns.alignfull, body.suki-page-layout-boxed .suki-content-layout-wide .wp-block-columns.alignfull',
		'property' => 'width',
		'pattern'  => 'calc( $ + ( 2 * 15px ) )',
	),
	array(
		'type'     => 'css',
		'element'  => 'body.suki-page-layout-boxed .suki-content-layout-narrow .wp-block-gallery.alignfull, body.suki-page-layout-boxed .suki-content-layout-wide .wp-block-gallery.alignfull',
		'property' => 'width',
		'pattern'  => 'calc( $ + ( 2 * 8px ) )',
	),
);

$add['container_width'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-content-layout-narrow .alignwide',
		'property' => 'width',
	),
	array(
		'type'     => 'css',
		'element'  => '.suki-content-layout-narrow .wp-block-columns.alignwide',
		'property' => 'width',
		'pattern'  => 'calc( $ + ( 2 * 15px ) )',
	),
	array(
		'type'     => 'css',
		'element'  => '.suki-content-layout-narrow .wp-block-gallery.alignwide',
		'property' => 'width',
		'pattern'  => 'calc( $ + ( 2 * 8px ) )',
	),
);