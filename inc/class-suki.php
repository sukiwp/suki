<?php
/**
 * Contains methods for customizing the theme customization screen.
 * 
 * @link http://codex.wordpress.org/Theme_Customization_API
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Suki {

	/**
	 * Singleton instance
	 *
	 * @var Suki
	 */
	private static $instance;

	/**
	 * Theme info
	 *
	 * @var array
	 */
	private $_info;

	/**
	 * ====================================================
	 * Singleton & constructor functions
	 * ====================================================
	 */

	/**
	 * Get singleton instance.
	 *
	 * @return Suki
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
		add_action( 'after_setup_theme', array( $this, 'setup_theme_info' ), 0 );
		add_action( 'after_setup_theme', array( $this, 'load_translations' ) );
		add_action( 'after_setup_theme', array( $this, 'check_theme_version' ) );
		add_action( 'after_setup_theme', array( $this, 'setup_content_width' ) );
		add_action( 'after_setup_theme', array( $this, 'add_theme_supports' ) );

		add_action( 'wp', array( $this, 'setup_accurate_content_width' ) );
		add_action( 'widgets_init', array( $this, 'register_widgets' ) );
		add_action( 'widgets_init', array( $this, 'register_sidebars' ) );

		// Declare 'wp_enqueue_scripts' action on 'init' hook to make sure all plugins' scripts has been enqueued before theme scripts.
		// For example, Elementor declares their 'wp_enqueue_scripts' actions late, on 'init' hook.
		add_action( 'init', array( $this, 'handle_frontend_scripts' ) );

		$this->_includes();
	}

	/**
	 * Include additional files.
	 */
	private function _includes() {
		// Helper functions
		require_once( SUKI_INCLUDES_PATH . '/helpers.php' );

		// Template functions & hooks
		require_once( SUKI_INCLUDES_PATH . '/template-tags.php' );
		require_once( SUKI_INCLUDES_PATH . '/template-hooks.php' );
		require_once( SUKI_INCLUDES_PATH . '/template-filters.php' );

		// Customizer functions
		require_once( SUKI_INCLUDES_PATH . '/customizer/class-suki-customizer.php' );

		// Admin page functions
		if ( is_admin() ) {
			require_once( SUKI_INCLUDES_PATH . '/admin/class-suki-admin.php' );
		}

		// Plugins compatibility functions
		foreach ( $this->get_compatible_plugins() as $plugin_slug => $plugin_class ) {
			// Only include plugin's compatibility class if the plugin is active.
			if ( class_exists( $plugin_class ) ) {
				$compatibility_file = SUKI_INCLUDES_PATH . '/compatibilities/' . $plugin_slug . '/class-suki-compatibility-' . $plugin_slug . '.php';

				if ( file_exists( $compatibility_file ) ) {
					require_once( $compatibility_file );
				}
			}
		}
	}

	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

	/**
	 * Set theme info based on header data in style.css file.
	 */
	public function setup_theme_info() {
		// Extract theme data from style.css
		$info = get_file_data( get_template_directory() . '/style.css', array(
			'name'        => 'Theme Name',
			'url'         => 'Theme URI',
			'description' => 'Description',
			'author'      => 'Author',
			'author_url'  => 'Author URI',
			'version'     => 'Version',
			'template'    => 'Template',
			'status'      => 'Status',
			'tags'        => 'Tags',
			'text_domain' => 'Text Domain',
			'domain_path' => 'Domain Path',
		) );

		// Add screenshot to theme data.
		$info['screenshot'] = esc_url( get_template_directory_uri() . '/screenshot.png' );

		// Assign to class $_info property.
		$this->_info = $info;
	}

	/**
	 * Check theme version and add hook to do some actions when version changed.
	 */
	public function check_theme_version() {
		// Get theme version info from DB
		$db_version = get_option( 'suki_theme_version', false );
		$current_version = $this->get_info( 'version' );

		// If no version info found in DB, then create the info.
		if ( ! $db_version ) {
			add_option( 'suki_theme_version', $current_version );
			return;
		}

		// If current version is larger than DB version, update DB version.
		if ( $db_version < $current_version ) {
			/**
			 * Hook: suki/maintenance/version_changed
			 */
			do_action( 'suki/maintenance/version_changed', $db_version, $current_version );

			update_option( 'suki_theme_version', $current_version );
		}
	}

	/**
	 * Set the content width in pixels, based on the theme's design and stylesheet.
	 * Priority 0 to make it available to lower priority callbacks.
	 *
	 * @global integer $content_width
	 */
	public function setup_content_width() {
		global $content_width;

		$content_width = floatval( suki_get_theme_mod( 'container_width' ) );
	}

	/**
	 * Set the global variable $content_width with more accurate value.
	 *
	 * @global integer $content_width
	 */
	public function setup_accurate_content_width() {
		global $content_width;

		$content_width = suki_get_content_width_by_layout( suki_get_current_page_setting( 'content_layout' ) );
	}

	/**
	 * Load translations for theme's text domain.
	 */
	public function load_translations() {
		load_theme_textdomain( 'suki', get_template_directory() . '/languages' );
	}

	/**
	 * Registers support for various WordPress features.
	 */
	public function add_theme_supports() {
		// Add default posts and comments RSS feed links to head
		add_theme_support( 'automatic-feed-links' );

		// Enable support for document <title> tag generated by WordPress itself
		add_theme_support( 'title-tag' );

		// Enable support for Post thumbnails on posts and pages
		add_theme_support( 'post-thumbnails' );

		// Register menus
		register_nav_menus( array(
			'header-menu-1' => esc_html__( 'Header Menu 1', 'suki' ),
			'header-mobile-menu' => esc_html__( 'Mobile Header Menu', 'suki' ),
			'footer-menu-1' => esc_html__( 'Footer Menu', 'suki' ),
		) );

		// Enable HTML5 tags for search form, comment form, and comments
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Enable custom logo
		add_theme_support( 'custom-logo', array(
			'flex-height' => true,
			'flex-width'  => true,
		) );

		// Add theme support for selective refresh for widgets
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Breadcrumb trail compatibility
		add_theme_support( 'breadcrumb-trail' );

		// Gutenberg "align-wide" compatibility
		add_theme_support( 'align-wide' );
	}

	/**
	 * Register custom widgets.
	 */
	public function register_widgets() {
		// Include custom widgets.
		require_once( SUKI_INCLUDES_PATH . '/widgets/class-suki-widget-posts.php' );

		// Register widgets.
		register_widget( 'Suki_Widget_Posts' );
	}
	
	/**
	 * Register theme sidebars (widget area).
	 */
	public function register_sidebars() {
		register_sidebar( array(
			'name'          => esc_html__( 'Sidebar', 'suki' ),
			'id'            => 'sidebar',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title h4">',
			'after_title'   => '</h2>',
		) );

		for ( $i = 1; $i <= 6; $i++ ) {
			register_sidebar( array(
				/* translators: %d: number of footer widgets column. */
				'name'          => sprintf( esc_html__( 'Footer Widgets Column %d', 'suki' ), $i ),
				'id'            => 'footer-widgets-' . $i,
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h2 class="widget-title h4">',
				'after_title'   => '</h2>',
			) );
		}
	}

	/**
	 * Enqueue frontend scripts.
	 *
	 * @param string $hook
	 */
	public function handle_frontend_scripts( $hook ) {
		add_filter( 'script_loader_tag', array( $this, 'add_defer_attribute_to_scripts' ), 10, 2 );

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_javascripts' ) );
	}

	/**
	 * Enqueue frontend styles.
	 *
	 * @param string $hook
	 */
	public function enqueue_frontend_styles( $hook ) {
		// Hook: Styles to be included before main CSS
		do_action( 'suki/frontend/before_enqueue_main_css', $hook );

		// Main CSS
		wp_enqueue_style( 'suki', SUKI_CSS_URL . '/main' . SUKI_ASSETS_SUFFIX . '.css', array(), SUKI_VERSION );
		wp_style_add_data( 'suki', 'rtl', 'replace' );

		// Hook: Styles to included after main CSS
		do_action( 'suki/frontend/after_enqueue_main_css', $hook );

		// Customizer generated CSS
		wp_add_inline_style( 'suki', trim( apply_filters( 'suki/frontend/inline_css', '' ) ) );
	}

	/**
	 * Enqueue frontend scripts.
	 *
	 * @param string $hook
	 */
	public function enqueue_frontend_javascripts( $hook ) {
		// Fetched version from package.json
		$ver = array();
		$ver['classlist-polyfill'] = '1.2.20180112';

		// classList Polyfill
		if ( function_exists( 'wp_script_add_data' ) ) {
			wp_enqueue_script( 'classlist-polyfill', SUKI_JS_URL . '/classList' . SUKI_ASSETS_SUFFIX . '.js', array(), $ver['classlist-polyfill'], true );
			wp_script_add_data( 'classlist-polyfill', 'conditional', 'lte IE 11' );
		}

		// Comment reply (WordPress)
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		// Hook: Scripts to be included before main JS
		do_action( 'suki/frontend/before_enqueue_main_js', $hook );

		// Main JS
		wp_enqueue_script( 'suki', SUKI_JS_URL . '/main' . SUKI_ASSETS_SUFFIX . '.js', array(), SUKI_VERSION, true );

		// Hook: Scripts to be included after main JS
		do_action( 'suki/frontend/after_enqueue_main_js', $hook );
	}

	/**
	 * Add 'defer' attribute to some scripts.
	 *
	 * @param string $tag
	 * @param string $handle
	 * @return string
	 */
	public function add_defer_attribute_to_scripts( $tag, $handle ) {
		$scripts_to_defer = apply_filters( 'suki/frontend/defer_scripts', array() );

		foreach ( $scripts_to_defer as $script ) {
			if ( $script === $handle ) {
				return str_replace( ' src', ' defer src', $tag );
			}
		}

		return $tag;
	}

	/**
	 * ====================================================
	 * Public functions
	 * ====================================================
	 */

	/**
	 * Return theme info from style.css file header.
	 *
	 * @param string $key
	 * @return string
	 */
	public function get_info( $key ) {
		if ( isset( $this->_info[ $key ] ) ) {
			return $this->_info[ $key ];
		}

		return false;
	}

	/**
	 * Return array of compatible plugins.
	 *
	 * @return array
	 */
	public function get_compatible_plugins() {
		return array(
			'jetpack' => 'Jetpack',
			'woocommerce' => 'WooCommerce',
			'elementor' => '\Elementor\Plugin',
			'contact-form-7' => 'WPCF7',
		);
	}
}

Suki::instance();