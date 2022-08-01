<?php
/**
 * Customizer setting outputs.
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$add = array();

/**
 * ====================================================
 * Global Modules > Color Palette
 * ====================================================
 */

for ( $i = 1; $i <= 8; $i++ ) {
	$add[ 'color_palette_' . $i ] = array(
		array(
			'type'     => 'css',
			'element'  => 'body',
			'property' => '--color-palette-' . $i,
		),
	);
}

/**
 * ====================================================
 * Global Elements > Content Size & Spacing
 * ====================================================
 */

$add['container_wide_width'] = array(
	array(
		'type'     => 'css',
		'element'  => 'body',
		'property' => '--content-width--wide',
	),
);

$add['container_narrow_width'] = array(
	array(
		'type'     => 'css',
		'element'  => 'body',
		'property' => '--content-width--narrow',
	),
);

$add['block_spacing'] = array(
	array(
		'type'     => 'css',
		'element'  => 'body',
		'property' => '--block-spacing',
	),
);

/**
 * ====================================================
 * Global Elements > Base Typography
 * ====================================================
 */

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$element  = 'body';
	$property = '--base--' . str_replace( '_', '-', $prop );

	$add[ 'body_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element,
			'property' => $property,
		),
	);
	if ( in_array( $prop, array( 'font_size', 'line_height', 'letter_spacing' ), true ) ) {
		$add[ 'body_' . $prop . '__tablet' ] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 1023px)',
			),
		);
		$add[ 'body_' . $prop . '__mobile' ] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 499px)',
			),
		);
	}
}

$add['font_smoothing'] = array(
	array(
		'type'    => 'class',
		'element' => 'body',
		'pattern' => 'suki-font-smoothing-$',
	),
);

$add['body_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => 'body',
		'property' => '--text-color',
	),
);

$add['subtle_color'] = array(
	array(
		'type'     => 'css',
		'element'  => 'body',
		'property' => '--subtle-background-color',
	),
);

$add['border_color'] = array(
	array(
		'type'     => 'css',
		'element'  => 'body',
		'property' => '--border-color',
	),
);

$add['link_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => 'body',
		'property' => '--link-color',
	),
);

$add['link_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => 'body',
		'property' => '--link-color--focus',
	),
);

/**
 * ====================================================
 * Global Elements > Headings
 * ====================================================
 */

for ( $i = 1; $i <= 4; $i++ ) {
	foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
		$element  = 'body';
		$property = '--h' . $i . '--' . str_replace( '_', '-', $prop );

		$rules = array();

		$add[ 'h' . $i . '_' . $prop ] = array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element,
			'property' => $property,
		);

		// Responsive.
		if ( in_array( $prop, array( 'font_size', 'line_height', 'letter_spacing' ), true ) ) {
			$add[ 'h' . $i . '_' . $prop . '__tablet' ] = array(
				array(
					'type'     => 'css',
					'element'  => $element,
					'property' => $property,
					'media'    => '@media screen and (max-width: 1023px)',
				),
			);
			$add[ 'h' . $i . '_' . $prop . '__mobile' ] = array(
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
		'element'  => 'body',
		'property' => '--heading-color',
	),
);

$add['heading_link_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => 'body',
		'property' => '--heading-color--focus',
	),
);

$add['heading_link_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => 'body',
		'property' => '--heading-color--focus',
	),
);

/**
 * ====================================================
 * Global Elements > Blockquote
 * ====================================================
 */

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$element  = 'blockquote';
	$property = str_replace( '_', '-', $prop );

	$add[ 'blockquote_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element,
			'property' => $property,
		),
	);
	if ( in_array( $prop, array( 'font_size', 'line_height', 'letter_spacing' ), true ) ) {
		$add[ 'blockquote_' . $prop . '__tablet' ] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 1023px)',
			),
		);
		$add[ 'blockquote_' . $prop . '__mobile' ] = array(
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
 * Global Elements > Button
 * ====================================================
 */

$add['button_padding'] = array(
	array(
		'type'     => 'css',
		'element'  => 'body',
		'property' => '--button--padding',
	),
);

$add['button_border'] = array(
	array(
		'type'     => 'css',
		'element'  => 'body',
		'property' => '--button--border-width',
	),
);

$add['button_border_radius'] = array(
	array(
		'type'     => 'css',
		'element'  => 'body',
		'property' => '--button--border-radius',
	),
);

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'letter_spacing' ) as $prop ) {
	$add[ 'button_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => 'body',
			'property' => '--button--' . str_replace( '_', '-', $prop ),
		),
	);
}

foreach ( array( 'background_color', 'border_color', 'text_color' ) as $prop ) {
	$add[ 'button_' . $prop ] = array(
		array(
			'type'     => 'css',
			'element'  => 'body',
			'property' => '--button--' . str_replace( '_', '-', $prop ),
		),
	);

	$add[ 'button_hover_' . $prop ] = array(
		array(
			'type'     => 'css',
			'element'  => 'body',
			'property' => '--button--' . str_replace( '_', '-', $prop ) . '--focus',
		),
	);
}

