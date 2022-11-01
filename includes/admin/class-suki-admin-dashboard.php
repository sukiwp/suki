<?php
/**
 * Suki Admin Dashboard page
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
class Suki_Admin_Dashboard {
	/**
	 * Singleton instance
	 *
	 * @var Suki_Admin_Dashboard
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
	 * @return Suki_Admin_Dashboard
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Class constructor.
	 */
	protected function __construct() {
		add_action( 'admin_menu', array( $this, 'add_admin_menu' ), 1 );

		add_action( 'suki/admin/dashboard/header', array( $this, 'render_header__logo' ), 10 );
		add_action( 'suki/admin/dashboard/header', array( $this, 'render_header__links' ), 20 );
		add_action( 'suki/admin/dashboard/content', array( $this, 'render_content__customizer_shortcuts' ), 10 );
		if ( suki_show_pro_teaser() ) {
			add_action( 'suki/admin/dashboard/content', array( $this, 'render_content__pro_teaser' ), 20 );
		}
		add_action( 'suki/admin/dashboard/content', array( $this, 'render_content__sites_import' ), 30 );

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
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
	public function add_admin_menu() {
		// Add theme dashboard page.
		add_theme_page(
			suki_get_theme_info( 'name' ),
			suki_get_theme_info( 'name' ),
			'edit_theme_options',
			'suki',
			array( $this, 'render' )
		);

		/**
		 * Hook: suki/admin/menu
		 */
		do_action( 'suki/admin/menu' );
	}

	/**
	 * Enqueue dashboard page's scripts.
	 */
	public function enqueue_scripts() {
		$current_screen = get_current_screen();

		if ( 'appearance_page_suki' === $current_screen->id ) {
			$script_data = include trailingslashit( SUKI_SCRIPTS_DIR ) . 'dashboard.asset.php';

			/**
			 * Enqueue dashboard.css
			 */

			wp_enqueue_style( 'suki-dashboard', trailingslashit( SUKI_SCRIPTS_URL ) . 'dashboard.css', array( 'wp-components' ), $script_data['version'] );

			/**
			 * Enqueue dashboard.js
			 */

			wp_enqueue_script( 'suki-dashboard', trailingslashit( SUKI_SCRIPTS_URL ) . 'dashboard.js', $script_data['dependencies'], $script_data['version'], true );

			$data = array();

			// Add data for "Customizer Shortcuts" section.
			if ( has_action( 'suki/admin/dashboard/content', array( $this, 'render_content__customizer_shortcuts' ) ) ) {
				$data['customizerShortcuts'] = array(
					'links' => apply_filters(
						'suki/admin/dashboard/customizer_shortcuts',
						array(
							array(
								'label' => esc_html__( 'Global Colors', 'suki' ),
								'url'   => add_query_arg( array( 'autofocus[section]' => 'suki_section_color_palette' ), admin_url( 'customize.php' ) ),
								'icon'  => 'art',
							),
							array(
								'label' => esc_html__( 'Global Elements', 'suki' ),
								'url'   => add_query_arg( array( 'autofocus[panel]' => 'suki_panel_global_elements' ), admin_url( 'customize.php' ) ),
								'icon'  => 'editor-textcolor',
							),
							array(
								'label' => esc_html__( 'Global Layout', 'suki' ),
								'url'   => add_query_arg( array( 'autofocus[panel]' => 'suki_panel_global_layout' ), admin_url( 'customize.php' ) ),
								'icon'  => 'welcome-widgets-menus',
							),
							array(
								'label' => esc_html__( 'Header Builder', 'suki' ),
								'url'   => add_query_arg( array( 'autofocus[panel]' => 'suki_panel_header' ), admin_url( 'customize.php' ) ),
								'icon'  => 'move',
							),
							array(
								'label' => esc_html__( 'Footer Builder', 'suki' ),
								'url'   => add_query_arg( array( 'autofocus[panel]' => 'suki_panel_footer' ), admin_url( 'customize.php' ) ),
								'icon'  => 'move',
							),
							array(
								'label' => esc_html__( 'Blog Layout', 'suki' ),
								'url'   => add_query_arg( array( 'autofocus[panel]' => 'suki_panel_blog' ), admin_url( 'customize.php' ) ),
								'icon'  => 'welcome-write-blog',
							),
						)
					),
				);
			}

			// Add data for "Pro Teaser" section.
			if ( has_action( 'suki/admin/dashboard/content', array( $this, 'render_content__pro_teaser' ) ) ) {
				$data['proTeaser'] = array(
					'modules'    => suki_convert_associative_array_into_simple_array( suki_get_pro_modules(), 'slug' ),
					'websiteURL' => add_query_arg(
						array(
							'utm_source'   => 'suki-dashboard',
							'utm_medium'   => 'learn-more',
							'utm_campaign' => 'theme-pro-modules-list',
						),
						trailingslashit( SUKI_PRO_WEBSITE_URL )
					),
				);
			}

			// Add data for "Sites Import" section.
			if ( has_action( 'suki/admin/dashboard/content', array( $this, 'render_content__sites_import' ) ) ) {
				$data['sitesImport'] = array(
					'isPluginInstalled' => is_plugin_active( 'suki-sites-import/suki-sites-import.php' ),
					'pluginPageURL'     => add_query_arg( array( 'page' => 'suki-sites-import' ), admin_url( 'themes.php' ) ),
					'bannerImageURL'    => trailingslashit( SUKI_IMAGES_URL ) . 'dashboard-sites-import-banner.jpg',
				);
			}

			// Pass data to dashboard.js.
			if ( ! empty( $data ) ) {
				wp_add_inline_script(
					'suki-dashboard',
					'const sukiDashboardData = ' . wp_json_encode( $data ),
					'before'
				);
			}
		}
	}

	/**
	 * ====================================================
	 * Render functions
	 * ====================================================
	 */

	/**
	 * Render theme dashboard page.
	 */
	public function render() {
		?>
		<div class="suki-admin-dashboard <?php echo esc_attr( suki_is_pro() ? 'suki-pro-installed' : '' ); ?>">
			<div class="suki-admin-dashboard__header">
				<div class="suki-admin-dashboard__container">
					<?php
					/**
					 * Hook: suki/admin/dashboard/header
					 */
					do_action( 'suki/admin/dashboard/header' );
					?>
				</div>
			</div>

			<div class="suki-admin-dashboard__body">
				<div class="suki-admin-dashboard__container">
					<hr class="wp-header-end" style="display: none;">
					<!-- WordPress notices -->
					<?php settings_errors(); ?>

					<?php
					/**
					 * Hook: suki/admin/dashboard/content
					 */
					do_action( 'suki/admin/dashboard/content' );
					?>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Render header elements: Logo.
	 */
	public function render_header__logo() {
		?>
		<h1 class="suki-admin-dashboard__header-logo">
			<img src="<?php echo esc_url( trailingslashit( SUKI_IMAGES_URL ) . 'suki-logo.svg' ); ?>" alt="<?php echo esc_attr( suki_get_theme_info( 'name' ) ); ?>">
			<span class="suki-admin-dashboard__version-badge"><?php echo esc_html( suki_get_theme_info( 'version' ) ); ?></span>
		</h1>
		<?php
	}

	/**
	 * Render header elements: Links.
	 */
	public function render_header__links() {
		?>
		<div class="suki-admin-dashboard__header-links">
			<a href="https://docs.sukiwp.com/"><?php esc_html_e( 'Documentation', 'suki' ); ?></a>
			<a href="https://sukiwp.com/support/"><?php esc_html_e( 'Support', 'suki' ); ?></a>
			<a href="https://www.facebook.com/groups/sukiwp/"><?php esc_html_e( 'Community', 'suki' ); ?></a>
			<a href="https://translate.sukiwp.com/"><?php esc_html_e( 'Translation', 'suki' ); ?></a>
			<a href="https://sukiwp.com/changelog/"><?php esc_html_e( 'Changelog', 'suki' ); ?></a>
		</div>
		<?php
	}

	/**
	 * Render content section: Customizer Shortcuts.
	 *
	 * Container for React app.
	 */
	public function render_content__customizer_shortcuts() {
		?>
		<div id="suki-admin-dashboard__customizer-shortcuts"></div>
		<?php
	}

	/**
	 * Render content section: Pro Teaser.
	 *
	 * Container for React app.
	 */
	public function render_content__pro_teaser() {
		?>
		<div id="suki-admin-dashboard__pro-teaser"></div>
		<?php
	}

	/**
	 * Render content section: Suki Sites Import.
	 *
	 * Container for React app.
	 */
	public function render_content__sites_import() {
		?>
		<div id="suki-admin-dashboard__sites-import"></div>
		<?php
	}
}

Suki_Admin_Dashboard::instance();
