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
		// Google Fonts CSS
		add_action( 'suki/frontend/before_enqueue_main_css', array( $this, 'enqueue_frontend_google_fonts_css' ) );

		// Default values, postmessages, contexts
		add_filter( 'suki/customizer/setting_defaults', array( $this, 'add_setting_defaults' ) );
		add_filter( 'suki/customizer/setting_postmessages', array( $this, 'add_setting_postmessages' ) );
		add_filter( 'suki/customizer/control_contexts', array( $this, 'add_control_contexts' ) );

		// Customizer page
		add_action( 'customize_register', array( $this, 'register_custom_controls' ), 1 );
		add_action( 'customize_register', array( $this, 'register_settings' ) );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		if ( is_customize_preview() ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_preview_scripts' ) );
			add_action( 'wp_head', array( $this, 'print_preview_styles' ), 20 );
			add_action( 'wp_footer', array( $this, 'print_preview_scripts' ), 20 );
		}
	}

	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

	/**
	 * Enqueue Google Fonts CSS on frontend.
	 */
	public function enqueue_frontend_google_fonts_css() {
		// Customizer Google Fonts
		$google_fonts_url = $this->generate_active_google_fonts_embed_url();
		if ( ! empty( $google_fonts_url ) ) {
			wp_enqueue_style( 'suki-google-fonts', $google_fonts_url, array(), SUKI_VERSION );
		}
	}

	/**
	 * Add default values for all Customizer settings.
	 * Triggered via filter to allow modification by users.
	 *
	 * @param array $defaults
	 * @return array
	 */
	public function add_setting_defaults( $defaults = array() ) {
		$add = include( SUKI_INCLUDES_DIR . '/customizer/defaults.php' );

		return array_merge_recursive( $defaults, $add );
	}

	/**
	 * Add postmessage rules for some Customizer settings.
	 * Triggered via filter to allow modification by users.
	 *
	 * @param array $postmessages
	 * @return array
	 */
	public function add_setting_postmessages( $postmessages = array() ) {
		$add = include( SUKI_INCLUDES_DIR . '/customizer/postmessages.php' );

		return array_merge_recursive( $postmessages, $add );
	}

	/**
	 * Add dependency contexts for some Customizer settings.
	 * Triggered via filter to allow modification by users.
	 *
	 * @param array $contexts
	 * @return array
	 */
	public function add_control_contexts( $contexts = array() ) {
		$add = include( SUKI_INCLUDES_DIR . '/customizer/contexts.php' );

		return array_merge_recursive( $contexts, $add );
	}

	/**
	 * Register custom customizer controls.
	 *
	 * @param WP_Customize_Manager $wp_customize
	 */
	public function register_custom_controls( $wp_customize ) {
		require_once( SUKI_INCLUDES_DIR . '/customizer/class-suki-customizer-sanitization.php' );

		require_once( SUKI_INCLUDES_DIR . '/customizer/custom-controls/class-suki-customize-section-spacer.php' );

		require_once( SUKI_INCLUDES_DIR . '/customizer/custom-controls/class-suki-customize-control.php' );

		require_once( SUKI_INCLUDES_DIR . '/customizer/custom-controls/class-suki-customize-control-hr.php' );
		require_once( SUKI_INCLUDES_DIR . '/customizer/custom-controls/class-suki-customize-control-heading.php' );
		require_once( SUKI_INCLUDES_DIR . '/customizer/custom-controls/class-suki-customize-control-blank.php' );
		require_once( SUKI_INCLUDES_DIR . '/customizer/custom-controls/class-suki-customize-control-toggle.php' );
		require_once( SUKI_INCLUDES_DIR . '/customizer/custom-controls/class-suki-customize-control-color.php' );
		require_once( SUKI_INCLUDES_DIR . '/customizer/custom-controls/class-suki-customize-control-shadow.php' );
		require_once( SUKI_INCLUDES_DIR . '/customizer/custom-controls/class-suki-customize-control-slider.php' );
		require_once( SUKI_INCLUDES_DIR . '/customizer/custom-controls/class-suki-customize-control-dimension.php' );
		require_once( SUKI_INCLUDES_DIR . '/customizer/custom-controls/class-suki-customize-control-dimensions.php' );
		require_once( SUKI_INCLUDES_DIR . '/customizer/custom-controls/class-suki-customize-control-typography.php' );
		require_once( SUKI_INCLUDES_DIR . '/customizer/custom-controls/class-suki-customize-control-multicheck.php' );
		require_once( SUKI_INCLUDES_DIR . '/customizer/custom-controls/class-suki-customize-control-radioimage.php' );
		require_once( SUKI_INCLUDES_DIR . '/customizer/custom-controls/class-suki-customize-control-builder.php' );

		if ( suki_show_pro_teaser() ) {
			require_once( SUKI_INCLUDES_DIR . '/customizer/custom-controls/class-suki-customize-section-pro-link.php' );
			require_once( SUKI_INCLUDES_DIR . '/customizer/custom-controls/class-suki-customize-section-pro-teaser.php' );
			require_once( SUKI_INCLUDES_DIR . '/customizer/custom-controls/class-suki-customize-control-pro-teaser.php' );
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

		// Sections and Panels
		require_once( SUKI_INCLUDES_DIR . '/customizer/options/_sections.php' );

		// General Styles
		require_once( SUKI_INCLUDES_DIR . '/customizer/options/general--base.php' );
		require_once( SUKI_INCLUDES_DIR . '/customizer/options/general--link.php' );
		require_once( SUKI_INCLUDES_DIR . '/customizer/options/general--headings.php' );
		require_once( SUKI_INCLUDES_DIR . '/customizer/options/general--blockquote.php' );
		require_once( SUKI_INCLUDES_DIR . '/customizer/options/general--form-inputs.php' );
		require_once( SUKI_INCLUDES_DIR . '/customizer/options/general--buttons.php' );
		require_once( SUKI_INCLUDES_DIR . '/customizer/options/general--title.php' );
		require_once( SUKI_INCLUDES_DIR . '/customizer/options/general--small-title.php' );
		require_once( SUKI_INCLUDES_DIR . '/customizer/options/general--meta.php' );
		require_once( SUKI_INCLUDES_DIR . '/customizer/options/general--line-subtle.php' );

		// Layout
		require_once( SUKI_INCLUDES_DIR . '/customizer/options/page-container.php' );
		require_once( SUKI_INCLUDES_DIR . '/customizer/options/header--builder.php' );
		require_once( SUKI_INCLUDES_DIR . '/customizer/options/header--top-main-bottom-bar.php' );
		require_once( SUKI_INCLUDES_DIR . '/customizer/options/header--mobile-main-bar.php' );
		require_once( SUKI_INCLUDES_DIR . '/customizer/options/header--mobile-vertical-bar.php' );
		require_once( SUKI_INCLUDES_DIR . '/customizer/options/header--logo.php' );
		require_once( SUKI_INCLUDES_DIR . '/customizer/options/header--html.php' );
		require_once( SUKI_INCLUDES_DIR . '/customizer/options/header--search.php' );
		require_once( SUKI_INCLUDES_DIR . '/customizer/options/header--cart.php' );
		require_once( SUKI_INCLUDES_DIR . '/customizer/options/header--social.php' );
		require_once( SUKI_INCLUDES_DIR . '/customizer/options/page-header.php' );
		require_once( SUKI_INCLUDES_DIR . '/customizer/options/content--section.php' );
		require_once( SUKI_INCLUDES_DIR . '/customizer/options/content--main.php' );
		require_once( SUKI_INCLUDES_DIR . '/customizer/options/content--sidebar.php' );
		require_once( SUKI_INCLUDES_DIR . '/customizer/options/footer--builder.php' );
		require_once( SUKI_INCLUDES_DIR . '/customizer/options/footer--widgets-bar.php' );
		require_once( SUKI_INCLUDES_DIR . '/customizer/options/footer--bottom-bar.php' );
		require_once( SUKI_INCLUDES_DIR . '/customizer/options/footer--copyright.php' );
		require_once( SUKI_INCLUDES_DIR . '/customizer/options/footer--social.php' );
		require_once( SUKI_INCLUDES_DIR . '/customizer/options/footer--scroll-to-top.php' );

		// Global Settings
		require_once( SUKI_INCLUDES_DIR . '/customizer/options/global--color-palette.php' );
		require_once( SUKI_INCLUDES_DIR . '/customizer/options/global--google-fonts.php' );
		require_once( SUKI_INCLUDES_DIR . '/customizer/options/global--social.php' );

		// Page Settings
		require_once( SUKI_INCLUDES_DIR . '/customizer/options/page-settings.php' );

		// Blog
		require_once( SUKI_INCLUDES_DIR . '/customizer/options/blog--archive.php' );
		require_once( SUKI_INCLUDES_DIR . '/customizer/options/blog--single.php' );
		require_once( SUKI_INCLUDES_DIR . '/customizer/options/blog--entry-default.php' );
		require_once( SUKI_INCLUDES_DIR . '/customizer/options/blog--entry-grid.php' );
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
		wp_enqueue_script( 'suki-customize-preview', SUKI_JS_URL . '/admin/customize-preview.js', array( 'customize-preview' ), SUKI_VERSION, true );
		
		wp_localize_script( 'suki-customize-preview', 'sukiCustomizerPreviewData', array(
			'postMessages' => $this->get_setting_postmessages(),
			'fonts'        => suki_get_all_fonts(),
		) );
	}

	/**
	 * Print <style> tags for preview frame.
	 */
	public function print_preview_styles() {
		// Print global preview CSS.
		echo '<style id="suki-preview-css" type="text/css">.customize-partial-edit-shortcut button:hover,.customize-partial-edit-shortcut button:focus{border-color: currentColor}</style>' . "\n";

		/**
		 * Print saved theme_mods CSS.
		 */

		$postmessages = $this->get_setting_postmessages();
		$default_values = $this->get_setting_defaults();

		// Loop through each setting.
		foreach ( $postmessages as $key => $rules ) {
			// Get saved value.
			$setting_value = get_theme_mod( $key );

			// Get default value.
			$default_value = suki_array_value( $default_values, $key );
			if ( is_null( $default_value ) ) {
				$default_value = '';
			}

			// Temporary CSS array to organize output.
			$css_array = array();

			// Add CSS only if value is not the same as default value and not empty.
			if ( $setting_value !== $default_value && '' !== $setting_value ) {
				foreach ( $rules as $rule ) {
					// Check rule validity, and then skip if it's not valid.
					if ( ! $this->check_postmessage_rule_for_css_compatibility( $rule ) ) {
						continue;
					}

					// Sanitize rule.
					$rule = $this->sanitize_postmessage_rule_value( $rule, $setting_value );

					// Add to CSS array.
					$css_array[ $rule['media'] ][ $rule['element'] ][ $rule['property'] ] = $rule['value'];
				}
			}

			echo '<style id="suki-customize-preview-css-' . $key . '" type="text/css">' . suki_convert_css_array_to_string( $css_array ) . '</style>' . "\n"; // WPCS: XSS OK
		}
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
							// Nav Menu
							if ( placement.partial.id.indexOf( 'nav_menu_instance' ) ) {
								window.suki.initAll();
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
	 * Build CSS string from Customizer's postmessages.
	 *
	 * @param array $postmessages
	 * @param array $defaults
	 * @return string
	 */
	public function convert_postmessages_to_css_string( $postmessages = array(), $defaults = array() ) {
		$css_array = $this->convert_postmessages_to_css_array( $postmessages, $defaults );

		return suki_convert_css_array_to_string( $css_array );
	}

	/**
	 * Convert Customizer's postmessages array to CSS array.
	 *
	 * @param array $postmessages
	 * @param array $defaults
	 * @return string
	 */
	public function convert_postmessages_to_css_array( $postmessages = array(), $defaults = array() ) {
		// Temporary CSS array to organize output.
		// Media groups are defined now, for proper responsive orders.
		$css_array = array(
			'global' => array(),
			'@media screen and (max-width: 1023px)' => array(),
			'@media screen and (max-width: 499px)' => array(),
		);

		// Intersect the whole postmessages array with saved theme mods array.
		// This way we can optimize the iteration to only process the existing theme mods.
		$keys = array_intersect( array_keys( $postmessages ), array_keys( get_theme_mods() ) );

		// Loop through each setting.
		foreach ( $keys as $key ) {
			// Get saved value.
			$setting_value = get_theme_mod( $key );

			// Skip this setting if value is not valid (only accepts string and number).
			if ( ! is_numeric( $setting_value ) && ! is_string( $setting_value ) ) continue;

			// Skip this setting if value is empty string.
			if ( '' === $setting_value ) continue;

			// Skip rule if value === default value.
			if ( $setting_value === suki_array_value( $defaults, $key ) ) continue;

			// Loop through each rule.
			foreach ( $postmessages[ $key ] as $rule ) {
				// Check rule validity, and then skip if it's not valid.
				if ( ! $this->check_postmessage_rule_for_css_compatibility( $rule ) ) {
					continue;
				}

				// Sanitize rule.
				$rule = $this->sanitize_postmessage_rule_value( $rule, $setting_value );

				// Add to CSS array.
				$css_array[ $rule['media'] ][ $rule['element'] ][ $rule['property'] ] = $rule['value'];
			}
		}

		return $css_array;
	}

	/**
	 * Check a postmessage rule and return whether it's valid or not.
	 *
	 * @param array $rule
	 * @return boolean
	 */
	public function check_postmessage_rule_for_css_compatibility( $rule ) {
		// Check if there is no type defined, then return false.
		if ( ! isset( $rule['type'] ) ) return false;

		// Skip rule if it's not CSS related.
		if ( ! in_array( $rule['type'], array( 'css', 'font' ) ) ) return false;

		// Check if no element selector is defined, then return false.
		if ( ! isset( $rule['element'] ) ) return false;

		// Check if no property is defined, then return false.
		if ( ! isset( $rule['property'] ) || empty( $rule['property'] ) ) return false;

		// Passed all checks, return true.
		return true;
	}

	/**
	 * Sanitize a postmessage rule, run rule function, format original setting value and fill it into the rule.
	 *
	 * @param array $rule
	 * @param mixed $setting_value
	 * @return array
	 */
	public function sanitize_postmessage_rule_value( $rule, $setting_value ) {
		// Declare empty array to hold all available fonts.
		// Will be populated later, only when needed.
		$fonts = array();

		// If "media" attribute is not specified, set it to "global".
		if ( ! isset( $rule['media'] ) || empty( $rule['media'] ) ) $rule['media'] = 'global';

		// If "pattern" attribute is not specified, set it to "$".
		if ( ! isset( $rule['pattern'] ) || empty( $rule['pattern'] ) ) $rule['pattern'] = '$';

		// Check if there is function attached.
		if ( isset( $rule['function'] ) && isset( $rule['function']['name'] ) ) {
			// Apply function to the original value.
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

		// Parse value for "font" type.
		if ( 'font' === $rule['type'] ) {
			$chunks = explode( '|', $setting_value );

			if ( 2 === count( $chunks ) ) {
				// Populate $fonts array if haven't.
				if ( empty( $fonts ) ) {
					$fonts = suki_get_all_fonts();
				}
				$setting_value = suki_array_value( $fonts[ $chunks[0] ], $chunks[1], $chunks[1] );
			}
		}

		// Replace any $ found in the pattern to value.
		$rule['value'] = str_replace( '$', $setting_value, $rule['pattern'] );

		// Replace any $ found in the media screen to value.
		$rule['media'] = str_replace( '$', $setting_value, $rule['media'] );

		return $rule;
	}

	/**
	 * Return all customizer default preset value.
	 *
	 * @return array
	 */
	public function get_default_colors() {
		return apply_filters( 'suki/dataset/default_colors', array(
			'transparent'       => 'rgba(0,0,0,0)',
			'white'             => '#ffffff',
			'black'             => '#000000',
			'accent'            => '#0066cc',
			'accent2'           => '#004c99',
			'bg'                => '#ffffff',
			'text'              => '#666666',
			'heading'           => '#333333',
			'meta'              => '#bbbbbb',
			'subtle'            => 'rgba(0,0,0,0.05)',
			'border'            => 'rgba(0,0,0,0.1)',
		) );
	}

	/**
	 * Return all customizer setting postmessages.
	 * 
	 * @return array
	 */
	public function get_setting_postmessages() {
		return apply_filters( 'suki/customizer/setting_postmessages', array() );
	}

	/**
	 * Return all customizer setting .
	 * 
	 * @return array
	 */
	public function get_control_contexts() {
		return apply_filters( 'suki/customizer/control_contexts', array() );
	}

	/**
	 * Return all customizer setting defaults.
	 * 
	 * @return array
	 */
	public function get_setting_defaults() {
		return apply_filters( 'suki/customizer/setting_defaults', array() );
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
			$value = suki_array_value( $this->get_setting_defaults(), $key, null );
		}

		// Fallback to default parameter
		if ( is_null( $value ) ) {
			$value = $default;
		}

		$value = apply_filters( 'suki/customizer/setting_value', $value, $key );
		$value = apply_filters( 'suki/customizer/setting_value/' . $key, $value );

		return $value;
	}

	/**
	 * Return all page types for page settings.
	 * 
	 * @return array
	 */
	public function get_all_page_settings_types() {
		// Define sections with default page types.
		$page_sections = array(
			'search' => array(
				'title' => esc_html__( 'Search Results Page', 'suki' ),
			),
			'404' => array(
				'title' => esc_html__( '404 Page', 'suki' ),
			),
		);

		// Add custom post types to sections.
		$post_types = array_merge(
			array( 'post' ),
			get_post_types( array(
				'public'             => true,
				'publicly_queryable' => true,
				'rewrite'            => true,
				'_builtin'           => false,
			), 'names' )
		);

		$ignored_post_types = apply_filters( 'suki/admin/metabox/page_settings/ignored_post_types', array() );

		$post_types = array_diff( $post_types, $ignored_post_types );

		foreach ( $post_types as $post_type ) {
			$post_type_obj = get_post_type_object( $post_type );

			$page_sections[ $post_type . '_archive' ] = array(
				/* translators: %s: post type's plural name. */
				'title' => sprintf( esc_html__( '%s Archive Page', 'suki' ), $post_type_obj->labels->name ),
				'description' => sprintf(
					/* translators: %s: post type's plural name. */
					esc_html__( 'These are default settings for main %s Archive page and the taxonomy archive page.', 'suki' ),
					$post_type_obj->labels->name
				) . '<br><br>' . sprintf(
					/* translators: %s: post type's singular name. */
					esc_html__( 'TIPS: You can specify different settings for each taxonomy via the Page Settings metabox available on the term edit page.', 'suki' ),
					$post_type_obj->labels->singular_name
				),
			);
			$page_sections[ $post_type . '_singular' ] = array(
				/* translators: %s: post type's singular name. */
				'title' => sprintf( esc_html__( 'Single %s Page', 'suki' ), $post_type_obj->labels->singular_name ),
				'description' => sprintf(
					/* translators: %s: post type's singular name. */
					esc_html__( 'These are default settings for all Single %s page.', 'suki' ),
					$post_type_obj->labels->singular_name
				) . '<br><br>' . sprintf(
					/* translators: %s: Post type's singular name. */
					esc_html__( 'TIPS: You can specify different settings for each %s via the Page Settings metabox available on the edit page.', 'suki' ),
					$post_type_obj->labels->singular_name
				),
			);
		}

		return $page_sections;
	}
	
	/**
	 * Return all active fonts divided into each provider.
	 * 
	 * @param string $group
	 * @return array
	 */
	public function get_active_fonts( $group = null ) {
		$fonts = array(
			'web_safe_fonts' => array(),
			'custom_fonts' => array(),
			'google_fonts' => array(),
		);

		$count = 0;

		$saved_settings = get_theme_mods();
		if ( empty( $saved_settings ) ) {
			$saved_settings = array();
		}

		// Iterate through the saved customizer settings, to find all font family settings.
		foreach ( $saved_settings as $key => $value ) {
			// Check if this setting is not a font family, then skip this setting.
			if ( false === strpos( $key, '_font_family' ) ) {
				continue;
			}

			// Split value format to [font provider, font name].
			$args = explode( '|', $value );

			// Only add if value format is valid.
			if ( 2 === count( $args ) ) {
				// Add to active fonts list.
				// Make sure it is has not been added before.
				if ( ! in_array( $args[1], $fonts[ $args[0] ] ) ) {
					$fonts[ $args[0] ][] = $args[1];
				}

				// Increment counter.
				$count += 1;
			}
		}

		// Check using the counter, if there is no saved settings about font family, add the default system font as active.
		if ( 0 === $count ) {
			$fonts['web_safe_fonts'][] = 'Default System Font';
		}

		// Return values.
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
	public function generate_active_google_fonts_embed_url() {
		return suki_build_google_fonts_embed_url( $this->get_active_fonts( 'google_fonts' ) );
	}
}

Suki_Customizer::instance();