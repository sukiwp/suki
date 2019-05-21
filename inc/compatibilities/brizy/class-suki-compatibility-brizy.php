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

			// Modify generated Brizy head content: Replace default (fixed) 1170px content width with theme content container (wrapper) width.
			add_filter( 'brizy_content', array( $this, 'use_theme_container_width_on_frontend' ), 10, 3 );
		}

		if ( suki_get_theme_mod( 'brizy_disable_reset_css' ) ) {
			// Add editor CSS to unset all Brizy reset CSS.
			add_action( 'brizy_editor_enqueue_scripts', array( $this, 'disable_reset_css_on_editor' ) );
			
			// Add frontend CSS to unset all Brizy reset CSS.
			add_action( 'brizy_preview_enqueue_scripts', array( $this, 'disable_reset_css_on_frontend' ) );
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
	 * Replace default (fixed) 1170px content width with theme content container (wrapper) width on editor.
	 */
	public function use_theme_container_width_on_editor() {
		wp_add_inline_style( 'brizy-editor', suki_minify_css_string( '.brz-ed .brz-section__content[style*="--containerWidth:1170px"] { --containerWidth: ' . suki_get_theme_mod( 'container_width' ) . ' !important; }' ) );
	}

	/**
	 * Modify generated Brizy head content: Replace default (fixed) 1170px content width with theme content container (wrapper) width.
	 *
	 * @param string $content
	 * @param Brizy_Editor_Project $project
	 * @param WP_Post $post
	 * @return string
	 */
	public function use_theme_container_width_on_frontend( $content, $project, $post ) {
		if ( '<meta ' === substr( $content, 0, 6 ) ) {
			$content = preg_replace( '/(\.css-(.*?),\[data-css-\2\])\{max-width:1170px;/', '$1{max-width:' . suki_get_theme_mod( 'container_width' ) . ';', $content );
		}

		return $content;
	}

	/**
	 * Unset all Brizy reset CSS on editor.
	 */
	public function disable_reset_css_on_editor() {
		wp_add_inline_style( 'brizy-editor', suki_minify_css_string( '.brz .brz-root__container.brz-reset-all { all: unset; }' ) );
	}

	/**
	 * Unset all Brizy reset CSS on frontend.
	 */
	public function disable_reset_css_on_frontend() {
		wp_add_inline_style( 'brizy-preview', suki_minify_css_string( '.brz .brz-root__container.brz-reset-all { all: unset; }' ) );
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