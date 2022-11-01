<?php
/**
 * Suki theme's functions.php file.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ====================================================
 * Theme constants
 * ====================================================
 */

define( 'SUKI_INCLUDES_DIR', trailingslashit( get_template_directory() ) . 'includes' );

define( 'SUKI_IMAGES_URL', trailingslashit( get_template_directory_uri() ) . 'assets/images' );
define( 'SUKI_IMAGES_DIR', trailingslashit( get_template_directory() ) . 'assets/images' );

define( 'SUKI_CSS_URL', trailingslashit( get_template_directory_uri() ) . 'assets/css' );
define( 'SUKI_CSS_DIR', trailingslashit( get_template_directory() ) . 'assets/css' );

define( 'SUKI_JS_URL', trailingslashit( get_template_directory_uri() ) . 'assets/js' );
define( 'SUKI_JS_DIR', trailingslashit( get_template_directory() ) . 'assets/js' );

define( 'SUKI_SCRIPTS_URL', trailingslashit( get_template_directory_uri() ) . 'assets/scripts' );
define( 'SUKI_SCRIPTS_DIR', trailingslashit( get_template_directory() ) . 'assets/scripts' );

define( 'SUKI_VERSION', wp_get_theme( get_template() )->get( 'Version' ) );

define( 'SUKI_ASSETS_SUFFIX', SCRIPT_DEBUG ? '' : '.min' );

define( 'SUKI_PRO_WEBSITE_URL', esc_url( 'https://sukiwp.com/pro/' ) );

/**
 * ====================================================
 * Main theme class
 * ====================================================
 */

require_once trailingslashit( SUKI_INCLUDES_DIR ) . 'class-suki.php';
