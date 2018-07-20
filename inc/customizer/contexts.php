<?php
/**
 * Customizer default values.
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$add = array();

/**
 * ====================================================
 * Page Container
 * ====================================================
 */

$add['boxed_page_width'] =
$add['boxed_page_shadow'] =
$add['heading_outside'] =
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
 * Page Settings
 * ====================================================
 */

foreach ( Suki_Customizer::instance()->get_all_page_settings_types() as $type => $type_data ) {
	$add['hr_page_settings_' . $type . '_page_header'] =
	$add['page_settings_' . $type . '[custom_page_title]'] = 
	$add['page_settings_' . $type . '[page_header_keep_content_header]'] = array(
		array(
			'setting'  => 'page_settings_' . $type . '[disable_page_header]',
			'operator' => '!=',
			'value'    => 1,
		),
	);
}

$contexts = array_merge_recursive( $contexts, $add );