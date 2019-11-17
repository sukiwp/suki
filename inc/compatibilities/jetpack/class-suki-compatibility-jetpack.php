<?php
/**
 * Plugin compatibility: Jetpack
 *
 * @link https://jetpack.me/
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Suki_Compatibility_Jetpack {

	/**
	 * Singleton instance
	 *
	 * @var Suki_Compatibility_Jetpack
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
	 * @return Suki_Compatibility_Jetpack
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
		add_action( 'after_setup_theme', array( $this, 'setup_theme' ) );
		add_action( 'suki/frontend/before_enqueue_main_css', array( $this, 'enqueue_css' ) );
	}
	
	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

	/**
	 * Setup theme support for Jetpack.
	 */
	public function setup_theme() {
		// Add theme support for Infinite Scroll.
		// ref: https://jetpack.com/support/infinite-scroll/
		add_theme_support( 'infinite-scroll', array(
			'type'           => 'click',
			'container'      => 'loop',
			'footer'         => 'page',
			'footer_widgets' => array( 'footer-widgets-1', 'footer-widgets-2', 'footer-widgets-3', 'footer-widgets-4', 'footer-widgets-5', 'footer-widgets-6' ),
			'wrapper'        => false,
			'render'         => array( $this, 'render_infinite_scroll' ),
		) );

		// Add theme support for Responsive Videos.
		add_theme_support( 'jetpack-responsive-videos' );
	}

	/**
	 * Enqueue custom CSS.
	 */
	public function enqueue_css() {
		wp_enqueue_style( 'suki-jetpack', SUKI_CSS_URL . '/compatibilities/jetpack/jetpack' . SUKI_ASSETS_SUFFIX . '.css', array(), SUKI_VERSION );
		wp_style_add_data( 'suki-jetpack', 'rtl', 'replace' );
	}

	/**
	 * ====================================================
	 * Render functions
	 * ====================================================
	 */

	/**
	 * Custom render function for Infinite Scroll.
	 */
	public function render_infinite_scroll() {
		while ( have_posts() ) {
			the_post();
			if ( is_search() ) :
			    suki_get_template_part( 'entry', 'search' );
			else :
			    suki_get_template_part( 'entry', suki_get_theme_mod( 'blog_index_loop_mode' ) );
			endif;
		}
	}
}

Suki_Compatibility_Jetpack::instance();