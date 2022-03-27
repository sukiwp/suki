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
	class Suki_Customize_Control_Shadow extends Suki_Customize_Control {
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
		 * Setup parameters for content rendering by Underscore JS template.
		 */
		public function to_json() {
			parent::to_json();

			$this->json['name'] = $this->id;

			$value = $this->value();
			if ( false === $value || '' === trim( $value ) ) {
				$value = '0 0 0 0 rgba(0,0,0,0)'; // default value.
			}

			$chunks = explode( ' ', $value );
			if ( ! isset( $chunks[5] ) ) {
				$chunks[5] = '';
			}

			$this->json['decomposedValue'] = array(
				'h_offset' => intval( $chunks[0] ),
				'v_offset' => intval( $chunks[1] ),
				'blur'     => intval( $chunks[2] ),
				'spread'   => intval( $chunks[3] ),
				'color'    => $chunks[4],
				'position' => $chunks[5],
			);

			$this->json['value'] = $value;

			$this->json['has_palette'] = $this->has_palette;

			$this->json['excludedProps'] = $this->exclude;

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
			$inputs = array(
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
					<# var inputs = <?php echo wp_json_encode( $inputs ); ?>; #>
					<# _.each( inputs, function( label, prop ) { #>
						<# var hideStyle = -1 < data.excludedProps.indexOf( prop ) ? 'style="display: none;"' : ''; #>
						<div class="suki-shadow-{{ prop }}" {{{ hideStyle }}}>
							<input type="number" value="{{ '' !== hideStyle ? '' : data.decomposedValue[ prop ] }}" step="1">
							<span class="suki-small-label">{{{ label }}}</span>
						</div>
					<# }); #>
				</div>

				<div class="suki-flex-fieldset">
					<# var hideStyle = -1 < data.excludedProps.indexOf( 'position' ) ? 'style="display: none;"' : ''; #>
					<div class="suki-shadow-position" {{{ hideStyle }}}>
						<select>
							<option value="" {{ value === data.decomposedValue.position ? 'selected' : '' }}><?php esc_html_e( 'Outer shadow', 'suki' ); ?></option>
							<option value="inset" {{ value === data.decomposedValue.position ? 'selected' : '' }}><?php esc_html_e( 'Inner shadow', 'suki' ); ?></option>
						</select>
					</div>

					<div class="suki-shadow-color">
						<input value="{{ data.decomposedValue.color }}" type="text" maxlength="30" class="color-picker" data-palette="{{ data.has_palette ? '<?php echo esc_attr( $palette ); ?>' : 'false' }}" placeholder="<?php esc_attr_e( 'Hex / RGBA', 'suki' ); ?>" data-default-color="rgba(0,0,0,0)" data-show-opacity="true">
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
