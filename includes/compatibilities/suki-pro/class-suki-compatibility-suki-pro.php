<?php
/**
 * Plugin compatibility: Suki Pro
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Suki_Compatibility_Suki_Pro {

	/**
	 * Singleton instance
	 *
	 * @var Suki_Compatibility_Suki_Pro
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
	 * @return Suki_Compatibility_Suki_Pro
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
		/**
		 * Compatibility for Suki Pro prior to v1.1.0.
		 */

		// Get the main version without suffix like "dev", "alpha", "beta".
		if ( defined( 'SUKI_PRO_VERSION' ) && version_compare( preg_replace( '/\-.*/', '', SUKI_PRO_VERSION ), '1.1.0', '<' ) ) {
			// Add legacy "woocommerce-advanced" module and hide the new modules.
			// Use "0" priority because the legacy "woocommerce-advanced" module needs to be added before any other filters run.
			add_filter( 'suki/pro/modules', array( $this, 'fallback_compatibility_for_legacy_woocommerce_advanced_module' ), 0 );

			// Add fallback compatibility for all Suki Pro modules dynamic CSS.
			// Since Suki v1.1.0, all dynamic CSS are printed using 'wp_add_inline_style' instead of manual printing on 'wp_head'.
			add_filter( 'suki/frontend/inline_css', array( $this, 'fallback_compatibility_for_customizer_inline_css' ) );
		}

		/**
		 * Compatibility for Suki Pro prior to v1.2.0.
		 */

		// Get the main version without suffix like "dev", "alpha", "beta".
		if ( defined( 'SUKI_PRO_VERSION' ) && version_compare( preg_replace( '/\-.*/', '', SUKI_PRO_VERSION ), '1.2.0', '<' ) ) {
			// Modify header bar templates to use HTML attributes for Javascript configuration.
			// Since Suki Pro v1.2.0, HTML attributes are no longer used to define Javascript configuration.
			// Instead, localize_script is used to define the configuration.
			add_filter( 'suki/template_part/header-desktop-top-bar', array( $this, 'fallback_compatibility_for_header_top_bar_attributes' ) );
			add_filter( 'suki/template_part/header-desktop-main-bar', array( $this, 'fallback_compatibility_for_header_main_bar_attributes' ) );
			add_filter( 'suki/template_part/header-desktop-bottom-bar', array( $this, 'fallback_compatibility_for_header_bottom_bar_attributes' ) );
			add_filter( 'suki/template_part/header-mobile', array( $this, 'fallback_compatibility_for_header_mobile_main_bar_attributes' ) );
		}
	}
	
	/**
	 * ====================================================
	 * Suki Pro 1.1.0
	 * ====================================================
	 */

	/**
	 * Add legacy "woocommerce-advanced" module and hide the new modules.
	 *
	 * @param array $modules
	 * @return array
	 */
	public function fallback_compatibility_for_legacy_woocommerce_advanced_module( $modules ) {
		$pro_active_modules = get_option( 'suki_pro_active_modules', array() );

		// Hide the new modules.
		foreach ( $modules as $module_slug => $module_data ) {
			if ( 'woocommerce' === $module_data['category'] ) {
				$modules[ $module_slug ]['hide'] = true;
			}
		}

		// Add legacy "woocommerce-advanced" module.
		$modules['woocommerce-advanced'] = array(
			'label'    => esc_html__( 'WooCommerce Advanced (Legacy)', 'suki' ),
			'category' => 'woocommerce',
			'url'      => esc_url( add_query_arg( array( 'utm_source' => 'suki-dashboard', 'utm_medium' => 'learn-more', 'utm_campaign' => 'theme-pro-modules-list' ), trailingslashit( SUKI_PRO_URL ) ) ),
		);

		return $modules;
	}

	/**
	 * Add fallback compatibility for all Suki Pro modules dynamic CSS.
	 *
	 * @param string $css
	 * @return string
	 */
	public function fallback_compatibility_for_customizer_inline_css( $css ) {
		$postmessages = array();
		$active_modules = get_option( 'suki_pro_active_modules', array() );

		foreach ( $active_modules as $i => $module_slug ) {
			// Skip Advanced WooCommerce module if it's activated but no WooCommerce class is found.
			if ( 'woocommerce' === substr( $module_slug, 0, 11 ) && ! class_exists( 'WooCommerce' ) ) {
				continue;
			}

			if ( defined( 'SUKI_PRO_INCLUDES_DIR' ) ) {
				$postmessages_file = trailingslashit( SUKI_PRO_INCLUDES_DIR ) . 'modules/' . $module_slug . '/customizer/postmessages.php';
			} else {
				$postmessages_file = trailingslashit( SUKI_PRO_DIR ) . 'inc/modules/' . $module_slug . '/customizer/postmessages.php';
			}

			if ( file_exists( $postmessages_file ) ) {
				include( $postmessages_file );
			}
		}

		$generated_css = Suki_Customizer::instance()->convert_postmessages_to_css_string( $postmessages );

		if ( ! empty( $generated_css ) ) {
			$css = "\n/* Suki Pro Dynamic CSS (fallback compatibility prior Suki Pro v1.1.0) */\n" . $generated_css;
		}

		return $css;
	}

	/**
	 * ====================================================
	 * Suki Pro 1.2.0
	 * ====================================================
	 */

	/**
	 * Add fallback compatibility for header top bar templates to use HTML attributes for Javascript configuration.
	 *
	 * @param string $html
	 * @return string
	 */
	public function fallback_compatibility_for_header_top_bar_attributes( $html ) {
		$attrs_array = apply_filters( 'suki/frontend/header_top_bar_attrs', array(
			'data-height' => intval( suki_get_theme_mod( 'header_top_bar_height' ) ),
		) );
		$attrs = '';
		foreach ( $attrs_array as $key => $value ) {
			$attrs .= ' ' . $key . '="' . esc_attr( $value ) . '"';
		}

		$html = preg_replace( '/(<div id="suki-header-top-bar".*?)(>)/', '$1 ' . $attrs . '$2', $html );

		return $html;
	}

	/**
	 * Add fallback compatibility for header main bar templates to use HTML attributes for Javascript configuration.
	 *
	 * @param string $html
	 * @return string
	 */
	public function fallback_compatibility_for_header_main_bar_attributes( $html ) {
		$attrs_array = apply_filters( 'suki/frontend/header_main_bar_attrs', array(
			'data-height' => intval( suki_get_theme_mod( 'header_main_bar_height' ) ),
		) );
		$attrs = '';
		foreach ( $attrs_array as $key => $value ) {
			$attrs .= ' ' . $key . '="' . esc_attr( $value ) . '"';
		}

		$html = preg_replace( '/(<div id="suki-header-main-bar".*?)(>)/', '$1 ' . $attrs . '$2', $html );

		return $html;
	}

	/**
	 * Add fallback compatibility for header bottom bar templates to use HTML attributes for Javascript configuration.
	 *
	 * @param string $html
	 * @return string
	 */
	public function fallback_compatibility_for_header_bottom_bar_attributes( $html ) {
		$attrs_array = apply_filters( 'suki/frontend/header_bottom_bar_attrs', array(
			'data-height' => intval( suki_get_theme_mod( 'header_bottom_bar_height' ) ),
		) );
		$attrs = '';
		foreach ( $attrs_array as $key => $value ) {
			$attrs .= ' ' . $key . '="' . esc_attr( $value ) . '"';
		}

		$html = preg_replace( '/(<div id="suki-header-bottom-bar".*?)(>)/', '$1 ' . $attrs . '$2', $html );

		return $html;
	}

	/**
	 * Add fallback compatibility for header mobile main bar templates to use HTML attributes for Javascript configuration.
	 *
	 * @param string $html
	 * @return string
	 */
	public function fallback_compatibility_for_header_mobile_main_bar_attributes( $html ) {
		$attrs_array = apply_filters( 'suki/frontend/header_mobile_main_bar_attrs', array(
			'data-height' => intval( suki_get_theme_mod( 'header_mobile_main_bar_height' ) ),
		) );
		$attrs = '';
		foreach ( $attrs_array as $key => $value ) {
			$attrs .= ' ' . $key . '="' . esc_attr( $value ) . '"';
		}

		$html = preg_replace( '/(<div id="suki-header-mobile-main-bar".*?)(>)/', '$1 ' . $attrs . '$2', $html );

		return $html;
	}
}

Suki_Compatibility_Suki_Pro::instance();