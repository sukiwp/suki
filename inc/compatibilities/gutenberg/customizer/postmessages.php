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
 * General Elements > Gutenberg Elements
 * ====================================================
 */

$add['gutenberg_alignwide_negative_margin'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-content-layout-narrow .alignwide, .suki-content-layout-wide .alignwide',
		'property' => 'width',
		'pattern'  => 'calc( 100% + ( 2 * $ ) )',
	),
	array(
		'type'     => 'css',
		'element'  => '.suki-content-layout-narrow .wp-block-gallery.alignwide, .suki-content-layout-wide .wp-block-gallery.alignwide',
		'property' => 'width',
		'pattern'  => 'calc( 100% + ( 2 * $ ) + ( 2 + 8px ) )',
	),
);

$add['gutenberg_columns_gutter'] = array(
	array(
		'type'     => 'css',
		'element'  => '.wp-block-columns',
		'property' => 'margin',
		'pattern'  => '0 -$',
	),
	array(
		'type'     => 'css',
		'element'  => '.wp-block-column',
		'property' => 'padding',
		'pattern'  => '0 $',
	),
);

/**
 * ====================================================
 * Page Canvas & Wrapper
 * ====================================================
 */

$add['boxed_page_width'] = array(
	array(
		'type'     => 'css',
		'element'  => 'body.suki-page-layout-boxed #canvas .alignfull',
		'property' => 'max-width',
	),
	array(
		'type'     => 'css',
		'element'  => 'body.suki-page-layout-boxed #canvas .alignwide',
		'property' => 'max-width',
		'media'    => '@media screen and (min-width: $)',
	),
);
$responsive = array(
	'' => '',
	'__tablet' => '@media screen and (max-width: 1023px)',
	'__mobile' => '@media screen and (max-width: 499px)',
);
foreach ( $responsive as $suffix => $media ) {
	$add['edge_padding' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-content-layout-narrow .alignwide, .suki-content-layout-wide .alignwide',
			'property' => 'padding',
			'pattern'  => '0 $',
			'media'    => $media,
		),
	);
}