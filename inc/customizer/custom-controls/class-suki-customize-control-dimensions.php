<?php
/**
 * Customizer custom control: Dimensions
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Suki_Customize_Control_Dimensions' ) ) :
/**
 * Dimensions control class
 */
class Suki_Customize_Control_Dimensions extends Suki_Customize_Control {
	/**
	 * @var string
	 */
	public $type = 'suki-dimensions';

	/**
	 * Available choices: default, corners.
	 *
	 * @var string
	 */
	public $mode = 'default';

	/**
	 * Available choices: px, em, %.
	 *
	 * @var array
	 */
	public $units = array( '' );

	/**
	 * Setup parameters for content rendering by Underscore JS template.
	 */
	public function to_json() {
		parent::to_json();

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

		$this->json['name'] = $this->id;
		$this->json['units'] = $this->units;

		$this->json['inputs'] = array();
		$this->json['structures'] = array();

		foreach ( $this->settings as $setting_key => $setting ) {
			$value = $this->value( $setting_key );
			if ( false === $value ) {
				$value = '   '; // 3 empty space for default value
			}

			// Convert dimensions string into numbers and unit.
			$numbers = array();
			$units = array_keys( $this->units );
			$unit = reset( $units );
			$parts = explode( ' ', $value );
			foreach ( $parts as $part ) {
				$_number = '' === $part ? '' : floatval( $part );
				$_unit = str_replace( $_number, '', $part );
				
				$numbers[] = $_number;
				if ( '' !== $_unit ) {
					$unit = $_unit;
				}
			}

			// Add to inputs array.
			$this->json['inputs'][ $setting_key ] = array(
				'__link' => $this->get_link( $setting_key ),
				'value' => $value,
				'numbers' => $numbers,
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
				<div class="suki-dimensions-fieldset suki-row {{ data.responsive ? 'suki-responsive-fieldset' : '' }} {{ 'desktop' == device ? 'active' : '' }} {{ 'preview-' + device }}" data-linked="false">
					<label class="suki-row-item" style="width: 30px;">
						<span class="suki-small-label">&nbsp;</span>
						<button class="suki-dimensions-link button button-secondary dashicons dashicons-editor-unlink" tabindex="0"></button>
						<button class="suki-dimensions-unlink button button-primary dashicons dashicons-admin-links" tabindex="0"></button>
					</label>
					<# _.each( [ 'top', 'right', 'bottom', 'left' ], function( prop, i ) { #>
						<label class="suki-row-item">
							<span class="suki-small-label">{{{ prop }}}</span>
							<input class="suki-dimensions-input" type="number" value="{{ data.inputs[ setting_key ].numbers[ i ] }}" min="{{ data.units[ data.inputs[ setting_key ].unit ].min }}" max="{{ data.units[ data.inputs[ setting_key ].unit ].max }}" step="{{ data.units[ data.inputs[ setting_key ].unit ].step }}">
						</label>
					<# }); #>
					<label class="suki-row-item" style="width: 30px;">
						<span class="suki-small-label">&nbsp;</span>
						<select class="suki-dimensions-unit suki-unit">
							<# _.each( data.units, function( unit_data, unit ) { #>
								<option value="{{ unit }}" {{ unit == data.inputs[ setting_key ].unit ? 'selected' : '' }} data-min="{{ unit_data.min }}" data-max="{{ unit_data.max }}" data-step="{{ unit_data.step }}">{{{ unit_data.label }}}</option>
							<# }); #>
						</select>
					</label>

					<input type="hidden" class="suki-dimensions-value" value="{{ data.inputs[ setting_key ].value }}" {{{ data.inputs[ setting_key ].__link }}}>
				</div>
			<# }); #>
		</div>
		<?php
	}
}

// Register control type.
$wp_customize->register_control_type( 'Suki_Customize_Control_Dimensions' );
endif;