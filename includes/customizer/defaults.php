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

$add = array();

/**
 * ====================================================
 * Global Configurations > Color Palette
 * ====================================================
 */

$add['color_base']        = '#ffffff';
$add['color_base_2']      = '#f3f3f3';
$add['color_base_3']      = '#cccccc';
$add['color_contrast']    = '#000000';
$add['color_contrast_2']  = '#333333';
$add['color_contrast_3']  = '#666666';
$add['color_primary']     = '#0055cc';
$add['color_primary_2']   = '#004099';
$add['color_secondary']   = '#0055cc';
$add['color_secondary_2'] = '#004099';

/**
 * ====================================================
 * Global Elements > Base Typography
 * ====================================================
 */

$add['body_font_family'] = 'System Font';
$add['body_font_size']   = '16px';
$add['body_line_height'] = 1.6;

$add['body_text_color'] = 'var(--wp--preset--color--contrast-2)';

/**
 * ====================================================
 * Global Elements > Border & Subtle Background
 * ====================================================
 */

$add['subtle_color'] = 'var(--wp--preset--color--base-2)';
$add['border_color'] = 'var(--wp--preset--color--base-3)';

/**
 * ====================================================
 * Global Elements > Link
 * ====================================================
 */

$add['link_text_color']       = 'var(--wp--preset--color--primary)';
$add['link_hover_text_color'] = 'var(--wp--preset--color--primary-2)';

/**
 * ====================================================
 * Global Elements > Headings
 * ====================================================
 */

$add['h1_font_size']   = '2.4rem';
$add['h1_font_weight'] = 600;
$add['h1_line_height'] = 1.2;

$add['h2_font_size']   = '1.8rem';
$add['h2_font_weight'] = 600;
$add['h2_line_height'] = 1.3;

$add['h3_font_size']   = '1.5rem';
$add['h3_font_weight'] = 600;
$add['h3_line_height'] = 1.4;

$add['h4_font_size']   = '1.25rem';
$add['h4_font_weight'] = 600;
$add['h4_line_height'] = 1.5;

$add['h5_font_size']   = '1.1rem';
$add['h5_font_weight'] = 600;
$add['h5_line_height'] = 1.6;

$add['h6_font_size']   = '1rem';
$add['h6_font_weight'] = 600;
$add['h6_line_height'] = 1.6;

$add['heading_text_color'] = 'var(--wp--preset--color--contrast)';

/**
 * ====================================================
 * Global Elements > Blockquote
 * ====================================================
 */

$add['blockquote_font_size']   = '1.25rem';
$add['blockquote_font_style']  = 'italic';
$add['blockquote_font_weight'] = 400;
$add['blockquote_line_height'] = 1.5;

/**
 * ====================================================
 * Global Elements > Form Input
 * ====================================================
 */

$add['input_padding']       = array( '0.75em', '1em', '0.75em', '1em' );
$add['input_border']        = array( '1px', '1px', '1px', '1px' );
$add['input_border_radius'] = '0.25em';

$add['input_bg_color']           = 'var(--wp--preset--color--base)';
$add['input_focus_border_color'] = 'var(--wp--preset--color--contrast-2)';

/**
 * ====================================================
 * Global Elements > Button
 * ====================================================
 */

$add['button_padding']       = array( '0.75em', '1em', '0.75em', '1em' );
$add['button_border']        = array( '1px', '1px', '1px', '1px' );
$add['button_border_radius'] = '0.25em';

$add['button_font_weight'] = 600;
$add['button_font_size']   = '1rem';

$add['button_bg_color']           = 'var(--wp--preset--color--primary)';
$add['button_border_color']       = 'var(--wp--preset--color--primary)';
$add['button_text_color']         = 'var(--wp--preset--color--base)';
$add['button_hover_bg_color']     = 'var(--wp--preset--color--primary-2)';
$add['button_hover_border_color'] = 'var(--wp--preset--color--primary-2)';
$add['button_hover_text_color']   = 'var(--wp--preset--color--base)';

/**
 * ====================================================
 * Global Elements > Meta Info
 * ====================================================
 */

$add['meta_text_color'] = 'var(--wp--preset--contrast-3)';

/**
 * ====================================================
 * Global Layout > Content Size & Spacing
 * ====================================================
 */

$add['container_wide_width']   = '1140px';
$add['container_narrow_width'] = '700px';

$add['block_spacing'] = '1.25rem';

/**
 * ====================================================
 * Global Layout > Page Canvas
 * ====================================================
 */

$add['page_layout'] = 'boxed';

$add['boxed_page_width']  = '1400px';
$add['boxed_page_shadow'] = array( '0px', '0px', '30px', '0px', '#00000000' );

$add['page_bg_color'] = 'var(--wp--preset--color--base)';

