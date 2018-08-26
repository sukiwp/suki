<?php
/**
 * Suki functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * ====================================================
 * Theme constants
 * ====================================================
 */

define( 'SUKI_INCLUDES_DIR', get_template_directory() . '/inc' );

define( 'SUKI_IMAGES_URL', get_template_directory_uri() . '/assets/images' );

define( 'SUKI_CSS_URL', get_template_directory_uri() . '/assets/css' );

define( 'SUKI_JS_URL', get_template_directory_uri() . '/assets/js' );

define( 'SUKI_VERSION', wp_get_theme( get_template() )->get( 'Version' ) );

define( 'SUKI_ASSETS_SUFFIX', SCRIPT_DEBUG ? '' : '.min' );

define( 'SUKI_PRO_URL', esc_url( 'https://sukiwp.com/pro/' ) );

/**
 * ====================================================
 * Main theme class
 * ====================================================
 */

require_once( SUKI_INCLUDES_DIR . '/class-suki.php' );