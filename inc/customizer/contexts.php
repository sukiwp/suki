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
 * Page Canvas & Wrapper
 * ====================================================
 */

$add['heading_boxed_page'] =
$add['boxed_page_width'] =
$add['boxed_page_shadow'] =
$add['hr_boxed_page_outside'] =
$add['outside_bg_color'] =
$add['outside_bg_image'] =
$add['outside_bg_position'] =
$add['outside_bg_size'] =
$add['outside_bg_repeat'] =
$add['outside_bg_attachment'] = array(
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
 * Header > Mobile Drawer (Popup)
 * ====================================================
 */

$add['suki_section_header_mobile_main_bar'] =
$add['suki_section_header_mobile_vertical_bar'] = array(
	array(
		'setting'  => '__device',
		'operator' => 'in',
		'value'    => array( 'tablet', 'mobile' ),
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
		'operator' => 'in',
		'value'    => array( 'tablet', 'mobile' ),
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
 * Blog > Posts Page
 * ====================================================
 */

$add['edit_entry_default'] = array(
	array(
		'setting'  => 'blog_index_loop_mode',
		'value'    => 'default',
	),
);

$add['edit_entry_grid'] = array(
	array(
		'setting'  => 'blog_index_loop_mode',
		'value'    => 'grid',
	),
);

/**
 * ====================================================
 * Blog > Post Layout: Default
 * ====================================================
 */

$add['entry_read_more_text'] = array(
	array(
		'setting'  => 'entry_read_more_display',
		'operator' => '!=',
		'value'    => '',
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

/**
 * ====================================================
 * Page Settings
 * ====================================================
 */

foreach( Suki_Customizer::instance()->get_all_page_settings_types() as $ps_type => $ps_data ) {
	if ( false === strpos( $ps_type, '_singular' ) ) {
		$add['page_settings_' . $ps_type . '[page_header_bg_image]'] = array(
			array(
				'setting'  => 'page_settings_' . $ps_type . '[page_header_bg]',
				'value'    => 'custom',
			),
		);
	}
}

return $add;