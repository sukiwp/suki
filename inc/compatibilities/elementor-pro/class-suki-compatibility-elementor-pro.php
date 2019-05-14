<?php
/**
 * Plugin compatibility: Elementor Pro
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Suki_Compatibility_Elementor_Pro {

	/**
	 * Singleton instance
	 *
	 * @var Suki_Compatibility_Elementor_Pro
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
	 * @return Suki_Compatibility_Elementor_Pro
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
		// Disable page settings on Elementor Template post type.
		add_filter( 'suki/admin/metabox/page_settings/ignored_post_types', array( $this, 'disable_page_settings_on_elementor_template' ) );

		// Add support for Theme Builder.
		add_action( 'elementor/theme/register_locations', array( $this, 'register_elementor_locations' ) );
	}
	
	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

	/**
	 * Register all template locations for Elementor Pro's Theme Builder.
	 *
	 * @param array $post_types
	 * @return array
	 */
	public function disable_page_settings_on_elementor_template( $post_types ) {
		$post_types[] = 'elementor_library';

		return $post_types;
	}

	/**
	 * Register all template locations for Elementor Pro's Theme Builder.
	 *
	 * @param \ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager $elementor_theme_manager
	 */
	public function register_elementor_locations( $elementor_theme_manager ) {
		global $wp_filter;
		
		// Iterate through each core location and then regiter it with the proper hook used by the theme.
		foreach ( $elementor_theme_manager->get_core_locations() as $location => $args ) {
			$hook = 'suki/frontend/' . $location;
			$hook_object = suki_array_value( $wp_filter, $hook );

			// Build an array of all attached actions on this hook that would be removed.
			$remove_hooks = array();
			if ( is_a( $hook_object, 'WP_Hook' ) ) {
				foreach ( $hook_object->callbacks as $priority => $idxs ) {
					foreach ( $idxs as $idx => $callback ) {
						$remove_hooks[] = $callback['function'];
					}
				}
			}

			// Register location.
			$elementor_theme_manager->register_core_location( $location, array(
				'hook' => $hook,
				'remove_hooks' => $remove_hooks,
			) );
		}
	}
}

Suki_Compatibility_Elementor_Pro::instance();