<?php
/**
 * Suki module: Core
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
 * Core module class.
 */
class Suki_Core extends Suki_Module {
	/**
	 * Module name
	 *
	 * @var string
	 */
	const MODULE_SLUG = 'core';

	/**
	 * ====================================================
	 * Singleton & constructor functions
	 * ====================================================
	 */

	/**
	 * Class constructor
	 */
	protected function __construct() {
		parent::__construct();
	}

	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

}

Suki_Core::instance();
