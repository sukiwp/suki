<?php
/**
 * Customizer settings: Page Settings
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

foreach ( Suki_Customizer::instance()->get_all_page_settings_types() as $type => $type_data ) {
	$section = 'suki_section_page_settings_' . $type;
	$option_key = 'page_settings_' . $type;

	// Get default value (array) of the option key.
	$default = suki_array_value( $defaults, $option_key, array() );
	if ( ! is_array( $default ) ) {
		$default = array();
	}

	/**
	 * ====================================================
	 * Content
	 * ====================================================
	 */

	// Heading: Content
	$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_page_settings_' . $type . '_content', array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => esc_html__( 'Content', 'suki' ),
		'priority'    => 10,
	) ) );

	// Section layout
	$key = 'content_container';
	$id = $option_key . '[' . $key . ']';
	$wp_customize->add_setting( $id, array(
		'default'     => suki_array_value( $default, $key, 'default' ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
	) );
	$wp_customize->add_control( $id, array(
		'type'        => 'select',
		'section'     => $section,
		'label'       => esc_html__( 'Section layout', 'suki' ),
		'choices'     => array(
			'default'            => esc_html__( 'Full width section, wrapped content', 'suki' ),
			'full-width'         => esc_html__( 'Full width content', 'suki' ),
			'full-width-padding' => esc_html__( 'Full width content with side padding', 'suki' ),
		),
		'priority'    => 10,
	) );

	// Content & sidebar layout
	$key = 'content_layout';
	$id = $option_key . '[' . $key . ']';
	$wp_customize->add_setting( $id, array(
		'default'     => suki_array_value( $default, $key, 'right-sidebar' ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
	) );
	$wp_customize->add_control( $id, array(
		'type'        => 'select',
		'section'     => $section,
		'label'       => esc_html__( 'Content & sidebar layout', 'suki' ),
		'choices'     => array(
			'wide'          => esc_html__( 'Full content', 'suki' ),
			'narrow'        => esc_html__( 'Narrow content', 'suki' ),
			'left-sidebar'  => is_rtl() ? esc_html__( 'Right sidebar', 'suki' ) : esc_html__( 'Left sidebar', 'suki' ),
			'right-sidebar' => is_rtl() ? esc_html__( 'Left sidebar', 'suki' ) : esc_html__( 'Right sidebar', 'suki' ),
		),
		'priority'    => 10,
	) );

	/**
	 * ====================================================
	 * Header
	 * ====================================================
	 */

	// Heading: Header
	$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_page_settings_' . $type . '_header', array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => esc_html__( 'Header', 'suki' ),
		'priority'    => 20,
	) ) );

	// Disable main header
	$key = 'disable_header';
	$id = $option_key . '[' . $key . ']';
	$wp_customize->add_setting( $id, array(
		'default'     => suki_array_value( $default, $key ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
	) );
	$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $id, array(
		'section'     => $section,
		'label'       => esc_html__( 'Disable main header', 'suki' ),
		'priority'    => 20,
	) ) );

	// Disable mobile header
	$key = 'disable_mobile_header';
	$id = $option_key . '[' . $key . ']';
	$wp_customize->add_setting( $id, array(
		'default'     => suki_array_value( $default, $key ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
	) );
	$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $id, array(
		'section'     => $section,
		'label'       => esc_html__( 'Disable mobile header', 'suki' ),
		'priority'    => 20,
	) ) );

	/**
	 * ====================================================
	 * Page Header (Title Bar)
	 * ====================================================
	 */

	// Heading: Page Header (Title Bar)
	$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_page_settings_' . $type . '_page_header', array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => esc_html__( 'Page Header (Title Bar)', 'suki' ),
		'priority'    => 30,
	) ) );

	// Disable page header
	$key = 'disable_page_header';
	$id = $option_key . '[' . $key . ']';
	$wp_customize->add_setting( $id, array(
		'default'     => suki_array_value( $default, $key ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
	) );
	$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $id, array(
		'section'     => $section,
		'label'       => esc_html__( 'Disable page header', 'suki' ),
		'priority'    => 30,
	) ) );

	// ------
	$wp_customize->add_control( new Suki_Customize_Control_HR( $wp_customize, 'hr_page_settings_' . $type . '_page_header_title', array(
		'section'     => $section,
		'settings'    => array(),
		'priority'    => 30,
	) ) );

	// Custom page title
	$key = 'page_header_page_title';
	$id = $option_key . '[' . $key . ']';
	$wp_customize->add_setting( $id, array(
		'default'     => suki_array_value( $default, $key ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'text' ),
	) );
	$wp_customize->add_control( $id, array(
		'section'     => $section,
		'label'       => esc_html__( 'Override default page title text', 'suki' ),
		'description' => esc_html__( 'Default page title text is generated by native WordPress functions. Use this option to display custom page title text. Available syntax: {{object}}.', 'suki' ),
		'priority'    => 30,
	) );

	// Keep main content title displayed
	$key = 'page_header_keep_content_header';
	$id = $option_key . '[' . $key . ']';
	$wp_customize->add_setting( $id, array(
		'default'     => suki_array_value( $default, $key ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
	) );
	$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $id, array(
		'section'     => $section,
		'label'       => esc_html__( 'Keep main content title displayed', 'suki' ),
		'description' => esc_html__( 'By default, when page header is active, the page title on content section would be hidden. Enabling this would make the page title on content section remains displayed.', 'suki' ),
		'priority'    => 30,
	) ) );

	// ------
	$wp_customize->add_control( new Suki_Customize_Control_HR( $wp_customize, 'hr_page_settings_' . $type . '_page_header_bg', array(
		'section'     => $section,
		'settings'    => array(),
		'priority'    => 30,
	) ) );

	// Override background image
	$key = 'page_header_bg_image';
	$id = $option_key . '[' . $key . ']';
	$wp_customize->add_setting( $id, array(
		'default'     => suki_array_value( $default, $key ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'image' ),
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $id, array(
		'section'     => $section,
		'label'       => esc_html__( 'Override background image', 'suki' ),
		'description' => esc_html__( 'Thus will override the global background image you set on Page Header.', 'suki' ),
		'mime_type'   => 'image',
		'priority'    => 30,
	) ) );

	// Override background position
	$key = 'page_header_bg_position';
	$id = $option_key . '[' . $key . ']';
	$wp_customize->add_setting( $id, array(
		'default'     => suki_array_value( $default, $key ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
	) );
	$wp_customize->add_control( $id, array(
		'type'        => 'select',
		'section'     => $section,
		'label'       => esc_html__( 'Override background position', 'suki' ),
		'choices'     => array(
			''              => esc_html__( 'Default', 'suki' ),
			'left top'      => esc_html__( 'Left top', 'suki' ),
			'left center'   => esc_html__( 'Left center', 'suki' ),
			'left bottom'   => esc_html__( 'Left bottom', 'suki' ),
			'center top'    => esc_html__( 'Center top', 'suki' ),
			'center center' => esc_html__( 'Center center', 'suki' ),
			'center bottom' => esc_html__( 'Center bottom', 'suki' ),
			'right top'     => esc_html__( 'Right top', 'suki' ),
			'right center'  => esc_html__( 'Right center', 'suki' ),
			'right bottom'  => esc_html__( 'Right bottom', 'suki' ),
		),
		'priority'    => 30,
	) );

	// Override background size
	$key = 'page_header_bg_size';
	$id = $option_key . '[' . $key . ']';
	$wp_customize->add_setting( $id, array(
		'default'     => suki_array_value( $default, $key ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
	) );
	$wp_customize->add_control( $id, array(
		'type'        => 'select',
		'section'     => $section,
		'label'       => esc_html__( 'Override background size', 'suki' ),
		'choices'     => array(
			''        => esc_html__( 'Default', 'suki' ),
			'auto'    => esc_html__( 'Default', 'suki' ),
			'cover'   => esc_html__( 'Cover', 'suki' ),
			'contain' => esc_html__( 'Contain', 'suki' ),
		),
		'priority'    => 30,
	) );

	// Override background repeat
	$key = 'page_header_bg_repeat';
	$id = $option_key . '[' . $key . ']';
	$wp_customize->add_setting( $id, array(
		'default'     => suki_array_value( $default, $key ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
	) );
	$wp_customize->add_control( $id, array(
		'type'        => 'select',
		'section'     => $section,
		'label'       => esc_html__( 'Override background repeat', 'suki' ),
		'choices'     => array(
			''          => esc_html__( 'Default', 'suki' ),
			'no-repeat' => esc_html__( 'No repeat', 'suki' ),
			'repeat-x'  => esc_html__( 'Repeat X (horizontally)', 'suki' ),
			'repeat-y'  => esc_html__( 'Repeat Y (vertically)', 'suki' ),
			'repeat'    => esc_html__( 'Repeat both axis', 'suki' ),
		),
		'priority'    => 30,
	) );

	// Override background attachment
	$key = 'page_header_bg_attachment';
	$id = $option_key . '[' . $key . ']';
	$wp_customize->add_setting( $id, array(
		'default'     => suki_array_value( $default, $key ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
	) );
	$wp_customize->add_control( $id, array(
		'type'        => 'select',
		'section'     => $section,
		'label'       => esc_html__( 'Override background attachment', 'suki' ),
		'choices'     => array(
			''       => esc_html__( 'Default', 'suki' ),
			'scroll' => esc_html__( 'Scroll', 'suki' ),
			'fixed'  => esc_html__( 'Fixed', 'suki' ),
		),
		'priority'    => 30,
	) );

	// Override background overlay
	$key = 'page_header_bg_overlay_opacity'; 
	$id = $option_key . '[' . $key . ']';
	$wp_customize->add_setting( $id, array(
		'default'     => suki_array_value( $default, $key ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'slider' ),
	) );
	$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $id, array(
		'section'     => $section,
		'label'       => esc_html__( 'Override background overlay opacity', 'suki' ),
		'units'       => array(
			'' => array(
				'min'  => 0,
				'max'  => 1,
				'step' => 0.05,
			),
		),
		'hide_units'  => true,
		'priority'    => 30,
	) ) );

	/**
	 * ====================================================
	 * Footer
	 * ====================================================
	 */

	// Heading: Footer
	$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_page_settings_' . $type . '_footer', array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => esc_html__( 'Footer', 'suki' ),
		'priority'    => 40,
	) ) );

	// Disable footer widgets
	$key = 'disable_footer_widgets';
	$id = $option_key . '[' . $key . ']';
	$wp_customize->add_setting( $id, array(
		'default'     => suki_array_value( $default, $key ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
	) );
	$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $id, array(
		'section'     => $section,
		'label'       => esc_html__( 'Disable footer widgets', 'suki' ),
		'priority'    => 40,
	) ) );

	// Disable footer bottom
	$key = 'disable_footer_bottom';
	$id = $option_key . '[' . $key . ']';
	$wp_customize->add_setting( $id, array(
		'default'     => suki_array_value( $default, $key ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
	) );
	$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $id, array(
		'section'     => $section,
		'label'       => esc_html__( 'Disable footer bottom', 'suki' ),
		'priority'    => 40,
	) ) );

	/**
	 * ====================================================
	 * Suki Pro Upsell
	 * ====================================================
	 */

	if ( suki_show_pro_teaser() ) {
		$wp_customize->add_control( new Suki_Customize_Control_Pro_Teaser( $wp_customize, 'pro_teaser_page_settings_' . $type, array(
			'section'     => $section,
			'settings'    => array(),
			'label'       => esc_html_x( 'More Options on Suki Pro', 'Suki Pro upsell', 'suki' ),
			'url'         => SUKI_PRO_URL,
			'features'    => array(
				esc_html_x( 'Activate transparent header on this page', 'Suki Pro upsell', 'suki' ),
				esc_html_x( 'Activate alternative header colors on this page', 'Suki Pro upsell', 'suki' ),
			),
			'priority'    => 90,
		) ) );
	}
}