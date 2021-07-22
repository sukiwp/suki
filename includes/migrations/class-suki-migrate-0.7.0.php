<?php
/**
 * Migrate to 0.7.0
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Suki_Migrate_0_7_0 {

	/**
	 * Singleton instance
	 *
	 * @var Suki_Migrate_0_7_0
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
	 * @return Suki_Migrate_0_7_0
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
		$this->convert_page_header_bg_overlay_to_color();
		$this->rename_menu_highlight();
	}

	/**
	 * ====================================================
	 * Private functions
	 * ====================================================
	 */

	/**
	 * Convert Page Header background overlay opacity to an independent color option.
	 *
	 * Formerly, user can only set the opacity where the overlay color inherits from background color.
	 * Now, user can specify different background overlay color than the background color.
	 */
	private function convert_page_header_bg_overlay_to_color() {
		$opacity = get_theme_mod( 'page_header_bg_overlay_opacity' );

		if ( ! empty( $opacity ) ) {
			$color = get_theme_mod( 'page_header_bg_color' );

			// If page header background color is set.
			if ( ! empty( $color )  ) {
				// If opacity is less than 1, convert to rgba.
				if ( 1 < floatval( $opacity ) ) {
					// If page header background color is in hex format.
					if ( 0 === strpos( $color, '#' ) ) {
						// Strip the '#' prefix.
						$color = substr( $color, 1 );

						// Convert to array of 3 components.
						$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );

						// Convert hex array to rgb.
						$rgb =  array_map( 'hexdec', $hex );

						// Build a new value along with the opacity.
						$new_value = 'rgba(' . $rgb[0] . ',' . $rgb[1] . ',' . $rgb[2] . ',' . $opacity . ')';
						
						// Save to DB.
						set_theme_mod( 'page_header_bg_overlay_color', $new_value );
					}
				}
			}

			// Remove background overlay opacity key on theme mods.
			remove_theme_mod( 'page_header_bg_overlay_opacity' );
		}
	}

	/**
	 * Rename menu highlight color option keys, because now there is additonal option for active menu highlight colors.
	 *
	 * Formerly, it is only "_menu_highlight_".
	 * Now, it is "_menu_hover_hightlight_".
	 */
	private function rename_menu_highlight() {
		foreach ( array( 'top_bar', 'main_bar', 'bottom_bar' ) as $bar ) {
			foreach ( array( 'highlight_color', 'highlight_text_color' ) as $color ) {
				// Get value from DB.
				$value = get_theme_mod( 'header_' . $bar . '_menu_' . $color );

				// If there is value, rename old key into new key,
				if ( false !== $value ) {
					// Save to DB with new key.
					set_theme_mod( 'header_' . $bar . '_menu_hover_' . $color, $value );

					// Remove the old key.
					remove_theme_mod( 'header_' . $bar . '_menu_' . $color );
				}
			}
		}
	}
}

Suki_Migrate_0_7_0::instance();