<?php
/**
 * Migrate to 1.3.0
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Suki_Migrate_1_3_0 {

	/**
	 * Singleton instance
	 *
	 * @var Suki_Migrate_1_3_0
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
	 * @return Suki_Migrate_1_3_0
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
		$this->migrate_page_header_title_text();
	}

	/**
	 * ====================================================
	 * Private functions
	 * ====================================================
	 */

	/**
	 * Migrate all page header title text option keys.
	 *
	 * The reason behind this migration:
	 * The title text should affect the content header title as well not just the page header title.
	 */
	private function migrate_page_header_title_text() {
		foreach ( Suki_Customizer::instance()->get_all_page_settings_types() as $ps_type => $ps_data ) {
			// Define the option key.
			$option_key = 'page_settings_' . $ps_type;

			// Get the values.
			$mod = get_theme_mod( $option_key, array() );

			// Process title text for 404 and search page.
			if ( in_array( $ps_type, array( 'search', '404' ) ) ) {
				// Check if user ever filled the custom title text options.
				if ( isset( $mod['page_header_title_text__' . $ps_type ] ) ) {
					// Move the value to a new key.
					$mod['title_text'] = $mod['page_header_title_text__' . $ps_type ];

					// Remove the old key.
					unset( $mod['page_header_title_text__' . $ps_type ] );
				}
			}
			
			// Process title text for archive pages.
			elseif ( 0 < strpos( $ps_type, '_archive' ) ) {
				// Check if user ever filled the custom title text options.
				if ( isset( $mod['page_header_title_text__post_type_archive'] ) ) {
					// Move the value to a new key.
					$mod['title_text'] = $mod['page_header_title_text__post_type_archive'];

					// Remove the old key.
					unset( $mod['page_header_title_text__post_type_archive'] );
				}

				// Check if user ever filled the custom title text options.
				if ( isset( $mod['page_header_title_text__taxonomy_archive'] ) ) {
					// Move the value to a new key.
					$mod['tax_title_text'] = $mod['page_header_title_text__taxonomy_archive'];

					// Remove the old key.
					unset( $mod['page_header_title_text__taxonomy_archive'] );
				}
			}

			// Save the new values.
			set_theme_mod( $option_key, $mod );
		}
	}
}

Suki_Migrate_1_3_0::instance();