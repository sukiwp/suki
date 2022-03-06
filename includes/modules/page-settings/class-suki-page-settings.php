<?php
/**
 * Suki module: Individual Page Settings
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
 * Individual Page Settings module class.
 */
class Suki_Page_Settings extends Suki_Module {
	/**
	 * Module name
	 *
	 * @var string
	 */
	const MODULE_SLUG = 'page-settings';

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

		/**
		 * Customizer settings & values
		 */

		// Add Customizer options.
		add_action( 'customize_register', array( $this, 'add_customizer_settings' ) );

		// Add Customizer dependency control contexts.
		add_filter( 'suki/customizer/control_contexts', array( $this, 'add_customizer_control_contexts' ) );

		/**
		 * Meta box
		 */

		// Only include metabox on post add/edit page and term add/edit page.
		global $pagenow;
		if ( in_array( $pagenow, array( 'post.php', 'post-new.php', 'edit-tags.php', 'term.php' ), true ) ) {
			require_once trailingslashit( SUKI_INCLUDES_DIR ) . 'modules/' . self::MODULE_SLUG . '/class-suki-page-settings-meta-box.php';
		}

		/**
		 * Frontend
		 */

		// Override page settings value with individual page setting values.
		add_filter( 'suki/page_settings/setting_value', array( $this, 'override_page_settings_value' ), 10, 3 );
	}

	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

	/**
	 * Override page settings value with individual page setting values.
	 *
	 * @param mixed  $value     Setting value.
	 * @param string $key       Setting key.
	 * @param string $page_type Page type.
	 * @return mixed
	 */
	public function override_page_settings_value( $value, $key, $page_type ) {
		// Error 404.
		if ( 'error_404' === $page_type ) {
			// Some fixed values.
			switch ( $key ) {
				case 'hero':
					$value = 0;
					break;

				case 'content_container':
					$value = 'narrow';
					break;

				case 'content_layout':
					$value = 'wide';
					break;
			}
		}

		// Singular pages.
		if ( '_single' === substr( $page_type, -7 ) ) {
			$post_type = str_replace( '_single', '', $page_type );

			// Get the singular object.
			$obj = get_queried_object();

			// Get the individual page settings for current singular object.
			$individual_settings = wp_parse_args( get_post_meta( $obj->ID, '_suki_page_settings', true ), array() );

			// Override with individual value (if set).
			if ( isset( $individual_settings[ $key ] ) ) {
				$value = $individual_settings[ $key ];
			}
		}

		// Archive pages.
		if ( '_archive' === substr( $page_type, -8 ) ) {
			$post_type = str_replace( '_archive', '', $page_type );

			if ( is_tax() || is_category() || is_tag() ) {
				$obj = get_queried_object();

				if ( $obj ) {
					// Get the individual page settings for current taxonomy term.
					$individual_settings = wp_parse_args( get_term_meta( $obj->term_id, 'suki_page_settings', true ), array() );

					// Override with individual value (if set).
					if ( isset( $individual_settings[ $key ] ) ) {
						$value = $individual_settings[ $key ];
					}
				}
			}
		}

		return $value;
	}

	/**
	 * Add Customizer options.
	 *
	 * @param WP_Customize_Manager $wp_customize WP_Customize_Manager object.
	 */
	public function add_customizer_settings( $wp_customize ) {
		$defaults = Suki_Customizer::instance()->get_setting_defaults();

		require_once trailingslashit( SUKI_INCLUDES_DIR ) . 'modules/' . self::MODULE_SLUG . '/customizer/options/all-page-settings.php';
	}

	/**
	 * Add Customizer dependency control contexts.
	 *
	 * @param array $contexts Dependency contexts.
	 * @return array
	 */
	public function add_customizer_control_contexts( $contexts = array() ) {
		$add = include trailingslashit( SUKI_INCLUDES_DIR ) . 'modules/' . self::MODULE_SLUG . '/customizer/contexts.php';

		return array_merge_recursive( $contexts, $add );
	}
}

Suki_Page_Settings::instance();
