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
 * Global Modules > Color Palette
 * ====================================================
 */

for ( $i = 1; $i <= 8; $i++ ) {
	$add['color_palette_' . $i ] = array(
		array(
			'type'     => 'css',
			'element'  => '.has-suki-color-' . $i . '-background-color', // scss: gutenberg
			'property' => 'background-color',
		),
		array(
			'type'     => 'css',
			'element'  => '.has-suki-color-' . $i . '-color', // scss: gutenberg
			'property' => 'color',
		),
	);
}

/**
 * ====================================================
 * Typography & Colors > Base Typography & Colors
 * ====================================================
 */

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$element = 'html'; // scss: base
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
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 1023px)',
			),
		);
		$add['body_' . $prop . '__mobile'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 499px)',
			),
		);
	}
}

// Font sizes
$add['body_line_height'][] = array(
	'type'     => 'css',
	'element'  => '.has-medium-text-size', // scss: gutenberg
	'property' => 'line-height',
	'pattern'  => 'calc( 0.9 * $ )',
);
$add['body_line_height'][] = array(
	'type'     => 'css',
	'element'  => '.has-large-text-size', // scss: gutenberg
	'property' => 'line-height',
	'pattern'  => 'calc( 0.825 * $ )',
);
$add['body_line_height'][] = array(
	'type'     => 'css',
	'element'  => '.has-huge-text-size',
	'property' => 'line-height',
	'pattern'  => 'calc( 0.75 * $ )', // scss: gutenberg
);

// Drop cap
$add['body_line_height'][] = array(
	'type'     => 'css',
	'element'  => 'p.has-drop-cap:not(:focus):first-letter', // scss: gutenberg
	'property' => 'font-size',
	'pattern'  => '$em',
	'function' => array(
		'name' => 'scale_dimensions',
		'args' => array( 3 ),
	),
);

$add['font_smoothing'] = array(
	array(
		'type'     => 'class',
		'element'  => 'body',
		'pattern'  => 'suki-font-smoothing-$', // scss: common
	),
);

$add['body_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => 'body', // scss: base
		'property' => 'color',
	),
);

$add['subtle_color'] = array(
	array(
		'type'     => 'css',
		'element'  => 'pre, code, .tagcloud a, .navigation.pagination .current, span.select2-container .select2-selection--multiple .select2-selection__rendered li.select2-selection__choice, .wp-block-table.is-style-stripes tbody tr:nth-child(odd)', // scss: base, common, forms, gutenberg
		'property' => 'background-color',
	),
);
$add['border_color'] = array(
	array(
		'type'     => 'css',
		'element'  => 'html *', // scss: base
		'property' => 'border-color',
	),
);

$add['link_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => 'a, button.suki-toggle, .navigation .nav-links a:hover, .navigation .nav-links a:focus, .tagcloud a:hover, .tagcloud a:focus, .comment-body .reply:hover, .comment-body .reply:focus, .comment-metadata a:hover, .comment-metadata a:focus', // scss: base, common
		'property' => 'color',
	),
	array(
		'type'     => 'css',
		'element'  => '.entry-meta a:hover, .entry-meta a:focus, .widget .post-date a:hover, .widget .post-date a:focus, .widget_rss .rss-date a:hover, .widget_rss .rss-date a:focus', // scss: entry, widgets
		'property' => 'color',
	),
	array(
		'type'     => 'css',
		'element'  => 'h1 a:hover, h1 a:focus, .h1 a:hover, .h1 a:focus, h2 a:hover, h2 a:focus, .h2 a:hover, .h2 a:focus, h3 a:hover, h3 a:focus, .h3 a:hover, .h3 a:focus, h4 a:hover, h4 a:focus, .h4 a:hover, .h4 a:focus, h5 a:hover, h5 a:focus, .h5 a:hover, .h5 a:focus, h6 a:hover, h6 a:focus, .h6 a:hover, .h6 a:focus, .comment-author a:hover, .comment-author a:focus, .entry-author-name a:hover, .entry-author-name a:focus', // scss: base, common
		'property' => 'color',
	),
	array(
		'type'     => 'css',
		'element'  => '.suki-header-section a:not(.button):hover, .suki-header-section a:not(.button):focus, .suki-header-section .suki-toggle:hover, .suki-header-section .suki-toggle:focus, .suki-header-section .menu .sub-menu a:not(.button):hover, .suki-header-section .menu .sub-menu a:not(.button):focus, .suki-header-section .menu .sub-menu .suki-toggle:hover, .suki-header-section .menu .sub-menu .suki-toggle:focus, .suki-header-section-vertical a:not(.button):hover, .suki-header-section-vertical a:not(.button):focus, .suki-header-section-vertical .suki-toggle:hover, .suki-header-section-vertical .suki-toggle:focus, .suki-header-section-vertical .menu .sub-menu a:not(.button):hover, .suki-header-section-vertical .menu .sub-menu a:not(.button):focus, .suki-header-section-vertical .menu .sub-menu .suki-toggle:hover, .suki-header-section-vertical .menu .sub-menu .suki-toggle:focus', // scss: header
		'property' => 'color',
	),
	array(
		'type'     => 'css',
		'element'  => '::selection', // scss: base
		'property' => 'background-color',
	),
	array(
		'type'     => 'css',
		'element'  => '.suki-header-cart .cart-count', // scss: header
		'property' => 'background-color',
	),
);
$add['link_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => 'a:hover, a:focus, .suki-toggle:hover, .suki-toggle:focus', // scss: base, common
		'property' => 'color',
	),
);

/**
 * ====================================================
 * Typography & Colors > Headings
 * ====================================================
 */

for ( $i = 1; $i <= 4; $i++ ) {
	foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
		$property = str_replace( '_', '-', $prop );

		$rules = array();

		$rules[] = array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => 'h' . $i . ', .h' . $i, // scss: base
			'property' => $property,
		);

		// Add additional rules
		switch ( $i ) {
			case 1:
				// Styles that inherit h1 by default
				$rules[] = array(
					'type'     => 'font_family' === $prop ? 'font' : 'css',
					'element'  => '.title, .entry-title, .page-title', // scss: common, entry
					'property' => $property,
				);
				break;

			case 3:
				// Styles that inherit h3 by default
				$rules[] = array(
					'type'     => 'font_family' === $prop ? 'font' : 'css',
					'element'  => 'legend, .small-title, .entry-small-title, .comments-title, .comment-reply-title', // scss: forms, common, entry
					'property' => $property,
				);
				break;

			case 4:
				// Styles that inherit h4 by default
				$rules[] = array(
					'type'     => 'font_family' === $prop ? 'font' : 'css',
					'element'  => '.widget_block > [class^="wp-block-"] > h2:first-child, .widget_block > [class^="wp-block-"] > h3:first-child, .widget_block > [class^="wp-block-"] > h4:first-child, .widget_block > [class^="wp-block-"] > h5:first-child, .widget_block > [class^="wp-block-"] > h6:first-child, .widget-title', // scss: widgets
					'property' => $property,
				);
				break;
		}

		$add['h' . $i . '_' . $prop ] = $rules;

		// Responsive
		if ( in_array( $prop, array( 'font_size', 'line_height', 'letter_spacing' ) ) ) {
			// Tablet
			$rules__tablet = $rules;
			foreach ( $rules__tablet as &$rule ) {
				$rule[ 'media' ] = '@media screen and (max-width: 1023px)';
			}
			$add['h' . $i . '_' . $prop . '__tablet'] = $rules__tablet;


			// Mobile
			$rules__mobile = $rules;
			foreach ( $rules__mobile as &$rule ) {
				$rule[ 'media' ] = '@media screen and (max-width: 499px)';
			}
			$add['h' . $i . '_' . $prop . '__mobile'] = $rules__mobile;
		}
	}
}
$add['heading_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => 'h1, .h1, h2, .h2, h3, .h3, h4, .h4, h5, .h5, h6, .h6, h1 a, .h1 a, h2 a, .h2 a, h3 a, .h3 a, h4 a, .h4 a, h5 a, .h5 a, h6 a, .h6 a, table th, button.suki-toggle, .navigation .nav-links .current, .comment-author a, .entry-author-name, .entry-author-name a, .widget-title, p.has-drop-cap:not(:focus):first-letter', // scss: base, common, entry, widgets, gutenberg
		'property' => 'color',
	),
	array(
		'type'     => 'css',
		'element'  => '.suki-header-section a:not(.button), .suki-header-section .suki-toggle, .suki-header-section .menu .sub-menu a:not(.button), .suki-header-section .menu .sub-menu .suki-toggle, .suki-header-section-vertical a:not(.button), .suki-header-section-vertical .suki-toggle, .suki-header-section-vertical .menu .sub-menu a:not(.button), .suki-header-section-vertical .menu .sub-menu .suki-toggle', // scss: header
		'property' => 'color',
	),
);
$add['heading_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => 'h1 a:hover, h1 a:focus, .h1 a:hover, .h1 a:focus, h2 a:hover, h2 a:focus, .h2 a:hover, .h2 a:focus, h3 a:hover, h3 a:focus, .h3 a:hover, .h3 a:focus, h4 a:hover, h4 a:focus, .h4 a:hover, .h4 a:focus, h5 a:hover, h5 a:focus, .h5 a:hover, .h5 a:focus, h6 a:hover, h6 a:focus, .h6 a:hover, .h6 a:focus, .comment-author a:hover, .comment-author a:focus, .entry-author-name a:hover, .entry-author-name a:focus',
		'property' => 'color', // scss: base, common, entry
	),
);

