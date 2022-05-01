<?php
/**
 * Customizer custom control: Dimensions
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Suki_Customize_Dimensions_Control' ) ) {
	/**
	 * Dimensions control class
	 */
	class Suki_Customize_Dimensions_Control extends WP_Customize_Control {
		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'suki-dimensions';

		/**
		 * Control mode.
		 * Available choices: default, corners.
		 *
		 * @var string
		 */
		public $mode = 'default';

		/**
		 * Control units.
		 *
		 * @var array
		 */
		public $units = array();

		/**
		 * Constructor.
		 *
		 * @param WP_Customize_Manager $manager Customizer Manager object.
		 * @param integer              $id      Control ID.
		 * @param array                $args    Arguments array.
		 */
		public function __construct( $manager, $id, $args = array() ) {
			parent::__construct( $manager, $id, $args );

			// Make sure there is at least 1 unit type.
			if ( empty( $this->units ) ) {
				$this->units = array(
					'' => array(
						'min'   => '',
						'max'   => '',
						'step'  => '',
						'label' => '',
					),
				);
			}

			// Sanitize unit attributes.
			foreach ( $this->units as $key => $unit ) {
				$this->units[ $key ] = wp_parse_args(
					$unit,
					array(
						'min'   => '',
						'max'   => '',
						'step'  => '',
						'label' => $key,
					)
				);
			}
		}

		/**
		 * Setup parameters for content rendering by Underscore JS template.
		 */
		public function to_json() {
			parent::to_json();

			/**
			 * Add general variables.
			 */

			$this->json['name'] = $this->id;

			$this->json['units'] = $this->units;

			/**
			 * Build settingsData and responsiveStructures.
			 */

			$this->json['settingsData'] = array();

			$this->json['responsiveStructures'] = array();

			foreach ( $this->settings as $setting_key => $setting_obj ) {
				// Get setting value.
				$value = $this->value( $setting_key );

				// Explode full value into array.
				$value_array = explode( ' ', $value );

				// Sanitize value_array array.
				$value_array = array(
					0 => suki_array_value( $value_array, 0, '' ),
					1 => suki_array_value( $value_array, 1, '' ),
					2 => suki_array_value( $value_array, 2, '' ),
					3 => suki_array_value( $value_array, 3, '' ),
				);

				// Build array to store each dimension value data.
				$exploded_value = array();
				foreach ( $value_array as $value_item ) {
					// Split each dimension value into number and unit.
					$_number = '' === $value_item ? '' : floatval( $value_item );
					$_unit   = preg_replace( '/[0-9]+/', '', $value_item );

					// When no unit found in the value, use the first choice as the selected unit (unit should not be empty).
					if ( empty( $_unit ) ) {
						$_unit = array_keys( $this->units )[0];
					}

					$exploded_value[] = array(
						'raw'    => '' === $_number ? '' : $_number . $_unit,
						'number' => $_number,
						'unit'   => $_unit,
					);
				}

				// Build settingsData array.
				$this->json['settingsData'][ $setting_key ] = array(
					'link'          => $this->get_link( $setting_key ),
					'value'         => $value,
					'explodedValue' => $exploded_value,
				);

				// Build responsiveStructures array.
				$device = 'desktop';
				if ( false !== strpos( $setting_obj->id, '__' ) ) {
					$chunks = explode( '__', $setting_obj->id );

					if ( in_array( $chunks[1], array( 'desktop', 'tablet', 'mobile' ), true ) ) {
						$device = $chunks[1];
					}
				}
				$this->json['responsiveStructures'][ $device ] = $setting_key;
			}

			// Whether this control has responsive settings or not.
			$this->json['hasResponsive'] = 1 < count( $this->json['responsiveStructures'] ) ? true : false;
		}

		/**
		 * Don't render the control content from PHP, as it's rendered via JS on load.
		 */
		public function render_content() {}

		/**
		 * Render Underscore JS template for this control's content.
		 */
		protected function content_template() {
			?>
			<# if ( data.label ) { #>
				<span class="customize-control-title {{ data.hasResponsive ? 'suki-responsive-title' : '' }}">
					{{{ data.label }}}
					<# if ( data.hasResponsive ) { #>
						<span class="suki-responsive-switcher">
							<# _.each( data.responsiveStructures, function( settingKey, device ) { #>
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
				<# _.each( data.responsiveStructures, function( settingKey, device ) { #>
					<div class="suki-dimensions-fieldset suki-flex-fieldset {{ data.hasResponsive ? 'suki-responsive-fieldset' : '' }} {{ 'desktop' == device ? 'active' : '' }} {{ 'preview-' + device }}" data-linked="false">
						<# _.each( [ 'top', 'right', 'bottom', 'left' ], function( prop, i ) {; #>
							<div>
								<div class="suki-dimension">
									<input
										class="suki-dimension-number"
										type="number"
										value="{{ data.settingsData[ settingKey ].explodedValue[ i ].number }}"
										min="{{ data.units[ data.settingsData[ settingKey ].explodedValue[ i ].unit ].min }}"
										max="{{ data.units[ data.settingsData[ settingKey ].explodedValue[ i ].unit ].max }}"
										step="{{ data.units[ data.settingsData[ settingKey ].explodedValue[ i ].unit ].step }}"
									>
									<select class="suki-dimension-unit">
										<# _.each( data.units, function( unitData, unit ) { #>
											<option
												value="{{ unit }}"
												{{ unit == data.settingsData[ settingKey ].explodedValue[ i ].unit ? 'selected' : '' }}
												data-min="{{ unitData.min }}"
												data-max="{{ unitData.max }}"
												data-step="{{ unitData.step }}"
											>{{{ unitData.label }}}</option>
										<# }); #>
									</select>
									<input type="hidden" class="suki-dimension-value" value="{{ data.settingsData[ settingKey ].explodedValue[ i ].raw }}">
								</div>
								<span class="suki-small-label">{{{ prop }}}</span>
							</div>
						<# }); #>

						<input type="hidden" class="suki-dimensions-value" value="{{ data.settingsData[ settingKey ].value }}" {{{ data.settingsData[ settingKey ].link }}}>
					</div>
				<# }); #>
			</div>
			<?php
		}
	}

	// Register control type.
	$wp_customize->register_control_type( 'Suki_Customize_Dimensions_Control' );
}
