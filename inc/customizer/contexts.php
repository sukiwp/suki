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
foreach ( array( 'main_bar', 'top_bar', 'bottom_bar' ) as $type ) {
	$add['suki_section_header_' . $type ] = array(
		array(
			'setting'  => '__device',
			'value'    => 'desktop',
		),
	);
	
	if ( 'main_bar' !==  $type ) {
		$add['header_' . $type . '_container'] = array(
			array(
				'setting'  => 'header_top_bar_merged',
				'operator' => '!=',
				'value'    => 1,
			),
		);
	}

	$add['header_' . $type . '_menu_hover_highlight_color'] =
	$add['header_' . $type . '_menu_hover_highlight_text_color'] =
	$add['header_' . $type . '_menu_active_highlight_color'] =
	$add['header_' . $type . '_menu_active_highlight_text_color'] = array(
		array(
			'setting'  => 'header_' . $type . '_menu_highlight',
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
	'relation' => 'OR',
	array(
		'setting'  => '__device',
		'value'    => 'tablet',
	),
	array(
		'setting'  => '__device',
		'value'    => 'mobile',
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
	'relation' => 'OR',
	array(
		'setting'  => '__device',
		'value'    => 'tablet',
	),
	array(
		'setting'  => '__device',
		'value'    => 'mobile',
	),
);

/**
 * ====================================================
 * Page Header (Title Bar)
 * ====================================================
 */

$add['breadcrumb_plugin'] =
$add['page_header_breadcrumb_typography'] =
$add['page_header_breadcrumb_text_color'] =
$add['page_header_breadcrumb_link_text_color'] =
$add['page_header_breadcrumb_link_hover_text_color'] = array(
	array(
		'setting'  => 'page_header_breadcrumb',
		'value'    => 1,
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

/**
 * ====================================================
 * Page Settings
 * ====================================================
 */

foreach( Suki_Customizer::instance()->get_all_page_settings_types() as $type => $type_data ) {
	if ( false === strpos( $type, '_singular' ) ) {
		$add['page_settings_' . $type . '[page_header_bg_image]'] = array(
			array(
				'setting'  => 'page_settings_' . $type . '[page_header_bg]',
				'value'    => 'custom',
			),
		);
	}
}

$contexts = array_merge_recursive( $contexts, $add );