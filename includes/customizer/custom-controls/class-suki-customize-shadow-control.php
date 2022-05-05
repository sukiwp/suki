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
		 * Units choices and rules.
		 *
		 * @var array
		 */
		public $units = array(
			'px'  => array(
				'step' => 1,
			),
			'em'  => array(
				'step' => 0.01,
			),
			'rem' => array(
				'step' => 0.01,
			),
		);

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

			// `units` property.
			$this->json['units'] = suki_convert_associative_array_into_simple_array( $this->units );

			// `props` property.
			$this->json['props'] = $this->props;
		}
	}

	// Register control type.
	$wp_customize->register_control_type( 'Suki_Customize_Shadow_Control' );
}
