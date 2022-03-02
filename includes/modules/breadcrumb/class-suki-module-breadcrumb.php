<?php
/**
 * Suki module: Breadcrumb
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
 * Breadcrumb module class.
 */
class Suki_Module_Breadcrumb extends Suki_Module {
	/**
	 * Module name
	 *
	 * @var string
	 */
	const MODULE_SLUG = 'breadcrumb';

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

		// Add breadcrumb as Content Header elements on all page types (Customizer).
		foreach ( Suki_Customizer::instance()->get_page_types() as $page_type_key => $page_type_data ) {
			add_filter( 'suki/dataset/' . $page_type_key . '_content_header_elements', array( $this, 'add_content_header_elements' ) );
		}

		// Add breadcrumb as Header Builder elements (Customizer).
		add_filter( 'suki/dataset/header_builder_configurations', array( $this, 'add_header_builder_elements' ) );

		// Add Customizer options.
		add_action( 'customize_register', array( $this, 'add_customizer_settings' ) );

		// Add Customizer default values.
		add_filter( 'suki/customizer/setting_defaults', array( $this, 'add_customizer_setting_defaults' ) );

		// Add Customizer dynamic outputs.
		add_filter( 'suki/customizer/setting_outputs', array( $this, 'add_customizer_setting_outputs' ) );

		// Add Customizer dependency control contexts.
		add_filter( 'suki/customizer/control_contexts', array( $this, 'add_customizer_control_contexts' ) );

		// Add template parts directory.
		add_filter( 'suki/frontend/template_dirs', array( $this, 'add_template_dir' ) );
	}

	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

	/**
	 * Add breadcrumb as Content Header elements.
	 *
	 * @param array $elements Elements array.
	 * @return array
	 */
	public function add_content_header_elements( $elements ) {
		$elements['breadcrumb'] = esc_html__( 'Breadcrumb', 'suki' );

		return $elements;
	}

	/**
	 * Add breadcrumb as Header Builder elements.
	 *
	 * @param array $configurations Configurations array.
	 * @return array
	 */
	public function add_header_builder_elements( $configurations ) {
		$configurations['choices']['breadcrumb'] = '<span class="dashicons dashicons-networking"></span>' . esc_html__( 'Breadcrumb', 'suki' );

		return $configurations;
	}

	/**
	 * Add Customizer options.
	 *
	 * @param WP_Customize_Manager $wp_customize WP_Customize_Manager object.
	 */
	public function add_customizer_settings( $wp_customize ) {
		$defaults = Suki_Customizer::instance()->get_setting_defaults();

		require_once trailingslashit( SUKI_INCLUDES_DIR ) . 'modules/' . self::MODULE_SLUG . '/customizer/options/global--breadcrumb.php';
	}

	/**
	 * Add Customizer default values.
	 *
	 * @param array $defaults Default values.
	 * @return array
	 */
	public function add_customizer_setting_defaults( $defaults = array() ) {
		$add = include trailingslashit( SUKI_INCLUDES_DIR ) . 'modules/' . self::MODULE_SLUG . '/customizer/defaults.php';

		return array_merge_recursive( $defaults, $add );
	}

	/**
	 * Add Customizer Dynamic output rules.
	 *
	 * @param array $outputs Dynamic output rules.
	 * @return array
	 */
	public function add_customizer_setting_outputs( $outputs = array() ) {
		$add = include trailingslashit( SUKI_INCLUDES_DIR ) . 'modules/' . self::MODULE_SLUG . '/customizer/outputs.php';

		return array_merge_recursive( $outputs, $add );
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

	/**
	 * Add template parts directory
	 *
	 * @param array $dirs Directories array.
	 * @return array
	 */
	public function add_template_dir( $dirs ) {
		$dirs[] = trailingslashit( SUKI_INCLUDES_DIR ) . 'modules/' . self::MODULE_SLUG . '/template-parts';

		return $dirs;
	}
}

Suki_Module_Breadcrumb::instance();
