<?php
/**
 * Customizer sections
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( suki_show_pro_teaser() ) {
	// Suki Pro link.
	$wp_customize->add_section(
		new Suki_Customize_Pro_Link_Section(
			$wp_customize,
			'suki_section_pro_link',
			array(
				'title'    => esc_html_x( 'More Options Available in Suki Pro', 'Suki Pro upsell', 'suki' ),
				'url'      => esc_url(
					add_query_arg(
						array(
							'utm_source'   => 'suki-customizer',
							'utm_medium'   => 'learn-more',
							'utm_campaign' => 'theme-upsell',
						),
						SUKI_PRO_WEBSITE_URL
					)
				),
				'priority' => 9999,
			)
		)
	);
}

// --- Global
$wp_customize->add_section(
	new Suki_Customize_Spacer_Section(
		$wp_customize,
		'suki_section_spacer_global',
		array(
			'title'    => esc_html__( 'Global', 'suki' ),
			'priority' => 0,
		)
	)
);

// Global Configurations.
$panel = 'suki_panel_global_settings';
$wp_customize->add_panel(
	$panel,
	array(
		'title'    => esc_html__( 'Global Configurations', 'suki' ),
		'priority' => 121,
	)
);

// Global Configurations > Color Palette.
$wp_customize->add_section(
	'suki_section_color_palette',
	array(
		'title'       => esc_html__( 'Color Palette', 'suki' ),
		'description' => '<p>' . esc_html__( 'Save up to 8 colors that you frequently use while customizing your website.', 'suki' ) . '</p><p>' . esc_html__( 'These colors don\'t represent global colors (text, heading, border, etc.). To configure Global Colors, please navigate to Global Elements section.', 'suki' ) . '</p>',
		'panel'       => $panel,
		'priority'    => 10,
	)
);

// Global Configurations > Social.
$wp_customize->add_section(
	'suki_section_social',
	array(
		'title'       => esc_html__( 'Social Media Links', 'suki' ),
		'description' => '<p>' . esc_html__( 'Please use full URL format with the protocol. For example: "https://" or "mailto:".', 'suki' ) . '</p>',
		'panel'       => $panel,
		'priority'    => 10,
	)
);

// Global Elements.
$panel = 'suki_panel_global_elements';
$wp_customize->add_panel(
	$panel,
	array(
		'title'    => esc_html__( 'Global Elements', 'suki' ),
		'priority' => 122,
	)
);

// Global Elements > Base Typography.
$wp_customize->add_section(
	'suki_section_base',
	array(
		'title'    => esc_html__( 'Base Typography', 'suki' ),
		'panel'    => $panel,
		'priority' => 10,
	)
);

// Global Elements > Headings (H1 - H4).
$wp_customize->add_section(
	'suki_section_headings',
	array(
		'title'    => esc_html__( 'Headings (H1 - H6)', 'suki' ),
		'panel'    => $panel,
		'priority' => 10,
	)
);

// Global Elements > Blockquote.
$wp_customize->add_section(
	'suki_section_blockquote',
	array(
		'title'    => esc_html__( 'Blockquote', 'suki' ),
		'panel'    => $panel,
		'priority' => 10,
	)
);

// Global Elements > Form Input.
$wp_customize->add_section(
	'suki_section_form_input',
	array(
		'title'    => esc_html__( 'Form Input', 'suki' ),
		'panel'    => $panel,
		'priority' => 10,
	)
);

// Global Elements > Button.
$wp_customize->add_section(
	'suki_section_button',
	array(
		'title'    => esc_html__( 'Button', 'suki' ),
		'panel'    => $panel,
		'priority' => 10,
	)
);

// Global Elements > Title.
$wp_customize->add_section(
	'suki_section_title',
	array(
		'title'       => esc_html__( 'Title', 'suki' ),
		'description' => '<p>' . esc_html__( 'Used on Default Post title and Static Page title. By default, it uses H1 styles.', 'suki' ) . '</p>',
		'panel'       => $panel,
		'priority'    => 10,
	)
);

// Global Elements > Small Title.
$wp_customize->add_section(
	'suki_section_small_title',
	array(
		'title'       => esc_html__( 'Small Title', 'suki' ),
		'description' => '<p>' . esc_html__( 'Used on Grid Post title, and other subsidiary headings like "Leave a Reply", "2 Comments", etc. By default, it uses H3 styles.', 'suki' ) . '</p>',
		'panel'       => $panel,
		'priority'    => 10,
	)
);

// Global Elements > Meta Info.
$wp_customize->add_section(
	'suki_section_meta',
	array(
		'title'       => esc_html__( 'Meta Info', 'suki' ),
		'description' => '<p>' . esc_html__( 'Used on Post meta, Widget meta, Comments meta, and other small info text.', 'suki' ) . '</p>',
		'panel'       => $panel,
		'priority'    => 10,
	)
);

// Global Layout.
$panel = 'suki_panel_global_layout';
$wp_customize->add_panel(
	$panel,
	array(
		'title'    => esc_html__( 'Global Layout', 'suki' ),
		'priority' => 123,
	)
);

// Global Layout > Content Size & Spacing.
$wp_customize->add_section(
	'suki_section_global_size_spacing',
	array(
		'title'    => esc_html__( 'Content Size & Spacing', 'suki' ),
		'panel'    => $panel,
		'priority' => 10,
	)
);

// Global Layout > Page Canvas.
$wp_customize->add_section(
	'suki_section_page_canvas',
	array(
		'title'    => esc_html__( 'Page Canvas', 'suki' ),
		'panel'    => $panel,
		'priority' => 10,
	)
);

// Global Layout > Content Section.
$wp_customize->add_section(
	'suki_section_content',
	array(
		'title'    => esc_html__( 'Content Section', 'suki' ),
		'panel'    => $panel,
		'priority' => 10,
	)
);

// Global Layout > Main Content.
$wp_customize->add_section(
	'suki_section_main',
	array(
		'title'    => esc_html__( 'Main Content', 'suki' ),
		'panel'    => $panel,
		'priority' => 10,
	)
);

// Global Layout > Sidebar.
$wp_customize->add_section(
	'suki_section_sidebar',
	array(
		'title'    => esc_html__( 'Sidebar', 'suki' ),
		'panel'    => $panel,
		'priority' => 10,
	)
);

// Global Layout > Hero Section.
$wp_customize->add_section(
	'suki_section_hero',
	array(
		'title'       => esc_html__( 'Hero Section', 'suki' ),
		'description' => esc_html__( 'A section between header and content section that displays Content Header.', 'suki' ),
		'panel'       => $panel,
		'priority'    => 10,
	)
);

// Header.
$panel = 'suki_panel_header';
$wp_customize->add_panel(
	$panel,
	array(
		'title'    => esc_html__( 'Header', 'suki' ),
		'priority' => 124,
	)
);

// Header > Responsive Tabs.
$wp_customize->add_section(
	new Suki_Customize_Responsive_Tabs_Section(
		$wp_customize,
		'suki_section_header_responsive_tabs',
		array(
			'panel'    => $panel,
			'priority' => 10,
		)
	)
);

// Header > Header Builder.
$wp_customize->add_section(
	new Suki_Customize_Builder_Section(
		$wp_customize,
		'suki_section_header_builder',
		array(
			'title'    => esc_html__( 'Header Builder', 'suki' ),
			'panel'    => $panel,
			'priority' => 10,
		)
	)
);

// Header > --- Areas.
$wp_customize->add_section(
	new Suki_Customize_Spacer_Section(
		$wp_customize,
		'suki_section_spacer_header_bars',
		array(
			'title'    => esc_html__( 'Areas', 'suki' ),
			'panel'    => $panel,
			'priority' => 10,
		)
	)
);

// Header > Top Bar.
$wp_customize->add_section(
	'suki_section_header_top_bar',
	array(
		'title'    => esc_html__( 'Top Bar', 'suki' ),
		'panel'    => $panel,
		'priority' => 10,
	)
);

// Header > Main Bar.
$wp_customize->add_section(
	'suki_section_header_main_bar',
	array(
		'title'    => esc_html__( 'Main Bar', 'suki' ),
		'panel'    => $panel,
		'priority' => 10,
	)
);

// Header > Bottom Bar.
$wp_customize->add_section(
	'suki_section_header_bottom_bar',
	array(
		'title'    => esc_html__( 'Bottom Bar', 'suki' ),
		'panel'    => $panel,
		'priority' => 10,
	)
);

// Header > Mobile Main Bar.
$wp_customize->add_section(
	'suki_section_header_mobile_main_bar',
	array(
		'title'    => esc_html__( 'Mobile Main Bar', 'suki' ),
		'panel'    => $panel,
		'priority' => 20,
	)
);

// Header > Mobile Drawer.
$wp_customize->add_section(
	'suki_section_header_mobile_vertical_bar',
	array(
		'title'       => esc_html__( 'Mobile Popup', 'suki' ),
		'description' => esc_html__( 'This would appear when the "Toggle" element is clicked. Please make sure you have added the "Toggle" element into the Mobile Main Bar.', 'suki' ),
		'panel'       => $panel,
		'priority'    => 20,
	)
);

// Header > --- Elements.
$wp_customize->add_section(
	new Suki_Customize_Spacer_Section(
		$wp_customize,
		'suki_section_spacer_header_elements',
		array(
			'title'    => esc_html__( 'Elements', 'suki' ),
			'panel'    => $panel,
			'priority' => 30,
		)
	)
);

// Header > Logo.
$wp_customize->add_section(
	'suki_section_header_logo',
	array(
		'title'    => esc_html__( 'Logo', 'suki' ),
		'panel'    => $panel,
		'priority' => 30,
	)
);

// Header > Menu.
$wp_customize->add_section(
	'suki_section_header_menu',
	array(
		'title'    => esc_html__( 'Menu', 'suki' ),
		'panel'    => $panel,
		'priority' => 30,
	)
);

// Header > Search.
$wp_customize->add_section(
	'suki_section_header_search',
	array(
		'title'    => esc_html__( 'Search', 'suki' ),
		'panel'    => $panel,
		'priority' => 30,
	)
);

// Header > HTML.
$wp_customize->add_section(
	'suki_section_header_html',
	array(
		'title'    => esc_html__( 'HTML', 'suki' ),
		'panel'    => $panel,
		'priority' => 30,
	)
);

// Header > Social.
$wp_customize->add_section(
	'suki_section_header_social',
	array(
		'title'    => esc_html__( 'Social', 'suki' ),
		'panel'    => $panel,
		'priority' => 30,
	)
);

// Header > More Options Available.
if ( suki_show_pro_teaser() ) {
	$wp_customize->add_section(
		new Suki_Customize_Pro_Teaser_Section(
			$wp_customize,
			'suki_section_teaser_pro_upsell_header',
			array(
				'title'    => esc_html_x( 'More Options Available in Suki Pro', 'Suki Pro upsell', 'suki' ),
				'panel'    => $panel,
				'url'      => esc_url(
					add_query_arg(
						array(
							'utm_source'   => 'suki-customizer',
							'utm_medium'   => 'learn-more',
							'utm_campaign' => 'theme-upsell',
						),
						SUKI_PRO_WEBSITE_URL
					)
				),
				'features' => array(
					esc_html_x( 'More Header Elements', 'Suki Pro upsell', 'suki' ),
					esc_html_x( 'Vertical Header', 'Suki Pro upsell', 'suki' ),
					esc_html_x( 'Transparent Header', 'Suki Pro upsell', 'suki' ),
					esc_html_x( 'Alternate Header Colors', 'Suki Pro upsell', 'suki' ),
					esc_html_x( 'Sticky Header', 'Suki Pro upsell', 'suki' ),
					esc_html_x( 'Mega Menu', 'Suki Pro upsell', 'suki' ),
				),
				'priority' => 90,
			)
		)
	);
}

// Footer.
$panel = 'suki_panel_footer';
$wp_customize->add_panel(
	$panel,
	array(
		'title'    => esc_html__( 'Footer', 'suki' ),
		'priority' => 125,
	)
);

// Footer > Footer Builder.
$wp_customize->add_section(
	new Suki_Customize_Builder_Section(
		$wp_customize,
		'suki_section_footer_builder',
		array(
			'title'    => esc_html__( 'Footer Builder', 'suki' ),
			'panel'    => $panel,
			'priority' => 10,
		)
	)
);

// Footer > --- Areas.
$wp_customize->add_section(
	new Suki_Customize_Spacer_Section(
		$wp_customize,
		'suki_section_spacer_footer_bars',
		array(
			'title'    => esc_html__( 'Areas', 'suki' ),
			'panel'    => $panel,
			'priority' => 10,
		)
	)
);

// Footer > Widgets Bar.
$wp_customize->add_section(
	'suki_section_footer_widgets_bar',
	array(
		'title'    => esc_html__( 'Widgets Bar', 'suki' ),
		'panel'    => $panel,
		'priority' => 20,
	)
);

// Footer > Bottom Bar.
$wp_customize->add_section(
	'suki_section_footer_bottom_bar',
	array(
		'title'    => esc_html__( 'Bottom Bar', 'suki' ),
		'panel'    => $panel,
		'priority' => 20,
	)
);

// Footer > --- Elements.
$wp_customize->add_section(
	new Suki_Customize_Spacer_Section(
		$wp_customize,
		'suki_section_spacer_footer_elements',
		array(
			'title'    => esc_html__( 'Elements', 'suki' ),
			'panel'    => $panel,
			'priority' => 30,
		)
	)
);

// Footer > Copyright.
$wp_customize->add_section(
	'suki_section_footer_copyright',
	array(
		'title'    => esc_html__( 'Copyright', 'suki' ),
		'panel'    => $panel,
		'priority' => 30,
	)
);

// Footer > HTML.
$wp_customize->add_section(
	'suki_section_footer_html',
	array(
		'title'    => esc_html__( 'HTML', 'suki' ),
		'panel'    => $panel,
		'priority' => 30,
	)
);

// Footer > Social.
$wp_customize->add_section(
	'suki_section_footer_social',
	array(
		'title'    => esc_html__( 'Social', 'suki' ),
		'panel'    => $panel,
		'priority' => 30,
	)
);

// Footer > Scroll To Top.
$wp_customize->add_section(
	'suki_section_scroll_to_top',
	array(
		'title'    => esc_html__( 'Scroll To Top', 'suki' ),
		'panel'    => $panel,
		'priority' => 39,
	)
);

// Footer > More Options Available.
if ( suki_show_pro_teaser() ) {
	$wp_customize->add_section(
		new Suki_Customize_Pro_Teaser_Section(
			$wp_customize,
			'suki_section_teaser_pro_upsell_footer',
			array(
				'title'    => esc_html_x( 'More Options Available in Suki Pro', 'Suki Pro upsell', 'suki' ),
				'panel'    => $panel,
				'url'      => esc_url(
					add_query_arg(
						array(
							'utm_source'   => 'suki-customizer',
							'utm_medium'   => 'learn-more',
							'utm_campaign' => 'theme-upsell',
						),
						SUKI_PRO_WEBSITE_URL
					)
				),
				'features' => array(
					esc_html_x( 'Dynamic & Responsive Widgets Column Width', 'Suki Pro upsell', 'suki' ),
				),
				'priority' => 90,
			)
		)
	);
}

// --- Pages.
$wp_customize->add_section(
	new Suki_Customize_Spacer_Section(
		$wp_customize,
		'suki_section_spacer_pages',
		array(
			'title'    => esc_html__( 'Pages', 'suki' ),
			'priority' => 140,
		)
	)
);

// Blog.
$panel = 'suki_panel_blog';
$wp_customize->add_panel(
	$panel,
	array(
		'title'    => esc_html__( 'Blog', 'suki' ),
		'priority' => 141,
	)
);

// Blog > --- Pages.
$wp_customize->add_section(
	new Suki_Customize_Spacer_Section(
		$wp_customize,
		'suki_section_spacer_blog_pages',
		array(
			'title'    => esc_html__( 'Pages', 'suki' ),
			'panel'    => $panel,
			'priority' => 10,
		)
	)
);

// Blog > Post Archive Page.
$wp_customize->add_section(
	'suki_section_post_archive',
	array(
		'title'    => esc_html__( 'Posts Archive Page', 'suki' ),
		'panel'    => $panel,
		'priority' => 10,
	)
);

// Blog > Post Archive Page > Default.
$wp_customize->add_section(
	'suki_section_entry_default',
	array(
		'title'    => esc_html__( 'Default', 'suki' ),
		'panel'    => $panel,
		'priority' => 10,
	)
);

// Blog > Post Archive Page >Grid.
$wp_customize->add_section(
	'suki_section_entry_grid',
	array(
		'title'    => esc_html__( 'Grid', 'suki' ),
		'panel'    => $panel,
		'priority' => 10,
	)
);

// Blog > Single Post Page.
$wp_customize->add_section(
	'suki_section_post_single',
	array(
		'title'    => esc_html__( 'Single Post Page', 'suki' ),
		'panel'    => $panel,
		'priority' => 15,
	)
);

// Other Pages.
$panel = 'suki_panel_other_pages';
$wp_customize->add_panel(
	$panel,
	array(
		'title'    => esc_html__( 'Other Pages', 'suki' ),
		'priority' => 149,
	)
);

// Other Pages > --- Default Pages.
$wp_customize->add_section(
	new Suki_Customize_Spacer_Section(
		$wp_customize,
		'suki_section_spacer_page_settings_others',
		array(
			'title'    => esc_html__( 'Default Pages', 'suki' ),
			'panel'    => $panel,
			'priority' => 10,
		)
	)
);

// Other Pages > Static Page.
$wp_customize->add_section(
	'suki_section_page_single',
	array(
		'title'    => esc_html__( 'Static Page', 'suki' ),
		'panel'    => $panel,
		'priority' => 10,
	)
);

// Other Pages > Search Results Page.
$wp_customize->add_section(
	'suki_section_search_results',
	array(
		'title'    => esc_html__( 'Search Results Page', 'suki' ),
		'panel'    => $panel,
		'priority' => 10,
	)
);

// Other Pages > Error 404 Page.
$wp_customize->add_section(
	'suki_section_error_404',
	array(
		'title'    => esc_html__( 'Error 404 Page', 'suki' ),
		'panel'    => $panel,
		'priority' => 10,
	)
);

// Other Pages > Custom Post Types.
$i = 10;
foreach ( Suki_Customizer::instance()->get_page_types( 'custom' ) as $page_type_key => $page_type_data ) {
	// Get post type object..
	// First check if $page_type_key is not for 404 and search page..
	$post_type_slug = preg_replace( '/(_single|_archive)/', '', $page_type_key );
	$post_type_obj  = get_post_type_object( $post_type_slug );

	// Increment section priority..
	$i += 10;

	// Skip section creation if it already exists..
	if ( $wp_customize->get_section( suki_array_value( $page_type_data, 'section' ) ) ) {
		continue;
	}

	// Add separator .
	if ( 0 < strpos( $page_type_key, '_archive' ) ) {
		// Other Pages > --- [Custom Post Type].
		$wp_customize->add_section(
			new Suki_Customize_Spacer_Section(
				$wp_customize,
				'suki_section_spacer_page_settings_' . $post_type_slug,
				array(
					/* translators: %s: Custom post type's plural name. */
					'title'    => $post_type_obj->labels->name,
					'panel'    => $panel,
					'priority' => $i,
				)
			)
		);
	}

	$description = suki_array_value( $page_type_data, 'description' );

	// Other Pages > [Custom Post Type] Archive Page / Single [Custom Post Type] Page.
	$wp_customize->add_section(
		suki_array_value( $page_type_data, 'section' ),
		array(
			'title'       => suki_array_value( $page_type_data, 'title' ),
			'panel'       => $panel,
			'description' => ! empty( $description ) ? '<p>' . $description . '</p>' : '',
			'priority'    => $i,
		)
	);
}

// --- Core.
$wp_customize->add_section(
	new Suki_Customize_Spacer_Section(
		$wp_customize,
		'suki_section_spacer_core',
		array(
			'title'    => esc_html__( 'Core', 'suki' ),
			'priority' => 159,
		)
	)
);
