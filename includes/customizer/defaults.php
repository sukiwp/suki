<?php
/**
 * Customizer default values.
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$colors = suki_get_default_colors();

$add = array();

/**
 * ====================================================
 * Global Modules > Color Palette
 * ====================================================
 */

$add['color_palette_1'] = $colors['heading'];
$add['color_palette_2'] = $colors['text'];
$add['color_palette_3'] = $colors['accent'];
$add['color_palette_4'] = $colors['accent2'];
$add['color_palette_5'] = $colors['border'];
$add['color_palette_6'] = $colors['subtle'];
$add['color_palette_7'] = $colors['white'];
$add['color_palette_8'] = $colors['black'];

/**
 * ====================================================
 * Global Modules > Google Fonts
 * ====================================================
 */

$add['google_fonts_subsets'] = array();

/**
 * ====================================================
 * Typography & Colors > Base Typography & Colors
 * ====================================================
 */

$add['body_font_family'] = 'web_safe_fonts|Default System Font';
$add['body_font_size']   = '16px';
$add['body_line_height'] = '1.7';

$add['font_smoothing'] = 0;

$add['body_text_color'] = $colors['text'];

/**
 * ====================================================
 * Typography & Colors > Border & Subtle Background
 * ====================================================
 */

$add['subtle_color'] = $colors['subtle'];
$add['border_color'] = $colors['border'];

/**
 * ====================================================
 * Typography & Colors > Link
 * ====================================================
 */

$add['link_text_color']       = $colors['accent'];
$add['link_hover_text_color'] = $colors['heading'];

/**
 * ====================================================
 * Typography & Colors > Headings
 * ====================================================
 */

$add['h1_font_weight'] = 600;
$add['h1_font_size']   = '32px';
$add['h1_line_height'] = '1.3';

$add['h2_font_weight'] = 600;
$add['h2_font_size']   = '27px';
$add['h2_line_height'] = '1.4';

$add['h3_font_weight'] = 600;
$add['h3_font_size']   = '22px';
$add['h3_line_height'] = '1.5';

$add['h4_font_weight'] = 600;
$add['h4_font_size']   = '18px';
$add['h4_line_height'] = '1.6';

$add['heading_text_color']       = $colors['heading'];
$add['heading_hover_text_color'] = '';

/**
 * ====================================================
 * Typography & Colors > Blockquote
 * ====================================================
 */

$add['blockquote_font_weight'] = 300;
$add['blockquote_font_style']  = 'italic';
$add['blockquote_font_size']   = '1.2em';
$add['blockquote_line_height'] = '1.6';

/**
 * ====================================================
 * Typography & Colors > Form Input
 * ====================================================
 */

$add['input_padding']       = '10px 12px 10px 12px';
$add['input_border']        = '1px 1px 1px 1px';
$add['input_border_radius'] = '3px';

$add['input_bg_color']           = $colors['bg'];
$add['input_focus_border_color'] = $colors['text'];

/**
 * ====================================================
 * Typography & Colors > Button
 * ====================================================
 */

$add['button_padding']       = '10px 20px 10px 20px';
$add['button_border']        = '1px 1px 1px 1px';
$add['button_border_radius'] = '3px';

$add['button_font_weight'] = 600;
$add['button_font_size']   = '1rem';

$add['button_bg_color']           = $colors['accent'];
$add['button_border_color']       = $colors['accent'];
$add['button_text_color']         = $colors['white'];
$add['button_hover_bg_color']     = $colors['accent2'];
$add['button_hover_border_color'] = $colors['accent2'];
$add['button_hover_text_color']   = $colors['white'];

/**
 * ====================================================
 * Typography & Colors > Title
 * ====================================================
 */

/**
 * ====================================================
 * Typography & Colors > Small Title
 * ====================================================
 */

/**
 * ====================================================
 * Typography & Colors > Meta Info
 * ====================================================
 */

$add['meta_font_size']   = '0.9rem';
$add['meta_line_height'] = '1.7';

/**
 * ====================================================
 * Page Canvas & Wrapper
 * ====================================================
 */

$add['page_layout'] = 'full-width';

$add['boxed_page_width']  = '1400px';
$add['boxed_page_shadow'] = '0px 0px 30px 0px rgba(0,0,0,0.05)';

$add['container_width']      = '1140px';
$add['content_narrow_width'] = '720px';

$add['page_bg_color'] = $colors['bg'];

$add['outside_bg_color']      = $colors['border'];
$add['outside_bg_image']      = '';
$add['outside_bg_position']   = 'center center';
$add['outside_bg_size']       = 'cover';
$add['outside_bg_repeat']     = 'no-repeat';
$add['outside_bg_attachment'] = 'fixed';

/**
 * ====================================================
 * Header > Builder
 * ====================================================
 */

