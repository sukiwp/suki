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
		// Compatibility CSS (via theme inline CSS)
		add_filter( 'suki/frontend/inline_css', array( $this, 'add_compatibility_css' ) );

		// Add theme defined fonts to all typography settings.
		add_action( 'elementor/fonts/additional_fonts', array( $this, 'add_theme_fonts_as_options_on_font_control' ) );

		// Add editor preview CSS.
		add_action( 'elementor/preview/enqueue_styles', array( $this, 'add_editor_preview_css' ) );

		// Modify Elementor page template.
		add_filter( 'template_include', array( $this, 'remove_content_wrapper_on_page_templates' ), 999 );
		add_action( 'elementor/page_templates/canvas/before_content', array( $this, 'add_page_template_canvas_wrapper' ) );
		add_action( 'elementor/page_templates/canvas/after_content', array( $this, 'add_page_template_canvas_wrapper_end' ) );
		add_action( 'elementor/page_templates/header-footer/before_content', array( $this, 'add_page_template_header_footer_wrapper' ) );
		add_action( 'elementor/page_templates/header-footer/after_content', array( $this, 'add_page_template_header_footer_wrapper_end' ) );

		// Modify single template for many Elementor Library types.
		add_filter( 'single_template', array( $this, 'set_elementor_library_single_template' ) );
	}
	
	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

	/**
	 * Add compatibility CSS via inline CSS.
	 *
	 * @param string $inline_css
	 * @return string
	 */
	public function add_compatibility_css( $inline_css ) {
		$inline_css .= "\n/* Elementor compatibility CSS */\n" . suki_minify_css_string( '.elementor-text-editor > *:last-child { margin-bottom: 0; }' ); // WPCS: XSS OK

		return $inline_css;
	}

	/**
	 * Modify Icon control: add fonts.
	 *
	 * @param array $fonts
	 * @return array
	 */
	public function add_theme_fonts_as_options_on_font_control( $fonts ) {
		$fonts = array();

		$class = 'Elementor\Fonts';
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
	 * Add additional CSS to Elementor editor's preview.
	 */
	public function add_editor_preview_css() {
		wp_add_inline_style( 'editor-preview', suki_minify_css_string( '.elementor-editor-active > * { pointer-events: none; } .elementor-editor-active .elementor-edit-mode { pointer-events: auto; }' ) );
	}

	/**
	 * Remove content wrapper on header.php and footer.php via filter.
	 *
	 * @param string $template
	 * @return string
	 */
	public function remove_content_wrapper_on_page_templates( $template ) {
		// Check if Elementor page template is being used.
		if ( false !== strpos( $template, '/elementor/' ) ) {
			if ( false !== strpos( $template, '/header-footer.php' ) || false !== strpos( $template, '/canvas.php' ) ) {
				// Remove content wrapper.
				add_filter( 'suki/frontend/show_content_wrapper', '__return_false' );
			}
		}

		return $template;
	}

	/**
	 * Add opening wrapper tag to Elementor Canvas page template.
	 */
	public function add_page_template_canvas_wrapper() {
		/**
		 * Hook: suki/frontend/before_canvas
		 *
		 * @hooked suki_skip_to_content_link - 1
		 * @hooked suki_top_popups - 10
		 */
		do_action( 'suki/frontend/before_canvas' );
		?>

		<div id="canvas" class="suki-canvas">
			<div id="page" class="site">
				<div id="content" class="site-content">
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?> role="article">
		<?php
	}

	/**
	 * Add closing wrapper tag to Elementor Canvas page template.
	 */
	public function add_page_template_canvas_wrapper_end() {
		?>
					</article>
				</div>
			</div>
		</div>
		
		<?php
		/**
		 * Hook: suki/frontend/after_canvas
		 */
		do_action( 'suki/frontend/after_canvas' );
	}

	/**
	 * Add opening wrapper tag to Elementor Header & Footer (Full Width) page template.
	 */
	public function add_page_template_header_footer_wrapper() {
		?>
		<div id="content" class="site-content">
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?> role="article">
		<?php
	}

	/**
	 * Add closing wrapper tag to Elementor Header & Footer (Full Width) page template.
	 */
	public function add_page_template_header_footer_wrapper_end() {
		?>
			</article>
		</div>
		<?php
	}

	/**
	 * Change Elementor Library single template.
	 *
	 * @param string $template
	 * @return string
	 */
	public function set_elementor_library_single_template( $template ) {
		global $post;

		$terms = wp_list_pluck( get_the_terms( $post->ID, 'elementor_library_type' ), 'slug' );

		if ( ! empty( $terms ) ) {
			switch ( $terms[0] ) {
			 	case 'section':
			 	case 'page':
			 		$template = SUKI_INCLUDES_DIR . '/compatibilities/elementor/templates/single-elementor_library.php';
			 		break;
			}
		}


		return $template;
	}
}

Suki_Compatibility_Elementor::instance();