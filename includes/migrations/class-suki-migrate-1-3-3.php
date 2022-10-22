<?php
/**
 * Migrate to 1.3.3
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Migration class for Suki 1.3.3.
 */
class Suki_Migrate_1_3_3 extends Suki_Migrate {

	/**
	 * Singleton instance
	 *
	 * @var Suki_Migrate_1_3_3
	 */
	private static $instance;

	/**
	 * Version
	 *
	 * @var string
	 */
	const VERSION = '1.3.3';

	/**
	 * ====================================================
	 * Singleton & constructor functions
	 * ====================================================
	 */

	/**
	 * Get singleton instance.
	 *
	 * @return Suki_Migrate_1_3_3
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
		$this->migrate_page_template_slug();
	}

	/**
	 * Revert the page template values on all pages, from "page_builder" to "page-builder".
	 */
	private function migrate_page_template_slug() {
		$posts = get_posts(
			array(
				'post_type'      => 'any',
				'posts_per_page' => -1,
				'meta_key'       => '_wp_page_template',
				'meta_value'     => 'page-templates/page_builder.php',
			)
		);
		foreach ( $posts as $post ) {
			update_post_meta( $post->ID, '_wp_page_template', 'page-templates/page-builder.php' );
		}

		$posts = get_posts(
			array(
				'post_type'      => 'any',
				'posts_per_page' => -1,
				'meta_key'       => '_wp_page_template',
				'meta_value'     => 'page-templates/page_builder_with_container.php',
			)
		);
		foreach ( $posts as $post ) {
			update_post_meta( $post->ID, '_wp_page_template', 'page-templates/page-builder-with-container.php' );
		}
	}
}

Suki_Migrate_1_3_3::instance();