$add['outside_bg_color']    = 'var(--wp--preset--color--base-3)';
$add['outside_bg_repeat']   = 0;
$add['outside_bg_parallax'] = 1;

$add['outside_bg_color_overlay_dim'] = 50;

/**
 * ====================================================
 * Global Layout > Content Section
 * ====================================================
 */

$add['content_container'] = 'wide';
$add['content_layout']    = 'right-sidebar';
$add['content_padding']   = array( '80px', '20px', '80px', '20px' );

/**
 * ====================================================
 * Global Layout > Sidebar
 * ====================================================
 */

$add['sidebar_width'] = '25%';
$add['sidebar_gap']   = '3.5rem';

/**
 * ====================================================
 * Global Layout > Hero Section
 * ====================================================
 */

$add['hero'] = 1;

$add['hero_container'] = 'inherit';
$add['hero_padding']   = array( '60px', '20px', '60px', '20px' );
$add['hero_border']    = array( '', '', '', '' );

$add['hero_bg_color']    = 'var(--wp--preset--color--base-2)';
$add['hero_bg_repeat']   = 0;
$add['hero_bg_parallax'] = 1;

$add['hero_bg_color_overlay_dim'] = 50;

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

$add['header_mobile_visibility'] = 'tablet';

$add['header_mobile_elements_main_left']    = array( 'mobile-logo' );
$add['header_mobile_elements_main_center']  = array();
$add['header_mobile_elements_main_right']   = array( 'mobile-vertical-toggle' );
$add['header_mobile_elements_vertical_top'] = array( 'mobile-menu', 'search-bar' );

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
$add['header_mobile_logo_width'] = '';

/**
 * ====================================================
 * Header > Cart
 * ====================================================
 */

$add['header_cart_amount_visibility'] = array( 'desktop', 'tablet', 'mobile' );

$add['header_cart_count_text_color'] = 'var(--wp--preset--color--base)';

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

$add['header_top_bar_merged'] = 0;

$add['header_top_bar_container'] = 'wide';
$add['header_top_bar_height']    = '50px';
$add['header_top_bar_padding']   = array( '0px', '20px', '0px', '20px' );
$add['header_top_bar_border']    = array( '', '', '', '' );

$add['header_top_bar_menu_highlight'] = 'none';

$add['header_top_bar_icon_size'] = '1.2em';

/**
 * ====================================================
 * Header > Main (Logo) Bar
 * ====================================================
 */

$add['header_main_bar_container'] = 'wide';
$add['header_main_bar_height']    = '90px';
$add['header_main_bar_padding']   = array( '0px', '20px', '0px', '20px' );
$add['header_main_bar_border']    = array( '', '', '', '' );

$add['header_main_bar_menu_highlight'] = 'none';

$add['header_main_bar_icon_size'] = '1.2em';

/**
 * ====================================================
 * Header > Bottom Bar
 * ====================================================
 */

$add['header_bottom_bar_merged'] = 0;

$add['header_bottom_bar_container'] = 'wide';
$add['header_bottom_bar_height']    = '50px';
$add['header_bottom_bar_padding']   = array( '0px', '20px', '0px', '20px' );
$add['header_bottom_bar_border']    = array( '', '', '', '' );

$add['header_bottom_bar_menu_highlight'] = 'none';

$add['header_bottom_bar_icon_size'] = '1.2em';

/**
 * ====================================================
 * Header > Mobile Main Bar
 * ====================================================
 */

$add['header_mobile_main_bar_height']          = '60px';
$add['header_mobile_main_bar_padding__tablet'] = array( '0px', '20px', '0px', '20px' );

$add['header_mobile_main_bar_icon_size'] = '1.2em';

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
$add['header_mobile_vertical_bar_padding']   = array( '30px', '30px', '30px', '30px' );

$add['header_mobile_vertical_bar_icon_size'] = '1.2em';

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

$add['footer_widgets_bar_container'] = 'wide';
$add['footer_widgets_bar_padding']   = array( '60px', '20px', '60px', '20px' );
$add['footer_widgets_bar_border']    = array( '', '', '', '' );

$add['footer_widgets_bar_widget_title_tag']        = 'h2';
$add['footer_widgets_bar_widget_title_alignment']  = 'left';
$add['footer_widgets_bar_widget_title_decoration'] = 'border-bottom';

$add['footer_widgets_bar_bg_color'] = 'var(--wp--preset--color--base-2)';

/**
 * ====================================================
 * Footer > Bottom Bar
 * ====================================================
 */

$add['footer_bottom_bar_merged'] = 0;

$add['footer_bottom_bar_container'] = 'wide';
$add['footer_bottom_bar_padding']   = array( '25px', '20px', '25px', '20px' );
$add['footer_bottom_bar_border']    = array( '', '', '', '' );

