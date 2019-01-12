<?php
/**
 * Customizer sections
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( suki_show_pro_teaser() ) {
	// Suki Pro link
	$wp_customize->add_section( new Suki_Customize_Section_Pro_Link( $wp_customize, 'suki_section_pro_link', array(
		'title'       => esc_html_x( 'Premium Modules Available', 'Suki Pro upsell', 'suki' ),
		'url'         => SUKI_PRO_URL,
		'priority'    => 0,
	) ) );

	// ------
	$wp_customize->add_section( new Suki_Customize_Section_Spacer( $wp_customize, 'suki_section_spacer_pro_link', array(
		'priority'    => 0,
	) ) );
}

// Global Settings
$panel = 'suki_panel_global_settings';
$wp_customize->add_panel( $panel, array(
	'title'       => esc_html__( 'Global Settings', 'suki' ),
	'priority'    => 1,
) );
	// Site Identity
	$wp_customize->get_section( 'title_tagline' )->panel = $panel;
	$wp_customize->get_section( 'title_tagline' )->priority = 10;

	// Homepage Settings
	$wp_customize->get_section( 'static_front_page' )->panel = $panel;
	$wp_customize->get_section( 'static_front_page' )->priority = 10;

	// ------
	$wp_customize->add_section( new Suki_Customize_Section_Spacer( $wp_customize, 'suki_section_spacer_global_settings', array(
		'panel'       => $panel,
		'priority'    => 20,
	) ) );

	// Customizer CSS
	$wp_customize->add_section( 'suki_section_customizer_css', array(
		'title'       => esc_html__( 'Customizer CSS', 'suki' ),
		'panel'       => $panel,
		'priority'    => 20,
	) );

	// Google Fonts
	$wp_customize->add_section( 'suki_section_google_fonts', array(
		'title'       => esc_html__( 'Google Fonts', 'suki' ),
		'panel'       => $panel,
		'priority'    => 20,
	) );

	// Social
	$wp_customize->add_section( 'suki_section_social', array(
		'title'       => esc_html__( 'Social Media Links', 'suki' ),
		'description' => esc_html__( 'Please use full URL format with http:// or https://', 'suki' ),
		'panel'       => $panel,
		'priority'    => 20,
	) );

// ------
$wp_customize->add_section( new Suki_Customize_Section_Spacer( $wp_customize, 'suki_section_spacer_170', array(
	'priority'    => 170,
) ) );

// General Elements
$panel = 'suki_panel_global_elements';
$wp_customize->add_panel( $panel, array(
	'title'       => esc_html__( 'General Elements', 'suki' ),
	'priority'    => 171,
) );

	// Body (Base)
	$wp_customize->add_section( 'suki_section_body', array(
		'title'       => esc_html__( 'Body (Base)', 'suki' ),
		'description' => esc_html__( 'The global settings of body typography and colors.', 'suki' ),
		'panel'       => $panel,
		'priority'    => 10,
	) );

	// Headings (H1 - H4)
	$wp_customize->add_section( 'suki_section_headings', array(
		'title'       => esc_html__( 'Headings (H1 - H4)', 'suki' ),
		'description' => esc_html__( 'Used on all H1 - H4 tags globally.', 'suki' ),
		'panel'       => $panel,
		'priority'    => 10,
	) );

	// Blockquote
	$wp_customize->add_section( 'suki_section_blockquote', array(
		'title'       => esc_html__( 'Blockquote', 'suki' ),
		'panel'       => $panel,
		'priority'    => 10,
	) );

	// Form Input
	$wp_customize->add_section( 'suki_section_form_input', array(
		'title'       => esc_html__( 'Form Input', 'suki' ),
		'panel'       => $panel,
		'priority'    => 10,
	) );

	// Button
	$wp_customize->add_section( 'suki_section_button', array(
		'title'       => esc_html__( 'Button', 'suki' ),
		'panel'       => $panel,
		'priority'    => 10,
	) );

	// Title
	$wp_customize->add_section( 'suki_section_title', array(
		'title'       => esc_html__( 'Title', 'suki' ),
		'description' => esc_html__( 'Used on Default Post title and Static Page title. By default, it uses H1 styles.', 'suki' ),
		'panel'       => $panel,
		'priority'    => 10,
	) );

	// Small Title
	$wp_customize->add_section( 'suki_section_small_title', array(
		'title'       => esc_html__( 'Small Title', 'suki' ),
		'description' => esc_html__( 'Used on Grid Post title, and other subsidiary headings like "Leave a Reply", "2 Comments", etc. By default, it uses H3 styles.', 'suki' ),
		'panel'       => $panel,
		'priority'    => 10,
	) );

	// Meta Info
	$wp_customize->add_section( 'suki_section_meta', array(
		'title'       => esc_html__( 'Meta Info', 'suki' ),
		'description' => esc_html__( 'Used on Post meta, Widget meta, Comments meta, and other small info text.', 'suki' ),
		'panel'       => $panel,
		'priority'    => 10,
	) );

// Page Canvas & Wrapper
$wp_customize->add_section( 'suki_section_page_container', array(
	'title'       => esc_html__( 'Page Canvas & Wrapper', 'suki' ),
	'priority'    => 172,
) );

// Header
$panel = 'suki_panel_header';
$wp_customize->add_panel( $panel, array(
	'title'       => esc_html__( 'Header', 'suki' ),
	'description' => esc_html__( 'Tips: you can customize the Mobile Header by switching to tablet / mobile view.', 'suki' ),
	'priority'    => 173,
) );

	// Header Builder
	$wp_customize->add_section( 'suki_section_header_builder', array(
		'title'       => esc_html__( 'Header Builder', 'suki' ),
		'panel'       => $panel,
		'priority'    => 10,
	) );

	// ------
	$wp_customize->add_section( new Suki_Customize_Section_Spacer( $wp_customize, 'suki_section_spacer_header_bars', array(
		'panel'       => $panel,
		'priority'    => 10,
	) ) );

	// Top Bar
	$wp_customize->add_section( 'suki_section_header_top_bar', array(
		'title'       => esc_html__( 'Top Bar', 'suki' ),
		'panel'       => $panel,
		'priority'    => 10,
	) );

	// Main Bar
	$wp_customize->add_section( 'suki_section_header_main_bar', array(
		'title'       => esc_html__( 'Main Bar', 'suki' ),
		'panel'       => $panel,
		'priority'    => 10,
	) );

	// Bottom Bar
	$wp_customize->add_section( 'suki_section_header_bottom_bar', array(
		'title'       => esc_html__( 'Bottom Bar', 'suki' ),
		'panel'       => $panel,
		'priority'    => 10,
	) );

	// ------
	$wp_customize->add_section( new Suki_Customize_Section_Spacer( $wp_customize, 'suki_section_spacer_header_mobile_bars', array(
		'panel'       => $panel,
		'priority'    => 20,
	) ) );

	// Mobile Main Bar
	$wp_customize->add_section( 'suki_section_header_mobile_main_bar', array(
		'title'       => esc_html__( 'Mobile Main Bar', 'suki' ),
		'panel'       => $panel,
		'priority'    => 20,
	) );

	// Mobile Drawer
	$wp_customize->add_section( 'suki_section_header_mobile_vertical_bar', array(
		'title'       => esc_html__( 'Mobile Drawer (Popup)', 'suki' ),
		'panel'       => $panel,
		'priority'    => 20,
	) );

	// ------
	$wp_customize->add_section( new Suki_Customize_Section_Spacer( $wp_customize, 'suki_section_spacer_header_elements', array(
		'panel'       => $panel,
		'priority'    => 40,
	) ) );

	// Logo
	$wp_customize->add_section( 'suki_section_header_logo', array(
		'title'       => esc_html__( 'Element: Logo', 'suki' ),
		'panel'       => $panel,
		'priority'    => 40,
	) );

	// Search
	$wp_customize->add_section( 'suki_section_header_search', array(
		'title'       => esc_html__( 'Element: Search', 'suki' ),
		'panel'       => $panel,
		'priority'    => 40,
	) );

	// HTML
	$wp_customize->add_section( 'suki_section_header_html', array(
		'title'       => esc_html__( 'Element: HTML(s)', 'suki' ),
		'panel'       => $panel,
		'priority'    => 40,
	) );

	// Social
	$wp_customize->add_section( 'suki_section_header_social', array(
		'title'       => esc_html__( 'Element: Social', 'suki' ),
		'panel'       => $panel,
		'priority'    => 40,
	) );

	if ( suki_show_pro_teaser() ) {
		// ------
		$wp_customize->add_section( new Suki_Customize_Section_Spacer( $wp_customize, 'suki_section_spacer_header_advanced', array(
			'panel'       => $panel,
			'priority'    => 90,
		) ) );

		// More Options Available on Suki Pro
		$wp_customize->add_section( new Suki_Customize_Section_Pro_Teaser( $wp_customize, 'suki_section_pro_header_advanced', array(
			'title'       => esc_html_x( 'More Options on Suki Pro', 'Suki Pro upsell', 'suki' ),
			'panel'       => $panel,
			'url'         => SUKI_PRO_URL,
			'features'    => array(
				esc_html_x( 'More header elements', 'Suki Pro upsell', 'suki' ),
				esc_html_x( 'Vertical bar (drawer & permanent style)', 'Suki Pro upsell', 'suki' ),
				esc_html_x( 'Transparent header', 'Suki Pro upsell', 'suki' ),
				esc_html_x( 'Alternate header colors', 'Suki Pro upsell', 'suki' ),
				esc_html_x( 'Sticky header', 'Suki Pro upsell', 'suki' ),
			),
			'priority'    => 90,
		) ) );
	}

// Page Header (Title Bar)
$wp_customize->add_section( 'suki_section_page_header', array(
	'title'       => esc_html__( 'Page Header (Title Bar)', 'suki' ),
	'priority'    => 174,
) );

// Content & Sidebar
$panel = 'suki_panel_content';
$wp_customize->add_panel( $panel, array(
	'title'       => esc_html__( 'Content & Sidebar', 'suki' ),
	'priority'    => 175,
) );

	// Content Section
	$wp_customize->add_section( 'suki_section_content', array(
		'title'       => esc_html__( 'Content Section', 'suki' ),
		'panel'       => $panel,
		'priority'    => 10,
	) );

	// ------
	$wp_customize->add_section( new Suki_Customize_Section_Spacer( $wp_customize, 'suki_section_spacer_content', array(
		'panel'       => $panel,
		'priority'    => 10,
	) ) );

	// Main Content Area
	$wp_customize->add_section( 'suki_section_main', array(
		'title'       => esc_html__( 'Main Content Area', 'suki' ),
		'panel'       => $panel,
		'priority'    => 10,
	) );

	// Sidebar Area
	$wp_customize->add_section( 'suki_section_sidebar', array(
		'title'       => esc_html__( 'Sidebar Area', 'suki' ),
		'panel'       => $panel,
		'priority'    => 10,
	) );

// Footer
$panel = 'suki_panel_footer';
$wp_customize->add_panel( $panel, array(
	'title'       => esc_html__( 'Footer', 'suki' ),
	'priority'    => 176,
) );

	// Footer Builder
	$wp_customize->add_section( 'suki_section_footer_builder', array(
		'title'       => esc_html__( 'Footer Builder', 'suki' ),
		'panel'       => $panel,
		'priority'    => 10,
	) );

	// ------
	$wp_customize->add_section( new Suki_Customize_Section_Spacer( $wp_customize, 'suki_section_spacer_footer_bars', array(
		'panel'       => $panel,
		'priority'    => 10,
	) ) );

	// Widgets Bar
	$wp_customize->add_section( 'suki_section_footer_widgets_bar', array(
		'title'       => esc_html__( 'Widgets Bar', 'suki' ),
		'panel'       => $panel,
		'priority'    => 20,
	) );

	// Bottom Bar
	$wp_customize->add_section( 'suki_section_footer_bottom_bar', array(
		'title'       => esc_html__( 'Bottom Bar', 'suki' ),
		'panel'       => $panel,
		'priority'    => 20,
	) );

	// ------
	$wp_customize->add_section( new Suki_Customize_Section_Spacer( $wp_customize, 'suki_section_spacer_footer_elements', array(
		'panel'       => $panel,
		'priority'    => 30,
	) ) );

	// Widgets
	$wp_customize->add_section( 'suki_section_footer_widgets_column', array(
		'title'       => esc_html__( 'Element: Widgets Column(s)', 'suki' ),
		'panel'       => $panel,
		'priority'    => 30,
	) );

	// Copyright
	$wp_customize->add_section( 'suki_section_footer_copyright', array(
		'title'       => esc_html__( 'Element: Copyright', 'suki' ),
		'panel'       => $panel,
		'priority'    => 30,
	) );

	// Menu
	$wp_customize->add_section( 'suki_section_footer_menu', array(
		'title'       => esc_html__( 'Element: Menu', 'suki' ),
		'panel'       => $panel,
		'priority'    => 30,
	) );

	// Social
	$wp_customize->add_section( 'suki_section_footer_social', array(
		'title'       => esc_html__( 'Element: Social', 'suki' ),
		'panel'       => $panel,
		'priority'    => 30,
	) );

	if ( suki_show_pro_teaser() ) {
		// ------
		$wp_customize->add_section( new Suki_Customize_Section_Spacer( $wp_customize, 'suki_section_spacer_footer_advanced', array(
			'panel'       => $panel,
			'priority'    => 90,
		) ) );

		// More Options Available on Suki Pro
		$wp_customize->add_section( new Suki_Customize_Section_Pro_Teaser( $wp_customize, 'suki_section_pro_footer_advanced', array(
			'title'       => esc_html_x( 'More Options on Suki Pro', 'Suki Pro upsell', 'suki' ),
			'panel'       => $panel,
			'url'         => SUKI_PRO_URL,
			'features'    => array(
				esc_html_x( 'Dynamic widgets column width (responsive)', 'Suki Pro upsell', 'suki' ),
			),
			'priority'    => 90,
		) ) );
	}

// ------
$wp_customize->add_section( new Suki_Customize_Section_Spacer( $wp_customize, 'suki_section_spacer_180', array(
	'priority'    => 180,
) ) );

// Blog
$panel = 'suki_section_blog';
$wp_customize->add_panel( $panel, array(
	'title'       => esc_html__( 'Blog', 'suki' ),
	'priority'    => 181,
) );

	// Post Index
	$wp_customize->add_section( 'suki_section_blog_index', array(
		'title'       => esc_html__( 'Posts Page', 'suki' ),
		'panel'       => $panel,
	) );

	// Single Post
	$wp_customize->add_section( 'suki_section_blog_single', array(
		'title'       => esc_html__( 'Single Post Page', 'suki' ),
		'description' => sprintf(
			/* translators: %s: link to "Post Layout: Default" section. */
			esc_html__( '"Default" post layout is used as the main post layout. You can configure it on %s', 'suki' ),
			'<a href="' . esc_attr( add_query_arg( 'autofocus[section]', 'suki_section_entry_default', remove_query_arg( 'autofocus' ) ) ) . '" class="suki-customize-goto-control">' . esc_html__( 'Post Layout: Default', 'suki' ) . '</a>'
		),
		'panel'       => $panel,
	) );

	// ------
	$wp_customize->add_section( new Suki_Customize_Section_Spacer( $wp_customize, 'suki_section_spacer_entry', array(
		'panel'       => $panel,
	) ) );

	// Post Layout: Default
	$wp_customize->add_section( 'suki_section_entry_default', array(
		'title'       => esc_html__( 'Post Layout: Default', 'suki' ),
		'panel'       => $panel,
	) );

	// Post Layout: Grid
	$wp_customize->add_section( 'suki_section_entry_grid', array(
		'title'       => esc_html__( 'Post Layout: Grid', 'suki' ),
		'panel'       => $panel,
	) );

