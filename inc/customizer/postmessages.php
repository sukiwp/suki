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
 * WordPress default controls
 * ====================================================
 */

// Add postmessage to some default WordPress settings.
$add['blogname'] = array(
	array(
		'type'    => 'html',
		'element' => '.site-title a span',
	),
	array(
		'type'     => 'html',
		'property' => 'alt',
		'element'  => '.site-title a img',
	),
);
$add['blogdescription'] = array(
	array(
		'type'    => 'html',
		'element' => '.site-description',
	),
);

/**
 * ====================================================
 * General Elements > Body (Base)
 * ====================================================
 */

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$element = 'html, body';
	$property = str_replace( '_', '-', $prop );

	$add['body_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element,
			'property' => $property,
		),
	);
	if ( in_array( $prop, array( 'font_size', 'line_height', 'letter_spacing' ) ) ) {
		$add['body_' . $prop . '__tablet'] = array(
			array(
				'type'     => 'css',
				'element'  => 'html, body',
				'property' => $property,
				'media'    => '@media screen and (max-width: 767px)',
			),
		);
		$add['body_' . $prop . '__mobile'] = array(
			array(
				'type'     => 'css',
				'element'  => 'html, body',
				'property' => $property,
				'media'    => '@media screen and (max-width: 499px)',
			),
		);
	}
}

// Drop cap
$add['body_line_height'][] = array(
	'type'     => 'css',
	'element'  => 'p.has-drop-cap:not(:focus):first-letter',
	'property' => 'font-size',
	'pattern'  => '$em',
	'function' => array(
		'name' => 'scale_dimensions',
		'args' => array( 2 ),
	),
);

$add['body_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => 'html, body',
		'property' => 'color',
	),
	array(
		'type'     => 'css',
		'element'  => '.nav-links a, #infinite-handle span button, .tagcloud a',
		'property' => 'color',
	),
);
$add['link_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => 'a, .suki-toggle',
		'property' => 'color',
	),
	array(
		'type'     => 'css',
		'element'  => '.nav-links a:hover, .nav-links a:focus, #infinite-handle span button:hover, #infinite-handle span button:focus, .tagcloud a:hover, .tagcloud a:focus',
		'property' => 'color',
	),
	array(
		'type'     => 'css',
		'element'  => '::selection',
		'property' => 'background-color',
	),
);
$add['link_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => 'a:hover, a:focus, .suki-toggle:hover, .suki-toggle:focus',
		'property' => 'color',
	),
);
$add['subtle_color'] = array(
	array(
		'type'     => 'css',
		'element'  => 'pre, code, .tagcloud a',
		'property' => 'background-color',
	),
);

/**
 * ====================================================
 * General Elements > Headings
 * ====================================================
 */

for ( $i = 1; $i <= 4; $i++ ) {
	foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
		$element = 'h' . $i;
		$property = str_replace( '_', '-', $prop );

		$add['h' . $i . '_' . $prop ] = array(
			array(
				'type'     => 'font_family' === $prop ? 'font' : 'css',
				'element'  => $element,
				'property' => $property,
			),
		);
		if ( in_array( $prop, array( 'font_size', 'line_height', 'letter_spacing' ) ) ) {
			$add['h' . $i . '_' . $prop . '__tablet'] = array(
				array(
					'type'     => 'css',
					'element'  => $element,
					'property' => $property,
					'media'    => '@media screen and (max-width: 767px)',
				),
			);
			$add['h' . $i . '_' . $prop . '__mobile'] = array(
				array(
					'type'     => 'css',
					'element'  => $element,
					'property' => $property,
					'media'    => '@media screen and (max-width: 499px)',
				),
			);
		}
	}
}
$add['heading_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => 'h1, h2, h3, h4, h1 a, h2 a, h3 a, h4 a, .comment-author a, .entry-author-name, .entry-author-name a',
		'property' => 'color',
	),
);
$add['heading_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => 'h1 a:hover, h1 a:focus, h2 a:hover, h2 a:focus, h3 a:hover, h3 a:focus, h4 a:hover, h4 a:focus, .comment-author a:hover, .comment-author a:focus, .entry-author-name a:hover, .entry-author-name a:focus',
		'property' => 'color',
	),
);

