<?php
/**
 * Customizer settings: Page Settings
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

foreach ( Suki_Customizer::instance()->get_page_types( 'all' ) as $page_type_key => $page_type_data ) {
	// Get Customizer section name.
	$section = suki_array_value( $page_type_data, 'section' );

	// Set option key prefix to the page type name.
	$option_prefix = $page_type_key;

	// Extract the post type slug from $page_type_key.
	if ( ! in_array( $page_type_key, array( 'search_results', 'error_404' ), true ) ) {
		$post_type_slug = preg_replace( '/(_single|_archive)/', '', $page_type_key );
		$post_type_obj  = get_post_type_object( $post_type_slug );
	}

	/**
	 * ====================================================
	 * Page Settings
	 * ====================================================
	 */

	// Heading: Page Settings.
	$wp_customize->add_control(
		new Suki_Customize_Heading_Control(
			$wp_customize,
			'heading_' . $page_type_key . '_page_settings',
			array(
				'section'  => $section,
				'settings' => array(),
				'label'    => esc_html__( 'Page Settings', 'suki' ),
				'priority' => 100,
			)
		)
	);

	if ( 'error_404' !== $page_type_key ) {

		// Content container.
		$subkey = 'content_container';
		$key    = $option_prefix . '_' . $subkey;
		$wp_customize->add_setting(
			$key,
			array(
				'default'           => suki_array_value( $defaults, $key ),
				'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
			)
		);
		$wp_customize->add_control(
			$key,
			array(
				'type'     => 'select',
				'section'  => $section,
				'label'    => esc_html__( 'Content container', 'suki' ),
				'choices'  => array(
					''       => esc_html__( '-- Global --', 'suki' ),
					'narrow' => esc_html__( 'Narrow', 'suki' ),
					'wide'   => esc_html__( 'Wide', 'suki' ),
					'full'   => esc_html__( 'Full', 'suki' ),
				),
				'priority' => 100,
			)
		);

		// Info.
		$wp_customize->add_control(
			new Suki_Customize_Notice_Control(
				$wp_customize,
				'notice_' . $option_prefix . '_sidebar_on_narrow_layout',
				array(
					'section'     => $section,
					'settings'    => array(),
					'description' => esc_html__( 'Narrow container doesn\'t support sidebar.', 'suki' ),
					'priority'    => 100,
				)
			)
		);

		// Sidebar.
		$subkey = 'content_layout';
		$key    = $option_prefix . '_' . $subkey;
		$wp_customize->add_setting(
			$key,
			array(
				'default'           => suki_array_value( $defaults, $key ),
				'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
			)
		);
		$wp_customize->add_control(
			$key,
			array(
				'type'     => 'select',
				'section'  => $section,
				'label'    => esc_html__( 'Sidebar', 'suki' ),
				'choices'  => array(
					''              => esc_html__( '-- Global --', 'suki' ),
					'no-sidebar'    => esc_html__( 'Disabled', 'suki' ),
					'left-sidebar'  => esc_html__( 'Left', 'suki' ),
					'right-sidebar' => esc_html__( 'Right', 'suki' ),
				),
				'priority' => 110,
			)
		);

		// ------
		$wp_customize->add_control(
			new Suki_Customize_HR_Control(
				$wp_customize,
				'hr_' . $page_type_key . '_hero',
				array(
					'section'  => $section,
					'settings' => array(),
					'priority' => 120,
				)
			)
		);

		// Hero section.
		$subkey = 'hero';
		$key    = $option_prefix . '_' . $subkey;
		$wp_customize->add_setting(
			$key,
			array(
				'default'           => suki_array_value( $defaults, $key ),
				'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
			)
		);
		$wp_customize->add_control(
			$key,
			array(
				'type'     => 'select',
				'section'  => $section,
				'label'    => esc_html__( 'Hero section', 'suki' ),
				'choices'  => array(
					''  => esc_html__( '-- Global --', 'suki' ),
					'1' => esc_html__( '&#x2714; Enabled', 'suki' ),
					'0' => esc_html__( '&#x2718; Disabled', 'suki' ),
				),
				'priority' => 120,
			)
		);

		// Hero container.
		$subkey = 'hero_container';
		$key    = $option_prefix . '_' . $subkey;
		$wp_customize->add_setting(
			$key,
			array(
				'default'           => suki_array_value( $defaults, $key ),
				'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
			)
		);
		$wp_customize->add_control(
			$key,
			array(
				'type'     => 'select',
				'section'  => $section,
				'label'    => esc_html__( 'Hero container', 'suki' ),
				'choices'  => array(
					''        => esc_html__( '-- Global --', 'suki' ),
					'inherit' => esc_html__( '= Content', 'suki' ),
					'narrow'  => esc_html__( 'Narrow', 'suki' ),
					'wide'    => esc_html__( 'Wide', 'suki' ),
					'full'    => esc_html__( 'Full', 'suki' ),
				),
				'priority' => 120,
			)
		);

		// Background image.
		$subkey  = 'hero_bg';
		$key     = $option_prefix . '_' . $subkey;
		$choices = array(
			''       => esc_html__( '-- Global --', 'suki' ),
			'custom' => esc_html__( 'Custom', 'suki' ),
		);
		if ( false !== strpos( $page_type_key, '_single' ) ) {
			if ( post_type_supports( $post_type_obj->name, 'thumbnail' ) ) {
				/* translators: %s: singular post type name */
				$choices['thumbnail'] = sprintf( esc_html__( 'Featured image', 'suki' ), $post_type_obj->labels->singular_name );
			}
		}
		$wp_customize->add_setting(
			$key,
			array(
				'default'           => suki_array_value( $defaults, $key ),
				'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
			)
		);
		$wp_customize->add_control(
			$key,
			array(
				'type'     => 'select',
				'section'  => $section,
				'label'    => esc_html__( 'Background image', 'suki' ),
				'choices'  => $choices,
				'priority' => 120,
			)
		);

			// Custom background image.
			$subkey = 'hero_bg_image';
			$key    = $option_prefix . '_' . $subkey;
			$wp_customize->add_setting(
				$key,
				array(
					'default'           => suki_array_value( $defaults, $key ),
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control(
				new WP_Customize_Media_Control(
					$wp_customize,
					$key,
					array(
						'section'  => $section,
						'priority' => 120,
					)
				)
			);

		// ------
		$wp_customize->add_control(
			new Suki_Customize_HR_Control(
				$wp_customize,
				'hr_' . $page_type_key . '_header',
				array(
					'section'  => $section,
					'settings' => array(),
					'priority' => 130,
				)
			)
		);
	}

	// Desktop Header.
	$subkey = 'disable_header';
	$key    = $option_prefix . '_' . $subkey;
	$wp_customize->add_setting(
		$key,
		array(
			'default'           => suki_array_value( $defaults, $key ),
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
		)
	);
	$wp_customize->add_control(
		$key,
		array(
			'type'     => 'select',
			'section'  => $section,
			'label'    => esc_html__( 'Desktop Header', 'suki' ),
			'choices'  => array(
				''  => esc_html__( '&#x2714; Visible', 'suki' ),
				'1' => esc_html__( '&#x2718; Hidden', 'suki' ),
			),
			'priority' => 130,
		)
	);

	// Mobile Header.
	$subkey = 'disable_header_mobile';
	$key    = $option_prefix . '_' . $subkey;
	$wp_customize->add_setting(
		$key,
		array(
			'default'           => suki_array_value( $defaults, $key ),
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
		)
	);
	$wp_customize->add_control(
		$key,
		array(
			'type'     => 'select',
			'section'  => $section,
			'label'    => esc_html__( 'Mobile Header', 'suki' ),
			'choices'  => array(
				''  => esc_html__( '&#x2714; Visible', 'suki' ),
				'1' => esc_html__( '&#x2718; Hidden', 'suki' ),
			),
			'priority' => 140,
		)
	);

	// ------
	$wp_customize->add_control(
		new Suki_Customize_HR_Control(
			$wp_customize,
			'hr_' . $page_type_key . '_footer',
			array(
				'section'  => $section,
				'settings' => array(),
				'priority' => 150,
			)
		)
	);

	// Footer widgets.
	$subkey = 'disable_footer_widgets';
	$key    = $option_prefix . '_' . $subkey;
	$wp_customize->add_setting(
		$key,
		array(
			'default'           => suki_array_value( $defaults, $key ),
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
		)
	);
	$wp_customize->add_control(
		$key,
		array(
			'type'     => 'select',
			'section'  => $section,
			'label'    => esc_html__( 'Footer widgets', 'suki' ),
			'choices'  => array(
				''  => esc_html__( '&#x2714; Visible', 'suki' ),
				'1' => esc_html__( '&#x2718; Hidden', 'suki' ),
			),
			'priority' => 150,
		)
	);

	// Footer bottom.
	$subkey = 'disable_footer_bottom';
	$key    = $option_prefix . '_' . $subkey;
	$wp_customize->add_setting(
		$key,
		array(
			'default'           => suki_array_value( $defaults, $key ),
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
		)
	);
	$wp_customize->add_control(
		$key,
		array(
			'type'     => 'select',
			'section'  => $section,
			'label'    => esc_html__( 'Footer bottom', 'suki' ),
			'choices'  => array(
				''  => esc_html__( '&#x2714; Visible', 'suki' ),
				'1' => esc_html__( '&#x2718; Hidden', 'suki' ),
			),
			'priority' => 150,
		)
	);
}