/**
 * ====================================================
 * Global Elements > Form Input
 * ====================================================
 */

$add['input_padding'] = array(
	array(
		'type'     => 'css',
		'element'  => 'body',
		'property' => '--input--padding',
	),
);

$add['input_border'] = array(
	array(
		'type'     => 'css',
		'element'  => 'body',
		'property' => '--input--border-width',
	),
);

$add['input_border_radius'] = array(
	array(
		'type'     => 'css',
		'element'  => 'body',
		'property' => '--input--border-radius',
	),
);

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'letter_spacing' ) as $prop ) {
	$add[ 'input_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => 'body',
			'property' => '--input--' . str_replace( '_', '-', $prop ),
		),
	);
}

foreach ( array( 'background_color', 'border_color', 'text_color' ) as $prop ) {
	$add[ 'input_' . $prop ] = array(
		array(
			'type'     => 'css',
			'element'  => 'body',
			'property' => '--input--' . str_replace( '_', '-', $prop ),
		),
	);

	$add[ 'input_hover_' . $prop ] = array(
		array(
			'type'     => 'css',
			'element'  => 'body',
			'property' => '--input--' . str_replace( '_', '-', $prop ) . '--focus',
		),
	);
}

/**
 * ====================================================
 * Global Elements > Title
 * ====================================================
 */

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$element  = 'body';
	$property = '--title--' . str_replace( '_', '-', $prop );

	$add[ 'title_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element,
			'property' => $property,
		),
	);
	if ( in_array( $prop, array( 'font_size', 'line_height', 'letter_spacing' ), true ) ) {
		$add[ 'title_' . $prop . '__tablet' ] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 1023px)',
			),
		);
		$add[ 'title_' . $prop . '__mobile' ] = array(
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
		'element'  => 'body',
		'property' => '--title--text-color',
	),
);

$add['title_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => 'body',
		'property' => '--title--text-color--focus',
	),
);

/**
 * ====================================================
 * Global Elements > Small Title
 * ====================================================
 */

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$element  = 'body';
	$property = '--small-title--' . str_replace( '_', '-', $prop );

	$add[ 'small_title_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element,
			'property' => $property,
		),
	);
	if ( in_array( $prop, array( 'font_size', 'line_height', 'letter_spacing' ), true ) ) {
		$add[ 'small_title_' . $prop . '__tablet' ] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 1023px)',
			),
		);
		$add[ 'small_title_' . $prop . '__mobile' ] = array(
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
		'element'  => 'body',
		'property' => '--small-title--text-color',
	),
);

$add['small_title_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => 'body',
		'property' => '--small-title--text-color--focus',
	),
);

/**
 * ====================================================
 * Global Elements > Meta Info
 * ====================================================
 */

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$element  = 'body';
	$property = '--meta--' . str_replace( '_', '-', $prop );

	$add[ 'meta_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element,
			'property' => $property,
		),
	);
	if ( in_array( $prop, array( 'font_size', 'line_height', 'letter_spacing' ), true ) ) {
		$add[ 'meta_' . $prop . '__tablet' ] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 1023px)',
			),
		);
		$add[ 'meta_' . $prop . '__mobile' ] = array(
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
		'element'  => 'body',
		'property' => '--meta--text-color',
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
		'element'  => 'body',
		'property' => '--meta--text-color--focus',
	),
);

/**
 * ====================================================
 * Global Layout > Page Canvas
 * ====================================================
 */

$add['page_layout'] = array(
	array(
		'type'    => 'class',
		'element' => 'body',
		'pattern' => 'suki-page--$',
	),
);

$add['boxed_page_width'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-page--layout-boxed .suki-canvas',
		'property' => '--canvas-width',
	),
);

$add['boxed_page_shadow'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-page--layout-boxed .suki-canvas',
		'property' => 'box-shadow',
	),
);

$add['page_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-canvas',
		'property' => 'background-color',
	),
);

$add['outside_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-page--layout-boxed',
		'property' => 'background-color',
	),
);

foreach ( array( 'image', 'position', 'size', 'repeat', 'attachment' ) as $prop ) {
	$add[ 'outside_bg_' . $prop ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-page--layout-boxed',
			'property' => 'background-' . $prop,
			'pattern'  => 'image' === $prop ? 'url($)' : '$',
			'media'    => '@media screen and (min-width: 1024px)',
		),
	);
}

/**
 * ====================================================
 * Global Layout > Content Section
 * ====================================================
 */

$responsive = array(
	''         => '',
	'__tablet' => '@media screen and (max-width: 1023px)',
	'__mobile' => '@media screen and (max-width: 499px)',
);
foreach ( $responsive as $suffix => $media ) {
	$add[ 'content_padding' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-content',
			'property' => 'padding',
			'media'    => $media,
		),
	);
}

/**
 * ====================================================
 * Global Layout > Main Content
 * ====================================================
 */