/**
 * ====================================================
 * General Elements > Blockquote
 * ====================================================
 */

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$element = 'blockquote';
	$property = str_replace( '_', '-', $prop );

	$add['blockquote_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element,
			'property' => $property,
		),
	);
	if ( in_array( $prop, array( 'font_size', 'line_height', 'letter_spacing' ) ) ) {
		$add['blockquote_' . $prop . '__tablet'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 767px)',
			),
		);
		$add['blockquote_' . $prop . '__mobile'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 499px)',
			),
		);
	}
}

/**
 * ====================================================
 * General Elements > Buttons
 * ====================================================
 */

$add['button_padding'] = array(
	array(
		'type'     => 'css',
		'element'  => 'button, input[type="button"], input[type="reset"], input[type="submit"], .button, a.button, .wp-block-button .wp-block-button__link',
		'property' => 'padding',
	),
);
$add['button_border'] = array(
	array(
		'type'     => 'css',
		'element'  => 'button, input[type="button"], input[type="reset"], input[type="submit"], .button, a.button, .wp-block-button .wp-block-button__link',
		'property' => 'border-width',
	),
);
$add['button_border_radius'] = array(
	array(
		'type'     => 'css',
		'element'  => 'button, input[type="button"], input[type="reset"], input[type="submit"], .button, a.button, .wp-block-button .wp-block-button__link',
		'property' => 'border-radius',
	),
);
foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'letter_spacing' ) as $prop ) {
	$element = 'button, input[type="button"], input[type="reset"], input[type="submit"], .button, a.button, .wp-block-button .wp-block-button__link';
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
			'element'  => 'button, input[type="button"], input[type="reset"], input[type="submit"], .button, a.button, .wp-block-button .wp-block-button__link',
			'property' => $prop,
		),
	);
}
foreach ( array( 'bg' => 'background-color', 'border' => 'border-color', 'text' => 'color' ) as $key => $prop ) {
	$add['button_hover_' . $key . '_color'] = array(
		array(
			'type'     => 'css',
			'element'  => 'button:hover, button:focus, input[type="button"]:hover, input[type="button"]:focus, input[type="reset"]:hover, input[type="reset"]:focus, input[type="submit"]:hover, input[type="submit"]:focus, .button:hover, .button:focus, a.button:hover, a.button:focus, .wp-block-button .wp-block-button__link:hover, .wp-block-button .wp-block-button__link:focus',
			'property' => $prop,
		),
	);
}

/**
 * ====================================================
 * General Elements > Form Inputs
 * ====================================================
 */

