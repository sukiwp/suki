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

		// Customizer settings & values
		add_filter( 'suki_customizer_setting_postmessages', array( $this, 'add_customizer_setting_postmessages' ) );

		// Add theme defined fonts to all typography settings.
		add_action( 'elementor/fonts/additional_fonts', array( $this, 'modify_font_control__add_fonts' ) );

		// Add new options in Heading widget 'Size' setting.
		add_action( 'elementor/element/heading/section_style/before_section_end', array( $this, 'add_heading_size_options' ), 10, 2 );

		// Add new options in Button widget 'Type' setting.
		add_action( 'elementor/element/button/section_style/before_section_end', array( $this, 'add_button_type_options' ), 10, 2 );

		// Modify Elementor page template.
		add_filter( 'template_include', array( $this, 'remove_content_wrapper_on_page_templates' ), 99999 );
		add_action( 'elementor/page_templates/canvas/before_content', array( $this, 'add_page_template_canvas_wrapper' ) );
		add_action( 'elementor/page_templates/canvas/after_content', array( $this, 'add_page_template_canvas_wrapper_end' ) );
		add_action( 'elementor/page_templates/header-footer/before_content', array( $this, 'add_page_template_header_footer_wrapper' ) );
		add_action( 'elementor/page_templates/header-footer/after_content', array( $this, 'add_page_template_header_footer_wrapper_end' ) );
	}
	
	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

	/**
	 * Enqueue compatibility CSS.
	 */
	public function enqueue_css() {
		wp_enqueue_style( 'suki-elementor', SUKI_CSS_URL . '/compatibilities/elementor' . SUKI_ASSETS_SUFFIX . '.css', array(), SUKI_VERSION );
		wp_style_add_data( 'suki-elementor', 'rtl', 'replace' );
	}

	/**
	 * Add postmessage rules for some Customizer settings.
	 *
	 * @param array $postmessages
	 * @return array
	 */
	public function add_customizer_setting_postmessages( $postmessages = array() ) {
		include( SUKI_INCLUDES_PATH . '/compatibilities/elementor/customizer/postmessages.php' );

		return $postmessages;
	}

	/**
	 * Add heading size options.
	 *
	 * @param \Elementor\Elements_Base $element
	 */
	public function add_heading_size_options( $element, $args ) {
		$element->update_control(
			'size',
			array(
				'options' => array_merge( suki_array_value( $element->get_controls( 'size' ), 'options', array() ), array(
					'suki-title'       => esc_html__( 'Suki - Title', 'suki' ),
					'suki-small-title' => esc_html__( 'Suki - Small Title', 'suki' ),
					'suki-meta'        => esc_html__( 'Suki - Meta Info', 'suki' ),
				) ),
			)
		);
	}

	/**
	 * Add button type options.
	 *
	 * @param \Elementor\Elements_Base $element
	 */
	public function add_button_type_options( $element, $args ) {
		$element->update_control(
			'button_type',
			array(
				'options' => array_merge( suki_array_value( $element->get_controls( 'button_type' ), 'options', array() ), array(
					'suki' => esc_html__( 'Suki - Button', 'suki' ),
				) ),
				'default' => 'suki',
			)
		);

		$element->update_control(
			'border_border',
			array(
				'default' => 'solid',
			)
		);
	}

	/**
	 * Modify Icon control: add fonts.
	 *
	 * @param array $fonts
	 * @return array
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
	 * Remove content wrapper on header.php via filter.
	 *
	 * @param string $template
	 * @return string
	 */
	public function remove_content_wrapper_on_page_templates( $template ) {
		if ( is_singular() ) {
			$page_template = get_post_meta( get_the_ID(), '_wp_page_template', true );

			// Remove content wrapper on Elementor's page templates.
			if ( in_array( $page_template, array( 'elementor_header_footer', 'elementor_canvas' ) ) ) {
				add_filter( 'suki_print_content_wrapper', '__return_false' );
			}
		}

		return $template;
	}

	/**
	 * Add opening wrapper tag to Elementor Canvas page template.
	 */
	public function add_page_template_canvas_wrapper() {
		/**
		 * Hook: suki_before_header
		 *
		 * @hooked suki_skip_to_content_link - 1
		 * @hooked suki_mobile_vertical_header - 10
		 * @hooked suki_popup_background - 99
		 */
		do_action( 'suki_before_canvas' );
		?>

		<div id="canvas" class="suki-canvas">
			<div id="page" class="site">
				<div id="content" class="site-content">

					<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?> role="article">
						<div class="entry-wrapper">
		<?php
	}

	/**
	 * Add closing wrapper tag to Elementor Canvas page template.
	 */
	public function add_page_template_canvas_wrapper_end() {
		?>
						</div>
					</article>

				</div>
			</div>
		</div>
		
		<?php
		/**
		 * Hook: suki_after_canvas
		 */
		do_action( 'suki_after_canvas' );
	}

	/**
	 * Add opening wrapper tag to Elementor Header & Footer (Full Width) page template.
	 */
	public function add_page_template_header_footer_wrapper() {
		// Content wrapper has been deactivated via remove_content_wrapper_on_page_templates().
		?>
		<div id="content" class="site-content">
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?> role="article">
				<div class="entry-wrapper">
		<?php
	}

	/**
	 * Add closing wrapper tag to Elementor Header & Footer (Full Width) page template.
	 */
	public function add_page_template_header_footer_wrapper_end() {
		?>
				</div>
			</article>
		</div>
		<?php
	}
}

Suki_Compatibility_Elementor::instance();