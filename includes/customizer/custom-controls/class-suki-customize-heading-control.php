<?php
/**
 * Customizer custom control: Heading
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'Suki_Customize_Control' ) && ! class_exists( 'Suki_Customize_Heading_Control' ) ) {
	/**
	 * Heading control class
	 */
	class Suki_Customize_Heading_Control extends Suki_Customize_Control {
		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'suki-heading';

		/**
		 * Render Underscore JS template for this control's content.
		 */
		protected function content_template() {
			?>
			<# if ( data.label ) { #>
				<span class="suki-heading-tabindex" tabindex="0"></span>
				<div class="suki-heading">{{ data.label }}</div>
			<# } #>
			<# if ( data.description ) { #>
				<div class="description customize-control-description">{{{ data.description }}}</div>
			<# } #>
			<?php
		}
	}

	// Register control type.
	$wp_customize->register_control_type( 'Suki_Customize_Heading_Control' );
}
