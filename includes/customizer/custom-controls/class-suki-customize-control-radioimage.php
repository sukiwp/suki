<?php
/**
 * Customizer custom control: Radio Image
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Suki_Customize_Control_RadioImage' ) ) {
	/**
	 * Multiple checkboxes control class
	 */
	class Suki_Customize_Control_RadioImage extends WP_Customize_Control {
		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'suki-radioimage';

		/**
		 * Columns.
		 *
		 * @var columns
		 */
		public $columns = 0;

		/**
		 * Constructor.
		 *
		 * @param WP_Customize_Manager $manager Customizer Manager object.
		 * @param integer              $id      Control ID.
		 * @param array                $args    Arguments array.
		 */
		public function __construct( $manager, $id, $args = array() ) {
			parent::__construct( $manager, $id, $args );

			// Sanitize unit attributes.
			foreach ( $this->choices as $choice_value => $choice_data ) {
				$this->choices[ $choice_value ] = wp_parse_args(
					$choice_data,
					array(
						'label' => '',
						'image' => '',
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

			$this->json['choices'] = $this->choices;

			$this->json['value'] = $this->value();

			$this->json['columns'] = empty( $this->columns ) ? min( count( $this->choices ), 4 ) : $this->columns;

			$this->json['link'] = $this->get_link();
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
				<span class="customize-control-title">{{{ data.label }}}</span>
			<# } #>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
			<div class="customize-control-content">
				<ul class="suki-radioimage-list suki-radioimage-columns-{{ data.columns }}">
					<# _.each( data.choices, function( choice, value ) { #>
						<li>
							<input type="radio" id="{{ data.name + '--' + value }}" name="{{ data.name }}" value="{{ value }}" class="suki-radioimage-input" {{ value === data.value ? 'checked' : '' }} {{{ data.link }}}>
							<label for="{{ data.name + '--' + value }}" tabindex="0">
								<# if ( choice.image ) { #>
									<img src="{{ choice.image }}">
								<# } #>
								<# if ( choice.label ) { #>
									<span>{{{ choice.label }}}</span>
								<# } #>
							</label>
						</li>
					<# }); #>
				</ul>
			</div>
			<?php
		}
	}

	// Register control type.
	$wp_customize->register_control_type( 'Suki_Customize_Control_RadioImage' );
}
