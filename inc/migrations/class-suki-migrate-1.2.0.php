<?php
/**
 * Migrate to 1.2.0
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Suki_Migrate_1_2_0 {

	/**
	 * Singleton instance
	 *
	 * @var Suki_Migrate_1_2_0
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
	 * @return Suki_Migrate_1_2_0
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
		$this->migrate_entry_grid_defaults();
		$this->migrate_woocommerce_options();

		//woocommerce_cart_two_columns
	}

	/**
	 * ====================================================
	 * Private functions
	 * ====================================================
	 */

	/**
	 * Migrate entry grid efault values.
	 */
	private function migrate_entry_grid_defaults() {
		set_theme_mod( 'entry_grid_padding', '1.25em 1.5em 1.25em 1.5em' );
		set_theme_mod( 'entry_grid_border', '1px 1px 1px 1px' );
		set_theme_mod( 'entry_grid_featured_media_ignore_padding', 1 );
	}

	/**
	 * Migrate WooCommerce options.
	 */
	private function migrate_woocommerce_options() {
		// Deprecate "woocommerce_cart_two_columns" and replace with "woocommerce_cart_layout".
		if ( intval( get_theme_mod( 'woocommerce_cart_two_columns' ) ) ) {
			set_theme_mod( 'woocommerce_cart_layout', '2-columns' );
			remove_theme_mod( 'woocommerce_cart_two_columns' );
		}

		// Deprecate "woocommerce_checkout_two_columns" and replace with "woocommerce_checkout_layout".
		if ( intval( get_theme_mod( 'woocommerce_checkout_two_columns' ) ) ) {
			set_theme_mod( 'woocommerce_checkout_layout', '2-columns' );
			remove_theme_mod( 'woocommerce_checkout_two_columns' );
		}
	}
}

Suki_Migrate_1_2_0::instance();