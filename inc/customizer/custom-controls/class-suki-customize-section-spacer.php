<?php
/**
 * Customizer custom section: Spacer
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( class_exists( 'WP_Customize_Section' ) && ! class_exists( 'Suki_Customize_Section_Spacer' ) ) :
/**
 * Spacer section class.
 */
class Suki_Customize_Section_Spacer extends WP_Customize_Section {
	/**
	 * @var string
	 */
	public $type = 'suki-section-spacer';

	/**
	 * Render Underscore JS template for this section.
	 */
	protected function render_template() {
		?>
		<li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }}"></li>
		<?php
	}
}

// Register section type.
$wp_customize->register_section_type( 'Suki_Customize_Section_Spacer' );
endif;