<?php
/**
 * Customizer custom control: Dimension
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Suki_Customize_Control_Dimension' ) ) :
/**
 * Dimension control class
 */
class Suki_Customize_Control_Dimension extends Suki_Customize_Control {
	/**
	 * @var string
	 */
	public $type = 'suki-dimension';

	/**
	 * Available choices: px, em, %.
	 *
	 * @var array
	 */
	public $units = array( '' );

	/**
	 * Constructor
	 */
	public function __construct( $manager, $id, $args = array() ) {
		parent::__construct( $manager, $id, $args );

		// Make sure there is at least 1 unit type.
		if ( empty( $this->units ) ) {
			$this->units = array( '' );
		}

		// Sanitize unit attributes.
		foreach ( $this->units as $key => $unit ) {
			$this->units[ $key ] = wp_parse_args( $unit, array(
				'min' => '',
				'max' => '',
				'step' => '',
				'label' => $key,
			) );
		}
	}

	/**
	 * Setup parameters for content rendering by Underscore JS template.
	 */
	public function to_json() {
		parent::to_json();

		$this->json['name'] = $this->id;
		$this->json['units'] = $this->units;

		$this->json['inputs'] = array();
		$this->json['structures'] = array();

		foreach ( $this->settings as $setting_key => $setting ) {
			$value = $this->value( $setting_key );
			if ( false === $value ) {
				$value = '';
			}

			// Convert raw value string into number and unit.
			$number = '' === $value ? '' : floatval( $value );
			$unit = str_replace( $number, '', $value );
			if ( ! array_key_exists( $unit, $this->units ) ) {
				$units = array_keys( $this->units );
				$unit = reset( $units );
			}

			// Add to inputs array.
			$this->json['inputs'][ $setting_key ] = array(
				'__link' => $this->get_link( $setting_key ),
				'value' => $value,
				'number' => $number,
				'unit' => $unit,
			);

			// Add to structures array.
			$device = 'desktop';
			if ( false !== strpos( $setting->id, '__' ) ) {
				$chunks = explode( '__', $setting->id );
				if ( in_array( $chunks[1], array( 'desktop', 'tablet', 'mobile' ) ) ) $device = $chunks[1];
			}
			$this->json['structures'][ $device ] = $setting_key;
		}

		$this->json['responsive'] = 1 < count( $this->json['structures'] ) ? true : false;
	}

	/**
	 * Render Underscore JS template for this control's content.
	 */
	protected function content_template() {
		?>
		<# if ( data.label ) { #>
			<span class="customize-control-title {{ data.responsive ? 'suki-responsive-title' : '' }}">
				{{{ data.label }}}
				<# if ( data.responsive ) { #>
					<span class="suki-responsive-switcher">
						<# _.each( data.structures, function( setting_key, device ) { #>
							<span class="suki-responsive-switcher-button preview-{{ device }}" data-device="{{ device }}"><span class="dashicons dashicons-{{ 'mobile' === device ? 'smartphone' : device }}"></span></span>
						<# }); #>
					</span>
				<# } #>
			</span>
		<# } #>
		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>
		<div class="customize-control-content">
			<# _.each( data.structures, function( setting_key, device ) { #>
				<div class="suki-dimension-fieldset suki-row {{ data.responsive ? 'suki-responsive-fieldset' : '' }} {{ 'desktop' == device ? 'active' : '' }} {{ 'preview-' + device }}">
					<div class="suki-row-item" style="width: 100%;">
						<input class="suki-dimension-input suki-input-with-unit" type="number" value="{{ data.inputs[ setting_key ].number }}" min="{{ data.units[ data.inputs[ setting_key ].unit ].min }}" max="{{ data.units[ data.inputs[ setting_key ].unit ].max }}" step="{{ data.units[ data.inputs[ setting_key ].unit ].step }}">
					</div>
					<div class="suki-row-item" style="width: 30px;">
						<select class="suki-dimension-unit suki-unit">
							<# _.each( data.units, function( unit_data, unit ) { #>
								<option value="{{ unit }}" {{ unit == data.inputs[ setting_key ].unit ? 'selected' : '' }} data-min="{{ unit_data.min }}" data-max="{{ unit_data.max }}" data-step="{{ unit_data.step }}">{{{ unit_data.label }}}</option>
							<# }); #>
						</select>
					</div>

					<input type="hidden" class="suki-dimension-value" value="{{ data.inputs[ setting_key ].value }}" {{{ data.inputs[ setting_key ].__link }}}>
				</div>
			<# }); #>
		</div>
		<?php
	}
}

// Register control type.
$wp_customize->register_control_type( 'Suki_Customize_Control_Dimension' );
endif;