$responsive = array(
	''         => '',
	'__tablet' => '@media screen and (max-width: 1023px)',
	'__mobile' => '@media screen and (max-width: 499px)',
);
foreach ( $responsive as $suffix => $media ) {
	$add[ 'content_main_padding' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.site-main',
			'property' => 'padding',
			'media'    => $media,
		),
	);
}
$add['content_main_border'] = array(
	array(
		'type'     => 'css',
		'element'  => '.site-main',
		'property' => 'border-width',
	),
);

$add['content_main_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.site-main',
		'property' => 'background-color',
	),
);

$add['content_main_border_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.site-main',
		'property' => 'border-color',
	),
);

/**
 * ====================================================
 * Global Layout > Sidebar
 * ====================================================
 */

$add['sidebar_width'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-content-sidebar-column',
		'property' => 'flex-basis',
	),
);

$add['sidebar_gap'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-content-sidebar-columns',
		'property' => 'gap',
	),
);

$add['sidebar_widgets_mode'] = array(
	array(
		'type'    => 'class',
		'element' => '.sidebar',
		'pattern' => 'suki-sidebar-widgets-mode-$',
	),
);

$add['sidebar_widgets_gap'] = array(
	array(
		'type'     => 'css',
		'element'  => '.sidebar > * + *',
		'property' => 'margin-top',
	),
);

$responsive = array(
	''         => '',
	'__tablet' => '@media screen and (max-width: 1023px)',
	'__mobile' => '@media screen and (max-width: 499px)',
);

foreach ( $responsive as $suffix => $media ) {
	$add[ 'sidebar_padding' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-sidebar-widgets-mode-merged, .suki-sidebar-widgets-mode-separated > *',
			'property' => 'padding',
			'media'    => $media,
		),
	);
}

$add['sidebar_border'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-sidebar-widgets-mode-merged, .suki-sidebar-widgets-mode-separated > *',
		'property' => 'border-width',
	),
);

$add['sidebar_border_radius'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-sidebar-widgets-mode-merged, .suki-sidebar-widgets-mode-separated > *',
		'property' => 'border-radius',
	),
);

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$element  = '.sidebar';
	$property = str_replace( '_', '-', $prop );

	$add[ 'sidebar_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element,
			'property' => $property,
		),
	);

	if ( in_array( $prop, array( 'font_size', 'line_height', 'letter_spacing' ), true ) ) {
		$add[ 'sidebar_' . $prop . '__tablet' ] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 1023px)',
			),
		);

		$add[ 'sidebar_' . $prop . '__mobile' ] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 499px)',
			),
		);
	}
}

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
		'element'  => '.sidebar',
		'property' => '--background-color',
	),
);

$add['sidebar_border_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.sidebar',
		'property' => '--border-color',
	),
);

$add['sidebar_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.sidebar',
		'property' => '--text-color',
	),
);

$add['sidebar_link_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.sidebar a',
		'property' => '--link-color',
	),
);

$add['sidebar_link_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.sidebar',
		'property' => '--link-color--focus',
	),
);

/**
 * ====================================================
 * Global Layout > Hero Section
 * ====================================================
 */

$add['hero_container'] = array(
	array(
		'type'    => 'class',
		'element' => '.suki-hero',
		'pattern' => 'suki-section-$',
	),
);

$responsive = array(
	''         => '',
	'__tablet' => '@media screen and (max-width: 1023px)',
	'__mobile' => '@media screen and (max-width: 499px)',
);

foreach ( $responsive as $suffix => $media ) {
	$add[ 'hero_height' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-hero',
			'property' => 'min-height',
			'media'    => $media,
		),
	);
}

foreach ( $responsive as $suffix => $media ) {
	$add[ 'hero_padding' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-hero',
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
	$element  = '.suki-hero';
	$property = '--title--' . str_replace( '_', '-', $prop );

	$add[ 'hero_title_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element,
			'property' => $property,
		),
	);
	if ( in_array( $prop, array( 'font_size', 'line_height', 'letter_spacing' ), true ) ) {
		$add[ 'hero_title_' . $prop . '__tablet' ] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 1023px)',
			),
		);
		$add[ 'hero_title_' . $prop . '__mobile' ] = array(
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
	$element  = '.suki-hero';
	$property = str_replace( '_', '-', $prop );

	$add[ 'hero_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element,
			'property' => $property,
		),
	);

	if ( in_array( $prop, array( 'font_size', 'line_height', 'letter_spacing' ), true ) ) {
		$add[ 'hero_' . $prop . '__tablet' ] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 1023px)',
			),
		);

		$add[ 'hero_' . $prop . '__mobile' ] = array(
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
	$element  = '.suki-hero .suki-breadcrumb';
	$property = str_replace( '_', '-', $prop );

	$add[ 'hero_breadcrumb_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element,
			'property' => $property,
		),
	);

	if ( in_array( $prop, array( 'font_size', 'line_height', 'letter_spacing' ), true ) ) {
		$add[ 'hero_breadcrumb_' . $prop . '__tablet' ] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 1023px)',
			),
		);

		$add[ 'hero_breadcrumb_' . $prop . '__mobile' ] = array(
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
		'element'  => '.suki-hero',
		'property' => '--background-color',
	),
);

$add['hero_border_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-hero',
		'property' => '--border-color',
	),
);

