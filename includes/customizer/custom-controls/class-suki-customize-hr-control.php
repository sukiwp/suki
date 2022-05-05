<?php
/**
 * Customizer custom control: HR (horizontal line)
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'Suki_Customize_Control' ) && ! class_exists( 'Suki_Customize_HR_Control' ) ) {
	/**
	 * Horizontal line control class
	 */
	class Suki_Customize_HR_Control extends Suki_Customize_Control {
		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'suki-hr';

		/**
		 * Render control's content
		 */
		protected function render_content() {
			?>
			<hr>
			<?php
		}
	}
}
