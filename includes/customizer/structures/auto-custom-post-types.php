<?php
/**
 * Customizer settings: Other Pages > Custom Post Types
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

foreach ( Suki_Customizer::instance()->get_page_types( 'custom' ) as $page_type_key => $page_type_data ) {
	$section = suki_array_value( $page_type_data, 'section' );

	$option_prefix = $page_type_key;

	// Abort if the post type has their own options.
	if ( ! suki_array_value( $page_type_data, 'auto_options', true ) ) {
		continue;
	}

	// Extract the post type slug from $page_type_key.
	$post_type_slug = preg_replace( '/(_single|_archive)/', '', $page_type_key );
	$post_type_obj  = get_post_type_object( $post_type_slug );

	/**
	 * ====================================================
	 * Content Header
	 * ====================================================
	 */

	// Heading: Content Header.
	$wp_customize->add_control(
		new Suki_Customize_Heading_Control(
			$wp_customize,
			'heading_' . $page_type_key . '_content_header',
			array(
				'section'  => $section,
				'settings' => array(),
				'label'    => esc_html__( 'Content Header', 'suki' ),
				'priority' => 20,
			)
		)
	);

	// Elements.
	$elements = array(
		'title' => esc_html__( 'Title', 'suki' ),
	);
	// Archive elements.
	if ( false !== strpos( $page_type_key, '_archive' ) ) {
		$elements['archive-description'] = esc_html__( 'Taxonomy Description', 'suki' );
	}
	$subkey = 'content_header';
	$key    = $option_prefix . '_' . $subkey;
	$wp_customize->add_setting(
		$key,
		array(
			'default'           => suki_array_value( $defaults, $key ),
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'multiselect' ),
		)
	);
	$wp_customize->add_control(
		new Suki_Customize_Control_Sortable(
			$wp_customize,
			$key,
			array(
				'section'  => $section,
				'choices'  => apply_filters( 'suki/dataset/' . $page_type_key . '_content_header_elements', $elements ),
				'priority' => 20,
			)
		)
	);

	// Alignment.
	$subkey = 'content_header_alignment';
	$key    = $option_prefix . '_' . $subkey;
	$wp_customize->add_setting(
		$key,
		array(
			'default'           => suki_array_value( $defaults, $key ),
			'transport'         => 'postMessage',
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
		)
	);
	$wp_customize->add_control(
		new Suki_Customize_RadioImage_Control(
			$wp_customize,
			$key,
			array(
				'section'  => $section,
				'choices'  => array(
					'left'   => array(
						'label' => esc_html__( 'Left', 'suki' ),
					),
					'center' => array(
						'label' => esc_html__( 'Center', 'suki' ),
					),
					'right'  => array(
						'label' => esc_html__( 'Right', 'suki' ),
					),
				),
				'priority' => 20,
			)
		)
	);

	// Title text format on archive pages.
	if ( false !== strpos( $page_type_key, '_archive' ) ) {

		// Title text format on post type archive pages.
		$subkey = 'title_text';
		$key    = $option_prefix . '_' . $subkey;
		$wp_customize->add_setting(
			$key,
			array(
				'default'           => suki_array_value( $defaults, $key ),
				'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'text' ),
			)
		);
		$wp_customize->add_control(
			$key,
			array(
				'section'     => $section,
				/* translators: %s: post type's plural name. */
				'label'       => sprintf( esc_html__( '%s page title', 'suki' ), $post_type_obj->labels->name ),
				'description' => esc_html__( 'Available tags: {{post_type}}.', 'suki' ),
				'input_attrs' => array(
					'placeholder' => '{{post_type}}',
				),
				'priority'    => 20,
			)
		);

		// Title text format on taxonomy archive pages.
		$subkey = 'tax_title_text';
		$key    = $option_prefix . '_' . $subkey;
		$wp_customize->add_setting(
			$key,
			array(
				'default'           => suki_array_value( $defaults, $key ),
				'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'text' ),
			)
		);
		$wp_customize->add_control(
			$key,
			array(
				'section'     => $section,
				'label'       => esc_html__( 'Taxonomy archive page title', 'suki' ),
				'description' => esc_html__( 'Available tags: {{taxonomy}}, {{term}}.', 'suki' ),
				'input_attrs' => array(
					'placeholder' => '{{taxonomy}}: {{term}}',
				),
				'priority'    => 20,
			)
		);
	}

	/**
	 * ====================================================
	 * Featured Image
	 * ====================================================
	 */

	if ( strpos( $page_type_key, '_single' ) && post_type_supports( $post_type_slug, 'thumbnail' ) ) {
		// Heading: Featured Image.
		$wp_customize->add_control(
			new Suki_Customize_Heading_Control(
				$wp_customize,
				'heading_' . $page_type_key . '_content_thumbnail',
				array(
					'section'  => $section,
					'settings' => array(),
					'label'    => esc_html__( 'Featured Image', 'suki' ),
					'priority' => 30,
				)
			)
		);

		// Display.
		$subkey = 'content_thumbnail_position';
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
				'label'    => esc_html__( 'Display', 'suki' ),
				'choices'  => array(
					''       => esc_html__( 'Disabled', 'suki' ),
					'before' => esc_html__( 'Before Content Header', 'suki' ),
					'after'  => esc_html__( 'After Content Header', 'suki' ),
				),
				'priority' => 30,
			)
		);

		// Wide alignment.
		$subkey = 'content_thumbnail_wide';
		$key    = $option_prefix . '_' . $subkey;
		$wp_customize->add_setting(
			$key,
			array(
				'default'           => suki_array_value( $defaults, $key ),
				'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
			)
		);
		$wp_customize->add_control(
			new Suki_Customize_Toggle_Control(
				$wp_customize,
				$key,
				array(
					'section'  => $section,
					'label'    => esc_html__( 'Wide alignment on Narrow container', 'suki' ),
					'priority' => 30,
				)
			)
		);
	}
}
