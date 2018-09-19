<?php
/**
 * Plugin compatibility: Gutenberg
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Suki_Compatibility_Gutenberg {

	/**
	 * Singleton instance
	 *
	 * @var Suki_Compatibility_Gutenberg
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
	 * @return Suki_Compatibility_Gutenberg
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
		// Compatibility CSS
		add_action( 'suki/frontend/before_enqueue_main_css', array( $this, 'enqueue_css' ) );
	}

	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

	/**
	 * Enqueue compatibility CSS.
	 */
	public function enqueue_css() {
		wp_enqueue_style( 'suki-gutenberg', SUKI_CSS_URL . '/compatibilities/gutenberg' . SUKI_ASSETS_SUFFIX . '.css', array(), SUKI_VERSION );
		wp_style_add_data( 'suki-gutenberg', 'rtl', 'replace' );
	}
}

Suki_Compatibility_Gutenberg::instance();