// ------
$wp_customize->add_section( new Suki_Customize_Section_Spacer( $wp_customize, 'suki_section_spacer_190', array(
	'priority'    => 190,
) ) );

// Page Settings
$panel = 'suki_panel_page_settings';
$wp_customize->add_panel( $panel, array(
	'title'       => esc_html__( 'Page Settings', 'suki' ),
	'description' => esc_html__( 'Page Settings allows you to override global configuration of page elements (Header, Title Bar, Content, and Footer) on each different page type.', 'suki' ),
	'priority'    => 191,
) );

	// Begin registering sections.
	$i = 10;
	foreach ( Suki_Customizer::instance()->get_all_page_settings_types() as $type => $type_data ) {
		if ( 0 < strpos( $type, '_archive' ) ) {
			$wp_customize->add_section( new Suki_Customize_Section_Spacer( $wp_customize, 'suki_section_spacer_page_settings_' . $i, array(
				'panel'       => $panel,
				'priority'    => $i,
			) ) );
		}

		$wp_customize->add_section( 'suki_section_page_settings_' . $type, array(
			'title'       => suki_array_value( $type_data, 'title' ),
			'description' => suki_array_value( $type_data, 'description' ),
			'panel'       => $panel,
			'priority'    => $i,
		) );

		$i += 10;
	}