$add['hero_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-hero',
		'property' => '--text-color',
	),
);

$add['hero_link_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-hero',
		'property' => '--link-color',
	),
);

$add['hero_link_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-hero',
		'property' => '--link-color--focus',
	),
);

$add['hero_title_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-hero',
		'property' => '--title--text-color',
	),
);

$add['hero_breadcrumb_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-hero .suki-breadcrumb',
		'property' => '--text-color',
	),
);

$add['hero_breadcrumb_link_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-hero .suki-breadcrumb',
		'property' => '--link-color',
	),
);

$add['hero_breadcrumb_link_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-hero .suki-breadcrumb',
		'property' => '--link-color--focus',
	),
);

$add['hero_bg_attachment'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-hero',
		'property' => 'background-attachment',
	),
);

$add['hero_bg_overlay_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-hero:before',
		'property' => 'background-color',
	),
);

/**
 * ====================================================
 * Header > Top Bar
 * Header > Main Bar
 * Header > Bottom Bar
 * ====================================================
 */

foreach ( array( 'top', 'main', 'bottom' ) as $bar ) {
	$add[ 'header_' . $bar . '_bar_container' ] = array(
		array(
			'type'    => 'class',
			'element' => '.suki-header-' . $bar . '-bar',
			'pattern' => 'suki-section-$',
		),
	);

	$add[ 'header_' . $bar . '_bar_height' ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $bar . '-bar',
			'property' => '--height',
		),
	);

	$add[ 'header_' . $bar . '_bar_padding' ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $bar . '-bar',
			'property' => 'padding',
		),
	);

	$add[ 'header_' . $bar . '_bar_border' ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $bar . '-bar',
			'property' => 'border-width',
		),
	);

	$add[ 'header_' . $bar . '_bar_items_gap' ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $bar . '-bar',
			'property' => '--items-gap',
		),
	);

	foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
		$element  = '.suki-header-' . $bar . '-bar';
		$property = str_replace( '_', '-', $prop );

		$add[ 'header_' . $bar . '_bar_' . $prop ] = array(
			array(
				'type'     => 'font_family' === $prop ? 'font' : 'css',
				'element'  => $element,
				'property' => $property,
			),
		);
	}

	foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
		$element  = '.suki-header-' . $bar . '-bar .suki-menu-item-link';
		$property = str_replace( '_', '-', $prop );

		$add[ 'header_' . $bar . '_bar_menu_' . $prop ] = array(
			array(
				'type'     => 'font_family' === $prop ? 'font' : 'css',
				'element'  => $element,
				'property' => $property,
			),
		);
	}

	foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
		$element  = '.suki-header-' . $bar . '-bar .sub-menu';
		$property = str_replace( '_', '-', $prop );

		$add[ 'header_' . $bar . '_bar_submenu_' . $prop ] = array(
			array(
				'type'     => 'font_family' === $prop ? 'font' : 'css',
				'element'  => $element,
				'property' => $property,
			),
		);
	}

	$add[ 'header_' . $bar . '_bar_icon_size' ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $bar . '-bar',
			'property' => '--menu-icon-size',
		),
	);

	$add[ 'header_' . $bar . '_bar_bg_color' ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $bar . '-bar',
			'property' => '--background-color',
		),
	);

	$add[ 'header_' . $bar . '_bar_border_color' ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $bar . '-bar',
			'property' => '--border-color',
		),
	);

	$add[ 'header_' . $bar . '_bar_text_color' ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $bar . '-bar',
			'property' => '--text-color',
		),
	);

	$add[ 'header_' . $bar . '_bar_link_text_color' ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $bar . '-bar',
			'property' => '--link-color',
		),
	);

	$add[ 'header_' . $bar . '_bar_link_hover_text_color' ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $bar . '-bar',
			'property' => '--link-color--focus',
		),
	);

	$add[ 'header_' . $bar . '_bar_link_active_text_color' ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $bar . '-bar',
			'property' => '--link-color--active',
		),
	);

	$add[ 'header_' . $bar . '_bar_submenu_bg_color' ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $bar . '-bar .sub-menu',
			'property' => '--background-color',
		),
	);

	$add[ 'header_' . $bar . '_bar_submenu_border_color' ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $bar . '-bar .sub-menu',
			'property' => '--border-color',
		),
	);

	$add[ 'header_' . $bar . '_bar_submenu_text_color' ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $bar . '-bar .sub-menu',
			'property' => '--text-color',
		),
	);

	$add[ 'header_' . $bar . '_bar_submenu_link_text_color' ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $bar . '-bar .sub-menu',
			'property' => '--link-color',
		),
	);

	$add[ 'header_' . $bar . '_bar_submenu_link_hover_text_color' ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $bar . '-bar .sub-menu',
			'property' => '--link-color--focus',
		),
	);

	$add[ 'header_' . $bar . '_bar_submenu_link_active_text_color' ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $bar . '-bar .sub-menu',
			'property' => '--link-color--active',
		),
	);

	$add[ 'header_' . $bar . '_bar_menu_highlight' ] = array(
		array(
			'type'    => 'class',
			'element' => '.suki-header-' . $bar . '-bar',
			'pattern' => 'suki-header-menu--highlight-$',
		),
	);

	$add[ 'header_' . $bar . '_bar_menu_hover_highlight_color' ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $bar . '-bar',
			'property' => '--menu-hover-highlight-background-color',
		),
	);

	$add[ 'header_' . $bar . '_bar_menu_hover_highlight_text_color' ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $bar . '-bar',
			'property' => '--menu-hover-highlight-text-color',
		),
	);

	$add[ 'header_' . $bar . '_bar_menu_active_highlight_color' ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $bar . '-bar',
			'property' => '--menu-active-highlight-background-color',
		),
	);

	$add[ 'header_' . $bar . '_bar_menu_active_highlight_text_color' ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-' . $bar . '-bar',
			'property' => '--menu-active-highlight-text-color',
		),
	);

	if ( 'main' !== $bar ) {
		$add[ 'header_' . $bar . '_bar_merged_gap' ] = array(
			array(
				'type'     => 'css',
				'element'  => '.suki-header-main-bar-with-' . $bar . '-bar > .suki-header-main-bar-merged-wrapper > .suki-header-row',
				'property' => 'margin-' . $bar,
			),
		);
	}
}

