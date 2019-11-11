<?php
/**
 * Customizer settings: Header > Header Builder
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'suki_section_header_builder';

/**
 * ====================================================
 * Builder
 * ====================================================
 */

ob_start(); ?>
<div class="suki-responsive-switcher nav-tab-wrapper wp-clearfix">
	<a href="#" class="nav-tab preview-desktop suki-responsive-switcher-button" data-device="desktop">
		<span class="dashicons dashicons-desktop"></span>
		<span><?php esc_html_e( 'Desktop', 'suki' ); ?></span>
	</a>
	<a href="#" class="nav-tab preview-tablet preview-mobile suki-responsive-switcher-button" data-device="tablet">
		<span class="dashicons dashicons-smartphone"></span>
		<span><?php esc_html_e( 'Tablet / Mobile', 'suki' ); ?></span>
	</a>
</div>
<span class="button button-secondary suki-builder-hide suki-builder-toggle"><span class="dashicons dashicons-no"></span><?php esc_html_e( 'Hide', 'suki' ); ?></span>
<span class="button button-primary suki-builder-show suki-builder-toggle"><span class="dashicons dashicons-edit"></span><?php esc_html_e( 'Header Builder', 'suki' ); ?></span>
<?php $switcher = ob_get_clean();

// --- Blank: Header Builder Switcher
$wp_customize->add_control( new Suki_Customize_Control_Blank( $wp_customize, 'header_builder_actions', array(
	'section'     => $section,
	'settings'    => array(),
	'description' => $switcher,
	'priority'    => 10,
) ) );

// Desktop Header
$settings = array(
	'top_left'      => 'header_elements_top_left',
	'top_center'    => 'header_elements_top_center',
	'top_right'     => 'header_elements_top_right',
	'main_left'     => 'header_elements_main_left',
	'main_center'   => 'header_elements_main_center',
	'main_right'    => 'header_elements_main_right',
	'bottom_left'   => 'header_elements_bottom_left',
	'bottom_center' => 'header_elements_bottom_center',
	'bottom_right'  => 'header_elements_bottom_right',
);
foreach ( $settings as $key ) {
	$wp_customize->add_setting( $key, array(
		'default'     => suki_array_value( $defaults, $key ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'builder' ),
	) );
}
$wp_customize->add_control( new Suki_Customize_Control_Builder( $wp_customize, 'header_elements', array(
	'settings'    => $settings,
	'section'     => $section,
	'label'       => esc_html__( 'Desktop Header', 'suki' ),
	'choices'     => array(
		'logo'                   => '<span class="dashicons dashicons-admin-home"></span>' . esc_html__( 'Logo', 'suki' ),
		/* translators: %s: instance number. */
		'menu-1'                 => '<span class="dashicons dashicons-admin-links"></span>' . sprintf( esc_html__( 'Menu %s', 'suki' ), 1 ),
		/* translators: %s: instance number. */
		'html-1'                 => '<span class="dashicons dashicons-editor-code"></span>' . sprintf( esc_html__( 'HTML %s', 'suki' ), 1 ),
		'search-bar'             => '<span class="dashicons dashicons-search"></span>' . esc_html__( 'Search Bar', 'suki' ),
		'search-dropdown'        => '<span class="dashicons dashicons-search"></span>' . esc_html__( 'Search Dropdown', 'suki' ),
		'shopping-cart-link'     => '<span class="dashicons dashicons-cart"></span>' . esc_html__( 'Cart Link', 'suki' ),
		'shopping-cart-dropdown' => '<span class="dashicons dashicons-cart"></span>' . esc_html__( 'Cart Dropdown', 'suki' ),
		'social'                 => '<span class="dashicons dashicons-twitter"></span>' . esc_html__( 'Social', 'suki' ),
	),
	'labels'      => array(
		'top_left'      => is_rtl() ? esc_html__( 'Top - Right', 'suki' ) : esc_html__( 'Top - Left', 'suki' ),
		'top_center'    => esc_html__( 'Top - Center', 'suki' ),
		'top_right'     => is_rtl() ? esc_html__( 'Top - Left', 'suki' ) : esc_html__( 'Top - Right', 'suki' ),
		'main_left'     => is_rtl() ? esc_html__( 'Main - Right', 'suki' ) : esc_html__( 'Main - Left', 'suki' ),
		'main_center'   => esc_html__( 'Main - Center', 'suki' ),
		'main_right'    => is_rtl() ? esc_html__( 'Main - Left', 'suki' ) : esc_html__( 'Main - Right', 'suki' ),
		'bottom_left'   => is_rtl() ? esc_html__( 'Bottom - Right', 'suki' ) : esc_html__( 'Bottom - Left', 'suki' ),
		'bottom_center' => esc_html__( 'Bottom - Center', 'suki' ),
		'bottom_right'  => is_rtl() ? esc_html__( 'Bottom - Left', 'suki' ) : esc_html__( 'Bottom - Right', 'suki' ),
	),
	'priority'    => 10,
) ) );

