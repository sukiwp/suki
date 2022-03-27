<?php
/**
 * Customizer custom control: Background
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Suki_Customize_Control_Background' ) ) {
	/**
	 * Background control class
	 */
	class Suki_Customize_Control_Background extends Suki_Customize_Control {
		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'suki-background';

		/**
		 * Setup parameters for content rendering by Underscore JS template.
		 */
		public function to_json() {
			parent::to_json();

			/**
			 * Add general variables.
			 */

			$this->json['name'] = $this->id;

			$this->json['isCurrentUserCanUpload'] = current_user_can( 'upload_files' );

			/**
			 * Build settingsData.
			 */

			$this->json['settingsData'] = array();

			foreach ( $this->settings as $setting_key => $setting ) {
				// Extract setting type.
				// Skip if no valid type found in the setting id.
				if ( ! preg_match( '/(image|attachment|repeat|size|position)/', $setting->id, $matches ) ) {
					continue;
				}
				$type = $matches[1];

				// Get setting value.
				$value = $this->value( $setting_key );

				// Add to settingsData array.
				$this->json['settingsData'][ $setting_key ] = array(
					'link'  => $this->get_link( $setting_key ),
					'value' => $value,
				);

				// Prepare attachment info fo "image" field.
				if ( 'image' === $type ) {
					$attachment_id = attachment_url_to_postid( $value );

					if ( $attachment_id ) {
						$this->json['imageAttachment'] = wp_prepare_attachment_for_js( $attachment_id );
					}
				}
			}
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
					image: '<?php esc_html_e( 'Image', 'suki' ); ?>',
					attachment: '<?php esc_html_e( 'Attachment', 'suki' ); ?>',
					repeat: '<?php esc_html_e( 'Repeat', 'suki' ); ?>',
					size: '<?php esc_html_e( 'Size', 'suki' ); ?>',
					position: '<?php esc_html_e( 'Position', 'suki' ); ?>',

					button_select: '<?php esc_html_e( 'Select image', 'suki' ); ?>',
					button_remove: '<?php esc_html_e( 'Remove image', 'suki' ); ?>',
					button_change: '<?php esc_html_e( 'Change image', 'suki' ); ?>',
				},
				choices = <?php echo wp_json_encode( $this->get_choices() ); ?>;
			#>
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{{ data.label }}}</span>
			<# } #>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
			<div class="customize-control-content suki-control-box">
				<div>
					<# if ( data.imageAttachment && data.imageAttachment.id ) { #>
						<div class="attachment-media-view attachment-media-view-{{ data.imageAttachment.type }} {{ data.imageAttachment.orientation }}">
							<div class="thumbnail thumbnail-{{ data.imageAttachment.type }}">
								<# if ( 'image' === data.imageAttachment.type && data.imageAttachment.sizes && data.imageAttachment.sizes.full ) { #>
									<img class="attachment-thumb" src="{{ data.imageAttachment.sizes.full.url }}" draggable="false" alt="" />
								<# } else { #>
									<img class="attachment-thumb type-icon icon" src="{{ data.imageAttachment.icon }}" draggable="false" alt="" />
									<p class="attachment-title">{{ data.imageAttachment.title }}</p>
								<# } #>
							</div>
							<div class="actions">
								<# if ( data.isCurrentUserCanUpload ) { #>
									<button type="button" class="button remove-button">{{ labels.button_remove }}</button>
									<button type="button" class="button upload-button control-focus">{{ labels.button_change }}</button>
								<# } #>
							</div>
						</div>
					<# } else { #>
						<div class="attachment-media-view">
							<# if ( data.isCurrentUserCanUpload ) { #>
								<button type="button" class="upload-button button-add-media">{{ labels.button_select }}</button>
							<# } #>
						</div>
					<# } #>
					<input type="hidden" value="{{ data.settingsData.image.value }}" {{{ data.settingsData.image.link }}}>
				</div>

				<div class="suki-flex-fieldset">
					<# _.each( [ 'attachment', 'repeat' ], function( type ) { #>
						<# if ( data.settingsData[ type ] ) { #>
							<div>
								<label class="suki-small-label">{{ labels[ type ] }}</label>
								<select {{{ data.settingsData[ type ].link }}}>
									<# _.each( choices[ type ], function( label, value ) { #>
										<option value="{{ value }}" {{{ value === data.settingsData[ type ].value ? 'selected' : '' }}}>{{{ label }}}</option>
									<# }); #>
								</select>
							</div>
						<# } #>
					<# }); #>
				</div>

				<div class="suki-flex-fieldset">
					<# _.each( [ 'size', 'position' ], function( type ) { #>
						<# if ( data.settingsData[ type ] ) { #>
							<div>
								<label class="suki-small-label">{{ labels[ type ] }}</label>
								<select {{{ data.settingsData[ type ].link }}}>
									<# _.each( choices[ type ], function( label, value ) { #>
										<option value="{{ value }}" {{{ value === data.settingsData[ type ].value ? 'selected' : '' }}}>{{{ label }}}</option>
									<# }); #>
								</select>
							</div>
						<# } #>
					<# }); #>
				</div>
			</div>
			<?php
		}

		/**
		 * Return available choices for this control settingsData.
		 *
		 * @param string $key Key of requested choices.
		 * @return array
		 */
		public function get_choices( $key = null ) {
			$choices = array(
				'attachment' => array(
					'scroll' => esc_html__( 'Scroll', 'suki' ),
					'fixed'  => esc_html__( 'Fixed', 'suki' ),
				),
				'repeat'     => array(
					'no-repeat' => esc_html__( 'No', 'suki' ),
					'repeat-x'  => esc_html__( 'X axis', 'suki' ),
					'repeat-y'  => esc_html__( 'Y axis', 'suki' ),
					'repeat'    => esc_html__( 'Both', 'suki' ),
				),
				'size'       => array(
					'auto'    => esc_html__( 'Auto', 'suki' ),
					'cover'   => esc_html__( 'Cover', 'suki' ),
					'contain' => esc_html__( 'Contain', 'suki' ),
				),
				'position'   => array(
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
}
