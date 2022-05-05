<?php
/**
 * Customizer custom control: Radio Image
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'Suki_Customize_React_Control' ) && ! class_exists( 'Suki_Customize_RadioImage_Control' ) ) {
	/**
	 * Multiple checkboxes control class
	 */
	class Suki_Customize_RadioImage_Control extends Suki_Customize_React_Control {
		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'suki-radioimage';

		/**
		 * Columns.
		 *
		 * @var columns
		 */
		public $columns = 0;

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

			// `choices` property for controls with options to select / choose.
			$this->json['choices'] = suki_convert_associative_array_into_simple_array( $this->choices );

			// `columns` property.
			$this->json['columns'] = $this->columns;
		}
	}

	// Register control type.
	$wp_customize->register_control_type( 'Suki_Customize_RadioImage_Control' );
}
