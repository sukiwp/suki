<?php
/**
 * Suki Customizer's Color Select control (React)
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Suki_Customize_Color_Select_Control' ) ) {
	/**
	 * Color Select control class
	 */
	class Suki_Customize_Color_Select_Control extends Suki_Customize_Control {
		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'suki-color-select';

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
	$wp_customize->register_control_type( 'Suki_Customize_Color_Select_Control' );
}
