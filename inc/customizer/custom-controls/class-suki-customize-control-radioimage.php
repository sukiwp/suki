<?php
/**
 * Customizer custom control: Radio Image
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Suki_Customize_Control_RadioImage' ) ) :
/**
 * Multiple checkboxes control class
 */
class Suki_Customize_Control_RadioImage extends Suki_Customize_Control {
	/**
	 * @var string
	 */
	public $type = 'suki-radioimage';

	/**
	 * Setup parameters for content rendering by Underscore JS template.
	 */
	public function to_json() {
		parent::to_json();

		foreach ( $this->choices as $choice_value => $choice_data ) {
			$this->choices[ $choice_value ] = wp_parse_args( $choice_data, array(
				'label' => '',
				'image' => '',
			) );
		}

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
			<# _.each( data.choices, function( choice, value ) { #>
				<div class="suki-radioimage-item">
					<input type="radio" id="{{ data.name + '--' + value }}" name="{{ data.name }}" value="{{ value }}" class="suki-radioimage-input" {{ value === data.value ? 'checked' : '' }}>
					<label for="{{ data.name + '--' + value }}" tabindex="0">
						<# if ( choice.image ) { #>
							<img src="{{ choice.image }}">
						<# } #>
						<# if ( choice.label ) { #>
							<span>{{{ choice.label }}}</span>
						<# } #>
					</label>
				</div>
			<# }); #>
		</div>
		<?php
	}
}

// Register control type.
$wp_customize->register_control_type( 'Suki_Customize_Control_RadioImage' );
endif;