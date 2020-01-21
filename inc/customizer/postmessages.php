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
 * Global Settings > Color Palette
 * ====================================================
 */

for ( $i = 1; $i <= 8; $i++ ) {
	$add['color_palette_' . $i ] = array(
		array(
			'type'     => 'css',
			'element'  => '.has-suki-color-' . $i . '-background-color',
			'property' => 'background-color',
		),
		array(
			'type'     => 'css',
			'element'  => '.has-suki-color-' . $i . '-color',
			'property' => 'color',
		),
	);
}

/**
 * ====================================================
 * General Styles > Body (Base)
 * ====================================================
 */

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$element = 'html';
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
	'element'  => '.has-medium-text-size',
	'property' => 'line-height',
	'pattern'  => 'calc( 0.95 * $ )',
);
$add['body_line_height'][] = array(
	'type'     => 'css',
	'element'  => '.has-large-text-size',
	'property' => 'line-height',
	'pattern'  => 'calc( 0.875 * $ )',
);
$add['body_line_height'][] = array(
	'type'     => 'css',
	'element'  => '.has-larger-text-size',
	'property' => 'line-height',
	'pattern'  => 'calc( 0.8 * $ )',
);

// Drop cap
$add['body_line_height'][] = array(
	'type'     => 'css',
	'element'  => 'p.has-drop-cap:not(:focus):first-letter',
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
		'pattern'  => 'suki-font-smoothing-$',
	),
);

$add['body_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => 'body',
		'property' => 'color',
	),
);

/**
 * ====================================================
 * General Styles > Border & Subtle Background
 * ====================================================
 */

$add['subtle_color'] = array(
	array(
		'type'     => 'css',
		'element'  => 'pre, code, .page-header, .tagcloud a, .navigation.pagination .current, span.select2-container .select2-selection--multiple .select2-selection__rendered li.select2-selection__choice, .wp-block-table.is-style-stripes tr:nth-child(odd)',
		'property' => 'background-color',
	),
);
$add['border_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '*',
		'property' => 'border-color',
	),
);

/**
 * ====================================================
 * General Styles > Link
 * ====================================================
 */

