<?php
/**
 * Customizer custom control: Horizontal Line
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Suki_Customize_Control_HR' ) ) :
/**
 * Horizontal line control class
 */
class Suki_Customize_Control_HR extends Suki_Customize_Control {
	/**
	 * @var string
	 */
	public $type = 'suki-hr';

	/**
	 * Render control's content
	 */
	protected function render_content() {
		?><hr><?php
	}
}
endif;