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
		// Add editor preview CSS.
		add_action( 'brizy_editor_enqueue_scripts', array( $this, 'add_editor_preview_css' ) );
	}
	
	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

	/**
	 * Add additional CSS to Brizy editor's preview.
	 */
	public function add_editor_preview_css() {
		wp_add_inline_style( 'brizy-editor', suki_minify_css_string( '.brz-ed > * { pointer-events: none; } #brz-ed-root, #brz-toolbar-portal { pointer-events: auto; }' ) );
	}
}

Suki_Compatibility_Brizy::instance();