<?php
/**
 * Customizer custom control: Color
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
	class Suki_Customize_Color_Control extends Suki_Customize_React_Control {
		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'suki-color';

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

			// Default value.
			$this->json['defaultValue'] = $this->setting->default;
		}
	}

	// Register control type.
	$wp_customize->register_control_type( 'Suki_Customize_Color_Control' );
}