// Mobile Header
$settings = array(
	'mobile_main_left'    => 'header_mobile_elements_main_left',
	'mobile_main_center'  => 'header_mobile_elements_main_center',
	'mobile_main_right'   => 'header_mobile_elements_main_right',
	'mobile_vertical_top' => 'header_mobile_elements_vertical_top',
);
foreach ( $settings as $key ) {
	$wp_customize->add_setting( $key, array(
		'default'     => suki_array_value( $defaults, $key ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'builder' ),
	) );
}
$wp_customize->add_control( new Suki_Customize_Control_Builder( $wp_customize, 'header_mobile_elements', array(
	'settings'    => $settings,
	'section'     => $section,
	'label'       => esc_html__( 'Mobile Header', 'suki' ),
	'choices'     => array(
		'mobile-logo'            => '<span class="dashicons dashicons-admin-home"></span>' . esc_html__( 'Mobile Logo', 'suki' ),
		'mobile-menu'            => '<span class="dashicons dashicons-admin-links"></span>' . esc_html__( 'Mobile Menu', 'suki' ),
		/* translators: %s: instance number. */
		'html-1'                 => '<span class="dashicons dashicons-editor-code"></span>' . sprintf( esc_html__( 'HTML %s', 'suki' ), 1 ),
		'search-bar'             => '<span class="dashicons dashicons-search"></span>' . esc_html__( 'Search Bar', 'suki' ),
		'search-dropdown'        => '<span class="dashicons dashicons-search"></span>' . esc_html__( 'Search Icon', 'suki' ),
		'shopping-cart-link'     => '<span class="dashicons dashicons-cart"></span>' . esc_html__( 'Cart Link', 'suki' ),
		'social'                 => '<span class="dashicons dashicons-twitter"></span>' . esc_html__( 'Social', 'suki' ),
		'mobile-vertical-toggle' => '<span class="dashicons dashicons-menu"></span>' . esc_html__( 'Toggle', 'suki' ),
	),
	'labels'      => array(
		'mobile_main_left'    => is_rtl() ? esc_html__( 'Right', 'suki' ) : esc_html__( 'Left', 'suki' ),
		'mobile_main_center'  => esc_html__( 'Center', 'suki' ),
		'mobile_main_right'   => is_rtl() ? esc_html__( 'Left', 'suki' ) : esc_html__( 'Right', 'suki' ),
		'mobile_vertical_top' => esc_html__( 'Drawer (Popup)', 'suki' ),
	),
	'limitations' => array(
		'mobile-logo'            => array( 'mobile_vertical_top' ),
		'mobile-menu'            => array( 'mobile_main_left', 'mobile_main_center', 'mobile_main_right' ),
		'search-bar'             => array( 'mobile_main_left', 'mobile_main_center', 'mobile_main_right' ),
		'search-dropdown'        => array( 'mobile_vertical_top' ),
		'shopping-cart-link'     => array( 'mobile_vertical_top' ),
		'mobile-vertical-toggle' => array( 'mobile_vertical_top' ),
	),
	'priority'    => 10,
) ) );