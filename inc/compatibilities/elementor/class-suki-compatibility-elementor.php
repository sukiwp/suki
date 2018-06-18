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
		define( 'ELEMENTOR_PARTNER_ID', 1845 );

		// Customizer settings & values
		add_filter( 'suki_customizer_setting_postmessages', array( $this, 'add_customizer_setting_postmessages' ) );

		// Editor preview CSS
		add_action( 'elementor/preview/enqueue_styles', array( $this, 'enqueue_preview_css' ) );

		// Add Section padding notice.
		add_action( 'elementor/element/section/section_advanced/after_section_start', array( $this, 'add_section_padding_notice' ), 10, 2 );

		// Add Heading widget "Size" options.
		add_action( 'elementor/element/heading/section_title/before_section_end', array( $this, 'add_heading_size_options' ), 10, 2 );

		// Add Button widget "Type" options.
		add_action( 'elementor/element/button/section_button/before_section_end', array( $this, 'add_button_type_options' ), 10, 2 );

		// Add theme defined fonts to all typography settings.
		add_action( 'elementor/fonts/groups', array( $this, 'modify_font_control__add_groups' ) );
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
	 * Enqueue custom preview CSS.
	 */
	public function enqueue_preview_css() {
		$css_array = array(
			'global' => array(
				'#elementor-add-new-section' => array(
					'margin' => 0,
					'max-width' => 'none',
				),
				'.elementor-editor-active > *' => array(
					'pointer-events' => 'none',
				),
				'.elementor-editor-active > *' => array(
					'pointer-events' => 'none',
				),
				'.elementor-editor-active .elementor-edit-mode' => array(
					'pointer-events' => 'auto',
				),
				'.elementor-editor-active .elementor-inner' => array(
					'margin-top' => '0 !important',
				),
				'.elementor-editor-active .elementor-column-wrap.elementor-element-empty .elementor-widget-wrap' => array(
					'min-height' => '30px !important',
				),
				'.elementor-editor-active .elementor.elementor-edit-mode .elementor-top-section > .elementor-container > .elementor-row' => array(
					'min-height' => '30px !important',
				),
				'.elementor-editor-active .elementor.elementor-edit-mode .elementor-section-wrap > .elementor-section:first-child > .elementor-element-overlay > .elementor-editor-section-settings' => array(
					'top' => '0',
					'-webkit-border-radius' => '0 0 3px 3px',
					'border-radius' => '0 0 3px 3px',
					'-webkit-transform' => 'translateX(-50%)',
					'-ms-transform' => 'translateX(-50%)',
					'transform' => 'translateX(-50%)',
				),
			),
		);

		wp_add_inline_style( 'editor-preview', suki_convert_css_array_to_string( $css_array ) );
	}
	
	/**
	 * ====================================================
	 * Editor Hook functions
	 * ====================================================
	 */

	/**
	 * Add section padding notice.
	 *
	 * @param \Elementor\Elements_Base $element
	 * @param array $args
	 */
	public function add_section_padding_notice( $element, $args ) {
		$element->add_control(
			'padding_description',
			array(
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				/* translators: %1$s: desktop edge padding value from Customizer, %2$s: tablet edge padding value from Customizer, %3$s: mobile edge padding value from Customizer. */
				'raw' => wp_kses_post( sprintf( __( 'You might need to set the LEFT & RIGHT PADDING according to your "Edge tolerance padding" value like specified on Customizer.<br><br>Your current edge padding values are:<br>Desktop: %1$spx<br>Tablet: %2$spx<br>Mobile: %3$spx', 'suki' ), suki_get_theme_mod( 'edge_padding' ), suki_get_theme_mod( 'edge_padding__tablet' ), suki_get_theme_mod( 'edge_padding__mobile' ) ) ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				'hide_in_inner' => true,
				'condition' => array(
					'layout' => array( 'boxed' ),
				),
			)
		);
	}

	/**
	 * Add heading size options.
	 *
	 * @param \Elementor\Elements_Base $element
	 * @param array $args
	 */
	public function add_heading_size_options( $element, $args ) {
		$element->update_control(
			'size',
			array(
				'options' => array_merge( suki_array_value( $element->get_controls( 'size' ), 'options', array() ), array(
					'suki-title'       => esc_html__( 'Suki - Title', 'suki' ),
					'suki-small-title' => esc_html__( 'Suki - Small Title', 'suki' ),
					'suki-meta'        => esc_html__( 'Suki - Meta', 'suki' ),
				) ),
			)
		);
	}

	/**
	 * Add button type options.
	 *
	 * @param \Elementor\Elements_Base $element
	 * @param array $args
	 */
	public function add_button_type_options( $element, $args ) {
		$element->update_control(
			'button_type',
			array(
				'options' => array_merge( suki_array_value( $element->get_controls( 'button_type' ), 'options', array() ), array(
					'suki-default' => esc_html__( 'Suki Button', 'suki' ),
				) ),
				'default' => 'suki-default',
			)
		);
	}

	/**
	 * Modify Icon control: add font groups.
	 *
	 * @param array $groups
	 */
	public function modify_font_control__add_groups( $groups ) {
		$new_groups = array(
			/* translators: %s: theme name. */
			'suki_google_fonts' => sprintf( esc_html__( '%s - Google', 'suki' ), suki_get_theme_info( 'name' ) ),
		);

		return array_merge( $new_groups, $groups );
	}

	/**
	 * Modify Icon control: add fonts.
	 *
	 * @param array $fonts
	 */
	public function modify_font_control__add_fonts( $fonts ) {
		$fonts = array();

		foreach( suki_get_web_safe_fonts() as $font => $stack ) {
			$fonts[ $font ] = \Elementor\Fonts::SYSTEM;
		}

		foreach( suki_get_google_fonts() as $font => $stack ) {
			$fonts[ $font ] = 'suki_google_fonts';
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