$add['link_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => 'a, .suki-toggle',
		'property' => 'color',
	),
	array(
		'type'     => 'css',
		'element'  => '.navigation .nav-links a:hover, .navigation .nav-links a:focus, .tagcloud a:hover, .tagcloud a:focus, .reply:hover, .reply:focus',
		'property' => 'color',
	),
	array(
		'type'     => 'css',
		'element'  => '.entry-meta a:hover, .entry-meta a:focus, .comment-metadata a:hover, .comment-metadata a:focus, .widget .post-date a:hover, .widget .post-date a:focus, .widget_rss .rss-date a:hover, .widget_rss .rss-date a:focus',
		'property' => 'color',
	),
	array(
		'type'     => 'css',
		'element'  => 'h1 a:hover, h1 a:focus, .h1 a:hover, .h1 a:focus, h2 a:hover, h2 a:focus, .h2 a:hover, .h2 a:focus, h3 a:hover, h3 a:focus, .h3 a:hover, .h3 a:focus, h4 a:hover, h4 a:focus, .h4 a:hover, .h4 a:focus, h5 a:hover, h5 a:focus, .h5 a:hover, .h5 a:focus, h6 a:hover, h6 a:focus, .h6 a:hover, .h6 a:focus, .comment-author a:hover, .comment-author a:focus, .entry-author-name a:hover, .entry-author-name a:focus',
		'property' => 'color',
	),
	array(
		'type'     => 'css',
		'element'  => '.suki-header-section a:not(.button):hover, .suki-header-section a:not(.button):focus, .suki-header-section .suki-toggle:hover, .suki-header-section .suki-toggle:focus, .suki-header-section .menu .sub-menu a:not(.button):hover, .suki-header-section .menu .sub-menu a:not(.button):focus, .suki-header-section .menu .sub-menu .suki-toggle:hover, .suki-header-section .menu .sub-menu .suki-toggle:focus, .suki-header-section-vertical a:not(.button):hover, .suki-header-section-vertical a:not(.button):focus, .suki-header-section-vertical .suki-toggle:hover, .suki-header-section-vertical .suki-toggle:focus, .suki-header-section-vertical .menu .sub-menu a:not(.button):hover, .suki-header-section-vertical .menu .sub-menu a:not(.button):focus, .suki-header-section-vertical .menu .sub-menu .suki-toggle:hover, .suki-header-section-vertical .menu .sub-menu .suki-toggle:focus',
		'property' => 'color',
	),
	array(
		'type'     => 'css',
		'element'  => '::selection',
		'property' => 'background-color',
	),
	array(
		'type'     => 'css',
		'element'  => '.suki-header-shopping-cart .shopping-cart-count',
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

/**
 * ====================================================
 * General Styles > Headings
 * ====================================================
 */

for ( $i = 1; $i <= 4; $i++ ) {
	foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
		$property = str_replace( '_', '-', $prop );

		$rules = array();

		$rules[] = array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => 'h' . $i . ', .h' . $i,
			'property' => $property,
		);

		// Add additional rules
		switch ( $i ) {
			case 1:
				// Styles that inherit h1 by default
				$rules[] = array(
					'type'     => 'css',
					'element'  => '.title, .entry-title, .page-title',
					'property' => $property,
				);
				break;

			case 3:
				// Styles that inherit h3 by default
				$rules[] = array(
					'type'     => 'css',
					'element'  => 'legend, .small-title, .entry-small-title, .comments-title, .comment-reply-title, .page-header .page-title',
					'property' => $property,
				);
				break;

			case 4:
				// Styles that inherit h4 by default
				$rules[] = array(
					'type'     => 'css',
					'element'  => '.widget-title',
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
		'element'  => 'h1, .h1, h2, .h2, h3, .h3, h4, .h4, h5, .h5, h6, .h6, h1 a, .h1 a, h2 a, .h2 a, h3 a, .h3 a, h4 a, .h4 a, h5 a, .h5 a, h6 a, .h6 a, .comment-author a, .entry-author-name, .entry-author-name a',
		'property' => 'color',
	),
	array(
		'type'     => 'css',
		'element'  => 'p.has-drop-cap:not(:focus):first-letter',
		'property' => 'color',
	),
	array(
		'type'     => 'css',
		'element'  => '.suki-header-section a:not(.button), .suki-header-section .suki-toggle, .suki-header-section .menu .sub-menu a:not(.button), .suki-header-section .menu .sub-menu .suki-toggle, .suki-header-section-vertical a:not(.button), .suki-header-section-vertical .suki-toggle, .suki-header-section-vertical .menu .sub-menu a:not(.button), .suki-header-section-vertical .menu .sub-menu .suki-toggle',
		'property' => 'color',
	),
	array(
		'type'     => 'css',
		'element'  => '.navigation .nav-links .current',
		'property' => 'color',
	),
	array(
		'type'     => 'css',
		'element'  => 'table th',
		'property' => 'color',
	),
);
$add['heading_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => 'h1 a:hover, h1 a:focus, .h1 a:hover, .h1 a:focus, h2 a:hover, h2 a:focus, .h2 a:hover, .h2 a:focus, h3 a:hover, h3 a:focus, .h3 a:hover, .h3 a:focus, h4 a:hover, h4 a:focus, .h4 a:hover, .h4 a:focus, h5 a:hover, h5 a:focus, .h5 a:hover, .h5 a:focus, h6 a:hover, h6 a:focus, .h6 a:hover, .h6 a:focus, .comment-author a:hover, .comment-author a:focus, .entry-author-name a:hover, .entry-author-name a:focus',
		'property' => 'color',
	),
);

/**
 * ====================================================
 * General Styles > Blockquote
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
 * General Styles > Button
 * ====================================================
 */

