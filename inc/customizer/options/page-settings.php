<?php
/**
 * Customizer settings: Page Settings
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

foreach ( Suki_Customizer::instance()->get_all_page_settings_types() as $ps_type => $ps_data ) {
	$section = 'suki_section_page_settings_' . $ps_type;
	$option_key = 'page_settings_' . $ps_type;

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
	$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_page_settings_' . $ps_type . '_content', array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => esc_html__( 'Content & Sidebar', 'suki' ),
		'priority'    => 10,
	) ) );

	// Layout
	$subkey = 'content_container';
	$key = $option_key . '[' . $subkey . ']';
	$wp_customize->add_setting( $key, array(
		'default'     => suki_array_value( $default, $subkey ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
	) );
	$wp_customize->add_control( $key, array(
		'type'        => 'select',
		'section'     => $section,
		'label'       => esc_html__( 'Layout', 'suki' ),
		'choices'     => array(
			''           => esc_html__( 'Default', 'suki' ),
			'default'    => esc_html__( 'Full width section, wrapped content', 'suki' ),
			'full-width' => esc_html__( 'Full width content', 'suki' ),
		),
		'priority'    => 10,
	) );

	// Content & sidebar layout
	$subkey = 'content_layout';
	$key = $option_key . '[' . $subkey . ']';
	$wp_customize->add_setting( $key, array(
		'default'     => suki_array_value( $default, $subkey ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
	) );
	$wp_customize->add_control( $key, array(
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
	if ( false !== strpos( $ps_type, '_singular' ) ) {
		// ------
		$wp_customize->add_control( new Suki_Customize_Control_HR( $wp_customize, 'hr_page_settings_' . $ps_type . '_content_elements', array(
			'section'     => $section,
			'settings'    => array(),
			'priority'    => 10,
		) ) );

		// Hide post title
		$subkey = 'content_hide_title';
		$key = $option_key . '[' . $subkey . ']';
		$wp_customize->add_setting( $key, array(
			'default'     => suki_array_value( $default, $subkey ),
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
		) );
		$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $key, array(
			'section'     => $section,
			'label'       => esc_html__( 'Hide post title', 'suki' ),
			'priority'    => 10,
		) ) );

		// Hide featured image
		$subkey = 'content_hide_thumbnail';
		$key = $option_key . '[' . $subkey . ']';
		$wp_customize->add_setting( $key, array(
			'default'     => suki_array_value( $default, $subkey ),
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
		) );
		$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $key, array(
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
	$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_page_settings_' . $ps_type . '_header', array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => esc_html__( 'Header', 'suki' ),
		'priority'    => 20,
	) ) );

	// Disable main header
	$subkey = 'disable_header';
	$key = $option_key . '[' . $subkey . ']';
	$wp_customize->add_setting( $key, array(
		'default'     => suki_array_value( $default, $subkey ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
	) );
	$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $key, array(
		'section'     => $section,
		'label'       => esc_html__( 'Disable main header', 'suki' ),
		'priority'    => 20,
	) ) );

	// Disable mobile header
	$subkey = 'disable_mobile_header';
	$key = $option_key . '[' . $subkey . ']';
	$wp_customize->add_setting( $key, array(
		'default'     => suki_array_value( $default, $subkey ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
	) );
	$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $key, array(
		'section'     => $section,
		'label'       => esc_html__( 'Disable mobile header', 'suki' ),
		'priority'    => 20,
	) ) );

	/**
	 * ====================================================
	 * Page Header
	 * ====================================================
	 */

	// Heading: Page Header
	$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_page_settings_' . $ps_type . '_page_header', array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => esc_html__( 'Page Header', 'suki' ),
		'priority'    => 30,
	) ) );

	// Page header
	$subkey = 'page_header';
	$key = $option_key . '[' . $subkey . ']';
	$wp_customize->add_setting( $key, array(
		'default'     => suki_array_value( $default, $subkey ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
	) );
	$wp_customize->add_control( $key, array(
		'type'        => 'select',
		'section'     => $section,
		'label'       => esc_html__( 'Page header', 'suki' ),
		'choices'     => array(
			''  => esc_html__( 'Default', 'suki' ),
			'0' => esc_html__( 'Disabled', 'suki' ),
			'1' => esc_html__( 'Enabled', 'suki' ),
		),
		'priority'    => 30,
	) );

	// Page header background image
	$subkey = 'page_header_bg';
	$key = $option_key . '[' . $subkey . ']';
	$choices = array();
	if ( false !== strpos( $ps_type, '_singular' ) ) {
		$post_type_obj = get_post_type_object( str_replace( '_singular', '', $ps_type ) );

		/* translators: %s: plural post type name */
		$choices['archive'] = sprintf( esc_html__( 'Same as %s archive', 'suki' ), $post_type_obj->labels->name );

		if ( post_type_supports( $post_type_obj->name, 'thumbnail' ) ) {
			/* translators: %s: singular post type name */
			$choices['thumbnail'] = sprintf( esc_html__( 'Use %s\'s featured image (if specified)', 'suki' ), $post_type_obj->labels->singular_name );
		}
	} else {
		$choices['custom'] = esc_html__( 'Custom', 'suki' );
	}
	$wp_customize->add_setting( $key, array(
		'default'     => suki_array_value( $default, $subkey ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
	) );
	$wp_customize->add_control( $key, array(
		'type'        => 'select',
		'section'     => $section,
		'label'       => esc_html__( 'Page header background image', 'suki' ),
		'choices'     => array_merge(
			array( '' => esc_html__( 'Default', 'suki' ) ),
			$choices
		),
		'priority'    => 30,
	) );

	// Options specifically for non singular page types.
	if ( false === strpos( $ps_type, '_singular' ) ) {
		// Custom background image
		$subkey = 'page_header_bg_image';
		$key = $option_key . '[' . $subkey . ']';
		$wp_customize->add_setting( $key, array(
			'default'     => suki_array_value( $default, $subkey ),
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'image' ),
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $key, array(
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
	$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_page_settings_' . $ps_type . '_footer', array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => esc_html__( 'Footer', 'suki' ),
		'priority'    => 40,
	) ) );

	// Disable footer widgets
	$subkey = 'disable_footer_widgets';
	$key = $option_key . '[' . $subkey . ']';
	$wp_customize->add_setting( $key, array(
		'default'     => suki_array_value( $default, $subkey ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
	) );
	$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $key, array(
		'section'     => $section,
		'label'       => esc_html__( 'Disable footer widgets', 'suki' ),
		'priority'    => 40,
	) ) );

	// Disable footer bottom
	$subkey = 'disable_footer_bottom';
	$key = $option_key . '[' . $subkey . ']';
	$wp_customize->add_setting( $key, array(
		'default'     => suki_array_value( $default, $subkey ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
	) );
	$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $key, array(
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
		$wp_customize->add_control( new Suki_Customize_Control_Pro_Teaser( $wp_customize, 'pro_teaser_page_settings_' . $ps_type, array(
			'section'     => $section,
			'settings'    => array(),
			'label'       => esc_html_x( 'More Options Available', 'Suki Pro upsell', 'suki' ),
			'url'         => esc_url( add_query_arg( array( 'utm_source' => 'suki-customizer', 'utm_medium' => 'learn-more', 'utm_campaign' => 'theme-upsell' ), SUKI_PRO_URL ) ),
			'features'    => array(
				esc_html_x( 'Enable / disable transparent header on this page', 'Suki Pro upsell', 'suki' ),
				esc_html_x( 'Enable / disable alternate header colors on this page', 'Suki Pro upsell', 'suki' ),
				esc_html_x( 'Enable / disable sticky header on this page', 'Suki Pro upsell', 'suki' ),
				esc_html_x( 'Enable / disable preloader screen on this page', 'Suki Pro upsell', 'suki' ),
				esc_html_x( 'Insert custom portable blocks (hooks) on this page', 'Suki Pro upsell', 'suki' ),
			),
			'priority'    => 90,
		) ) );
	}
}