<?php
/**
 * Customizer custom control: Shadow
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Suki_Customize_Control_Shadow' ) ) {
	/**
	 * Shadow control class
	 */
	class Suki_Customize_Control_Shadow extends WP_Customize_Control {
		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'suki-shadow';

		/**
		 * Has palette.
		 *
		 * @var boolean
		 */
		public $has_palette = true;

		/**
		 * Excluded fields.
		 *
		 * @var array
		 */
		public $exclude = array();

		/**
		 * Control units.
		 *
		 * @var array
		 */
		public $units = array(
			'px'  => array(
				'step' => 1,
			),
			'em'  => array(
				'step' => 0.01,
			),
			'rem' => array(
				'step' => 0.01,
			),
		);

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

			// Explode full value into parts array.
			$value_array = explode( ' ', $this->value() );

			// Sanitize value_array array.
			$value_array = array(
				'h_offset' => suki_array_value( $value_array, 0, 0 ),
				'v_offset' => suki_array_value( $value_array, 1, 0 ),
				'blur'     => suki_array_value( $value_array, 2, 0 ),
				'spread'   => suki_array_value( $value_array, 3, 0 ),
				'color'    => suki_array_value( $value_array, 4, 'rgba(0,0,0,0)' ),
				'position' => suki_array_value( $value_array, 5, '' ),
			);

			// Parse all dimension values into more detailed array.
			foreach ( array( 'h_offset', 'v_offset', 'blur', 'spread' ) as $prop ) {
				$raw = $value_array[ $prop ];

				// Split each dimension value into number and unit.
				$_number = '' === $raw ? '' : floatval( $raw );
				$_unit   = preg_replace( '/[0-9]+/', '', $raw );

				// When no unit found in the value, use the first choice as the selected unit (unit should not be empty).
				if ( empty( $_unit ) ) {
					$_unit = array_keys( $this->units )[0];
				}

				$value_array[ $prop ] = array(
					'raw'    => $raw,
					'number' => $_number,
					'unit'   => $_unit,
				);
			}

			/**
			 * Add variables.
			 */

			$this->json['name'] = $this->id;

			$this->json['value'] = $this->value();

			$this->json['explodedValue'] = $value_array;

			$this->json['hasPalette'] = $this->has_palette;

			$this->json['excludedProps'] = $this->exclude;

			$this->json['units'] = $this->units;

			$this->json['link'] = $this->get_link();
		}

		/**
		 * Enqueue additional control's CSS or JS scripts.
		 */
		public function enqueue() {
			wp_enqueue_script( 'alpha-color-picker' );
			wp_enqueue_style( 'alpha-color-picker' );
		}

		/**
		 * Don't render the control content from PHP, as it's rendered via JS on load.
		 */
		public function render_content() {}

		/**
		 * Render Underscore JS template for this control's content.
		 */
		protected function content_template() {
			$number_fields = array(
				'h_offset' => esc_html__( 'X', 'suki' ),
				'v_offset' => esc_html__( 'Y', 'suki' ),
				'blur'     => esc_html__( 'Blur', 'suki' ),
				'spread'   => esc_html__( 'Spread', 'suki' ),
			);

			/**
			 * Get color palette/
			 */

			$palette = array();

			for ( $i = 1; $i <= 8; $i++ ) {
				$palette[] = suki_get_theme_mod( 'color_palette_' . $i, '' );
			}

			$palette = implode( '|', $palette );
			?>
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{{ data.label }}}</span>
			<# } #>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
			<div class="customize-control-content suki-control-box">
				<div class="suki-flex-fieldset">
					<# var number_fields = <?php echo wp_json_encode( $number_fields ); ?>; #>
					<# _.each( number_fields, function( label, prop ) { #>
						<# var hideStyle = -1 < data.excludedProps.indexOf( prop ) ? 'style="display: none;"' : ''; #>
						<div class="suki-shadow-{{ prop }}" {{{ hideStyle }}}>
							<div class="suki-dimension">
								<input
									class="suki-dimension-number"
									type="number"
									value="{{ data.explodedValue[ prop ].number }}"
									min="{{ data.units[ data.explodedValue[ prop ].unit ].min }}"
									max="{{ data.units[ data.explodedValue[ prop ].unit ].max }}"
									step="{{ data.units[ data.explodedValue[ prop ].unit ].step }}"
								>
								<select class="suki-dimension-unit">
									<# _.each( data.units, function( unitData, unit ) { #>
										<option
											value="{{ unit }}"
											{{ unit == data.explodedValue[ prop ].unit ? 'selected' : '' }}
											data-min="{{ unitData.min }}"
											data-max="{{ unitData.max }}"
											data-step="{{ unitData.step }}"
										>{{{ unitData.label }}}</option>
									<# }); #>
								</select>
								<input type="hidden" class="suki-dimension-value" value="{{ '' !== hideStyle ? '' : data.explodedValue[ prop ].raw }}">
							</div>
							<span class="suki-small-label">{{{ label }}}</span>
						</div>
					<# }); #>
				</div>

				<div style="position: relative; padding-right: 35px;">
					<# var hideStyle = -1 < data.excludedProps.indexOf( 'position' ) ? 'style="display: none;"' : ''; #>
					<div class="suki-shadow-position" {{{ hideStyle }}}>
						<select>
							<option value="" {{{ '' === data.explodedValue.position ? 'selected' : '' }}}><?php esc_html_e( 'Outer shadow', 'suki' ); ?></option>
							<option value="inset" {{{ 'inset' === data.explodedValue.position ? 'selected' : '' }}}><?php esc_html_e( 'Inner shadow', 'suki' ); ?></option>
						</select>
					</div>

					<div class="suki-shadow-color">
						<input value="{{ data.explodedValue.color }}" type="text" maxlength="30" class="color-picker" data-palette="{{ data.hasPalette ? '<?php echo esc_attr( $palette ); ?>' : 'false' }}" placeholder="<?php esc_attr_e( 'Hex / RGBA', 'suki' ); ?>" data-default-color="rgba(0,0,0,0)" data-show-opacity="true">
					</div>
				</div>

				<input type="hidden" {{{ data.link }}} value="{{ data.value }}" class="suki-shadow-value">
			</div>
			<?php
		}
	}

	// Register control type.
	$wp_customize->register_control_type( 'Suki_Customize_Control_Shadow' );
}
