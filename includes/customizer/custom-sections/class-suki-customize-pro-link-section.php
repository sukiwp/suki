<?php
/**
 * Customizer custom section: Pro Link
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'WP_Customize_Section' ) && ! class_exists( 'Suki_Customize_Pro_Link_Section' ) ) {
	/**
	 * Pro Link section class.
	 */
	class Suki_Customize_Pro_Link_Section extends WP_Customize_Section {
		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'suki-pro-link';

		/**
		 * Landing page URL.
		 *
		 * @var string
		 */
		public $url = '#';

		/**
		 * Setup the parameters passed to the JavaScript via JSON.
		 */
		public function json() {
			/**
			 * Pass all `params` in the parent class (WP_Customize_Section).
			 */

			$json = parent::json();

			/**
			 * Pass more properties from this class as `params`.
			 */

			// `url` property.
			$json['url'] = $this->url;

			return $json;
		}

		/**
		 * Render Underscore JS template for this section.
		 */
		protected function render_template() {
			?>
			<li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }}">
				<# if ( data.title ) { #>
					<a href="{{ data.url }}" target="_blank" rel="noopener">
						<h3 class="accordion-section-title">{{{ data.title }}}</h3>
					</a>
				<# } #>
			</li>
			<?php
		}
	}

	// Register section type.
	$wp_customize->register_section_type( 'Suki_Customize_Pro_Link_Section' );
}
