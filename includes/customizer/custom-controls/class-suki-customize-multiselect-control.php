<?php
/**
 * Suki Customizer's Multi-select control (React)
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Suki_Customize_MultiSelect_Control' ) ) {
	/**
	 * Multi-select control class
	 */
	class Suki_Customize_MultiSelect_Control extends Suki_Customize_Control {
		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'suki-multiselect';

		/**
		 * Select items limit.
		 * `0` means unlimited.
		 *
		 * @var integer
		 */
		public $items_limit = 0;

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

			// `items_limit` property.
			$this->json['itemsLimit'] = $this->items_limit;
		}
	}

	// Register control type.
	$wp_customize->register_control_type( 'Suki_Customize_MultiSelect_Control' );
}
