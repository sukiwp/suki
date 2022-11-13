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
	 * Version
	 *
	 * @var string
	 */
	const VERSION = '1.3.3';

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
				// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
				'meta_key'       => '_wp_page_template',
				// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value
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
				// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
				'meta_key'       => '_wp_page_template',
				// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value
				'meta_value'     => 'page-templates/page_builder_with_container.php',
			)
		);
		foreach ( $posts as $post ) {
			update_post_meta( $post->ID, '_wp_page_template', 'page-templates/page-builder-with-container.php' );
		}
	}
}

Suki_Migrate_1_3_3::instance();
