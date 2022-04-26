<?php
/**
 * Suki Customizer's Toggle control (React)
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Suki_Customize_Toggle_Control' ) ) {
	/**
	 * Toggle control class
	 */
	class Suki_Customize_Toggle_Control extends Suki_Customize_Control {
		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'suki-toggle';
	}

	// Register control type.
	$wp_customize->register_control_type( 'Suki_Customize_Toggle_Control' );
}
