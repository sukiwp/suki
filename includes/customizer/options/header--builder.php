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
$config = suki_get_header_builder_configurations();
$key = 'header_elements';
$settings = array();
foreach ( $config['locations'] as $slug => $label ) {
	$settings[ $slug ] = $key . '_' . $slug;
}
foreach ( $settings as $setting ) {
	$wp_customize->add_setting( $setting, array(
		'default'     => suki_array_value( $defaults, $setting ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'builder' ),
	) );
}
$wp_customize->add_control( new Suki_Customize_Control_Builder( $wp_customize, $key, array(
	'settings'    => $settings,
	'section'     => $section,
	'label'       => esc_html__( 'Desktop Header', 'suki' ),
	'choices'     => $config['choices'],
	'labels'      => $config['locations'],
	'priority'    => 10,
) ) );

// Mobile Header
$config = suki_get_mobile_header_builder_configurations();
$key = 'header_mobile_elements';
$settings = array();
foreach ( $config['locations'] as $slug => $label ) {
	$settings[ $slug ] = $key . '_' . $slug;
}
foreach ( $settings as $setting ) {
	$wp_customize->add_setting( $setting, array(
		'default'     => suki_array_value( $defaults, $setting ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'builder' ),
	) );
}
$wp_customize->add_control( new Suki_Customize_Control_Builder( $wp_customize, $key, array(
	'settings'    => $settings,
	'section'     => $section,
	'label'       => esc_html__( 'Mobile Header', 'suki' ),
	'choices'     => $config['choices'],
	'labels'      => $config['locations'],
	'limitations' => $config['limitations'],
	'priority'    => 10,
) ) );