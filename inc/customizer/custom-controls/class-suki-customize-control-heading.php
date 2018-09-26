<?php
/**
 * Customizer custom control: Heading
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Suki_Customize_Control_Heading' ) ) :
/**
 * Heading control class
 */
class Suki_Customize_Control_Heading extends Suki_Customize_Control {
	/**
	 * @var string
	 */
	public $type = 'suki-heading';

	/**
	 * Render control's content
	 */
	protected function render_content() {
		if ( ! empty( $this->label ) ) : ?>
			<span class="tabindex" tabindex="0"></span>
			<h4 class="suki-heading"><span><?php echo $this->label; // WPCS: XSS OK ?></span></h4>
			<?php if ( ! empty( $this->description ) ) : ?>
				<p class="description customize-control-description"><?php echo $this->description; // WPCS: XSS OK ?></p>
			<?php endif; ?>
		<?php endif;
	}
}
endif;