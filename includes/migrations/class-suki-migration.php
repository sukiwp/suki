<?php
/**
 * Suki migration handler class
 *
 * @package Suki
 *
 * @since 2.0.0
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Migration handler class
 */
class Suki_Migration {

	/**
	 * Singleton instance
	 *
	 * @var Suki_Migration
	 */
	private static $instance;

	/**
	 * Checkpoints
	 *
	 * When there is a new migration checkpoint, developer should add the version here.
	 * A new migration file should be added as well, with filename format: `class-suki-migrate-x.x.x.php`
	 * Replace `x`s with the version number.
	 *
	 * @var array
	 */
	const CHECKPOINTS = array(
		'0.6.0',
		'0.7.0',
		'1.1.0',
		'1.2.0',
		'1.3.0',
		'1.3.3',
	);

	/**
	 * ====================================================
	 * Singleton & constructor functions
	 * ====================================================
	 */

	/**
	 * Get singleton instance.
	 *
	 * @return Suki_Migration
	 */
	final public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Class constructor
	 */
	private function __construct() {
		add_action( 'init', array( $this, 'run' ), 999 ); // set priority to "999" to allow plugin's "init" to run before the migration.
	}

	/**
	 * Run version checking and migration processes
	 */
	public function run() {
		// Get theme version info from DB.
		$db_version    = get_option( 'suki_theme_version', false );
		$files_version = preg_replace( '/\-.*/', '', Suki::instance()->get_info( 'version' ) );

		// If no version is recorded in DB, then create it.
		if ( ! $db_version ) {
			add_option( 'suki_theme_version', $files_version );

			// Skip migration and version update, because this is new installation.
			return;
		}

		// If current version is larger than DB version, update DB version and run migration (if any).
		if ( version_compare( $db_version, $files_version, '<' ) ) {
			// Iterate through each checkpoints.
			foreach ( self::CHECKPOINTS as $checkpoint_version ) {
				/**
				 * Skip migration checkpoint if:
				 * - Checkpoint version is less than DB version
				 * - Checkpoint version is greater than files version.
				 */
				if ( version_compare( $checkpoint_version, $db_version, '<' ) || version_compare( $checkpoint_version, $files_version, '>' ) ) {
					continue;
				}

				// Include migration functions.
				$file = SUKI_INCLUDES_DIR . '/migrations/class-suki-migrate-' . str_replace( '.', '-', $checkpoint_version ) . '.php';

				if ( file_exists( $file ) ) {
					include $file;
				}

				// Update DB version to checkpoint.
				update_option( 'suki_theme_version', $checkpoint_version );
			}

			// Update DB version to latest version.
			update_option( 'suki_theme_version', $files_version );
		}
	}
}

Suki_Migration::instance();
