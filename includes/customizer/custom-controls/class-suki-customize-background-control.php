<?php
/**
 * Customizer custom control: Background
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'Suki_Customize_React_Control' ) && ! class_exists( 'Suki_Customize_Background_Control' ) ) {
	/**
	 * Background control class
	 */
	class Suki_Customize_Background_Control extends Suki_Customize_React_Control {
		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'suki-background';

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

			// Image attachment object.
			if ( array_key_exists( 'image', $this->settings ) ) {
				$attachment_id = attachment_url_to_postid( $this->settings['image']->value() );

				if ( $attachment_id ) {
					$this->json['imageAttachment'] = wp_prepare_attachment_for_js( $attachment_id );
				}
			}
		}
	}

	// Register control type.
	$wp_customize->register_control_type( 'Suki_Customize_Background_Control' );
}