/**
 * ====================================================
 * Header > Mobile Main Bar
 * ====================================================
 */

foreach ( array( 'main' ) as $bar ) {
	$add[ 'header_mobile_' . $bar . '_bar_height' ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-mobile-' . $bar . '-bar',
			'property' => '--height',
		),
	);

	$responsive = array(
		'__tablet' => '@media screen and (max-width: 1023px)',
		'__mobile' => '@media screen and (max-width: 499px)',
	);

	foreach ( $responsive as $suffix => $media ) {
		$add[ 'header_mobile_' . $bar . '_bar_padding' . $suffix ] = array(
			array(
				'type'     => 'css',
				'element'  => '.suki-header-mobile-' . $bar . '-bar',
				'property' => 'padding',
				'media'    => $media,
			),
		);
	}

	$add[ 'header_mobile_' . $bar . '_bar_border' ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-mobile-' . $bar . '-bar',
			'property' => 'border-width',
		),
	);

	$add[ 'header_mobile_' . $bar . '_bar_items_gap' ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-mobile-' . $bar . '-bar',
			'property' => '--items-gap',
		),
	);

	foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
		$element  = '.suki-header-mobile-' . $bar . '-bar';
		$property = str_replace( '_', '-', $prop );

		$add[ 'header_mobile_' . $bar . '_bar_' . $prop ] = array(
			array(
				'type'     => 'font_family' === $prop ? 'font' : 'css',
				'element'  => $element,
				'property' => $property,
			),
		);
	}

	foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
		$element  = '.suki-header-mobile-' . $bar . '-bar .suki-menu-item-link';
		$property = str_replace( '_', '-', $prop );

		$add[ 'header_mobile_' . $bar . '_bar_menu_' . $prop ] = array(
			array(
				'type'     => 'font_family' === $prop ? 'font' : 'css',
				'element'  => $element,
				'property' => $property,
			),
		);
	}

	foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
		$element  = '.suki-header-mobile-' . $bar . '-bar .sub-menu';
		$property = str_replace( '_', '-', $prop );

		$add[ 'header_mobile_' . $bar . '_bar_submenu_' . $prop ] = array(
			array(
				'type'     => 'font_family' === $prop ? 'font' : 'css',
				'element'  => $element,
				'property' => $property,
			),
		);
	}

	$add[ 'header_mobile_' . $bar . '_bar_icon_size' ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-mobile-' . $bar . '-bar',
			'property' => '--menu-icon-size',
		),
	);

	$add[ 'header_mobile_' . $bar . '_bar_bg_color' ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-mobile-' . $bar . '-bar',
			'property' => '--background-color',
		),
	);

	$add[ 'header_mobile_' . $bar . '_bar_border_color' ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-mobile-' . $bar . '-bar',
			'property' => '--border-color',
		),
	);

	$add[ 'header_mobile_' . $bar . '_bar_text_color' ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-mobile-' . $bar . '-bar',
			'property' => '--text-color',
		),
	);

	$add[ 'header_mobile_' . $bar . '_bar_link_text_color' ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-mobile-' . $bar . '-bar',
			'property' => '--link-color',
		),
	);

	$add[ 'header_mobile_' . $bar . '_bar_link_hover_text_color' ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-header-mobile-' . $bar . '-bar',
			'property' => '--link-color--focus',
		),
	);
}

/**
 * ====================================================
 * Header > Mobile Popup
 * ====================================================
 */

$add['header_mobile_vertical_bar_position'] = array(
	array(
		'type'    => 'class',
		'element' => '.suki-header-mobile-vertical:not(.suki-header-mobile-vertical-display-full-screen)',
		'pattern' => 'suki-header-mobile-vertical-position-$',
	),
);

