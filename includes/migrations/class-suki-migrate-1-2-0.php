<?php
/**
 * Migrate to 1.2.0
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Migration class for Suki 1.2.0.
 */
class Suki_Migrate_1_2_0 extends Suki_Migrate {

	/**
	 * Singleton instance
	 *
	 * @var Suki_Migrate_1_2_0
	 */
	private static $instance;

	/**
	 * Version
	 *
	 * @var string
	 */
	const VERSION = '1.2.0';

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
	 * ====================================================
	 * Migration functions
	 * ====================================================
	 */

	/**
	 * Run migration
	 */
	protected function run() {
		$this->migrate_entry_grid_defaults();
		$this->migrate_woocommerce_options();
	}

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
		if ( boolval( get_theme_mod( 'woocommerce_cart_two_columns' ) ) ) {
			set_theme_mod( 'woocommerce_cart_layout', '2-columns' );
			remove_theme_mod( 'woocommerce_cart_two_columns' );
		}

		// Deprecate "woocommerce_checkout_two_columns" and replace with "woocommerce_checkout_layout".
		if ( boolval( get_theme_mod( 'woocommerce_checkout_two_columns' ) ) ) {
			set_theme_mod( 'woocommerce_checkout_layout', '2-columns' );
			remove_theme_mod( 'woocommerce_checkout_two_columns' );
		}
	}
}

Suki_Migrate_1_2_0::instance();
