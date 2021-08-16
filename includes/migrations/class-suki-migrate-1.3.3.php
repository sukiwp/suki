<?php
/**
 * Migrate to 1.3.3
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Suki_Migrate_1_3_3 {

	/**
	 * Singleton instance
	 *
	 * @var Suki_Migrate_1_3_3
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
	 * @return Suki_Migrate_1_3_3
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
		$this->migrate_page_template_slug();
	}

	/**
	 * ====================================================
	 * Private functions
	 * ====================================================
	 */

	/**
	 * Revert the page template values on all pages, from "page_builder" to "page-builder".
	 */
	private function migrate_page_template_slug() {
		$posts = get_posts( array(
			'post_type'      => 'any',
			'posts_per_page' => -1,
			'meta_key'       => '_wp_page_template',
			'meta_value'     => 'page-templates/page_builder.php',
		) );
		foreach ( $posts as $post ) {
			update_post_meta( $post->ID, '_wp_page_template', 'page-templates/page-builder.php' );
		}

		$posts = get_posts( array(
			'post_type'      => 'any',
			'posts_per_page' => -1,
			'meta_key'       => '_wp_page_template',
			'meta_value'     => 'page-templates/page_builder_with_container.php',
		) );
		foreach ( $posts as $post ) {
			update_post_meta( $post->ID, '_wp_page_template', 'page-templates/page-builder-with-container.php' );
		}
	}
}

Suki_Migrate_1_3_3::instance();