$add['input_padding'] = array(
	array(
		'type'     => 'css',
		'element'  => 'input[type="text"], input[type="password"], input[type="color"], input[type="date"], input[type="datetime-local"], input[type="email"], input[type="month"], input[type="number"], input[type="search"], input[type="tel"], input[type="time"], input[type="url"], input[type="week"], select, .select2-container .select2-selection, textarea',
		'property' => 'padding',
	),
	array(
		'type'     => 'css',
		'element'  => '.select2-container .select2-dropdown .select2-search, .select2-container .select2-dropdown .select2-results .select2-results__option',
		'property' => 'padding',
	),
);
$add['input_border'] = array(
	array(
		'type'     => 'css',
		'element'  => 'input[type="text"], input[type="password"], input[type="color"], input[type="date"], input[type="datetime-local"], input[type="email"], input[type="month"], input[type="number"], input[type="search"], input[type="tel"], input[type="time"], input[type="url"], input[type="week"], select, .select2-container .select2-selection, textarea',
		'property' => 'border-width',
	),
	array(
		'type'     => 'css',
		'element'  => '.select2-container .select2-dropdown',
		'property' => 'border-width',
	),
);
$add['input_border_radius'] = array(
	array(
		'type'     => 'css',
		'element'  => 'input[type="text"], input[type="password"], input[type="color"], input[type="date"], input[type="datetime-local"], input[type="email"], input[type="month"], input[type="number"], input[type="search"], input[type="tel"], input[type="time"], input[type="url"], input[type="week"], select, .select2-container .select2-selection, textarea',
		'property' => 'border-radius',
	),
	array(
		'type'     => 'css',
		'element'  => '.select2-container .select2-dropdown',
		'property' => 'border-radius',
	),
);
foreach ( array( 'bg' => 'background-color', 'border' => 'border-color', 'text' => 'color' ) as $key => $prop ) {
	$add['input_' . $key . '_color'] = array(
		array(
			'type'     => 'css',
			'element'  => 'input[type="text"], input[type="password"], input[type="color"], input[type="date"], input[type="datetime-local"], input[type="email"], input[type="month"], input[type="number"], input[type="search"], input[type="tel"], input[type="time"], input[type="url"], input[type="week"], select, .select2-container .select2-selection, textarea',
			'property' => $prop,
		),
	);
}
foreach ( array( 'bg' => 'background-color', 'border' => 'border-color', 'text' => 'color' ) as $key => $prop ) {
	$add['input_focus_' . $key . '_color'] = array(
		array(
			'type'     => 'css',
			'element'  => 'input[type="text"]:focus, input[type="password"]:focus, input[type="color"]:focus, input[type="date"]:focus, input[type="datetime-local"]:focus, input[type="email"]:focus, input[type="month"]:focus, input[type="number"]:focus, input[type="search"]:focus, input[type="tel"]:focus, input[type="time"]:focus, input[type="url"]:focus, input[type="week"]:focus, select:focus, .select2-container .select2-selection:focus, .select2-drop, textarea:focus',
			'property' => $prop,
		),
	);
}

/**
 * ====================================================
 * General Elements > Title
 * ====================================================
 */

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$element = '.page-title, .entry-title';
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
		'element'  => '.page-title, .page-title a, .entry-title, .entry-title a',
		'property' => 'color',
	),
);
$add['title_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.page-title a:hover, .page-title a:focus, .entry-title a:hover, .entry-title a:focus',
		'property' => 'color',
	),
);

/**
 * ====================================================
 * General Elements > Small Title
 * ====================================================
 */

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$element = '.entry-small-title, .comments-title, .comment-reply-title';
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
		'element'  => '.entry-small-title, .entry-small-title a, .comments-title, .comment-reply-title',
		'property' => 'color',
	),
);
$add['small_title_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.entry-small-title a:hover, .entry-small-title a:focus',
		'property' => 'color',
	),
);

/**
 * ====================================================
 * General Elements > Meta
 * ====================================================
 */

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$element = '.entry-meta, .comment-metadata, .widget .post-date, .widget .rss-date';
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
		'element'  => '.entry-meta, .comment-metadata, .tagcloud, .widget .post-date, .widget_rss .rss-date, .reply, .entry-author-links',
		'property' => 'color',
	),
);
$add['meta_link_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.entry-meta a, .comment-metadata a, .widget .post-date a, .widget_rss .rss-date a, .reply a, .entry-author-links a',
		'property' => 'color',
	),
);
$add['meta_link_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.entry-meta a:hover, .entry-meta a:focus, .comment-metadata a:hover, .comment-metadata a:focus, .widget .post-date a:hover, .widget .post-date a:focus, .widget_rss .rss-date a:hover, .widget_rss .rss-date a:focus, .reply a:hover, .reply a:focus, .entry-author-links a:hover, .entry-author-links a:focus',
		'property' => 'color',
	),
);

/**
 * ====================================================
 * Page Container
 * ====================================================
 */