$add['header_elements_top_left']      = array();
$add['header_elements_top_center']    = array();
$add['header_elements_top_right']     = array();
$add['header_elements_main_left']     = array( 'logo' );
$add['header_elements_main_center']   = array();
$add['header_elements_main_right']    = array( 'menu-1', 'search-dropdown' );
$add['header_elements_bottom_left']   = array();
$add['header_elements_bottom_center'] = array();
$add['header_elements_bottom_right']  = array();

$add['header_mobile_elements_main_left']    = array( 'mobile-logo' );
$add['header_mobile_elements_main_center']  = array();
$add['header_mobile_elements_main_right']   = array( 'mobile-vertical-toggle' );
$add['header_mobile_elements_vertical_top'] = array( 'search-bar', 'mobile-menu' );

/**
 * ====================================================
 * Header > HTML
 * ====================================================
 */

$add['header_html_1_content'] = esc_html__( 'Insert HTML text here', 'suki' );

/**
 * ====================================================
 * Header > Logo
 * ====================================================
 */

$add['header_logo_width']        = '100px';
$add['header_mobile_logo_width'] = '100px';

/**
 * ====================================================
 * Header > Search
 * ====================================================
 */

$add['header_search_bar_width']      = '300px';
$add['header_search_dropdown_width'] = '300px';

/**
 * ====================================================
 * Header > Cart
 * ====================================================
 */

$add['header_cart_amount_visibility'] = array( 'desktop', 'tablet', 'mobile' );

$add['header_cart_count_text_color'] = $colors['white'];

/**
 * ====================================================
 * Header > Social
 * ====================================================
 */

$add['header_social_links']        = array( 'facebook', 'twitter', 'instagram' );
$add['header_social_links_target'] = 'self';

/**
 * ====================================================
 * Header > Top Bar
 * ====================================================
 */

$add['header_top_bar_merged']     = 0;
$add['header_top_bar_merged_gap'] = '0px';

$add['header_top_bar_container'] = 'default';
$add['header_top_bar_height']    = '40px';
$add['header_top_bar_padding']   = '0px 20px 0px 20px';
$add['header_top_bar_border']    = '0px 0px 0px 0px';

$add['header_top_bar_items_gutter'] = '12px';

$add['header_top_bar_menu_highlight'] = 'none';

$add['header_top_bar_icon_size'] = '18px';

/**
 * ====================================================
 * Header > Main (Logo) Bar
 * ====================================================
 */

$add['header_main_bar_container'] = 'default';
$add['header_main_bar_height']    = '80px';
$add['header_main_bar_padding']   = '0px 20px 0px 20px';
$add['header_main_bar_border']    = '0px 0px 0px 0px';

$add['header_main_bar_items_gutter'] = '12px';

$add['header_main_bar_menu_highlight'] = 'none';

$add['header_main_bar_icon_size'] = '18px';

/**
 * ====================================================
 * Header > Bottom Bar
 * ====================================================
 */

$add['header_bottom_bar_merged']     = 0;
$add['header_bottom_bar_merged_gap'] = '0px';

$add['header_bottom_bar_container'] = 'default';
$add['header_bottom_bar_height']    = '60px';
$add['header_bottom_bar_padding']   = '0px 20px 0px 20px';
$add['header_bottom_bar_border']    = '0px 0px 0px 0px';

$add['header_bottom_bar_items_gutter'] = '12px';

$add['header_bottom_bar_menu_highlight'] = 'none';

$add['header_bottom_bar_icon_size'] = '18px';

/**
 * ====================================================
 * Header > Mobile Main Bar
 * ====================================================
 */

$add['header_mobile_main_bar_height']          = '60px';
$add['header_mobile_main_bar_padding__tablet'] = '0px 20px 0px 20px';
$add['header_mobile_main_bar_border']          = '0px 0px 0px 0px';

$add['header_mobile_main_bar_items_gutter'] = '12px';

$add['header_mobile_main_bar_icon_size'] = '18px';

/**
 * ====================================================
 * Header > Mobile Drawer
 * ====================================================
 */

$add['header_mobile_vertical_bar_display'] = 'drawer';

$add['header_mobile_vertical_bar_position']             = 'left';
$add['header_mobile_vertical_bar_full_screen_position'] = 'center';

$add['header_mobile_vertical_bar_alignment'] = 'left';
$add['header_mobile_vertical_bar_width']     = '300px';
$add['header_mobile_vertical_bar_padding']   = '30px 30px 30px 30px';

$add['header_mobile_vertical_bar_items_gutter'] = '12px';

$add['header_mobile_vertical_bar_icon_size'] = '18px';

/**
 * ====================================================
 * Page Header
 * ====================================================
 */

