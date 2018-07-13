<?php
/**
 * Plugin compatibility: Contact Form 7
 *
 * @link https://jetpack.me/
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Suki_Compatibility_Contact_Form_7 {

	/**
	 * Singleton instance
	 *
	 * @var Suki_Compatibility_Contact_Form_7
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
	 * @return Suki_Compatibility_Contact_Form_7
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
		add_action( 'suki_before_enqueue_main_css', array( $this, 'enqueue_css' ) );
	}
	
	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

	/**
	 * Enqueue custom CSS.
	 */
	public function enqueue_css() {
		wp_enqueue_style( 'suki-contact-form-7', SUKI_CSS_URL . '/compatibilities/contact-form-7' . SUKI_ASSETS_SUFFIX . '.css', array(), SUKI_VERSION );
		wp_style_add_data( 'suki-contact-form-7', 'rtl', 'replace' );
	}
}

Suki_Compatibility_Contact_Form_7::instance();