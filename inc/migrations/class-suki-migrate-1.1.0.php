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
		$this->convert_page_header_elements();
	}

	/**
	 * ====================================================
	 * Private functions
	 * ====================================================
	 */

	/**
	 * Convert Page Header elements.
	 *
	 * Formerly, there are some settings to change page header layout: layout, effective width, show/hide breadcrumb toggle.
	 * Now, use a builder control with 3 locations (left, center, right) and user can freely put title and breadcrumb whenever they like. Also remove effective width option.
	 */
	private function convert_page_header_elements() {
		$layout = get_theme_mod( 'page_header_layout' );

		switch ( $layout ) {
			case 'left':
			case 'right':
			case 'center':
				// Set elements
				$elements = array( 'title' );
				if ( intval( get_theme_mod( 'page_header_breadcrumb' ) ) ) {
					$elements[] = 'breadcrumb';
				}

				// Set the new option key and value.
				set_theme_mod( 'page_header_elements_' . $layout, $elements );
				break;

			case 'left-right':
				set_theme_mod( 'page_header_elements_left', array( 'title' ) );

				if ( intval( get_theme_mod( 'page_header_breadcrumb' ) ) ) {
					set_theme_mod( 'page_header_elements_right', array( 'breadcrumb' ) );
				}
				break;


			case 'right-left':
				set_theme_mod( 'page_header_elements_right', array( 'title' ) );

				if ( intval( get_theme_mod( 'page_header_breadcrumb' ) ) ) {
					set_theme_mod( 'page_header_elements_left', array( 'breadcrumb' ) );
				}
				break;
		}

		// Remove the old option keys from theme mods.
		remove_theme_mod( 'page_header_layout' );
		remove_theme_mod( 'page_header_layout_width' );
		remove_theme_mod( 'page_header_breadcrumb' );
	}
}

Suki_Migrate_1_1_0::instance();