$add['hero'] = 1;

$add['hero_container'] = 'inherit';
$add['hero_padding']   = '60px 20px 60px 20px';
$add['hero_border']    = '0px 0px 0px 0px';

$add['hero_bg_color'] = $colors['subtle'];

$add['hero_bg_attachment'] = 'scroll';

/**
 * ====================================================
 * Content & Sidebar > Section
 * ====================================================
 */

$add['content_container'] = 'default';
$add['content_layout']    = 'right-sidebar';
$add['content_padding']   = '80px 20px 80px 20px';

/**
 * ====================================================
 * Content & Sidebar > Main Column
 * ====================================================
 */

$add['content_main_padding'] = '0px 0px 0px 0px';
$add['content_main_border']  = '0px 0px 0px 0px';

/**
 * ====================================================
 * Content & Sidebar > Sidebar
 * ====================================================
 */

$add['sidebar_width'] = '25%';
$add['sidebar_gap']   = '60px';

$add['sidebar_widgets_mode'] = 'merged';
$add['sidebar_widgets_gap']  = '40px';

$add['sidebar_padding']       = '0px 0px 0px 0px';
$add['sidebar_border']        = '0px 0px 0px 0px';
$add['sidebar_border_radius'] = '0px';

$add['sidebar_widget_title_tag']        = 'h2';
$add['sidebar_widget_title_alignment']  = 'left';
$add['sidebar_widget_title_decoration'] = 'border-bottom';

$add['sidebar_shadow'] = '0px 0px 30px 0px rgba(0,0,0,0)';

/**
 * ====================================================
 * Footer > Builder
 * ====================================================
 */

$add['footer_widgets_bar'] = 0;

$add['footer_elements_bottom_left']   = array();
$add['footer_elements_bottom_center'] = array( 'copyright' );
$add['footer_elements_bottom_right']  = array();

/**
 * ====================================================
 * Footer > Widgets Bar
 * ====================================================
 */

$add['footer_widgets_bar_container'] = 'default';
$add['footer_widgets_bar_padding']   = '60px 20px 60px 20px';
$add['footer_widgets_bar_border']    = '0px 0px 0px 0px';

$add['footer_widgets_bar_columns_gutter'] = '15px';
$add['footer_widgets_bar_widgets_gap']    = '40px';

$add['footer_widgets_bar_widget_title_tag']        = 'h2';
$add['footer_widgets_bar_widget_title_alignment']  = 'left';
$add['footer_widgets_bar_widget_title_decoration'] = 'border-bottom';

$add['footer_widgets_bar_bg_color'] = $colors['subtle'];

/**
 * ====================================================
 * Footer > Bottom Bar
 * ====================================================
 */

$add['footer_bottom_bar_merged']     = 0;
$add['footer_bottom_bar_merged_gap'] = '0px';

$add['footer_bottom_bar_container']    = 'default';
$add['footer_bottom_bar_padding']      = '25px 20px 25px 20px';
$add['footer_bottom_bar_border']       = '0px 0px 0px 0px';
$add['footer_bottom_bar_items_gutter'] = '12px';

$add['footer_bottom_bar_bg_color'] = $colors['subtle'];

/**
 * ====================================================
 * Footer > Copyright
 * ====================================================
 */

$add['footer_copyright_content'] = esc_html__( 'Copyright &copy; {{year}} {{sitename}} &mdash; powered by {{theme}}', 'suki' );

/**
 * ====================================================
 * Footer > Social
 * ====================================================
 */

$add['footer_social_links']        = array( 'facebook', 'twitter', 'instagram' );
$add['footer_social_links_target'] = 'self';

/**
 * ====================================================
 * Footer > Scroll To Top
 * ====================================================
 */

$add['scroll_to_top']            = 0;
$add['scroll_to_top_visibility'] = array( 'desktop', 'tablet', 'mobile' );

$add['scroll_to_top_display']  = 'sticky';
$add['scroll_to_top_position'] = 'right';
$add['scroll_to_top_h_offset'] = '20px';
$add['scroll_to_top_v_offset'] = '20px';

$add['scroll_to_top_icon_size']     = '18px';
$add['scroll_to_top_padding']       = '10px';
$add['scroll_to_top_border_radius'] = '40px';

/**
 * ====================================================
 * Blog > Posts Page
 * ====================================================
 */

$add['post_archive_content_header']           = array( 'title', 'archive-description' );
$add['post_archive_content_header_alignment'] = 'left';

$add['post_archive_loop_layout']     = 'default';
$add['post_archive_navigation_mode'] = 'pagination';

$add['blog_index_loop_mode']       = 'default';
$add['blog_index_content_header']  = 0;
$add['blog_index_navigation_mode'] = 'pagination';

