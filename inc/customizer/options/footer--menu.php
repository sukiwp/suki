<?php
/**
 * Customizer settings: Footer > Menu(s)
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'suki_section_footer_menu';

/**
 * ====================================================
 * Footer Menu
 * ====================================================
 */

// Heading: Menu
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_footer_menu_1', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Footer Menu', 'suki' ),
	'description' => '<a href="' . esc_url( add_query_arg( 'autofocus[control]', 'nav_menu_locations[footer-menu-1]' ) ) . '" class="suki-customize-goto-control button button-secondary">' . esc_html__( 'Edit Footer Menu', 'suki' ) . '</a>',
	'priority'    => 10,
) ) );