$add['header_mobile_vertical_bar_full_screen_position'] = array(
	array(
		'type'    => 'class',
		'element' => '.suki-header-mobile-vertical.suki-header-mobile-vertical-display-full-screen',
		'pattern' => 'suki-header-mobile-vertical-position-$',
	),
);

$add['header_mobile_vertical_bar_alignment'] = array(
	array(
		'type'    => 'class',
		'element' => '.suki-header-mobile-vertical',
		'pattern' => 'has-text-align-$',
	),
);

$add['header_mobile_vertical_bar_width'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-mobile-vertical-bar',
		'property' => '--width',
	),
);

$add['header_mobile_vertical_bar_padding'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-mobile-vertical-bar',
		'property' => 'padding',
	),
);

$add['header_mobile_vertical_bar_items_gap'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-mobile-vertical-bar',
		'property' => '--items-gap',
	),
);

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$add[ 'header_mobile_vertical_bar_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => '.suki-header-mobile-vertical-bar',
			'property' => str_replace( '_', '-', $prop ),
		),
	);
}

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$add[ 'header_mobile_vertical_bar_menu_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => '.suki-header-mobile-vertical-bar :is(.suki-menu-item-link, .suki-toggle)',
			'property' => str_replace( '_', '-', $prop ),
		),
	);
}

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$add[ 'header_mobile_vertical_bar_submenu_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => '.suki-header-mobile-vertical-bar .sub-menu :is(.suki-menu-item-link, .suki-toggle)',
			'property' => str_replace( '_', '-', $prop ),
		),
	);
}

$add['header_mobile_vertical_bar_icon_size'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-mobile-vertical-bar',
		'property' => '--menu-icon-size',
	),
);

$add['header_mobile_vertical_bar_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-mobile-vertical-bar',
		'property' => '--background-color',
	),
);

$add['header_mobile_vertical_bar_border_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-mobile-vertical-bar',
		'property' => '--border-color',
	),
);

$add['header_mobile_vertical_bar_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-mobile-vertical-bar',
		'property' => '--text-color',
	),
);

$add['header_mobile_vertical_bar_link_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-mobile-vertical-bar',
		'property' => '--link-color',
	),
);

$add['header_mobile_vertical_bar_link_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-mobile-vertical-bar',
		'property' => '--link-color--focus',
	),
);

$add['header_mobile_vertical_bar_link_active_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-mobile-vertical-bar',
		'property' => '--link-color--active',
	),
);

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
		'element'  => '.suki-header-cart .cart-count',
		'property' => 'background-color',
	),
);

$add['header_cart_count_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-header-cart .cart-count',
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
 * Footer > Widgets Bar
 * ====================================================
 */

$add['footer_widgets_bar_container'] = array(
	array(
		'type'    => 'class',
		'element' => '.suki-footer-widgets-bar',
		'pattern' => 'suki-section-$',
	),
);

$responsive = array(
	''         => '',
	'__tablet' => '@media screen and (max-width: 1023px)',
	'__mobile' => '@media screen and (max-width: 499px)',
);

foreach ( $responsive as $suffix => $media ) {
	$add[ 'footer_widgets_bar_padding' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-footer-widgets-bar',
			'property' => 'padding',
			'media'    => $media,
		),
	);
}

$add['footer_widgets_bar_border'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-widgets-bar',
		'property' => 'border-width',
	),
);

$add['footer_widgets_bar_columns_gap'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-widgets-columns',
		'property' => 'gap',
	),
);

$add['footer_widgets_bar_widgets_gap'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-widgets-column > * + *',
		'property' => 'margin-top',
	),
);

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$element  = '.suki-footer-widgets-bar';
	$property = str_replace( '_', '-', $prop );

	$add[ 'footer_widgets_bar_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element,
			'property' => $property,
		),
	);

	if ( in_array( $prop, array( 'font_size', 'line_height', 'letter_spacing' ), true ) ) {
		$add[ 'footer_widgets_bar_' . $prop . '__tablet' ] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 1023px)',
			),
		);

		$add[ 'footer_widgets_bar_' . $prop . '__mobile' ] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 499px)',
			),
		);
	}
}

$add['footer_widgets_bar_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-widgets-bar',
		'property' => '--background-color',
	),
);

$add['footer_widgets_bar_border_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-widgets-bar',
		'property' => '--border-color',
	),
);

$add['footer_widgets_bar_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-widgets-bar',
		'property' => '--text-color',
	),
);

$add['footer_widgets_bar_link_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-widgets-bar',
		'property' => '--link-color',
	),
);

$add['footer_widgets_bar_link_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-widgets-bar',
		'property' => '--link-color--focus',
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
		'type'    => 'class',
		'element' => '.suki-footer-bottom-bar',
		'pattern' => 'suki-section-$',
	),
);

$responsive = array(
	''         => '',
	'__tablet' => '@media screen and (max-width: 1023px)',
	'__mobile' => '@media screen and (max-width: 499px)',
);
foreach ( $responsive as $suffix => $media ) {
	$add[ 'footer_bottom_bar_padding' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-footer-bottom-bar',
			'property' => 'padding',
			'media'    => $media,
		),
	);
}
$add['footer_bottom_bar_border'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-bottom-bar',
		'property' => 'border-width',
	),
);

