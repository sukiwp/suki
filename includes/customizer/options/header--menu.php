<?php
/**
 * Customizer settings: Header > Menu
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'suki_section_header_menu';

/**
 * ====================================================
 * Menu 1
 * ====================================================
 */

// Heading: Menu
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_header_menu_1', array(
	'section'     => $section,
	'settings'    => array(),
	/* translators: %s: Menu element number. */
	'label'       => sprintf( esc_html__( 'Menu %s', 'suki' ), 1 ),
	'description' => '<a href="' . esc_url( add_query_arg( 'autofocus[control]', 'nav_menu_locations[header-menu-1]', remove_query_arg( 'autofocus' ) ) ) . '" class="suki-customize-goto-control button button-secondary">' .
		/* translators: %s: Menu element number. */
		sprintf( esc_html__( 'Setup Menu', 'suki' ), 1 ) . '</a>',
	'priority'    => 10,
) ) );

// Heading: Mobile Menu
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_header_mobile_menu', array(
	'section'     => $section,
	'settings'    => array(),
	/* translators: %s: Menu element number. */
	'label'       => esc_html__( 'Mobile Menu', 'suki' ),
	'description' => '<a href="' . esc_url( add_query_arg( 'autofocus[control]', 'nav_menu_locations[header-mobile-menu]', remove_query_arg( 'autofocus' ) ) ) . '" class="suki-customize-goto-control button button-secondary">' . esc_html__( 'Setup Menu', 'suki' ) . '</a>',
	'priority'    => 20,
) ) );

/**
 * ====================================================
 * Suki Pro Upsell
 * ====================================================
 */

$features = array();
for ( $i = 2; $i <=3; $i++ ) {
	/* translators: %s: Menu element number. */
	$features[] = sprintf( esc_html_x( 'Menu %s', 'Suki Pro upsell', 'suki' ), $i );
}

$features[] = esc_html__( 'Vertical Menu', 'suki' );

if ( suki_show_pro_teaser() ) {
	$wp_customize->add_control( new Suki_Customize_Control_Pro_Teaser( $wp_customize, 'pro_teaser_header_menu', array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => esc_html_x( 'More Options Available in Suki Pro', 'Suki Pro upsell', 'suki' ),
		'url'         => esc_url( add_query_arg( array( 'utm_source' => 'suki-customizer', 'utm_medium' => 'learn-more', 'utm_campaign' => 'theme-upsell' ), SUKI_PRO_WEBSITE_URL ) ),
		'features'    => $features,
		'priority'    => 90,
	) ) );
}