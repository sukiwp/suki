<?php
/**
 * Customizer custom control: Sortable
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Suki_Customize_Control_Sortable' ) ) {
	/**
	 * Custom color control class
	 */
	class Suki_Customize_Control_Sortable extends WP_Customize_Control {
		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'suki-sortable';

		/**
		 * Setup parameters for content rendering by Underscore JS template.
		 */
		public function to_json() {
			parent::to_json();

			/**
			 * Add general variables.
			 */

			$this->json['name'] = $this->id;

			$this->json['value'] = is_array( $this->value() ) ? $this->value() : array();

			$this->json['choices'] = $this->choices;

			$this->json['link'] = $this->get_link();
		}

		/**
		 * Enqueue additional control's CSS or JS scripts.
		 */
		public function enqueue() {
			wp_enqueue_script( 'html5sortable' );
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
			<div class="customize-control-content suki-control-box">
				<ul class="suki-sortable" id="{{ data.name }}">
					<# _.each( data.value, function( item ) { #>
						<# if ( 0 > Object.keys( data.choices ).indexOf( item ) ) return; #>
						<li class="suki-sortable-item" data-value="{{ item }}">
							<input type="checkbox" value="{{{ item }}}" id="{{ data.name + '--' + item }}" checked>

							<div class="suki-sortable-item-label button">
								<label for="{{ data.name + '--' + item }}">
									<span class="dashicons dashicons-visibility"></span>
									<span class="dashicons dashicons-hidden"></span>
								</label>
								<span class="suki-sortable-item-name">{{ data.choices[ item ] }}</span>
								<span class="suki-sortable-item-handle dashicons dashicons-move"></span>
							</div>
						</li>
					<# } ); #>
					<# _.each( data.choices, function( label, item ) { #>
						<# if ( 0 <= data.value.indexOf( item ) ) return; #>
						<li class="suki-sortable-item" data-value="{{ item }}">
							<input type="checkbox" value="{{{ item }}}" id="{{ data.name + '--' + item }}">

							<div class="suki-sortable-item-label button">
								<label for="{{ data.name + '--' + item }}">
									<span class="dashicons dashicons-visibility"></span>
									<span class="dashicons dashicons-hidden"></span>
								</label>
								<span class="suki-sortable-item-name">{{ label }}</span>
								<span class="suki-sortable-item-handle dashicons dashicons-move"></span>
							</div>
						</li>
					<# } ); #>
				</ul>
			</div>
			<?php
		}
	}

	// Register control type.
	$wp_customize->register_control_type( 'Suki_Customize_Control_Sortable' );
}