/**
 * ====================================================
 * Typography & Colors > Blockquote
 * ====================================================
 */

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$element = 'blockquote, .wp-block-quote p, .wp-block-pullquote blockquote p'; // scss: base, gutenberg
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
				'media'    => '@media screen and (max-width: 1023px)',
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
 * Typography & Colors > Button
 * ====================================================
 */

$add['button_padding'] = array(
	array(
		'type'     => 'css',
		'element'  => 'button, input[type="button"], input[type="reset"], input[type="submit"], .button, a.button, a.wp-block-button__link', // scss: forms
		'property' => 'padding',
	),
);
$add['button_border'] = array(
	array(
		'type'     => 'css',
		'element'  => 'button, input[type="button"], input[type="reset"], input[type="submit"], .button, a.button, a.wp-block-button__link', // scss: forms
		'property' => 'border-width',
	),
);
$add['button_border_radius'] = array(
	array(
		'type'     => 'css',
		'element'  => 'button, input[type="button"], input[type="reset"], input[type="submit"], .button, a.button, a.wp-block-button__link', // scss: forms
		'property' => 'border-radius',
	),
);
foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'letter_spacing' ) as $prop ) {
	$element = 'button, input[type="button"], input[type="reset"], input[type="submit"], .button, a.button, a.wp-block-button__link'; // scss: forms
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
			'element'  => 'button, input[type="button"], input[type="reset"], input[type="submit"], .button, a.button, a.wp-block-button__link', // scss: forms
			'property' => $prop,
		),
	);
}
foreach ( array( 'bg' => 'background-color', 'border' => 'border-color', 'text' => 'color' ) as $key => $prop ) {
	$add['button_hover_' . $key . '_color'] = array(
		array(
			'type'     => 'css',
			'element'  => 'button:hover, button:focus, input[type="button"]:hover, input[type="button"]:focus, input[type="reset"]:hover, input[type="reset"]:focus, input[type="submit"]:hover, input[type="submit"]:focus, .button:hover, .button:focus, a.button:hover, a.button:focus, a.wp-block-button__link:hover, a.wp-block-button__link:focus', // scss: forms
			'property' => $prop,
		),
	);
}

/**
 * ====================================================
 * Typography & Colors > Form Input
 * ====================================================
 */

$add['input_padding'] = array(
	array(
		'type'     => 'css',
		'element'  => 'input[type="text"], input[type="password"], input[type="color"], input[type="date"], input[type="datetime-local"], input[type="email"], input[type="month"], input[type="number"], input[type="search"], input[type="tel"], input[type="time"], input[type="url"], input[type="week"], .input, select, textarea, span.select2-container .select2-selection, span.select2-container .select2-dropdown .select2-search, span.select2-container .select2-dropdown .select2-results .select2-results__option', // scss: forms
		'property' => 'padding',
	),
);
$add['input_border'] = array(
	array(
		'type'     => 'css',
		'element'  => 'input[type="text"], input[type="password"], input[type="color"], input[type="date"], input[type="datetime-local"], input[type="email"], input[type="month"], input[type="number"], input[type="search"], input[type="tel"], input[type="time"], input[type="url"], input[type="week"], .input, select, textarea, span.select2-container .select2-selection, span.select2-container .select2-dropdown', // scss: forms
		'property' => 'border-width',
	),
);
$add['input_border_radius'] = array(
	array(
		'type'     => 'css',
		'element'  => 'input[type="text"], input[type="password"], input[type="color"], input[type="date"], input[type="datetime-local"], input[type="email"], input[type="month"], input[type="number"], input[type="search"], input[type="tel"], input[type="time"], input[type="url"], input[type="week"], .input, select, textarea, span.select2-container .select2-selection, span.select2-container .select2-dropdown', // scss: forms
		'property' => 'border-radius',
	),
);
foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'letter_spacing' ) as $prop ) {
	$element = 'input[type="text"], input[type="password"], input[type="color"], input[type="date"], input[type="datetime-local"], input[type="email"], input[type="month"], input[type="number"], input[type="search"], input[type="tel"], input[type="time"], input[type="url"], input[type="week"], .input, select, textarea, .search-field, span.select2-container';
	$property = str_replace( '_', '-', $prop );

	$add['input_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element, // scss: forms
			'property' => $property,
		),
	);
}
foreach ( array( 'bg' => 'background-color', 'border' => 'border-color', 'text' => 'color' ) as $key => $prop ) {
	$add['input_' . $key . '_color'] = array(
		array(
			'type'     => 'css',
			'element'  => 'input[type="text"], input[type="password"], input[type="color"], input[type="date"], input[type="datetime-local"], input[type="email"], input[type="month"], input[type="number"], input[type="search"], input[type="tel"], input[type="time"], input[type="url"], input[type="week"], .input, select, textarea, .search-field, span.select2-container .select2-selection, span.select2-container.select2-container--open .select2-dropdown', // scss: forms
			'property' => $prop,
		),
	);

	if ( 'text' == $key ) {
		$add['input_' . $key . '_color'][] = array(
			'type'     => 'css',
			'element'  => '.search-field + .suki-search-icon',
			'property' => $prop,
		);
	}
}
foreach ( array( 'bg' => 'background-color', 'border' => 'border-color', 'text' => 'color' ) as $key => $prop ) {
	$add['input_focus_' . $key . '_color'] = array(
		array(
			'type'     => 'css',
			'element'  => 'input[type="text"]:focus, input[type="password"]:focus, input[type="color"]:focus, input[type="date"]:focus, input[type="datetime-local"]:focus, input[type="email"]:focus, input[type="month"]:focus, input[type="number"]:focus, input[type="search"]:focus, input[type="tel"]:focus, input[type="time"]:focus, input[type="url"]:focus, input[type="week"]:focus, .input:hover, .input:focus, select:focus, textarea:focus, .search-field:focus, span.select2-container.select2-container--open .select2-selection', // scss: forms
			'property' => $prop,
		),
	);

	if ( 'border' === $key ) {
		$add['input_focus_' . $key . '_color'][] = array(
			'type'     => 'css',
			'element'  => 'span.select2-container.select2-container--open .select2-dropdown', // scss: forms
			'property' => $prop,
		);
	}

	if ( 'text' == $key ) {
		$add['input_focus_' . $key . '_color'][] = array(
			'type'     => 'css',
			'element'  => '.search-field:focus + .suki-search-icon',
			'property' => $prop,
		);
	}
}

