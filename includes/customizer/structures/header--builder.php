<?php
/**
 * Customizer settings: Header > Header Builder
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$section = 'suki_section_header_builder';

/**
 * ====================================================
 * Responsive switcher
 * ====================================================
 */

ob_start();
?>
<div class="suki-header-builder-responsive-switcher nav-tab-wrapper wp-clearfix">
	<button class="nav-tab preview-desktop nav-tab-active" data-device="desktop">
		<span class="dashicons dashicons-desktop"></span>
		<span><?php esc_html_e( 'Desktop', 'suki' ); ?></span>
	</button>
	<button class="nav-tab preview-tablet preview-mobile" data-device="tablet">
		<span class="dashicons dashicons-smartphone"></span>
		<span><?php esc_html_e( 'Tablet / Mobile', 'suki' ); ?></span>
	</button>
</div>
<script>
	const buttons = document.querySelectorAll( '.suki-header-builder-responsive-switcher > button' );

	buttons.forEach( ( button ) => {
		button.addEventListener( 'click', ( e ) => {
			e.preventDefault();
			wp.customize.previewedDevice.set( button.getAttribute( 'data-device' ) );
		} );
	} );

	wp.customize.bind( 'ready', function() {
		wp.customize.previewedDevice.bind( ( device ) => {
			const targetDevice = 'desktop' === device ? 'desktop' : 'tablet';

			buttons.forEach( ( button ) => {
				if ( targetDevice === button.getAttribute( 'data-device' ) ) {
					button.classList.add( 'nav-tab-active' );
				} else {
					button.classList.remove( 'nav-tab-active' );
				}
			} );
		} );
	} );
</script>
<?php
$switcher = ob_get_clean();

// --- Header Builder Switcher
$wp_customize->add_control(
	new Suki_Customize_FreeText_Control(
		$wp_customize,
		'header_builder_switcher',
		array(
			'section'     => $section,
			'settings'    => array(),
			'description' => $switcher,
			'priority'    => 10,
		)
	)
);

/**
 * ====================================================
 * Desktop Header
 * ====================================================
 */

/**
 * Filter: suki/dataset/header_builder/areas
 *
 * @param array Array of areas for Header Builder.
 */
$desktop_areas = apply_filters(
	'suki/dataset/header_builder/areas',
	array(
		'top_left'      => esc_html__( 'Top - Left', 'suki' ),
		'top_center'    => esc_html__( 'Top - Center', 'suki' ),
		'top_right'     => esc_html__( 'Top - Right', 'suki' ),
		'main_left'     => esc_html__( 'Main - Left', 'suki' ),
		'main_center'   => esc_html__( 'Main - Center', 'suki' ),
		'main_right'    => esc_html__( 'Main - Right', 'suki' ),
		'bottom_left'   => esc_html__( 'Bottom - Left', 'suki' ),
		'bottom_center' => esc_html__( 'Bottom - Center', 'suki' ),
		'bottom_right'  => esc_html__( 'Bottom - Right', 'suki' ),
	)
);

/**
 * Filter: suki/dataset/header_builder/elements
 *
 * @param array Array of elements for Header Builder.
 */
$desktop_choices = apply_filters(
	'suki/dataset/header_builder/elements',
	array(
		'logo'            => array(
			'icon'              => 'admin-home',
			'label'             => esc_html__( 'Logo', 'suki' ),
			'unsupported_areas' => array(),
		),
		'menu-1'          => array(
			'icon'              => 'admin-links',
			/* translators: %s: instance number. */
			'label'             => sprintf( esc_html__( 'Menu %s', 'suki' ), 1 ),
			'unsupported_areas' => array(),
		),
		'html-1'          => array(
			'icon'              => 'editor-code',
			/* translators: %s: instance number. */
			'label'             => sprintf( esc_html__( 'HTML %s', 'suki' ), 1 ),
			'unsupported_areas' => array(),
		),
		'search-bar'      => array(
			'icon'              => 'search',
			'label'             => esc_html__( 'Search Bar', 'suki' ),
			'unsupported_areas' => array(),
		),
		'search-dropdown' => array(
			'icon'              => 'search',
			'label'             => esc_html__( 'Search Dropdown', 'suki' ),
			'unsupported_areas' => array(),
		),
		'social'          => array(
			'icon'              => 'twitter',
			'label'             => esc_html__( 'Social', 'suki' ),
			'unsupported_areas' => array(),
		),
	)
);

