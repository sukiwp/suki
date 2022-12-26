<?php
/**
 * Suki module: Page Settings
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
 * Page Settings module class.
 */
class Suki_Page_Settings extends Suki_Module {
	/**
	 * Module name
	 *
	 * @var string
	 */
	const MODULE_SLUG = 'page-settings';

	/**
	 * Post meta key
	 *
	 * @var string
	 */
	const META_KEY = 'suki_page_settings';

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
		 * Data
		 */

		// Register meta.
		add_action( 'init', array( $this, 'register_meta' ) );

		/**
		 * Customizer settings & values
		 */

		// Add Customizer options.
		add_action( 'customize_register', array( $this, 'add_customizer_settings' ) );

		// Add Customizer dependency control contexts.
		add_filter( 'suki/customizer/control_contexts', array( $this, 'add_customizer_control_contexts' ) );

		/**
		 * Frontend
		 */

		// Override page settings value with individual page setting values.
		add_filter( 'suki/page_settings/setting_value', array( $this, 'override_page_settings_value' ), 10, 3 );

		/**
		 * Meta box
		 */

		if ( is_admin() ) {
			require_once trailingslashit( SUKI_INCLUDES_DIR ) . 'modules/' . self::MODULE_SLUG . '/class-suki-page-settings-meta-box.php';
		}
	}

	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

	/**
	 * Register meta data for posts and terms.
	 */
	public function register_meta() {
		foreach ( suki_get_public_post_types() as $post_type ) {
			register_post_meta(
				$post_type,
				self::META_KEY,
				array(
					'type'          => 'object', // Associative array requires JSON format.
					'single'        => true,
					'default'       => array(),
					'auth_callback' => function () {
						return current_user_can( 'edit_posts' );
					},
					'show_in_rest'  => array(
						'schema' => array(
							'type'                 => 'object',
							'additionalProperties' => array(
								'type' => 'string',
							),
						),
					),
				)
			);
		}
	}

	/**
	 * Override page settings value with individual page setting values which is configured via meta box.
	 *
	 * @param mixed  $value                Setting value.
	 * @param string $key                  Setting key.
	 * @param string $current_page_context Page type.
	 * @return mixed
	 */
	public function override_page_settings_value( $value, $key, $current_page_context ) {
		// Singular pages.
		if ( '_single' === substr( $current_page_context, -7 ) ) {
			// Get the singular object.
			$post = get_queried_object();

			if ( ! empty( $post ) ) {
				// Get the individual page settings for current singular object.
				$individual_settings = wp_parse_args( get_post_meta( $post->ID, self::META_KEY, true ), array() );

				// Override with individual value (if set).
				if ( isset( $individual_settings[ $key ] ) ) {
					$value = $individual_settings[ $key ];
				}
			}
		}

		// Archive pages.
		if ( '_archive' === substr( $current_page_context, -8 ) ) {
			if ( is_tax() || is_category() || is_tag() ) {
				$term = get_queried_object();

				if ( ! empty( $term ) ) {
					// Get the individual page settings for current taxonomy term.
					$individual_settings = wp_parse_args( get_term_meta( $term->term_id, self::META_KEY, true ), array() );

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

		require_once trailingslashit( SUKI_INCLUDES_DIR ) . 'modules/' . self::MODULE_SLUG . '/customizer/structures/all-page-settings.php';
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
