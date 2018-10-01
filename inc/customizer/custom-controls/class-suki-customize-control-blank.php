<?php
/**
 * Customizer custom control: Blank
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Suki_Customize_Control_Blank' ) ) :
/**
 * Blank control class
 */
class Suki_Customize_Control_Blank extends Suki_Customize_Control {
	/**
	 * @var string
	 */
	public $type = 'suki-blank';

	/**
	 * Render control's content
	 */
	protected function render_content() {
		if ( ! empty( $this->label ) ) : ?>
			<span class="customize-control-title"><?php echo $this->label; // WPCS: XSS OK ?></span>
		<?php endif;
		if ( ! empty( $this->description ) ) : ?>
			<span class="description customize-control-description"><?php echo $this->description; // WPCS: XSS OK ?></span>
		<?php endif;
	}
}
endif;