$add['button_padding'] = array(
	array(
		'type'     => 'css',
		'element'  => 'button, input[type="button"], input[type="reset"], input[type="submit"], .button, a.button, a.wp-block-button__link',
		'property' => 'padding',
	),
);
$add['button_border'] = array(
	array(
		'type'     => 'css',
		'element'  => 'button, input[type="button"], input[type="reset"], input[type="submit"], .button, a.button, a.wp-block-button__link',
		'property' => 'border-width',
	),
);
$add['button_border_radius'] = array(
	array(
		'type'     => 'css',
		'element'  => 'button, input[type="button"], input[type="reset"], input[type="submit"], .button, a.button, a.wp-block-button__link',
		'property' => 'border-radius',
	),
);
foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'letter_spacing' ) as $prop ) {
	$element = 'button, input[type="button"], input[type="reset"], input[type="submit"], .button, a.button, a.wp-block-button__link';
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
			'element'  => 'button, input[type="button"], input[type="reset"], input[type="submit"], .button, a.button, a.wp-block-button__link',
			'property' => $prop,
		),
	);
}
foreach ( array( 'bg' => 'background-color', 'border' => 'border-color', 'text' => 'color' ) as $key => $prop ) {
	$add['button_hover_' . $key . '_color'] = array(
		array(
			'type'     => 'css',
			'element'  => 'button:hover, button:focus, input[type="button"]:hover, input[type="button"]:focus, input[type="reset"]:hover, input[type="reset"]:focus, input[type="submit"]:hover, input[type="submit"]:focus, .button:hover, .button:focus, a.button:hover, a.button:focus, a.wp-block-button__link:hover, a.wp-block-button__link:focus',
			'property' => $prop,
		),
	);
}

/**
 * ====================================================
 * General Styles > Form Input
 * ====================================================
 */

$add['input_padding'] = array(
	array(
		'type'     => 'css',
		'element'  => 'input[type="text"], input[type="password"], input[type="color"], input[type="date"], input[type="datetime-local"], input[type="email"], input[type="month"], input[type="number"], input[type="search"], input[type="tel"], input[type="time"], input[type="url"], input[type="week"], .input, select, textarea, span.select2-container .select2-selection, span.select2-container .select2-dropdown .select2-search, span.select2-container .select2-dropdown .select2-results .select2-results__option',
		'property' => 'padding',
	),
);
$add['input_border'] = array(
	array(
		'type'     => 'css',
		'element'  => 'input[type="text"], input[type="password"], input[type="color"], input[type="date"], input[type="datetime-local"], input[type="email"], input[type="month"], input[type="number"], input[type="search"], input[type="tel"], input[type="time"], input[type="url"], input[type="week"], .input, select, textarea, span.select2-container .select2-selection, span.select2-container .select2-dropdown',
		'property' => 'border-width',
	),
);
$add['input_border_radius'] = array(
	array(
		'type'     => 'css',
		'element'  => 'input[type="text"], input[type="password"], input[type="color"], input[type="date"], input[type="datetime-local"], input[type="email"], input[type="month"], input[type="number"], input[type="search"], input[type="tel"], input[type="time"], input[type="url"], input[type="week"], .input, select, textarea, span.select2-container .select2-selection, span.select2-container .select2-dropdown',
		'property' => 'border-radius',
	),
);
foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'letter_spacing' ) as $prop ) {
	$element = 'input[type="text"], input[type="password"], input[type="color"], input[type="date"], input[type="datetime-local"], input[type="email"], input[type="month"], input[type="number"], input[type="search"], input[type="tel"], input[type="time"], input[type="url"], input[type="week"], .input, select, textarea, .search-field, span.select2-container';
	$property = str_replace( '_', '-', $prop );

	$add['input_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element,
			'property' => $property,
		),
	);
}
foreach ( array( 'bg' => 'background-color', 'border' => 'border-color', 'text' => 'color' ) as $key => $prop ) {
	$add['input_' . $key . '_color'] = array(
		array(
			'type'     => 'css',
			'element'  => 'input[type="text"], input[type="password"], input[type="color"], input[type="date"], input[type="datetime-local"], input[type="email"], input[type="month"], input[type="number"], input[type="search"], input[type="tel"], input[type="time"], input[type="url"], input[type="week"], .input, select, textarea, .search-field, span.select2-container .select2-selection, span.select2-container.select2-container--open .select2-dropdown',
			'property' => $prop,
		),
	);
}
foreach ( array( 'bg' => 'background-color', 'border' => 'border-color', 'text' => 'color' ) as $key => $prop ) {
	$add['input_focus_' . $key . '_color'] = array(
		array(
			'type'     => 'css',
			'element'  => 'input[type="text"]:focus, input[type="password"]:focus, input[type="color"]:focus, input[type="date"]:focus, input[type="datetime-local"]:focus, input[type="email"]:focus, input[type="month"]:focus, input[type="number"]:focus, input[type="search"]:focus, input[type="tel"]:focus, input[type="time"]:focus, input[type="url"]:focus, input[type="week"]:focus, .input:hover, .input:focus, select:focus, textarea:focus, .search-field:focus, span.select2-container.select2-container--open .select2-selection',
			'property' => $prop,
		),
	);

	if ( 'border' === $key ) {
		$add['input_focus_' . $key . '_color'][] = array(
			'type'     => 'css',
			'element'  => 'span.select2-container.select2-container--open .select2-dropdown',
			'property' => $prop,
		);
	}
}

