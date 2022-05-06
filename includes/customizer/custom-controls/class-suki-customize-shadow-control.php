<?php
/**
 * Customizer custom control: Shadow
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'Suki_Customize_React_Control' ) && ! class_exists( 'Suki_Customize_Shadow_Control' ) ) {
	/**
	 * Shadow control class
	 */
	class Suki_Customize_Shadow_Control extends Suki_Customize_React_Control {
		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'suki-shadow';

		/**
		 * Properties to show.
		 *
		 * @var array
		 */
		public $props = array( 'x', 'y', 'blur', 'spread', 'position' );

		/**
		 * Setup parameters for content rendering by Underscore JS template.
		 */
		public function to_json() {
			/**
			 * Pass all `params` in the parent class (Suki_Customize_Control).
			 */

			parent::to_json();

			/**
			 * Pass more properties from this class as `params`.
			 */

			// `props` property.
			$this->json['props'] = $this->props;
		}
	}

	// Register control type.
	$wp_customize->register_control_type( 'Suki_Customize_Shadow_Control' );
}
