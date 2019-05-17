<?php
/**
 * Customizer sections
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

// Brizy Integration
$wp_customize->add_section( 'suki_section_brizy', array(
	'title'       => esc_html__( 'Brizy Integration', 'suki' ),
	'priority'    => 199,
) );