<?php
/**
 * Customizer custom section: Pro Link
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( class_exists( 'WP_Customize_Section' ) && ! class_exists( 'Suki_Customize_Section_Pro_Link' ) ) :
/**
 * Pro Link section class.
 */
class Suki_Customize_Section_Pro_Link extends WP_Customize_Section {
	/**
	 * @var string
	 */
	public $type = 'suki-section-pro-link';

	/**
	 * @var string
	 */
	public $url = '#';

	/**
	 * Setup parameters for content rendering by Underscore JS template.
	 */
	public function json() {
		$json = parent::json();
		$json['url'] = $this->url;

		return $json;
	}

	/**
	 * Render Underscore JS template for this control's content.
	 */
	protected function render_template() {
		?>
		<li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }}">
			<a class="accordion-section-title" href="{{ data.url }}" target="_blank" rel="noopener">
				<h3>{{{ data.title }}}</h3>
			</a>
		</li>
		<?php
	}
}

// Register section type.
$wp_customize->register_section_type( 'Suki_Customize_Section_Pro_Link' );
endif;