<?php
/**
 * Plugin compatibility: Elementor
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Suki_Compatibility_Elementor {

	/**
	 * Singleton instance
	 *
	 * @var Suki_Compatibility_Elementor
	 */
	private static $instance;

	/**
	 * ====================================================
	 * Singleton & constructor functions
	 * ====================================================
	 */

	/**
	 * Get singleton instance.
	 *
	 * @return Suki_Compatibility_Elementor
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Class constructor
	 */
	protected function __construct() {
		// Compatibility CSS
		add_action( 'suki_before_enqueue_main_css', array( $this, 'enqueue_css' ) );

		// Add theme defined fonts to all typography settings.
		add_action( 'elementor/fonts/additional_fonts', array( $this, 'modify_font_control__add_fonts' ) );

		// Modify Elementor page template.
		add_action( 'elementor/page_templates/canvas/before_content', array( $this, 'add_page_template_canvas_wrapper' ) );
		add_action( 'elementor/page_templates/canvas/after_content', array( $this, 'add_page_template_canvas_wrapper_end' ) );
	}
	
	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

	/**
	 * Add postmessage rules for some Customizer settings.
	 * Triggered via filter to allow modification by users.
	 *
	 * @param array $postmessages
	 * @return array
	 */
	public function add_customizer_setting_postmessages( $postmessages = array() ) {
		include( SUKI_INCLUDES_PATH . '/compatibilities/elementor/customizer/postmessages.php' );

		return $postmessages;
	}

	/**
	 * Enqueue compatibility CSS.
	 */
	public function enqueue_css() {
		wp_enqueue_style( 'suki-elementor', SUKI_CSS_URL . '/compatibilities/elementor' . SUKI_ASSETS_SUFFIX . '.css', array(), SUKI_VERSION );
		wp_style_add_data( 'suki-elementor', 'rtl', 'replace' );
	}

	/**
	 * Modify Icon control: add fonts.
	 *
	 * @param array $fonts
	 */
	public function modify_font_control__add_fonts( $fonts ) {
		$fonts = array();

		$class = '\Elementor\Fonts';
		if ( class_exists( $class ) ) {
			foreach( suki_get_web_safe_fonts() as $font => $stack ) {
				$fonts[ $font ] = $class::SYSTEM;
			}

			foreach( suki_get_google_fonts() as $font => $stack ) {
				$fonts[ $font ] = $class::GOOGLE;
			}
		}

		return $fonts;
	}

	/**
	 * Add opening wrapper tag to Elementor Canvas page template.
	 */
	public function add_page_template_canvas_wrapper() {
		?>
		<div id="suki-popup-background" class="suki-popup-close"></div>

		<div id="canvas" class="suki-canvas">
			<div id="page" class="site">
		<?php
	}

	/**
	 * Add closing wrapper tag to Elementor Canvas page template.
	 */
	public function add_page_template_canvas_wrapper_end() {
		?>
			</div>
		</div>
		<?php
	}
}

Suki_Compatibility_Elementor::instance();