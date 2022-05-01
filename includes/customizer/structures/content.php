<?php
/**
 * Customizer settings: Content > Content Section
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$section = 'suki_section_content';

/**
 * ====================================================
 * Layout
 * ====================================================
 */

// Container width.
$key = 'content_container';
$wp_customize->add_setting(
	$key,
	array(
		'default'           => suki_array_value( $defaults, $key ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
	)
);
$wp_customize->add_control(
	new Suki_Customize_Control_RadioImage(
		$wp_customize,
		$key,
		array(
			'section'  => $section,
			'label'    => esc_html__( 'Container width', 'suki' ) . ' <span class="suki-global-default-badge suki-tooltip" tabindex="0" data-tooltip="' . esc_attr__( 'You can override this option on each individual page.', 'suki' ) . '"><span class="dashicons dashicons-admin-site-alt3"></span> ' . esc_html__( 'Global', 'suki' ) . '</span>',
			'choices'  => array(
				'narrow' => array(
					'label' => '<span class="dashicons dashicons-align-center"></span> ' . esc_html__( 'Narrow', 'suki' ),
				),
				'wide'   => array(
					'label' => '<span class="dashicons dashicons-align-wide"></span> ' . esc_html__( 'Wide', 'suki' ),
				),
				'full'   => array(
					'label' => '<span class="dashicons dashicons-align-full-width"></span> ' . esc_html__( 'Full', 'suki' ),
				),
			),
			'columns'  => 3,
			'priority' => 10,
		)
	)
);

// Info.
$wp_customize->add_control(
	new Suki_Customize_Control_Blank(
		$wp_customize,
		'notice_narrow_content_layout',
		array(
			'section'     => $section,
			'settings'    => array(),
			'description' => '<div class="notice notice-info notice-alt inline"><p>' . esc_html__( 'Narrow content layout doesn\'t support Sidebar.', 'suki' ) . '</p></div>',
			'priority'    => 10,
		)
	)
);

// Sidebar.
$key = 'content_layout';
$wp_customize->add_setting(
	$key,
	array(
		'default'           => suki_array_value( $defaults, $key ),
		'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'select' ),
	)
);

$wp_customize->add_control(
	new Suki_Customize_Control_RadioImage(
		$wp_customize,
		$key,
		array(
			'section'  => $section,
			'label'    => esc_html__( 'Sidebar', 'suki' ) . ' <span class="suki-global-default-badge suki-tooltip" tabindex="0" data-tooltip="' . esc_attr__( 'You can override this option on each individual page.', 'suki' ) . '"><span class="dashicons dashicons-admin-site-alt3"></span> ' . esc_html__( 'Global', 'suki' ) . '</span>',
			'choices'  => array(
				'no-sidebar'    => array(
					'label' => esc_html__( 'Disabled', 'suki' ),
				),
				'left-sidebar'  => array(
					'label' => '<span class="dashicons dashicons-align-pull-left"></span> ' . esc_html__( 'Left', 'suki' ),
				),
				'right-sidebar' => array(
					'label' => '<span class="dashicons dashicons-align-pull-right"></span> ' . esc_html__( 'Right', 'suki' ),
				),
			),
			'columns'  => 3,
			'priority' => 10,
		)
	)
);

// ------
$wp_customize->add_control(
	new Suki_Customize_Control_HR(
		$wp_customize,
		'hr_content_layout',
		array(
			'section'  => $section,
			'settings' => array(),
			'priority' => 10,
		)
	)
);

// Padding.
$key      = 'content_padding';
$settings = array(
	$key,
	$key . '__tablet',
	$key . '__mobile',
);
foreach ( $settings as $setting ) {
	$wp_customize->add_setting(
		$setting,
		array(
			'default'           => suki_array_value( $defaults, $setting ),
			'transport'         => 'postMessage',
			'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'dimensions' ),
		)
	);
}
$wp_customize->add_control(
	new Suki_Customize_Dimensions_Control(
		$wp_customize,
		$key,
		array(
			'settings' => $settings,
			'section'  => $section,
			'label'    => esc_html__( 'Padding', 'suki' ),
			'units'    => array(
				'px'  => array(
					'min'  => 0,
					'step' => 1,
				),
				'em'  => array(
					'min'  => 0,
					'step' => 0.01,
				),
				'rem' => array(
					'min'  => 0,
					'step' => 0.01,
				),
				'%'   => array(
					'min'  => 0,
					'step' => 0.01,
				),
			),
			'priority' => 10,
		)
	)
);
