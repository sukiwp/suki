<?php
/**
 * Suki module: Google Fonts
 *
 * @package Suki
 *
 * @since 2.0.0
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Google Fonts module class.
 */
class Suki_Google_Fonts extends Suki_Module {
	/**
	 * Module name
	 *
	 * @var string
	 */
	const MODULE_SLUG = 'google-fonts';

	/**
	 * ====================================================
	 * Singleton & constructor functions
	 * ====================================================
	 */

	/**
	 * Class constructor
	 */
	protected function __construct() {
		parent::__construct();

		/**
		 * Fonts data set
		 */

		// Add Google Fonts list to theme fonts bank.
		add_filter( 'suki/dataset/all_fonts', array( $this, 'add_to_all_fonts' ) );

		/**
		 * Customizer settings & values
		 */

		// Add Customizer options.
		add_action( 'customize_register', array( $this, 'add_customizer_settings' ) );

		// Add Customizer default values.
		add_filter( 'suki/customizer/setting_defaults', array( $this, 'add_customizer_setting_defaults' ) );

		/**
		 * Frontend
		 */

		// Enqueue Google Fonts on frontend.
		add_action( 'suki/frontend/before_enqueue_main_css', array( $this, 'enqueue_css' ) );

		if ( boolval( suki_get_theme_mod( 'google_fonts_local' ) ) ) {
			/**
			 * Google Fonts local mode.
			 */

			// Change Google Fonts URL to local self-hosted URL.
			add_filter( 'suki/frontend/google_fonts_url', array( $this, 'use_local_url' ), 999, 2 );
		} else {
			/**
			 * Google Fonts API URL.
			 */

			// Add preconnect for faster performance.
			add_filter( 'wp_resource_hints', array( $this, 'add_preconnect' ), 10, 2 );
		}

		/**
		 * Admin
		 */

		if ( is_admin() ) {
			// Enqueue Google Fonts on Gutenberg block editor.
			add_action( 'after_setup_theme', array( $this, 'enqueue_editor_css' ) );
		}
	}

	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

	/**
	 * Add Google Fonts list to theme fonts bank.
	 *
	 * @param array $fonts Theme fonts bank.
	 * @return array
	 */
	public function add_to_all_fonts( $fonts ) {
		// Add Google Fonts as the last group of the list.
		$fonts = array_merge( $fonts, array( 'google_fonts' => $this->get_fonts_list() ) );

		return $fonts;
	}

	/**
	 * Add Customizer options.
	 *
	 * @param WP_Customize_Manager $wp_customize WP_Customize_Manager object.
	 */
	public function add_customizer_settings( $wp_customize ) {
		$defaults = Suki_Customizer::instance()->get_setting_defaults();

		require_once trailingslashit( SUKI_INCLUDES_DIR ) . 'modules/' . self::MODULE_SLUG . '/customizer/options/global--google-fonts.php';
	}

	/**
	 * Add Customizer default values.
	 *
	 * @param array $defaults Default values.
	 * @return array
	 */
	public function add_customizer_setting_defaults( $defaults = array() ) {
		$add = include trailingslashit( SUKI_INCLUDES_DIR ) . 'modules/' . self::MODULE_SLUG . '/customizer/defaults.php';

		return array_merge_recursive( $defaults, $add );
	}

	/**
	 * Enqueue Google Fonts CSS on frontend.
	 */
	public function enqueue_css() {
		$url = $this->get_embed_url();

		if ( ! empty( $url ) ) {
			wp_enqueue_style( 'suki-google-fonts', $url, array(), SUKI_VERSION );
		}
	}

	/**
	 * Change Google Fonts URL to local self-hosted URL.
	 *
	 * @param string $url   Embed URL.
	 * @param array  $fonts Font families array.
	 * @return string
	 */
	public function use_local_url( $url, $fonts ) {
		require_once trailingslashit( SUKI_INCLUDES_DIR ) . 'modules/' . self::MODULE_SLUG . '/class-wptt-webfont-loader.php';

		return wptt_get_webfont_url( $url );
	}

	/**
	 * Add resource hints to our Google fonts call.
	 *
	 * @param array  $urls           URLs to print for resource hints.
	 * @param string $relation_type  The relation type the URLs are printed.
	 * @return array $urls           URLs to print for resource hints.
	 */
	public function add_preconnect( $urls, $relation_type ) {
		if ( wp_style_is( 'suki-google-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
			$urls[] = array(
				'href' => 'https://fonts.googleapis.com',
			);
			$urls[] = array(
				'href' => 'https://fonts.gstatic.com',
				'crossorigin',
			);
		}

		return $urls;
	}

	/**
	 * Enqueue Google Fonts on Gutenberg block editor.
	 */
	public function enqueue_editor_css() {
		$url = $this->get_embed_url();

		if ( ! empty( $url ) ) {
			add_editor_style( 'suki-google-fonts', $url, array(), SUKI_VERSION );
		}
	}

	/**
	 * ====================================================
	 * Public functions
	 * ====================================================
	 */

	/**
	 * Return array of selected Google Fonts list.
	 *
	 * @todo Update the Google Fonts list regularly.
	 *
	 * @return array
	 */
	public function get_fonts_list() {
		$google_fonts = include trailingslashit( SUKI_INCLUDES_DIR ) . 'modules/' . self::MODULE_SLUG . '/google-fonts-list.php';

		/**
		 * Filter: suki/dataset/google_fonts
		 *
		 * Allow further modification to Google Fonts list.
		 *
		 * @param array $fonts Google Fonts array.
		 * @return array
		 */
		$google_fonts = apply_filters( 'suki/dataset/google_fonts', $google_fonts );

		return $google_fonts;
	}

	/**
	 * Build Google Fonts embed URL from specified fonts
	 *
	 * @param array $google_fonts Array of Google Fonts families.
	 * @return string
	 */
	public function generate_embed_url( $google_fonts = array() ) {
		if ( empty( $google_fonts ) ) {
			return '';
		}

		// Basic embed link.
		$url = ( is_ssl() ? 'https:' : 'http:' ) . '//fonts.googleapis.com/css2?';

		// Add font families.
		foreach ( $google_fonts as $name ) {
			// Add font family and all variants.
			$url .= 'family=' . str_replace( ' ', '+', $name ) . ':ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900';
			$url .= '&';
		}

		// Add display fallback.
		$url .= 'display=swap';

		return $url;
	}

	/**
	 * Return Google Fonts embed URL from selected typography values on Customizer.
	 *
	 * @return string
	 */
	public function get_embed_url() {
		// Get active Google Fonts.
		$fonts = suki_get_theme_mod( 'google_fonts', array() );

		// Abort if there is no active Google Fonts.
		if ( empty( $fonts ) ) {
			return '';
		}

		// Generate embed URL.
		$url = $this->generate_embed_url( $fonts );

		/**
		 * Filter: suki/frontend/google_fonts_url
		 *
		 * Allow further modification to the embed URL.
		 *
		 * @since 2.0.0
		 *
		 * @param string $url   Embed URL.
		 * @param array  $fonts Google Fonts array.
		 */
		$url = apply_filters( 'suki/frontend/google_fonts_url', $url, $fonts );

		return $url;
	}
}

Suki_Google_Fonts::instance();
