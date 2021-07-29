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

	// Extract the post type slug from $ps_type.
	$post_type_slug = preg_replace( '/(_single|_archive)/', '', $ps_type );
	$post_type_obj = get_post_type_object( $post_type_slug );

	/**
	 * ====================================================
	 * Individual Page Settings
	 * ====================================================
	 */

	// Heading: Individual Page Settings
	$title = esc_html__( 'Individual Page Settings', 'suki' );
	if ( false !== strpos( $ps_type, '_single' ) ) {
		$title .= ' <span class="suki-global-default-badge suki-tooltip" tabindex="0" data-tooltip="' . sprintf( esc_attr__( 'You can override these options on each individual %s.', 'suki' ), $post_type_obj->labels->singular_name ) . '"><span class="dashicons dashicons-admin-site-alt3"></span></span>';
	}
	$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_' . $ps_type . '_page_settings', array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => $title,
		'priority'    => 100,
	) ) );

	if ( 'error_404' !== $ps_type ) {

		// Content container
		$subkey = 'content_container';
		$key = $option_prefix . '_' . $subkey;
		$wp_customize->add_setting( $key, array(
			'default'     => suki_array_value( $defaults, $key ),
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
		) );
		$wp_customize->add_control( $key, array(
			'type'        => 'select',
			'section'     => $section,
			'label'       => esc_html__( 'Content container', 'suki' ),
			'choices'     => array(
				''           => esc_html__( '-- Global --', 'suki' ),
				'narrow'     => esc_html__( 'Narrow', 'suki' ),
				'default'    => esc_html__( 'Normal', 'suki' ),
				'full-width' => esc_html__( 'Full width', 'suki' ),
			),
			'priority'    => 100,
		) );

		// Info
		$wp_customize->add_control( new Suki_Customize_Control_Blank( $wp_customize, 'notice_' . $option_prefix . '_sidebar_on_narrow_layout', array(
			'section'     => $section,
			'settings'    => array(),
			'description' => '<div class="notice notice-info notice-alt inline"><p>' . esc_html__( 'Narrow content layout doesn\'t support Sidebar.', 'suki' ) . '</p></div>',
			'priority'    => 100,
		) ) );

		// Sidebar
		$subkey = 'content_layout';
		$key = $option_prefix . '_' . $subkey;
		$wp_customize->add_setting( $key, array(
			'default'     => suki_array_value( $defaults, $key ),
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
		) );
		$wp_customize->add_control( $key, array(
			'type'        => 'select',
			'section'     => $section,
			'label'       => esc_html__( 'Sidebar', 'suki' ),
			'choices'     => array(
				''              => esc_html__( '-- Global --', 'suki' ),
				'wide'          => esc_html__( 'None', 'suki' ),
				'right-sidebar' => is_rtl() ? esc_html__( 'Left', 'suki' ) : esc_html__( 'Right', 'suki' ),
				'left-sidebar'  => is_rtl() ? esc_html__( 'Right', 'suki' ) : esc_html__( 'Left', 'suki' ),
			),
			'priority'    => 110,
		) );
		
		// ------
		$wp_customize->add_control( new Suki_Customize_Control_HR( $wp_customize, 'hr_' . $ps_type . '_hero', array(
			'section'     => $section,
			'settings'    => array(),
			'priority'    => 120,
		) ) );

		// Hero section
		$subkey = 'hero';
		$key = $option_prefix . '_' . $subkey;
		$wp_customize->add_setting( $key, array(
			'default'     => suki_array_value( $defaults, $key ),
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

		// Container
		$subkey = 'hero_container';
		$key = $option_prefix . '_' . $subkey;
		$wp_customize->add_setting( $key, array(
			'default'     => suki_array_value( $defaults, $key ),
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
		) );
		$wp_customize->add_control( $key, array(
			'type'        => 'select',
			'section'     => $section,
			'label'       => esc_html__( 'Container', 'suki' ),
			'choices'     => array(
				''           => esc_html__( '-- Global --', 'suki' ),
				'default'    => esc_html__( 'Normal', 'suki' ),
				'full-width' => esc_html__( 'Full width', 'suki' ),
				'narrow'     => esc_html__( 'Narrow', 'suki' ),
			),
			'priority'    => 120,
		) );

		// Background image
		$subkey = 'hero_bg';
		$key = $option_prefix . '_' . $subkey;
		$choices = array(
			''       => esc_html__( '-- Global --', 'suki' ),
			'custom' => esc_html__( 'Custom', 'suki' ),
		);
		if ( false !== strpos( $ps_type, '_single' ) ) {
			if ( 'page_single' !== $ps_type ) {
				/* translators: %s: plural post type name */
				$choices['archive'] = sprintf( esc_html__( 'Same as archive', 'suki' ), $post_type_obj->labels->name );
			}

			if ( post_type_supports( $post_type_obj->name, 'thumbnail' ) ) {
				/* translators: %s: singular post type name */
				$choices['thumbnail'] = sprintf( esc_html__( 'Featured image', 'suki' ), $post_type_obj->labels->singular_name );
			}
		}
		$wp_customize->add_setting( $key, array(
			'default'     => suki_array_value( $defaults, $key ),
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
		) );
		$wp_customize->add_control( $key, array(
			'type'        => 'select',
			'section'     => $section,
			'label'       => esc_html__( 'Background image', 'suki' ),
			'choices'     => $choices,
			'priority'    => 120,
		) );

			// Custom background image
			$subkey = 'hero_bg_image';
			$key = $option_prefix . '_' . $subkey;
			$wp_customize->add_setting( $key, array(
				'default'     => suki_array_value( $defaults, $key ),
				'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'image' ),
			) );
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $key, array(
				'section'     => $section,
				// 'label'       => esc_html__( 'Custom background image', 'suki' ),
				'priority'    => 120,
			) ) );
		
		// ------
		$wp_customize->add_control( new Suki_Customize_Control_HR( $wp_customize, 'hr_' . $ps_type . '_header', array(
			'section'     => $section,
			'settings'    => array(),
			'priority'    => 130,
		) ) );
	}

	// Desktop Header
	$subkey = 'disable_header';
	$key = $option_prefix . '_' . $subkey;
	$wp_customize->add_setting( $key, array(
		'default'     => suki_array_value( $defaults, $key ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
	) );
	$wp_customize->add_control( $key, array(
		'type'        => 'select',
		'section'     => $section,
		'label'       => esc_html__( 'Desktop Header', 'suki' ),
		'choices'     => array(
			''  => esc_html__( '&#x2714; Visible', 'suki' ),
			'1' => esc_html__( '&#x2718; Hidden', 'suki' ),
		),
		'priority'    => 130,
	) );

	// Mobile Header
	$subkey = 'disable_mobile_header';
	$key = $option_prefix . '_' . $subkey;
	$wp_customize->add_setting( $key, array(
		'default'     => suki_array_value( $defaults, $key ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
	) );
	$wp_customize->add_control( $key, array(
		'type'        => 'select',
		'section'     => $section,
		'label'       => esc_html__( 'Mobile Header', 'suki' ),
		'choices'     => array(
			''  => esc_html__( '&#x2714; Visible', 'suki' ),
			'1' => esc_html__( '&#x2718; Hidden', 'suki' ),
		),
		'priority'    => 140,
	) );

	// ------
	$wp_customize->add_control( new Suki_Customize_Control_HR( $wp_customize, 'hr_' . $ps_type . '_footer', array(
		'section'     => $section,
		'settings'    => array(),
		'priority'    => 150,
	) ) );

	// Footer widgets
	$subkey = 'disable_footer_widgets';
	$key = $option_prefix . '_' . $subkey;
	$wp_customize->add_setting( $key, array(
		'default'     => suki_array_value( $defaults, $key ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
	) );
	$wp_customize->add_control( $key, array(
		'type'        => 'select',
		'section'     => $section,
		'label'       => esc_html__( 'Footer widgets', 'suki' ),
		'choices'     => array(
			''  => esc_html__( '&#x2714; Visible', 'suki' ),
			'1' => esc_html__( '&#x2718; Hidden', 'suki' ),
		),
		'priority'    => 150,
	) );

	// Footer bottom
	$subkey = 'disable_footer_bottom';
	$key = $option_prefix . '_' . $subkey;
	$wp_customize->add_setting( $key, array(
		'default'     => suki_array_value( $defaults, $key ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
	) );
	$wp_customize->add_control( $key, array(
		'type'        => 'select',
		'section'     => $section,
		'label'       => esc_html__( 'Footer bottom', 'suki' ),
		'choices'     => array(
			''  => esc_html__( '&#x2714; Visible', 'suki' ),
			'1' => esc_html__( '&#x2718; Hidden', 'suki' ),
		),
		'priority'    => 150,
	) );
}