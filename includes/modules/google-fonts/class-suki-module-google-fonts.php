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
class Suki_Module_Google_Fonts extends Suki_Module {
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

		// Load Google Fonts locally.
		if ( boolval( suki_get_theme_mod( 'google_fonts_local' ) ) ) {
			require_once trailingslashit( SUKI_INCLUDES_DIR ) . 'modules/' . self::MODULE_SLUG . '/class-suki-google-fonts-local.php';

			// Change Google Fonts URL to local self-hosted URL.
			add_filter( 'suki/frontend/google_fonts_url', array( $this, 'use_local_google_fonts_url' ), 999 );
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
		// Get active Google Fonts from Customizer values.
		$fonts = Suki_Customizer::instance()->get_active_fonts( 'google_fonts' );

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

		// Enqueue on frontend.
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
	public function use_local_google_fonts_url( $url, $fonts ) {
		$local = new Suki_Google_Fonts_Local( $url );

		return $local->get_url();
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
	 * Return array of Google Fonts subsets.
	 *
	 * @return array
	 */
	public function get_subsets() {
		return array(
			// 'latin' always chosen by default
			'latin-ext'    => 'Latin Extended',
			'arabic'       => 'Arabic',
			'bengali'      => 'Bengali',
			'cyrillic'     => 'Cyrillic',
			'cyrillic-ext' => 'Cyrillic Extended',
			'devaganari'   => 'Devaganari',
			'greek'        => 'Greek',
			'greek-ext'    => 'Greek Extended',
			'gujarati'     => 'Gujarati',
			'gurmukhi'     => 'Gurmukhi',
			'hebrew'       => 'Hebrew',
			'kannada'      => 'Kannada',
			'khmer'        => 'Khmer',
			'malayalam'    => 'Malayalam',
			'myanmar'      => 'Myanmar',
			'oriya'        => 'Oriya',
			'sinhala'      => 'Sinhala',
			'tamil'        => 'Tamil',
			'telugu'       => 'Telugu',
			'thai'         => 'Thai',
			'vietnamese'   => 'Vietnamese',
		);
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
		$link = ( is_ssl() ? 'https:' : 'http:' ) . '//fonts.googleapis.com/css';
		$args = array();

		// Add font families.
		$families = array();
		foreach ( $google_fonts as $name ) {
			// Add font family and all variants.
			$families[] = str_replace( ' ', '+', $name ) . ':100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i';
		}
		$args['family'] = implode( '|', $families );

		// Add font subsets.
		$subsets        = array_merge( array( 'latin' ), suki_get_theme_mod( 'google_fonts_subsets', array() ) );
		$args['subset'] = implode( ',', $subsets );

		return esc_attr( add_query_arg( $args, $link ) );
	}
}

Suki_Module_Google_Fonts::instance();
