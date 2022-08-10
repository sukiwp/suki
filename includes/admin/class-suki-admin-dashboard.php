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
	 * Class constructor.
	 */
	protected function __construct() {
		/**
		 * Content actions
		 */

		add_action( 'suki/admin/dashboard/header', array( $this, 'render_header__logo' ), 10 );
		add_action( 'suki/admin/dashboard/header', array( $this, 'render_header__links' ), 20 );
		add_action( 'suki/admin/dashboard/content', array( $this, 'render_content__customizer' ), 10 );
		add_action( 'suki/admin/dashboard/content', array( $this, 'render_content__suki_pro_teaser' ), 20 );
		add_action( 'suki/admin/dashboard/content', array( $this, 'render_content__addons' ), 30 );
		// add_action( 'suki/admin/dashboard/content', array( $this, 'render_content__modules' ), 20 );

		/**
		 * AJAX handlers
		 */

		// Modules manager.
		add_action( 'wp_ajax_suki_active_modules', array( $this, 'ajax_activate_modules' ) );
		add_action( 'wp_ajax_suki_deactive_modules', array( $this, 'ajax_deactivate_modules' ) );

		// Suki Sites Import plugin installation.
		add_action( 'wp_ajax_suki_install_sites_import_plugin', array( $this, 'ajax_install_sites_import_plugin' ) );
	}

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
					<div class="suki-admin-dashboard__notices">
						<hr class="wp-header-end" style="display: none;">

						<?php settings_errors(); ?>
					</div>

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
			<img src="<?php echo esc_url( SUKI_IMAGES_URL . '/suki-logo.svg' ); ?>" alt="<?php echo esc_attr( suki_get_theme_info( 'name' ) ); ?>">
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
	 * Render content section: Customizer.
	 */
	public function render_content__customizer() {
		$links = apply_filters(
			'suki/admin/dashboard/customizer_links',
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
		);
		?>
		<div class="suki-admin-dashboard__customizer suki-admin-dashboard__box">
			<h2 class="suki-admin-dashboard__heading"><?php esc_html_e( 'Start Customizing', 'suki' ); ?></h2>
			<div class="suki-admin-dashboard__customizer-links-list" style="--rows: <?php echo esc_attr( ceil( count( $links ) / 2 ) ); ?>">
				<?php
				foreach ( $links as $link ) {
					?>
					<div class="suki-admin-dashboard__customizer-links-item">
						<a href="<?php echo esc_url( $link['url'] ); ?>">
							<span class="dashicons dashicons-<?php echo esc_attr( $link['icon'] ); ?>"></span>
							<span><?php echo $link['label']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
						</a>
					</div>
					<?php
				}
				?>
			</div>
		</div>
		<?php
	}

	/**
	 * Render content section: Suki Pro.
	 */
	public function render_content__suki_pro_teaser() {
		$pro_modules = suki_get_pro_modules();
		?>
		<div class="suki-admin-dashboard__suki-pro-teaser suki-admin-dashboard__box">
			<h2 class="suki-admin-dashboard__heading" style="margin-bottom: 0;"><?php esc_html_e( 'Suki Pro', 'suki' ); ?></h2>
			<p class="suki-admin-dashboard__subheading" style="margin-top: 5px;"><?php esc_html_e( 'Get more features, advanced demo templates, and premium support.', 'suki' ); ?></p>
			<hr class="suki-admin-dashboard__box-separator">

			<ul class="suki-admin-dashboard__suki-pro-teaser-modules-grid" style="--rows: <?php echo esc_attr( ceil( count( $pro_modules ) / 3 ) ); ?>">
				<?php
				foreach ( $pro_modules as $module_slug => $module_data ) {
					?>
					<li><?php echo esc_html( $module_data['label'] ); ?></li>
					<?php
				}
				?>
			</ul>

			<?php
			$url = add_query_arg(
				array(
					'utm_source'   => 'suki-dashboard',
					'utm_medium'   => 'learn-more',
					'utm_campaign' => 'theme-pro-modules-list',
				),
				trailingslashit( SUKI_PRO_WEBSITE_URL )
			);
			?>
			<p class="suki-admin-dashboard__suki-pro-teaser-action">
				<a href="<?php echo esc_url( $url ); ?>" class="button button-large button-primary"><?php esc_html_e( 'Upgrade to Suki Pro', 'suki' ); ?></a>
			</p>
		</div>
		<?php
	}

	/**
	 * Render content section: Modules.
	 *
	 * Module statuses:
	 * - `inactive`    : The module is currently inactive. There will be a toggle to activate the module.
	 * - `active`      : The module is currently active.  There will be a toggle to deactivate the module
	 * - `unavailable` : The module is not available because there might be some required plugins not installed or versions doesn't match.
	 */
	public function render_content__modules() {
		$modules = array();

		$categories = suki_get_module_categories();

		$active_pro_modules = get_option( 'suki_active_pro_modules', array() );

		/**
		 * Fetch pro modules and add more data.
		 */
		foreach ( suki_get_pro_modules() as $module_slug => $module_data ) {
			$is_active = in_array( $module_slug, $active_pro_modules, true );

			$module_data['hide'] = false;

			$module_data['pro'] = true;

			if ( suki_is_pro() ) {
				$module_data['status'] = array(
					'type'  => $is_active ? 'active' : 'inactive',
					'label' => $is_active ? esc_html__( 'Deactivate', 'suki' ) : esc_html__( 'Activate', 'suki' ),
					'url'   => add_query_arg(
						array(
							'action'  => $is_active ? 'deactivate_modules' : 'activate_modules',
							'modules' => array( $module_slug ),
						)
					),
				);
			} else {
				$module_data['status'] = array(
					'type'  => 'unavailable',
					'label' => esc_html__( 'Available on Suki Pro', 'suki' ),
				);
			}

			// Add to collection.
			if ( ! empty( $module_data['category'] ) ) {
				$modules[ $module_data['category'] ][ $module_slug ] = $module_data;
			}
		}
		?>
		<div class="suki-admin-dashboard__modules suki-admin-dashboard__box">
			<?php
			if ( suki_is_pro() ) {
				?>
				<h2 class="suki-admin-dashboard__heading"><?php esc_html_e( 'More Features on Suki Pro', 'suki' ); ?></h2>

				<div class="suki-admin-dashboard__modules-bulk-actions">
					<a href="<?php echo esc_url( add_query_arg( array( 'action' => 'activate_modules' ) ) ); ?>" class="button">
						<?php esc_html_e( 'Activate All', 'suki' ); ?>
					</a>
					<a href="<?php echo esc_url( add_query_arg( array( 'action' => 'deactivate_modules' ) ) ); ?>" class="button">
						<?php esc_html_e( 'Deactivate All', 'suki' ); ?>
					</a>
				</div>
				<?php
			}
			?>

			<?php
			foreach ( $categories as $category_slug => $category_data ) {
				// Skip if this category doesn't have modules.
				if ( empty( $modules[ $category_slug ] ) ) {
					continue;
				}
				?>
				<hr class="suki-admin-dashboard__box-separator">
				<h3 class="suki-admin-dashboard__modules-category">
					<span class="dashicons dashicons-<?php echo esc_attr( $category_data['icon'] ); ?>"></span>
					<span><?php echo esc_html( $category_data['label'] ); ?></span>
				</h3>
				<div class="suki-admin-dashboard__modules-grid" style="--rows: <?php echo esc_attr( ceil( count( $modules[ $category_slug ] ) / 2 ) ); ?>">
					<?php
					foreach ( $modules[ $category_slug ] as $module_slug => $module_data ) {
						// Skip if module is in "hide" mode.
						if ( boolval( $module_data['hide'] ) ) {
							continue;
						}
						?>
						<div class="suki-admin-dashboard__module suki-admin-dashboard__module--<?php echo esc_attr( $module_data['status']['type'] ); ?>">
							<?php
							/**
							 * Module status and action
							 */
							if ( isset( $module_data['status']['url'] ) ) {
								?>
								<a href="<?php echo esc_url( $module_data['status']['url'] ); ?>" class="suki-admin-dashboard__module-action suki-admin-dashboard__module-action--<?php echo esc_attr( $module_data['status']['type'] ); ?> suki-admin-tooltip">
									<span class="suki-admin-tooltip__content"><?php echo esc_html( $module_data['status']['label'] ); ?></span>
								</a>
								<?php
							} else {
								?>
								<span tabindex="0" class="suki-admin-dashboard__module-action suki-admin-dashboard__module-action--<?php echo esc_attr( $module_data['status']['type'] ); ?> suki-admin-tooltip">
									<span class="suki-admin-tooltip__content"><?php echo esc_html( $module_data['status']['label'] ); ?></span>
								</span>
								<?php
							}
							?>

							<div class="suki-admin-dashboard__module-name"><?php echo esc_html( $module_data['label'] ); ?></div>

							<?php
							/**
							 * Module settings link
							 */
							if ( 'active' === $module_data['status']['type'] && isset( $module_data['settings_link'] ) ) {
								?>
								<a href="<?php echo esc_url( $module_data['settings_link']['url'] ); ?>" class="suki-admin-dashboard__module-settings-link suki-admin-tooltip">
									<span class="suki-admin-tooltip__content"><?php echo esc_html( $module_data['settings_link']['label'] ); ?></span>
								</a>
								<?php
							}
							?>
						</div>
						<?php
					}
					?>
				</div>
				<?php
			}
			?>
		</div>
		<?php
	}

	/**
	 * Render content section: Addons.
	 */
	public function render_content__addons() {
		?>
		<div class="suki-admin-dashboard__addons">
			<div class="suki-admin-dashboard__addon suki-admin-dashboard__box">
				<div class="suki-admin-dashboard__addon-banner"><img src="<?php echo esc_url( SUKI_IMAGES_URL . '/dashboard--suki-sites-import.jpg' ); ?>" width="400" height="160" alt="" /></div>
				<h2 class="suki-admin-dashboard__heading"><?php esc_html_e( 'Demo Sites Import', 'suki' ); ?></h2>
				<p><?php esc_html_e( 'Kickstart your website with our pre-made demo websites: Import. Modify. Launch!', 'suki' ); ?></p>

				<?php
				if ( is_plugin_active( 'suki-sites-import/suki-sites-import.php' ) ) {
					?>
					<p><a href="<?php echo esc_url( add_query_arg( array( 'page' => 'suki-sites-import' ), admin_url( 'themes.php' ) ) ); ?>" class="button"><?php esc_html_e( 'Browse Demo Sites', 'suki' ); ?></a></p>
					<?php
				} elseif ( current_user_can( 'install_plugins' ) ) {
					?>
					<p><button class="button" data-js="install-sites-import-plugin"><?php esc_html_e( 'Install & Activate Plugin', 'suki' ); ?></button></p>
					<?php
				}
				?>
			</div>

			<div class="suki-admin-dashboard__addon suki-admin-dashboard__box">
				<div class="suki-admin-dashboard__addon-banner"><img src="<?php echo esc_url( SUKI_IMAGES_URL . '/dashboard--child-theme.jpg' ); ?>" width="400" height="160" alt="" /></div>
				<h2 class="suki-admin-dashboard__heading"><?php esc_html_e( 'Child Theme', 'suki' ); ?></h2>
				<p><?php esc_html_e( 'Extend codes or override templates from the Suki theme using our starter Child Theme.', 'suki' ); ?></p>

				<?php
				if ( is_child_theme() ) {
					?>
					<p><a href="<?php echo esc_url( admin_url( 'theme-editor.php' ) ); ?>" class="button"><?php esc_html_e( 'Edit Child Theme', 'suki' ); ?></a></p>
					<?php
				} else {
					?>
					<p><a href="https://github.com/sukiwp/suki-child/" class="button"><?php esc_html_e( 'Download Starter Child Theme', 'suki' ); ?></a></p>
					<?php
				}
				?>
			</div>
		</div>
		<?php
	}

	/**
	 * ====================================================
	 * AJAX functions
	 * ====================================================
	 */

	/**
	 * AJAX callback to activate modules.
	 */
	public function ajax_activate_modules() {
		check_ajax_referer( 'suki', '_ajax_nonce' );

		// Abort if no module is specified.
		if ( ! isset( $_REQUEST['modules'] ) ) {
			return;
		}

		// Skip if it's White Label module.
		if ( in_array( 'white-label', $_REQUEST['modules'], true ) ) {
			return;
		}

		// Get pro modules list.
		$available_modules = suki_get_pro_modules();

		// Sanitize module.
		$module = sanitize_key( $_REQUEST['module'] );

		// Get module data.
		$module_data = suki_array_value( $available_modules, $module );

		// Get active modules array from DB.
		$active_modules = get_option( 'suki_pro_active_modules', array() );

		// If module is already active, show notice and abort.
		if ( in_array( $module, $active_modules ) ) {
			return;
		}

		// Merge into active modules array.
		$active_modules = array_merge( $active_modules, array( $module ) );

		// Resort array.
		$active_modules = array_values( $active_modules );

		// Update DB.
		update_option( 'suki_pro_active_modules', $active_modules );

		// Add success notice.
		Suki_Pro_Notice::instance()->add_notice(
			array(
				'type' => 'success',
				/* translators: %s: module name */
				'text' => sprintf( esc_html__( '"%s" is activated.', 'suki-pro' ), suki_array_value( $module_data, 'label' ) ),
			)
		);

		// Redirect to show notices on session.
		wp_safe_redirect( admin_url( 'themes.php?page=suki' ) );

		wp_send_json_success();
		exit;
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
				require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
			}
			if ( ! class_exists( 'WP_Upgrader' ) ) {
				require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
			}

			$api = plugins_api(
				'plugin_information',
				array(
					'slug'   => 'suki-sites-import',
					'fields' => array(
						'short_description' => false,
						'sections'          => false,
						'requires'          => false,
						'rating'            => false,
						'ratings'           => false,
						'downloaded'        => false,
						'last_updated'      => false,
						'added'             => false,
						'tags'              => false,
						'compatibility'     => false,
						'homepage'          => false,
						'donate_link'       => false,
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
}

Suki_Admin::instance();
