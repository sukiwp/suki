<?php
/**
 * Customizer custom control: Background
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Suki_Customize_Control_Background' ) ) :
/**
 * Background control class
 */
class Suki_Customize_Control_Background extends Suki_Customize_Control {
	/**
	 * @var string
	 */
	public $type = 'suki-background';

	/**
	 * Constructor
	 */
	public function __construct( $manager, $id, $args = array() ) {
		parent::__construct( $manager, $id, $args );

	}

	/**
	 * Setup parameters for content rendering by Underscore JS template.
	 */
	public function to_json() {
		parent::to_json();

		$this->json['name'] = $this->id;
		$this->json['can_upload'] = current_user_can( 'upload_files' );

		$this->json['inputs'] = array();
		$this->json['structures'] = array();

		foreach ( $this->settings as $setting_key => $setting ) {
			// Extract setting type.
			// Skip if no valid type found in the setting id.
			if ( ! preg_match( '/(image|attachment|repeat|size|position)/', $setting->id, $matches ) ) {
				continue;
			}
			$type = $matches[1];

			$value = $this->value( $setting_key );

			// Add to inputs array.
			$this->json['inputs'][ $setting_key ] = array(
				'__link' => $this->get_link( $setting_key ),
				'value'  => $value,
			);

			// Prepare attachment info fo "image" field.
			if ( 'image' === $type ) {
				$attachment_id = attachment_url_to_postid( $value );

				if ( $attachment_id ) {
					$this->json['attachment'] = wp_prepare_attachment_for_js( $attachment_id );
				}
			}
		}
	}

	/**
	 * Render Underscore JS template for this control's content.
	 */
	protected function content_template() {
		?>
		<#
		var labels = {
				image: '<?php esc_html_e( 'Image', 'suki' ); ?>',
				attachment: '<?php esc_html_e( 'Attachment', 'suki' ); ?>',
				repeat: '<?php esc_html_e( 'Repeat', 'suki' ); ?>',
				size: '<?php esc_html_e( 'Size', 'suki' ); ?>',
				position: '<?php esc_html_e( 'Position', 'suki' ); ?>',

				button_select: '<?php esc_html_e( 'Select image', 'suki' ); ?>',
				button_remove: '<?php esc_html_e( 'Remove image', 'suki' ); ?>',
				button_change: '<?php esc_html_e( 'Change image', 'suki' ); ?>',
			},
		    choices = <?php echo json_encode( $this->get_choices() ); ?>;
		#>
		<# if ( data.label ) { #>
			<span class="customize-control-title">{{{ data.label }}}</span>
		<# } #>
		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>
		<div class="customize-control-content">
			<div class="suki-background-fieldset suki-row">
				<div class="suki-row-item">
					<# if ( data.attachment && data.attachment.id ) { #>
						<div class="attachment-media-view attachment-media-view-{{ data.attachment.type }} {{ data.attachment.orientation }}">
							<div class="thumbnail thumbnail-{{ data.attachment.type }}">
								<# if ( 'image' === data.attachment.type && data.attachment.sizes && data.attachment.sizes.full ) { #>
									<img class="attachment-thumb" src="{{ data.attachment.sizes.full.url }}" draggable="false" alt="" />
								<# } else { #>
									<img class="attachment-thumb type-icon icon" src="{{ data.attachment.icon }}" draggable="false" alt="" />
									<p class="attachment-title">{{ data.attachment.title }}</p>
								<# } #>
							</div>
							<div class="actions">
								<# if ( data.can_upload ) { #>
									<button type="button" class="button remove-button">{{ labels.button_remove }}</button>
									<button type="button" class="button upload-button control-focus">{{ labels.button_change }}</button>
								<# } #>
							</div>
						</div>
					<# } else { #>
						<div class="attachment-media-view">
							<# if ( data.can_upload ) { #>
								<button type="button" class="upload-button button-add-media">{{ labels.button_select }}</button>
							<# } #>
						</div>
					<# } #>
					<input type="hidden" value="{{ data.inputs.image.value }}" {{{ data.inputs.image.__link }}}>
				</div>
			</div>

			<div class="suki-background-fieldset suki-row">
				<# _.each( [ 'attachment', 'repeat' ], function( type ) { #>
					<# if ( data.inputs[ type ] ) { #>
						<label class="suki-row-item">
							<span class="suki-small-label">{{ labels[ type ] }}</span>
							<select class="suki-background-input" {{{ data.inputs[ type ].__link }}}>
								<# _.each( choices[ type ], function( label, value ) { #>
									<option value="{{ value }}" {{{ value === data.inputs[ type ].value ? 'selected' : '' }}}>{{{ label }}}</option>
								<# }); #>
							</select>
						</label>
					<# } #>
				<# }); #>
			</div>

			<div class="suki-background-fieldset suki-row">
				<# _.each( [ 'size', 'position' ], function( type ) { #>
					<# if ( data.inputs[ type ] ) { #>
						<label class="suki-row-item">
							<span class="suki-small-label">{{ labels[ type ] }}</span>
							<select class="suki-background-input" {{{ data.inputs[ type ].__link }}}>
								<# _.each( choices[ type ], function( label, value ) { #>
									<option value="{{ value }}" {{{ value === data.inputs[ type ].value ? 'selected' : '' }}}>{{{ label }}}</option>
								<# }); #>
							</select>
						</label>
					<# } #>
				<# }); #>
			</div>
		</div>
		<?php
	}

	/**
	 * Return available choices for this control inputs.
	 *
	 * @param string $key
	 * @return array
	 */
	public function get_choices( $key = null ) {
		$choices = array(
			'attachment' => array(
				'scroll' => esc_html__( 'Scroll', 'suki' ),
				'fixed'  => esc_html__( 'Fixed', 'suki' ),
			),
			'repeat' => array(
				'no-repeat' => esc_html__( 'No', 'suki' ),
				'repeat-x'  => esc_html__( 'X axis', 'suki' ),
				'repeat-y'  => esc_html__( 'Y axis', 'suki' ),
				'repeat'    => esc_html__( 'Both', 'suki' ),
			),
			'size' => array(
				'auto'    => esc_html__( 'Auto', 'suki' ),
				'cover'   => esc_html__( 'Cover', 'suki' ),
				'contain' => esc_html__( 'Contain', 'suki' ),
			),
			'position' => array(
				'left top'      => esc_html__( 'Left top', 'suki' ),
				'left center'   => esc_html__( 'Left center', 'suki' ),
				'left bottom'   => esc_html__( 'Left bottom', 'suki' ),
				'center top'    => esc_html__( 'Center top', 'suki' ),
				'center center' => esc_html__( 'Center center', 'suki' ),
				'center bottom' => esc_html__( 'Center bottom', 'suki' ),
				'right top'     => esc_html__( 'Right top', 'suki' ),
				'right center'  => esc_html__( 'Right center', 'suki' ),
				'right bottom'  => esc_html__( 'Right bottom', 'suki' ),
			),
		);

		if ( ! empty( $key ) ) {
			return suki_array_value( $choices, $key, array() );
		} else {
			return $choices;
		}
	}
}

// Register control type.
$wp_customize->register_control_type( 'Suki_Customize_Control_Background' );
endif;