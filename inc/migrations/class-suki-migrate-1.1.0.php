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
		$this->migrate_default_values();
		$this->convert_page_header_elements();
	}

	/**
	 * ====================================================
	 * Private functions
	 * ====================================================
	 */

	/**
	 * Default values changes.
	 */
	private function migrate_default_values() {
		// Page Header is now enabled by default.
		// Old = 0
		// New = 1
		if ( false === get_theme_mod( 'page_header' ) ) {
			set_theme_mod( 'page_header', 0 );
		}

		// Header sections now has no border by default.
		// Old = 0px 0px 1px 0px
		// New = 0px 0px 0px 0px
		$header_sections = array(
			'header_top_bar_border',
			'header_main_bar_border',
			'header_bottom_bar_border',
			'header_mobile_main_bar_border',

			'page_header_border',
		);
		foreach ( $header_sections as $key ) {
			if ( false === get_theme_mod( $key ) ) {
				set_theme_mod( $key, '0px 0px 1px 0px' );
			}
		}

		// Footer sections now has no border by default.
		// Old = 1px 0px 0px 0px
		// New = 0px 0px 0px 0px
		$footer_sections = array(
			'footer_widgets_bar_border',
			'footer_bottom_bar_border',
		);
		foreach ( $footer_sections as $key ) {
			if ( false === get_theme_mod( $key ) ) {
				set_theme_mod( $key, '1px 0px 0px 0px' );
			}
		}
	}

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