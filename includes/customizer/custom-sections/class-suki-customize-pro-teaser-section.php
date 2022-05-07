<?php
/**
 * Customizer custom section: Pro Teaser
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'WP_Customize_Section' ) && ! class_exists( 'Suki_Customize_Pro_Teaser_Section' ) ) {
	/**
	 * Pro Teaser section class.
	 */
	class Suki_Customize_Pro_Teaser_Section extends WP_Customize_Section {
		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'suki-pro-teaser';

		/**
		 * Landing page URL.
		 *
		 * @var string
		 */
		public $url = '#';

		/**
		 * Features.
		 *
		 * @var array
		 */
		public $features = array();

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

			// `features` property.
			$json['features'] = $this->features;

			return $json;
		}

		/**
		 * Render Underscore JS template for this control's content.
		 */
		protected function render_template() {
			?>
			<li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }} suki-pro-teaser">
				<# if ( data.title ) { #>
					<a href="{{ data.url }}" target="_blank" rel="noopener">
						<h3 class="accordion-section-title">{{{ data.title }}}</h3>
					</a>
				<# } #>
				<# if ( 0 < data.features.length ) { #>
					<ul>
						<# _.each( data.features, function( feature, i ) { #>
							<li>{{{ feature }}}</li>
						<# } ); #>
					</ul>
				<# } #>
			</li>
			<?php
		}
	}

	// Register section type.
	$wp_customize->register_section_type( 'Suki_Customize_Pro_Teaser_Section' );
}
