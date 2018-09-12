<?php
/**
 * Customizer settings: Header > Header Builder
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * ====================================================
 * Header Builder
 * ====================================================
 */

/**
 * Header elements
 */

// Get control.
$header_elements = $wp_customize->get_control( 'header_elements' );

// Add choices to control.
$header_elements->choices = array_merge( $header_elements->choices, array(
	'shopping-cart-link'     => '<span class="dashicons dashicons-cart"></span>' . esc_html__( 'Cart Link', 'suki' ),
	'shopping-cart-dropdown' => '<span class="dashicons dashicons-cart"></span>' . esc_html__( 'Cart Dropdown', 'suki' ),
) );

/**
 * Mobile Header elements
 */

// Get control.
$header_mobile_elements = $wp_customize->get_control( 'header_mobile_elements' );

// Add choices to control.
$header_mobile_elements->choices = array_merge( $header_mobile_elements->choices, array(
	'shopping-cart-link' => '<span class="dashicons dashicons-cart"></span>' . esc_html__( 'Cart Link', 'suki' ),
) );

// Add limitation rules to control.
$header_mobile_elements->limitations = array_merge( $header_mobile_elements->limitations, array(
	'shopping-cart-link' => array( 'mobile_vertical_top' ),
) );