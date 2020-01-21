<?php
/**
 * Suki Admin page basic functions
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Suki_Admin {
	/**
	 * Singleton instance
	 *
	 * @var Suki_Admin
	 */
	private static $instance;

	/**
	 * Parent menu slug of all theme pages
	 *
	 * @var string
	 */
	private $_menu_id = 'suki';

	/**
	 * ====================================================
	 * Singleton & constructor functions
	 * ====================================================
	 */

	/**
	 * Get singleton instance.
	 *
	 * @return Suki_Admin
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
		// General admin hooks on every admin pages
		add_action( 'admin_menu', array( $this, 'register_admin_menu' ), 1 );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_javascripts' ) );

		add_action( 'admin_notices', array( $this, 'add_theme_welcome' ), 999 );

		add_action( 'admin_notices', array( $this, 'add_rating_notice' ) );
		add_action( 'wp_ajax_suki_rating_notice_close', array( $this, 'ajax_dismiss_rating_notice' ) );
		add_action( 'after_switch_theme', array( $this, 'reset_rating_notice_flag' ) );

		add_action( 'wp_ajax_suki_install_sites_import_plugin', array( $this, 'ajax_install_sites_import_plugin' ) );

		// Classic editor hooks
		add_action( 'admin_init', array( $this, 'add_editor_css' ) );
		add_filter( 'tiny_mce_before_init', array( $this, 'add_classic_editor_custom_css' ) );
		add_filter( 'tiny_mce_before_init', array( $this, 'add_classic_editor_body_class' ) );
		add_filter( 'block_editor_settings', array( $this, 'add_gutenberg_custom_css' ) );

		// Suki admin page hooks
		add_action( 'suki/admin/dashboard/header', array( $this, 'render_admin_page__logo' ), 10 );
		add_action( 'suki/admin/dashboard/content', array( $this, 'render_admin_page__modules' ), 10 );
		add_action( 'suki/admin/dashboard/sidebar', array( $this, 'render_sidebar__sites' ), 10 );
		add_action( 'suki/admin/dashboard/sidebar', array( $this, 'render_sidebar__links' ), 20 );
		
		$this->_includes();
	}

	/**
	 * Include additional files.
	 */
	private function _includes() {
		require_once( SUKI_INCLUDES_DIR . '/admin/class-suki-admin-fields.php' );

		// Only include metabox on post add/edit page and term add/edit page.
		global $pagenow;
		if ( in_array( $pagenow, array( 'post.php', 'post-new.php', 'edit-tags.php', 'term.php' ) ) ) {
			require_once( SUKI_INCLUDES_DIR . '/admin/class-suki-admin-metabox-page-settings.php' );
		}
	}

	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

	/**
	 * Add admin submenu page: Appearance > Suki.
	 */
	public function register_admin_menu() {
		add_theme_page(
			suki_get_theme_info( 'name' ),
			suki_get_theme_info( 'name' ),
			'edit_theme_options',
			'suki',
			array( $this, 'render_admin_page' )
		);

		/**
		 * Hook: suki/admin/menu
		 */
		do_action( 'suki/admin/menu' );
	}

	/**
	 * Enqueue admin styles.
	 *
	 * @param string $hook
	 */
	public function enqueue_admin_styles( $hook ) {
		/**
		 * Hook: Styles to be included before admin CSS
		 */
		do_action( 'suki/admin/before_enqueue_admin_css', $hook );

		// Register CSS files
		wp_register_style( 'alpha-color-picker', SUKI_CSS_URL . '/vendors/alpha-color-picker' . SUKI_ASSETS_SUFFIX . '.css', array( 'wp-color-picker' ), SUKI_VERSION );

		// Enqueue CSS files
		wp_enqueue_style( 'suki-admin', SUKI_CSS_URL . '/admin/admin.css', array(), SUKI_VERSION );
		wp_style_add_data( 'suki-admin', 'rtl', 'replace' );

		/**
		 * Hook: Styles to be included after admin CSS
		 */
		do_action( 'suki/admin/after_enqueue_admin_css', $hook );
	}

	/**
	 * Enqueue admin javascripts.
	 *
	 * @param string $hook
	 */
	public function enqueue_admin_javascripts( $hook ) {
		// Fetched version from package.json
		$ver = array();

		/**
		 * Hook: Styles to be included before admin JS
		 */
		do_action( 'suki/admin/before_enqueue_admin_js', $hook );

		// Register JS files
		wp_register_script( 'alpha-color-picker', SUKI_JS_URL . '/vendors/alpha-color-picker' . SUKI_ASSETS_SUFFIX . '.js', array( 'jquery', 'wp-color-picker' ), SUKI_VERSION, true );

		// Enqueue JS files.
		wp_enqueue_script( 'suki-admin', SUKI_JS_URL . '/admin/admin' . SUKI_ASSETS_SUFFIX . '.js', array( 'jquery' ), SUKI_VERSION, true );

		// Send data to main JS file.
		wp_localize_script( 'suki-admin', 'SukiAdminData', array(
			'ajax_nonce'         => wp_create_nonce( 'suki' ),
			'sitesImportPageURL' => esc_url( add_query_arg( array( 'page' => 'suki-sites-import' ), admin_url( 'themes.php' ) ) ),
			'strings'            => array(
				'installing'               => esc_html__( 'Installing...', 'suki' ),
				'error_installing_plugin'  => esc_html__( 'Error occured while installing the plugin', 'suki' ),
				'redirecting_to_demo_list' => esc_html__( 'Redirecting to demo list...', 'suki' ),
			),
		) );

		/**
		 * Hook: Styles to be included after admin JS
		 */
		do_action( 'suki/admin/after_enqueue_admin_js', $hook );
	}

	/**
	 * Add welcome panel on the Appearance > Themes page.
	 */
	public function add_theme_welcome() {
		if ( 'themes' !== get_current_screen()->id ) {
			return;
		}
		?>
		<div class="suki-admin-themes-welcome notice">
			<img src="<?php echo esc_url( SUKI_IMAGES_URL . '/suki-logo.svg' ); ?>" alt="Suki">
			<h2><?php esc_html_e( 'Welcome to Suki!', 'suki' ); ?></h2>
			<p><?php esc_html_e( 'Thank you for installing Suki! Please visit the theme dashboard for more info about Suki features.', 'suki' ); ?></p>
			<p><a href="<?php echo esc_url( add_query_arg( array( 'page' => 'suki' ), admin_url( 'themes.php' ) ) ); ?>" class="button button-hero button-primary"><?php esc_html_e( 'Suki Dashboard', 'suki' ); ?></a></p>
		</div>
		<?php
	}

	/**
	 * Add notice to give rating on WordPress.org.
	 */
	public function add_rating_notice() {
		$time_interval = strtotime( '-7 days' );

		$installed_time = get_option( 'suki_installed_time' );
		if ( ! $installed_time ) {
			$installed_time = time();
			update_option( 'suki_installed_time', $installed_time );
		}

		// Abort if:
		// - Suki is installed less than 7 days.
		// - The notice is already dismissed before.
		// - Current user can't manage options.
		if ( $installed_time > $time_interval || intval( get_option( 'suki_rating_notice_is_dismissed', 0 ) ) || ! current_user_can( 'edit_theme_options' ) ) {
			return;
		}

		?>
		<div class="notice notice-info suki-rating-notice">
			<p><?php esc_html_e( 'Hey, it\'s me David from Suki WordPress theme. I noticed you\'ve been using Suki to build your website - that\'s awesome!', 'suki' ); ?><br><?php esc_html_e( 'Could you do us a BIG favor and give it a 5-star rating on WordPress.org? It would boost our motivation to keep adding new features in the future.', 'suki' ); ?></p>
			<p>
				<a href="https://wordpress.org/support/theme/suki/reviews/?rate=5#new-post" class="button button-primary" target="_blank" rel="noopener"><?php esc_html_e( 'Okay, you deserve it', 'suki' ); ?></a>&nbsp;&nbsp;&nbsp;
				<a href="#" class="suki-rating-notice-close button-link" data-suki-rating-notice-repeat="<?php echo esc_attr( $time_interval ); ?>"><?php esc_html_e( 'Nope, maybe later', 'suki' ); ?></a>&nbsp;&nbsp;&nbsp;
				<a href="#" class="suki-rating-notice-close button-link" data-suki-rating-notice-repeat="-1"><?php esc_html_e( 'I already did', 'suki' ); ?></a>
			</p>
		</div>
		<?php
	}

	/**
	 * Reset theme installed time, for rating notice purpose.
	 */
	public function reset_rating_notice_flag() {
		update_option( 'suki_installed_time', time() );
		update_option( 'suki_rating_notice_is_dismissed', 0 );
	}

	/**
	 * Add CSS for editor page.
	 */
	public function add_editor_css() {
		add_editor_style( SUKI_CSS_URL . '/admin/editor' . SUKI_ASSETS_SUFFIX . '.css' );

		wp_enqueue_style( 'suki-editor-google-fonts', Suki_Customizer::instance()->generate_active_google_fonts_embed_url() );
	}

	/**
	 * Add custom CSS to classic editor.
	 *
	 * @param array $settings
	 * @return array
	 */
	public function add_classic_editor_custom_css( $settings ) {
		// Skip Gutenberg editor page.
		$current_screen = get_current_screen();
		if ( method_exists( $current_screen, 'is_block_editor' ) && $current_screen->is_block_editor() ) {
			return $settings;
		}

		global $post;

		if ( empty( $post ) ) {
			return $settings;
		}

		$css_array = array(
			'global' => array(),
		);

		// TinyMCE HTML
		$css_array['global']['html']['background-color'] = '#fcfcfc';

		// Typography
		$active_google_fonts = array();
		$typography_types = array(
			'body' => 'body',
			'blockquote' => 'blockquote',
			'h1' => 'h1',
			'h2' => 'h2',
			'h3' => 'h3',
			'h4' => 'h4',
		);
		$fonts = suki_get_all_fonts();

		foreach ( $typography_types as $type => $selector ) {
			// Font Family
			$font_family = suki_get_theme_mod( $type . '_font_family' );
			$font_stack = $font_family;
			if ( '' !== $font_family && 'inherit' !== $font_family ) {
				$chunks = explode( '|', $font_family );
				if ( 2 === count( $chunks ) ) {
					$font_stack = suki_array_value( $fonts[ $chunks[0] ], $chunks[1], $chunks[1] );
				}
			}
			if ( ! empty( $font_stack ) ) {
				$css_array['global'][ $selector ]['font-family'] = $font_stack;
			}

			// Font weight
			$font_weight = suki_get_theme_mod( $type . '_font_weight' );
			if ( ! empty( $font_weight ) ) {
				$css_array['global'][ $selector ]['font-weight'] = $font_weight;
			}
			
			// Font style
			$font_style = suki_get_theme_mod( $type . '_font_style' );
			if ( ! empty( $font_style ) ) {
				$css_array['global'][ $selector ]['font-style'] = $font_style;
			}
			
			// Text transform
			$text_transform = suki_get_theme_mod( $type . '_text_transform' );
			if ( ! empty( $text_transform ) ) {
				$css_array['global'][ $selector ]['text-transform'] = $text_transform;
			}

			// Font size
			$font_size = suki_get_theme_mod( $type . '_font_size' );
			if ( ! empty( $font_size ) ) {
				$css_array['global'][ $selector ]['font-size'] = $font_size;
			}

			// Line height
			$line_height = suki_get_theme_mod( $type . '_line_height' );
			if ( ! empty( $line_height ) ) {
				$css_array['global'][ $selector ]['line-height'] = $line_height;
			}

			// Letter spacing
			$letter_spacing = suki_get_theme_mod( $type . '_letter_spacing' );
			if ( ! empty( $letter_spacing ) ) {
				$css_array['global'][ $selector ]['letter-spacing'] = $letter_spacing;
			}
		}

		// Content wrapper width for content layout with sidebar
		// $css_array['global']['body.suki-editor-left-sidebar']['width'] =
		// $css_array['global']['body.suki-editor-right-sidebar']['width'] = 'calc(' . suki_get_content_width_by_layout() . 'px + 2rem)';

		// // Content wrapper width for narrow content layout
		// $css_array['global']['body.suki-editor-narrow']['width'] = 'calc(' . suki_get_content_width_by_layout( 'narrow' ) . 'px + 2rem)';

		// // Content wrapper width for full content layout
		// $css_array['global']['body.suki-editor-wide']['width'] = 'calc(' . suki_get_content_width_by_layout( 'wide' ) . 'px + 2rem)';

		// Build CSS string.
		// $styles = str_replace( '"', '\"', suki_convert_css_array_to_string( $css_array ) );
		$styles = wp_slash( suki_convert_css_array_to_string( $css_array ) );

		// Merge with existing styles or add new styles.
		if ( ! isset( $settings['content_style'] ) ) {
			$settings['content_style'] = $styles . ' ';
		} else {
			$settings['content_style'] .= ' ' . $styles . ' ';
		}

		return $settings;
	}

	/**
	 * Add body class to classic editor.
	 *
	 * @param array $settings
	 * @return array
	 */
	public function add_classic_editor_body_class( $settings ) {
		// Skip Gutenberg editor page.
		$current_screen = get_current_screen();
		if ( method_exists( $current_screen, 'is_block_editor' ) && $current_screen->is_block_editor() ) {
			return $settings;
		}
		
		global $post;

		if ( empty( $post ) ) {
			return $settings;
		}

		$class = 'suki-editor-' . suki_get_page_setting_by_post_id( 'content_layout', $post->ID );

		// Merge with existing classes or add new class.
		if ( ! isset( $settings['body_class'] ) ) {
			$settings['body_class'] = $class . ' ';
		} else {
			$settings['body_class'] .= ' ' . $class . ' ';
		}

		return $settings;
	}

	/**
	 * Add custom CSS to Gutenberg editor.
	 *
	 * @param array $settings
	 * @return array
	 */
	public function add_gutenberg_custom_css( $settings ) {
		$css_array = array();

		// Content width
		$css_array['global']['.wp-block']['max-width'] = 'calc(' . suki_get_theme_mod( 'content_narrow_width' ) . ' + ' . '30px)';
		$css_array['global']['.wp-block[data-align="wide"]']['max-width'] = 'calc(' . suki_get_theme_mod( 'container_width' ) . ' + ' . '30px)';
		$css_array['global']['.wp-block[data-align="full"]']['max-width'] = 'none';

		// Typography
		$active_google_fonts = array();
		$typography_types = array(
			'body' => 'body',
			'blockquote' => 'blockquote',
			'h1' => 'h1, .editor-post-title__block .editor-post-title__input',
			'h2' => 'h2',
			'h3' => 'h3',
			'h4' => 'h4',
			'title' => '.editor-post-title__block .editor-post-title__input',
		);
		$fonts = suki_get_all_fonts();

		foreach ( $typography_types as $type => $selector ) {
			// Font Family
			$font_family = suki_get_theme_mod( $type . '_font_family' );
			$font_stack = $font_family;
			if ( '' !== $font_family && 'inherit' !== $font_family ) {
				$chunks = explode( '|', $font_family );
				if ( 2 === count( $chunks ) ) {
					$font_stack = suki_array_value( $fonts[ $chunks[0] ], $chunks[1], $chunks[1] );
				}
			}
			if ( ! empty( $font_stack ) ) {
				$css_array['global'][ $selector ]['font-family'] = $font_stack;
			}

			// Font weight
			$font_weight = suki_get_theme_mod( $type . '_font_weight' );
			if ( ! empty( $font_weight ) ) {
				$css_array['global'][ $selector ]['font-weight'] = $font_weight;
			}
			
			// Font style
			$font_style = suki_get_theme_mod( $type . '_font_style' );
			if ( ! empty( $font_style ) ) {
				$css_array['global'][ $selector ]['font-style'] = $font_style;
			}
			
			// Text transform
			$text_transform = suki_get_theme_mod( $type . '_text_transform' );
			if ( ! empty( $text_transform ) ) {
				$css_array['global'][ $selector ]['text-transform'] = $text_transform;
			}

			// Font size
			$font_size = suki_get_theme_mod( $type . '_font_size' );
			if ( ! empty( $font_size ) ) {
				$css_array['global'][ $selector ]['font-size'] = $font_size;
			}

			// Line height
			$line_height = suki_get_theme_mod( $type . '_line_height' );
			if ( ! empty( $line_height ) ) {
				$css_array['global'][ $selector ]['line-height'] = $line_height;
			}

			// Letter spacing
			$letter_spacing = suki_get_theme_mod( $type . '_letter_spacing' );
			if ( ! empty( $letter_spacing ) ) {
				$css_array['global'][ $selector ]['letter-spacing'] = $letter_spacing;
			}
		}

		// Relative heading margin top
		$css_array['global']['h1, h2, h3, h4, h5, h6']['margin-top'] = 'calc( 2 * ' . suki_get_theme_mod( 'body_font_size' ) . ') !important';

		// Add to settings array.
		$settings['styles']['suki-custom'] = array(
			'css' => suki_convert_css_array_to_string( $css_array ),
		);

		return $settings;
	}

	/**
	 * ====================================================
	 * AJAX functions
	 * ====================================================
	 */

	/**
	 * AJAX callback to dismiss rating notice.
	 */
	public function ajax_dismiss_rating_notice() {
		$repeat_after = ( isset( $_REQUEST['repeat_after'] ) ) ? intval( $_REQUEST['repeat_after'] ) : false;

		if ( -1 == $repeat_after ) {
			// Dismiss rating notice forever.
			update_option( 'suki_rating_notice_is_dismissed', 1 );
		} else {
			// Repeat rating notice later.
			update_option( 'suki_installed_time', time() );
		}

		wp_send_json_success();
	}

	/**
	 * AJAX callback to install Suki Sites Import plugin.
	 */
	public function ajax_install_sites_import_plugin() {
		check_ajax_referer( 'suki', '_ajax_nonce' );

		if ( ! current_user_can( 'install_plugins' ) ) {
			wp_send_json_error();
		}

		$path = 'suki-sites-import/suki-sites-import.php';

		if ( ! file_exists( WP_PLUGIN_DIR . '/' . $path ) ) {
			if ( ! function_exists( 'plugins_api' ) ) {
				require_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );
			}
			if ( ! class_exists( 'WP_Upgrader' ) ) {
				require_once( ABSPATH . 'wp-admin/includes/class-wp-upgrader.php' );
			}

			$api = plugins_api(
				'plugin_information',
				array(
					'slug' => 'suki-sites-import',
					'fields' => array(
						'short_description' => false,
						'sections' => false,
						'requires' => false,
						'rating' => false,
						'ratings' => false,
						'downloaded' => false,
						'last_updated' => false,
						'added' => false,
						'tags' => false,
						'compatibility' => false,
						'homepage' => false,
						'donate_link' => false,
					),
				)
			);

			// Use AJAX upgrader skin instead of plugin installer skin.
			// ref: function wp_ajax_install_plugin().
			$upgrader = new Plugin_Upgrader( new WP_Ajax_Upgrader_Skin() );

			$install = $upgrader->install( $api->download_link );

			if ( false === $install ) {
				wp_send_json_error();
			}
		}

		if ( ! is_plugin_active( $path ) ) {
			$activate = activate_plugin( $path, '', false, true );

			if ( is_wp_error( $activate ) ) {
				wp_send_json_error();
			}
		}
		
		wp_send_json_success();
	}

	/**
	 * ====================================================
	 * Render functions
	 * ====================================================
	 */

	/**
	 * Render admin page.
	 */
	public function render_admin_page() {
		?>
		<div class="wrap suki-admin-wrap <?php echo esc_attr( suki_is_pro() ? 'suki-pro-installed' : '' ); ?>">
			<div class="suki-admin-header">
				<div class="suki-admin-wrapper wp-clearfix">
					<?php
					/**
					 * Hook: suki/admin/dashboard/header
					 */
					do_action( 'suki/admin/dashboard/header' );
					?>
				</div>
			</div>

			<div class="suki-admin-notices">
				<div class="suki-admin-wrapper">
					<h1 style="display: none;"></h1>

					<?php settings_errors(); ?>
				</div>
			</div>

			<div class="suki-admin-content metabox-holder">
				<div class="suki-admin-wrapper">
					<div class="suki-admin-content-row">
						<div class="suki-admin-primary">
							<?php
							/**
							 * Hook: suki/admin/dashboard/content
							 */
							do_action( 'suki/admin/dashboard/content' );
							?>
						</div>

						<?php if ( has_action( 'suki/admin/dashboard/sidebar' ) ) : ?>
							<div class="suki-admin-secondary">
								<?php
								/**
								 * Hook: suki/admin/dashboard/sidebar
								 */
								do_action( 'suki/admin/dashboard/sidebar' );
								?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Render logo on Suki admin page.
	 */
	public function render_admin_page__logo() {
		?>
		<div class="suki-admin-logo">
			<?php echo apply_filters( 'suki/admin/dashboard/logo', '<img src="' . esc_url( SUKI_IMAGES_URL . '/suki-logo.svg' ) . '" alt="' . esc_attr( get_admin_page_title() ) . '">' ); // WPCS: XSS OK ?>
			<span class="suki-admin-version"><?php echo suki_get_theme_info( 'version' ); // WPCS: XSS OK ?></span>
		</div>
		<?php
	}

	/**
	 * Render modules manager on Suki admin page.
	 */
	public function render_admin_page__modules() {
		$all_modules = array();
		$module_categories = suki_get_module_categories();

		// Fetch free modules.
		foreach ( suki_get_theme_modules() as $module_slug => $module_data ) {
			$data = wp_parse_args( $module_data, array(
				'label'    => '',
				'url'      => '',
				'category' => '',
				'actions'  => array(),
				'hide'     => false,
				'pro'      => false,
				'active'   => true,
			) );

			// Always flag all free modules as FREE.
			$data['pro'] = false;

			// Always make sure all free modules are active.
			$data['active'] = true;

			// Add action.
			$data['actions']['enabled'] = array(
				'label' => '✓',
			);

			// Add to collection.
			if ( ! empty( $data['category'] ) ) {
				$all_modules[ $data['category'] ][ $module_slug ] = $data;
			}
		}

		// Fetch pro modules.
		foreach ( suki_get_pro_modules() as $module_slug => $module_data ) {
			$data = wp_parse_args( $module_data, array(
				'label'    => '',
				'url'      => '',
				'category' => '',
				'actions'  => array(),
				'hide'     => false,
				'pro'      => true,
				'active'   => false,
			) );

			// Always flag all free modules as PRO.
			$data['pro'] = true;

			// Add to collection.
			if ( ! empty( $data['category'] ) ) {
				$all_modules[ $data['category'] ][ $module_slug ] = $data;
			}
		}

		?>
		<div class="suki-admin-modules postbox" action="" method="POST">
			<h2 class="hndle">
				<?php echo wp_kses_post( apply_filters( 'suki/pro/modules/list_heading', esc_html__( 'Modules Manager', 'suki' ) ) ); ?>
			</h2>
			<div class="inside">
				<?php foreach ( $all_modules as $category_slug => $category_modules ) : ?>
					<?php
					// Skip if specified category doesn't exists.
					if ( ! isset( $module_categories[ $category_slug ] ) ) {
						continue;
					}
					?>
					<h3 class="suki-admin-modules-category <?php echo esc_attr( 'suki-admin-modules-category--' . $category_slug ); ?>"><?php echo esc_html( $module_categories[ $category_slug ] ); ?></h3>
					<ul class="suki-admin-modules-grid">
						<?php foreach ( $category_modules as $module_slug => $module_data ) : ?>
							<?php
							// Skip if module is in "hide" mode.
							if ( intval( $module_data['hide'] ) ) {
								continue;
							}

							// Add note all pro modules "Available on Suki Pro".
							if ( $module_data['pro'] && ! suki_is_pro() ) {
								$module_data['actions'] = array(
									'available-on-suki-pro' => array(
										'label' => esc_html__( 'Available on Suki Pro', 'suki' ),
									),
								);

								$module_data['active'] = false;
							}

							// Check WooCommerce modules.
							if ( 'woocommerce' === $category_slug && ! class_exists( 'WooCommerce' ) ) {
								$module_data['actions'] = array(
									'woocommerce-not-found' => array(
										'label' => esc_html__( 'WooCommerce is not installed', 'suki' ),
									),
								);

								$module_data['active'] = false;
							}
							?>
							<li id="<?php echo esc_attr( 'suki-admin-module--' . $module_slug ); ?>" class="suki-admin-module <?php echo esc_attr( ( $module_data['pro'] ? 'pro' : 'free' ) . ' ' . ( $module_data['active'] ? 'active' : 'inactive' ) ); ?>">
								<h4 class="suki-admin-module-name">
									<?php if ( ! empty( $module_data['url'] ) ) : ?>
										<a href="<?php echo esc_html( $module_data['url'] ); ?>" target="_blank" rel="noopener">
											<span><?php echo esc_html( $module_data['label'] ); ?></span>
										</a>
									<?php else : ?>
										<span><?php echo esc_html( $module_data['label'] ); ?></span>
									<?php endif; ?>

									<?php if ( $module_data['pro'] ) : ?>
										<span class="suki-admin-module-badge-pro"><?php esc_html_e( 'Pro', 'suki' ); ?></span>
									<?php endif; ?>
								</h4>

								<div class="suki-admin-module-actions row-actions">
									<?php foreach( $module_data['actions'] as $action_key => $action_data ) : ?>
										<span class="<?php echo esc_attr( 'suki-admin-module-action--' . $action_key ); ?>">
											<?php if ( isset( $action_data['url'] ) ) : ?>
												<a href="<?php echo esc_url( $action_data['url'] ); ?>"><?php echo esc_html( $action_data['label'] ); ?></a>
											<?php else : ?>
												<span><?php echo esc_html( $action_data['label'] ); ?></span>
											<?php endif; ?>
										</span>
									<?php endforeach; ?>
								</div>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endforeach; ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Render links box on Suki admin page's sidebar.
	 */
	public function render_sidebar__links() {
		$menus = apply_filters( 'suki/admin/dashboard/menu', array(
			array(
				'label'  => esc_html__( 'Suki Website', 'suki' ),
				'url'    => 'https://sukiwp.com/',
				'icon'   => 'dashicons-admin-home',
				'newtab' => true,
			),
			array(
				'label'  => esc_html__( 'Documentation', 'suki' ),
				'url'    => 'https://docs.sukiwp.com/',
				'icon'   => 'dashicons-book-alt',
				'newtab' => true,
			),
			array(
				'label'  => esc_html__( 'Users Community Group', 'suki' ),
				'url'    => 'https://www.facebook.com/groups/sukiwp/',
				'icon'   => 'dashicons-groups',
				'newtab' => true,
			),
			array(
				'label'  => esc_html__( 'Follow Us on Facebook', 'suki' ),
				'url'    => 'https://www.facebook.com/sukiwp/',
				'icon'   => 'dashicons-facebook',
				'newtab' => true,
			),
			array(
				'label'  => esc_html__( 'Rate Us &#9733;&#9733;&#9733;&#9733;&#9733;', 'suki' ),
				'url'    => 'https://wordpress.org/support/theme/suki/reviews/?rate=5#new-post',
				'icon'   => 'dashicons-star-filled',
				'newtab' => true,
			),
		) );
		?>
		<div class="suki-admin-other-links postbox">
			<h2 class="hndle"><?php esc_html_e( 'Other Links', 'suki' ); ?></h2>
			<div class="inside">
				<ul class="suki-admin-links-list">
					<?php foreach ( $menus as $menu ) : ?>
						<li><span class="dashicons <?php echo esc_attr( $menu['icon'] ); ?>"></span><a href="<?php echo esc_url( $menu['url'] ); ?>" <?php echo $menu['newtab'] ? ' target="_blank" rel="noopener"' : ''; // WPCS: XSS OK ?>><?php echo esc_html( $menu['label'] ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
		<?php
	}

	/**
	 * Render "One Click Demo Import" info box on Suki admin page's sidebar.
	 */
	public function render_sidebar__sites() {
		if ( ! current_user_can( 'install_plugins' ) ) {
			return;
		}
		?>
		<div class="suki-admin-demo-sites postbox">
			<h2 class="hndle"><?php esc_html_e( 'One Click Demo Import', 'suki' ); ?></h2>
			<div class="inside">
				<p class="suki-admin-demo-sites-image"><img src="<?php echo esc_url( SUKI_IMAGES_URL . '/suki-sites-import-banner.png' ); ?>" width="300" height="150"></p>
				<p><?php esc_html_e( 'Kickstart your website with our pre-made demo websites in 3 steps: Import. Modify. Launch!', 'suki' ); ?></p>
				<p>
					<?php if ( is_plugin_active( 'suki-sites-import/suki-sites-import.php' ) ) : ?>
						<a href="<?php echo esc_url( add_query_arg( array( 'page' => 'suki-sites-import' ), admin_url( 'themes.php' ) ) ); ?>" class="button button-large button-secondary"><?php esc_html_e( 'Browse Demo Sites', 'suki' ); ?></a>
					<?php else : ?>
						<button class="suki-admin-install-sites-import-plugin-button button button-large button-secondary"><?php esc_html_e( 'Install & Activate Plugin', 'suki' ); ?></button>
					<?php endif; ?>
				</p>
			</div>
		</div>
		<?php
	}
}

Suki_Admin::instance();