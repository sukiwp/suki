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

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Suki_Customize_Control_Heading' ) ) {
	/**
	 * Heading control class
	 */
	class Suki_Customize_Control_Heading extends Suki_Customize_Control {
		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'suki-heading';

		/**
		 * Render control's content
		 */
		protected function render_content() {
			if ( ! empty( $this->label ) ) {
				?>
				<span class="suki-heading-tabindex" tabindex="0"></span>
				<div class="suki-heading"><?php echo $this->label; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
				<?php
				if ( ! empty( $this->description ) ) {
					?>
					<p class="description customize-control-description"><?php echo $this->description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
					<?php
				}
			}
		}
	}
}
