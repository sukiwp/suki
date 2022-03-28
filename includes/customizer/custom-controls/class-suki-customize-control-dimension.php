<?php
/**
 * Customizer custom control: Dimension
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Suki_Customize_Control_Dimension' ) ) {
	/**
	 * Dimension control class
	 */
	class Suki_Customize_Control_Dimension extends WP_Customize_Control {
		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'suki-dimension';

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

			foreach ( $this->settings as $setting_key => $setting ) {
				$value = $this->value( $setting_key );
				if ( false === $value ) {
					$value = '';
				}

				// Convert raw value string into number and unit.
				$number = '' === $value ? '' : floatval( $value );
				$unit   = str_replace( $number, '', $value );
				if ( ! array_key_exists( $unit, $this->units ) ) {
					$units = array_keys( $this->units );
					$unit  = reset( $units );
				}

				// Add to settingsData array.
				$this->json['settingsData'][ $setting_key ] = array(
					'link'   => $this->get_link( $setting_key ),
					'value'  => $value,
					'number' => $number,
					'unit'   => $unit,
				);

				// Add to responsiveStructures array.
				$device = 'desktop';
				if ( false !== strpos( $setting->id, '__' ) ) {
					$chunks = explode( '__', $setting->id );
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
							<# _.each( data.responsiveStructures, function( setting_key, device ) { #>
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
				<# _.each( data.responsiveStructures, function( setting_key, device ) { #>
					<div class="suki-dimension {{ data.hasResponsive ? 'suki-responsive-fieldset' : '' }} {{ 'desktop' == device ? 'active' : '' }} {{ 'preview-' + device }}" data-settingkey="{{ setting_key }}">
						<input class="suki-dimension-number" type="number" value="{{ data.settingsData[ setting_key ].number }}" min="{{ data.units[ data.settingsData[ setting_key ].unit ].min }}" max="{{ data.units[ data.settingsData[ setting_key ].unit ].max }}" step="{{ data.units[ data.settingsData[ setting_key ].unit ].step }}">
						<select class="suki-dimension-unit">
							<# _.each( data.units, function( unit_data, unit ) { #>
								<option value="{{ unit }}" {{ unit == data.settingsData[ setting_key ].unit ? 'selected' : '' }} data-min="{{ unit_data.min }}" data-max="{{ unit_data.max }}" data-step="{{ unit_data.step }}">{{{ unit_data.label }}}</option>
							<# }); #>
						</select>
						<input type="hidden" class="suki-dimension-value" value="{{ data.settingsData[ setting_key ].value }}" {{{ data.settingsData[ setting_key ].link }}}>
					</div>
				<# }); #>
			</div>
			<?php
		}
	}

	// Register control type.
	$wp_customize->register_control_type( 'Suki_Customize_Control_Dimension' );
}
