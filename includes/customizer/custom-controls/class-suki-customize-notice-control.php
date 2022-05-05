<?php
/**
 * Customizer custom control: Notice
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'Suki_Customize_Control' ) && ! class_exists( 'Suki_Customize_Notice_Control' ) ) {
	/**
	 * Notice control class
	 */
	class Suki_Customize_Notice_Control extends Suki_Customize_Control {
		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'suki-notice';

		/**
		 * Notice status (error / info / success / warning)
		 *
		 * @var string
		 */
		public $status = 'info';

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

			// `status` property.
			$this->json['status'] = $this->status;
		}

		/**
		 * Render Underscore JS template for this control's content.
		 */
		protected function content_template() {
			?>
			<div class="suki-notice notice notice-{{ data.status }} notice-alt inline">
				<# if ( data.label ) { #>
					<div class="suki-notice__label">{{ data.label }}</div>
				<# } #>
				<# if ( data.description ) { #>
					<p>{{{ data.description }}}</p>
				<# } #>
			</div>
			<?php
		}
	}

	// Register control type.
	$wp_customize->register_control_type( 'Suki_Customize_Notice_Control' );
}