/**
 * ====================================================
 * Typography & Colors > Title
 * ====================================================
 */

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$element = '.title, .entry-title, .page-title';
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
				'media'    => '@media screen and (max-width: 1023px)',
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
		'element'  => '.title, .title a, .entry-title, .entry-title a, .page-title, .page-title a',
		'property' => 'color',
	),
);
$add['title_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.title a:hover, .title a:focus, .entry-title a:hover, .entry-title a:focus, .page-title a:hover, .page-title a:focus',
		'property' => 'color',
	),
);

/**
 * ====================================================
 * Typography & Colors > Small Title
 * ====================================================
 */

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$element = 'legend, .small-title, .entry-small-title, .comments-title, .comment-reply-title'; // scss: forms, common, entry
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
				'media'    => '@media screen and (max-width: 1023px)',
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
		'element'  => 'legend, .small-title, .small-title a, .entry-small-title, .entry-small-title a, .comments-title, .comment-reply-title', // scss: forms, common, entry
		'property' => 'color',
	),
);
$add['small_title_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.small-title a:hover, .small-title a:focus, .entry-small-title a:hover, .entry-small-title a:focus', // scss: common, entry
		'property' => 'color',
	),
);

/**
 * ====================================================
 * Typography & Colors > Meta Info
 * ====================================================
 */

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$element = '.entry-meta, .comment-metadata, .widget .post-date, .widget_rss .rss-date';
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
				'media'    => '@media screen and (max-width: 1023px)',
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
		'element'  => '.entry-meta, .comment-metadata, .widget .post-date, .widget_rss .rss-date',
		'property' => 'color',
	),
);
$add['meta_link_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.entry-meta a, .comment-metadata a, .widget .post-date a, .widget_rss .rss-date a',
		'property' => 'color',
	),
);
$add['meta_link_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.entry-meta a:hover, .entry-meta a:focus, .comment-metadata a:hover, .comment-metadata a:focus, .widget .post-date a:hover, .widget .post-date a:focus, .widget_rss .rss-date a:hover, .widget_rss .rss-date a:focus',
		'property' => 'color',
	),
);

/**
 * ====================================================
 * Page Canvas & Wrapper
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
		'element'  => 'body.suki-page-layout-boxed #page', // scss: container
		'property' => 'width',
	),
	array(
		'type'     => 'css',
		'element'  => 'body.suki-page-layout-boxed .suki-header-section.suki-section-full-width .menu .sub-menu', // scss: header
		'property' => 'max-width',
	),
	// alignfull
	array(
		'type'     => 'css',
		'element'  => 'body.suki-page-layout-boxed .suki-content-layout-wide .alignfull',
		'property' => 'max-width',
	),
	array(
		'type'     => 'css',
		'element'  => 'body.suki-page-layout-boxed .suki-content-layout-wide .alignfull',
		'property' => 'left',
		'pattern'  => 'calc( 50% - min( $ / 2, 50vw ) )',
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
		'element'  => '.suki-wrapper, .suki-section-contained > .suki-section-inner', // scss: container
		'property' => 'width',
	),
	array(
		'type'     => 'css',
		'element'  => '.suki-header-section .menu .sub-menu', // scss: header
		'property' => 'max-width',
	),
	// alignwide
	array(
		'type'     => 'css',
		'element'  => '.suki-content-layout-wide .alignwide', // scss: gutenberg
		'property' => 'max-width',
	),
	array(
		'type'     => 'css',
		'element'  => '.suki-content-layout-wide .alignwide', // scss: gutenberg
		'property' => 'left',
		'pattern'  => 'calc( 50% - min( ( $ / 2 ), 50vw - 20px ) );',
	),
	array(
		'type'     => 'css',
		'element'  => '.suki-section-default.suki-content-layout-wide [class$="__inner-container"] > *:not(.alignwide):not(.alignfull)', // scss: gutenberg
		'property' => 'width',
	),
);
$add['content_narrow_width'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-section-narrow > .suki-section-inner > .suki-wrapper', // scss: container
		'property' => 'width',
	),
	array(
		'type'     => 'css',
		'element'  => '.suki-section-narrow.suki-content-layout-wide [class$="__inner-container"] > *:not(.alignwide):not(.alignfull)', // scss: gutenberg
		'property' => 'width',
	),
);

$add['page_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => 'body, #page', // scss: base, container
		'property' => 'background-color',
	),
	array(
		'type'     => 'css',
		'element'  => '::selection', // scss: base
		'property' => 'color',
	),
);

$add['outside_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => 'body.suki-page-layout-boxed',
		'property' => 'background-color',
	),
);
foreach ( array( 'image', 'position', 'size', 'repeat', 'attachment' ) as $prop ) {
	$add['outside_bg_' . $prop ] = array(
		array(
			'type'     => 'css',
			'element'  => 'body.suki-page-layout-boxed',
			'property' => 'background-' . $prop,
			'pattern'  => 'image' == $prop ? 'url($)' : '$',
			'media'    => '@media screen and (min-width: 1024px)',
		),
	);
}

/**
 * ====================================================
 * Header > Element: Logo
 * ====================================================
 */

$add['header_logo_width'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-logo .suki-logo-image', // scss: header
		'property' => 'width',
	),
);
$add['header_mobile_logo_width'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-mobile-logo .suki-logo-image', // scss: header
		'property' => 'width',
	),
);

/**
 * ====================================================
 * Header > Element: Search
 * ====================================================
 */

$add['header_search_bar_width'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-search-bar .search-form', // scss: header
		'property' => 'width',
	),
);
$add['header_search_dropdown_width'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-search-dropdown .sub-menu', // scss: header
		'property' => 'width',
	),
);

/**
 * ====================================================
 * Header > Element: Shopping Cart
 * ====================================================
 */

$add['header_cart_count_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-cart .cart-count', // scss: header
		'property' => 'background-color',
	),
);
$add['header_cart_count_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-cart .cart-count', // scss: header
		'property' => 'color',
	),
);

