<?php
/**
 * Suki Customizer class.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Suki Customizer class.
 */
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
		// Default values, outputs, contexts.
		add_filter( 'suki/customizer/setting_defaults', array( $this, 'add_setting_defaults' ) );
		add_filter( 'suki/customizer/setting_outputs', array( $this, 'add_setting_outputs' ) );
		add_filter( 'suki/customizer/control_contexts', array( $this, 'add_control_contexts' ) );

		// Customizer page.
		add_action( 'customize_register', array( $this, 'register_custom_controls' ), 1 );
		add_action( 'customize_register', array( $this, 'register_settings' ) );
		add_action( 'customize_register', array( $this, 'move_other_sections' ), 999 ); // priority needs to be higher than 10 because "Menus" section is registered at "11" priority number.
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
	 * Add default values for all Customizer settings.
	 * Triggered via filter to allow modification by users.
	 *
	 * @param array $defaults Default values array.
	 * @return array
	 */
	public function add_setting_defaults( $defaults = array() ) {
		$add = include SUKI_INCLUDES_DIR . '/customizer/defaults.php';

		return array_merge_recursive( $defaults, $add );
	}

	/**
	 * Add output rules for some Customizer settings.
	 * Triggered via filter to allow modification by users.
	 *
	 * @param array $outputs Post messages array.
	 * @return array
	 */
	public function add_setting_outputs( $outputs = array() ) {
		$add = include SUKI_INCLUDES_DIR . '/customizer/outputs.php';

		return array_merge_recursive( $outputs, $add );
	}

	/**
	 * Add dependency contexts for some Customizer settings.
	 * Triggered via filter to allow modification by users.
	 *
	 * @param array $contexts Contexts array.
	 * @return array
	 */
	public function add_control_contexts( $contexts = array() ) {
		$add = include SUKI_INCLUDES_DIR . '/customizer/contexts.php';

		return array_merge_recursive( $contexts, $add );
	}

	/**
	 * Register custom customizer controls.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer Manager object.
	 */
	public function register_custom_controls( $wp_customize ) {
		require_once SUKI_INCLUDES_DIR . '/customizer/class-suki-customizer-sanitization.php';

		/**
		 * Custom sections
		 */

		require_once SUKI_INCLUDES_DIR . '/customizer/custom-sections/class-suki-customize-spacer-section.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/custom-sections/class-suki-customize-builder-section.php';

		if ( suki_show_pro_teaser() ) {
			require_once SUKI_INCLUDES_DIR . '/customizer/custom-sections/class-suki-customize-pro-link-section.php';
			require_once SUKI_INCLUDES_DIR . '/customizer/custom-sections/class-suki-customize-pro-teaser-section.php';
		}

		/**
		 * Custom controls
		 */

		require_once SUKI_INCLUDES_DIR . '/customizer/custom-controls/class-suki-customize-control.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/custom-controls/class-suki-customize-react-control.php';

		require_once SUKI_INCLUDES_DIR . '/customizer/custom-controls/class-suki-customize-background-control.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/custom-controls/class-suki-customize-builder-control.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/custom-controls/class-suki-customize-color-control.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/custom-controls/class-suki-customize-color-select-control.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/custom-controls/class-suki-customize-dimension-control.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/custom-controls/class-suki-customize-dimensions-control.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/custom-controls/class-suki-customize-freetext-control.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/custom-controls/class-suki-customize-heading-control.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/custom-controls/class-suki-customize-hr-control.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/custom-controls/class-suki-customize-multicheck-control.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/custom-controls/class-suki-customize-multiselect-control.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/custom-controls/class-suki-customize-notice-control.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/custom-controls/class-suki-customize-radioimage-control.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/custom-controls/class-suki-customize-shadow-control.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/custom-controls/class-suki-customize-slider-control.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/custom-controls/class-suki-customize-toggle-control.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/custom-controls/class-suki-customize-typography-control.php';

		require_once SUKI_INCLUDES_DIR . '/customizer/custom-controls/class-suki-customize-pro-teaser-control.php';
	}

	/**
	 * Register customizer sections and settings.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer Manager object.
	 */
	public function register_settings( $wp_customize ) {
		$defaults = $this->get_setting_defaults();

		// Sections and Panels.
		require_once SUKI_INCLUDES_DIR . '/customizer/structures/sections.php';

		// Global Modules.
		require_once SUKI_INCLUDES_DIR . '/customizer/structures/global--social.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/structures/global--color-palette.php';

		// Global Styles.
		require_once SUKI_INCLUDES_DIR . '/customizer/structures/style--size-spacing.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/structures/style--base.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/structures/style--headings.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/structures/style--blockquote.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/structures/style--form-inputs.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/structures/style--buttons.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/structures/style--title.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/structures/style--small-title.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/structures/style--meta.php';

		// Layout.
		require_once SUKI_INCLUDES_DIR . '/customizer/structures/canvas.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/structures/header--builder.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/structures/header--top-main-bottom-bar.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/structures/header--mobile-main-bar.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/structures/header--mobile-vertical-bar.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/structures/header--logo.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/structures/header--menu.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/structures/header--html.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/structures/header--search.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/structures/header--social.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/structures/content.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/structures/content--main.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/structures/content--sidebar.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/structures/content--hero.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/structures/footer--builder.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/structures/footer--widgets-bar.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/structures/footer--bottom-bar.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/structures/footer--copyright.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/structures/footer--html.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/structures/footer--social.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/structures/footer--scroll-to-top.php';

		// Blog.
		require_once SUKI_INCLUDES_DIR . '/customizer/structures/blog--archive.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/structures/blog--single.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/structures/blog--entry-default.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/structures/blog--entry-grid.php';

		// Pages.
		require_once SUKI_INCLUDES_DIR . '/customizer/structures/page--single.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/structures/page--error-404.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/structures/page--search.php';
		require_once SUKI_INCLUDES_DIR . '/customizer/structures/auto-custom-post-types.php';
	}

	/**
	 * Move other sections to the bottom of Customizer panel.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer Manager object.
	 */
	public function move_other_sections( $wp_customize ) {
		$sections = array( 'title_tagline', 'colors', 'header_image', 'background_image', 'nav_menus', 'widgets', 'static_front_page' );

		foreach ( $sections as $i => $key ) {
			if ( in_array( $key, array( 'nav_menus', 'widgets' ), true ) ) {
				$obj = $wp_customize->get_panel( $key );
			} else {
				$obj = $wp_customize->get_section( $key );
			}

			if ( $obj ) {
				$obj->priority = 160 + $i;
			}
		}
	}

	/**
	 * Enqueue customizer controls scripts & styles.
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( 'suki-customizer', SUKI_CSS_URL . '/customizer.css', array(), SUKI_VERSION );
		wp_style_add_data( 'suki-customizer', 'rtl', 'replace' );
		wp_style_add_data( 'suki-customizer', 'suffix', SUKI_ASSETS_SUFFIX );

		// Enqueue JS.
		$script_data = suki_get_script_data( 'customizer' );
		wp_enqueue_script( 'suki-customizer', $script_data['js_file_url'], $script_data['dependencies'], $script_data['version'], true );

		wp_add_inline_script(
			'suki-customizer',
			'const SukiCustomizerData = ' . wp_json_encode(
				array(
					'contexts'        => $this->get_control_contexts(),
					'previewContexts' => $this->get_preview_contexts(),
					'fonts'           => suki_get_all_fonts(),
					'l10n'            => array(
						/**
						 * General
						 */
						'default'          => esc_html__( 'Default', 'suki' ),
						'reset'            => esc_html__( 'Reset', 'suki' ),
						'custom'           => esc_html__( 'Custom', 'suki' ),

						/**
						 * Multi-select
						 */
						'addNew'           => esc_html__( 'Add New', 'suki' ),
						'remove'           => esc_html__( 'Remove', 'suki' ),

						/**
						 * Dimension
						 */
						'top'              => esc_html__( 'Top', 'suki' ),
						'right'            => esc_html__( 'Right', 'suki' ),
						'bottom'           => esc_html__( 'Bottom', 'suki' ),
						'left'             => esc_html__( 'Left', 'suki' ),

						/**
						 * Responsive
						 */
						'dekstop'          => esc_html__( 'Desktop', 'suki' ),
						'tablet'           => esc_html__( 'Tablet', 'suki' ),
						'mobile'           => esc_html__( 'Mobile', 'suki' ),

						/**
						 * Shadow
						 */
						'x'                => esc_html__( 'X axis', 'suki' ),
						'y'                => esc_html__( 'Y axis', 'suki' ),
						'blur'             => esc_html__( 'Blur', 'suki' ),
						'spread'           => esc_html__( 'Spread', 'suki' ),
						'innerShadow'      => esc_html__( 'Inner shadow', 'suki' ),
						'outerShadow'      => esc_html__( 'Outer shadow', 'suki' ),

						/**
						 * Color
						 */
						/* translators: %d: color number. */
						'themeColor$d'     => esc_html__( 'Theme Color %d', 'suki' ),
						'notSet'           => esc_html__( 'Not set', 'suki' ),

						/**
						 * Typography
						 */
						'fontFamily'       => esc_html__( 'Family', 'suki' ),
						'fontWeight'       => esc_html__( 'Weight', 'suki' ),
						'fontStyle'        => esc_html__( 'Style', 'suki' ),
						'textTransform'    => esc_html__( 'Transform', 'suki' ),
						'fontSize'         => esc_html__( 'Size', 'suki' ),
						'lineHeight'       => esc_html__( 'Line Height', 'suki' ),
						'letterSpacing'    => esc_html__( 'Spacing', 'suki' ),

						'weight100'        => esc_html__( 'Thin' ),
						'weight200'        => esc_html__( 'Extra Light', 'suki' ),
						'weight300'        => esc_html__( 'Light', 'suki' ),
						'weight400'        => esc_html__( 'Regular', 'suki' ),
						'weight500'        => esc_html__( 'Medium', 'suki' ),
						'weight600'        => esc_html__( 'Semi Bold', 'suki' ),
						'weight700'        => esc_html__( 'Bold', 'suki' ),
						'weight800'        => esc_html__( 'Extra Bold', 'suki' ),
						'weight900'        => esc_html__( 'Black', 'suki' ),

						'normal'           => esc_html__( 'Normal', 'suki' ),
						'italic'           => esc_html__( 'Italic', 'suki' ),

						'none'             => esc_html__( 'None', 'suki' ),
						'uppercase'        => esc_html__( 'Uppercase', 'suki' ),
						'lowercase'        => esc_html__( 'Lowercase', 'suki' ),
						'capitalize'       => esc_html__( 'Capitalize', 'suki' ),

						/**
						 * Background
						 */
						'attachment'       => esc_html__( 'Attachment', 'suki' ),
						'scroll'           => esc_html__( 'Scroll', 'suki' ),
						'fixed'            => esc_html__( 'Fixed', 'suki' ),

						'repeat'           => esc_html__( 'Repeat', 'suki' ),
						'noRepeat'         => esc_html__( 'No repeat', 'suki' ),
						'repeatX'          => esc_html__( 'Repeat horizontally', 'suki' ),
						'repeatY'          => esc_html__( 'Repeat vertically', 'suki' ),
						'repeatBoth'       => esc_html__( 'Repeat both', 'suki' ),

						'size'             => esc_html__( 'Size', 'suki' ),
						'auto'             => esc_html__( 'Auto', 'suki' ),
						'cover'            => esc_html__( 'Cover', 'suki' ),
						'contain'          => esc_html__( 'Contain', 'suki' ),

						'position'         => esc_html__( 'Position', 'suki' ),
						'leftTop'          => esc_html__( 'Left top', 'suki' ),
						'leftCenter'       => esc_html__( 'Left center', 'suki' ),
						'leftBottom'       => esc_html__( 'Left bottom', 'suki' ),
						'centerTop'        => esc_html__( 'Center top', 'suki' ),
						'centerCenter'     => esc_html__( 'Center center', 'suki' ),
						'centerBottom'     => esc_html__( 'Center bottom', 'suki' ),
						'rightTop'         => esc_html__( 'Right top', 'suki' ),
						'rightCenter'      => esc_html__( 'Right center', 'suki' ),
						'rightBottom'      => esc_html__( 'Right bottom', 'suki' ),

						'selectImage'      => esc_html__( 'Select image', 'suki' ),
						'removeImage'      => esc_html__( 'Remove image', 'suki' ),
						'changeImage'      => esc_html__( 'Change image', 'suki' ),

						/**
						 * Builder
						 */
						'inactiveElements' => esc_html__( 'Inactive elements', 'suki' ),
					),
				)
			),
			'before'
		);
	}

	/**
	 * Enqueue customizer preview scripts & styles.
	 */
	public function enqueue_preview_scripts() {
		wp_enqueue_script( 'suki-customize-preview', SUKI_JS_URL . '/admin/customize-preview.js', array( 'customize-preview' ), SUKI_VERSION, true );

		wp_localize_script(
			'suki-customize-preview',
			'sukiCustomizerPreviewData',
			array(
				'postMessages' => $this->get_setting_outputs(),
				'fonts'        => suki_get_all_fonts(),
			)
		);
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

		$outputs        = $this->get_setting_outputs();
		$default_values = $this->get_setting_defaults();

		// Loop through each setting.
		foreach ( $outputs as $key => $rules ) {
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
					if ( ! $this->check_output_rule_for_css_compatibility( $rule ) ) {
						continue;
					}

					// Sanitize rule.
					$rule = $this->sanitize_output_rule_value( $rule, $setting_value );

					// Add to CSS array.
					$css_array[ $rule['media'] ][ $rule['element'] ][ $rule['property'] ] = $rule['value'];
				}
			}

			echo '<style id="suki-customize-preview-css-' . $key . '" type="text/css">' . suki_convert_css_array_to_string( $css_array ) . '</style>' . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
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
				} );
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
	 * Build CSS string from Customizer's outputs.
	 *
	 * @param array $outputs  Outputs array.
	 * @param array $defaults Default values array.
	 * @return string
	 */
	public function convert_outputs_to_css_string( $outputs = array(), $defaults = array() ) {
		$css_array = $this->convert_outputs_to_css_array( $outputs, $defaults );

		return suki_convert_css_array_to_string( $css_array );
	}

	/**
	 * Convert Customizer's outputs array to CSS array.
	 *
	 * @param array $outputs Post messages array.
	 * @param array $defaults     Default values array.
	 * @return string
	 */
	public function convert_outputs_to_css_array( $outputs = array(), $defaults = array() ) {
		// Temporary CSS array to organize output.
		// Media groups are defined now, for proper responsive orders.
		$css_array = array(
			'global'                                => array(),
			'@media screen and (max-width: 1023px)' => array(),
			'@media screen and (max-width: 499px)'  => array(),
		);

		// Get saved theme mods as an array.
		$mods = get_theme_mods();
		if ( empty( $mods ) ) {
			$mods = array();
		}

		// Intersect the whole outputs array with saved theme mods array.
		// This way we can optimize the iteration to only process the existing theme mods.
		$keys = array_intersect( array_keys( $outputs ), array_keys( $mods ) );

		// Loop through each setting.
		foreach ( $keys as $key ) {
			// Get saved value.
			$setting_value = get_theme_mod( $key );

			// Skip this setting if value is not valid (only accepts string and number).
			if ( ! is_numeric( $setting_value ) && ! is_string( $setting_value ) ) {
				continue;
			}

			// Skip this setting if value is empty string.
			if ( '' === $setting_value ) {
				continue;
			}

			// Skip rule if value === default value.
			if ( suki_array_value( $defaults, $key ) === $setting_value ) {
				continue;
			}

			// Loop through each rule.
			foreach ( $outputs[ $key ] as $rule ) {
				// Check rule validity, and then skip if it's not valid.
				if ( ! $this->check_output_rule_for_css_compatibility( $rule ) ) {
					continue;
				}

				// Sanitize rule.
				$rule = $this->sanitize_output_rule_value( $rule, $setting_value );

				// Add to CSS array.
				$css_array[ $rule['media'] ][ $rule['element'] ][ $rule['property'] ] = $rule['value'];
			}
		}

		return $css_array;
	}

	/**
	 * Check a output rule and return whether it's valid or not.
	 *
	 * @param array $rule Output rule.
	 * @return boolean
	 */
	public function check_output_rule_for_css_compatibility( $rule ) {
		// Check if there is no type defined, then return false.
		if ( ! isset( $rule['type'] ) ) {
			return false;
		}

		// Skip rule if it's not CSS related.
		if ( ! in_array( $rule['type'], array( 'css', 'font' ), true ) ) {
			return false;
		}

		// Check if no element selector is defined, then return false.
		if ( ! isset( $rule['element'] ) ) {
			return false;
		}

		// Check if no property is defined, then return false.
		if ( ! isset( $rule['property'] ) || empty( $rule['property'] ) ) {
			return false;
		}

		// Passed all checks, return true.
		return true;
	}

	/**
	 * Sanitize a output rule, run rule function, format original setting value and fill it into the rule.
	 *
	 * @param array $rule          Output rule.
	 * @param mixed $setting_value Setting value.
	 * @return array
	 */
	public function sanitize_output_rule_value( $rule, $setting_value ) {
		// Declare empty array to hold all available fonts.
		// Will be populated later, only when needed.
		$fonts = array();

		// If "media" attribute is not specified, set it to "global".
		if ( ! isset( $rule['media'] ) || empty( $rule['media'] ) ) {
			$rule['media'] = 'global';
		}

		// If "pattern" attribute is not specified, set it to "$".
		if ( ! isset( $rule['pattern'] ) || empty( $rule['pattern'] ) ) {
			$rule['pattern'] = '$';
		}

		// Convert array value into string.
		if ( is_array( $setting_value ) ) {
			foreach ( $setting_value as $i => $subvalue ) {
				if ( '' === $subvalue ) {
					$setting_value[ $i ] = '0';
				}
			}

			$setting_value = implode( ' ', $setting_value );
		}

		// Check if there is function attached.
		if ( isset( $rule['function'] ) && isset( $rule['function']['name'] ) ) {
			// Apply function to the original value.
			switch ( $rule['function']['name'] ) {
				/**
				 * Explode raw value by space (' ') as the delimiter and then return value from the specified index.
				 *
				 * - args[0] = Index of exploded array to return.
				 */
				case 'explode_value':
					if ( ! isset( $rule['function']['args'][0] ) ) {
						break;
					}

					$index = $rule['function']['args'][0];

					if ( ! is_numeric( $index ) ) {
						break;
					}

					$array = explode( ' ', $setting_value );

					$setting_value = isset( $array[ $index ] ) ? $array[ $index ] : '';
					break;

				/**
				 * Scale all dimensions found in the raw value according to the specified scale amount.
				 *
				 * - args[0] = Scale amount.
				 */
				case 'scale_dimensions':
					if ( ! isset( $rule['function']['args'][0] ) ) {
						break;
					}

					$scale = $rule['function']['args'][0];

					if ( ! is_numeric( $scale ) ) {
						break;
					}

					$parts     = explode( ' ', $setting_value );
					$new_parts = array();

					foreach ( $parts as $i => $part ) {
						$number = floatval( $part );
						$unit   = str_replace( $number, '', $part );

						$new_parts[ $i ] = ( $number * $scale ) . $unit;
					}

					$setting_value = implode( ' ', $new_parts );
					break;
			}
		}

		// Parse value for "font" type.
		if ( 'font' === $rule['type'] ) {
			/**
			 * Chunks
			 *
			 * 0 => group.
			 * 1 => font name.
			 */
			$chunks = explode( '|', $setting_value );

			if ( 2 === count( $chunks ) ) {
				// Populate $fonts array if haven't.
				if ( empty( $fonts ) ) {
					$fonts = suki_get_all_fonts();
				}
				$setting_value = suki_array_value( suki_array_value( $fonts, $chunks[0], array() ), $chunks[1], $chunks[1] );
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
	 * Fallback function since Suki 1.3.0.
	 *
	 * @return array
	 */
	public function get_default_colors() {
		return suki_get_default_colors();
	}

	/**
	 * Return all customizer setting outputs.
	 *
	 * @return array
	 */
	public function get_setting_outputs() {
		/**
		 * Filter: suki/customizer/setting_outputs
		 *
		 * @param array $outputs Setting output rules.
		 */
		$outputs = apply_filters( 'suki/customizer/setting_outputs', array() );

		return $outputs;
	}

	/**
	 * Return all customizer setting .
	 *
	 * @return array
	 */
	public function get_control_contexts() {
		/**
		 * Filter: suki/customizer/control_contexts
		 *
		 * @param array $contexts Control dependency rules.
		 */
		$contexts = apply_filters( 'suki/customizer/control_contexts', array() );

		return $contexts;
	}

	/**
	 * Return all customizer setting defaults.
	 *
	 * @return array
	 */
	public function get_setting_defaults() {
		/**
		 * Filter: suki/customizer/setting_defaults
		 *
		 * @param array $defaults Setting default values.
		 */
		$defaults = apply_filters( 'suki/customizer/setting_defaults', array() );

		return $defaults;
	}

	/**
	 * Return single customizer setting value.
	 *
	 * @param string $key     Key of the requested value.
	 * @param mixed  $default Default value.
	 * @return mixed
	 */
	public function get_setting_value( $key, $default = null ) {
		$value = get_theme_mod( $key, null );

		// Fallback to defaults array.
		if ( is_null( $value ) ) {
			$value = suki_array_value( $this->get_setting_defaults(), $key, null );
		}

		// Fallback to default parameter.
		if ( is_null( $value ) ) {
			$value = $default;
		}

		/**
		 * Filter: suki/customizer/setting_value
		 *
		 * @param mixed  $value Setting value.
		 * @param string $key   Setting key.
		 */
		$value = apply_filters( 'suki/customizer/setting_value', $value, $key );

		/**
		 * Filter: suki/customizer/setting_value/{$key}
		 *
		 * @param mixed  $value Setting value.
		 */
		$value = apply_filters( 'suki/customizer/setting_value/' . $key, $value );

		return $value;
	}

	/**
	 * Return all binding contexts between Customizer's sections and live preview frame.
	 *
	 * @return array
	 */
	public function get_preview_contexts() {
		$contexts = array();

		// Add "Homepage Settings".
		$contexts['static_front_page'] = esc_url( home_url() );

		// Add "404 Page".
		$contexts['suki_section_error_404'] = esc_url( home_url( '404' ) );

		// Add "Search Page".
		$contexts['suki_section_search_results'] = esc_url( home_url( '?s=awesome' ) );

		/**
		 * Filter: suki/customizer/preview_contexts
		 *
		 * @param array $contexts Customizer preview contexts.
		 */
		$contexts = apply_filters( 'suki/customizer/preview_contexts', $contexts );

		return $contexts;
	}

	/**
	 * Return all page types data.
	 *
	 * @param string $context Context of returned types.
	 * @return array
	 */
	public function get_page_types( $context = 'all' ) {
		// Non post type pages.
		$other_types = array(
			'search_results' => array(
				'section'          => 'suki_section_search_results',
				'title'            => esc_html__( 'Search Results Page', 'suki' ),
				'add_auto_options' => false,
			),
			'error_404'      => array(
				'section'          => 'suki_section_error_404',
				'title'            => esc_html__( 'Error 404 Page', 'suki' ),
				'add_auto_options' => false,
			),
		);

		// Native post types.
		$native_types = array(
			'page_single'  => array(
				'section'          => 'suki_section_page_single',
				'title'            => esc_html__( 'Static Page', 'suki' ),
				'add_auto_options' => false,
			),
			'post_archive' => array(
				'section'          => 'suki_section_post_archive',
				'title'            => esc_html__( 'Posts Archive Page', 'suki' ),
				'add_auto_options' => false,
			),
			'post_single'  => array(
				'section'          => 'suki_section_post_single',
				'title'            => esc_html__( 'Single Post Page', 'suki' ),
				'add_auto_options' => false,
			),
		);

		// Custom post types.
		$custom_types = array();
		foreach ( suki_get_public_post_types( 'custom' ) as $cpt ) {
			$cpt_obj = get_post_type_object( $cpt );

			$custom_types[ $cpt . '_archive' ] = array(
				'section'          => 'suki_section_' . $cpt . '_archive',
				/* translators: %s: post type's plural name. */
				'title'            => sprintf( esc_html__( '%s Archive Page', 'suki' ), $cpt_obj->labels->name ),
				'add_auto_options' => true,
			);
			$custom_types[ $cpt . '_single' ]  = array(
				'section'          => 'suki_section_' . $cpt . '_single',
				/* translators: %s: post type's singular name. */
				'title'            => sprintf( esc_html__( 'Single %s Page', 'suki' ), $cpt_obj->labels->singular_name ),
				'add_auto_options' => true,
			);
		}

		/**
		 * Filter: suki/dataset/customizer_page_types/custom
		 *
		 * Allow to modify Customizer page types for custom post types.
		 *
		 * @param array $custom_types Customizer page types for custom post types.
		 * @return array
		 */
		$custom_types = apply_filters( 'suki/dataset/customizer_page_types/custom', $custom_types );

		// Build the return data.
		switch ( $context ) {
			case 'custom':
				$return = $custom_types;
				break;

			case 'native':
				$return = $native_types;
				break;

			case 'others':
				$return = $other_types;
				break;

			default:
				$return = array_merge( $other_types, $native_types, $custom_types );
				break;
		}

		return $return;
	}

	/**
	 * Return all active fonts divided into each provider.
	 *
	 * @param string $group Group to be returned.
	 * @return array
	 */
	public function get_active_fonts( $group = null ) {
		$fonts = array(
			'web_safe_fonts' => array(),
			'custom_fonts'   => array(),
			'google_fonts'   => array(),
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
				if ( ! in_array( $args[1], $fonts[ $args[0] ], true ) ) {
					$fonts[ $args[0] ][] = $args[1];
				}

				// Increment counter.
				++$count;
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
	 * ====================================================
	 * Deprecated functions
	 * ====================================================
	 */

	/**
	 * [DEPRECATED]
	 * Return all page types data.
	 *
	 * @param string $context Context of returned types.
	 * @return array
	 */
	public function get_all_page_settings_types( $context = 'all' ) {
		_deprecated_function( __METHOD__, '2.0.0', __CLASS__ . '::instance->get_page_types' );

		return $this->get_page_types( $context );
	}

	/**
	 * [DEPRECATED]
	 * Enqueue Google Fonts CSS on frontend.
	 */
	public function enqueue_frontend_google_fonts_css() {
		_deprecated_function( __METHOD__, '2.0.0', 'Suki_Google_Fonts::instance()->enqueue_css' );

		if ( class_exists( 'Suki_Google_Fonts' ) ) {
			Suki_Google_Fonts::instance()->enqueue_css();
		}
	}

	/**
	 * [DEPRECATED]
	 * Return Google Fonts embed link from Customizer typography options.
	 */
	public function generate_active_google_fonts_embed_url() {
		_deprecated_function( __METHOD__, '2.0.0' );

		if ( class_exists( 'Suki_Google_Fonts' ) ) {
			$fonts = $this->get_active_fonts( 'google_fonts' );
			return Suki_Google_Fonts::instance()->generate_embed_url( $fonts );
		}
	}

	/**
	 * [DEPRECATED]
	 * Add output rules for some Customizer settings.
	 * Triggered via filter to allow modification by users.
	 *
	 * @param array $postmessages Outputs array.
	 * @return array
	 */
	public function add_setting_postmessages( $postmessages = array() ) {
		_deprecated_function( __METHOD__, '2.0.0', __CLASS__ . '::instance()->add_setting_outputs' );

		return add_setting_outputs( $postmessages );
	}

	/**
	 * [DEPRECATED]
	 * Build CSS string from Customizer's outputs.
	 *
	 * @param array $outputs  Outputs array.
	 * @param array $defaults Default values array.
	 * @return string
	 */
	public function convert_postmessages_to_css_string( $outputs = array(), $defaults = array() ) {
		_deprecated_function( __METHOD__, '2.0.0', __CLASS__ . '::instance()->convert_outputs_to_css_string' );

		return $this->convert_outputs_to_css_string( $outputs, $defaults );
	}

	/**
	 * [DEPRECATED]
	 * Convert Customizer's outputs array to CSS array.
	 *
	 * @param array $postmessages Outputs array.
	 * @param array $defaults     Default values array.
	 * @return string
	 */
	public function convert_postmessages_to_css_array( $postmessages = array(), $defaults = array() ) {
		_deprecated_function( __METHOD__, '2.0.0', __CLASS__ . '::instance()->convert_outputs_to_css_array' );

		return $this->convert_outputs_to_css_array( $postmessages, $defaults );
	}

	/**
	 * [DEPRECATED]
	 * Check a output rule and return whether it's valid or not.
	 *
	 * @param array $rule Output rule.
	 * @return boolean
	 */
	public function check_postmessage_rule_for_css_compatibility( $rule ) {
		_deprecated_function( __METHOD__, '2.0.0', __CLASS__ . '::instance()->check_output_rule_for_css_compatibility' );

		return $this->check_output_rule_for_css_compatibility( $rule );
	}

	/**
	 * [DEPRECATED]
	 * Sanitize a output rule, run rule function, format original setting value and fill it into the rule.
	 *
	 * @param array $rule          Output rule.
	 * @param mixed $setting_value Setting value.
	 * @return array
	 */
	public function sanitize_postmessage_rule_value( $rule, $setting_value ) {
		_deprecated_function( __METHOD__, '2.0.0', __CLASS__ . '::instance()->sanitize_output_rule_value' );

		return $this->sanitize_output_rule_value( $rule, $setting_value );
	}

	/**
	 * [DEPRECATED]
	 * Return all customizer setting outputs.
	 *
	 * @return array
	 */
	public function get_setting_postmessages() {
		_deprecated_function( __METHOD__, '2.0.0', __CLASS__ . '::instance()->get_setting_outputs' );

		return $this->get_setting_outputs();
	}
}

Suki_Customizer::instance();
