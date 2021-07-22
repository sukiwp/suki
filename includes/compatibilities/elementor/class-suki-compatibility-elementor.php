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
		add_action( 'wp_enqueue_scripts', array( $this, 'add_compatibility_css' ), 20 );

		// Disable page settings on Elementor Template post type.
		add_filter( 'suki/dataset/page_settings/ignored_post_types', array( $this, 'disable_page_settings_on_elementor_template' ) );

		// Add theme defined fonts to all typography settings.
		add_action( 'elementor/fonts/additional_fonts', array( $this, 'add_theme_fonts_as_options_on_font_control' ) );

		// Modify Elementor page template.
		add_filter( 'template_include', array( $this, 'remove_content_wrapper_on_page_templates' ), 999 );
		add_action( 'elementor/page_templates/header-footer/before_content', array( $this, 'add_page_template_header_footer_wrapper' ) );
		add_action( 'elementor/page_templates/header-footer/after_content', array( $this, 'add_page_template_header_footer_wrapper_end' ) );

		// Modify single template for many Elementor Library types.
		add_filter( 'single_template', array( $this, 'set_elementor_library_single_template' ) );

		// Color palette compatibility
		add_action( 'customize_register', array( $this, 'register_customizer_settings' ) );
		add_action( 'customize_controls_print_footer_scripts', array( $this, 'print_custom_scripts' ) );
		add_action( 'wp_ajax_suki_apply_color_palette_to_elementor', array( $this, 'ajax_apply_color_palette_to_elementor' ) );
	}
	
	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

	/**	
	 * Add compatibility CSS.
	 */	
	public function add_compatibility_css() {
		$css = "\n/* Elementor Compatibility CSS */\n" . suki_minify_css_string( '.elementor-text-editor > *:last-child { margin-bottom: 0; }' );

		wp_add_inline_style( 'suki', trim( $css ) );
	}

	/**
	 * Register all template locations for Elementor Pro's Theme Builder.
	 *
	 * @param array $post_types
	 * @return array
	 */
	public function disable_page_settings_on_elementor_template( $post_types ) {
		$post_types[] = 'elementor_library';

		return $post_types;
	}

	/**
	 * Modify Icon control: add fonts.
	 *
	 * @param array $fonts
	 * @return array
	 */
	public function add_theme_fonts_as_options_on_font_control( $fonts ) {
		$fonts = array();

		if ( class_exists( '\Elementor\Fonts' ) ) {
			foreach( suki_get_web_safe_fonts() as $font => $stack ) {
				$fonts[ $font ] = \Elementor\Fonts::SYSTEM;
			}

			foreach( suki_get_google_fonts() as $font => $stack ) {
				$fonts[ $font ] = \Elementor\Fonts::GOOGLE;
			}
		}

		return $fonts;
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
			if ( false !== strpos( $template, '/header-footer.php' ) ) {
				// Remove content wrapper.
				add_filter( 'suki/frontend/show_content_wrapper', '__return_false' );
			}
		}

		return $template;
	}

	/**
	 * Add opening wrapper tag to Elementor Header & Footer (Full Width) page template.
	 */
	public function add_page_template_header_footer_wrapper() {
		?>
		<div id="content" class="site-content suki-section">

			<?php if ( is_singular() ) : ?>
				<article id="<?php echo esc_attr( is_page() ? 'page' : 'post' ); ?>-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?> role="article">
			<?php endif; ?>
		<?php
	}

	/**
	 * Add closing wrapper tag to Elementor Header & Footer (Full Width) page template.
	 */
	public function add_page_template_header_footer_wrapper_end() {
			if ( is_singular() ) : ?>
				</article>
			<?php endif; ?>

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

		if ( 'elementor_library' === $post->post_type ) {
			$terms = wp_list_pluck( get_the_terms( $post->ID, 'elementor_library_type' ), 'slug' );

			if ( ! empty( $terms ) ) {
				switch ( $terms[0] ) {
				 	case 'section':
				 	case 'page':
				 		$template = SUKI_INCLUDES_DIR . '/compatibilities/elementor/templates/single-elementor_library.php';
				 		break;
				}
			}
		}

		return $template;
	}

	/**
	 * Register customizer sections, settings, and controls.
	 *
	 * @param WP_Customize_Manager $wp_customize
	 */
	public function register_customizer_settings( $wp_customize ) {
		$defaults = Suki_Customizer::instance()->get_setting_defaults();

		$section = 'suki_section_color_palette';

		/**
		 * ====================================================
		 * Elementor Integration
		 * ====================================================
		 */

		// Heading: Elementor Integration
		$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_color_palette_elementor', array(
			'section'     => $section,
			'settings'    => array(),
			'label'       => esc_html__( 'Elementor Integration', 'suki' ),
			'priority'    => 30,
		) ) );

		// Apply to Elementor color picker
		$wp_customize->add_control( new Suki_Customize_Control_Blank( $wp_customize, 'apply_color_palette_to_elementor', array(
			'section'     => $section,
			'settings'    => array(),
			'description' => '<button class="suki-apply-color-palette-to-elementor button button-secondary">' . esc_html__( 'Apply to Elementor color picker', 'suki' ) . '</button><br><br>' . esc_html__( 'Pressing this button will replace the existing Elementor color picker with the colors you defined above. You can still change and edit Elementor color picker like usual.', 'suki' ),
			'priority'    => 30,
		) ) );
	}

	/**
	 * Print custom javascript for applying color palette to Elementor editor.
	 */
	public function print_custom_scripts() {
		?>
		<script type="text/javascript">
			(function( $ ) {
				'use strict';

				$( '#customize-controls' ).on( 'click', '.suki-apply-color-palette-to-elementor', function( e ) {
					e.preventDefault();

					var $button = $( this );

					$button.prop( 'disabled', 'disabled' );
					$button.addClass( 'disabled' );

					return $.ajax({
						method: 'POST',
						dataType: 'JSON',
						url: ajaxurl,
						cache: false,
						data: {
							action: 'suki_apply_color_palette_to_elementor',
							_ajax_nonce: SukiAdminData.ajax_nonce,
						},
					})
					.done(function( response, status, XHR ) {
						if ( response.success ) {
							alert( '<?php esc_html_e( 'Color palette applied!', 'suki' ); ?>' );
						} else {
							alert( '<?php esc_html_e( 'Error!', 'suki' ); ?>' );
						}

						$button.prop( 'disabled', null );
						$button.removeClass( 'disabled' );
					});
				});
			})( jQuery );
		</script>
		<?php
	}

	/**
	 * ====================================================
	 * AJAX functions
	 * ====================================================
	 */

	/**
	 * AJAX callback to apply color palette to Elementor.
	 */
	public function ajax_apply_color_palette_to_elementor() {
		check_ajax_referer( 'suki', '_ajax_nonce' );

		$palette = array();

		for ( $i = 1; $i <= 8; $i++ ) {
			$palette[] = suki_get_theme_mod( 'color_palette_' . $i, '' );
		}

		update_option( 'elementor_scheme_color-picker', $palette );
		
		wp_send_json_success();
	}
}

Suki_Compatibility_Elementor::instance();