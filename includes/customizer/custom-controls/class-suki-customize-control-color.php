<?php
/**
 * Customizer custom control: Color
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Suki_Customize_Control_Color' ) ) {
	/**
	 * Custom color control class
	 */
	class Suki_Customize_Control_Color extends Suki_Customize_Control {
		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'suki-color';

		/**
		 * Use alpha.
		 *
		 * @var boolean
		 */
		public $alpha = true;

		/**
		 * Has palette.
		 *
		 * @var boolean
		 */
		public $has_palette = true;

		/**
		 * Setup parameters for content rendering by Underscore JS template.
		 */
		public function to_json() {
			parent::to_json();

			/**
			 * Add general variables.
			 */

			$this->json['name'] = $this->id;

			$this->json['default'] = $this->setting->default;

			$this->json['value'] = $this->value();

			$this->json['alpha'] = $this->alpha;

			$this->json['hasPalette'] = $this->has_palette;

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
			<div class="customize-control-content suki-colorpicker suki-colorpicker-{{ data.alpha ? 'with-alpha' : 'no-alpha' }}">
				<input value="{{ data.value }}" type="text" maxlength="30" class="color-picker" data-palette="{{ data.hasPalette ? '<?php echo esc_attr( $palette ); ?>' : 'false' }}" placeholder="<?php esc_attr_e( 'Hex / RGBA', 'suki' ); ?>" data-default-color="{{ data.default }}" data-show-opacity="{{ data.alpha }}" {{{ data.link }}}>
			</div>
			<?php
		}
	}

	// Register control type.
	$wp_customize->register_control_type( 'Suki_Customize_Control_Color' );
}
