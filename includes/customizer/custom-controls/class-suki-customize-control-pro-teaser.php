<?php
/**
 * Customizer custom control: Pro Teaser
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Suki_Customize_Control_Pro_Teaser' ) ) :
/**
 * Pro Teaser control class
 */
class Suki_Customize_Control_Pro_Teaser extends Suki_Customize_Control {
	/**
	 * @var string
	 */
	public $type = 'suki-pro-teaser';

	/**
	 * @var string
	 */
	public $url = '#';

	/**
	 * @var array
	 */
	public $features = array();

	/**
	 * Render control's content
	 */
	protected function render_content() {
		if ( ! empty( $this->label ) ) : ?>
			<div class="suki-pro-teaser">
				<a class="accordion-section-title" href="<?php echo esc_url( $this->url ); ?>" target="_blank" rel="noopener">
					<h3><?php echo $this->label; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h3>
				</a>
				<?php if ( ! empty( $this->features ) ) : ?>
					<ul>
						<?php foreach ( $this->features as $feature ) : ?>
							<li><?php echo $feature; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
		<?php endif;
	}
}
endif;