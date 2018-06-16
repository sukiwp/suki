<?php
/**
 * Customizer custom control: Typography
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Suki_Customize_Control_Typography' ) ) :
/**
 * Typography control class
 */
class Suki_Customize_Control_Typography extends WP_Customize_Control {
	/**
	 * @var string
	 */
	public $type = 'suki-typography';

	/**
	 * @var array
	 */
	public $units = array();

	/**
	 * @var array
	 */
	public $choices = array();

	/**
	 * Constructor
	 */
	public function __construct( $manager, $id, $args = array() ) {
		parent::__construct( $manager, $id, $args );

		$font_families = array();
		foreach( suki_get_all_fonts() as $provider => $fonts ) {
			$font_families[ $provider ] = array();

			foreach ( $fonts as $name => $stack ) {
				$font_families[ $provider ][ esc_attr( $provider . '|' . $name ) ] = esc_attr( $name );
			}
		}

		$this->choices = array(
			'font_family' => $font_families,
			'font_weight' => array(
				'100'     => esc_html__( 'Thin', 'suki' ),
				'200'     => esc_html__( 'Extra Light', 'suki' ),
				'300'     => esc_html__( 'Light', 'suki' ),
				'400'     => esc_html__( 'Regular', 'suki' ),
				'500'     => esc_html__( 'Medium', 'suki' ),
				'600'     => esc_html__( 'Semi Bold', 'suki' ),
				'700'     => esc_html__( 'Bold', 'suki' ),
				'800'     => esc_html__( 'Extra Bold', 'suki' ),
				'900'     => esc_html__( 'Black', 'suki' ),
			),
			'font_style'  => array(
				'normal'  => esc_html__( 'Normal', 'suki' ),
				'italic'  => esc_html__( 'Italic', 'suki' ),
			),
			'text_transform' => array(
				'none'       => esc_html__( 'None', 'suki' ),
				'uppercase'  => esc_html__( 'Uppercase', 'suki' ),
				'lowercase'  => esc_html__( 'Lowercase', 'suki' ),
				'capitalize' => esc_html__( 'Capitalize', 'suki' ),
			),
		);

		$this->units = array(
			'font_size' => array(
				'px' => array(
					'min' => 0,
					'max' => 100,
					'step' => 1,
					'label' => 'px',
				),
				'em' => array(
					'min' => 0,
					'max' => 10,
					'step' => 0.01,
					'label' => 'em',
				),
			),
			'line_height' => array(
				'' => array(
					'min' => 0,
					'max' => 10,
					'step' => 0.01,
					'label' => 'em',
				),
			),
			'letter_spacing' => array(
				'px' => array(
					'min' => -20,
					'max' => 20,
					'step' => 0.5,
					'label' => 'px',
				),
				'em' => array(
					'min' => -2,
					'max' => 2,
					'step' => 0.01,
					'label' => 'em',
				),
			),
		);
	}

