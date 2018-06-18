<?php
/**
 * Customizer custom control: Shadow
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Suki_Customize_Control_Shadow' ) ) :
/**
 * Shadow control class
 */
class Suki_Customize_Control_Shadow extends WP_Customize_Control {
	/**
	 * @var string
	 */
	public $type = 'suki-shadow';

	/**
	 * @var array
	 */
	public $exclude = array();

	/**
	 * Setup parameters for content rendering by Underscore JS template.
	 */
	public function to_json() {
		parent::to_json();

		$this->json['name'] = $this->id;

		$value = $this->value();
		if ( empty( $value ) ) {
			$value = '    '; // 4 empty space for default value
		}

		$chunks = explode( ' ', $value );
		$this->json['value'] = array(
			'h_offset' => trim( $chunks[0], 'px' ),
			'v_offset' => trim( $chunks[1], 'px' ),
			'blur' => trim( $chunks[2], 'px' ),
			'spread' => trim( $chunks[3], 'px' ),
			'color' => $chunks[4],
		);
		$this->json['raw_value'] = $value;

		$this->json['exclude'] = $this->exclude;

		$this->json['__link'] = $this->get_link();
	}

	/**
	 * Render Underscore JS template for this control's content.
	 */
	protected function content_template() {
		$numbers = array(
			'h_offset' => esc_html__( 'H-Offset', 'suki' ),
			'v_offset' => esc_html__( 'V-Offset', 'suki' ),
			'blur'     => esc_html__( 'Blur', 'suki' ),
			'spread'   => esc_html__( 'Spread', 'suki' ),
		);

		?>
		<# if ( data.label ) { #>
			<span class="customize-control-title">{{{ data.label }}}</span>
		<# } #>
		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>
		<div class="customize-control-content">
			<div class="suki-row suki-shadow-row">
				<?php foreach ( $numbers as $prop => $label ) : ?>
					<# var isExcluded = -1 < data.exclude.indexOf( '<?php echo esc_attr( $prop ); ?>' ) ? 'style="display: none;"' : ''; #>
					<label class="suki-row-item suki-shadow-<?php echo esc_attr( $prop ); ?>" {{{ isExcluded }}}>
						<span class="suki-small-label"><?php echo esc_attr( $label ); ?></span>
						<input type="number" value="{{ '' !== isExcluded ? '' : data.value[ '<?php echo esc_attr( $prop ); ?>' ] }}" class="suki-shadow-input" step="1">
					</label>
				<?php endforeach; ?>
				<label class="suki-row-item" style="width: 30px; vertical-align: top;">
					<span class="suki-small-label"><?php esc_html_e( 'Color', 'suki' ); ?></span>
				</label>
			</div>
			<div class="suki-shadow-color">
				<input value="{{ data.value.color }}" type="text" maxlength="30" class="suki-shadow-input color-picker-hex" placeholder="<?php esc_attr_e( 'Hex / RGBA', 'suki' ); ?>" data-default-color="" data-alpha="true" data-custom-width="false">
			</div>

			<input type="hidden" {{{ data.__link }}} value="{{ data.raw_value }}" class="suki-shadow-value">
		</div>
		<?php
	}
}

// Register control type.
$wp_customize->register_control_type( 'Suki_Customize_Control_Shadow' );
endif;