<?php
/**
 * Suki migrate base class
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
 * Suki migrate class
 */
abstract class Suki_Migrate {

	/**
	 * Singleton instances
	 *
	 * @var array()
	 */
	protected static $instances = array();

	/**
	 * Version
	 *
	 * @var string
	 */
	const VERSION = '';

	/**
	 * ====================================================
	 * Singleton & constructor functions
	 * ====================================================
	 */

	/**
	 * Get singleton instance.
	 *
	 * @return Suki_Migrate
	 */
	public static function instance() {
		$called_class = get_called_class();
		if ( empty( static::$instances[ $called_class ] ) ) {
			static::$instances[ $called_class ] = new static();
		}
		return static::$instances[ $called_class ];
	}

	/**
	 * Class constructor
	 */
	protected function __construct() {
		$files_version = preg_replace( '/\-.*/', '', Suki::instance()->get_info( 'version' ) );

		if ( version_compare( self::VERSION, $files_version, '<=' ) ) {
			$this->run();
		}
	}

	/**
	 * Abstract function to run the migration procedures.
	 */
	protected function run() {
	}
}