/**
 * ====================================================
 * Header > Element: Social
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

// Main bar is placed first because top bar and bottom bar can be merged into main bar.
foreach ( array( 'main_bar', 'top_bar', 'bottom_bar' ) as $bar ) {
	$slug = str_replace( '_', '-', $bar );

	if ( 'main_bar' !== $bar ) {
		$add['header_' . $bar . '_merged_gap'] = array(
			array(
				'type'     => 'css',
				'element'  => '.suki-header-main-bar.suki-header-main-bar-with-' . $slug . ' .suki-header-main-bar-row',
				'property' => 'padding-' . ( 'top_bar' === $bar ? 'top' : 'bottom' ),
			),
		);
	}

	// Layout
	$add['header_' . $bar . '_container'] = array(
		array(
			'type'     => 'class',
			'element'  => '.suki-header-' . $slug,
			'pattern'  => 'suki-section-$',
		),
	);
	$add['header_' . $bar . '_height'] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $slug, // scss: header
			'property' => 'height',
		),
	);

	$add['header_' . $bar . '_padding'] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $slug . '-inner', // scss: header
			'property' => 'padding',
		),
	);
	$add['header_' . $bar . '_border'] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $slug . '-inner',
			'property' => 'border-width',
		),
	);
	$add['header_' . $bar . '_items_gutter'] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $slug . ' .suki-header-column > *', // scss: header
			'property' => 'padding',
			'pattern'  => '0 $',
		),
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $slug . '-row', // scss: header
			'property' => 'margin',
			'pattern'  => '0 -$',
		),
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $slug . ' .suki-header-menu .menu-item', // scss: header
			'property' => 'padding',
			'pattern'  => '0 $',
		),
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $slug . '.suki-header-menu-highlight-background .suki-header-menu > .menu > .menu-item > .suki-menu-item-link, .suki-header-' . $slug . '.suki-header-menu-highlight-border-top .suki-header-menu > .menu > .menu-item > .suki-menu-item-link, .suki-header-' . $slug . '.suki-header-menu-highlight-border-bottom .suki-header-menu > .menu > .menu-item > .suki-menu-item-link', // scss: header
			'property' => 'padding',
			'pattern'  => '0 $',
		),
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $slug . '.suki-header-menu-highlight-none .suki-header-menu > .menu > .menu-item > .sub-menu, .suki-header-' . $slug . '.suki-header-menu-highlight-underline .suki-header-menu > .menu > .menu-item > .sub-menu', // scss: header
			'property' => 'margin-left',
			'pattern'  => '-$',
		),
	);

	foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
		$element = '.suki-header-' . $slug;
		$property = str_replace( '_', '-', $prop );

		$add['header_' . $bar . '_' . $prop ] = array(
			array(
				'type'     => 'font_family' === $prop ? 'font' : 'css',
				'element'  => $element,
				'property' => $property,
			),
		);
	}

	foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
		$element = '.suki-header-' . $slug . ' .menu .menu-item > .suki-menu-item-link';
		$property = str_replace( '_', '-', $prop );

		$add['header_' . $bar . '_menu_' . $prop ] = array(
			array(
				'type'     => 'font_family' === $prop ? 'font' : 'css',
				'element'  => $element,
				'property' => $property,
			),
		);
	}

	foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
		$element = '.suki-header-' . $slug . ' .menu > .menu-item .sub-menu .menu-item > .suki-menu-item-link';
		$property = str_replace( '_', '-', $prop );

		$add['header_' . $bar . '_submenu_' . $prop ] = array(
			array(
				'type'     => 'font_family' === $prop ? 'font' : 'css',
				'element'  => $element,
				'property' => $property,
			),
		);
	}

	$add['header_' . $bar . '_icon_size'] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $slug . ' .suki-menu-icon', // scss: header
			'property' => 'font-size',
		),
	);

	$add['header_' . $bar . '_bg_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $slug . '-inner',
			'property' => 'background-color',
		),
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $slug . ' .menu > .menu-item .sub-menu', // scss: header
			'property' => 'background-color',
		),
	);
	$add['header_' . $bar . '_border_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $slug . ' *',
			'property' => 'border-color',
		),
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $slug . ' .menu > .menu-item .sub-menu',
			'property' => 'border-color',
		),
	);
	$add['header_' . $bar . '_text_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $slug,
			'property' => 'color',
		),
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $slug . ' .menu > .menu-item .sub-menu',
			'property' => 'color',
		),
	);
	$add['header_' . $bar . '_link_text_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $slug . ' a:not(.button), .suki-header-' . $slug . ' .suki-toggle, .suki-header-' . $slug . ' .menu > .menu-item .sub-menu a:not(.button)', // scss: header
			'property' => 'color',
		),
	);
	$add['header_' . $bar . '_link_hover_text_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $slug . ' a:not(.button):hover, .suki-header-' . $slug . ' a:not(.button):focus, .suki-header-' . $slug . ' .suki-toggle:hover, .suki-header-' . $slug . ' .suki-toggle:focus, .suki-header-' . $slug . ' .menu > .menu-item .sub-menu a:not(.button):hover, .suki-header-' . $slug . ' .menu > .menu-item .sub-menu a:not(.button):focus', // scss: header
			'property' => 'color',
		),
	);
	$add['header_' . $bar . '_link_active_text_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $slug . ' .current-menu-item > .suki-menu-item-link, .suki-header-' . $slug . ' .current-menu-ancestor > .suki-menu-item-link',
			'property' => 'color',
		),
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $slug . ' .menu > .menu-item .sub-menu .current-menu-item > .suki-menu-item-link, .suki-header-' . $slug . ' .menu > .menu-item .sub-menu .current-menu-ancestor > .suki-menu-item-link',
			'property' => 'color',
		),
	);

	$add['header_' . $bar . '_submenu_bg_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $slug . ' .menu > .menu-item .sub-menu',
			'property' => 'background-color',
		),
	);
	$add['header_' . $bar . '_submenu_border_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $slug . ' .menu > .menu-item .sub-menu',
			'property' => 'border-color',
		),
	);
	$add['header_' . $bar . '_submenu_text_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $slug . ' .menu > .menu-item .sub-menu',
			'property' => 'color',
		),
	);
	$add['header_' . $bar . '_submenu_link_text_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $slug . ' .menu > .menu-item .sub-menu a:not(.button)',
			'property' => 'color',
		),
	);
	$add['header_' . $bar . '_submenu_link_hover_text_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $slug . ' .menu > .menu-item .sub-menu a:not(.button):hover, .suki-header-' . $slug . ' .menu > .menu-item .sub-menu a:not(.button):focus',
			'property' => 'color',
		),
	);
	$add['header_' . $bar . '_submenu_link_active_text_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $slug . ' .menu > .menu-item .sub-menu .current-menu-item > .suki-menu-item-link, .suki-header-' . $slug . ' .menu > .menu-item .sub-menu .current-menu-ancestor > .suki-menu-item-link',
			'property' => 'color',
		),
	);

	$add['header_' . $bar . '_menu_highlight'] = array(
		array(
			'type'     => 'class',
			'element'  => '.suki-header-' . $slug,
			'pattern'  => 'suki-header-menu-highlight-$',
		),
	);

	$add['header_' . $bar . '_menu_hover_highlight_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $slug . ' .suki-header-menu > .menu > .menu-item > .suki-menu-item-link:hover:before, .suki-header-' . $slug . ' .suki-header-menu > .menu > .menu-item > .suki-menu-item-link:focus:before', // scss: header
			'property' => 'background-color',
		),
	);
	$add['header_' . $bar . '_menu_hover_highlight_text_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $slug . ' .suki-header-menu > .menu > .menu-item > .suki-menu-item-link:hover, .suki-header-' . $slug . ' .suki-header-menu > .menu > .menu-item > .suki-menu-item-link:focus',
			'property' => 'color',
		),
	);
	$add['header_' . $bar . '_menu_active_highlight_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $slug . ' .suki-header-menu > .menu > .current-menu-item > .suki-menu-item-link:before, .suki-header-' . $slug . ' .suki-header-menu > .menu > .current-menu-ancestor > .suki-menu-item-link:before',
			'property' => 'background-color',
		),
	);
	$add['header_' . $bar . '_menu_active_highlight_text_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $slug . ' .suki-header-menu > .menu > .current-menu-item > .suki-menu-item-link, .suki-header-' . $slug . ' .suki-header-menu > .menu > .current-menu-ancestor > .suki-menu-item-link',
			'property' => 'color',
		),
	);
}

/**
 * ====================================================
 * Header > Mobile Main Bar
 * ====================================================
 */

$add['header_mobile_main_bar_height'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-mobile-main-bar',
		'property' => 'height',
	),
);
$responsive = array(
	'__tablet' => '@media screen and (max-width: 1023px)',
	'__mobile' => '@media screen and (max-width: 499px)',
);
foreach ( $responsive as $suffix => $media ) {
	$add['header_mobile_main_bar_padding' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-mobile-main-bar-inner',
			'property' => 'padding',
			'media'    => $media,
		),
	);
}
$add['header_mobile_main_bar_border'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-mobile-main-bar-inner',
		'property' => 'border-width',
	),
);
$add['header_mobile_main_bar_items_gutter'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-mobile-main-bar .suki-header-column > *',
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
		'element'  => '.suki-header-mobile-main-bar .suki-header-menu .menu-item',
		'property' => 'padding',
		'pattern'  => '0 $',
	),
);

$add['header_mobile_main_bar_icon_size'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-mobile-main-bar .suki-menu-icon',
		'property' => 'font-size',
	),
);

