<?php
/**
 * Suki Customizer's Color control (React)
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Suki_Customize_Color_Control' ) ) {
	/**
	 * Color control class
	 */
	class Suki_Customize_Color_Control extends Suki_Customize_Control {
		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'suki-color';

		/**
		 * Value when checked.
		 *
		 * @var integer
		 */
		public $palette = array();

		/**
		 * Constructor.
		 *
		 * @param WP_Customize_Manager $manager Customizer Manager object.
		 * @param integer              $id      Control ID.
		 * @param array                $args    Arguments array.
		 */
		public function __construct( $manager, $id, $args = array() ) {
			parent::__construct( $manager, $id, $args );

			// Setup color palette.
			for ( $i = 1; $i <= 8; $i++ ) {
				$this->palette[] = array(
					/* translators: %d: color index number */
					'name'  => sprintf( esc_html__( 'Theme Color %d', 'suki' ), $i ),
					'color' => 'var(--color-palette-' . $i . ')',
				);
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

			// `palette` property.
			$this->json['palette'] = $this->palette;

			// Localization.
			$this->json['l10n'] = array(
				/* translators: %d: Color palette index */
				'colorPaletteName' => esc_html__( 'Theme Color %d', 'suki' ),
			);
		}
	}

	// Register control type.
	$wp_customize->register_control_type( 'Suki_Customize_Color_Control' );
}
