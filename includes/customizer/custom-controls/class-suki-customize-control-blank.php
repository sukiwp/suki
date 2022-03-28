<?php
/**
 * Customizer custom control: Blank
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Suki_Customize_Control_Blank' ) ) {
	/**
	 * Blank control class
	 */
	class Suki_Customize_Control_Blank extends WP_Customize_Control {
		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'suki-blank';

		/**
		 * Render control's content.
		 */
		protected function render_content() {
			if ( ! empty( $this->label ) ) {
				?>
				<span class="customize-control-title"><?php echo $this->label; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
				<?php
			}

			if ( ! empty( $this->description ) ) {
				?>
				<span class="description customize-control-description"><?php echo $this->description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
				<?php
			}
		}
	}
}
