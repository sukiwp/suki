<?php
/**
 * Customizer custom control: Multi-select
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'Suki_Customize_React_Control' ) && ! class_exists( 'Suki_Customize_MultiSelect_Control' ) ) {
	/**
	 * Multi-select control class
	 */
	class Suki_Customize_MultiSelect_Control extends Suki_Customize_React_Control {
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
		 * Whether to implement sortable feature or not.
		 * If enabled, user can sort the selected items.
		 * Otherwise, the selected items order will remain as the choices list.
		 *
		 * @var boolean
		 */
		public $is_sortable = false;

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

			// `is_sortable` property.
			$this->json['isSortable'] = $this->is_sortable;
		}
	}

	// Register control type.
	$wp_customize->register_control_type( 'Suki_Customize_MultiSelect_Control' );
}
