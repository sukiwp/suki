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
	 * @var array
	 */
	public $features = array();

	/**
	 * Render control's content
	 */
	protected function render_content() {
		if ( ! empty( $this->label ) ) : ?>
			<h3>
				<div class="wp-clearfix">
					<span><?php echo $this->label; // WPCS: XSS OK ?></span>
					<a href="<?php echo esc_url( $this->url ); ?>" class="button button-small button-secondary alignright" target="_blank" rel="noopener"><?php echo esc_html_x( 'Learn More', 'Suki Pro upsell', 'suki' ); ?></a>
				</div>
				<?php if ( ! empty( $this->features ) ) : ?>
					<ul class="menu-in-location">
						<?php foreach ( $this->features as $feature ) : ?>
							<li><?php echo $feature; // WPCS: XSS OK ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</h3>
		<?php endif;
	}
}
endif;