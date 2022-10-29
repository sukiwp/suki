<?php
/**
 * Customizer custom section: Responsive tabs
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'WP_Customize_Section' ) && ! class_exists( 'Suki_Customize_Responsive_Tabs_Section' ) ) {
	/**
	 * Responsive tabs section class.
	 */
	class Suki_Customize_Responsive_Tabs_Section extends WP_Customize_Section {
		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'suki-responsive-tabs';

		/**
		 * Render Underscore JS template for this section.
		 */
		protected function render_template() {
			?>
			<li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }}">
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
			</li>
			<?php
		}
	}

	// Register section type.
	$wp_customize->register_section_type( 'Suki_Customize_Responsive_Tabs_Section' );
}
