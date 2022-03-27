<?php
/**
 * Suki module base class
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
 * Suki module class
 */
abstract class Suki_Module {

	/**
	 * Singleton instances
	 *
	 * @var array()
	 */
	protected static $instances = array();

	/**
	 * Module name
	 *
	 * Module name sould be unique and written in a valid slug format.
	 *
	 * @var string
	 */
	const MODULE_SLUG = '';

	/**
	 * ====================================================
	 * Singleton & constructor functions
	 * ====================================================
	 */

	/**
	 * Get singleton instance.
	 *
	 * @return Suki_Module
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
	}
}
