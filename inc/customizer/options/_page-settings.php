<?php
/**
 * Customizer settings: Page Settings
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

foreach ( Suki_Customizer::instance()->get_all_page_settings_types() as $ps_type => $ps_data ) {
	$section = suki_array_value( $ps_data, 'section' );
	$option_prefix = $ps_type;

	// Get default value (array) of the option key.
	$default = suki_array_value( $defaults, $option_prefix, array() );
	if ( ! is_array( $default ) ) {
		$default = array();
	}

	// Heading: Page Settings
	$title = esc_html__( 'Page Settings', 'suki' );
	if ( false !== strpos( $ps_type, '_single' ) ) {
		// Extract the post type slug from $ps_type.
		$post_type_slug = preg_replace( '/(_single|_archive)/', '', $ps_type );
		$post_type_obj = get_post_type_object( $post_type_slug );

		$title .= ' <span class="suki-global-default-badge suki-tooltip" tabindex="0" data-tooltip="' . sprintf( esc_attr__( 'You can override these options on each individual %s.', 'suki' ), $post_type_obj->labels->singular_name ) . '"><span class="dashicons dashicons-admin-site-alt3"></span></span>';
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
		$key = $option_prefix . '_' . $subkey;
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
		$key = $option_prefix . '_' . $subkey;
		$wp_customize->add_setting( $key, array(
			'default'     => suki_array_value( $default, $subkey ),
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
		) );
		$wp_customize->add_control( new Suki_Customize_Control_RadioImage( $wp_customize, $key, array(
			'section'     => $section,
			'label'       => esc_html__( 'Sidebar', 'suki' ) . ' <span class="suki-tooltip suki-tooltip-right" tabindex="0" data-tooltip="' . esc_attr__( 'Not available on "Narrow" content layout', 'suki' ) . '"><span class="dashicons dashicons-info"></span></span>',
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
	 * Content Header
	 * ====================================================
	 */

	if ( 'error_404' !== $ps_type ) {
		// Title text format on archive pages
		if ( false !== strpos( $ps_type, '_archive' ) ) {
			// ------
			$wp_customize->add_control( new Suki_Customize_Control_HR( $wp_customize, 'hr_page_settings_' . $ps_type . '_content_header_title', array(
				'section'     => $section,
				'settings'    => array(),
				'priority'    => 120,
			) ) );

			// Title text format on post type archive pages
			$subkey = 'title_text';
			$key = $option_prefix . '_' . $subkey;
			$wp_customize->add_setting( $key, array(
				'default'     => suki_array_value( $default, $subkey ),
				'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'text' ),
			) );
			$wp_customize->add_control( $key, array(
				'section'     => $section,
				'label'       => esc_html__( 'Main archive page\'s title', 'suki' ),
				'input_attrs' => array(
					'placeholder' => '{{post_type}}',
				),
				'priority'    => 120,
			) );

			// Title text format on taxonomy archive pages
			$subkey = 'tax_title_text';
			$key = $option_prefix . '_' . $subkey;
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

		// ------
		$wp_customize->add_control( new Suki_Customize_Control_HR( $wp_customize, 'hr_page_settings_' . $ps_type . '_hero', array(
			'section'     => $section,
			'settings'    => array(),
			'priority'    => 120,
		) ) );

		// Hero 
		$subkey = 'hero';
		$key = $option_prefix . '_' . $subkey;
		$wp_customize->add_setting( $key, array(
			'default'     => suki_array_value( $default, $subkey ),
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
		) );
		$wp_customize->add_control( $key, array(
			'type'        => 'select',
			'section'     => $section,
			'label'       => esc_html__( 'Hero section', 'suki' ),
			'choices'     => array(
				''  => esc_html__( '-- Global --', 'suki' ),
				'1' => esc_html__( '&#x2714; Enabled', 'suki' ),
				'0' => esc_html__( '&#x2718; Disabled', 'suki' ),
			),
			'priority'    => 120,
		) );

		// // Content header
		// $subkey = 'content_header';
		// $key = $option_prefix . '_' . $subkey;
		// $wp_customize->add_setting( $key, array(
		// 	'default'     => suki_array_value( $default, $subkey ),
		// 	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
		// ) );
		// $wp_customize->add_control( new Suki_Customize_Control_RadioImage( $wp_customize, $key, array(
		// 	'section'     => $section,
		// 	'label'       => esc_html__( 'Content header', 'suki' ),
		// 	'choices'     => array(
		// 		'' => array(
		// 			'label' => esc_html__( '-- Global --', 'suki' ),
		// 			'image' => SUKI_IMAGES_URL . '/customizer/default.svg',
		// 		),
		// 		'disabled' => array(
		// 			'label' => esc_html__( 'Disabled', 'suki' ),
		// 			'image' => SUKI_IMAGES_URL . '/customizer/hero--disabled.svg',
		// 		),
		// 		'default' => array(
		// 			'label' => esc_html__( 'Default', 'suki' ),
		// 			'image' => SUKI_IMAGES_URL . '/customizer/hero--enabled.svg',
		// 		),
		// 		'hero' => array(
		// 			'label' => esc_html__( 'Hero', 'suki' ),
		// 			'image' => SUKI_IMAGES_URL . '/customizer/hero--enabled.svg',
		// 		),
		// 	),
		// 	'columns'     => 4,
		// 	'priority'    => 120,
		// ) ) );

		// // Content header alignment
		// $subkey = 'content_header_alignment';
		// $key = $option_prefix . '_' . $subkey;
		// $wp_customize->add_setting( $key, array(
		// 	'default'     => suki_array_value( $default, $subkey ),
		// 	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
		// ) );
		// $wp_customize->add_control( new Suki_Customize_Control_RadioImage( $wp_customize, $key, array(
		// 	'section'     => $section,
		// 	'label'       => esc_html__( 'Content header alignment', 'suki' ),
		// 	'choices'     => array(
		// 		'' => array(
		// 			'label' => '<span style="line-height: 20px; vertical-align: middle;">' . esc_html__( '-- Global --', 'suki' ) . '</span>',
		// 		),
		// 		'left'   => array(
		// 			'label' => '<span class="dashicons dashicons-editor-align' . ( is_rtl() ? 'right' : 'left' ) . '"></span>',
		// 		),
		// 		'center' => array(
		// 			'label' => '<span class="dashicons dashicons-editor-aligncenter"></span>',
		// 		),
		// 		'right'  => array(
		// 			'label' => '<span class="dashicons dashicons-editor-align' . ( is_rtl() ? 'left' : 'right' ) . '"></span>',
		// 		),
		// 	),
		// 	'priority'    => 120,
		// ) ) );

		// // Hero container width
		// $subkey = 'hero_container';
		// $key = $option_prefix . '_' . $subkey;
		// $wp_customize->add_setting( $key, array(
		// 	'default'     => suki_array_value( $default, $subkey ),
		// 	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
		// ) );
		// $wp_customize->add_control( new Suki_Customize_Control_RadioImage( $wp_customize, $key, array(
		// 	'section'     => $section,
		// 	'label'       => esc_html__( 'Hero container width', 'suki' ),
		// 	'choices'     => array(
		// 		'' => array(
		// 			'label' => esc_html__( '-- Global --', 'suki' ),
		// 			'image' => SUKI_IMAGES_URL . '/customizer/default.svg',
		// 		),
		// 		'default'    => array(
		// 			'label' => esc_html__( 'Normal', 'suki' ),
		// 			'image' => SUKI_IMAGES_URL . '/customizer/hero-container--default.svg',
		// 		),
		// 		'full-width' => array(
		// 			'label' => esc_html__( 'Full width', 'suki' ),
		// 			'image' => SUKI_IMAGES_URL . '/customizer/hero-container--full-width.svg',
		// 		),
		// 		'narrow'     => array(
		// 			'label' => esc_html__( 'Narrow', 'suki' ),
		// 			'image' => SUKI_IMAGES_URL . '/customizer/hero-container--narrow.svg',
		// 		),
		// 	),
		// 	'columns'     => 4,
		// 	'priority'    => 120,
		// ) ) );
	}

	/**
	 * ====================================================
	 * Header
	 * ====================================================
	 */

	// ------
	$wp_customize->add_control( new Suki_Customize_Control_HR( $wp_customize, 'hr_page_settings_' . $ps_type . '_header', array(
		'section'     => $section,
		'settings'    => array(),
		'priority'    => 130,
	) ) );

	// Desktop header
	$subkey = 'disable_header';
	$key = $option_prefix . '_' . $subkey;
	$wp_customize->add_setting( $key, array(
		'default'     => suki_array_value( $default, $subkey ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
	) );
	$wp_customize->add_control( $key, array(
		'type'        => 'select',
		'section'     => $section,
		'label'       => esc_html__( 'Desktop header', 'suki' ),
		'choices'     => array(
			''  => esc_html__( '&#x2714; Enabled', 'suki' ),
			'1' => esc_html__( '&#x2718; Disabled', 'suki' ),
		),
		'priority'    => 130,
	) );

	// Mobile header
	$subkey = 'disable_mobile_header';
	$key = $option_prefix . '_' . $subkey;
	$wp_customize->add_setting( $key, array(
		'default'     => suki_array_value( $default, $subkey ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
	) );
	$wp_customize->add_control( $key, array(
		'type'        => 'select',
		'section'     => $section,
		'label'       => esc_html__( 'Mobile header', 'suki' ),
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

	// ------
	$wp_customize->add_control( new Suki_Customize_Control_HR( $wp_customize, 'hr_page_settings_' . $ps_type . '_footer', array(
		'section'     => $section,
		'settings'    => array(),
		'priority'    => 150,
	) ) );

	// Footer widgets
	$subkey = 'disable_footer_widgets';
	$key = $option_prefix . '_' . $subkey;
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
	$key = $option_prefix . '_' . $subkey;
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