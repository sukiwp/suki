<?php
/**
 * Plugin compatibility: Brizy
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Suki_Compatibility_Brizy {

	/**
	 * Singleton instance
	 *
	 * @var Suki_Compatibility_Brizy
	 */
	private static $instance;

	/**
	 * ====================================================
	 * Singleton & constructor functions
	 * ====================================================
	 */

	/**
	 * Get singleton instance.
	 *
	 * @return Suki_Compatibility_Brizy
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Class constructor
	 */
	protected function __construct() {
		// Add frontend CSS.
		add_action( 'brizy_preview_enqueue_scripts', array( $this, 'add_frontend_css' ) );
	}
	
	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

	/**
	 * Add additional CSS to Brizy frontend.
	 */
	public function add_frontend_css() {
		wp_add_inline_style( 'brizy-preview', suki_minify_css_string( '.brz .brz-container__wrap { max-width: ' . suki_get_theme_mod( 'container_width' ) . '; }' ) );
	}
}

Suki_Compatibility_Brizy::instance();