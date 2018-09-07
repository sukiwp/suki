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
	 * Content & Sidebar
	 * ====================================================
	 */

	// Heading: Content & Sidebar
	$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_page_settings_' . $type . '_content', array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => esc_html__( 'Content & Sidebar', 'suki' ),
		'priority'    => 10,
	) ) );

	// Layout
	$key = 'content_container';
	$id = $option_key . '[' . $key . ']';
	$wp_customize->add_setting( $id, array(
		'default'     => suki_array_value( $default, $key ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
	) );
	$wp_customize->add_control( $id, array(
		'type'        => 'select',
		'section'     => $section,
		'label'       => esc_html__( 'Layout', 'suki' ),
		'choices'     => array(
			''                   => esc_html__( 'Default', 'suki' ),
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
		'default'     => suki_array_value( $default, $key ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
	) );
	$wp_customize->add_control( $id, array(
		'type'        => 'select',
		'section'     => $section,
		'label'       => esc_html__( 'Content & sidebar layout', 'suki' ),
		'choices'     => array(
			''              => esc_html__( 'Default', 'suki' ),
			'wide'          => esc_html__( 'Full content, no sidebar', 'suki' ),
			'narrow'        => esc_html__( 'Narrow content, no sidebar', 'suki' ),
			'left-sidebar'  => is_rtl() ? esc_html__( 'Right sidebar', 'suki' ) : esc_html__( 'Left sidebar', 'suki' ),
			'right-sidebar' => is_rtl() ? esc_html__( 'Left sidebar', 'suki' ) : esc_html__( 'Right sidebar', 'suki' ),
		),
		'priority'    => 10,
	) );

	// Options specifically for singular page types.
	if ( false !== strpos( $type, '_singular' ) ) {
		// Hide post title
		$key = 'content_hide_title';
		$id = $option_key . '[' . $key . ']';
		$wp_customize->add_setting( $id, array(
			'default'     => suki_array_value( $default, $key ),
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
		) );
		$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $id, array(
			'section'     => $section,
			'label'       => esc_html__( 'Hide post title', 'suki' ),
			'priority'    => 10,
		) ) );

		// Hide featured image
		$key = 'content_hide_thumbnail';
		$id = $option_key . '[' . $key . ']';
		$wp_customize->add_setting( $id, array(
			'default'     => suki_array_value( $default, $key ),
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
		) );
		$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $id, array(
			'section'     => $section,
			'label'       => esc_html__( 'Hide featured image', 'suki' ),
			'priority'    => 10,
		) ) );
	}

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


	// Background image
	$key = 'page_header_bg';
	$id = $option_key . '[' . $key . ']';
	if ( false !== strpos( $type, '_singular' ) ) {
		$post_type_object = get_post_type_object( str_replace( '_singular', '', $type ) );
		$choices = array(
			/* translators: %s: plural post type name */
			'archive'   => sprintf( esc_html__( 'Same as %s archive background image', 'suki' ), $post_type_object->labels->name ),
			/* translators: %s: singular post type name */
			'thumbnail' => sprintf( esc_html__( 'Use %s featured image as background', 'suki' ), $post_type_object->labels->singular_name ),
		);
	} else {
		$choices = array(
			'custom'    => esc_html__( 'Custom background image', 'suki' ),
		);
	}
	$wp_customize->add_setting( $id, array(
		'default'     => suki_array_value( $default, $key ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
	) );
	$wp_customize->add_control( $id, array(
		'type'        => 'select',
		'section'     => $section,
		'label'       => esc_html__( 'Background image', 'suki' ),
		'choices'     => array_merge(
			array( '' => esc_html__( 'Default', 'suki' ) ),
			$choices
		),
		'priority'    => 30,
	) );

	// Options specifically for non singular page types.
	if ( false === strpos( $type, '_singular' ) ) {
		// Custom background image
		$key = 'page_header_bg_image';
		$id = $option_key . '[' . $key . ']';
		$wp_customize->add_setting( $id, array(
			'default'     => suki_array_value( $default, $key ),
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'image' ),
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $id, array(
			'section'     => $section,
			'mime_type'   => 'image',
			'priority'    => 30,
		) ) );
	}

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