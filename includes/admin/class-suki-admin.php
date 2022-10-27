<?php
/**
 * Suki Admin page basic functions
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Admin class.
 */
class Suki_Admin {
	/**
	 * Singleton instance
	 *
	 * @var Suki_Admin
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
		/**
		 * Actions and filters
		 */

		// Add admin menu, CSS, and JS.
		add_action( 'admin_menu', array( $this, 'register_admin_menu' ), 1 );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_javascripts' ) );

		// Editor styles.
		add_action( 'admin_init', array( $this, 'enqueue_editor_css' ) );
		add_filter( 'block_editor_settings_all', array( $this, 'add_block_editor_dynamic_css__visual' ), 10, 2 );
		add_filter( 'tiny_mce_before_init', array( $this, 'add_classic_editor_dynamic_css' ) );
		add_action( 'enqueue_block_editor_assets', array( $this, 'add_block_editor_dynamic_css__controls' ), 20 );

		// Rating and review notification.
		add_action( 'admin_notices', array( $this, 'add_rating_notice' ) );
		add_action( 'wp_ajax_suki_rating_notice_close', array( $this, 'ajax_dismiss_rating_notice' ) );
		add_action( 'after_switch_theme', array( $this, 'reset_rating_notice_flag' ) );

		/**
		 * Include more files.
		 */

