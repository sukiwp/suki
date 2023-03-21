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

		// Add CSS and JS.
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

		// Dashboard page.
		require_once trailingslashit( SUKI_INCLUDES_DIR ) . 'admin/class-suki-admin-dashboard.php';

		// Form fields.
		require_once trailingslashit( SUKI_INCLUDES_DIR ) . 'admin/class-suki-admin-fields.php';
	}

	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

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
		wp_enqueue_style( 'suki-admin', trailingslashit( SUKI_CSS_URL ) . 'admin' . SUKI_ASSETS_SUFFIX . '.css', array(), SUKI_VERSION );
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
		wp_enqueue_script( 'suki-admin', trailingslashit( SUKI_JS_URL ) . 'admin' . SUKI_ASSETS_SUFFIX . '.js', array( 'jquery' ), SUKI_VERSION, true );

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

		// TODO: add rem responsive value and responsive sidebar visual preview.

		// Add rem value CSS.
		$css_array['global']['html']['font-size'] = suki_get_theme_mod( 'body_font_size', '16px' );

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
		/**
		 * Filter: suki/frontend/dynamic_css
		 *
		 * @param string $dynamic_css CSS string.
		 */
		$dynamic_css = apply_filters( 'suki/frontend/dynamic_css', '' );

		$dynamic_css = trim( $dynamic_css );

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
}

Suki_Admin::instance();