// Desktop Header.
$key      = 'header_elements';
$settings = array();
foreach ( $desktop_areas as $slug => $label ) {
	$settings[ $slug ] = $key . '_' . $slug;
}
foreach ( $settings as $setting ) {
	$wp_customize->add_setting(
		$setting,
		array(
			'default'           => suki_array_value( $defaults, $setting ),
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'builder' ),
		)
	);
}
$wp_customize->add_control(
	new Suki_Customize_Builder_Control(
		$wp_customize,
		$key,
		array(
			'settings' => $settings,
			'section'  => $section,
			'label'    => esc_html__( 'Desktop Header', 'suki' ),
			'areas'    => $desktop_areas,
			'choices'  => $desktop_choices,
			'priority' => 10,
		)
	)
);

/**
 * ====================================================
 * Mobile Header
 * ====================================================
 */

/**
 * Filter: suki/dataset/header_mobile_builder/areas
 *
 * @param array Array of areas for Header Builder.
 */
$mobile_areas = apply_filters(
	'suki/dataset/header_mobile_builder/areas',
	array(
		'main_left'    => esc_html__( 'Mobile - Left', 'suki' ),
		'main_center'  => esc_html__( 'Mobile - Center', 'suki' ),
		'main_right'   => esc_html__( 'Mobile - Right', 'suki' ),
		'vertical_top' => esc_html__( 'Mobile - Popup', 'suki' ),
	)
);

/**
 * Filter: suki/dataset/header_mobile_builder/elements
 *
 * @param array Array of elements for Header Builder.
 */
$mobile_choices = apply_filters(
	'suki/dataset/header_mobile_builder/elements',
	array(
		'mobile-logo'         => array(
			'icon'              => 'admin-home',
			'label'             => esc_html__( 'Mobile Logo', 'suki' ),
			'unsupported_areas' => array( 'vertical_top' ),
		),
		'mobile-menu'         => array(
			'icon'              => 'admin-links',
			'label'             => esc_html__( 'Mobile Menu', 'suki' ),
			'unsupported_areas' => array( 'main_left', 'main_center', 'main_right' ),
		),
		'html-1'              => array(
			'icon'              => 'editor-code',
			/* translators: %s: instance number. */
			'label'             => sprintf( esc_html__( 'HTML %s', 'suki' ), 1 ),
			'unsupported_areas' => array(),
		),
		'search-bar'          => array(
			'icon'              => 'search',
			'label'             => esc_html__( 'Search Bar', 'suki' ),
			'unsupported_areas' => array( 'main_left', 'main_center', 'main_right' ),
		),
		'search-dropdown'     => array(
			'icon'              => 'search',
			'label'             => esc_html__( 'Search Dropdown', 'suki' ),
			'unsupported_areas' => array( 'vertical_top' ),
		),
		'social'              => array(
			'icon'              => 'twitter',
			'label'             => esc_html__( 'Social', 'suki' ),
			'unsupported_areas' => array(),
		),
		'mobile-popup-toggle' => array(
			'icon'              => 'menu',
			'label'             => esc_html__( 'Toggle', 'suki' ),
			'unsupported_areas' => array( 'vertical_top' ),
		),
	)
);

// Mobile Header.
$key      = 'header_mobile_elements';
$settings = array();
foreach ( $mobile_areas as $slug => $label ) {
	$settings[ $slug ] = $key . '_' . $slug;
}
foreach ( $settings as $setting ) {
	$wp_customize->add_setting(
		$setting,
		array(
			'default'           => suki_array_value( $defaults, $setting ),
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'builder' ),
		)
	);
}
$wp_customize->add_control(
	new Suki_Customize_Builder_Control(
		$wp_customize,
		$key,
		array(
			'settings' => $settings,
			'section'  => $section,
			'label'    => esc_html__( 'Mobile Header', 'suki' ),
			'areas'    => $mobile_areas,
			'choices'  => $mobile_choices,
			'priority' => 10,
		)
	)
);