$add['header_mobile_main_bar_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-mobile-main-bar-inner',
		'property' => 'background-color',
	),
);
$add['header_mobile_main_bar_border_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-mobile-main-bar *',
		'property' => 'border-color',
	),
);
$add['header_mobile_main_bar_link_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-mobile-main-bar a:not(.button), .suki-header-mobile-main-bar .suki-toggle',
		'property' => 'color',
	),
);
$add['header_mobile_main_bar_link_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-mobile-main-bar a:not(.button):hover, .suki-header-mobile-main-bar a:not(.button):focus, .suki-header-mobile-main-bar .suki-toggle:hover, .suki-header-mobile-main-bar .suki-toggle:focus',
		'property' => 'color',
	),
);

/**
 * ====================================================
 * Header > Mobile Popup
 * ====================================================
 */

$add['header_mobile_vertical_bar_position'] = array(
	array(
		'type'     => 'class',
		'element'  => '.suki-header-mobile-vertical:not(.suki-header-mobile-vertical-display-full-screen)',
		'pattern'  => 'suki-header-mobile-vertical-position-$',
	),
);

$add['header_mobile_vertical_bar_full_screen_position'] = array(
	array(
		'type'     => 'class',
		'element'  => '.suki-header-mobile-vertical.suki-header-mobile-vertical-display-full-screen',
		'pattern'  => 'suki-header-mobile-vertical-position-$',
	),
);
$add['header_mobile_vertical_bar_alignment'] = array(
	array(
		'type'     => 'class',
		'element'  => '.suki-header-mobile-vertical',
		'pattern'  => 'suki-text-align-$',
	),
);

$add['header_mobile_vertical_bar_width'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-mobile-vertical-bar', // scss: header
		'property' => 'width',
	),
	array(
		'type'     => 'css',
		'element'  => '.suki-header-mobile-vertical.suki-header-mobile-vertical-display-full-screen .suki-header-section-vertical-column', // scss: header
		'property' => 'width',
	),
);
$add['header_mobile_vertical_bar_padding'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-mobile-vertical-bar', // scss: header
		'property' => 'padding',
	),
);

$add['header_mobile_vertical_bar_items_gutter'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-mobile-vertical-bar .suki-header-section-vertical-row > *', // scss: header
		'property' => 'padding',
		'pattern'  => '$ 0',
	),
	array(
		'type'     => 'css',
		'element'  => '.suki-header-mobile-vertical-bar .suki-header-section-vertical-column', // scss: header
		'property' => 'margin',
		'pattern'  => '-$ 0',
	),
);

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$add['header_mobile_vertical_bar_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => '.suki-header-mobile-vertical-bar',
			'property' => str_replace( '_', '-', $prop),
		),
	);
}

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$add['header_mobile_vertical_bar_menu_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => '.suki-header-mobile-vertical-bar .menu .menu-item > .suki-menu-item-link, .suki-header-mobile-vertical-bar .menu-item > .suki-toggle',
			'property' => str_replace( '_', '-', $prop),
		),
	);
}

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$add['header_mobile_vertical_bar_submenu_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => '.suki-header-mobile-vertical-bar .menu .sub-menu .menu-item > .suki-menu-item-link, .suki-header-mobile-vertical-bar .sub-menu .menu-item > .suki-toggle',
			'property' => str_replace( '_', '-', $prop),
		),
	);
}

$add['header_mobile_vertical_bar_icon_size'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-mobile-vertical-bar .suki-menu-icon',
		'property' => 'font-size',
	),
);

$add['header_mobile_vertical_bar_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-mobile-vertical-bar',
		'property' => 'background-color',
	),
);
$add['header_mobile_vertical_bar_border_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-mobile-vertical-bar *',
		'property' => 'border-color',
	),
);
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
		'element'  => '.suki-header-mobile-vertical-bar a:not(.button), .suki-header-mobile-vertical-bar .suki-toggle, .suki-header-mobile-vertical-bar .menu .sub-menu a:not(.button), .suki-header-mobile-vertical-bar .menu .sub-menu .suki-toggle', // scss: header
		'property' => 'color',
	),
);
$add['header_mobile_vertical_bar_link_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-mobile-vertical-bar a:not(.button):hover, .suki-header-mobile-vertical-bar a:not(.button):focus, .suki-header-mobile-vertical-bar .suki-toggle:hover, .suki-header-mobile-vertical-bar .suki-toggle:focus, .suki-header-mobile-vertical-bar .menu .sub-menu a:not(.button):hover, .suki-header-mobile-vertical-bar .menu .sub-menu a:not(.button):focus, .suki-header-mobile-vertical-bar .menu .sub-menu .suki-toggle:hover, .suki-header-mobile-vertical-bar .menu .sub-menu .suki-toggle:focus', // scss: header
		'property' => 'color',
	),
);
$add['header_mobile_vertical_bar_link_active_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-mobile-vertical-bar .current-menu-item > .suki-menu-item-link, .suki-header-mobile-vertical-bar .current-menu-ancestor > .suki-menu-item-link',
		'property' => 'color',
	),
);

/**
 * ====================================================
 * Page Header
 * ====================================================
 */

$add['hero_container'] = array(
	array(
		'type'     => 'class',
		'element'  => '.suki-hero',
		'pattern'  => 'suki-section-$',
	),
);
$responsive = array(
	''         => '',
	'__tablet' => '@media screen and (max-width: 1023px)',
	'__mobile' => '@media screen and (max-width: 499px)',
);
foreach ( $responsive as $suffix => $media ) {
	$add['hero_height' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-hero-inner', // scss: container
			'property' => 'min-height',
			'media'    => $media,
		),
	);
}
foreach ( $responsive as $suffix => $media ) {
	$add['hero_padding' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-hero-inner', // scss: container
			'property' => 'padding',
			'media'    => $media,
		),
	);
}
$add['hero_border'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-hero-inner',
		'property' => 'border-width',
	),
);

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$element = '.suki-hero .page-title, .suki-hero .entry-title';
	$property = str_replace( '_', '-', $prop );

	$add['hero_title_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element,
			'property' => $property,
		),
	);
	if ( in_array( $prop, array( 'font_size', 'line_height', 'letter_spacing' ) ) ) {
		$add['hero_title_' . $prop . '__tablet'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 1023px)',
			),
		);
		$add['hero_title_' . $prop . '__mobile'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 499px)',
			),
		);
	}
}

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$element = '.suki-hero';
	$property = str_replace( '_', '-', $prop );

	$add['hero_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element,
			'property' => $property,
		),
	);
	if ( in_array( $prop, array( 'font_size', 'line_height', 'letter_spacing' ) ) ) {
		$add['hero_' . $prop . '__tablet'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 1023px)',
			),
		);
		$add['hero_' . $prop . '__mobile'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 499px)',
			),
		);
	}
}

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$element = '.suki-hero .suki-breadcrumb';
	$property = str_replace( '_', '-', $prop );

	$add['hero_breadcrumb_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element,
			'property' => $property,
		),
	);
	if ( in_array( $prop, array( 'font_size', 'line_height', 'letter_spacing' ) ) ) {
		$add['hero_breadcrumb_' . $prop . '__tablet'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 1023px)',
			),
		);
		$add['hero_breadcrumb_' . $prop . '__mobile'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 499px)',
			),
		);
	}
}

$add['hero_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-hero-inner', // scss: container
		'property' => 'background-color',
	),
);
$add['hero_border_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-hero *',
		'property' => 'border-color',
	),
);
$add['hero_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-hero',
		'property' => 'color',
	),
);
$add['hero_link_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-hero a',
		'property' => 'color',
	),
);
$add['hero_link_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-hero a:hover, .suki-hero a:focus',
		'property' => 'color',
	),
);
$add['hero_title_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-hero .page-title, .suki-hero .entry-title',
		'property' => 'color',
	),
);
$add['hero_breadcrumb_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-hero .suki-breadcrumb',
		'property' => 'color',
	),
);
$add['hero_breadcrumb_link_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-hero .suki-breadcrumb a',
		'property' => 'color',
	),
);
$add['hero_breadcrumb_link_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-hero .suki-breadcrumb a:hover, .suki-hero .suki-breadcrumb a:focus',
		'property' => 'color',
	),
);

