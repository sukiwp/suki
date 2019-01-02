<?php
/**
 * Migrate to 0.6.0
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Suki_Migrate_0_6_0 {

	/**
	 * Singleton instance
	 *
	 * @var Suki_Migrate_0_6_0
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
	 * @return Suki_Migrate_0_6_0
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
		$this->merge_section_layout_and_padding();
	}

	/**
	 * ====================================================
	 * Private functions
	 * ====================================================
	 */

	/**
	 * Build a new padding value for template sections.
	 *
	 * Formerly, there is an automatic padding added to the section when user select "Full width with side padding" (full-width-padding) value.
	 * Now, the full-width-padding option is gone, and the side padding is merged to "Padding" options.
	 */
	private function merge_section_layout_and_padding() {
		$containers = array(
			'header_top_bar_container',
			'header_main_bar_container',
			'header_bottom_bar_container',
			'page_header_container',
			'content_container',
			'footer_widgets_bar_container',
			'footer_bottom_bar_container',
		);

		foreach ( $containers as $key ) {
			if ( 'full-width-padding' === get_theme_mod( $key ) ) {
				set_theme_mod( $key, 'full-width' );
			}
		}

		$paddings = array(
			'header_top_bar_padding',
			'header_main_bar_padding',
			'header_bottom_bar_padding',
			'header_mobile_main_bar_padding',
			'page_header_padding',
			'content_padding',
			'footer_widgets_bar_padding',
			'footer_bottom_bar_padding',
		);

		foreach ( $paddings as $key ) {
			// Convert padding value if it has been saved to DB.
			$padding = get_theme_mod( $key );
			if ( false !== $padding ) {
				$padding = explode( ' ', $padding );

				// Merge side padding into padding.
				$padding[1] = '20px';
				$padding[3] = '20px';

				$padding = implode( ' ', $padding );

				// Update DB value.
				set_theme_mod( $key, $padding );

				// Split "header_mobile_main_bar_padding" into "header_mobile_main_bar_padding__tablet".
				if ( 'header_mobile_main_bar_padding' === $key ) {
					set_theme_mod( $key . '__tablet', $padding );
					remove_theme_mod( $key );
				}
			}

			// Convert the tablet and mobile padding values of some keys.
			if ( in_array( $key, array( 'page_header_padding', 'content_padding', 'footer_widgets_bar_padding', 'footer_bottom_bar_padding' ) ) ) {
				// Convert tablet padding value if it has been saved to DB.
				$key_tablet = $key . '__tablet';
				$padding_tablet = get_theme_mod( $key_tablet );
				if ( false !== $padding_tablet ) {
					$padding_tablet = explode( ' ', $padding_tablet );

					$padding_tablet[1] = '20px';
					$padding_tablet[3] = '20px';

					set_theme_mod( $key_tablet, implode( ' ', $padding_tablet ) );
				}

				// Convert mobile padding value if it has been saved to DB.
				$key_mobile = $key . '__mobile';
				$padding_mobile = get_theme_mod( $key_mobile );
				if ( false !== $padding_mobile ) {
					$padding_mobile = explode( ' ', $padding_mobile );

					$padding_mobile[1] = '20px';
					$padding_mobile[3] = '20px';

					set_theme_mod( $key_mobile, implode( ' ', $padding_mobile ) );
				}
			}
		}
	}
}

Suki_Migrate_0_6_0::instance();