$add['page_layout'] = array(
	array(
		'type'    => 'class',
		'element' => 'body',
		'pattern' => 'suki-page-layout-$',
	),
);
$add['boxed_page_width'] = array(
	array(
		'type'     => 'css',
		'element'  => 'body.suki-page-layout-boxed #page',
		'property' => 'width',
	),
	array(
		'type'     => 'css',
		'element'  => 'body.suki-page-layout-boxed .suki-header-sticky.sticky .suki-section-inner',
		'property' => 'width',
	),
	// .alignfull
	array(
		'type'     => 'css',
		'element'  => 'body.suki-page-layout-boxed #canvas .alignfull',
		'property' => 'width',
	),
);
$add['boxed_page_shadow'] = array(
	array(
		'type'     => 'css',
		'element'  => 'body.suki-page-layout-boxed #page',
		'property' => 'box-shadow',
	),
);
$add['container_width'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-wrapper, .suki-section-contained > .suki-section-inner',
		'property' => 'width',
	),
	array(
		'type'     => 'css',
		'element'  => '.suki-section-default .menu .sub-menu',
		'property' => 'max-width',
	),
	array(
		'type'     => 'css',
		'element'  => '.suki-section-contained.suki-header-sticky.sticky .suki-section-inner',
		'property' => 'width',
	),
);
$responsive = array(
	'' => '',
	'__tablet' => '@media screen and (max-width: 767px)',
	'__mobile' => '@media screen and (max-width: 499px)',
);
foreach ( $responsive as $suffix => $media ) {
	$add['edge_padding' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-section-contained, .suki-section-default .suki-section-inner, .suki-section-full-width-padding .suki-section-inner',
			'property' => 'padding',
			'pattern'  => '0 $',
			'media'    => $media,
		),
	);
}
$add['page_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => 'body, #page',
		'property' => 'background-color',
	),
);

$add['outside_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => 'body.suki-page-layout-boxed',
		'property' => 'background-color',
	),
);
foreach ( array( 'bg_image', 'bg_position', 'bg_size', 'bg_repeat', 'bg_attachment' ) as $prop ) {
	$add['outside_' . $prop ] = array(
		array(
			'type'     => 'css',
			'element'  => 'body.suki-page-layout-boxed',
			'property' => str_replace( 'bg_', 'background-', $prop ),
			'pattern'  => ( 'bg_image' == $prop ) ? 'url($)' : '$',
			'media'    => '@media screen and (min-width: 1024px)',
		),
	);
}

/**
 * ====================================================
 * Header > Logo
 * ====================================================
 */

$add['header_logo_width'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-logo .site-title > a > img, .suki-header-logo .site-title > a > svg',
		'property' => 'width',
	),
);
$add['header_mobile_logo_width'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-mobile-logo .site-title > a > img, .suki-header-mobile-logo .site-title > a > svg',
		'property' => 'width',
	),
);

/**
 * ====================================================
 * Header > Search
 * ====================================================
 */

$add['header_search_bar_width'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-search.suki-header-search-bar .search-field',
		'property' => 'width',
	),
);
$add['header_search_dropdown_width'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-search.suki-header-search-dropdown .sub-menu',
		'property' => 'width',
	),
);

/**
 * ====================================================
 * Header > Social
 * ====================================================
 */

$add['header_social_links_target'] = array(
	array(
		'type'     => 'html',
		'element'  => '.suki-header-social-links a',
		'property' => 'target',
		'pattern'  => '_$',
	),
);

/**
 * ====================================================
 * Header > Top Bar
 * Header > Main Bar
 * Header > Bottom Bar
 * ====================================================
 */