/**
 * ====================================================
 * Blog > Single Post Page
 * ====================================================
 */

$add['post_single_content_header']             = array( 'title', 'header-meta' );
$add['post_single_content_header_alignment']   = 'left';
$add['post_single_content_header_meta']        = '{{date}}';
$add['post_single_content_thumbnail_position'] = 'before';

$add['post_single_content_footer']           = array( 'tags', 'footer-meta' );
$add['post_single_content_footer_alignment'] = 'left';
$add['post_single_content_footer_meta']      = esc_html__( 'Posted in {{categories}} &nbsp;&bull;&nbsp; {{comments}}', 'suki' );

$add['blog_single_author_bio'] = 1;
$add['blog_single_navigation'] = 1;

/**
 * ====================================================
 * Blog > Post Layout: Default
 * ====================================================
 */

$add['blog_index_default_items_gap'] = '6rem';

$add['entry_header']           = array( 'title', 'header-meta' );
$add['entry_header_alignment'] = 'left';
$add['entry_header_meta']      = '{{date}}';

$add['entry_thumbnail_position'] = 'before';
$add['entry_thumbnail_size']     = 'full';

$add['entry_content']           = 'content';
$add['entry_excerpt_length']    = 55;
$add['entry_read_more_text']    = '';
$add['entry_read_more_display'] = '';

$add['entry_footer']           = array( 'footer-meta' );
$add['entry_footer_alignment'] = 'left';
$add['entry_footer_meta']      = esc_html__( 'Posted in {{categories}} &nbsp;&bull;&nbsp; {{comments}}', 'suki' );

/**
 * ====================================================
 * Blog > Post Layout: Grid
 * ====================================================
 */

$add['blog_index_grid_columns']        = 2;
$add['blog_index_grid_rows_gutter']    = '15px';
$add['blog_index_grid_columns_gutter'] = '15px';

$add['entry_grid_padding']       = '0 0 0 0';
$add['entry_grid_border']        = '0 0 0 0';
$add['entry_grid_border_radius'] = '0px';
$add['entry_grid_same_height']   = 0;

$add['entry_grid_header']           = array( 'title', 'header-meta' );
$add['entry_grid_header_alignment'] = 'left';
$add['entry_grid_header_meta']      = '{{date}}';

$add['entry_grid_thumbnail_position']       = 'before';
$add['entry_grid_thumbnail_size']           = 'medium_large';
$add['entry_grid_thumbnail_ignore_padding'] = 0;

$add['entry_grid_excerpt_length']    = 30;
$add['entry_grid_read_more_text']    = '';
$add['entry_grid_read_more_display'] = '';

$add['entry_grid_footer']           = array( 'footer-meta' );
$add['entry_grid_footer_alignment'] = 'left';
$add['entry_grid_footer_meta']      = esc_html__( 'Posted in {{categories}} &nbsp;&bull;&nbsp; {{comments}}', 'suki' );

$add['entry_grid_shadow'] = '0px 0px 30px 0px rgba(0,0,0,0)';

/**
 * ====================================================
 * Other Pages > Static Page
 * ====================================================
 */

$add['page_single_content_header']           = array( 'title' );
$add['page_single_content_header_alignment'] = 'left';

$add['page_single_content_thumbnail_position'] = 'before';

/**
 * ====================================================
 * Other Pages > Search Page
 * ====================================================
 */

$add['search_results_content_header']           = array( 'title', 'search-form' );
$add['search_results_content_header_alignment'] = 'left';

/**
 * ====================================================
 * Other Pages > Error 404 Page
 * ====================================================
 */

$add['error_404_image_width'] = '300px';
$add['error_404_search_bar']  = 1;

/**
 * ====================================================
 * Other Pages > [Custom Post Type] Archive Page
 * ====================================================
 */

foreach ( Suki_Customizer::instance()->get_all_page_settings_types( 'custom' ) as $ps_type => $ps_data ) {
	// Only process archives.
	if ( 0 < strpos( '/(_archive)/', $ps_type ) ) {
		$add[ $ps_type . '_content_header' ]           = array( 'title', 'archive-description' );
		$add[ $ps_type . '_content_header_alignment' ] = 'left';
	}
}

/**
 * ====================================================
 * Other Pages > Single [Custom Post Types] Page
 * ====================================================
 */

foreach ( Suki_Customizer::instance()->get_all_page_settings_types( 'custom' ) as $ps_type => $ps_data ) {
	// Only process singular.
	if ( 0 < strpos( '/(_single)/', $ps_type ) ) {
		$add[ $ps_type . '_content_header' ]             = array( 'title' );
		$add[ $ps_type . '_content_header_alignment' ]   = 'left';
		$add[ $ps_type . '_content_thumbnail_position' ] = 'before';
	}
}

return $add;