		require_once SUKI_INCLUDES_DIR . '/admin/class-suki-admin-fields.php';
	}

	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

	/**
	 * Add admin submenu page: Appearance > Suki.
	 *
	 * More additional menus related to Suki theme could be added using the `suki/admin/menu` hook.
	 */
	public function register_admin_menu() {
		// Add theme dashboard page.
		add_theme_page(
			suki_get_theme_info( 'name' ),
			suki_get_theme_info( 'name' ),
			'edit_theme_options',
			'suki',
			array( $this, 'render_theme_dashboard' )
		);

		/**
		 * Hook: suki/admin/menu
		 */
		do_action( 'suki/admin/menu' );
	}

	/**
	 * Enqueue admin styles.
	 *
	 * @param string $hook Hook name.
	 */
	public function enqueue_admin_styles( $hook ) {
		/**
		 * Hook: Styles to be included before admin CSS
		 */
		do_action( 'suki/admin/before_enqueue_admin_css', $hook );

		// Enqueue CSS files.
		wp_enqueue_style( 'suki-admin', SUKI_CSS_URL . '/admin' . SUKI_ASSETS_SUFFIX . '.css', array(), SUKI_VERSION );
		wp_style_add_data( 'suki-admin', 'rtl', 'replace' );
		wp_style_add_data( 'suki-admin', 'suffix', SUKI_ASSETS_SUFFIX );

		/**
		 * Hook: Styles to be included after admin CSS
		 */
		do_action( 'suki/admin/after_enqueue_admin_css', $hook );
	}

	/**
	 * Enqueue admin javascripts.
	 *
	 * @param string $hook Hook name.
	 */
	public function enqueue_admin_javascripts( $hook ) {
		/**
		 * Hook: Styles to be included before admin JS
		 */
		do_action( 'suki/admin/before_enqueue_admin_js', $hook );

		// Enqueue JS files.
		wp_enqueue_script( 'suki-admin', SUKI_JS_URL . '/admin' . SUKI_ASSETS_SUFFIX . '.js', array( 'jquery' ), SUKI_VERSION, true );

		// Send data to main JS file.
		wp_localize_script(
			'suki-admin',
			'sukiAdminData',
			array(
				'ajax_nonce'         => wp_create_nonce( 'suki' ),
				'sitesImportPageURL' => esc_url( add_query_arg( array( 'page' => 'suki-sites-import' ), admin_url( 'themes.php' ) ) ),
				'strings'            => array(
					'installing'               => esc_html__( 'Installing...', 'suki' ),
					'error_installing_plugin'  => esc_html__( 'Error occured while installing the plugin', 'suki' ),
					'redirecting_to_demo_list' => esc_html__( 'Redirecting to demo list...', 'suki' ),
				),
			)
		);

		/**
		 * Hook: Styles to be included after admin JS
		 */
		do_action( 'suki/admin/after_enqueue_admin_js', $hook );
	}

	/**
	 * Add CSS for editor page.
	 */
	public function enqueue_editor_css() {
		add_editor_style( 'assets/css/editor' . SUKI_ASSETS_SUFFIX . '.css' );
	}

	/**
	 * Add dynamic CSS to Gutenberg visual editor.
	 *
	 * @param array                   $editor_settings      Editor's settings array.
	 * @param WP_Block_Editor_Context $block_editor_context Block editor context.
	 */
	public function add_block_editor_dynamic_css__visual( $editor_settings, $block_editor_context ) {
		$dynamic_css = trim( apply_filters( 'suki/frontend/dynamic_css', '' ) );

		$editor_settings['styles'][] = array(
			'css'            => $dynamic_css,
			'__unstableType' => 'theme',
		);

		return $editor_settings;
	}

	/**
	 * Add dynamic CSS to Gutenberg controls (outside .editor-styles-wrapper).
	 */
	public function add_block_editor_dynamic_css__controls() {
		// Abort if current admin page is not Gutenberg.
		if ( ! get_current_screen()->is_block_editor() ) {
			return;
		}

		$css_array = array();

		// Add color palette CSS.
		for ( $i = 1; $i <= 8; $i++ ) {
			$css_array['global']['.block-editor'][ '--color-palette-' . $i ] = suki_get_theme_mod( 'color_palette_' . $i );
		}

		// Add sidebar CSS.
		$css_array['global']['.editor-styles-wrapper']['--sidebar-width']       = suki_get_theme_mod( 'sidebar_width', '25%' );
		$css_array['global']['.editor-styles-wrapper']['--sidebar-gap']         = suki_get_theme_mod( 'sidebar_gap', 'calc( 3 * var(--wp--style--block-gap) )' );
		$css_array['global']['.editor-styles-wrapper']['--sidebar-widgets-gap'] = suki_get_theme_mod( 'sidebar_widgets_gap', 'calc( 1.5 * var(--wp--style--block-gap) )' );

		// Inject inline CSS after the admin.css.
		wp_register_style( 'suki-block-editor', false, array(), SUKI_VERSION );
		wp_add_inline_style(
			'suki-block-editor',
			suki_convert_css_array_to_string( $css_array )
		);
		wp_enqueue_style( 'suki-block-editor' );
	}

	/**
	 * Add dynamic CSS to Classic Editor.
	 *
	 * @param array $editor_settings Editor's settings array.
	 */
	public function add_classic_editor_dynamic_css( $editor_settings ) {
		$dynamic_css = trim( apply_filters( 'suki/frontend/dynamic_css', '' ) );

		// Remove comment and whitespace.
		$dynamic_css = preg_replace( '/\/\*.*?\*\//', '', $dynamic_css );
		$dynamic_css = preg_replace( '/[\t\n\r]/', '', $dynamic_css );

		// Merge with existing styles or add new styles.
		if ( ! isset( $editor_settings['content_style'] ) ) {
			$editor_settings['content_style'] = $dynamic_css . ' ';
		} else {
			$editor_settings['content_style'] .= ' ' . $dynamic_css . ' ';
		}

		return $editor_settings;
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
	 * ====================================================
	 * AJAX functions
	 * ====================================================
	 */

	/**
	 * AJAX callback to dismiss rating notice.
	 */
	public function ajax_dismiss_rating_notice() {
		check_ajax_referer( 'suki', '_ajax_nonce' );

		$repeat_after = ( isset( $_REQUEST['repeat_after'] ) ) ? intval( $_REQUEST['repeat_after'] ) : false;

		if ( -1 === $repeat_after ) {
			// Dismiss rating notice forever.
			update_option( 'suki_rating_notice_is_dismissed', 1 );
		} else {
			// Repeat rating notice later.
			update_option( 'suki_installed_time', time() );
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
	public function render_theme_dashboard() {
		// Include admin dashboard page.
		require_once SUKI_INCLUDES_DIR . '/admin/class-suki-admin-dashboard.php';

		Suki_Admin_Dashboard::instance()->render();
	}

	/**
	 * Render logo on Suki admin page.
	 */
	public function render_admin_page__logo() {
		?>
		<div class="suki-admin-logo">
			<?php echo apply_filters( 'suki/admin/dashboard/logo', '<img src="' . esc_url( SUKI_IMAGES_URL . '/suki-logo.svg' ) . '" alt="' . esc_attr( get_admin_page_title() ) . '">' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<span class="suki-admin-version"><?php echo suki_get_theme_info( 'version' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
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
			$data = wp_parse_args(
				$module_data,
				array(
					'label'    => '',
					'url'      => '',
					'category' => '',
					'actions'  => array(),
					'hide'     => false,
					'pro'      => false,
					'active'   => true,
				)
			);

			// Always flag all free modules as FREE.
			$data['pro'] = false;

			// Always make sure all free modules are active.
			$data['active'] = true;

			// Add action.
			$data['actions']['enabled'] = array(
				'label' => esc_html__( 'Core Module', 'suki' ),
			);

			// Add to collection.
			if ( ! empty( $data['category'] ) ) {
				$all_modules[ $data['category'] ][ $module_slug ] = $data;
			}
		}

		// Fetch pro modules.
		foreach ( suki_get_pro_modules() as $module_slug => $module_data ) {
			$data = wp_parse_args(
				$module_data,
				array(
					'label'    => '',
					'url'      => '',
					'category' => '',
					'actions'  => array(),
					'hide'     => false,
					'pro'      => true,
					'active'   => false,
				)
			);

			// Always flag all free modules as PRO.
			$data['pro'] = true;

			// Add to collection.
			if ( ! empty( $data['category'] ) ) {
				$all_modules[ $data['category'] ][ $module_slug ] = $data;
			}
		}

		?>
		<div class="suki-admin-modules postbox">
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
							if ( boolval( $module_data['hide'] ) ) {
								continue;
							}

							// Add note all pro modules "Available on Suki Pro".
							if ( $module_data['pro'] && ! suki_is_pro() ) {
								$module_data['actions'] = array(
									'disabled' => array(
										'label' => esc_html__( 'Available on Suki Pro', 'suki' ),
									),
								);

								$module_data['active'] = false;
							}

							// Check WooCommerce modules.
							if ( 'woocommerce' === $category_slug && ! class_exists( 'WooCommerce' ) ) {
								$module_data['actions'] = array(
									'disabled' => array(
										'label' => esc_html__( 'WooCommerce is not installed', 'suki' ),
									),
								);

								$module_data['active'] = false;
							}
							?>
							<li id="<?php echo esc_attr( 'suki-admin-module--' . $module_slug ); ?>" class="suki-admin-module <?php echo esc_attr( ( $module_data['pro'] ? 'pro' : 'free' ) . ' ' . ( $module_data['active'] ? 'active' : 'inactive' ) ); ?>">
								<h4 class="suki-admin-module-name">
									<span><?php echo esc_html( $module_data['label'] ); ?></span>
								</h4>

								<div class="suki-admin-module-actions">
									<?php foreach ( $module_data['actions'] as $action_key => $action_data ) : ?>
										<?php if ( isset( $action_data['url'] ) ) : ?>
											<a href="<?php echo esc_url( $action_data['url'] ); ?>" class="<?php echo esc_attr( 'suki-admin-module-action--' . $action_key ); ?>">
												<span><?php echo esc_html( $action_data['label'] ); ?></span>
											</a>
										<?php else : ?>
											<span  class="<?php echo esc_attr( 'suki-admin-module-action--' . $action_key ); ?>">
												<span><?php echo esc_html( $action_data['label'] ); ?></span>
											</span>
										<?php endif; ?>
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
		$menus = apply_filters(
			'suki/admin/dashboard/menu',
			array(
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
					'label'  => esc_html__( 'Translation', 'suki' ),
					'url'    => 'https://translate.sukiwp.com/',
					'icon'   => 'dashicons-admin-site-alt2',
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
			)
		);
		?>
		<div class="suki-admin-other-links postbox">
			<h2 class="hndle"><?php esc_html_e( 'Other Links', 'suki' ); ?></h2>
			<div class="inside">
				<ul class="suki-admin-links-list">
					<?php foreach ( $menus as $menu ) : ?>
						<li><span class="dashicons <?php echo esc_attr( $menu['icon'] ); ?>"></span><a href="<?php echo esc_url( $menu['url'] ); ?>" <?php echo $menu['newtab'] ? ' target="_blank" rel="noopener"' : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $menu['label'] ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
		<?php
	}

	/**
	 * Render "Suki Pro" info box on Suki admin page's sidebar.
	 */
	public function render_sidebar__suki_pro() {
		if ( ! current_user_can( 'install_plugins' ) ) {
			return;
		}
		?>
		<div class="suki-admin-demo-pro postbox">
			<h2 class="hndle"><?php esc_html_e( 'Suki Pro', 'suki' ); ?></h2>
			<div class="inside">
				<p class="suki-admin-demo-sites-image"><img src="<?php echo esc_url( SUKI_IMAGES_URL . '/suki-pro-banner.png' ); ?>" width="300" height="150"></p>
				<p><?php esc_html_e( 'Get more powerful features and take your website to the next level with Suki Pro.', 'suki' ); ?></p>
				<p>
					<?php
					$url_args = array(
						'utm_source'   => 'suki-dashboard',
						'utm_medium'   => 'learn-more',
						'utm_campaign' => 'theme-pro-modules-list',
					);
					?>
					<a href="<?php echo esc_url( add_query_arg( $url_args, trailingslashit( SUKI_PRO_WEBSITE_URL ) ) ); ?>" class="button button-large button-secondary"><?php esc_html_e( 'Upgrade to Suki Pro', 'suki' ); ?></a>
				</p>
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
				<p><?php esc_html_e( 'Kickstart your website with our pre-made demo websites: Import. Modify. Launch!', 'suki' ); ?></p>
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
