<?php
/**
 * Migrate to 2.0.0
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Migration class for Suki 2.0.0.
 */
class Suki_Migrate_2_0_0 {

	/**
	 * Singleton instance
	 *
	 * @var Suki_Migrate_2_0_0
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
	 * @return Suki_Migrate_2_0_0
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
		$this->migrate_page_settings_meta_key();

		// $this->migrate_container_default_to_wide();
	}

	/**
	 * ====================================================
	 * Private functions
	 * ====================================================
	 */

	/**
	 * Migrate `_suki_page_settings` post meta key to `suki_page_settings`.
	 *
	 * Array post meta doesn't need to use `_` prefix, because it's automatically hidden.
	 * ref: https://developer.wordpress.org/plugins/metadata/managing-post-metadata/#hidden-arrays
	 */
	private function migrate_page_settings_meta_key() {
		global $wpdb;

		$updated = $wpdb->update(
			$wpdb->prefix . 'postmeta',
			array(
				'meta_key' => 'suki_page_settings',
			),
			array(
				'meta_key' => '_suki_page_settings',
			)
		);

		return $updated;
	}

	private function migrate_container_default_to_wide() {

	}
}

Suki_Migrate_2_0_0::instance();
