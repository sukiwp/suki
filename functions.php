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

define( 'SUKI_INCLUDES_PATH', get_template_directory() . '/inc' );

define( 'SUKI_PLUGINS_PATH', get_template_directory() . '/plugins' );

define( 'SUKI_PLUGINS_URL', get_template_directory_uri() . '/plugins' );

define( 'SUKI_IMAGES_URL', get_template_directory_uri() . '/assets/images' );

define( 'SUKI_CSS_URL', get_template_directory_uri() . '/assets/css' );

define( 'SUKI_JS_URL', get_template_directory_uri() . '/assets/js' );

define( 'SUKI_VERSION', wp_get_theme( get_template() )->get( 'Version' ) );

define( 'SUKI_ASSETS_SUFFIX', SCRIPT_DEBUG ? '' : '.min' );

// define( 'SUKI_API_URL', 'https://api.singlestroke.io/suki/wp-json/singlestroke/v1' );
define( 'SUKI_API_URL', 'http://testing.local/wp-json/singlestroke/v1' );

/**
 * ====================================================
 * Main theme class
 * ====================================================
 */

require_once( SUKI_INCLUDES_PATH . '/class-suki.php' );