$add['footer_bottom_bar_items_gap'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-bottom-bar',
		'property' => '--items-gap',
	),
);

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$element  = '.suki-footer-bottom-bar';
	$property = str_replace( '_', '-', $prop );

	$add[ 'footer_bottom_bar_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element,
			'property' => $property,
		),
	);

	if ( in_array( $prop, array( 'font_size', 'line_height', 'letter_spacing' ), true ) ) {
		$add[ 'footer_bottom_bar_' . $prop . '__tablet' ] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 1023px)',
			),
		);

		$add[ 'footer_bottom_bar_' . $prop . '__mobile' ] = array(
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
		'element'  => '.suki-footer-bottom-bar',
		'property' => '--background-color',
	),
);

$add['footer_bottom_bar_border_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-bottom-bar',
		'property' => '--border-color',
	),
);

$add['footer_bottom_bar_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-bottom-bar',
		'property' => '--text-color',
	),
);

$add['footer_bottom_bar_link_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-bottom-bar',
		'property' => '--link-color',
	),
);

$add['footer_bottom_bar_link_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-footer-bottom-bar',
		'property' => '--link-color--focus',
	),
);

/**
 * ====================================================
 * Footer > Social
 * ====================================================
 */

// Social links.
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
		'type'    => 'class',
		'element' => '.suki-scroll-to-top',
		'pattern' => 'suki-scroll-to-top-display-$',
	),
);

$add['scroll_to_top_position'] = array(
	array(
		'type'    => 'class',
		'element' => '.suki-scroll-to-top',
		'pattern' => 'suki-scroll-to-top-position-$',
	),
);

$responsive = array(
	''         => '',
	'__tablet' => '@media screen and (max-width: 1023px)',
	'__mobile' => '@media screen and (max-width: 499px)',
);
foreach ( $responsive as $suffix => $media ) {
	$add[ 'scroll_to_top_h_offset' . $suffix ] = array(
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

	$add[ 'scroll_to_top_v_offset' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-scroll-to-top',
			'property' => 'margin-bottom',
			'media'    => $media,
		),
	);

	$add[ 'scroll_to_top_icon_size' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-scroll-to-top',
			'property' => 'font-size',
			'media'    => $media,
		),
	);

	$add[ 'scroll_to_top_padding' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.suki-scroll-to-top',
			'property' => 'padding',
			'media'    => $media,
		),
	);

	$add[ 'scroll_to_top_border_radius' . $suffix ] = array(
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
		'property' => '--button--background-color',
	),
);

$add['scroll_to_top_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-scroll-to-top',
		'property' => '--button--text-color',
	),
);

$add['scroll_to_top_hover_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-scroll-to-top',
		'property' => '--button--background-color--focus',
	),
);

$add['scroll_to_top_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-scroll-to-top',
		'property' => '--button--text-color--focus',
	),
);

/**
 * ====================================================
 * Blog > Posts Archive Page
 * ====================================================
 */

$add['post_archive_content_header_alignment'] = array(
	array(
		'type'    => 'class',
		'element' => '.suki-post_archive .suki-content-header > *',
		'pattern' => 'has-text-align-$',
	),
	array(
		'type'    => 'class',
		'element' => '.suki-post_archive .suki-content-header > *',
		'pattern' => 'suki-flex--justify-$',
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
		'element'  => '.suki-loop-default',
		'property' => 'gap',
	),
);

$add['entry_header_alignment'] = array(
	array(
		'type'    => 'class',
		'element' => '.entry-layout-default .entry-header',
		'pattern' => 'has-text-align-$',
	),
	array(
		'type'    => 'class',
		'element' => '.entry-layout-default .entry-header',
		'pattern' => 'suki-flex--justify-$',
	),
);

$add['entry_footer_alignment'] = array(
	array(
		'type'    => 'class',
		'element' => '.entry-layout-default .entry-footer',
		'pattern' => 'has-text-align-$',
	),
	array(
		'type'    => 'class',
		'element' => '.entry-layout-default .entry-footer',
		'pattern' => 'suki-flex--justify-$',
	),
);

/**
 * ====================================================
 * Blog > Post Layout: Grid
 * ====================================================
 */

$add['blog_index_grid_columns'] = array(
	array(
		'type'    => 'class',
		'element' => '.suki-loop-grid',
		'pattern' => 'columns-$',
	),
);

$add['blog_index_grid_rows_gap'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-loop-grid',
		'property' => 'row-gap',
		// 'pattern'  => '$ !important',
	),
);

$add['blog_index_grid_columns_gap'] = array(
	array(
		'type'     => 'css',
		'element'  => '.suki-loop-grid',
		'property' => 'column-gap',
		// 'pattern'  => '$ !important',
	),
);

$responsive = array(
	''         => '',
	'__tablet' => '@media screen and (max-width: 1023px)',
	'__mobile' => '@media screen and (max-width: 499px)',
);

