<?php
/**
 * Customizer control's conditional contexts.
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
 * Global Configurations > Breadcrumb
 * ====================================================
 */

$add['notice_breadcrumb_plugin'] = array(
	array(
		'setting'  => 'breadcrumb_plugin',
		'operator' => '!=',
		'value'    => '',
	),
);

$add['hr_breadcrumb'] = array(
	array(
		'setting' => 'breadcrumb_plugin',
		'value'   => '',
	),
);

$add['breadcrumb_trail_home'] = array(
	array(
		'setting' => 'breadcrumb_plugin',
		'value'   => '',
	),
);

$add['breadcrumb_trail_current_page'] = array(
	array(
		'setting' => 'breadcrumb_plugin',
		'value'   => '',
	),
);

$add['breadcrumb_hide_when_only_home_or_current'] = array(
	array(
		'setting' => 'breadcrumb_plugin',
		'value'   => '',
	),
);

return $add;
