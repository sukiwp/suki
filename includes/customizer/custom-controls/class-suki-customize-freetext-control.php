<?php
/**
 * Customizer custom control: Free Text
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'Suki_Customize_Control' ) && ! class_exists( 'Suki_Customize_FreeText_Control' ) ) {
	/**
	 * Free Text control class
	 */
	class Suki_Customize_FreeText_Control extends Suki_Customize_Control {
		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'suki-freetext';

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