/**
 * ====================================================
 * General Styles > Title
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
 * General Styles > Small Title
 * ====================================================
 */

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$element = 'legend, .small-title, .entry-small-title, .comments-title, .comment-reply-title, .page-header .page-title';
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
		'element'  => 'legend, .small-title, .small-title a, .entry-small-title, .entry-small-title a, .comments-title, .comment-reply-title, .page-header .page-title',
		'property' => 'color',
	),
);
$add['small_title_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.small-title a:hover, .small-title a:focus, .entry-small-title a:hover, .entry-small-title a:focus',
		'property' => 'color',
	),
);

/**
 * ====================================================
 * General Styles > Meta Info
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
		'element'  => 'body.suki-page-layout-boxed #page',
		'property' => 'width',
	),
	array(
		'type'     => 'css',
		'element'  => 'body.suki-page-layout-boxed .suki-header-section.suki-section-full-width .sub-menu',
		'property' => 'max-width',
	),
	// alignfull
	array(
		'type'     => 'css',
		'element'  => 'body.suki-page-layout-boxed .suki-content-layout-narrow .alignfull, body.suki-page-layout-boxed .suki-content-layout-wide .alignfull',
		'property' => 'max-width',
		'media'    => '@media screen and (min-width: $)',
	),
	array(
		'type'     => 'css',
		'element'  => 'body.suki-page-layout-boxed .suki-content-layout-narrow .alignfull, body.suki-page-layout-boxed .suki-content-layout-wide .alignfull',
		'property' => 'left',
		'pattern'  => 'calc( 50% - ( $ / 2 ) )',
		'media'    => '@media screen and (min-width: $)',
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
		'element'  => '.suki-header-section .menu .sub-menu',
		'property' => 'max-width',
	),
	// alignwide
	array(
		'type'     => 'css',
		'element'  => '.suki-content-layout-narrow .alignwide, .suki-content-layout-wide .alignwide',
		'property' => 'left',
		'pattern'  => 'calc( 50% - ( $ / 2 ) )',
		'media'    => '@media screen and (min-width: $)',
	),
	array(
		'type'     => 'css',
		'element'  => '.suki-content-layout-narrow .alignwide, .suki-content-layout-wide .alignwide',
		'property' => 'max-width',
		'media'    => '@media screen and (min-width: $)',
	),
);
$add['content_narrow_width'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-content-layout-narrow .site-main',
		'property' => 'max-width',
	),
);

$add['page_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => 'body, #page',
		'property' => 'background-color',
	),
	array(
		'type'     => 'css',
		'element'  => '.entry-layout-grid .entry-wrapper',
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
 * Header > Element: Logo
 * ====================================================
 */

