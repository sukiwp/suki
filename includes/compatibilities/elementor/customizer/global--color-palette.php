<?php
/**
 * Customizer settings: Global Modules > Color Palette
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$section = 'suki_section_color_palette';

/**
 * ====================================================
 * Elementor Integration
 * ====================================================
 */

// Heading: Elementor Integration.
$wp_customize->add_control(
	new Suki_Customize_Heading_Control(
		$wp_customize,
		'heading_color_palette_elementor',
		array(
			'section'  => $section,
			'settings' => array(),
			'label'    => esc_html__( 'Elementor Integration', 'suki' ),
			'priority' => 30,
		)
	)
);

// Apply to Elementor color picker.
$wp_customize->add_control(
	new Suki_Customize_FreeText_Control(
		$wp_customize,
		'apply_color_palette_to_elementor',
		array(
			'section'     => $section,
			'settings'    => array(),
			'description' => '<button class="suki-apply-color-palette-to-elementor button button-secondary">' . esc_html__( 'Apply to Elementor color picker', 'suki' ) . '</button><br><br>' . esc_html__( 'Pressing this button will replace the existing Elementor color picker with the colors you defined above. You can still change and edit Elementor color picker like usual.', 'suki' ),
			'priority'    => 30,
		)
	)
);