foreach ( array( 'top_bar', 'main_bar', 'bottom_bar' ) as $type ) {
	$bar = str_replace( '_', '-', $type );

	// Layout
	$add['header_' . $type . '_container'] = array(
		array(
			'type'     => 'class',
			'element'  => '.suki-header-' . $bar,
			'pattern'  => 'section-$',
		),
	);
	$add['header_' . $type . '_height'] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $bar,
			'property' => 'height',
		),
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $bar . '-inner',
			'property' => 'height',
		),
	);
	$add['header_' . $type . '_padding'] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $bar . ' .suki-header-row',
			'property' => 'padding',
		),
	);
	$add['header_' . $type . '_border'] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $bar . '-inner',
			'property' => 'border-width',
		),
	);
	$add['header_' . $type . '_items_gap'] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $bar . ' .suki-header-column > *',
			'property' => 'padding',
			'pattern'  => '0 $',
		),
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $bar . ' .suki-header-row',
			'property' => 'margin',
			'pattern'  => '0 -$',
		),
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $bar . ' .suki-header-menu .menu-item',
			'property' => 'margin',
			'pattern'  => '0 $',
		),
	);

	foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
		$element = '.suki-header-' . $bar;
		$property = str_replace( '_', '-', $prop );

		$add['header_' . $type . '_' . $prop ] = array(
			array(
				'type'     => 'font_family' === $prop ? 'font' : 'css',
				'element'  => $element,
				'property' => $property,
			),
		);
	}

	$add['header_' . $type . '_section_bg_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $bar . '-inner',
			'property' => 'background-color',
		),
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $bar . ' .sub-menu',
			'property' => 'background-color',
		),
	);
	$add['header_' . $type . '_section_border_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $bar . ' *',
			'property' => 'border-color',
		),
	);
	$add['header_' . $type . '_text_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $bar,
			'property' => 'color',
		),
	);
	$add['header_' . $type . '_link_text_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $bar . ' a:not(.button), .suki-header-' . $bar . ' .suki-toggle',
			'property' => 'color',
		),
	);
	$add['header_' . $type . '_link_hover_text_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $bar . ' a:not(.button):hover, .suki-header-' . $bar . ' a:not(.button):focus, .suki-header-' . $bar . ' .suki-toggle:hover, .suki-header-' . $bar . ' .suki-toggle:focus',
			'property' => 'color',
		),
	);
}

/**
 * ====================================================
 * Header > Mobile Main Bar
 * ====================================================
 */

// Layout
$add['header_mobile_main_bar_height'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-mobile-main-bar, .suki-header-mobile-main-bar-inner',
		'property' => 'height',
	),
);
$add['header_mobile_main_bar_border'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-mobile-main-bar-inner',
		'property' => 'border-width',
	),
);
$add['header_mobile_main_bar_items_gap'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-mobile-main-bar .suki-header-column > *, .suki-header-mobile-main-bar .suki-header-menu > li > a',
		'property' => 'padding',
		'pattern'  => '0 $',
	),
	array(
		'type'     => 'css',
		'element'  => '.suki-header-mobile-main-bar .suki-header-row',
		'property' => 'margin',
		'pattern'  => '0 -$',
	),
	array(
		'type'     => 'css',
		'element'  => '.suki-header-mobile-main-bar .menu-item',
		'property' => 'margin',
		'pattern'  => '0 $',
	),
);

$add['header_mobile_main_bar_section_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-mobile-main-bar-inner, .suki-header-mobile-main-bar .sub-menu',
		'property' => 'background-color',
	),
);
$add['header_mobile_main_bar_section_border_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-mobile-main-bar *',
		'property' => 'border-color',
	),
);
$add['header_mobile_main_bar_menu_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-mobile-main-bar a:not(.button), .suki-header-mobile-main-bar .suki-toggle',
		'property' => 'color',
	),
);
$add['header_mobile_main_bar_menu_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-mobile-main-bar a:not(.button):hover, .suki-header-mobile-main-bar a:not(.button):focus, .suki-header-mobile-main-bar .suki-toggle:hover, .suki-header-mobile-main-bar .suki-toggle:focus',
		'property' => 'color',
	),
);

/**
 * ====================================================
 * Header > Mobile Drawer (Popup)
 * ====================================================
 */

