<?php
/**
 * Customizer custom section: Builder
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'WP_Customize_Section' ) && ! class_exists( 'Suki_Customize_Builder_Section' ) ) {
	/**
	 * Builder section class.
	 */
	class Suki_Customize_Builder_Section extends WP_Customize_Section {
		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'suki-builder';

		/**
		 * Render Underscore JS template for this section.
		 */
		protected function render_template() {
			?>
			<li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }}">
				<h3 class="accordion-section-title" tabindex="0">
					{{ data.title }}
					<span class="screen-reader-text"><?php esc_html_e( 'Press return or enter to open this section', 'suki' ); ?></span>
				</h3>
				<ul class="suki-builder-section accordion-section-content">
					<li class="customize-section-description-container section-meta <# if ( data.description_hidden ) { #>customize-info<# } #>">
						<div class="customize-section-title">
							<button class="customize-section-back" tabindex="-1">
								<span class="screen-reader-text"><?php esc_html_e( 'Back', 'suki' ); ?></span>
							</button>
							<h3>
								<span class="customize-action">
									{{{ data.customizeAction }}}
								</span>
								{{ data.title }}
							</h3>
							<# if ( data.description && data.description_hidden ) { #>
								<button type="button" class="customize-help-toggle dashicons dashicons-editor-help" aria-expanded="false"><span class="screen-reader-text"><?php esc_html_e( 'Help', 'suki' ); ?></span></button>
								<div class="description customize-section-description">
									{{{ data.description }}}
								</div>
							<# } #>

							<div class="customize-control-notifications-container"></div>
						</div>

						<# if ( data.description && ! data.description_hidden ) { #>
							<div class="description customize-section-description">
								{{{ data.description }}}
							</div>
						<# } #>
					</li>
					<li class="suki-builder-section__toggle">
						<button class="suki-builder-section__toggle__hide button">
							<span class="dashicons dashicons-arrow-down-alt2"></span>
							<span><?php esc_html_e( 'Hide', 'suki' ); ?></span>
						</button>
						<button class="suki-builder-section__toggle__show button button-primary button-large">
							<span class="dashicons dashicons-arrow-up-alt2"></span>
							<span>{{ data.title }}</span>
						</button>
					</li>
				</ul>
			</li>
			<?php
		}
	}

	// Register section type.
	$wp_customize->register_section_type( 'Suki_Customize_Builder_Section' );
}
