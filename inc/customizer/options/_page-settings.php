<?php
/**
 * Customizer settings: Individual Page Settings
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

foreach ( Suki_Customizer::instance()->get_all_page_settings_types() as $ps_type => $ps_data ) {
	$section = suki_array_value( $ps_data, 'section' );
	$option_key = 'page_settings_' . $ps_type;

	// Get default value (array) of the option key.
	$default = suki_array_value( $defaults, $option_key, array() );
	if ( ! is_array( $default ) ) {
		$default = array();
	}

	// Heading: Individual Page Settings
	$title = esc_html__( 'Individual Page Settings', 'suki' );
	if ( 0 < strpos( $ps_type, '_singular' ) ) {
		// Extract the post type slug from $ps_type.
		$post_type_slug = preg_replace( '/(_singular|_archive)/', '', $ps_type );
		$post_type_obj = get_post_type_object( $post_type_slug );

		$title .= ' &nbsp; <span class="suki-global-default-badge suki-tooltip" tabindex="0" data-tooltip="' . sprintf( esc_attr__( 'You can override these options on each individual %s.', 'suki' ), $post_type_obj->labels->singular_name ) . '"><span class="dashicons dashicons-admin-site-alt3"></span></span>';
	}
	$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_page_settings_' . $ps_type, array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => $title,
		'description' => suki_array_value( $ps_data, 'description' ),
		'priority'    => 100,
	) ) );

	/**
	 * ====================================================
	 * Content
	 * ====================================================
	 */

	if ( 'error_404' !== $ps_type ) {
		// Content container
		$subkey = 'content_container';
		$key = $option_key . '[' . $subkey . ']';
		$wp_customize->add_setting( $key, array(
			'default'     => suki_array_value( $default, $subkey ),
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
		) );
		$wp_customize->add_control( new Suki_Customize_Control_RadioImage( $wp_customize, $key, array(
			'section'     => $section,
			'label'       => esc_html__( 'Content container', 'suki' ),
			'choices'     => array(
				''           => array(
					'label' => esc_html__( '-- Global --', 'suki' ),
					'image' => SUKI_IMAGES_URL . '/customizer/default.svg',
				),
				'narrow'     => array(
					'label' => esc_html__( 'Narrow', 'suki' ),
					'image' => SUKI_IMAGES_URL . '/customizer/content-container--narrow.svg',
				),
				'default'    => array(
					'label' => esc_html__( 'Normal', 'suki' ),
					'image' => SUKI_IMAGES_URL . '/customizer/content-container--default.svg',
				),
				'full-width' => array(
					'label' => esc_html__( 'Full width', 'suki' ),
					'image' => SUKI_IMAGES_URL . '/customizer/content-container--full-width.svg',
				),
			),
			'columns'     => 4,
			'priority'    => 110,
		) ) );

		// Sidebar
		$subkey = 'content_layout';
		$key = $option_key . '[' . $subkey . ']';
		$wp_customize->add_setting( $key, array(
			'default'     => suki_array_value( $default, $subkey ),
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
		) );
		$wp_customize->add_control( new Suki_Customize_Control_RadioImage( $wp_customize, $key, array(
			'section'     => $section,
			'label'       => esc_html__( 'Sidebar', 'suki' ),
			'choices'     => array(
				''              => array(
					'label' => esc_html__( '-- Global --', 'suki' ),
					'image' => SUKI_IMAGES_URL . '/customizer/default.svg',
				),
				'wide'          => array(
					'label' => esc_html__( 'None', 'suki' ),
					'image' => SUKI_IMAGES_URL . '/customizer/content-sidebar-layout--wide.svg',
				),
				'right-sidebar' => array(
					'label' => is_rtl() ? esc_html__( 'Left', 'suki' ) : esc_html__( 'Right', 'suki' ),
					'image' => SUKI_IMAGES_URL . '/customizer/content-sidebar-layout--right-sidebar.svg',
				),
				'left-sidebar'  => array(
					'label' => is_rtl() ? esc_html__( 'Right', 'suki' ) : esc_html__( 'Left', 'suki' ),
					'image' => SUKI_IMAGES_URL . '/customizer/content-sidebar-layout--left-sidebar.svg',
				),
			),
			'columns'     => 4,
			'priority'    => 110,
		) ) );
	}

	/**
	 * ====================================================
	 * Archive Title
	 * ====================================================
	 */

	// Title text format on archive pages
	if ( false !== strpos( $ps_type, '_archive' ) ) {
		// ------
		$wp_customize->add_control( new Suki_Customize_Control_HR( $wp_customize, 'hr_page_settings_' . $ps_type . '_content_header_title', array(
			'section'     => $section,
			'settings'    => array(),
			'priority'    => 120,
		) ) );

		// Title text format on post type archive pages
		$subkey = 'archive_title_text';
		$key = $option_key . '[' . $subkey . ']';
		$wp_customize->add_setting( $key, array(
			'default'     => suki_array_value( $default, $subkey ),
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'text' ),
		) );
		$wp_customize->add_control( $key, array(
			'section'     => $section,
			'label'       => esc_html__( 'Archive page\'s title', 'suki' ),
			'input_attrs' => array(
				'placeholder' => '{{post_type}}',
			),
			'priority'    => 120,
		) );

		// Title text format on taxonomy archive pages
		$subkey = 'tax_archive_title_text';
		$key = $option_key . '[' . $subkey . ']';
		$wp_customize->add_setting( $key, array(
			'default'     => suki_array_value( $default, $subkey ),
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'text' ),
		) );
		$wp_customize->add_control( $key, array(
			'section'     => $section,
			'label'       => esc_html__( 'Taxonomy archive page\'s title', 'suki' ),
			'input_attrs' => array(
				'placeholder' => '{{taxonomy}}: {{term}}',
			),
			'priority'    => 120,
		) );
	}

	/**
	 * ====================================================
	 * Hero section
	 * ====================================================
	 */

	if ( 'error_404' !== $ps_type ) {
		// ------
		$wp_customize->add_control( new Suki_Customize_Control_HR( $wp_customize, 'hr_page_settings_' . $ps_type . '_hero', array(
			'section'     => $section,
			'settings'    => array(),
			'priority'    => 120,
		) ) );

		// Hero section
		$subkey = 'hero';
		$key = $option_key . '[' . $subkey . ']';
		$wp_customize->add_setting( $key, array(
			'default'     => suki_array_value( $default, $subkey ),
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
		) );
		$wp_customize->add_control( new Suki_Customize_Control_RadioImage( $wp_customize, $key, array(
			'section'     => $section,
			'label'       => esc_html__( 'Hero section', 'suki' ),
			'description' => esc_html__( 'If enabled, title, breadcrumb, and meta info are moved inside Hero Section.', 'suki' ),
			'choices'     => array(
				'' => array(
					'label' => esc_html__( '-- Global --', 'suki' ),
					'image' => SUKI_IMAGES_URL . '/customizer/default.svg',
				),
				'00' => array(
					'label' => esc_html__( 'Disabled', 'suki' ),
					'image' => SUKI_IMAGES_URL . '/customizer/hero--disabled.svg',
				),
				'01' => array(
					'label' => esc_html__( 'Enabled', 'suki' ),
					'image' => SUKI_IMAGES_URL . '/customizer/hero--enabled.svg',
				),
			),
			'columns'     => 4,
			'priority'    => 120,
		) ) );

		// Container width
		$subkey = 'hero_container';
		$key = $option_key . '[' . $subkey . ']';
		$wp_customize->add_setting( $key, array(
			'default'     => suki_array_value( $default, $subkey ),
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
		) );
		$wp_customize->add_control( new Suki_Customize_Control_RadioImage( $wp_customize, $key, array(
			'section'     => $section,
			'label'       => esc_html__( 'Container width', 'suki' ),
			'choices'     => array(
				'' => array(
					'label' => esc_html__( '-- Global --', 'suki' ),
					'image' => SUKI_IMAGES_URL . '/customizer/default.svg',
				),
				'default'    => array(
					'label' => esc_html__( 'Normal', 'suki' ),
					'image' => SUKI_IMAGES_URL . '/customizer/hero-container--default.svg',
				),
				'full-width' => array(
					'label' => esc_html__( 'Full width', 'suki' ),
					'image' => SUKI_IMAGES_URL . '/customizer/hero-container--full-width.svg',
				),
				'narrow'     => array(
					'label' => esc_html__( 'Narrow', 'suki' ),
					'image' => SUKI_IMAGES_URL . '/customizer/hero-container--narrow.svg',
				),
			),
			'columns'     => 4,
			'priority'    => 120,
		) ) );

		// Alignment
		$subkey = 'hero_alignment';
		$key = $option_key . '[' . $subkey . ']';
		$wp_customize->add_setting( $key, array(
			'default'     => suki_array_value( $default, $subkey ),
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
		) );
		$wp_customize->add_control( new Suki_Customize_Control_RadioImage( $wp_customize, $key, array(
			'section'     => $section,
			'label'       => esc_html__( 'Alignment', 'suki' ),
			'choices'     => array(
				'' => array(
					'label' => '<span style="line-height: 20px; vertical-align: middle;">' . esc_html__( '-- Global --', 'suki' ) . '</span>',
				),
				'left'   => array(
					'label' => '<span class="dashicons dashicons-editor-align' . ( is_rtl() ? 'right' : 'left' ) . '"></span>',
				),
				'center' => array(
					'label' => '<span class="dashicons dashicons-editor-aligncenter"></span>',
				),
				'right'  => array(
					'label' => '<span class="dashicons dashicons-editor-align' . ( is_rtl() ? 'left' : 'right' ) . '"></span>',
				),
			),
			'priority'    => 120,
		) ) );
	}

	/**
	 * ====================================================
	 * Header
	 * ====================================================
	 */

	if ( 'error_404' !== $ps_type ) {
		// ------
		$wp_customize->add_control( new Suki_Customize_Control_HR( $wp_customize, 'hr_page_settings_' . $ps_type . '_header', array(
			'section'     => $section,
			'settings'    => array(),
			'priority'    => 130,
		) ) );
	}

	// Desktop Header
	$subkey = 'disable_header';
	$key = $option_key . '[' . $subkey . ']';
	$wp_customize->add_setting( $key, array(
		'default'     => suki_array_value( $default, $subkey ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
	) );
	$wp_customize->add_control( $key, array(
		'type'        => 'select',
		'section'     => $section,
		'label'       => esc_html__( 'Desktop Header', 'suki' ),
		'choices'     => array(
			''  => esc_html__( '&#x2714; Enabled', 'suki' ),
			'1' => esc_html__( '&#x2718; Disabled', 'suki' ),
		),
		'priority'    => 130,
	) );

	if ( 'error_404' !== $ps_type ) {
		// ------
		$wp_customize->add_control( new Suki_Customize_Control_HR( $wp_customize, 'hr_page_settings_' . $ps_type . '_header_mobile', array(
			'section'     => $section,
			'settings'    => array(),
			'priority'    => 135,
		) ) );
	}

	// Mobile Header
	$subkey = 'disable_mobile_header';
	$key = $option_key . '[' . $subkey . ']';
	$wp_customize->add_setting( $key, array(
		'default'     => suki_array_value( $default, $subkey ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
	) );
	$wp_customize->add_control( $key, array(
		'type'        => 'select',
		'section'     => $section,
		'label'       => esc_html__( 'Mobile Header', 'suki' ),
		'choices'     => array(
			''  => esc_html__( '&#x2714; Enabled', 'suki' ),
			'1' => esc_html__( '&#x2718; Disabled', 'suki' ),
		),
		'priority'    => 135,
	) );

	/**
	 * ====================================================
	 * Footer
	 * ====================================================
	 */

	// // Heading: Footer
	// $wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_page_settings_' . $ps_type . '_footer', array(
	// 	'section'     => $section,
	// 	'settings'    => array(),
	// 	'label'       => esc_html__( 'Footer', 'suki' ),
	// 	'priority'    => 40,
	// ) ) );

	// ------
	$wp_customize->add_control( new Suki_Customize_Control_HR( $wp_customize, 'hr_page_settings_' . $ps_type . '_footer', array(
		'section'     => $section,
		'settings'    => array(),
		'priority'    => 150,
	) ) );

	// Footer widgets
	$subkey = 'disable_footer_widgets';
	$key = $option_key . '[' . $subkey . ']';
	$wp_customize->add_setting( $key, array(
		'default'     => suki_array_value( $default, $subkey ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
	) );
	$wp_customize->add_control( $key, array(
		'type'        => 'select',
		'section'     => $section,
		'label'       => esc_html__( 'Footer widgets', 'suki' ),
		'choices'     => array(
			''  => esc_html__( '&#x2714; Enabled', 'suki' ),
			'1' => esc_html__( '&#x2718; Disabled', 'suki' ),
		),
		'priority'    => 150,
	) );

	// Footer bottom
	$subkey = 'disable_footer_bottom';
	$key = $option_key . '[' . $subkey . ']';
	$wp_customize->add_setting( $key, array(
		'default'     => suki_array_value( $default, $subkey ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
	) );
	$wp_customize->add_control( $key, array(
		'type'        => 'select',
		'section'     => $section,
		'label'       => esc_html__( 'Footer bottom', 'suki' ),
		'choices'     => array(
			''  => esc_html__( '&#x2714; Enabled', 'suki' ),
			'1' => esc_html__( '&#x2718; Disabled', 'suki' ),
		),
		'priority'    => 150,
	) );
}