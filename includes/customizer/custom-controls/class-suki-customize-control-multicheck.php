<?php
/**
 * Customizer custom control: Multiple checkboxes
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Suki_Customize_Control_MultiCheck' ) ) :
/**
 * Multiple checkboxes control class
 */
class Suki_Customize_Control_MultiCheck extends Suki_Customize_Control {
	/**
	 * @var string
	 */
	public $type = 'suki-multicheck';

	/**
	 * Setup parameters for content rendering by Underscore JS template.
	 */
	public function to_json() {
		parent::to_json();

		$this->json['name'] = $this->id;
		$this->json['choices'] = $this->choices;
		$this->json['value'] = $this->value();

		$this->json['__link'] = $this->get_link();
	}

	/**
	 * Render Underscore JS template for this control's content.
	 */
	protected function content_template() {
		?>
		<# if ( data.label ) { #>
			<span class="customize-control-title">{{{ data.label }}}</span>
		<# } #>
		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>
		<div class="customize-control-content">
			<ul>
				<# _.each( data.choices, function( label, value ) { #>
					<li>
						<label>
							<input type="checkbox" class="suki-multicheck-input" value="{{ value }}" {{ -1 < data.value.indexOf( value ) ? 'checked' : '' }}>
							<span>{{{ label }}}</span>
						</label>
					</li>
				<# }); #>
			</ul>
		</div>
		<?php
	}
}

// Register control type.
$wp_customize->register_control_type( 'Suki_Customize_Control_MultiCheck' );
endif;