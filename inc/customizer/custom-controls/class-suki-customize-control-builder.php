<?php
/**
 * Customizer custom control: Builder
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Suki_Customize_Control_Builder' ) ) :
/**
 * Builder control class
 */
class Suki_Customize_Control_Builder extends Suki_Customize_Control {
	/**
	 * @var string
	 */
	public $type = 'suki-builder';

	/**
	 * Available choices: inline, block
	 *
	 * @var string
	 */
	public $layout = 'inline';

	/**
	 * @var array
	 */
	public $locations = array();

	/**
	 * @var array
	 */
	public $limitations = array();

	/**
	 * @var array
	 */
	public $labels = array();

	/**
	 * Constructor
	 */
	public function __construct( $manager, $id, $args = array() ) {
		parent::__construct( $manager, $id, $args );

		$this->locations = isset( $args['settings'] ) ? $args['settings'] : array( 'default' );
	}

	/**
	 * Setup parameters for content rendering by Underscore JS template.
	 */
	public function to_json() {
		parent::to_json();

		$this->json['name'] = $this->id;
		$this->json['layout'] = $this->layout;
		$this->json['choices'] = $this->choices;

		$this->json['inputs'] = array();
		$this->json['structures'] = array();
		$this->json['actives'] = array();

		$this->json['limitations'] = $this->limitations;

		if ( 0 < count( $this->settings ) ) {
			// Multiple settings
			foreach ( $this->settings as $setting_key => $setting_id ) {
				$value = $this->value( $setting_key );

				if ( empty( $value ) ) $value = array();

				// Add to inputs array
				$this->json['inputs'][ $setting_key ] = array(
					'__link' => $this->get_link( $setting_key ),
					'value'  => $value,
				);

				// Pool active elements into array
				foreach ( $value as $item ) {
					$this->json['actives'][] = $item;
				}
			}
		} else {
			// Single setting
			$this->json['inputs']['default'] = array(
				'__link' => $this->get_link(),
				'value'  => (array) $this->value(),
			);
		}

		$this->json['labels'] = $this->labels;
	}

	/**
	 * Enqueue additional control's CSS or JS scripts.
	 */
	public function enqueue() {
		wp_enqueue_style( 'jquery-ui-sortable' );
	}
	
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
		<div class="customize-control-content suki-builder suki-builder-layout-{{ data.layout }}" data-name="{{ data.name }}">
			<div class="suki-builder-locations">
				<# _.each( data.settings, function( setting_id, setting_key ) { #>
					<div class="suki-builder-location suki-builder-location-{{ setting_key }}" data-location="{{ setting_key }}">
						<# if ( 'default' !== setting_key ) { #>
							<p class="suki-small-label">{{{ data.labels[ setting_key ] }}}</p>
						<# } #>
						<ul class="suki-builder-sortable-panel" data-connect="{{ data.name }}">
							<# _.each( data.inputs[ setting_key ].value, function( item ) {
								if ( undefined === data.choices[ item ] ) return;

								var limitations = undefined !== data.limitations[ item ] ? data.limitations[ item ].join( ',' ) : '';

								#><li class="suki-builder-element button button-secondary" data-value="{{ item }}" tabindex="0" data-limitations="{{ limitations }}">
									<span>{{{ data.choices[ item ] }}}</span><a href="#" class="suki-builder-element-delete"><span class="dashicons dashicons-no-alt"></span></a>
								</li><#
							}) #>
						</ul>
						<span class="suki-builder-element-add" tabindex="0">
							<span class="dashicons dashicons-plus-alt"></span>
							<span class="screen-reader-text"><?php esc_html_e( 'Add element', 'suki' ); ?></span>
						</span>
					</div>
				<# }); #>
			</div>
			<div class="suki-builder-inactive" data-location="__inactive">
				<ul class="suki-builder-sortable-panel" data-connect="{{ data.name }}">
					<# _.each( data.choices, function( label, item ) {
						if ( 0 > data.actives.indexOf( item ) ) {
							var limitations = undefined !== data.limitations[ item ] ? data.limitations[ item ].join( ',' ) : '';

							#><li class="suki-builder-element button button-secondary" data-value="{{ item }}" tabindex="0" data-limitations="{{ limitations }}">
								<span>{{{ label }}}</span><a href="#" class="suki-builder-element-delete"><span class="dashicons dashicons-no-alt"></span></a>
							</li><#
						}
					}); #>
					<li class="suki-builder-no-more-items"><?php esc_html_e( 'No more items to add', 'suki' ); ?></li>
				</ul>
			</div>
		</div>
		<?php
	}
}

// Register control type.
$wp_customize->register_control_type( 'Suki_Customize_Control_Builder' );
endif;