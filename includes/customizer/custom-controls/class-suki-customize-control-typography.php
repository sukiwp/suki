<?php
/**
 * Customizer custom control: Typography
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Suki_Customize_Control_Typography' ) ) {
	/**
	 * Typography control class
	 */
	class Suki_Customize_Control_Typography extends Suki_Customize_Control {
		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'suki-typography';

		/**
		 * Control units.
		 *
		 * @var array
		 */
		public $units = array();

		/**
		 * Choices.
		 *
		 * @var array
		 */
		public $choices = array();

		/**
		 * Setup parameters for content rendering by Underscore JS template.
		 */
		public function to_json() {
			parent::to_json();

			/**
			 * Add general variables.
			 */

			$this->json['name'] = $this->id;

			/**
			 * Build settingsData and responsiveStructures.
			 */

			$this->json['settingsData'] = array();

			$this->json['responsiveStructures'] = array();

			foreach ( $this->settings as $setting_key => $setting ) {
				// Extract setting type.
				// Skip if no valid type found in the setting id.
				if ( ! preg_match( '/(font_family|font_weight|font_style|text_transform|font_size|line_height|letter_spacing)/', $setting->id, $matches ) ) {
					continue;
				}
				$type = $matches[1];

				// Get setting value.
				$value = $this->value( $setting_key );

				// Build settingsData array.
				$this->json['settingsData'][ $setting_key ] = array(
					'link'  => $this->get_link( $setting_key ),
					'value' => $value,
				);

				// Add number and unit to font_size, line_height, letter_spacing setting type.
				if ( in_array( $type, array( 'font_size', 'line_height', 'letter_spacing' ), true ) ) {
					$units = $this->get_units( $type );

					// Convert raw value string into number and unit.
					$number = '' === $value ? '' : floatval( $value );
					$unit   = str_replace( $number, '', $value );
					if ( ! array_key_exists( $unit, $units ) ) {
						$unit = key( $units );
					}

					$this->json['settingsData'][ $setting_key ]['number'] = $number;
					$this->json['settingsData'][ $setting_key ]['unit']   = $unit;
				}

				// Build responsiveStructures array.
				$device = 'desktop';
				if ( false !== strpos( $setting->id, '__' ) ) {
					$chunks = explode( '__', $setting->id );
					if ( in_array( $chunks[1], array( 'desktop', 'tablet', 'mobile' ), true ) ) {
						$device = $chunks[1];
					}
				}

				if ( in_array( $type, array( 'font_size', 'line_height', 'letter_spacing' ), true ) ) {
					$this->json['responsiveStructures'][ $device ][ $type ] = $setting_key;
				}
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
			<#
			var labels = {
					font_family: '<?php esc_html_e( 'Font', 'suki' ); ?>',
					font_weight: '<?php esc_html_e( 'Weight', 'suki' ); ?>',
					font_style: '<?php esc_html_e( 'Style', 'suki' ); ?>',
					text_transform: '<?php esc_html_e( 'Transform', 'suki' ); ?>',
					font_size: '<?php esc_html_e( 'Size', 'suki' ); ?>',
					line_height: '<?php esc_html_e( 'Line Height', 'suki' ); ?>',
					letter_spacing: '<?php esc_html_e( 'Spacing', 'suki' ); ?>',
				},
				choices = <?php echo wp_json_encode( $this->get_choices() ); ?>,
				units = <?php echo wp_json_encode( $this->get_units() ); ?>;
			#>
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{{ data.label }}}</span>
			<# } #>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
			<div class="customize-control-content suki-control-box">
				<# if ( data.settingsData.font_family ) { #>
					<div class="suki-flex-fieldset">
						<div>
							<label class="suki-small-label">{{ labels.font_family }}</label>
							<select {{{ data.settingsData.font_family.link }}}>
								<option value=""><?php esc_html_e( 'Default', 'suki' ); ?></option>
								<# _.each( choices.font_family, function( provider_data, provider ) { #>
									<# if ( 0 == provider_data.fonts.length ) return; #>
									<optgroup label="{{ provider_data.label }}">
										<# _.each( provider_data.fonts, function( label, value ) { #>
											<option value="{{ value }}">{{{ label }}}</option>
										<# }); #>
									</optgroup>
								<# }); #>
							</select>
						</div>
					</div>
				<# } #>

				<div class="suki-flex-fieldset">
					<# _.each( [ 'font_weight', 'font_style', 'text_transform' ], function( type ) { #>
						<# if ( data.settingsData[ type ] ) { #>
							<div>
								<label class="suki-small-label">{{ labels[ type ] }}</label>
								<select {{{ data.settingsData[ type ].link }}}>
									<option value=""><?php esc_html_e( 'Default', 'suki' ); ?></option>
									<# _.each( choices[ type ], function( label, value ) { #>
										<option value="{{ value }}">{{{ label }}}</option>
									<# }); #>
								</select>
							</div>
						<# } #>
					<# }); #>
				</div>

				<# if ( data.hasResponsive ) { #>
					<div class="suki-responsive-switcher">
						<# _.each( data.responsiveStructures, function( setting_key, device ) { #>
							<span class="suki-responsive-switcher-button preview-{{ device }}" data-device="{{ device }}"><span class="dashicons dashicons-{{ 'mobile' === device ? 'smartphone' : device }}"></span></span>
						<# }); #>
					</div>
				<# } #>

				<# _.each( data.responsiveStructures, function( setting_keys, device ) { #>
					<div class="suki-flex-fieldset {{ data.hasResponsive ? 'suki-responsive-fieldset' : '' }} {{ 'desktop' == device ? 'active' : '' }} {{ 'preview-' + device }}">
						<# _.each( setting_keys, function( setting_key, setting_type ) { #>
							<# if ( data.settingsData[ setting_key ] ) { #>
								<div>
									<label class="suki-small-label">{{ labels[ setting_type ] }}</label>
									<div class="suki-dimension">
										<input class="suki-dimension-number" type="number" value="{{ data.settingsData[ setting_key ].number }}" min="" max="" step="" placeholder="<?php esc_attr_e( 'Default', 'suki' ); ?>">
										<select class="suki-dimension-unit">
											<# _.each( units[ setting_type ], function( unit_data, unit ) { #>
												<option value="{{ unit }}" {{ unit == data.settingsData[ setting_key ].unit ? 'selected' : '' }} data-min="{{ unit_data.min }}" data-max="{{ unit_data.max }}" data-step="{{ unit_data.step }}">{{{ unit_data.label }}}</option>
											<# }); #>
										</select>
									</div>
									<input type="hidden" class="suki-dimension-value" value="{{ data.settingsData[ setting_key ].value }}" {{{ data.settingsData[ setting_key ].link }}}>
								</div>
							<# } #>
						<# }); #>
					</div>
				<# }) #>
			</div>
			<?php
		}

		/**
		 * Return available choices for this control.
		 *
		 * @param string $key Key of request choice.
		 * @return array
		 */
		public function get_choices( $key = null ) {
			$font_families = array();

			foreach ( suki_get_all_fonts() as $provider => $fonts ) {
				$font_families[ $provider ]['label'] = ucwords( str_replace( '_', ' ', $provider ) );
				$font_families[ $provider ]['fonts'] = array();

				foreach ( $fonts as $name => $stack ) {
					$font_families[ $provider ]['fonts'][ esc_attr( $provider . '|' . $name ) ] = esc_attr( $name );
				}
			}

			$choices = array(
				'font_family'    => $font_families,
				'font_weight'    => array(
					'100' => esc_html__( 'Thin', 'suki' ),
					'200' => esc_html__( 'Extra Light', 'suki' ),
					'300' => esc_html__( 'Light', 'suki' ),
					'400' => esc_html__( 'Regular', 'suki' ),
					'500' => esc_html__( 'Medium', 'suki' ),
					'600' => esc_html__( 'Semi Bold', 'suki' ),
					'700' => esc_html__( 'Bold', 'suki' ),
					'800' => esc_html__( 'Extra Bold', 'suki' ),
					'900' => esc_html__( 'Black', 'suki' ),
				),
				'font_style'     => array(
					'normal' => esc_html__( 'Normal', 'suki' ),
					'italic' => esc_html__( 'Italic', 'suki' ),
				),
				'text_transform' => array(
					'none'       => esc_html__( 'None', 'suki' ),
					'uppercase'  => esc_html__( 'Uppercase', 'suki' ),
					'lowercase'  => esc_html__( 'Lowercase', 'suki' ),
					'capitalize' => esc_html__( 'Capitalize', 'suki' ),
				),
			);

			if ( ! empty( $key ) ) {
				return suki_array_value( $choices, $key, array() );
			} else {
				return $choices;
			}
		}

		/**
		 * Return available units for this control.
		 *
		 * @param string $key Key of requested unit.
		 * @return array
		 */
		public function get_units( $key = null ) {
			$units = array(
				'font_size'      => array(
					'px'  => array(
						'min'   => 0,
						'max'   => 100,
						'step'  => 1,
						'label' => 'px',
					),
					'em'  => array(
						'min'   => 0,
						'max'   => 10,
						'step'  => 0.01,
						'label' => 'em',
					),
					'rem' => array(
						'min'   => 0,
						'max'   => 10,
						'step'  => 0.01,
						'label' => 'rem',
					),
				),
				'line_height'    => array(
					'' => array(
						'min'   => 0,
						'max'   => 10,
						'step'  => 0.01,
						'label' => 'em',
					),
				),
				'letter_spacing' => array(
					'px' => array(
						'min'   => -20,
						'max'   => 20,
						'step'  => 0.1,
						'label' => 'px',
					),
					'em' => array(
						'min'   => -2,
						'max'   => 2,
						'step'  => 0.01,
						'label' => 'em',
					),
				),
			);

			if ( ! empty( $key ) ) {
				return suki_array_value( $units, $key, array() );
			} else {
				return $units;
			}
		}
	}

	// Register control type.
	$wp_customize->register_control_type( 'Suki_Customize_Control_Typography' );
}
