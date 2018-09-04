<?php
/**
 * Customizer default values.
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$colors = Suki_Customizer::instance()->get_default_colors();

$add = array();

/**
 * ====================================================
 * General Elements > Gutenberg Elements
 * ====================================================
 */

$add['gutenberg_alignwide_negative_margin'] = '100px';
$add['gutenberg_columns_gutter'] = '15px';

$defaults = array_merge_recursive( $defaults, $add );