$add['header_logo_width'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-logo .suki-logo-image',
		'property' => 'width',
	),
);
$add['header_mobile_logo_width'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-mobile-logo .suki-logo-image',
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
		'element'  => '.suki-header-search-bar .search-form',
		'property' => 'width',
	),
);
$add['header_search_dropdown_width'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-search-dropdown .sub-menu',
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
		'element'  => '.suki-header-shopping-cart .shopping-cart-count',
		'property' => 'background-color',
	),
);
$add['header_cart_count_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-shopping-cart .shopping-cart-count',
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
			'element'  => '.suki-header-' . $slug,
			'property' => 'height',
		),
	);

	if ( 'main_bar' !== $bar ) {
		$add['header_' . $bar . '_height'][] = array(
			'type'     => 'css',
			'element'  => '.suki-header-main-bar.suki-header-main-bar-with-' . $slug . ' > .suki-section-inner > .suki-wrapper',
			'property' => 'padding-' . ( 'top_bar' === $bar ? 'top' : 'bottom' ),
		);
	}

	$add['header_' . $bar . '_padding'] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $slug . '-inner',
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
			'element'  => '.suki-header-' . $slug . ' .suki-header-column > *',
			'property' => 'padding',
			'pattern'  => '0 $',
		),
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $slug . '-row',
			'property' => 'margin',
			'pattern'  => '0 -$',
		),
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $slug . ' .suki-header-menu .menu-item',
			'property' => 'padding',
			'pattern'  => '0 $',
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
			'element'  => '.suki-header-' . $slug . ' .suki-menu-icon',
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
			'element'  => '.suki-header-' . $slug . ' .menu > .menu-item .sub-menu',
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
			'element'  => '.suki-header-' . $slug . ' a:not(.button), .suki-header-' . $slug . ' .suki-toggle, .suki-header-' . $slug . ' .menu > .menu-item .sub-menu a:not(.button)',
			'property' => 'color',
		),
	);
	$add['header_' . $bar . '_link_hover_text_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $slug . ' a:not(.button):hover, .suki-header-' . $slug . ' a:not(.button):focus, .suki-header-' . $slug . ' .suki-toggle:hover, .suki-header-' . $slug . ' .suki-toggle:focus, .suki-header-' . $slug . ' .menu > .menu-item .sub-menu a:not(.button):hover, .suki-header-' . $slug . ' .menu > .menu-item .sub-menu a:not(.button):focus',
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
			'element'  => '.suki-header-' . $slug . ':not(.suki-header-menu-highlight-none) .suki-header-menu > .menu > .menu-item > .suki-menu-item-link:hover:after, .suki-header-' . $slug . ':not(.suki-header-menu-highlight-none) .suki-header-menu > .menu > .menu-item > .suki-menu-item-link:focus:after',
			'property' => 'background-color',
		),
	);
	$add['header_' . $bar . '_menu_hover_highlight_text_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $slug . ':not(.suki-header-menu-highlight-none) .suki-header-menu > .menu > .menu-item > .suki-menu-item-link:hover, .suki-header-' . $slug . ':not(.suki-header-menu-highlight-none) .suki-header-menu > .menu > .menu-item > .suki-menu-item-link:focus',
			'property' => 'color',
		),
	);
	$add['header_' . $bar . '_menu_active_highlight_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $slug . ':not(.suki-header-menu-highlight-none) .suki-header-menu > .menu > .current-menu-item > .suki-menu-item-link:after, .suki-header-' . $slug . ':not(.suki-header-menu-highlight-none) .suki-header-menu > .menu > .current-menu-ancestor > .suki-menu-item-link:after',
			'property' => 'background-color',
		),
	);
	$add['header_' . $bar . '_menu_active_highlight_text_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $slug . ':not(.suki-header-menu-highlight-none) .suki-header-menu > .menu > .current-menu-item > .suki-menu-item-link, .suki-header-' . $slug . ':not(.suki-header-menu-highlight-none) .suki-header-menu > .menu > .current-menu-ancestor > .suki-menu-item-link',
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
 * Header > Mobile Drawer (Popup)
 * ====================================================
 */

$add['header_mobile_vertical_bar_position'] = array(
	array(
		'type'     => 'class',
		'element'  => '.suki-header-mobile-vertical',
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
		'element'  => '.suki-header-mobile-vertical-bar',
		'property' => 'width',
	),
	array(
		'type'     => 'css',
		'element'  => '.suki-header-mobile-vertical.suki-header-mobile-vertical-display-full-screen .suki-header-section-vertical-column',
		'property' => 'width',
	),
);
$add['header_mobile_vertical_bar_padding'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-mobile-vertical-bar-inner',
		'property' => 'padding',
	),
);

