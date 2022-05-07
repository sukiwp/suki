<?php
/**
 * Customizer custom control: Pro Teaser
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'Suki_Customize_Control' ) && ! class_exists( 'Suki_Customize_Pro_Teaser_Control' ) ) {
	/**
	 * Pro Teaser control class
	 */
	class Suki_Customize_Pro_Teaser_Control extends Suki_Customize_Control {
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
		 * Features array.
		 *
		 * @var array
		 */
		public $features = array();

		/**
		 * Setup the parameters passed to the JavaScript via JSON.
		 */
		public function to_json() {
			/**
			 * Pass all `params` in the parent class (Suki_Customize_Control).
			 */

			parent::to_json();

			/**
			 * Pass more properties from this class as `params`.
			 */

			// `url` property.
			$this->json['url'] = $this->url;

			// `features` property.
			$this->json['features'] = $this->features;
		}

		/**
		 * Render Underscore JS template for this control's content.
		 */
		protected function content_template() {
			?>
			<div class="suki-pro-teaser">
				<# if ( data.label ) { #>
					<a href="{{ data.url }}" target="_blank" rel="noopener">
						<h3 class="accordion-section-title">{{{ data.label }}}</h3>
					</a>
				<# } #>
				<# if ( 0 < data.features.length ) { #>
					<ul>
						<# _.each( data.features, function( feature, i ) { #>
							<li>{{{ feature }}}</li>
						<# } ); #>
					</ul>
				<# } #>
			</div>
			<?php
		}
	}
}
