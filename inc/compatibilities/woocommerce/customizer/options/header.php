<?php
/**
 * Customizer settings: Header > Shopping Cart
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'suki_section_header_shopping_cart';

/**
 * ====================================================
 * Header Builder
 * ====================================================
 */

// Add Shopping Cart section
$wp_customize->add_section( $section, array(
	'title'       => esc_html__( 'Element: Shopping Cart', 'suki' ),
	'panel'       => $panel,
	'priority'    => 40,
) );

// Add Header elements
$wp_customize->get_control( 'header_elements' )->choices = array_merge(
	$wp_customize->get_control( 'header_elements' )->choices,
	array(
		'shopping-cart-link'     => '<span class="dashicons dashicons-cart"></span>' . esc_html__( 'Cart Link', 'suki' ),
		'shopping-cart-dropdown' => '<span class="dashicons dashicons-cart"></span>' . esc_html__( 'Cart Dropdown', 'suki' ),
	)
);

// Add Mobile Header elements
$wp_customize->get_control( 'header_mobile_elements' )->choices = array_merge(
	$wp_customize->get_control( 'header_mobile_elements' )->choices,
	array(
		'shopping-cart-link'     => '<span class="dashicons dashicons-cart"></span>' . esc_html__( 'Cart Link', 'suki' ),
	)
);