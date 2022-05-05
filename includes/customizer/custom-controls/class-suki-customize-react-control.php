<?php
/**
 * Customizer custom control: React Base
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'Suki_Customize_Control' ) && ! class_exists( 'Suki_Customize_React_Control' ) ) {
	/**
	 * Base control
	 */
	class Suki_Customize_React_Control extends Suki_Customize_Control {
		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'suki-react';

		/**
		 * Renders the control wrapper and calls $this->render_content() for the internals.
		 *
		 * Modification from the original method:
		 * - Add `suki-customize-control` and `suki-customize-react-control` class.
		 */
		protected function render() {
			$id    = 'customize-control-' . str_replace( array( '[', ']' ), array( '-', '' ), $this->id );
			$class = 'suki-customize-control suki-customize-react-control customize-control customize-control-' . $this->type;

			printf( '<li id="%s" class="%s">', esc_attr( $id ), esc_attr( $class ) );
			$this->render_content();
			echo '</li>';
		}
	}

	// Register control type.
	$wp_customize->register_control_type( 'Suki_Customize_React_Control' );
}
