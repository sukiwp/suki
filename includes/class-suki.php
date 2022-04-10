<?php
/**
 * Suki theme class.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main class of the theme.
 */
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
	private $info;

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
	final public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Class constructor.
	 */
	private function __construct() {
		/**
		 * Hooks
		 */

		// Set Content width.
		add_action( 'after_setup_theme', array( $this, 'set_content_width' ), 0 );

		// Load translations.
		add_action( 'after_setup_theme', array( $this, 'load_translations' ) );

		// Set Theme supports.
		add_action( 'after_setup_theme', array( $this, 'set_theme_supports' ) );

		// Register menus.
		add_action( 'after_setup_theme', array( $this, 'register_menus' ) );

		// Register sidebars and widgets.
		add_action( 'widgets_init', array( $this, 'register_sidebars' ) );

		// Set theme info.
		// Priority has to be set to 0 because "widgets_init" action is actually an "init" action with priority set to 1.
		add_action( 'init', array( $this, 'setup_theme_info' ), 0 );

		// Declare 'wp_enqueue_scripts' action on 'init' hook to make sure all plugins' scripts has been enqueued before theme scripts.
		// For example, Elementor declares their 'wp_enqueue_scripts' actions late, on 'init' hook.
		add_action( 'init', array( $this, 'handle_frontend_scripts' ) );

		// If enabled from Child Theme, this will make Child Theme inherit Parent Theme configuration.
		if ( get_stylesheet() !== get_template() && defined( 'SUKI_CHILD_USE_PARENT_MODS' ) && SUKI_CHILD_USE_PARENT_MODS ) {
			add_filter( 'pre_update_option_theme_mods_' . get_stylesheet(), array( $this, 'child_use_parent_mods__set' ), 10, 2 );
			add_filter( 'pre_option_theme_mods_' . get_stylesheet(), array( $this, 'child_use_parent_mods__get' ) );
		}

		/**
		 * Include more files.
		 */

		// Helper functions.
		require_once SUKI_INCLUDES_DIR . '/helpers.php';

		// Template functions and hooks.
		require_once SUKI_INCLUDES_DIR . '/template-tags.php';
		require_once SUKI_INCLUDES_DIR . '/template-actions.php';
		require_once SUKI_INCLUDES_DIR . '/template-filters.php';

		// Version checking and migrations.
		require_once SUKI_INCLUDES_DIR . '/migrations/class-suki-migration.php';

		// Customizer functionalities.
		require_once SUKI_INCLUDES_DIR . '/customizer/class-suki-customizer.php';

		// Load modules.
		require_once SUKI_INCLUDES_DIR . '/modules/class-suki-module.php';

		$active_modules = array(
			'breadcrumb',
			'google-fonts',
			'page-settings',
		);
		foreach ( $active_modules as $active_module ) {
			require_once SUKI_INCLUDES_DIR . '/modules/' . $active_module . '/class-suki-' . $active_module . '.php';
		}

		// Load plugin compatibilities.
		foreach ( $this->get_compatible_plugins() as $plugin_slug => $plugin_class ) {
			// Only include plugin's compatibility class if the plugin is active.
			if ( class_exists( $plugin_class ) ) {
				$compatibility_file = SUKI_INCLUDES_DIR . '/compatibilities/' . $plugin_slug . '/class-suki-compatibility-' . $plugin_slug . '.php';

				if ( file_exists( $compatibility_file ) ) {
					require_once $compatibility_file;
				}
			}
		}

		// Admin page functionalities.
		if ( is_admin() ) {
			require_once SUKI_INCLUDES_DIR . '/admin/class-suki-admin.php';
		}

		// Deprecated.
		require_once SUKI_INCLUDES_DIR . '/deprecated.php';
	}

	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

	/**
	 * Set the content width in pixels, based on the theme's design and stylesheet.
	 *
	 * Priority 0 to make it available to lower priority callbacks.
	 *
	 * @global integer $content_width
	 */
	public function set_content_width() {
		$GLOBALS['content_width'] = apply_filters( '_s_content_width', 640 );
	}

	/**
	 * Load translations for theme's text domain.
	 */
	public function load_translations() {
		load_theme_textdomain( 'suki', get_template_directory() . '/languages' );
	}

	/**
	 * Set theme supports.
	 */
	public function set_theme_supports() {
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Enable support for document <title> tag generated by WordPress itself.
		add_theme_support( 'title-tag' );

		// Enable support for Post thumbnails on posts and pages.
		add_theme_support( 'post-thumbnails' );

		// Use HTML5 tags for search form, comment form, and comments.
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Enable custom logo.
		add_theme_support(
			'custom-logo',
			array(
				'flex-height' => true,
				'flex-width'  => true,
			)
		);

		// Selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );
	}

	/**
	 * Setup theme info.
	 */
	public function setup_theme_info() {
		// Extract theme data from style.css.
		$info = get_file_data(
			get_template_directory() . '/style.css',
			array(
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
			)
		);

		// Add screenshot to theme data.
		$info['screenshot'] = esc_url( get_template_directory_uri() . '/screenshot.png' );

		// Save to class $info property.
		$this->info = apply_filters( 'suki/theme_info', $info );
	}

	/**
	 * Register theme sidebars (widget area).
	 */
	public function register_sidebars() {
		// Content sidebar.
		register_sidebar(
			array(
				'name'          => esc_html__( 'Sidebar', 'suki' ),
				'id'            => 'sidebar',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<' . suki_get_theme_mod( 'sidebar_widget_title_tag', 'h2' ) . ' class="widget-title">',
				'after_title'   => '</' . suki_get_theme_mod( 'sidebar_widget_title_tag', 'h2' ) . '>',
			)
		);

		// Footer widget area.
		for ( $i = 1; $i <= 6; $i++ ) {
			register_sidebar(
				array(
					/* translators: %s: footer widgets column number. */
					'name'          => sprintf( esc_html__( 'Footer Widgets Column %s', 'suki' ), $i ),
					'id'            => 'footer-widgets-' . $i,
					'before_widget' => '<div id="%1$s" class="widget %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<' . suki_get_theme_mod( 'footer_widgets_bar_widget_title_tag', 'h2' ) . ' class="widget-title">',
					'after_title'   => '</' . suki_get_theme_mod( 'footer_widgets_bar_widget_title_tag', 'h2' ) . '>',
				)
			);
		}
	}

	/**
	 * Register menus.
	 */
	public function register_menus() {
		register_nav_menus(
			array(
				/* translators: %s: number of Header Menu. */
				'header-menu-1'      => sprintf( esc_html__( 'Header Menu %s', 'suki' ), 1 ),
				'header-mobile-menu' => esc_html__( 'Mobile Header Menu', 'suki' ),
				'footer-menu-1'      => esc_html__( 'Footer Bottom Menu', 'suki' ),
			)
		);
	}

	/**
	 * Enqueue frontend scripts.
	 *
	 * @param string $hook Hook name.
	 */
	public function handle_frontend_scripts( $hook ) {
		add_filter( 'script_loader_tag', array( $this, 'add_defer_attribute_to_scripts' ), 10, 2 );

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_javascripts' ) );

		add_filter( 'suki/frontend/dynamic_css', array( $this, 'add_dynamic_css' ) );
		add_filter( 'suki/frontend/dynamic_css', array( $this, 'add_page_settings_css' ), 25 );
	}

	/**
	 * Enqueue frontend styles.
	 *
	 * @param string $hook Hook name.
	 */
	public function enqueue_frontend_styles( $hook ) {
		/**
		 * Remove the default block CSS from WordPress
		 */
		wp_dequeue_style( 'wp-block-library' );

		/**
		 * Hook: Enqueue others before main CSS
		 */
		do_action( 'suki/frontend/before_enqueue_main_css', $hook );

		/**
		 * Main CSS
		 */
		wp_enqueue_style( 'suki', SUKI_CSS_URL . '/main' . SUKI_ASSETS_SUFFIX . '.css', array(), SUKI_VERSION );
		wp_style_add_data( 'suki', 'rtl', 'replace' );
		wp_style_add_data( 'suki', 'suffix', SUKI_ASSETS_SUFFIX );

		/**
		 * Inline CSS
		 */
		wp_add_inline_style( 'suki', trim( apply_filters( 'suki/frontend/dynamic_css', '' ) ) );

		/**
		 * Hook: Enqueue others after main CSS
		 */
		do_action( 'suki/frontend/after_enqueue_main_css', $hook );
	}

	/**
	 * Enqueue frontend javascripts.
	 *
	 * @param string $hook Hook name.
	 */
	public function enqueue_frontend_javascripts( $hook ) {
		// Fetched version from package.json.
		$ver = array();

		// Comment reply (WordPress).
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		/**
		 * Hook: Scripts to be included before main JS
		 */
		do_action( 'suki/frontend/before_enqueue_main_js', $hook );

		// Main JS.
		wp_enqueue_script( 'suki', SUKI_JS_URL . '/main' . SUKI_ASSETS_SUFFIX . '.js', array(), SUKI_VERSION, true );

		// Localize script.
		wp_localize_script(
			'suki',
			'sukiConfig',
			apply_filters(
				'suki/frontend/localize_script',
				array(
					'breakpoints' => array(
						'mobile'  => 500,
						'tablet'  => 768,
						'desktop' => 1024,
					),
				)
			)
		);

		/**
		 * Hook: Scripts to be included after main JS
		 */
		do_action( 'suki/frontend/after_enqueue_main_js', $hook );
	}

	/**
	 * Add 'defer' attribute to some scripts.
	 *
	 * @param string $tag    Script tag.
	 * @param string $handle Script handle.
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
	 * Add dynamic CSS from customizer settings into the inline CSS.
	 *
	 * @param string $css CSS string.
	 * @return string
	 */
	public function add_dynamic_css( $css ) {
		// Skip adding dynamic CSS on customizer preview frame.
		if ( is_customize_preview() ) {
			return $css;
		}

		$outputs  = include SUKI_INCLUDES_DIR . '/customizer/outputs.php';
		$defaults = include SUKI_INCLUDES_DIR . '/customizer/defaults.php';

		$generated_css = Suki_Customizer::instance()->convert_outputs_to_css_string( $outputs, $defaults );

		if ( ! empty( $generated_css ) ) {
			$css .= "\n/* Suki Dynamic CSS */\n" . $generated_css;
		}

		return $css;
	}

	/**
	 * Add current page settings CSS into the inline CSS.
	 *
	 * @param string $css CSS string.
	 * @return string
	 */
	public function add_page_settings_css( $css ) {
		$css_array = array();

		/**
		 * Hero background image
		 */

		$hero_bg_image = '';

		// Get current page's hero background mode.
		$hero_bg = suki_get_current_page_setting( 'hero_bg' );

		switch ( $hero_bg ) {
			case 'thumbnail':
				// If post has thumbnail, use the thumbnail.
				if ( has_post_thumbnail() ) {
					$hero_bg_image = get_the_post_thumbnail_url( get_the_ID(), 'full' );
				}

				// If featured image is not set, fallback to global background image.
				if ( empty( $hero_bg_image ) ) {
					$hero_bg_image = suki_get_theme_mod( 'hero_bg_image' );
				}
				break;

			case 'archive':
				// Try to get the archive page's hero custom background image.
				if ( 'custom' === suki_get_theme_mod( get_post_type() . '_archive_hero_bg' ) ) {
					$hero_bg_image = suki_get_theme_mod( get_post_type() . '_archive_hero_bg_image' );
				}

				// If archive page's hero background custom background image is not set, fallback to global background image.
				if ( empty( $hero_bg_image ) ) {
					$hero_bg_image = suki_get_theme_mod( 'hero_bg_image' );
				}
				break;

			case 'custom':
				// Use custom background image.
				$hero_bg_image = suki_get_current_page_setting( 'hero_bg_image' );
				break;

			default:
				// Use global background image.
				$hero_bg_image = suki_get_theme_mod( 'hero_bg_image' );
				break;
		}

		if ( '' !== $hero_bg_image ) {
			$css_array['global']['.suki-hero-inner']['background-image'] = 'url(' . $hero_bg_image . ')';
		}

		/**
		 * Build the final CSS.
		 */

		$page_settings_css = suki_convert_css_array_to_string( $css_array );

		if ( '' !== trim( $page_settings_css ) ) {
			$css .= "\n/* Current Page Layout CSS */\n" . $page_settings_css; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		return $css;
	}

	/**
	 * Intercept saving mods on Child Theme and save it to Parent Theme instead.
	 *
	 * @param array $value     Value.
	 * @param array $old_value Old value.
	 * @return array
	 */
	public function child_use_parent_mods__set( $value, $old_value ) {
		// Update parent theme mods.
		update_option( 'theme_mods_' . get_template(), $value );

		// Prevent update to child theme mods.
		return $old_value;
	}

	/**
	 * Intercept retrieving mods on Child Theme and return Parent Theme's mods instead.
	 *
	 * @param array $default Default value.
	 * @return array
	 */
	public function child_use_parent_mods__get( $default ) {
		// Return parent theme mods.
		return get_option( 'theme_mods_' . get_template(), $default );
	}

	/**
	 * ====================================================
	 * Public functions
	 * ====================================================
	 */

	/**
	 * Return theme info from style.css file header.
	 *
	 * @param string $key Key of requested theme info.
	 * @return string
	 */
	public function get_info( $key ) {
		if ( isset( $this->info[ $key ] ) ) {
			return $this->info[ $key ];
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
			'suki-pro'       => 'Suki_Pro',
			'contact-form-7' => 'WPCF7',
			'elementor'      => '\Elementor\Plugin',
			'elementor-pro'  => '\ElementorPro\Plugin',
			'brizy'          => 'Brizy_Editor',
			'jetpack'        => 'Jetpack',
			'woocommerce'    => 'WooCommerce',
		);
	}
}

Suki::instance();
