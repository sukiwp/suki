<?php
/**
 * Customizer custom control: Typography
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'Suki_Customize_React_Control' ) && ! class_exists( 'Suki_Customize_Typography_Control' ) ) {
	/**
	 * Typography control class
	 */
	class Suki_Customize_Typography_Control extends Suki_Customize_React_Control {
		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'suki-typography';

		/**
		 * Setup the parameters passed to the JavaScript via JSON.
		 */
		public function to_json() {
			/**
			 * Pass all `params` in the parent class (Suki_Customize_Control).
			 */

			parent::to_json();

			/**
			 * Pass more properties from this class as `params`.
			 */

			// Responsive structures.
			if ( 1 < count( $this->settings ) ) {
				foreach ( $this->settings as $setting_key => $setting ) {
					// Extract setting type.
					// Skip if no valid type found in the setting id.
					if ( ! preg_match( '/(font_family|font_weight|font_style|text_transform|font_size|line_height|letter_spacing)/', $setting->id, $matches ) ) {
						continue;
					}
					$type = $matches[1];

					// Add to responsiveStructures array.
					$device = 'desktop';
					if ( false !== strpos( $setting->id, '__' ) ) {
						preg_match( '/^(.*?)__(.*?)$/', $setting->id, $matches );

						if ( in_array( $matches[2], array( 'desktop', 'tablet', 'mobile' ), true ) ) {
							$device = $matches[2];
						}
					}
					$this->json['responsiveStructures'][ $device ][ $type ] = $setting_key;
				}
			}
		}
	}

	// Register control type.
	$wp_customize->register_control_type( 'Suki_Customize_Typography_Control' );
}
