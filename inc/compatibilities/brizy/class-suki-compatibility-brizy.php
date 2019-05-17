<?php
/**
 * Plugin compatibility: Brizy
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Suki_Compatibility_Brizy {

	/**
	 * Singleton instance
	 *
	 * @var Suki_Compatibility_Brizy
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
	 * @return Suki_Compatibility_Brizy
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
		if ( suki_get_theme_mod( 'brizy_use_container_width' ) ) {
			// Add editor CSS to replace default (fixed) 1170px content width with theme content container (wrapper) width.
			add_action( 'brizy_editor_enqueue_scripts', array( $this, 'use_theme_container_width_on_editor' ) );

			// Modify generated frontend CSS to replace default (fixed) 1170px content width with theme content container (wrapper) width.
			add_filter( 'brizy_content', array( $this, 'use_theme_container_width_on_frontend' ), 10, 3 );
		}

		// Customizer settings & values
		add_action( 'customize_register', array( $this, 'register_customizer_settings' ) );
	}
	
	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

	/**
	 * Add additional CSS to Brizy editor.
	 */
	public function use_theme_container_width_on_editor() {
		wp_add_inline_style( 'brizy-editor', suki_minify_css_string( '.brz-ed .brz-section__content[style*="--containerWidth:1170px"] { --containerWidth: ' . suki_get_theme_mod( 'container_width' ) . ' !important; }' ) );
	}

	/**
	 * Add additional CSS to Brizy frontend.
	 *
	 * @param string $content
	 * @param Brizy_Editor_Project $project
	 * @param WP_Post $post
	 * @return string
	 */
	public function use_theme_container_width_on_frontend( $content, $project, $post ) {
		if ( ! did_action( 'wp_body_open' ) ) {
			$content = preg_replace( '/max-width:1170px;/', 'max-width:' . suki_get_theme_mod( 'container_width' ) . ';', $content );
		}

		return $content;
	}

	/**
	 * Register customizer sections, settings, and controls.
	 *
	 * @param WP_Customize_Manager $wp_customize
	 */
	public function register_customizer_settings( $wp_customize ) {
		$defaults = Suki_Customizer::instance()->get_setting_defaults();
		
		require_once( SUKI_INCLUDES_DIR . '/compatibilities/brizy/customizer/options/_sections.php' );
		require_once( SUKI_INCLUDES_DIR . '/compatibilities/brizy/customizer/options/brizy.php' );
	}
}

Suki_Compatibility_Brizy::instance();