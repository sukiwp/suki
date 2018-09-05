<?php
/**
 * Customizer sections: Gutenberg
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$panel = 'suki_panel_global_elements';

// ------
$wp_customize->add_section( new Suki_Customize_Section_Spacer( $wp_customize, 'suki_section_spacer_gutenberg', array(
	'panel'       => $panel,
	'priority'    => 20,
) ) );

// Gutenberg Elements
$wp_customize->add_section( 'suki_section_gutenberg', array(
	'title'       => esc_html__( 'Gutenberg Elements', 'suki' ),
	'description' => sprintf(
		/* translators: %s: link to "Page Settings" section. */
		esc_html__( 'Best content layout for Gutenberg is "Narrow content". You can activate the "Narrow content" layout on each page type via %s.', 'suki' ),
		'<a href="' . esc_url( add_query_arg( 'autofocus[panel]', 'suki_panel_page_settings' ) ) . '" class="suki-customize-goto-control">' . esc_html__( 'Page Settings', 'suki' ) . '</a>'
	),
	'panel'       => $panel,
	'priority'    => 20,
) );