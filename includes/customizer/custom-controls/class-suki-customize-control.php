<?php
/**
 * Suki Customizer's Base Control
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Suki_Customize_Control' ) ) {
	/**
	 * Base control
	 */
	class Suki_Customize_Control extends WP_Customize_Control {
		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'suki-base';

		/**
		 * Disable the default content rendering from WP_Customize_Control.
		 */
		public function render_content() {}

		/**
		 * Setup the parameters passed to the JavaScript via JSON.
		 */
		public function to_json() {
			/**
			 * Pass all `params` as defined in the parent class (WP_Customize_Control).
			 */

			parent::to_json();

			/**
			 * Pass more properties as `params` from the parent class (WP_Customize_Control).
			 */

			// `choices` property for controls with options to select / choose.
			$this->json['choices'] = $this->choices;

			// `input_attrs` property.
			$this->json['inputAttributes'] = $this->input_attrs;
		}

		/**
		 * Renders the control wrapper and calls $this->render_content() for the internals.
		 *
		 * Modification from the original method:
		 * - Add `suki-customize-control` class.
		 */
		protected function render() {
			$id    = 'customize-control-' . str_replace( array( '[', ']' ), array( '-', '' ), $this->id );
			$class = 'suki-customize-control customize-control customize-control-' . $this->type;

			printf( '<li id="%s" class="%s">', esc_attr( $id ), esc_attr( $class ) );
			$this->render_content();
			echo '</li>';
		}
	}

	// Register control type.
	$wp_customize->register_control_type( 'Suki_Customize_Control' );
}