$add['hero_bg_attachment'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-hero-inner', // scss: container
		'property' => 'background-attachment',
	),
);

$add['hero_bg_overlay_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-hero-inner:before', // scss: container
		'property' => 'background-color',
	),
);

/**
 * ====================================================
 * Content & Sidebar > Section
 * ====================================================
 */

$responsive = array(
	''         => '',
	'__tablet' => '@media screen and (max-width: 1023px)',
	'__mobile' => '@media screen and (max-width: 499px)',
);
foreach ( $responsive as $suffix => $media ) {
	$add['content_padding' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-content-inner', // scss: container
			'property' => 'padding',
			'media'    => $media,
		),
	);
}

/**
 * ====================================================
 * Content & Sidebar > Main Column
 * ====================================================
 */

$responsive = array(
	''         => '',
	'__tablet' => '@media screen and (max-width: 1023px)',
	'__mobile' => '@media screen and (max-width: 499px)',
);
foreach ( $responsive as $suffix => $media ) {
	$add['content_main_padding' . $suffix ] = array(
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
			'element'  => '.entry-layout-default .entry-thumbnail.suki-entry-thumbnail-ignore-padding',
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
			'element'  => '.entry-layout-default .entry-thumbnail.suki-entry-thumbnail-ignore-padding',
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
$add['content_main_border'] = array(
	array(
		'type'     => 'css',
		'element'  => '.content-area .site-main',
		'property' => 'border-width',
	),
);

$add['content_main_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.content-area .site-main',
		'property' => 'background-color',
	),
);
$add['content_main_border_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.content-area .site-main',
		'property' => 'border-color',
	),
);

/**
 * ====================================================
 * Content & Sidebar > Sidebar Area
 * ====================================================
 */

$add['sidebar_width'] = array(
	array(
		'type'     => 'css',
		'element'  => '.sidebar', // scss: container
		'property' => 'flex-basis',
	),
);
$add['sidebar_gap'] = array(
	array(
		'type'     => 'css',
		'element'  => '.ltr .suki-content-layout-right-sidebar .sidebar', // scss: container
		'property' => 'margin-left',
	),
	array(
		'type'     => 'css',
		'element'  => '.rtl .suki-content-layout-right-sidebar .sidebar', // scss: container
		'property' => 'margin-right',
	),
	array(
		'type'     => 'css',
		'element'  => '.ltr .suki-content-layout-left-sidebar .sidebar', // scss: container
		'property' => 'margin-right',
	),
	array(
		'type'     => 'css',
		'element'  => '.rtl .suki-content-layout-left-sidebar .sidebar', // scss: container
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
		'element'  => '.sidebar .widget', // scss: widgets
		'property' => 'margin-bottom',
	),
);

$responsive = array(
	''         => '',
	'__tablet' => '@media screen and (max-width: 1023px)',
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
$add['sidebar_border_radius'] = array(
	array(
		'type'     => 'css',
		'element'  => '.sidebar.suki-sidebar-widgets-mode-merged .sidebar-inner, .sidebar.suki-sidebar-widgets-mode-separated .widget',
		'property' => 'border-radius',
	),
);

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$element = '.sidebar';
	$property = str_replace( '_', '-', $prop );

	$add['sidebar_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element,
			'property' => $property,
		),
	);
	
	if ( in_array( $prop, array( 'font_size', 'line_height', 'letter_spacing' ) ) ) {
		$add['sidebar_' . $prop . '__tablet'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 1023px)',
			),
		);
		$add['sidebar_' . $prop . '__mobile'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 499px)',
			),
		);
	}
}

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$element = '.sidebar .widget_block > [class^="wp-block-"] > h2:first-child, .sidebar .widget_block > [class^="wp-block-"] > h3:first-child, .sidebar .widget_block > [class^="wp-block-"] > h4:first-child, .sidebar .widget_block > [class^="wp-block-"] > h5:first-child, .sidebar .widget_block > [class^="wp-block-"] > h6:first-child, .sidebar .widget-title';
	$property = str_replace( '_', '-', $prop );

	$add['sidebar_widget_title_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element,
			'property' => $property,
		),
	);
	
	if ( in_array( $prop, array( 'font_size', 'line_height', 'letter_spacing' ) ) ) {
		$add['sidebar_widget_title_' . $prop . '__tablet'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 1023px)',
			),
		);
		$add['sidebar_widget_title_' . $prop . '__mobile'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 499px)',
			),
		);
	}
}

$add['sidebar_widget_title_alignment'] = array(
	array(
		'type'     => 'class',
		'element'  => '.sidebar',
		'pattern'  => 'suki-widget-title-alignment-$',
	),
);
$add['sidebar_widget_title_decoration'] = array(
	array(
		'type'     => 'class',
		'element'  => '.sidebar',
		'pattern'  => 'suki-widget-title-decoration-$',
	),
);

$add['sidebar_shadow'] = array(
	array(
		'type'     => 'css',
		'element'  => '.sidebar.suki-sidebar-widgets-mode-merged .sidebar-inner, .sidebar.suki-sidebar-widgets-mode-separated .widget',
		'property' => 'box-shadow',
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
		'element'  => '.sidebar *',
		'property' => 'border-color',
	),
);
$add['sidebar_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.sidebar',
		'property' => 'color',
	),
);
$add['sidebar_link_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.sidebar a',
		'property' => 'color',
	),
);
$add['sidebar_link_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.sidebar a:hover, .sidebar a:focus',
		'property' => 'color',
	),
);
$add['sidebar_widget_title_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.sidebar .widget_block > [class^="wp-block-"] > h2:first-child, .sidebar .widget_block > [class^="wp-block-"] > h3:first-child, .sidebar .widget_block > [class^="wp-block-"] > h4:first-child, .sidebar .widget_block > [class^="wp-block-"] > h5:first-child, .sidebar .widget_block > [class^="wp-block-"] > h6:first-child, .sidebar .widget-title',
		'property' => 'color',
	),
);
$add['sidebar_widget_title_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.sidebar.suki-widget-title-decoration-box .widget_block > [class^="wp-block-"] > h2:first-child, .sidebar.suki-widget-title-decoration-box .widget_block > [class^="wp-block-"] > h3:first-child, .sidebar.suki-widget-title-decoration-box .widget_block > [class^="wp-block-"] > h4:first-child, .sidebar.suki-widget-title-decoration-box .widget_block > [class^="wp-block-"] > h5:first-child, .sidebar.suki-widget-title-decoration-box .widget_block > [class^="wp-block-"] > h6:first-child, .sidebar.suki-widget-title-decoration-box .widget-title',
		'property' => 'background-color',
	),
);
$add['sidebar_widget_title_border_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.sidebar .widget_block > [class^="wp-block-"] > h2:first-child, .sidebar .widget_block > [class^="wp-block-"] > h3:first-child, .sidebar .widget_block > [class^="wp-block-"] > h4:first-child, .sidebar .widget_block > [class^="wp-block-"] > h5:first-child, .sidebar .widget_block > [class^="wp-block-"] > h6:first-child, .sidebar .widget-title',
		'property' => 'border-color',
	),
);

/**
 * ====================================================
 * Footer > Widgets Bar
 * ====================================================
 */

