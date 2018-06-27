<?php
/**
 * Contains methods for customizing the theme customization screen.
 * 
 * @link http://codex.wordpress.org/Theme_Customization_API
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Suki_Customizer {

	/**
	 * Singleton instance
	 *
	 * @var Suki_Customizer
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
	 * @return Suki_Customizer
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
		// Default values, postmessages, contexts
		add_filter( 'suki_customizer_setting_defaults', array( $this, 'add_setting_defaults' ) );
		add_filter( 'suki_customizer_setting_postmessages', array( $this, 'add_setting_postmessages' ) );
		add_filter( 'suki_customizer_control_contexts', array( $this, 'add_control_contexts' ) );

		// Customizer page
		add_action( 'customize_register', array( $this, 'register_custom_controls' ), 1 );
		add_action( 'customize_register', array( $this, 'register_settings' ) );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		if ( is_customize_preview() ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_preview_scripts' ) );
			add_action( 'wp_print_styles', array( $this, 'print_preview_styles' ) );
			add_action( 'wp_print_footer_scripts', array( $this, 'print_preview_scripts' ) );
		}
	}

	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

	/**
	 * Add default values for all Customizer settings.
	 * Triggered via filter to allow modification by users.
	 *
	 * @param array $defaults
	 * @return array
	 */
	public function add_setting_defaults( $defaults = array() ) {
		include( SUKI_INCLUDES_PATH . '/customizer/defaults.php' );

		return $defaults;
	}

	/**
	 * Add postmessage rules for some Customizer settings.
	 * Triggered via filter to allow modification by users.
	 *
	 * @param array $postmessages
	 * @return array
	 */
	public function add_setting_postmessages( $postmessages = array() ) {
		include( SUKI_INCLUDES_PATH . '/customizer/postmessages.php' );

		return $postmessages;
	}

	/**
	 * Add dependency contexts for some Customizer settings.
	 * Triggered via filter to allow modification by users.
	 *
	 * @param array $contexts
	 * @return array
	 */
	public function add_control_contexts( $contexts = array() ) {
		include( SUKI_INCLUDES_PATH . '/customizer/contexts.php' );

		return $contexts;
	}

	/**
	 * Register custom customizer controls.
	 *
	 * @param WP_Customize_Manager $wp_customize
	 */
	public function register_custom_controls( $wp_customize ) {
		require_once( SUKI_INCLUDES_PATH . '/customizer/class-suki-customizer-sanitization.php' );

		require_once( SUKI_INCLUDES_PATH . '/customizer/custom-controls/class-suki-customize-section-spacer.php' );

		require_once( SUKI_INCLUDES_PATH . '/customizer/custom-controls/class-suki-customize-control-hr.php' );
		require_once( SUKI_INCLUDES_PATH . '/customizer/custom-controls/class-suki-customize-control-heading.php' );
		require_once( SUKI_INCLUDES_PATH . '/customizer/custom-controls/class-suki-customize-control-blank.php' );
		require_once( SUKI_INCLUDES_PATH . '/customizer/custom-controls/class-suki-customize-control-toggle.php' );
		require_once( SUKI_INCLUDES_PATH . '/customizer/custom-controls/class-suki-customize-control-color.php' );
		require_once( SUKI_INCLUDES_PATH . '/customizer/custom-controls/class-suki-customize-control-shadow.php' );
		require_once( SUKI_INCLUDES_PATH . '/customizer/custom-controls/class-suki-customize-control-slider.php' );
		require_once( SUKI_INCLUDES_PATH . '/customizer/custom-controls/class-suki-customize-control-dimensions.php' );
		require_once( SUKI_INCLUDES_PATH . '/customizer/custom-controls/class-suki-customize-control-typography.php' );
		require_once( SUKI_INCLUDES_PATH . '/customizer/custom-controls/class-suki-customize-control-multicheck.php' );
		require_once( SUKI_INCLUDES_PATH . '/customizer/custom-controls/class-suki-customize-control-builder.php' );

		if ( suki_show_pro_teaser() ) {
			require_once( SUKI_INCLUDES_PATH . '/customizer/custom-controls/class-suki-customize-section-pro.php' );
			require_once( SUKI_INCLUDES_PATH . '/customizer/custom-controls/class-suki-customize-control-pro.php' );
		}
	}

	/**
	 * Register customizer sections and settings.
	 *
	 * @param WP_Customize_Manager $wp_customize
	 */
	public function register_settings( $wp_customize ) {

		/**
		 * Register settings
		 */
		$defaults = $this->get_setting_defaults();

		// Define sections with default page types.
		$page_sections = array(
			'global' => array(
				'title' => esc_html__( 'Static Page', 'suki' ),
				'description' => esc_html__( 'You can override these settings for each individual page.', 'suki' ),
			),
			'search' => array(
				'title' => esc_html__( 'Search Results Page', 'suki' ),
			),
			'404' => array(
				'title' => esc_html__( '404 Page', 'suki' ),
			),
			'post_archive' => array(
				'title' => esc_html__( 'Posts Page', 'suki' ),
			),
			'post_singular' => array(
				'title' => esc_html__( 'Single Post Page', 'suki' ),
				'description' => esc_html__( 'You can override these settings for each individual post.', 'suki' ),
			),
		);

		// Add custom post types to sections.
		$post_types = get_post_types( array(
			'public'             => true,
			'publicly_queryable' => true,
			'rewrite'            => true,
			'_builtin'           => false,
		), 'objects' );
		foreach ( $post_types as $post_type ) {
			$page_sections[ $post_type->name . '_archive' ] = array(
				/* translators: %s: post type's plural name. */
				'title' => sprintf( esc_html__( '%s Page', 'suki' ), $post_type->labels->name ),
			);
			$page_sections[ $post_type->name . '_singular' ] = array(
				/* translators: %s: post type's singular name. */
				'title' => sprintf( esc_html__( 'Single %s Page', 'suki' ), $post_type->labels->singular_name ),
				/* translators: %s: post type's singular name. */
				'description' => sprintf( esc_html__( 'You can override these settings for each individual %s.', 'suki' ), $post_type->labels->singular_name ),
			);
		}

		// Sections and Panels
		require_once( SUKI_INCLUDES_PATH . '/customizer/options/_sections.php' );

		// Change some default WordPress settings to use "postMessage" transport.
		$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

		// General Elements
		require_once( SUKI_INCLUDES_PATH . '/customizer/options/elements--body.php' );
		require_once( SUKI_INCLUDES_PATH . '/customizer/options/elements--headings.php' );
		require_once( SUKI_INCLUDES_PATH . '/customizer/options/elements--blockquote.php' );
		require_once( SUKI_INCLUDES_PATH . '/customizer/options/elements--form-inputs.php' );
		require_once( SUKI_INCLUDES_PATH . '/customizer/options/elements--buttons.php' );
		require_once( SUKI_INCLUDES_PATH . '/customizer/options/elements--title.php' );
		require_once( SUKI_INCLUDES_PATH . '/customizer/options/elements--small-title.php' );
		require_once( SUKI_INCLUDES_PATH . '/customizer/options/elements--meta.php' );

		// Layout
		require_once( SUKI_INCLUDES_PATH . '/customizer/options/page-container.php' );
		require_once( SUKI_INCLUDES_PATH . '/customizer/options/header--builder.php' );
		require_once( SUKI_INCLUDES_PATH . '/customizer/options/header--top-main-bottom-bar.php' );
		require_once( SUKI_INCLUDES_PATH . '/customizer/options/header--mobile-main-bar.php' );
		require_once( SUKI_INCLUDES_PATH . '/customizer/options/header--mobile-vertical-bar.php' );
		require_once( SUKI_INCLUDES_PATH . '/customizer/options/header--logo.php' );
		require_once( SUKI_INCLUDES_PATH . '/customizer/options/header--menu.php' );
		require_once( SUKI_INCLUDES_PATH . '/customizer/options/header--html.php' );
		require_once( SUKI_INCLUDES_PATH . '/customizer/options/header--search.php' );
		require_once( SUKI_INCLUDES_PATH . '/customizer/options/header--social.php' );
		require_once( SUKI_INCLUDES_PATH . '/customizer/options/content--section.php' );
		require_once( SUKI_INCLUDES_PATH . '/customizer/options/content--main.php' );
		require_once( SUKI_INCLUDES_PATH . '/customizer/options/content--sidebar.php' );
		require_once( SUKI_INCLUDES_PATH . '/customizer/options/footer--builder.php' );
		require_once( SUKI_INCLUDES_PATH . '/customizer/options/footer--widgets-bar.php' );
		require_once( SUKI_INCLUDES_PATH . '/customizer/options/footer--bottom-bar.php' );
		require_once( SUKI_INCLUDES_PATH . '/customizer/options/footer--logo.php' );
		require_once( SUKI_INCLUDES_PATH . '/customizer/options/footer--copyright.php' );
		require_once( SUKI_INCLUDES_PATH . '/customizer/options/footer--widgets-column.php' );
		require_once( SUKI_INCLUDES_PATH . '/customizer/options/footer--menu.php' );
		require_once( SUKI_INCLUDES_PATH . '/customizer/options/footer--social.php' );

		// Global Settings
		require_once( SUKI_INCLUDES_PATH . '/customizer/options/settings--google-fonts.php' );
		require_once( SUKI_INCLUDES_PATH . '/customizer/options/settings--social.php' );

		// Page Settings
		require_once( SUKI_INCLUDES_PATH . '/customizer/options/page-settings.php' );

		// Blog
		require_once( SUKI_INCLUDES_PATH . '/customizer/options/blog--archive.php' );
		require_once( SUKI_INCLUDES_PATH . '/customizer/options/blog--single.php' );
		require_once( SUKI_INCLUDES_PATH . '/customizer/options/blog--entry-default.php' );
		require_once( SUKI_INCLUDES_PATH . '/customizer/options/blog--entry-grid.php' );
	}

	/**
	 * Enqueue customizer controls scripts & styles.
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( 'suki-customize-controls', SUKI_CSS_URL . '/admin/customize-controls.css', array(), SUKI_VERSION );
		wp_style_add_data( 'suki-customize-controls', 'rtl', 'replace' );
		
		wp_enqueue_script( 'suki-customize-controls', SUKI_JS_URL . '/admin/customize-controls.js', array( 'customize-controls' ), SUKI_VERSION, true );

		wp_localize_script( 'suki-customize-controls', 'sukiCustomizerControlsData', array(
			'contexts' => $this->get_control_contexts(),
		) );
	}

	/**
	 * Enqueue customizer preview scripts & styles.
	 */
	public function enqueue_preview_scripts() {
		wp_enqueue_script( 'suki-customize-postmessages', SUKI_JS_URL . '/admin/customize-postmessages.js', array( 'customize-preview' ), SUKI_VERSION, true );
		
		wp_localize_script( 'suki-customize-postmessages', 'sukiCustomizerPreviewData', array(
			'postMessages' => $this->get_setting_postmessages(),
			'fonts'        => suki_get_all_fonts(),
		) );
	}

	/**
	 * Print <style> tags for preview frame.
	 */
	public function print_preview_styles() {
		?>
		<style id="suki-preview-css" type="text/css">
			.customize-partial-edit-shortcut button:hover, .customize-partial-edit-shortcut button:focus {
				border-color: #fff;
			}
			.suki-customizer-placeholder.customize-partial-refreshing {
				min-height: 20px;
				background-image: linear-gradient(-45deg, rgba(0,0,0,0.1) 25%, rgba(0,0,0,0) 25%, rgba(0,0,0,0) 50%, rgba(0,0,0,0.1) 50%, rgba(0,0,0,0.1) 75%, rgba(0,0,0,0) 75%, rgba(0,0,0,0));
				background-repeat: repeat-x;
				background-size: 30px 30px;
				-webkit-animation: candystripe 1s linear infinite;
				-moz-animation: candystripe 1s linear infinite;
				animation: candystripe 1s linear infinite;
			}
			@-webkit-keyframes candystripe {
				to { background-position: 30px 0; }
			}
			@-moz-keyframes candystripe {
				to { background-position: 30px 0; }
			}
			@keyframes candystripe {
				to { background-position: 30px 0; }
			}
		</style>
		<?php
	}

	/**
	 * Print <script> tags for preview frame.
	 */
	public function print_preview_scripts() {
		?>
		<script type="text/javascript">
			(function() {
				'use strict';

				document.addEventListener( 'DOMContentLoaded', function() {
					if ( 'undefined' !== typeof wp && wp.customize && wp.customize.selectiveRefresh && wp.customize.widgetsPreview && wp.customize.widgetsPreview.WidgetPartial ) {
						wp.customize.selectiveRefresh.bind( 'partial-content-rendered', function( placement ) {
							switch( placement.partial.id ) {
								// Main Header
								case 'main_header':
									window.suki.initAll();
									break;
							}
						} );
					}
				});
			})();
		</script>
		<?php
	}

	/**
	 * ====================================================
	 * Public functions
	 * ====================================================
	 */

	/**
	 * Return all customizer default preset value.
	 * 
	 * @return array
	 */
	public function get_default_colors() {
		return apply_filters( 'suki_customizer_default_colors', array(
			'transparent'       => 'rgba(0,0,0,0)',
			'white'             => '#ffffff',
			'black'             => '#000000',
			'accent'            => '#5c6bc0',
			'accent_2'          => '#3949ab',
			'bg'                => '#ffffff',
			'text'              => '#666666',
			'text_lighter'      => '#999999',
			'heading'           => '#333333',
			'meta'              => '#bbbbbb',
			'subtle'            => '#f3f3f3',
			'border'            => '#e5e5e5',
			'dark_bg'           => '#000000',
			'dark_text'         => '#bbbbbb',
			'dark_text_lighter' => '#888888',
			'dark_heading'      => '#ffffff',
			'dark_meta'         => '#666666',
			'dark_subtle'       => '#0d0d0d',
			'dark_border'       => '#333333',
		) );
	}

	/**
	 * Return all customizer setting postmessages.
	 * 
	 * @return array
	 */
	public function get_setting_postmessages() {
		return apply_filters( 'suki_customizer_setting_postmessages', array() );
	}

	/**
	 * Return all customizer setting .
	 * 
	 * @return array
	 */
	public function get_control_contexts() {
		return apply_filters( 'suki_customizer_control_contexts', array() );
	}

	/**
	 * Return all customizer setting defaults.
	 * 
	 * @return array
	 */
	public function get_setting_defaults() {
		return apply_filters( 'suki_customizer_setting_defaults', array() );
	}

	/**
	 * Return single customizer setting value.
	 * 
	 * @param string $key
	 * @param mixed $default
	 * @return mixed
	 */
	public function get_setting_value( $key, $default = null ) {
		$value = get_theme_mod( $key, null );

		// Fallback to defaults array
		if ( is_null( $value ) ) {
			$value = suki_array_value( $this->get_setting_defaults(), $key );
		}

		// Fallback to default parameter
		if ( is_null( $value ) ) {
			$value = $default;
		}

		return $value;
	}

	/**
	 * Return all customizer setting keys that contains font_family.
	 * 
	 * @return array
	 */
	public function get_font_family_setting_keys() {
		$keys = array();

		foreach ( $this->get_setting_defaults() as $key => $default ) {
			// Collect all "font family" options.
			if ( false !== strpos( $key, '_font_family' ) ) {
				$keys[] = $key;
			}
		}
		return $keys;
	}
	
	/**
	 * Return all listed fonts divided into each provider.
	 * 
	 * @param string $group
	 * @return array
	 */
	public function get_all_listed_fonts( $group = null ) {
		$fonts = array(
			'web_safe_fonts' => array(),
			'google_fonts' => array(),
			'custom_fonts' => array(),
		);

		foreach ( suki_get_all_fonts() as $key => $list ) {
			$fonts[ $key ] = array_keys( $list );
		}

		if ( is_null( $group ) ) {
			return $fonts;
		} else {
			return suki_array_value( $fonts, $group, array() );
		}
	}
	
	/**
	 * Return all active fonts divided into each provider.
	 * 
	 * @param string $group
	 * @return array
	 */
	public function get_all_selected_fonts( $group = null ) {
		$fonts = array(
			'web_safe_fonts' => array(),
			'google_fonts' => array(),
			'custom_fonts' => array(),
		);

		foreach ( $this->get_font_family_setting_keys() as $key ) {
			$value = $this->get_setting_value( $key );

			// Split value format to [font provider, font name].
			$args = explode( '|', $value );

			if ( 2 === count( $args ) ) {
				// Add to active fonts list.
				// Check if the font family has not been added before.
				if ( ! in_array( $args[1], $fonts[ $args[0] ] ) ) {
					$fonts[ $args[0] ][] = $args[1];
				}
			}
		}

		if ( is_null( $group ) ) {
			return $fonts;
		} else {
			return suki_array_value( $fonts, $group, array() );
		}
	}

	/**
	 * Return Google Fonts embed link from Customizer typography options.
	 * 
	 * @return string
	 */
	public function generate_google_fonts_embed_url() {
		$google_fonts = $this->get_all_selected_fonts( 'google_fonts' );

		// Check if there is no active Google Fonts, then abort.
		if ( empty( $google_fonts ) ) {
			return;
		}

		return suki_generate_google_fonts_embed_url( $google_fonts );
	}

	/**
	 * Generate CSS string from customizer values.
	 * 
	 * @return string
	 */
	public function generate_css() {
		$all_postmessages = $this->get_setting_postmessages();
		$default_values = $this->get_setting_defaults();

		// Temporary CSS array to organize output.
		$css_array = array();

		// Get all available fonts.
		$fonts = suki_get_all_fonts();

		// Loop through each setting.
		foreach ( $all_postmessages as $key => $setting_postmessages ) {
			// Loop through each rule.
			foreach ( $setting_postmessages as $rule ) {
				// Skip rule if there is no type defined.
				if ( ! isset( $rule['type'] ) ) continue;

				// Skup rule if it's not CSS related.
				if ( ! in_array( $rule['type'], array( 'css', 'font' ) ) ) continue;

				// Skip rule if no element selector is defined.
				if ( ! isset( $rule['element'] ) ) continue;

				// Get value (fallback to default value).
				$setting_value = $this->get_setting_value( $key, null );

				// Skip rule if value is not valid or not existed.
				if ( is_null( $setting_value ) || '' === $setting_value ) continue;

				// Minify element selector.
				$rule['element'] = suki_minify_css_string( $rule['element'] );

				// Detect if postmessage type is "CSS".
				if ( 'css' === $rule['type'] ) {
					// Skip rule if no property is defined.
					if ( ! isset( $rule['property'] ) || empty( $rule['property'] ) ) continue;

					// If "media" attribute is not specified, set it to "global".
					if ( ! isset( $rule['media'] ) || empty( $rule['media'] ) ) $rule['media'] = 'global';

					// If "pattern" attribute is not specified, set it to "$".
					if ( ! isset( $rule['pattern'] ) || empty( $rule['pattern'] ) ) $rule['pattern'] = '$';

					// Check if there is function attached.
					if ( isset( $rule['function'] ) && isset( $rule['function']['name'] ) ) {

						switch ( $rule['function']['name'] ) {
							/**
							 * Explode raw value by space (' ') as the delimiter and then return value from the specified index.
							 *
							 * args[0] = index of exploded array to return
							 */
							case 'explode_value':
								if ( ! isset( $rule['function']['args'][0] ) ) break;

								$index = $rule['function']['args'][0];

								if ( ! is_numeric( $index ) ) break;

								$array = explode( ' ', $setting_value );

								$setting_value = isset( $array[ $index ] ) ? $array[ $index ] : '';
								break;

							/**
							 * Scale all dimensions found in the raw value according to the specified scale amount.
							 *
							 * args[0] = scale amount
							 */
							case 'scale_dimensions':
								if ( ! isset( $rule['function']['args'][0] ) ) break;

								$scale = $rule['function']['args'][0];

								if ( ! is_numeric( $scale ) ) break;

								$parts = explode( ' ', $setting_value );
								$new_parts = array();
								foreach ( $parts as $i => $part ) {
									$number = floatval( $part );
									$unit = str_replace( $number, '', $part );

									$new_parts[ $i ] = ( $number * $scale ) . $unit;
								}

								$setting_value = implode( ' ', $new_parts );
								break;
						}
					}

					// Assign setting value to property value.
					$value = $setting_value;

					// Check if "key" attribute is defined and value is an assosiative array.
					if ( is_array( $setting_value ) ) {
						if ( isset( $rule['key'] ) && in_array( $rule['key'], array_keys( $setting_value ) ) ) {
							// Fetch the property value using the key from setting value.
							$value = str_replace( '$', $setting_value[ $rule['key'] ], $rule['pattern'] );
						} else {
							$concat_value = array();
							foreach ( $setting_value as $key => $value ) {
								$concat_value[] = str_replace( '$', $value, $rule['pattern'] );
							}
							$value = implode( ' ', $concat_value );
						}
					} else {
						$value = str_replace( '$', $value, $rule['pattern'] );
					}

					// Minify value.
					$value = suki_minify_css_string( $value );

					// Minify media.
					$rule['media'] = suki_minify_css_string( $rule['media'] );

					// Add to CSS array.
					$css_array[ $rule['media'] ][ $rule['element'] ][ $rule['property'] ] = $value;
				}
				
				// Detect if postmessage type is "font".
				elseif ( 'font' === $rule['type'] ) {
					// Skip rule if it has an array value.
					if ( is_array( $setting_value ) ) continue;

					// Split value to provider and font name.
					if ( '' === $setting_value || 'inherit' === $setting_value ) {
						$value = $setting_value;
					} else {
						$chunks = explode( '|', $setting_value );
						if ( 2 === count( $chunks ) ) {
							$value = suki_array_value( $fonts[ $chunks[0] ], $chunks[1], $chunks[1] );
						} else {
							$value = $setting_value;
						}
					}

					// Minify value.
					$value = suki_minify_css_string( $value );

					// Add to CSS array.
					$css_array['global'][ $rule['element'] ]['font-family'] = $value;
				}
			}
		}

		return suki_convert_css_array_to_string( $css_array );
	}
}

Suki_Customizer::instance();