$add['header_mobile_vertical_bar_items_gutter'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-mobile-vertical-bar .suki-header-section-vertical-row > *',
		'property' => 'padding',
		'pattern'  => '$ 0',
	),
	array(
		'type'     => 'css',
		'element'  => '.suki-header-mobile-vertical-bar .suki-header-section-vertical-column',
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
		'element'  => '.suki-header-mobile-vertical-bar-inner',
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
		'element'  => '.suki-header-mobile-vertical-bar a:not(.button), .suki-header-mobile-vertical-bar .suki-toggle, .suki-header-mobile-vertical-bar .menu .sub-menu a:not(.button), .suki-header-mobile-vertical-bar .menu .sub-menu .suki-toggle',
		'property' => 'color',
	),
);
$add['header_mobile_vertical_bar_link_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-mobile-vertical-bar a:not(.button):hover, .suki-header-mobile-vertical-bar a:not(.button):focus, .suki-header-mobile-vertical-bar .suki-toggle:hover, .suki-header-mobile-vertical-bar .suki-toggle:focus, .suki-header-mobile-vertical-bar .menu .sub-menu a:not(.button):hover, .suki-header-mobile-vertical-bar .menu .sub-menu a:not(.button):focus, .suki-header-mobile-vertical-bar .menu .sub-menu .suki-toggle:hover, .suki-header-mobile-vertical-bar .menu .sub-menu .suki-toggle:focus',
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

$add['page_header_container'] = array(
	array(
		'type'     => 'class',
		'element'  => '.suki-page-header',
		'pattern'  => 'suki-section-$',
	),
);
$responsive = array(
	''         => '',
	'__tablet' => '@media screen and (max-width: 1023px)',
	'__mobile' => '@media screen and (max-width: 499px)',
);
foreach ( $responsive as $suffix => $media ) {
	$add['page_header_padding' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-page-header-inner',
			'property' => 'padding',
			'media'    => $media,
		),
	);
}
$add['page_header_border'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-page-header-inner',
		'property' => 'border-width',
	),
);

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$element = '.suki-page-header-title';
	$property = str_replace( '_', '-', $prop );

	$add['page_header_title_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element,
			'property' => $property,
		),
	);
	if ( in_array( $prop, array( 'font_size', 'line_height', 'letter_spacing' ) ) ) {
		$add['page_header_title_' . $prop . '__tablet'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 1023px)',
			),
		);
		$add['page_header_title_' . $prop . '__mobile'] = array(
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
	$element = '.suki-page-header-breadcrumb';
	$property = str_replace( '_', '-', $prop );

	$add['page_header_breadcrumb_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element,
			'property' => $property,
		),
	);
	if ( in_array( $prop, array( 'font_size', 'line_height', 'letter_spacing' ) ) ) {
		$add['page_header_breadcrumb_' . $prop . '__tablet'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 1023px)',
			),
		);
		$add['page_header_breadcrumb_' . $prop . '__mobile'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 499px)',
			),
		);
	}
}

$add['page_header_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-page-header-inner',
		'property' => 'background-color',
	),
);
$add['page_header_border_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-page-header *',
		'property' => 'border-color',
	),
);
$add['page_header_title_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-page-header-title',
		'property' => 'color',
	),
);
$add['page_header_breadcrumb_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-page-header',
		'property' => 'color',
	),
);
$add['page_header_breadcrumb_link_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-page-header a',
		'property' => 'color',
	),
);
$add['page_header_breadcrumb_link_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-page-header a:hover, .suki-page-header a:focus',
		'property' => 'color',
	),
);

$add['page_header_bg_attachment'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-page-header-inner',
		'property' => 'background-attachment',
	),
);

