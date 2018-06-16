<?php
/**
 * Customizer custom control: Pro
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Suki_Customize_Control_Pro' ) ) :
/**
 * Pro control class
 */
class Suki_Customize_Control_Pro extends WP_Customize_Control {
	/**
	 * @var string
	 */
	public $type = 'suki-pro';

	/**
	 * @var string
	 */
	public $url = '#';

	/**
	 * Render control's content
	 */
	protected function render_content() {
		if ( ! empty( $this->label ) ) : ?>
			<a href="<?php echo esc_url( $this->url ); ?>">
				<h4 class="suki-heading">
					<?php echo $this->label; // WPCS: XSS OK ?>
					<span class="suki-pro-link"><?php esc_html_e( 'Pro', 'suki' ); ?></span>
				</h4>
				<?php if ( ! empty( $this->description ) ) : ?>
					<p class="description customize-control-description"><?php echo $this->description; // WPCS: XSS OK ?></p>
				<?php endif; ?>
			</a>
		<?php endif;
	}
}
endif;