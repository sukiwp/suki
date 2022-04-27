<?php
/**
 * Suki Customizer's Color control (React)
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Suki_Customize_Color_Control' ) ) {
	/**
	 * Color control class
	 */
	class Suki_Customize_Color_Control extends Suki_Customize_Control {
		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'suki-color';

		/**
		 * Whether to integrate color palette or not.
		 *
		 * @var boolean
		 */
		public $has_palette = true;

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

			// `has_palette` property.
			$this->json['hasPalette'] = $this->has_palette;

			// Default value.
			$this->json['defaultValue'] = $this->setting->default;
		}
	}

	// Register control type.
	$wp_customize->register_control_type( 'Suki_Customize_Color_Control' );
}