$add['header_mobile_vertical_bar_width'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-mobile-vertical-bar',
		'property' => 'width',
	),
);
$add['header_mobile_vertical_bar_alignment'] = array(
	array(
		'type'     => 'class',
		'element'  => '.suki-header-mobile-vertical-bar',
		'pattern'  => 'suki-header-mobile-vertical-alignment-$',
	),
);

$add['header_mobile_vertical_bar_items_gap'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-mobile-vertical-bar .suki-header-vertical-row, .suki-header-mobile-vertical-bar .suki-header-vertical-row > *',
		'property' => 'padding',
		'pattern'  => '$ 0',
	),
);
$add['header_mobile_vertical_bar_section_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-mobile-vertical-bar-inner',
		'property' => 'background-color',
	),
);
$add['header_mobile_vertical_bar_section_border_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-mobile-vertical-bar *',
		'property' => 'border-color',
	),
);

// Text
foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$add['header_mobile_vertical_bar_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => '.suki-header-mobile-vertical-bar',
			'property' => str_replace( '_', '-', $prop),
			'pattern'  => in_array( $prop, array( 'font_size', 'letter_spacing' ) ) ? '$px' : '$',
		),
	);
}
$add['header_mobile_vertical_bar_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-mobile-vertical-bar',
		'property' => 'color',
	),
);
$add['header_mobile_vertical_bar_link_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-mobile-vertical-bar a:not(.button), .suki-header-mobile-vertical-bar .suki-toggle',
		'property' => 'color',
	),
);
$add['header_mobile_vertical_bar_link_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-mobile-vertical-bar a:not(.button):hover, .suki-header-mobile-vertical-bar a:not(.button):focus, .suki-header-mobile-vertical-bar .suki-toggle:hover, .suki-header-mobile-vertical-bar .suki-toggle:focus',
		'property' => 'color',
	),
);

/**
 * ====================================================
 * Content & Sidebar > Content Section
 * ====================================================
 */

$add['content_section_padding'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-content-row',
		'property' => 'padding',
	),
);

/**
 * ====================================================
 * Content & Sidebar > Main Content
 * ====================================================
 */

$responsive = array(
	'' => '',
	'__tablet' => '@media screen and (max-width: 767px)',
	'__mobile' => '@media screen and (max-width: 499px)',
);
foreach ( $responsive as $suffix => $media ) {
	$add['content_padding' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.content-area .site-main',
			'property' => 'padding',
			'media'    => $media,
		),
		array(
			'type'     => 'css',
			'element'  => '.entry-layout-default:first-child .entry-thumbnail.suki-entry-thumbnail-ignore-padding:first-child',
			'property' => 'margin-top',
			'pattern'  => '-$ !important',
			'media'    => $media,
			'function' => array(
				'name' => 'explode_value',
				'args' => array( 0 ), // 1st part = top
			),
		),
		array(
			'type'     => 'css',
			'element'  => '.entry-layout-default .entry-thumbnail.suki-entry-thumbnail-ignore-padding, .alignwide',
			'property' => 'margin-right',
			'pattern'  => '-$ !important',
			'media'    => $media,
			'function' => array(
				'name' => 'explode_value',
				'args' => array( 1 ), // 2nd part = right
			),
		),
		array(
			'type'     => 'css',
			'element'  => '.entry-layout-default .entry-thumbnail.suki-entry-thumbnail-ignore-padding, .alignwide',
			'property' => 'margin-left',
			'pattern'  => '-$ !important',
			'media'    => $media,
			'function' => array(
				'name' => 'explode_value',
				'args' => array( 3 ), // 4rd part = left
			),
		),
	);
}
$add['content_border'] = array(
	array(
		'type'     => 'css',
		'element'  => '.content-area .site-main',
		'property' => 'border-width',
	),
);
$add['narrow_content_width'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-content-layout-narrow .site-main',
		'property' => 'width',
		'media'    => '@media screen and (min-width: 1024px)',
	),
);

$add['content_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.content-area .site-main',
		'property' => 'background-color',
	),
);
$add['content_border_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.content-area .site-main',
		'property' => 'border-color',
	),
);