foreach ( $responsive as $suffix => $media ) {
	$add[ 'entry_grid_padding' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.entry-layout-grid',
			'property' => 'padding',
			'media'    => $media,
		),
		array(
			'type'     => 'css',
			'element'  => '.entry-layout-grid',
			'property' => '--padding-top',
			'function' => array(
				'name' => 'explode_value',
				'args' => array( 0 ), // 1st part = top
			),
			'media'    => $media,
		),
		array(
			'type'     => 'css',
			'element'  => '.entry-layout-grid',
			'property' => '--padding-right',
			'function' => array(
				'name' => 'explode_value',
				'args' => array( 1 ), // 2nd part = right
			),
			'media'    => $media,
		),
		array(
			'type'     => 'css',
			'element'  => '.entry-layout-grid',
			'property' => '--padding-left',
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
		'element'  => '.entry-layout-grid',
		'property' => 'border-width',
	),
);

$add['entry_grid_border_radius'] = array(
	array(
		'type'     => 'css',
		'element'  => '.entry-layout-grid',
		'property' => 'border-radius',
	),
);

$add['entry_grid_header_alignment'] = array(
	array(
		'type'    => 'class',
		'element' => '.entry-layout-grid .entry-header',
		'pattern' => 'has-text-align-$',
	),
	array(
		'type'    => 'class',
		'element' => '.entry-layout-grid .entry-header',
		'pattern' => 'suki-flex--justify-$',
	),
);

$add['entry_grid_footer_alignment'] = array(
	array(
		'type'    => 'class',
		'element' => '.entry-layout-grid .entry-footer',
		'pattern' => 'has-text-align-$',
	),
	array(
		'type'    => 'class',
		'element' => '.entry-layout-grid .entry-footer',
		'pattern' => 'suki-flex--justify-$',
	),
);

$add['entry_grid_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.entry-layout-grid',
		'property' => 'background-color',
	),
);

$add['entry_grid_border_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.entry-layout-grid',
		'property' => 'border-color',
	),
);

$add['entry_grid_shadow'] = array(
	array(
		'type'     => 'css',
		'element'  => '.entry-layout-grid',
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
		'type'    => 'class',
		'element' => '.suki-post_single .suki-content-header > *',
		'pattern' => 'has-text-align-$',
	),
	array(
		'type'    => 'class',
		'element' => '.suki-post_single .suki-content-header > *',
		'pattern' => 'suki-flex--justify-$',
	),
);

$add['post_single_content_footer_alignment'] = array(
	array(
		'type'    => 'class',
		'element' => '.suki-post_single .suki-content-footer > *',
		'pattern' => 'has-text-align-$',
	),
	array(
		'type'    => 'class',
		'element' => '.suki-post_single .suki-content-footer > *',
		'pattern' => 'suki-flex--justify-$',
	),
);

/**
 * ====================================================
 * Other Pages > Static Page
 * ====================================================
 */

$add['page_single_content_header_alignment'] = array(
	array(
		'type'    => 'class',
		'element' => '.suki-page_single .suki-content-header > *',
		'pattern' => 'has-text-align-$',
	),
	array(
		'type'    => 'class',
		'element' => '.suki-page_single .suki-content-header > *',
		'pattern' => 'suki-flex--justify-$',
	),
);

/**
 * ====================================================
 * Other Pages > Search Results Page
 * ====================================================
 */

$add['search_results_content_header_alignment'] = array(
	array(
		'type'    => 'class',
		'element' => '.suki-search_results .suki-content-header > *',
		'pattern' => 'has-text-align-$',
	),
	array(
		'type'    => 'class',
		'element' => '.suki-search_results .suki-content-header > *',
		'pattern' => 'suki-flex--justify-$',
	),
);

/**
 * ====================================================
 * Other Pages > [Custom Post Type] Archive Page
 * ====================================================
 */

foreach ( suki_get_public_post_types( 'custom' ) as $pt ) {
	$add[ $pt . '_archive_content_header_alignment' ] = array(
		array(
			'type'    => 'class',
			'element' => '.suki-' . $pt . '_archive .suki-content-header > *',
			'pattern' => 'has-text-align-$',
		),
		array(
			'type'    => 'class',
			'element' => '.suki-' . $pt . '_archive .suki-content-header > *',
			'pattern' => 'suki-flex--justify-$',
		),
	);
}

/**
 * ====================================================
 * Other Pages > Single [Custom Post Types] Page
 * ====================================================
 */

foreach ( suki_get_public_post_types( 'custom' ) as $pt ) {
	$add[ $pt . '_single_content_header_alignment' ] = array(
		array(
			'type'    => 'class',
			'element' => '.suki-' . $pt . '_single .suki-content-header > *',
			'pattern' => 'has-text-align-$',
		),
		array(
			'type'    => 'class',
			'element' => '.suki-' . $pt . '_single .suki-content-header > *',
			'pattern' => 'suki-flex--justify-$',
		),
	);
}

/**
 * ====================================================
 * Other Pages > Error 404
 * ====================================================
 */

$add['error_404_image_width'] = array(
	array(
		'type'     => 'css',
		'element'  => '.error-404-image img',
		'property' => 'width',
	),
);

return $add;
