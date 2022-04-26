<?php
/**
 * Customizer custom section: Spacer
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'WP_Customize_Section' ) && ! class_exists( 'Suki_Customize_Spacer_Section' ) ) {
	/**
	 * Spacer section class.
	 */
	class Suki_Customize_Spacer_Section extends WP_Customize_Section {
		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'suki-spacer';

		/**
		 * Render Underscore JS template for this section.
		 */
		protected function render_template() {
			?>
			<li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }}">
				<# if ( 0 < data.title.length ) { #>
					<h2>{{{ data.title }}}</h2>
				<# } #>
			</li>
			<?php
		}
	}

	// Register section type.
	$wp_customize->register_section_type( 'Suki_Customize_Spacer_Section' );
}