$add['footer_bottom_bar_bg_color'] = 'var(--wp--preset--color--base-2)';

/**
 * ====================================================
 * Footer > HTML
 * ====================================================
 */

$add['footer_html_1_content'] = esc_html__( 'Insert HTML text here', 'suki' );

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

$add['scroll_to_top_icon_size']     = '1.2em';
$add['scroll_to_top_padding']       = '10px';
$add['scroll_to_top_border_radius'] = '40px';

/**
 * ====================================================
 * Blog > Posts Page
 * ====================================================
 */

$add['post_archive_content_header']           = array( 'title', 'archive-description' );
$add['post_archive_content_header_alignment'] = 'left';

$add['post_archive_home_content_header'] = 1;

$add['post_archive_loop_layout']     = 'default';
$add['post_archive_navigation_mode'] = 'page-numbers';

/**
 * ====================================================
 * Blog > Single Post Page
 * ====================================================
 */

$add['post_single_content_header']             = array( 'title', 'header-meta' );
$add['post_single_content_header_alignment']   = 'left';
$add['post_single_content_header_meta']        = '{{date}}';
$add['post_single_content_thumbnail_position'] = 'before';

$add['post_single_content_footer']           = array( 'tags', 'hr', 'footer-meta' );
$add['post_single_content_footer_alignment'] = 'left';
$add['post_single_content_footer_meta']      = esc_html__( 'Posted in {{categories}}', 'suki' );

$add['post_single_hero_bg'] = 'thumbnail';

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

$add['entry_footer']           = array( 'hr', 'footer-meta' );
$add['entry_footer_alignment'] = 'left';
$add['entry_footer_meta']      = esc_html__( 'Posted in {{categories}}', 'suki' );

/**
 * ====================================================
 * Blog > Post Layout: Grid
 * ====================================================
 */

$add['blog_index_grid_columns']     = 2;
$add['blog_index_grid_columns_gap'] = '2rem';

$add['entry_grid_padding']       = array( '', '', '', '' );
$add['entry_grid_border']        = array( '', '', '', '' );
$add['entry_grid_border_radius'] = '';
$add['entry_grid_same_height']   = 0;

$add['entry_grid_header']           = array( 'title', 'header-meta' );
$add['entry_grid_header_alignment'] = 'left';
$add['entry_grid_header_meta']      = '{{date}}';

$add['entry_grid_thumbnail_position']       = 'before';
$add['entry_grid_thumbnail_size']           = 'medium_large';
$add['entry_grid_thumbnail_ignore_padding'] = 0;

$add['entry_grid_excerpt_length'] = 30;

$add['entry_grid_footer']           = array( 'hr', 'footer-meta' );
$add['entry_grid_footer_alignment'] = 'left';
$add['entry_grid_footer_meta']      = esc_html__( 'Posted in {{categories}}', 'suki' );

$add['entry_grid_shadow'] = array( '0px', '0px', '2rem', '0px', '#0000000d' );

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

// Hardcoded values for Error 404 page settings.
// No actual options added in the Customizer.
$add['error_404_hero']              = 0;
$add['error_404_content_container'] = 'narrow';
$add['error_404_content_layout']    = 'no-sidebar';

$add['error_404_title_text']       = esc_html__( 'Oops! That page can not be found', 'suki' );
$add['error_404_description_text'] = esc_html__( 'It looks like nothing was found at this location. Maybe try searching?', 'suki' );
$add['error_404_search_bar']       = 1;
$add['error_404_home_button']      = 1;
$add['error_404_home_button_text'] = esc_html__( 'Back to Home', 'suki' );

/**
 * ====================================================
 * Other Pages > [Custom Post Type] Archive Page
 * ====================================================
 */

foreach ( Suki_Customizer::instance()->get_page_types( 'custom' ) as $page_type_key => $page_type_data ) {
	// Only process archives.
	if ( 0 < strpos( '/(_archive)/', $page_type_key ) ) {
		$add[ $page_type_key . '_content_header' ]           = array( 'title', 'archive-description' );
		$add[ $page_type_key . '_content_header_alignment' ] = 'left';
	}
}

/**
 * ====================================================
 * Other Pages > Single [Custom Post Types] Page
 * ====================================================
 */

foreach ( Suki_Customizer::instance()->get_page_types( 'custom' ) as $page_type_key => $page_type_data ) {
	// Only process singular.
	if ( 0 < strpos( '/(_single)/', $page_type_key ) ) {
		$add[ $page_type_key . '_content_header' ]             = array( 'title' );
		$add[ $page_type_key . '_content_header_alignment' ]   = 'left';
		$add[ $page_type_key . '_content_thumbnail_position' ] = 'before';
	}
}

return $add;
