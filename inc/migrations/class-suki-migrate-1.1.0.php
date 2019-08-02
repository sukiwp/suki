<?php
/**
 * Migrate to 1.1.0
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Suki_Migrate_1_1_0 {

	/**
	 * Singleton instance
	 *
	 * @var Suki_Migrate_1_1_0
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
	 * @return Suki_Migrate_1_1_0
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
		$this->split_woocommerce_advanced_module();
	}

	/**
	 * ====================================================
	 * Private functions
	 * ====================================================
	 */

	/**
	 * Split "WooCommerce Advanced" module to multiple modules.
	 */
	private function split_woocommerce_advanced_module() {
		$active_modules = get_option( 'suki_pro_active_modules', array() );

		if ( in_array( 'woocommerce-advanced', $active_modules ) ) {
			// Add the separate WooCommerce modules.
			foreach ( suki_get_pro_modules() as $module_slug => $module_data ) {
				if ( 'woocommerce' === $module_data['category'] ) {
					$active_modules[] = $module_slug;
				}
			}
			
			update_option( 'suki_pro_active_modules', $active_modules );
		}
	}
}

Suki_Migrate_1_1_0::instance();