<?php
/**
 * Customizer custom control: Toggle
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Suki_Customize_Control_Toggle' ) ) {
	/**
	 * Toggle control class
	 */
	class Suki_Customize_Control_Toggle extends Suki_Customize_Control {
		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'suki-toggle';

		/**
		 * Setup parameters for content rendering by Underscore JS template.
		 */
		public function to_json() {
			parent::to_json();

			/**
			 * Add general variables.
			 */

			$this->json['name'] = $this->id;

			$this->json['value'] = $this->value();

			$this->json['link'] = $this->get_link();
		}

		/**
		 * Don't render the control content from PHP, as it's rendered via JS on load.
		 */
		public function render_content() {}

		/**
		 * Render Underscore JS template for this control's content.
		 */
		protected function content_template() {
			?>
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{{ data.label }}}</span>
			<# } #>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
			<div class="customize-control-content">
				<input id="{{ data.name }}" type="checkbox" value="1" {{{ data.link }}}>
				<label for="{{ data.name }}" class="suki-toggle-ui">
					<span class="suki-toggle-ui-handle"></span>
				</label>
			</div>
			<?php
		}
	}

	// Register control type.
	$wp_customize->register_control_type( 'Suki_Customize_Control_Toggle' );
}
