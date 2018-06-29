<?php
/**
 * Customizer settings: Header > Menu(s)
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
	/* translators: %d: number of Menu element. */
	'label'       => sprintf( esc_html__( 'Menu %d', 'suki' ), 1 ),
	/* translators: %d: number of Menu element. */
	'description' => '<a href="' . esc_url( add_query_arg( 'autofocus[control]', 'nav_menu_locations[header-menu-1]' ) ) . '" class="suki-customize-goto-control button button-secondary">' . sprintf( esc_html__( 'Edit Header Menu %d', 'suki' ), 1 ) . '</a>',
	'priority'    => 10,
) ) );

/**
 * ====================================================
 * Mobile Menu
 * ====================================================
 */

// Heading: Mobile Header Menu
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_mobile_header_menu', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Mobile Header Menu', 'suki' ),
	'description' => '<a href="' . esc_url( add_query_arg( 'autofocus[control]', 'nav_menu_locations[header-mobile-menu]' ) ) . '" class="suki-customize-goto-control button button-secondary">' . esc_html__( 'Edit Mobile Header Menu', 'suki' ) . '</a>',
	'priority'    => 20,
) ) );

/**
 * ====================================================
 * Suki Pro Upsell
 * ====================================================
 */

if ( suki_show_pro_teaser() ) {
	$wp_customize->add_control( new Suki_Customize_Control_Pro( $wp_customize, 'pro_teaser_header_menu', array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => esc_html_x( 'More Options on Suki Pro', 'Suki Pro upsell', 'suki' ),
		'url'         => SUKI_PRO_URL,
		'features'    => array(
			esc_html_x( 'Additional "Menu 2" element on Header Builder', 'Suki Pro upsell', 'suki' ),
			esc_html_x( 'Additional "Menu 3" element on Header Builder', 'Suki Pro upsell', 'suki' ),
		),
		'priority'    => 90,
	) ) );
}