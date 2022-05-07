<?php
/**
 * Customizer custom control: Slider
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'Suki_Customize_React_Control' ) && ! class_exists( 'Suki_Customize_Slider_Control' ) ) {
	/**
	 * Slider control class
	 */
	class Suki_Customize_Slider_Control extends Suki_Customize_React_Control {
		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'suki-slider';

		/**
		 * Minimum number value.
		 *
		 * @var integer
		 */
		public $min = 0;

		/**
		 * Maximum number value.
		 *
		 * @var integer
		 */
		public $max = 100;

		/**
		 * Step value.
		 *
		 * @var integer
		 */
		public $step = 1;

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

			// `min` property.
			$this->json['min'] = $this->min;

			// `max` property.
			$this->json['max'] = $this->max;

			// `step` property.
			$this->json['step'] = $this->step;

			// Responsive structures.
			if ( 1 < count( $this->settings ) ) {
				foreach ( $this->settings as $setting_key => $setting ) {
					// Add to responsiveStructures array.
					$device = 'desktop';
					if ( false !== strpos( $setting->id, '__' ) ) {
						preg_match( '/^(.*?)__(.*?)$/', $setting->id, $matches );

						if ( in_array( $matches[2], array( 'desktop', 'tablet', 'mobile' ), true ) ) {
							$device = $matches[2];
						}
					}
					$this->json['responsiveStructures'][ $device ] = $setting_key;
				}
			} else {
				$this->json['responsiveStructures']['global'] = 'default';
			}
		}
	}

	// Register control type.
	$wp_customize->register_control_type( 'Suki_Customize_Slider_Control' );
}
