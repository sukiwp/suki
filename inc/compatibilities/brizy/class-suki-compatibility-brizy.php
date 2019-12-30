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
		// Modify generated Brizy head content: Replace default (fixed) 1170px content width with theme content container (wrapper) width.
		add_filter( 'brizy_content', array( $this, 'modify_brizy_content' ), 10, 3 );

		// Add compatibility CSS.
		add_action( 'suki/frontend/dynamic_css', array( $this, 'add_compatibility_css' ) );

		// Customizer settings & values
		add_action( 'customize_register', array( $this, 'register_customizer_settings' ) );
	}
	
	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */


	/**
	 * Modify generated Brizy content:
	 * - Replace default (fixed) 1170px content width with theme content container (wrapper) width.
	 *
	 * @param string $content
	 * @param Brizy_Editor_Project $project
	 * @param WP_Post $post
	 * @return string
	 */
	public function modify_brizy_content( $content, $project, $post ) {
		// Use theme's container width.
		if ( '<meta ' === substr( $content, 0, 6 ) && intval( suki_get_theme_mod( 'brizy_use_container_width' ) ) ) {
			$content = preg_replace( '/(\.brz \.brz-css-\w*?\{max-width: )(1170px;)/', '${1}' . suki_get_theme_mod( 'container_width' ) . ';', $content );
		}

		return $content;
	}

	/**	
	 * Add compatibility CSS
	 * - Replace default (fixed) 1170px content width with theme content container (wrapper) width.
	 * - Disable Brizy's reset CSS.
	 *
	 * @param string $inline_css	
	 * @return string
	 */	
	public function add_compatibility_css( $inline_css ) {
		$add_css = '';

		// Use theme's container width on editor.
		if ( suki_get_theme_mod( 'brizy_use_container_width' ) && wp_style_is( 'brizy-editor', 'enqueued' ) ) {
			$add_css .= '.brz-ed .brz-container__wrap[style*="--containerWidth:1170px"] { --containerWidth: ' . suki_get_theme_mod( 'container_width' ) . ' !important; }';
		}
		
		// Disable reset CSS.
		if ( suki_get_theme_mod( 'brizy_disable_reset_css' ) ) {
			$add_css .= '.brz .brz-root__container.brz-reset-all { color: unset !important; font: unset !important; }';
		}

		if ( ! empty( $add_css ) ) {
			$inline_css .= "\n/* Brizy Compatibility CSS */\n" . suki_minify_css_string( $add_css );
		}

 		return $inline_css;
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