<?php
/**
 * Suki Customizer's Dimensions control (React)
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Suki_Customize_Dimensions_Control' ) ) {
	/**
	 * Dimensions control class
	 */
	class Suki_Customize_Dimensions_Control extends Suki_Customize_Control {
		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'suki-dimensions';

		/**
		 * Units choices and rules.
		 *
		 * @var integer
		 */
		public $units = array();

		/**
		 * Constructor.
		 *
		 * @param WP_Customize_Manager $manager Customizer Manager object.
		 * @param integer              $id      Control ID.
		 * @param array                $args    Arguments array.
		 */
		public function __construct( $manager, $id, $args = array() ) {
			parent::__construct( $manager, $id, $args );

			// Sanitize unit attributes.
			foreach ( $this->units as $key => $unit ) {
				$this->units[ $key ] = wp_parse_args(
					$unit,
					array(
						'min'     => '',
						'max'     => '',
						'step'    => '',
						'default' => '',
						'label'   => $key,
					)
				);

				if ( empty( $this->units[ $key ]['default'] ) ) {
					$this->units[ $key ]['default'] = $this->units[ $key ]['min'];
				}
			}
		}

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

			// `units` property.
			$this->json['units'] = suki_convert_associative_array_into_simple_array( $this->units );

			// Responsive structures.
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
		}
	}

	// Register control type.
	$wp_customize->register_control_type( 'Suki_Customize_Dimensions_Control' );
}
