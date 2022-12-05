<?php
/**
 * Customizer control's conditional display.
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// phpcs:disable Squiz.PHP.DisallowMultipleAssignments

$add = array();

/**
 * ====================================================
 * Page Canvas
 * ====================================================
 */

$add['boxed_page_width']  =
$add['boxed_page_shadow'] =
$add['hr_boxed_page']     =
$add['outside_bg_color']  =
$add['outside_bg']        = array(
	array(
		'setting' => 'page_layout',
		'value'   => 'boxed',
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
	$add[ 'suki_section_header_' . $bar ] = array(
		array(
			'setting' => '__device',
			'value'   => 'desktop',
		),
	);

	if ( 'main_bar' !== $bar ) {
		$add[ 'header_' . $bar . '_container' ] = array(
			array(
				'setting'  => 'header_' . $bar . '_merged',
				'operator' => '!=',
				'value'    => 1,
			),
		);

		$add[ 'header_' . $bar . '_merged_gap' ] = array(
			array(
				'setting'  => 'header_' . $bar . '_merged',
				'operator' => '==',
				'value'    => 1,
			),
		);
	}
}

/**
 * ====================================================
 * Header > Mobile Main Bar
 * Header > Mobile Popup
 * ====================================================
 */

$add['suki_section_header_mobile_main_bar']     =
$add['suki_section_header_mobile_vertical_bar'] = array(
	array(
		'setting'  => '__device',
		'operator' => '!=',
		'value'    => 'desktop',
	),
);

$add['header_mobile_vertical_bar_full_screen_position'] = array(
	array(
		'setting' => 'header_mobile_vertical_bar_display',
		'value'   => 'full-screen',
	),
);

$add['header_mobile_vertical_bar_position'] = array(
	array(
		'setting'  => 'header_mobile_vertical_bar_display',
		'operator' => '!=',
		'value'    => 'full-screen',
	),
);

/**
 * ====================================================
 * Header > Header Builder
 * ====================================================
 */

// Header Elements.
$add['header_elements'] = array(
	array(
		'setting' => '__device',
		'value'   => 'desktop',
	),
);

// Mobile Header Elements.
$add['header_mobile_visibility'] =
$add['header_mobile_elements']   = array(
	array(
		'setting'  => '__device',
		'operator' => '!=',
		'value'    => 'desktop',
	),
);

/**
 * ====================================================
 * Header > Shopping Cart
 * ====================================================
 */

$add['header_cart_amount_visibility'] = array(
	array(
		'setting'  => 'header_cart_amount',
		'operator' => '!=',
		'value'    => '',
	),
);

/**
 * ====================================================
 * Global Layout > Content Section
 * ====================================================
 */

$add['content_layout'] = array(
	array(
		'setting'  => 'content_container',
		'operator' => '!=',
		'value'    => 'narrow',
	),
);

/**
 * ====================================================
 * Footer > Bottom Bar
 * ====================================================
 */

$add['footer_bottom_bar_container'] = array(
	array(
		'setting'  => 'footer_bottom_bar_merged',
		'operator' => '!=',
		'value'    => 1,
	),
);

$add['footer_bottom_bar_merged_gap'] = array(
	array(
		'setting'  => 'footer_bottom_bar_merged',
		'operator' => '==',
		'value'    => 1,
	),
);

/**
 * ====================================================
 * Blog > Posts Archive Page
 * ====================================================
 */

$add['blank_edit_entry_default'] = array(
	array(
		'setting' => 'post_archive_loop_layout',
		'value'   => 'default',
	),
);

$add['blank_edit_entry_grid'] = array(
	array(
		'setting' => 'post_archive_loop_layout',
		'value'   => 'grid',
	),
);

$add['post_archive_title_text']     =
$add['post_archive_tax_title_text'] = array(
	array(
		'setting'  => 'post_archive_content_header',
		'operator' => 'contain',
		'value'    => 'title',
	),
);

/**
 * ====================================================
 * Blog > Single Post Page
 * ====================================================
 */

$add['post_single_content_header_meta'] = array(
	array(
		'setting'  => 'post_single_content_header',
		'operator' => 'contain',
		'value'    => 'header-meta',
	),
);

$add['post_single_content_footer_meta'] = array(
	array(
		'setting'  => 'post_single_content_footer',
		'operator' => 'contain',
		'value'    => 'footer-meta',
	),
);

/**
 * ====================================================
 * Blog > Post Layout: Default
 * ====================================================
 */

$add['entry_excerpt_length'] = array(
	array(
		'setting' => 'entry_content',
		'value'   => 'excerpt',
	),
);

$add['entry_read_more_text'] = array(
	array(
		'setting'  => 'entry_read_more_display',
		'operator' => '!=',
		'value'    => '',
	),
);

$add['entry_thumbnail_ignore_padding'] =
$add['entry_thumbnail_size']           = array(
	array(
		'setting'  => 'entry_thumbnail_position',
		'operator' => '!=',
		'value'    => '',
	),
);

$add['entry_header_meta'] = array(
	array(
		'setting'  => 'entry_header',
		'operator' => 'contain',
		'value'    => 'header-meta',
	),
);

$add['entry_footer_meta'] = array(
	array(
		'setting'  => 'entry_footer',
		'operator' => 'contain',
		'value'    => 'footer-meta',
	),
);

/**
 * ====================================================
 * Blog > Post Layout: Grid
 * ====================================================
 */

$add['entry_grid_read_more_text'] = array(
	array(
		'setting'  => 'entry_grid_read_more_display',
		'operator' => '!=',
		'value'    => '',
	),
);

$add['entry_grid_thumbnail_ignore_padding'] =
$add['entry_grid_thumbnail_size']           = array(
	array(
		'setting'  => 'entry_grid_thumbnail_position',
		'operator' => '!=',
		'value'    => '',
	),
);

$add['entry_grid_header_meta'] = array(
	array(
		'setting'  => 'entry_grid_header',
		'operator' => 'contain',
		'value'    => 'header-meta',
	),
);

$add['entry_grid_footer_meta'] = array(
	array(
		'setting'  => 'entry_grid_footer',
		'operator' => 'contain',
		'value'    => 'footer-meta',
	),
);

/**
 * ====================================================
 * Other Pages > Search Results
 * ====================================================
 */

$add['search_results_title_text'] = array(
	array(
		'setting'  => 'search_results_content_header',
		'operator' => 'contain',
		'value'    => 'title',
	),
);

/**
 * ====================================================
 * Other Pages > Error 404
 * ====================================================
 */

$add['error_404_image_width'] = array(
	array(
		'setting'  => 'error_404_image',
		'operator' => '!=',
		'value'    => '',
	),
);

$add['error_404_home_button_text'] = array(
	array(
		'setting' => 'error_404_home_button',
		'value'   => 1,
	),
);

// phpcs:enable Squiz.PHP.DisallowMultipleAssignments

return $add;
