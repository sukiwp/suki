<?php
/**
 * Plugin compatibility: Elementor Pro
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Suki_Compatibility_Elementor_Pro {

	/**
	 * Singleton instance
	 *
	 * @var Suki_Compatibility_Elementor_Pro
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
	 * @return Suki_Compatibility_Elementor_Pro
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

		// Add support for Theme Builder.
		add_action( 'elementor/theme/register_locations', array( $this, 'register_elementor_locations' ) );
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
		$css = "\n/* Elementor Pro Compatibility CSS */\n" . suki_minify_css_string( '.elementor .elementor-wc-products .woocommerce ul.products li.product { width: auto; }' );

		wp_add_inline_style( 'suki', trim( $css ) );
	}

	/**
	 * Register all template locations for Elementor Pro's Theme Builder.
	 *
	 * @param \ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager $elementor_theme_manager
	 */
	public function register_elementor_locations( $elementor_theme_manager ) {
		global $wp_filter;

		// Manually register theme builder location for header and footer.
		// Why? Because header and footer need to be embedded inside the theme's template tag for better accessibility and SEO.
		foreach ( array( 'header', 'footer' ) as $location ) {
			$hook = 'suki/frontend/' . $location;
			$hook_object = suki_array_value( $wp_filter, $hook );

			// Build an array of all attached actions on this hook that would be removed.
			$remove_hooks = array();
			if ( is_a( $hook_object, 'WP_Hook' ) ) {
				foreach ( $hook_object->callbacks as $priority => $idxs ) {
					foreach ( $idxs as $idx => $callback ) {
						$remove_hooks[] = $callback['function'];
					}
				}
			}

			// Register location.
			$elementor_theme_manager->register_location( $location, array(
				'hook' => $hook,
				'remove_hooks' => $remove_hooks,
			) );
		}
	}
}

Suki_Compatibility_Elementor_Pro::instance();