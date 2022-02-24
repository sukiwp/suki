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

define( 'SUKI_CSS_URL', trailingslashit( get_template_directory_uri() ) . 'assets/css' );

define( 'SUKI_JS_URL', trailingslashit( get_template_directory_uri() ) . 'assets/js' );

define( 'SUKI_VERSION', wp_get_theme( get_template() )->get( 'Version' ) );

define( 'SUKI_ASSETS_SUFFIX', SCRIPT_DEBUG ? '' : '.min' );

define( 'SUKI_PRO_WEBSITE_URL', esc_url( 'https://sukiwp.com/pro/' ) );

/**
 * ====================================================
 * Main theme class
 * ====================================================
 */

require_once SUKI_INCLUDES_DIR . '/class-suki.php';