$add['footer_widgets_bar_container'] = array(
	array(
		'type'     => 'class',
		'element'  => '.suki-footer-widgets-bar',
		'pattern'  => 'suki-section-$',
	),
);
$responsive = array(
	''         => '',
	'__tablet' => '@media screen and (max-width: 1023px)',
	'__mobile' => '@media screen and (max-width: 499px)',
);
foreach ( $responsive as $suffix => $media ) {
	$add['footer_widgets_bar_padding' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-footer-widgets-bar-inner',
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
$add['footer_widgets_bar_columns_gutter'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-widgets-bar-column', // scss: footer
		'property' => 'padding',
		'pattern'  => '0 $',
	),
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-widgets-bar-row', // scss: footer
		'property' => 'margin-left',
		'pattern'  => '-$',
	),
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-widgets-bar-row', // scss: footer
		'property' => 'margin-right',
		'pattern'  => '-$',
	),
);
$add['footer_widgets_bar_widgets_gap'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-widgets-bar .widget', // scss: footer
		'property' => 'margin-bottom',
	),
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-widgets-bar-row', // scss: footer
		'property' => 'margin-bottom',
		'pattern'  => '-$',
	),
);

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$element = '.suki-footer-widgets-bar';
	$property = str_replace( '_', '-', $prop );

	$add['footer_widgets_bar_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element,
			'property' => $property,
		),
	);
	
	if ( in_array( $prop, array( 'font_size', 'line_height', 'letter_spacing' ) ) ) {
		$add['footer_widgets_bar_' . $prop . '__tablet'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 1023px)',
			),
		);
		$add['footer_widgets_bar_' . $prop . '__mobile'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 499px)',
			),
		);
	}
}

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$element = '.suki-footer-widgets-bar .widget_block > [class^="wp-block-"] > h2:first-child, .suki-footer-widgets-bar .widget_block > [class^="wp-block-"] > h3:first-child, .suki-footer-widgets-bar .widget_block > [class^="wp-block-"] > h4:first-child, .suki-footer-widgets-bar .widget_block > [class^="wp-block-"] > h5:first-child, .suki-footer-widgets-bar .widget_block > [class^="wp-block-"] > h6:first-child, .suki-footer-widgets-bar .widget-title';
	$property = str_replace( '_', '-', $prop );

	$add['footer_widgets_bar_widget_title_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element,
			'property' => $property,
		),
	);
	
	if ( in_array( $prop, array( 'font_size', 'line_height', 'letter_spacing' ) ) ) {
		$add['footer_widgets_bar_widget_title_' . $prop . '__tablet'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 1023px)',
			),
		);
		$add['footer_widgets_bar_widget_title_' . $prop . '__mobile'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 499px)',
			),
		);
	}
}

$add['footer_widgets_bar_widget_title_alignment'] = array(
	array(
		'type'     => 'class',
		'element'  => '.suki-footer-widgets-bar',
		'pattern'  => 'suki-widget-title-alignment-$',
	),
);
$add['footer_widgets_bar_widget_title_decoration'] = array(
	array(
		'type'     => 'class',
		'element'  => '.suki-footer-widgets-bar',
		'pattern'  => 'suki-widget-title-decoration-$',
	),
);

$add['footer_widgets_bar_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-widgets-bar-inner',
		'property' => 'background-color',
	),
);
$add['footer_widgets_bar_border_color'] = array(
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
		'element'  => '.suki-footer-widgets-bar .widget_block > [class^="wp-block-"] > h2:first-child, .suki-footer-widgets-bar .widget_block > [class^="wp-block-"] > h3:first-child, .suki-footer-widgets-bar .widget_block > [class^="wp-block-"] > h4:first-child, .suki-footer-widgets-bar .widget_block > [class^="wp-block-"] > h5:first-child, .suki-footer-widgets-bar .widget_block > [class^="wp-block-"] > h6:first-child, .suki-footer-widgets-bar .widget-title',
		'property' => 'color',
	),
);
$add['footer_widgets_bar_widget_title_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-widgets-bar.suki-widget-title-decoration-box .widget_block > [class^="wp-block-"] > h2:first-child, .suki-footer-widgets-bar.suki-widget-title-decoration-box .widget_block > [class^="wp-block-"] > h3:first-child, .suki-footer-widgets-bar.suki-widget-title-decoration-box .widget_block > [class^="wp-block-"] > h4:first-child, .suki-footer-widgets-bar.suki-widget-title-decoration-box .widget_block > [class^="wp-block-"] > h5:first-child, .suki-footer-widgets-bar.suki-widget-title-decoration-box .widget_block > [class^="wp-block-"] > h6:first-child, .suki-footer-widgets-bar.suki-widget-title-decoration-box .widget-title',
		'property' => 'background-color',
	),
);
$add['footer_widgets_bar_widget_title_border_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-widgets-bar .widget_block > [class^="wp-block-"] > h2:first-child, .suki-footer-widgets-bar .widget_block > [class^="wp-block-"] > h3:first-child, .suki-footer-widgets-bar .widget_block > [class^="wp-block-"] > h4:first-child, .suki-footer-widgets-bar .widget_block > [class^="wp-block-"] > h5:first-child, .suki-footer-widgets-bar .widget_block > [class^="wp-block-"] > h6:first-child, .suki-footer-widgets-bar .widget-title',
		'property' => 'border-color',
	),
);

/**
 * ====================================================
 * Footer > Bottom Bar
 * ====================================================
 */

$add['footer_bottom_bar_merged_gap'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-bottom-bar.suki-section-merged',
		'property' => 'margin-top',
	),
);

$add['footer_bottom_bar_container'] = array(
	array(
		'type'     => 'class',
		'element'  => '.suki-footer-bottom-bar',
		'pattern'  => 'suki-section-$',
	),
);

$responsive = array(
	''         => '',
	'__tablet' => '@media screen and (max-width: 1023px)',
	'__mobile' => '@media screen and (max-width: 499px)',
);
foreach ( $responsive as $suffix => $media ) {
	$add['footer_bottom_bar_padding' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-footer-bottom-bar-inner', // scss: footer
			'property' => 'padding',
			'media'    => $media,
		),
	);
}
$add['footer_bottom_bar_border'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-bottom-bar-inner', // scss: footer
		'property' => 'border-width',
	),
);
$add['footer_bottom_bar_items_gutter'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-bottom-bar-row', // scss: footer
		'property' => 'margin',
		'pattern'  => '0 -$',
	),
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-bottom-bar .suki-footer-bottom-bar-column > *', // scss: footer
		'property' => 'padding',
		'pattern'  => '0 $',
	),
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-menu ul li', // scss: footer
		'property' => 'padding',
		'pattern'  => '0 $',
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

	if ( in_array( $prop, array( 'font_size', 'line_height', 'letter_spacing' ) ) ) {
		$add['footer_bottom_bar_' . $prop . '__tablet'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 1023px)',
			),
		);
		$add['footer_bottom_bar_' . $prop . '__mobile'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 499px)',
			),
		);
	}
}

$add['footer_bottom_bar_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-bottom-bar-inner', // scss: footer
		'property' => 'background-color',
	),
);
$add['footer_bottom_bar_border_color'] = array(
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
 * Footer > Scroll To Top
 * ====================================================
 */

$add['scroll_to_top_display'] = array(
	array(
		'type'     => 'class',
		'element'  => '.suki-scroll-to-top',
		'pattern'  => 'suki-scroll-to-top-display-$',
	),
);
$add['scroll_to_top_position'] = array(
	array(
		'type'     => 'class',
		'element'  => '.suki-scroll-to-top',
		'pattern'  => 'suki-scroll-to-top-position-$',
	),
);

$responsive = array(
	''         => '',
	'__tablet' => '@media screen and (max-width: 1023px)',
	'__mobile' => '@media screen and (max-width: 499px)',
);
foreach ( $responsive as $suffix => $media ) {
	$add['scroll_to_top_h_offset' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-scroll-to-top',
			'property' => 'margin-left',
			'media'    => $media,
		),
		array(
			'type'     => 'css',
			'element'  => '.suki-scroll-to-top',
			'property' => 'margin-right',
			'media'    => $media,
		),
	);

	$add['scroll_to_top_v_offset' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-scroll-to-top',
			'property' => 'margin-bottom',
			'media'    => $media,
		),
	);

	$add['scroll_to_top_icon_size' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-scroll-to-top',
			'property' => 'font-size',
			'media'    => $media,
		),
	);

	$add['scroll_to_top_padding' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-scroll-to-top',
			'property' => 'padding',
			'media'    => $media,
		),
	);

	$add['scroll_to_top_border_radius' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-scroll-to-top',
			'property' => 'border-radius',
			'media'    => $media,
		),
	);
}

