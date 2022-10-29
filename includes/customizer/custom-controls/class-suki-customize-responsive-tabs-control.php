<?php
/**
 * Customizer custom control: Responsive tabs
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'Suki_Customize_Control' ) && ! class_exists( 'Suki_Customize_Responsive_Tabs_Control' ) ) {
	/**
	 * Responsive tabs control class
	 */
	class Suki_Customize_Responsive_Tabs_Control extends Suki_Customize_Control {
		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'suki-responsive-tabs';

		/**
		 * Render control's content.
		 */
		protected function render_content() {
			?>
			<div class="suki-responsive-tabs nav-tab-wrapper wp-clearfix">
				<button class="suki-responsive-tabs__button nav-tab nav-tab-active" data-device="desktop">
					<span class="dashicons dashicons-desktop"></span>
					<span><?php esc_html_e( 'Desktop', 'suki' ); ?></span>
				</button>
				<button class="suki-responsive-tabs__button nav-tab" data-device="tablet">
					<span class="dashicons dashicons-smartphone"></span>
					<span><?php esc_html_e( 'Mobile', 'suki' ); ?></span>
				</button>
			</div>
			<?php
		}
	}
}