	/**
	 * Setup parameters for content rendering by Underscore JS template.
	 */
	public function to_json() {
		parent::to_json();

		$this->json['name'] = $this->id;

		$this->json['inputs'] = array();
		$this->json['structures'] = array();

		foreach ( $this->settings as $setting_key => $setting ) {
			// Extract setting type.
			// Skip if no valid type found in the setting id.
			if ( ! preg_match( '/(font_family|font_weight|font_style|text_transform|font_size|line_height|letter_spacing)/', $setting->id, $matches ) ) {
				continue;
			}
			$type = $matches[1];

			$value = $this->value( $setting_key );

			// Add to inputs array.
			$this->json['inputs'][ $setting_key ] = array(
				'__link' => $this->get_link( $setting_key ),
				'value'  => $value,
			);

			// Add number and unit to font_size, line_height, letter_spacing setting type.
			if ( in_array( $type, array( 'font_size', 'line_height', 'letter_spacing' ) ) ) {
				// Convert raw value string into number and unit.
				$number = '' === $value ? '' : floatval( $value );
				$unit = str_replace( $number, '', $value );
				if ( '' === $unit ) {
					$unit = key( $this->units[ $type ] );
				}

				$this->json['inputs'][ $setting_key ]['number'] = $number;
				$this->json['inputs'][ $setting_key ]['unit'] = $unit;
			}

			// Add to structures array.
			$device = 'desktop';
			if ( false !== strpos( $setting->id, '__' ) ) {
				$chunks = explode( '__', $setting->id );
				if ( in_array( $chunks[1], array( 'desktop', 'tablet', 'mobile' ) ) ) $device = $chunks[1];
			}

			if ( in_array( $type, array( 'font_size', 'line_height', 'letter_spacing' ) ) ) {
				$this->json['structures'][ $device ][ $type ] = $setting_key;
			}
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
						<span class="suki-responsive-switcher-button preview-desktop active" data-device="tablet"><span class="dashicons dashicons-desktop"></span></span>
						<span class="suki-responsive-switcher-button preview-tablet" data-device="mobile"><span class="dashicons dashicons-tablet"></span></span>
						<span class="suki-responsive-switcher-button preview-mobile" data-device="desktop"><span class="dashicons dashicons-smartphone"></span></span>
					</span>
				<# } #>
			</span>
		<# } #>
		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>
		<div class="customize-control-content {{ data.responsive ? 'suki-responsive' : '' }}">
			<# if ( data.inputs.font_family ) { #>
				<p class="suki-typography-fieldset suki-row">
					<label class="suki-row-item">
						<span class="suki-small-label"><?php esc_html_e( 'Font', 'suki' ); ?></span>
						<select class="suki-typography-input" {{{ data.inputs.font_family.__link }}}>
							<option value=""></option>
							<option value="inherit"><?php esc_html_e( 'Inherit', 'suki' ); ?></option>
							<?php foreach ( suki_array_value( $this->choices, 'font_family', array() ) as $provider => $fonts ) : ?>
								<optgroup label="<?php echo esc_attr( ucwords( str_replace( '_', ' ', $provider ) ) ); ?>">
									<?php foreach ( $fonts as $value => $label ) : ?>
										<option value="<?php echo esc_attr( $value ); ?>"><?php echo esc_html( $label ); ?></option>
									<?php endforeach; ?>
								</optgroup>
							<?php endforeach; ?>
						</select>
					</label>
				</p>
			<# } #>
			<# if ( data.inputs.font_weight || data.inputs.font_style || data.inputs.text_transform ) { #>
				<p class="suki-typography-fieldset suki-row">
					<# if ( data.inputs.font_weight ) { #>
						<label class="suki-row-item">
							<span class="suki-small-label"><?php esc_html_e( 'Weight', 'suki' ); ?></span>
							<select class="suki-typography-input" {{{ data.inputs.font_weight.__link }}}>
								<option value=""></option>
								<option value="inherit"><?php esc_html_e( 'Inherit', 'suki' ); ?></option>
								<?php foreach ( suki_array_value( $this->choices, 'font_weight', array() ) as $value => $label ) : ?>
									<option value="<?php echo esc_attr( $value ); ?>"><?php echo esc_html( $label ); ?></option>
								<?php endforeach; ?>
							</select>
						</label>
					<# } #>
					<# if ( data.inputs.font_style ) { #>
						<label class="suki-row-item">
							<span class="suki-small-label"><?php esc_html_e( 'Style', 'suki' ); ?></span>
							<select class="suki-typography-input" {{{ data.inputs.font_style.__link }}}>
								<option value=""></option>
								<option value="inherit"><?php esc_html_e( 'Inherit', 'suki' ); ?></option>
								<?php foreach ( suki_array_value( $this->choices, 'font_style', array() ) as $value => $label ) : ?>
									<option value="<?php echo esc_attr( $value ); ?>"><?php echo esc_html( $label ); ?></option>
								<?php endforeach; ?>
							</select>
						</label>
					<# } #>
					<# if ( data.inputs.text_transform ) { #>
						<label class="suki-row-item">
							<span class="suki-small-label"><?php esc_html_e( 'Transform', 'suki' ); ?></span>
							<select class="suki-typography-input" {{{ data.inputs.text_transform.__link }}}>
								<option value=""></option>
								<option value="inherit"><?php esc_html_e( 'Inherit', 'suki' ); ?></option>
								<?php foreach ( suki_array_value( $this->choices, 'text_transform', array() ) as $value => $label ) : ?>
									<option value="<?php echo esc_attr( $value ); ?>"><?php echo esc_html( $label ); ?></option>
								<?php endforeach; ?>
							</select>
						</label>
					<# } #>
				</p>
			<# } #>
			<# _.each( data.structures, function( setting_keys, device ) { #>
				<# if ( setting_keys['font_size'] || setting_keys['line_height'] || setting_keys['letter_spacing'] ) { #>
				<div class="suki-typography-fieldset suki-row {{ data.responsive ? 'suki-responsive-fieldset' : '' }} {{ 'desktop' == device ? 'active' : '' }} {{ 'preview-' + device }}">
					<# if ( data.inputs[ setting_keys['font_size'] ] ) { #>
						<# setting_key = setting_keys['font_size']; #>
						<label class="suki-row-item">
							<span class="suki-small-label"><?php esc_html_e( 'Size', 'suki' ); ?></span>
							<span class="suki-typography-size suki-row">
								<span class="suki-row-item">
									<input class="suki-typography-size-input" type="number" value="{{ data.inputs[ setting_key ].number }}" min="" max="" step="">
								</span>
								<span class="suki-row-item" style="width: 30px;">
									<select class="suki-typography-size-unit suki-unit">
										<?php foreach ( suki_array_value( $this->units, 'font_size', array() ) as $unit => $data ) : ?>
											<option value="<?php echo esc_attr( $unit ); ?>" data-min="<?php echo esc_attr( suki_array_value( $data, 'min' ) ); ?>" data-max="<?php echo esc_attr( suki_array_value( $data, 'max' ) ); ?>" data-step="<?php echo esc_attr( suki_array_value( $data, 'step' ) ); ?>"><?php echo esc_attr( suki_array_value( $data, 'label', $unit ) ); ?></option>
										<?php endforeach; ?>
									</select>
								</span>
								<input type="hidden" class="suki-typography-size-value" value="{{data.inputs[ setting_key ].value }}" {{{ data.inputs[ setting_key ].__link }}}>
							</span>
						</label>
					<# } #>
					<# if ( data.inputs[ setting_keys['line_height'] ] ) { #>
						<# setting_key = setting_keys['line_height']; #>
						<label class="suki-row-item">
							<span class="suki-small-label"><?php esc_html_e( 'Line', 'suki' ); ?></span>
							<span class="suki-typography-size suki-row">
								<span class="suki-row-item">
									<input class="suki-typography-size-input" type="number" value="{{ data.inputs[ setting_key ].number }}" min="" max="" step="">
								</span>
								<span class="suki-row-item" style="width: 30px;">
									<select class="suki-typography-size-unit suki-unit">
										<?php foreach ( suki_array_value( $this->units, 'line_height', array() ) as $unit => $data ) : ?>
											<option value="<?php echo esc_attr( $unit ); ?>" data-min="<?php echo esc_attr( suki_array_value( $data, 'min' ) ); ?>" data-max="<?php echo esc_attr( suki_array_value( $data, 'max' ) ); ?>" data-step="<?php echo esc_attr( suki_array_value( $data, 'step' ) ); ?>"><?php echo esc_attr( suki_array_value( $data, 'label', $unit ) ); ?></option>
										<?php endforeach; ?>
									</select>
								</span>
								<input type="hidden" class="suki-typography-size-value" value="{{data.inputs[ setting_key ].value }}" {{{ data.inputs[ setting_key ].__link }}}>
							</span>
						</label>
					<# } #>
					<# if ( data.inputs[ setting_keys['letter_spacing'] ] ) { #>
						<# setting_key = setting_keys['letter_spacing']; #>
						<label class="suki-row-item">
							<span class="suki-small-label"><?php esc_html_e( 'Spacing', 'suki' ); ?></span>
							<span class="suki-typography-size suki-row">
								<span class="suki-row-item">
									<input class="suki-typography-size-input" type="number" value="{{ data.inputs[ setting_key ].number }}" min="" max="" step="">
								</span>
								<span class="suki-row-item" style="width: 30px;">
									<select class="suki-typography-size-unit suki-unit">
										<?php foreach ( suki_array_value( $this->units, 'letter_spacing', array() ) as $unit => $data ) : ?>
											<option value="<?php echo esc_attr( $unit ); ?>" data-min="<?php echo esc_attr( suki_array_value( $data, 'min' ) ); ?>" data-max="<?php echo esc_attr( suki_array_value( $data, 'max' ) ); ?>" data-step="<?php echo esc_attr( suki_array_value( $data, 'step' ) ); ?>"><?php echo esc_attr( suki_array_value( $data, 'label', $unit ) ); ?></option>
										<?php endforeach; ?>
									</select>
								</span>
								<input type="hidden" class="suki-typography-size-value" value="{{data.inputs[ setting_key ].value }}" {{{ data.inputs[ setting_key ].__link }}}>
							</span>
						</label>
					<# } #>
				</div>
				<# } #>
			<# }) #>
		</div>
		<?php
	}
}

// Register control type.
$wp_customize->register_control_type( 'Suki_Customize_Control_Typography' );
endif;