<?php
/**
 * Tools admin page
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Suki_Admin_Page_Tools {

	/**
	 * Admin page ID
	 */
	const PAGE_ID = 'suki-tools';
	
	/**
	 * Singleton instance
	 *
	 * @var Suki_Admin_Page_Tools
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
	 * @return Suki_Admin_Page_Tools
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
		add_action( 'admin_init', array( $this, 'register_settings' ) );

		add_action( 'wp_ajax_suki_regenerate_css', array( $this, 'ajax_regenerate_css' ) );
		add_action( 'wp_ajax_suki_export_customizer', array( $this, 'ajax_export_customizer' ) );
		add_action( 'wp_ajax_suki_import_customizer', array( $this, 'ajax_import_customizer' ) );
		add_action( 'wp_ajax_suki_reset_customizer', array( $this, 'ajax_reset_customizer' ) );
	}

	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

	/**
	 * Initialize settings for Tools admin page.
	 */
	public function register_settings() {
		$section = 'suki_tools_section';

		// Section
		add_settings_section(
			$section,
			null,
			null,
			self::PAGE_ID
		);

		// Regenerate CSS
		$id = 'suki_regenerate_css';
		add_settings_field(
			$id,
			esc_html__( 'Regenerate Customizer CSS', 'suki' ),
			function() {
				?>
				<div class="suki-admin-regenerate-css">
					<p class="suki-admin-tools-action">
						<button data-nonce="<?php echo esc_attr( wp_create_nonce( 'suki_regenerate_css' ) ); ?>" class="suki-admin-regenerate-css-button button">
							<span class="dashicons dashicons-update"></span>
							<?php esc_html_e( 'Regenerate CSS', 'suki' ); ?>
						</button>
						<span class="suki-status suki-status-loading"><?php esc_html_e( 'Generating new CSS file &hellip;', 'suki' ); ?></span>
						<span class="suki-status suki-status-success"><?php esc_html_e( 'Successful!', 'suki' ); ?></span>
					</p>
					<p class="description"><?php esc_html_e( 'Use this button to manually recreate the CSS file according to the latest Customizer settings. If you are using any caching / minifier plugin, you might need to flush the cache.', 'suki' ); ?></p>
				</div>
				<?php
			},
			self::PAGE_ID,
			$section
		);

		// Reset Customizer settings
		$id = 'suki_reset_customizer';
		add_settings_field(
			$id,
			esc_html__( 'Reset Customizer settings', 'suki' ),
			function() {
				?>
				<div class="suki-admin-reset-customizer">
					<p class="suki-admin-tools-action">
						<button data-nonce="<?php echo esc_attr( wp_create_nonce( 'suki_reset_customizer' ) ); ?>" class="suki-admin-reset-customizer-button button" data-confirm="<?php esc_attr_e( 'Are you sure to reset all Customizer settings?', 'suki' ); ?>">
							<span class="dashicons dashicons-trash"></span>	
							<?php esc_html_e( 'Reset Customizer', 'suki' ); ?>
						</button>
						<span class="suki-status suki-status-loading"><?php esc_html_e( 'Resetting Customizer settings &hellip;', 'suki' ); ?></span>
						<span class="suki-status suki-status-success"><?php esc_html_e( 'Successful!', 'suki' ); ?></span>
					</p>
					<p class="description"><?php esc_html_e( 'All current Customizer settings would be deleted. Make sure you already backup (export) your current settings first, if you need to revert in the future!', 'suki' ); ?></p>
				</div>
				<?php
			},
			self::PAGE_ID,
			$section
		);

		// Export Customizer settings
		$id = 'suki_export_customizer';
		add_settings_field(
			$id,
			esc_html__( 'Export Customizer settings', 'suki' ),
			function() {
				?>
				<div class="suki-admin-export-customizer">
					<p class="suki-admin-tools-action">
						<button data-nonce="<?php echo esc_attr( wp_create_nonce( 'suki_export_customizer' ) ); ?>" class="suki-admin-export-customizer-button button">
							<span class="dashicons dashicons-download"></span>	
							<?php esc_html_e( 'Export Customizer', 'suki' ); ?>
						</button>
					</p>
					<p class="description"><?php esc_html_e( 'Export your current Customizer settings to a .txt file for backup.', 'suki' ); ?></p>
				</div>
				<?php
			},
			self::PAGE_ID,
			$section
		);

		// Import Customizer settings
		$id = 'suki_import_customizer';
		add_settings_field(
			$id,
			esc_html__( 'Import Customizer settings', 'suki' ),
			function() {
				?>
				<div class="suki-admin-import-customizer">
					<p class="suki-admin-tools-action">
						<textarea class="large-text" rows="5" cols="50" placeholder="<?php esc_attr_e( 'Paste the code from your .txt backup file here.', 'suki' ); ?>"></textarea>
						<button data-nonce="<?php echo esc_attr( wp_create_nonce( 'suki_import_customizer' ) ); ?>" class="suki-admin-import-customizer-button button" data-empty="<?php esc_attr_e( 'Empty code! Please paste the code into the textarea and then click Import button.', 'suki' ); ?>">
							<span class="dashicons dashicons-upload"></span>	
							<?php esc_html_e( 'Import Customizer', 'suki' ); ?>
						</button>
						<span class="suki-status suki-status-loading"><?php esc_html_e( 'Importing Customizer settings &hellip;', 'suki' ); ?></span>
						<span class="suki-status suki-status-error"><?php esc_html_e( 'Failed! Invalid code', 'suki' ); ?></span>
						<span class="suki-status suki-status-success"><?php esc_html_e( 'Successful!', 'suki' ); ?></span>
					</p>
					<p class="description"><?php esc_html_e( 'All current Customizer settings will be replaced with the imported settings. Please backup (export) first!', 'suki' ); ?></p>
				</div>
				<?php
			},
			self::PAGE_ID,
			$section
		);
	}

	/**
	 * ====================================================
	 * Render functions
	 * ====================================================
	 */

	/**
	 * Render admin submenu page: Suki > Tools.
	 */
	public function render_page() {
		settings_errors();
		?>
		<div class="suki-admin-tools">
			<form method="post" action="options.php">
				<?php
				settings_fields( self::PAGE_ID );
				do_settings_sections( self::PAGE_ID );
				// submit_button();
				?>
			</form>
		</div>
		<?php
	}

	/**
	 * ====================================================
	 * AJAX functions
	 * ====================================================
	 */

	/**
	 * AJAX callback to regenerate CSS.
	 */
	public function ajax_regenerate_css() {
		check_ajax_referer( 'suki_regenerate_css' );

		Suki_Customizer::instance()->write_static_css();

		wp_send_json_success();
	}

	/**
	 * AJAX callback to export Customizer settings
	 */
	public function ajax_export_customizer() {
		check_ajax_referer( 'suki_export_customizer' );
		
		$result = serialize( get_theme_mods() );
		$filename = 'suki-customizer-' . date( 'Ymd-His' );

		wp_send_json_success( array( 'content' => $result, 'filename' => $filename ) );
	}

	/**
	 * AJAX callback to import Customizer settings
	 */
	public function ajax_import_customizer() {
		check_ajax_referer( 'suki_import_customizer' );

		$code = isset( $_POST['code'] ) ? sanitize_text_field( wp_unslash( $_POST['code'] ) ) : '';
		// $code = str_replace( '\"', '"', $code );

		if ( ! is_serialized( $code ) ) {
			wp_send_json_error();
		}

		update_option( 'theme_mods_' . get_stylesheet(), unserialize( $code ) );
		
		wp_send_json_success();
	}

	/**
	 * AJAX callback to reset Customizer settings.
	 */
	public function ajax_reset_customizer() {
		check_ajax_referer( 'suki_reset_customizer' );

		remove_theme_mods();
		
		Suki_Customizer::instance()->write_static_css();

		wp_send_json_success();
	}
}

Suki_Admin_Page_Tools::instance();