$add['page_header_bg_overlay_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-page-header-inner:before',
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
			'element'  => '.suki-content-inner',
			'property' => 'padding',
			'media'    => $media,
		),

		// alignwide
		array(
			'type'     => 'css',
			'element'  => '.suki-content-layout-narrow .alignwide, .suki-content-layout-wide .alignwide',
			'property' => 'left',
			'pattern'  => 'calc( 50% - 50vw + $ )',
			'function' => array(
				'name' => 'explode_value',
				'args' => array( 0 ), // 4th part = left
			),
		),
		array(
			'type'     => 'css',
			'element'  => '.suki-content-layout-narrow .alignwide, .suki-content-layout-wide .alignwide',
			'property' => 'max-width',
			'pattern'  => 'calc( 100vw - ( 2 * $ ) )',
			'function' => array(
				'name' => 'explode_value',
				'args' => array( 0 ), // 4th part = left
			),
		),
	);
}

/**
 * ====================================================
 * Content & Sidebar > Main Content Area
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
		'element'  => '.sidebar',
		'property' => 'flex-basis',
	),
);
$add['sidebar_gap'] = array(
	array(
		'type'     => 'css',
		'element'  => '.ltr .suki-content-layout-right-sidebar .sidebar',
		'property' => 'margin-left',
	),
	array(
		'type'     => 'css',
		'element'  => '.rtl .suki-content-layout-right-sidebar .sidebar',
		'property' => 'margin-right',
	),
	array(
		'type'     => 'css',
		'element'  => '.ltr .suki-content-layout-left-sidebar .sidebar',
		'property' => 'margin-right',
	),
	array(
		'type'     => 'css',
		'element'  => '.rtl .suki-content-layout-left-sidebar .sidebar',
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
	$element = '.sidebar .widget-title';
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
		'element'  => '.sidebar .widget-title',
		'property' => 'color',
	),
);
$add['sidebar_widget_title_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.sidebar.suki-widget-title-decoration-box .widget-title',
		'property' => 'background-color',
	),
);
$add['sidebar_widget_title_border_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.sidebar .widget-title',
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
		'element'  => '.suki-footer-widgets-bar-column',
		'property' => 'padding',
		'pattern'  => '0 $',
	),
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-widgets-bar-row',
		'property' => 'margin-left',
		'pattern'  => '-$',
	),
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-widgets-bar-row',
		'property' => 'margin-right',
		'pattern'  => '-$',
	),
);
$add['footer_widgets_bar_widgets_gap'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-widgets-bar .widget',
		'property' => 'margin-bottom',
	),
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-widgets-bar-row',
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
	$element = '.suki-footer-widgets-bar .widget-title';
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
		'element'  => '.suki-footer-widgets-bar .widget-title',
		'property' => 'color',
	),
);
$add['footer_widgets_bar_widget_title_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-widgets-bar.suki-widget-title-decoration-box .widget-title',
		'property' => 'background-color',
	),
);
$add['footer_widgets_bar_widget_title_border_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-widgets-bar .widget-title',
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
			'element'  => '.suki-footer-bottom-bar-inner',
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
$add['footer_bottom_bar_items_gutter'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-bottom-bar .suki-footer-column > *',
		'property' => 'padding',
		'pattern'  => '0 $',
	),
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-bottom-bar-row',
		'property' => 'margin',
		'pattern'  => '0 -$',
	),
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-bottom-bar .suki-footer-menu .menu-item',
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
		'element'  => '.suki-footer-bottom-bar-inner',
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
 * Blog > Post Layout: Default
 * ====================================================
 */

$add['blog_index_default_items_gap'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-loop-default .entry',
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
		'element'  => '.suki-loop-grid',
		'property' => 'margin-top',
		'pattern'  => '-$',
	),
	array(
		'type'     => 'css',
		'element'  => '.suki-loop-grid',
		'property' => 'margin-bottom',
		'pattern'  => '-$',
	),
	array(
		'type'     => 'css',
		'element'  => '.suki-loop-grid > .entry',
		'property' => 'padding-top',
	),
	array(
		'type'     => 'css',
		'element'  => '.suki-loop-grid > .entry',
		'property' => 'padding-bottom',
	),
);
$add['blog_index_grid_columns_gutter'] = array(
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
	array(
		'type'     => 'css',
		'element'  => '.suki-loop-grid > .entry',
		'property' => 'padding-left',
	),
	array(
		'type'     => 'css',
		'element'  => '.suki-loop-grid > .entry',
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

return $add;