/**
 * ====================================================
 * Content & Sidebar > Sidebar
 * ====================================================
 */

$add['sidebar_width'] = array(
	array(
		'type'     => 'css',
		'element'  => '.sidebar',
		'property' => 'width',
	),
	array(
		'type'     => 'css',
		'element'  => '.sidebar',
		'property' => 'min-width',
	),
);
$add['sidebar_gap'] = array(
	array(
		'type'     => 'css',
		'element'  => '.ltr #content.suki-content-layout-right-sidebar .sidebar',
		'property' => 'margin-left',
	),
	array(
		'type'     => 'css',
		'element'  => '.rtl #content.suki-content-layout-right-sidebar .sidebar',
		'property' => 'margin-right',
	),
	array(
		'type'     => 'css',
		'element'  => '.ltr #content.suki-content-layout-left-sidebar .sidebar',
		'property' => 'margin-right',
	),
	array(
		'type'     => 'css',
		'element'  => '.rtl #content.suki-content-layout-left-sidebar .sidebar',
		'property' => 'margin-right',
	),
);

$add['sidebar_widgets_mode'] = array(
	array(
		'type'     => 'class',
		'element'  => '.sidebar',
		'pattern'  => 'suki-sidebar-widgets-mode-$',
	),
);
$add['sidebar_widgets_gap'] = array(
	array(
		'type'     => 'css',
		'element'  => '.sidebar .widget',
		'property' => 'margin-top',
	),
);

$responsive = array(
	'' => '',
	'__tablet' => '@media screen and (max-width: 767px)',
	'__mobile' => '@media screen and (max-width: 499px)',
);
foreach ( $responsive as $suffix => $media ) {
	$add['sidebar_padding' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.sidebar.suki-sidebar-widgets-mode-merged .sidebar-inner, .sidebar.suki-sidebar-widgets-mode-separated .widget',
			'property' => 'padding',
			'media'    => $media,
		),
	);
}
$add['sidebar_border'] = array(
	array(
		'type'     => 'css',
		'element'  => '.sidebar.suki-sidebar-widgets-mode-merged .sidebar-inner, .sidebar.suki-sidebar-widgets-mode-separated .widget',
		'property' => 'border-width',
	),
);

$add['sidebar_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.sidebar.suki-sidebar-widgets-mode-merged .sidebar-inner, .sidebar.suki-sidebar-widgets-mode-separated .widget',
		'property' => 'background-color',
	),
);
$add['sidebar_border_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.sidebar.suki-sidebar-widgets-mode-merged .sidebar-inner, .sidebar.suki-sidebar-widgets-mode-separated .widget',
		'property' => 'border-color',
	),
);

/**
 * ====================================================
 * Footer > Widgets Bar
 * ====================================================
 */

$add['footer_widgets_bar_columns_gap'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-widgets-bar-column',
		'property' => 'padding',
		'pattern'  => '0 $',
	),
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-widgets-bar-row',
		'property' => 'margin',
		'pattern'  => '0 -$',
	),
);
$add['footer_widgets_bar_container'] = array(
	array(
		'type'     => 'class',
		'element'  => '.suki-footer-widgets-bar',
		'pattern'  => 'section-$',
	),
);
$responsive = array(
	'' => '',
	'__tablet' => '@media screen and (max-width: 767px)',
	'__mobile' => '@media screen and (max-width: 499px)',
);
foreach ( $responsive as $suffix => $media ) {
	$add['footer_widgets_bar_padding' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-footer-widgets-bar-row',
			'property' => 'padding',
			'media'    => $media,
		),
	);
}
$add['footer_widgets_bar_border'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-widgets-bar-inner',
		'property' => 'border-width',
	),
);
$add['footer_widgets_bar_section_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-widgets-bar-inner',
		'property' => 'background-color',
	),
);
$add['footer_widgets_bar_section_border_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-widgets-bar *',
		'property' => 'border-color',
	),
);
$add['footer_widgets_bar_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-widgets-bar',
		'property' => 'color',
	),
);
$add['footer_widgets_bar_link_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-widgets-bar a:not(.button)',
		'property' => 'color',
	),
);
$add['footer_widgets_bar_link_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-widgets-bar a:not(.button):hover, .suki-footer-widgets-bar a:not(.button):focus',
		'property' => 'color',
	),
);
$add['footer_widgets_bar_widget_title_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-widgets-bar .widget-title',
		'property' => 'color',
	),
);

