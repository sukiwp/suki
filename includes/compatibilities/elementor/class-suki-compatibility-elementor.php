<?php
/**
 * Plugin compatibility: Elementor
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Elementor compatibility class.
 */
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
		// Add theme defined fonts to all typography settings.
		add_action( 'elementor/fonts/additional_fonts', array( $this, 'add_theme_fonts' ) );

		// Modify single template for many Elementor Library types.
		add_filter( 'single_template', array( $this, 'set_elementor_library_single_template' ) );
	}

	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

	/**
	 * Register all template locations for Elementor Pro's Theme Builder.
	 *
	 * @param array $post_types Post types array.
	 * @return array
	 */
	public function disable_page_settings_on_elementor_template( $post_types ) {
		$post_types[] = 'elementor_library';

		return $post_types;
	}

	/**
	 * Add theme fonts as choices in all font controls.
	 *
	 * @param array $fonts Fonts array.
	 * @return array
	 */
	public function add_theme_fonts( $fonts ) {
		if ( class_exists( '\Elementor\Fonts' ) ) {
			foreach ( suki_get_web_safe_fonts() as $font => $stack ) {
				if ( ! isset( $fonts[ $font ] ) ) {
					$fonts[ $font ] = \Elementor\Fonts::SYSTEM;
				}
			}
		}

		return $fonts;
	}

	/**
	 * Change Elementor Library single template.
	 *
	 * @param string $template Template name.
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
						$template = trailingslashit( SUKI_INCLUDES_DIR ) . 'compatibilities/elementor/templates/single-elementor-library.php';
						break;
				}
			}
		}

		return $template;
	}
}

Suki_Compatibility_Elementor::instance();
