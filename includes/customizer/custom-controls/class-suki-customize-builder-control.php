<?php
/**
 * Customizer custom control: Builder
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'Suki_Customize_React_Control' ) && ! class_exists( 'Suki_Customize_Builder_Control' ) ) {
	/**
	 * Builder control class
	 */
	class Suki_Customize_Builder_Control extends Suki_Customize_React_Control {
		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'suki-builder';

		/**
		 * Builder areas.
		 *
		 * @var array
		 */
		public $areas = array();
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

			// `choices` property.
			$this->json['choices'] = suki_convert_associative_array_into_simple_array( $this->choices );

			// `areas` property.
			$this->json['areas'] = suki_convert_associative_array_into_simple_array( $this->areas, 'id', 'label' );
		}
	}

	// Register control type.
	$wp_customize->register_control_type( 'Suki_Customize_Builder_Control' );
}
