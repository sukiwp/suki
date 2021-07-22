<?php
/**
 * Customizer control's conditional display.
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$add = array();

/**
 * ====================================================
 * Global Modules > Breadcrumb
 * ====================================================
 */

$add['notice_breadcrumb_plugin'] = array(
	array(
		'setting'  => 'breadcrumb_plugin',
		'operator' => '!=',
		'value'    => '',
	),
);

$add['hr_breadcrumb'] =
$add['breadcrumb_trail_home'] =
$add['breadcrumb_trail_current_page'] = array(
	array(
		'setting'  => 'breadcrumb_plugin',
		'value'    => '',
	),
);

/**
 * ====================================================
 * Page Canvas
 * ====================================================
 */

$add['heading_boxed_page'] =
$add['boxed_page_width'] =
$add['boxed_page_shadow'] =
$add['hr_boxed_page_outside'] =
$add['outside_bg_color'] =
$add['outside_bg'] = array(
	array(
		'setting'  => 'page_layout',
		'value'    => 'boxed',
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
	$add['suki_section_header_' . $bar ] = array(
		array(
			'setting'  => '__device',
			'value'    => 'desktop',
		),
	);
	
	if ( 'main_bar' !== $bar ) {
		$add['header_' . $bar . '_container'] = array(
			array(
				'setting'  => 'header_' . $bar . '_merged',
				'operator' => '!=',
				'value'    => 1,
			),
		);
		$add['header_' . $bar . '_merged_gap'] = array(
			array(
				'setting'  => 'header_' . $bar . '_merged',
				'operator' => '==',
				'value'    => 1,
			),
		);
	}

	$add['header_' . $bar . '_menu_hover_highlight_color'] =
	$add['header_' . $bar . '_menu_hover_highlight_text_color'] =
	$add['header_' . $bar . '_menu_active_highlight_color'] =
	$add['header_' . $bar . '_menu_active_highlight_text_color'] = array(
		array(
			'setting'  => 'header_' . $bar . '_menu_highlight',
			'operator' => '!=',
			'value'    => 'none',
		),
	);
}

/**
 * ====================================================
 * Header > Mobile Main Bar
 * Header > Mobile Popup
 * ====================================================
 */

$add['suki_section_header_mobile_main_bar'] =
$add['suki_section_header_mobile_vertical_bar'] = array(
	array(
		'setting'  => '__device',
		'operator' => '!=',
		'value'    => 'desktop',
	),
);

$add['header_mobile_vertical_bar_full_screen_position'] = array(
	array(
		'setting'  => 'header_mobile_vertical_bar_display',
		'value'    => 'full-screen',
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

// Header Elements
$add['header_elements' ] = array(
	array(
		'setting'  => '__device',
		'value'    => 'desktop',
	),
);

// Mobile Header Elements
$add['header_mobile_elements'] = array(
	array(
		'setting'  => '__device',
		'operator' => '!=',
		'value'    => 'desktop',
	),
);

/**
 * ====================================================
 * Header > Logo
 * ====================================================
 */

$add['heading_header_logo'] =
$add['custom_logo'] =
$add['header_logo_width'] = array(
	array(
		'setting'  => '__device',
		'value'    => 'desktop',
	),
);

$add['heading_header_mobile_logo'] =
$add['custom_logo_mobile'] =
$add['header_mobile_logo_width'] = array(
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
		'setting'  => 'blog_index_loop_mode',
		'value'    => 'default',
	),
);

$add['blank_edit_entry_grid'] = array(
	array(
		'setting'  => 'blog_index_loop_mode',
		'value'    => 'grid',
	),
);

$add['post_archive_title_text'] =
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
		'setting'  => 'entry_content',
		'value'    => 'excerpt',
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
$add['entry_thumbnail_size'] = array(
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
$add['entry_grid_thumbnail_size'] = array(
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
		'setting'  => 'error_404_home_button',
		'value'    => 1,
	),
);

/**
 * ====================================================
 * Individual Page Settings
 * ====================================================
 */

foreach( Suki_Customizer::instance()->get_all_page_settings_types() as $ps_type => $ps_data ) {
	$add[ $ps_type . '_hero_bg_image'] = array(
		array(
			'setting'  => $ps_type . '_hero_bg',
			'value'    => 'custom',
		),
	);

	$add[ $ps_type . '_content_layout'] = array(
		array(
			'setting'  => $ps_type . '_content_container',
			'operator' => '!=',
			'value'    => 'narrow',
		),
	);

	// Archives.
	if ( preg_match( '/(_archive)/', $ps_type ) ) {
		$add[ $ps_type . '_title_text'] = array(
			array(
				'setting'  => $ps_type . '_content_header',
				'operator' => 'contain',
				'value'    => 'title',
			),
		);
		$add[ $ps_type . '_tax_title_text'] = array(
			array(
				'setting'  => $ps_type . '_content_header',
				'operator' => 'contain',
				'value'    => 'title',
			),
		);
	}

}

return $add;