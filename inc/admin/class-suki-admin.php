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
		$this->_includes();

		// Hooks on every admin pages
		add_action( 'admin_menu', array( $this, 'register_admin_menu' ), 1 );
		add_action( 'admin_init', array( $this, 'check_compatible_plugins_active_status' ) );
		// add_action( 'admin_notices', array( $this, 'add_theme_notice' ), 99 );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
		add_filter( 'upload_mimes', array( $this, 'upload_mimes' ) );
		add_filter( 'user_contactmethods', array( $this, 'add_user_contactmethods' ) );

		// Hooks on classic editor pages
		add_action( 'admin_init', array( $this, 'add_editor_css' ) );
		add_action( 'tiny_mce_before_init', array( $this, 'modify_tiny_mce_config' ) );
	}

	private function _includes() {
		// Admin form fields
		require_once( SUKI_INCLUDES_PATH . '/admin/class-suki-admin-fields.php' );

		// Metabox
		require_once( SUKI_INCLUDES_PATH . '/admin/class-suki-admin-metabox-page-settings.php' );

		// Admin pages
		require_once( SUKI_INCLUDES_PATH . '/admin/class-suki-admin-page-dashboard.php' );
		require_once( SUKI_INCLUDES_PATH . '/admin/class-suki-admin-page-tools.php' );
	}

	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

	/**
	 * Add admin submenu page: Suki > About.
	 */
	public function register_admin_menu() {
		add_theme_page(
			suki_get_theme_info( 'name' ),
			suki_get_theme_info( 'name' ),
			'edit_theme_options',
			'suki',
			array( $this, 'admin_page' )
		);
	}

	/**
	 * Check compatible plugins status and record to DB.
	 */
	public function check_compatible_plugins_active_status() {
		$active_plugins = get_option( 'active_plugins', array() );
		$active_compatible_plugins = get_option( 'suki_active_compatible_plugins', array() );

		$compatible_plugins_data = Suki::instance()->get_compatible_plugins();

		foreach ( $compatible_plugins_data as $slug => $data ) {
			// Check if plugin is just activated.
			if ( ! in_array( $data['path'], $active_compatible_plugins ) && in_array( $data['path'], $active_plugins ) ) {
				/**
				 * Hook: suki_compatible_plugin_activated
				 */
				do_action( 'suki_compatible_plugin_activated', $data );

				// Update option.
				$active_compatible_plugins[] = $data['path'];
				update_option( 'suki_active_compatible_plugins', $active_compatible_plugins );
			}
			// Check if plugin is just deactivated.
			elseif ( in_array( $data['path'], $active_compatible_plugins ) && ! in_array( $data['path'], $active_plugins ) ) {
				/**
				 * Hook: suki_compatible_plugin_deactivated
				 */
				do_action( 'suki_compatible_plugin_deactivated', $data );

				// Update option.
				$i = array_search( $data['path'], $active_compatible_plugins );
				if ( false !== $i ) {
					unset( $active_compatible_plugins[ $i ] );
					$active_compatible_plugins = array_values( $active_compatible_plugins );
					update_option( 'suki_active_compatible_plugins', $active_compatible_plugins );
				}
			}
		}
	}

	/**
	 * Add admin notice to import data like screenshot.
	 */
	public function add_theme_notice() {
		global $hook_suffix;

		if ( 'themes.php' == $hook_suffix ) : ?>
			<div class="suki-admin-theme-notice notice notice-info">
				<div class="suki-admin-theme-notice-arrow"></div>
				<p>
					<?php esc_html_e( 'Fell in love with this screenshot? Learn how to replicate same design as the screenscrot.', 'suki' ); ?>&nbsp;
					<a href=""></a>
				</p>
			</div>
			<script type="text/javascript">
				(function($) {
					$(function() {
						$( '.suki-admin-theme-notice' ).insertBefore( $( '.theme-browser' ) );
					});
				})( jQuery );
			</script>
		<?php endif;
	}

	/**
	 * Enqueue scripts for all Admin page.
	 *
	 * @param string $hook
	 */
	public function admin_enqueue_scripts( $hook ) {
		// Fetched version from package.json
		$ver = array();
		$ver['jquery.repeater'] = '1.2.1';
		$ver['select2'] = '4.0.5';

		// Register JS files
		wp_register_script( 'wp-color-picker-alpha', SUKI_JS_URL . '/vendors/wp-color-picker-alpha.min.js', array( 'wp-color-picker' ), '2.1.3', true );
		wp_register_script( 'jquery-repeater', SUKI_JS_URL . '/vendors/jquery.repeater.min.js', array( 'jquery' ), $ver['jquery.repeater'], true );
		wp_register_script( 'select2', SUKI_JS_URL . '/vendors/select2.min.js', array( 'jquery' ), $ver['select2'], true );

		wp_enqueue_script( 'suki-admin', SUKI_JS_URL . '/admin/admin.js', array( 'jquery' ), SUKI_VERSION, true );

		// Register CSS files
		wp_enqueue_style( 'select2', SUKI_CSS_URL . '/vendors/select2.min.css', array(), $ver['select2'] );
		
		wp_enqueue_style( 'suki-admin', SUKI_CSS_URL . '/admin/admin.css', array(
			'select2',
		), SUKI_VERSION );
		wp_style_add_data( 'suki-admin', 'rtl', 'replace' );
	}

	/**
	 * Change footer text on all Suki admin pages.
	 *
	 * @param array $mimes
	 * @return array
	 */
	public function upload_mimes( $mimes ) {
		$mimes['otf'] = 'application/x-font-otf';
		$mimes['woff2'] = 'application/x-font-woff2';
		$mimes['woff'] = 'application/x-font-woff';
		$mimes['ttf'] = 'application/x-font-ttf';
		$mimes['svg'] = 'image/svg+xml';
		$mimes['eot'] = 'application/vnd.ms-fontobject';

		return $mimes;
	}

	/**
	 * Add social media link options to user profile edit page.
	 * 
	 * @param array $contactmethods
	 * @return array
	 */
	public function add_user_contactmethods( $contactmethods ) {
		$contact_types = apply_filters( 'suki_user_contact_types', array(
			'facebook'    => esc_html__( 'Facebook', 'suki' ),
			'instagram'   => esc_html__( 'Instagram', 'suki' ),
			'linkedin'    => esc_html__( 'LinkedIn', 'suki' ),
			'twitter'     => esc_html__( 'Twitter', 'suki' ),
			'google-plus' => esc_html__( 'Google Plus', 'suki' ),
		) );

		foreach ( suki_get_social_media_types() as $key => $value ) {
			$contactmethods[ $key ] = $value . esc_html__( ' URL', 'suki' );
		}

		return $contactmethods;
	}

	/**
	 * Add CSS for editor page.
	 */
	public function add_editor_css() {
		add_editor_style( SUKI_CSS_URL . '/admin/editor' . SUKI_ASSETS_SUFFIX . '.css' );
		add_editor_style( Suki_Customizer::instance()->generate_google_fonts_embed_url() );
	}

	/**
	 * Modify TinyMCE configurations.
	 * - Add dymanic CSS for editor page.
	 * - Add content layout body class.
	 *
	 * @param array $mceinit
	 * @return array
	 */
	public function modify_tiny_mce_config( $mceinit ) {
		/**
		 * Add dynamic CSS.
		 */

		$css_array = array(
			'global' => array(),
		);

		// Typography
		$active_google_fonts = array();
		$typography_types = array( 'body', 'blockquote', 'h1', 'h2', 'h3', 'h4' );
		$fonts = suki_get_all_fonts();

		foreach ( $typography_types as $type ) {
			$selected_font_family = suki_get_theme_mod( $type . '_font_family' );

			if ( '' === $selected_font_family || 'inherit' === $selected_font_family ) {
				$select_font_stack = $selected_font_family;
			} else {
				$chunks = explode( '|', $selected_font_family );
				if ( 2 === count( $chunks ) ) {
					$select_font_stack = suki_array_value( $fonts[ $chunks[0] ], $chunks[1], $chunks[1] );
				}
			}

			$css_array['global'][ $type ]['font-family'] = $select_font_stack;
			$css_array['global'][ $type ]['font-weight'] = suki_get_theme_mod( $type . '_font_weight' );
			$css_array['global'][ $type ]['font-style'] = suki_get_theme_mod( $type . '_font_style' );
			$css_array['global'][ $type ]['text-transform'] = suki_get_theme_mod( $type . '_text_transform' );
			$css_array['global'][ $type ]['font-size'] = suki_get_theme_mod( $type . '_font_size' );
			$css_array['global'][ $type ]['line-height'] = suki_get_theme_mod( $type . '_line_height' );
			$css_array['global'][ $type ]['letter-spacing'] = suki_get_theme_mod( $type . '_letter_spacing' );
		}

		// Container width for content layout with sidebar
		$css_array['global']['body']['max-width'] = suki_get_content_width_by_layout() . 'px';

		// Container width for narrow content layout
		$css_array['global']['body.suki-editor-narrow']['max-width'] = suki_get_content_width_by_layout( 'narrow' ) . 'px';

		// Container width for wide content layout
		$css_array['global']['body.suki-editor-wide']['max-width'] = suki_get_content_width_by_layout( 'wide' ) . 'px';

		// Build CSS string.
		// $styles = str_replace( '"', '\"', suki_convert_css_array_to_string( $css_array ) );
		$styles = wp_slash( suki_convert_css_array_to_string( $css_array ) );

		// Merge with existing styles or add new styles.
		if ( ! isset( $mceinit['content_style'] ) ) {
			$mceinit['content_style'] = $styles . ' ';
		} else {
			$mceinit['content_style'] .= ' ' . $styles . ' ';
		}

		/**
		 * Add body class.
		 */
		
		global $post;

		$class = 'suki-editor-' . suki_get_page_setting_by_post_id( 'content_layout', $post );

		// Merge with existing classes or add new class.
		if ( ! isset( $mceinit['body_class'] ) ) {
			$mceinit['body_class'] = $class . ' ';
		} else {
			$mceinit['body_class'] .= ' ' . $class . ' ';
		}

		return $mceinit;
	}

	/**
	 * ====================================================
	 * Render functions
	 * ====================================================
	 */

	public function admin_page() {
		?>
		<div class="wrap suki-admin-wrap">
			<div class="suki-admin-header">
				<div class="suki-admin-wrapper wp-clearfix">
					<div class="suki-admin-logo">
						<img src="<?php echo esc_url( SUKI_IMAGES_URL . '/suki-logo.svg' ); ?>" height="30" alt="<?php echo esc_attr( get_admin_page_title() ); ?>">
						<span class="suki-admin-version"><?php echo suki_get_theme_info( 'version' ); // WPCS: XSS OK ?></span>
					</div>
					<div class="suki-admin-header-menu">
						<a href="https://sukiwp.com/pro/" class="button button-large button-default" target="_blank" rel="noopener">
							<span class="dashicons dashicons-awards"></span>
							<?php echo esc_html_x( 'Upgrade to Suki Pro', 'Suki Pro teaser', 'suki' ); ?>
						</a>
					</div>
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
						<div class="suki-admin-primary postbox">
							<?php
							$tabs = $this->get_tabs();
							$tab = $this->get_current_tab();
							?>
							<div class="suki-admin-nav-tab nav-tab-wrapper">
								<?php foreach ( $tabs as $key => $label ) : ?>
									<a href="<?php echo esc_url( add_query_arg( array( 'page' => 'suki', 'tab' => $key ), admin_url( 'themes.php' ) ) ); ?>" class="nav-tab <?php echo esc_attr( $key == $tab ? 'nav-tab-active' : '' ); ?>"><?php echo $label; // WPCS: XSS OK ?></a>
								<?php endforeach; ?>
							</div>

							<div class="suki-admin-tab-panel">
								<?php
								$class = 'Suki_Admin_Page_' . str_replace( ' ', '_', ucwords( $tabs[ $tab ] ) );
								$class::instance()->render_page();
								?>
							</div>
						</div>
						<div class="suki-admin-secondary">
							<div class="suki-admin-secondary-customize">
								<a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="suki-admin-customize-button button button-hero button-primary">
									<?php esc_html_e( 'Go to Customizer', 'suki' ); ?>
								</a>
							</div>
							<div class="suki-admin-secondary-docs postbox">
								<h2 class="hndle"><?php esc_html_e( 'Documentation', 'suki' ); ?></h2>
								<div class="inside">
									<p><?php esc_html_e( 'Not sure how something works? Our documentation might help you figure out the solution.', 'suki' ); ?></p>
									<p>
										<a href="https://sukiwp.com/documentation/" class="button button-default" target="_blank" rel="noopener">
											<span class="dashicons dashicons-lightbulb"></span>
											<?php esc_html_e( 'Go to our Documentation', 'suki' ); ?>
										</a>
									</p>
								</div>
							</div>
							<div class="suki-admin-secondary-fb-group postbox">
								<h2 class="hndle"><?php esc_html_e( 'Join the community!', 'suki' ); ?></h2>
								<div class="inside">
									<p><?php esc_html_e( 'Join our Facebook group for latest updates info and discussions with other Suki users.', 'suki' ); ?></p>
									<p>
										<a href="https://facebook.com/groups/sukiwp/" class="button button-default" target="_blank" rel="noopener">
											<span class="dashicons dashicons-facebook"></span>
											<?php esc_html_e( 'Join our Facebook Group', 'suki' ); ?>
										</a>
									</p>
								</div>
							</div>
							<?php if ( false ) : ?>
								<div class="suki-admin-secondary-rate postbox">
									<h2 class="hndle"><?php esc_html_e( 'Enjoy Suki?', 'suki' ); ?></h2>
									<div class="inside">
										<p><?php esc_html_e( 'Please take a minute to leave a review on Suki, we would really appreciate it!', 'suki' ); ?></p>
										<p>
											<a href="https://wordpress.org/support/theme/suki/reviews/?rate=5#new-post" class="button button-default" target="_blank" rel="noopener">
												<span class="dashicons dashicons-thumbs-up"></span>
												<?php esc_html_e( 'Rate us &#9733;&#9733;&#9733;&#9733;&#9733;', 'suki' ); ?>
											</a>
										</p>
									</div>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * ====================================================
	 * Public functions
	 * ====================================================
	 */

	public function get_tabs() {
		return apply_filters( 'suki_admin_tabs', array(
			'dashboard' => esc_html__( 'Dashboard', 'suki' ),
			'tools' => esc_html__( 'Tools', 'suki' ),
		) );
	}

	public function get_current_tab() {
		$section = isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : key( $this->get_tabs() );

		if ( $this->is_admin_page() ) {
			return $section;
		} else {
			return false;
		}
	}

	public function is_admin_page() {
		global $hook_suffix;

		if ( 'appearance_page_suki' === $hook_suffix ) {
			return true;
		} else {
			return false;
		}
	}
}

Suki_Admin::instance();