$add['scroll_to_top_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-scroll-to-top',
		'property' => 'background-color',
	),
	array(
		'type'     => 'css',
		'element'  => '.suki-scroll-to-top:hover, .suki-scroll-to-top:focus',
		'property' => 'background-color',
	),
);
$add['scroll_to_top_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-scroll-to-top',
		'property' => 'color',
	),
	array(
		'type'     => 'css',
		'element'  => '.suki-scroll-to-top:hover, .suki-scroll-to-top:focus',
		'property' => 'color',
	),
);
$add['scroll_to_top_hover_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-scroll-to-top:hover, .suki-scroll-to-top:focus',
		'property' => 'background-color',
	),
);
$add['scroll_to_top_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-scroll-to-top:hover, .suki-scroll-to-top:focus',
		'property' => 'color',
	),
);

/**
 * ====================================================
 * Blog > Posts Archive Page
 * ====================================================
 */

$add['post_archive_content_header_alignment'] = array(
	array(
		'type'     => 'class',
		'element'  => 'body.blog .content-header, body.category .content-header, body.tag .content-header, body.author .content-header, body.date .content-header',
		'pattern'  => 'suki-text-align-$',
	),
);

/**
 * ====================================================
 * Blog > Post Layout: Default
 * ====================================================
 */

$add['blog_index_default_items_gap'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-loop-default .entry', // scss: entry
		'property' => 'margin-bottom',
	),
);

$add['entry_header_alignment'] = array(
	array(
		'type'     => 'class',
		'element'  => '.entry-layout-default .entry-header',
		'pattern'  => 'suki-text-align-$',
	),
);

$add['entry_footer_alignment'] = array(
	array(
		'type'     => 'class',
		'element'  => '.entry-layout-default .entry-footer',
		'pattern'  => 'suki-text-align-$',
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
$add['blog_index_grid_rows_gutter'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-loop-grid', // scss: entry
		'property' => 'margin-top',
		'pattern'  => '-$',
	),
	array(
		'type'     => 'css',
		'element'  => '.suki-loop-grid', // scss: entry
		'property' => 'margin-bottom',
		'pattern'  => '-$',
	),
	array(
		'type'     => 'css',
		'element'  => '.suki-loop-grid > .entry', // scss: entry
		'property' => 'padding-top',
	),
	array(
		'type'     => 'css',
		'element'  => '.suki-loop-grid > .entry', // scss: entry
		'property' => 'padding-bottom',
	),
);
$add['blog_index_grid_columns_gutter'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-loop-grid', // scss: entry
		'property' => 'margin-left',
		'pattern'  => '-$',
	),
	array(
		'type'     => 'css',
		'element'  => '.suki-loop-grid', // scss: entry
		'property' => 'margin-right',
		'pattern'  => '-$',
	),
	array(
		'type'     => 'css',
		'element'  => '.suki-loop-grid > .entry', // scss: entry
		'property' => 'padding-left',
	),
	array(
		'type'     => 'css',
		'element'  => '.suki-loop-grid > .entry', // scss: entry
		'property' => 'padding-right',
	),
);

$responsive = array(
	''         => '',
	'__tablet' => '@media screen and (max-width: 1023px)',
	'__mobile' => '@media screen and (max-width: 499px)',
);
foreach ( $responsive as $suffix => $media ) {
	$add['entry_grid_padding' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.entry-layout-grid .entry-wrapper',
			'property' => 'padding',
			'media'    => $media,
		),
		array(
			'type'     => 'css',
			'element'  => '.entry-layout-grid .entry-thumbnail.suki-entry-thumbnail-ignore-padding:first-child',
			'property' => 'margin-top',
			'pattern'  => '-$ !important',
			'function' => array(
				'name' => 'explode_value',
				'args' => array( 0 ), // 1st part = top
			),
			'media'    => $media,
		),
		array(
			'type'     => 'css',
			'element'  => '.entry-layout-grid .entry-thumbnail.suki-entry-thumbnail-ignore-padding',
			'property' => 'margin-right',
			'pattern'  => '-$ !important',
			'function' => array(
				'name' => 'explode_value',
				'args' => array( 1 ), // 2nd part = right
			),
			'media'    => $media,
		),
		array(
			'type'     => 'css',
			'element'  => '.entry-layout-grid .entry-thumbnail.suki-entry-thumbnail-ignore-padding',
			'property' => 'margin-left',
			'pattern'  => '-$ !important',
			'function' => array(
				'name' => 'explode_value',
				'args' => array( 3 ), // 4rd part = left
			),
			'media'    => $media,
		),
	);
}
$add['entry_grid_border'] = array(
	array(
		'type'     => 'css',
		'element'  => '.entry-layout-grid .entry-wrapper',
		'property' => 'border-width',
	),
);
$add['entry_grid_border_radius'] = array(
	array(
		'type'     => 'css',
		'element'  => '.entry-layout-grid .entry-wrapper',
		'property' => 'border-radius',
	),
);

$add['entry_grid_header_alignment'] = array(
	array(
		'type'     => 'class',
		'element'  => '.entry-layout-grid .entry-header',
		'pattern'  => 'suki-text-align-$',
	),
);

$add['entry_grid_footer_alignment'] = array(
	array(
		'type'     => 'class',
		'element'  => '.entry-layout-grid .entry-footer',
		'pattern'  => 'suki-text-align-$',
	),
);

$add['entry_grid_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.entry-layout-grid .entry-wrapper',
		'property' => 'background-color',
	),
);

$add['entry_grid_border_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.entry-layout-grid .entry-wrapper',
		'property' => 'border-color',
	),
);

$add['entry_grid_shadow'] = array(
	array(
		'type'     => 'css',
		'element'  => '.entry-layout-grid .entry-wrapper',
		'property' => 'box-shadow',
	),
);

/**
 * ====================================================
 * Blog > Single Post Page
 * ====================================================
 */

$add['post_single_content_header_alignment'] = array(
	array(
		'type'     => 'class',
		'element'  => 'body.single-post .content-header',
		'pattern'  => 'suki-text-align-$',
	),
);

$add['post_single_content_footer_alignment'] = array(
	array(
		'type'     => 'class',
		'element'  => '.entry-single .entry-footer',
		'pattern'  => 'suki-text-align-$',
	),
);

/**
 * ====================================================
 * Other Pages > Static Page
 * ====================================================
 */

$add['page_single_content_header_alignment'] = array(
	array(
		'type'     => 'class',
		'element'  => 'body.page .content-header',
		'pattern'  => 'suki-text-align-$',
	),
);

/**
 * ====================================================
 * Other Pages > Search Results Page
 * ====================================================
 */

$add['search_results_content_header_alignment'] = array(
	array(
		'type'     => 'class',
		'element'  => 'body.search-results:not(.archive) .content-header',
		'pattern'  => 'suki-text-align-$',
	),
);

/**
 * ====================================================
 * Other Pages > [Custom Post Type] Archive Page
 * ====================================================
 */

foreach ( suki_get_post_types_for_page_settings( 'custom' ) as $post_type ) {
	$element = 'body.post-type-archive-' . $post_type . ' .content-header';
	foreach ( get_object_taxonomies( $post_type ) as $tax ) {
		$element .= ', body.tax-' . $tax . ' .content-header';
	}

	$add[ $post_type . '_archive_content_header_alignment'] = array(
		array(
			'type'     => 'class',
			'element'  => $element,
			'pattern'  => 'suki-text-align-$',
		),
	);
}

/**
 * ====================================================
 * Other Pages > Single [Custom Post Types] Page
 * ====================================================
 */

foreach ( suki_get_post_types_for_page_settings( 'custom' ) as $post_type ) {
	$add[ $post_type . '_single_content_header_alignment'] = array(
		array(
			'type'     => 'class',
			'element'  => 'body.single-' . $post_type . ' .content-header',
			'pattern'  => 'suki-text-align-$',
		),
	);
}

return $add;