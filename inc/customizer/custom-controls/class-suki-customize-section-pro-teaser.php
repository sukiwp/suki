<?php
/**
 * Customizer custom section: Pro Teaser
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( class_exists( 'WP_Customize_Section' ) && ! class_exists( 'Suki_Customize_Section_Pro_Teaser' ) ) :
/**
 * Pro Teaser section class.
 */
class Suki_Customize_Section_Pro_Teaser extends WP_Customize_Section {
	/**
	 * @var string
	 */
	public $type = 'suki-section-pro-teaser';

	/**
	 * @var string
	 */
	public $url = '#';

	/**
	 * @var array
	 */
	public $features = array();

	/**
	 * Setup parameters for content rendering by Underscore JS template.
	 */
	public function json() {
		$json = parent::json();
		$json['url'] = $this->url;
		$json['features'] = $this->features;

		return $json;
	}

	/**
	 * Render Underscore JS template for this control's content.
	 */
	protected function render_template() {
		?>
		<li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }}">
			<div class="suki-pro-teaser">
				<div class="wp-clearfix">
					<h3>{{{ data.title }}}</h3>
					<a href="{{ data.url }}" class="button button-small button-secondary alignright" target="_blank" rel="noopener"><?php echo esc_html_x( 'Learn More', 'Suki Pro upsell', 'suki' ); ?></a>
				</div>
				<# if ( 0 < data.features.length ) { #>
					<ul>
						<# _.each( data.features, function( feature, i ) { #>
							<li>{{{ feature }}}</li>
						<# }); #>
					</ul>
				<# } #>
			</div>
		</li>
		<?php
	}
}

// Register section type.
$wp_customize->register_section_type( 'Suki_Customize_Section_Pro_Teaser' );
endif;