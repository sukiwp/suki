<?php
/**
 * Customizer default values.
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
 * Global Modules > Breadcrumb
 * ====================================================
 */

$add['breadcrumb_plugin'] = '';

$add['breadcrumb_trail_home']                     = 1;
$add['breadcrumb_trail_current_page']             = 1;
$add['breadcrumb_hide_when_only_home_or_current'] = 1;

return $add;