/**
 * ====================================================
 * Footer > Bottom Bar
 * ====================================================
 */

$add['footer_bottom_bar_container'] = array(
	array(
		'type'     => 'class',
		'element'  => '.suki-footer-bottom-bar',
		'pattern'  => 'section-$',
	),
);

$responsive = array(
	'' => '',
	'__tablet' => '@media screen and (max-width: 767px)',
	'__mobile' => '@media screen and (max-width: 499px)',
);
foreach ( $responsive as $suffix => $media ) {
	$add['footer_bottom_bar_padding' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-footer-bottom-bar-row',
			'property' => 'padding',
			'media'    => $media,
		),
	);
}
$add['footer_bottom_bar_border'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-bottom-bar-inner',
		'property' => 'border-width',
	),
);

$add['footer_bottom_bar_section_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-bottom-bar-inner',
		'property' => 'background-color',
	),
);
$add['footer_bottom_bar_section_border_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-bottom-bar-inner',
		'property' => 'border-color',
	),
);
$add['footer_bottom_bar_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-bottom-bar',
		'property' => 'color',
	),
);
$add['footer_bottom_bar_link_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-bottom-bar a:not(.button)',
		'property' => 'color',
	),
);
$add['footer_bottom_bar_link_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-bottom-bar a:not(.button):hover, .suki-footer-bottom-bar a:not(.button):focus',
		'property' => 'color',
	),
);

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$element = '.suki-footer-bottom-bar';
	$property = str_replace( '_', '-', $prop );

	$add['footer_bottom_bar_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element,
			'property' => $property,
		),
	);
}

/**
 * ====================================================
 * Footer > Social
 * ====================================================
 */

// Social links
$add['footer_social_links_target'] = array(
	array(
		'type'     => 'html',
		'element'  => '.suki-footer-social-links a',
		'property' => 'target',
		'pattern'  => '_$',
	),
);

/**
 * ====================================================
 * Blog > Post Layout: Grid
 * ====================================================
 */

$add['blog_index_grid_columns'] = array(
	array(
		'type'     => 'class',
		'element'  => '.suki-loop-grid',
		'pattern'  => 'suki-loop-grid-$-columns',
	),
);
$add['blog_index_grid_columns_gap'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-loop-grid > .entry, #infinite-handle',
		'property' => 'padding-left',
	),
	array(
		'type'     => 'css',
		'element'  => '.suki-loop-grid > .entry, #infinite-handle',
		'property' => 'padding-right',
	),
	array(
		'type'     => 'css',
		'element'  => '.suki-loop-grid',
		'property' => 'margin-left',
		'pattern'  => '-$',
	),
	array(
		'type'     => 'css',
		'element'  => '.suki-loop-grid',
		'property' => 'margin-right',
		'pattern'  => '-$',
	),
);
$add['entry_grid_header_alignment'] = array(
	array(
		'type'     => 'css',
		'element'  => '.entry-layout-grid .entry-header, .entry-layout-grid .entry-footer',
		'property' => 'text-align',
	),
);

/**
 * ====================================================
 * Blog > Post Layout: Default
 * ====================================================
 */

$add['entry_header_alignment'] = array(
	array(
		'type'     => 'css',
		'element'  => '.entry-header, .entry-footer',
		'property' => 'text-align',
	),
	array(
		'type'     => 'css',
		'element'  => '.page-title',
		'property' => 'text-align',
	),
);

$postmessages = array_merge_recursive( $postmessages, $add );