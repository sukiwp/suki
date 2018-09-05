<?php
/**
 * Customizer default values.
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$colors = self::get_default_colors();

$add = array();

/**
 * ====================================================
 * Global Settings > Google Fonts
 * ====================================================
 */

$add['google_fonts_subsets'] = array();

/**
 * ====================================================
 * General Elements > Body (Base)
 * ====================================================
 */

$add['body_font_family'] = 'web_safe_fonts|Default System Font';
$add['body_font_weight'] = '';
$add['body_font_style'] = '';
$add['body_text_transform'] = '';
$add['body_font_size'] = '15px';
$add['body_line_height'] = '1.7';
$add['body_letter_spacing'] = '';

$add['body_text_color'] = $colors['text'];

$add['link_text_color'] = $colors['accent'];
$add['link_hover_text_color'] = $colors['accent_2'];

$add['subtle_color'] = $colors['subtle'];
$add['border_color'] = $colors['border'];

/**
 * ====================================================
 * General Elements > Headings
 * ====================================================
 */

$add['h1_font_family'] = '';
$add['h1_font_weight'] = 500;
$add['h1_font_style'] = '';
$add['h1_text_transform'] = '';
$add['h1_font_size'] = '32px';
$add['h1_line_height'] = '1.4';
$add['h1_letter_spacing'] = '';

$add['h2_font_family'] = '';
$add['h2_font_weight'] = 500;
$add['h2_font_style'] = '';
$add['h2_text_transform'] = '';
$add['h2_font_size'] = '27px';
$add['h2_line_height'] = '1.5';
$add['h2_letter_spacing'] = '';

$add['h3_font_family'] = '';
$add['h3_font_weight'] = 500;
$add['h3_font_style'] = '';
$add['h3_text_transform'] = '';
$add['h3_font_size'] = '22px';
$add['h3_line_height'] = '1.6';
$add['h3_letter_spacing'] = '';

$add['h4_font_family'] = '';
$add['h4_font_weight'] = 500;
$add['h4_font_style'] = '';
$add['h4_text_transform'] = '';
$add['h4_font_size'] = '17px';
$add['h4_line_height'] = '1.7';
$add['h4_letter_spacing'] = '';

$add['heading_text_color'] = $colors['heading'];
$add['heading_hover_text_color'] = $colors['accent'];

/**
 * ====================================================
 * General Elements > Blockquote
 * ====================================================
 */

$add['blockquote_font_family'] = '';
$add['blockquote_font_weight'] = 300;
$add['blockquote_font_style'] = 'italic';
$add['blockquote_text_transform'] = '';
$add['blockquote_font_size'] = '20px';
$add['blockquote_line_height'] = '1.6';
$add['blockquote_letter_spacing'] = '';

/**
 * ====================================================
 * General Elements > Form Input
 * ====================================================
 */

$add['input_padding'] = '10px 12px 10px 12px';
$add['input_border'] = '1px 1px 1px 1px';
$add['input_border_radius'] = '3px';

$add['input_bg_color'] = $colors['bg'];
$add['input_border_color'] = $colors['border'];
$add['input_text_color'] = $colors['text'];
$add['input_focus_bg_color'] = $colors['bg'];
$add['input_focus_border_color'] = $colors['meta'];
$add['input_focus_text_color'] = $colors['text'];

/**
 * ====================================================
 * General Elements > Button
 * ====================================================
 */

$add['button_padding'] = '10px 20px 10px 20px';
$add['button_border'] = '1px 1px 1px 1px';
$add['button_border_radius'] = '3px';

$add['button_font_family'] = '';
$add['button_font_weight'] = 500;
$add['button_font_style'] = '';
$add['button_text_transform'] = '';
$add['button_font_size'] = '1rem';
$add['button_letter_spacing'] = '';

$add['button_bg_color'] = $colors['accent'];
$add['button_border_color'] = $colors['accent'];
$add['button_text_color'] = $colors['white'];
$add['button_hover_bg_color'] = $colors['accent_2'];
$add['button_hover_border_color'] = $colors['accent_2'];
$add['button_hover_text_color'] = $colors['white'];

/**
 * ====================================================
 * General Elements > Title
 * ====================================================
 */

$add['title_font_family'] = '';
$add['title_font_weight'] = '';
$add['title_font_style'] = '';
$add['title_text_transform'] = '';
$add['title_font_size'] = '';
$add['title_line_height'] = '';
$add['title_letter_spacing'] = '';

$add['title_text_color'] = '';
$add['title_hover_text_color'] = '';

/**
 * ====================================================
 * General Elements > Small Title
 * ====================================================
 */

$add['small_title_font_family'] = '';
$add['small_title_font_weight'] = 500;
$add['small_title_font_style'] = '';
$add['small_title_text_transform'] = '';
$add['small_title_font_size'] = '22px';
$add['small_title_line_height'] = '1.6';
$add['small_title_letter_spacing'] = '';

$add['small_title_text_color'] = '';
$add['small_title_hover_text_color'] = '';

/**
 * ====================================================
 * General Elements > Meta Info
 * ====================================================
 */

$add['meta_font_family'] = '';
$add['meta_font_weight'] = '';
$add['meta_font_style'] = '';
$add['meta_text_transform'] = '';
$add['meta_font_size'] = '0.9rem';
$add['meta_line_height'] = '1.7';
$add['meta_letter_spacing'] = '';

$add['meta_text_color'] = $colors['meta'];
$add['meta_link_text_color'] = $colors['meta'];
$add['meta_link_hover_text_color'] = $colors['text'];

/**
 * ====================================================
 * Page Canvas & Wrapper
 * ====================================================
 */

$add['page_layout'] = 'full-width';
$add['boxed_page_width'] = '1400px';
$add['boxed_page_shadow'] = '0px 0px 30px 0px rgba(0,0,0,0.05)';
$add['container_width'] = '1140px';

$add['edge_padding'] = '25px';
$add['edge_padding__tablet'] = '20px';
$add['edge_padding__mobile'] = '15px';
$add['page_bg_color'] = $colors['bg'];

$add['outside_bg_color'] = $colors['border'];
$add['outside_bg_image'] = '';
$add['outside_bg_position'] = 'center center';
$add['outside_bg_size'] = 'cover';
$add['outside_bg_repeat'] = 'no-repeat';
$add['outside_bg_attachment'] = 'fixed';

/**
 * ====================================================
 * Header > Builder
 * ====================================================
 */

$add['header_elements_top_left'] = array();
$add['header_elements_top_center'] = array();
$add['header_elements_top_right'] = array();
$add['header_elements_main_left'] = array( 'logo' );
$add['header_elements_main_center'] = array();
$add['header_elements_main_right'] = array( 'menu-1', 'shopping-cart-dropdown', 'search-dropdown' );
$add['header_elements_bottom_left'] = array();
$add['header_elements_bottom_center'] = array();
$add['header_elements_bottom_right'] = array();

$add['header_mobile_elements_main_left'] = array( 'mobile-logo' );
$add['header_mobile_elements_main_center'] = array();
$add['header_mobile_elements_main_right'] = array( 'shopping-cart-link', 'mobile-vertical-toggle' );
$add['header_mobile_elements_vertical_top'] = array( 'search-bar', 'mobile-menu' );

/**
 * ====================================================
 * Header > HTML
 * ====================================================
 */

$add['header_html_1_content'] = 'Insert HTML text here';

/**
 * ====================================================
 * Header > Logo
 * ====================================================
 */

$add['header_logo_width'] = '100px';
$add['header_mobile_logo_width'] = '100px';

/**
 * ====================================================
 * Header > Search
 * ====================================================
 */

$add['header_search_bar_width'] = '300px';
$add['header_search_dropdown_width'] = '300px';

/**
 * ====================================================
 * Header > Social
 * ====================================================
 */

$add['header_social_links'] = array( 'facebook', 'twitter', 'instagram' );
$add['header_social_links_target'] = 'self';

/**
 * ====================================================
 * Header > Top Bar
 * ====================================================
 */

$add['header_top_bar_merged'] = 0;

$add['header_top_bar_container'] = 'default';
$add['header_top_bar_height'] = '40px';
$add['header_top_bar_padding'] = '0px 0px 0px 0px';
$add['header_top_bar_border'] = '0px 0px 1px 0px';

$add['header_top_bar_items_gutter'] = '12px';

$add['header_top_bar_font_family'] = '';
$add['header_top_bar_font_weight'] = '';
$add['header_top_bar_font_style'] = '';
$add['header_top_bar_text_transform'] = '';
$add['header_top_bar_font_size'] = '';
$add['header_top_bar_line_height'] = '';
$add['header_top_bar_letter_spacing'] = '';

$add['header_top_bar_menu_font_family'] = '';
$add['header_top_bar_menu_font_weight'] = '';
$add['header_top_bar_menu_font_style'] = '';
$add['header_top_bar_menu_text_transform'] = '';
$add['header_top_bar_menu_font_size'] = '';
$add['header_top_bar_menu_line_height'] = '';
$add['header_top_bar_menu_letter_spacing'] = '';

$add['header_top_bar_menu_highlight'] = 'none';

$add['header_top_bar_submenu_font_family'] = '';
$add['header_top_bar_submenu_font_weight'] = '';
$add['header_top_bar_submenu_font_style'] = '';
$add['header_top_bar_submenu_text_transform'] = '';
$add['header_top_bar_submenu_font_size'] = '';
$add['header_top_bar_submenu_line_height'] = '';
$add['header_top_bar_submenu_letter_spacing'] = '';

$add['header_top_bar_icon_size'] = '18px';

$add['header_top_bar_bg_color'] = '';
$add['header_top_bar_border_color'] = '';
$add['header_top_bar_text_color'] = '';
$add['header_top_bar_link_text_color'] = $colors['heading'];
$add['header_top_bar_link_hover_text_color'] = $colors['text'];
$add['header_top_bar_menu_highlight_color'] = $colors['accent'];

/**
 * ====================================================
 * Header > Main (Logo) Bar
 * ====================================================
 */

$add['header_main_bar_container'] = 'default';
$add['header_main_bar_height'] = '80px';
$add['header_main_bar_padding'] = '0px 0px 0px 0px';
$add['header_main_bar_border'] = '0px 0px 1px 0px';

$add['header_main_bar_items_gutter'] = '12px';

$add['header_main_bar_font_family'] = '';
$add['header_main_bar_font_weight'] = '';
$add['header_main_bar_font_style'] = '';
$add['header_main_bar_text_transform'] = '';
$add['header_main_bar_font_size'] = '';
$add['header_main_bar_line_height'] = '';
$add['header_main_bar_letter_spacing'] = '';

$add['header_main_bar_menu_font_family'] = '';
$add['header_main_bar_menu_font_weight'] = '';
$add['header_main_bar_menu_font_style'] = '';
$add['header_main_bar_menu_text_transform'] = '';
$add['header_main_bar_menu_font_size'] = '';
$add['header_main_bar_menu_line_height'] = '';
$add['header_main_bar_menu_letter_spacing'] = '';

$add['header_main_bar_menu_highlight'] = 'none';

$add['header_main_bar_submenu_font_family'] = '';
$add['header_main_bar_submenu_font_weight'] = '';
$add['header_main_bar_submenu_font_style'] = '';
$add['header_main_bar_submenu_text_transform'] = '';
$add['header_main_bar_submenu_font_size'] = '';
$add['header_main_bar_submenu_line_height'] = '';
$add['header_main_bar_submenu_letter_spacing'] = '';

$add['header_main_bar_icon_size'] = '18px';

$add['header_main_bar_bg_color'] = '';
$add['header_main_bar_border_color'] = '';
$add['header_main_bar_text_color'] = '';
$add['header_main_bar_link_text_color'] = $colors['heading'];
$add['header_main_bar_link_hover_text_color'] = $colors['text'];
$add['header_main_bar_menu_highlight_color'] = $colors['accent'];

/**
 * ====================================================
 * Header > Bottom Bar
 * ====================================================
 */

$add['header_bottom_bar_merged'] = 0;

$add['header_bottom_bar_container'] = 'default';
$add['header_bottom_bar_height'] = '40px';
$add['header_bottom_bar_padding'] = '0px 0px 0px 0px';
$add['header_bottom_bar_border'] = '0px 0px 1px 0px';

$add['header_bottom_bar_items_gutter'] = '12px';

$add['header_bottom_bar_font_family'] = '';
$add['header_bottom_bar_font_weight'] = '';
$add['header_bottom_bar_font_style'] = '';
$add['header_bottom_bar_text_transform'] = '';
$add['header_bottom_bar_font_size'] = '';
$add['header_bottom_bar_line_height'] = '';
$add['header_bottom_bar_letter_spacing'] = '';

$add['header_bottom_bar_menu_font_family'] = '';
$add['header_bottom_bar_menu_font_weight'] = '';
$add['header_bottom_bar_menu_font_style'] = '';
$add['header_bottom_bar_menu_text_transform'] = '';
$add['header_bottom_bar_menu_font_size'] = '';
$add['header_bottom_bar_menu_line_height'] = '';
$add['header_bottom_bar_menu_letter_spacing'] = '';

$add['header_bottom_bar_menu_highlight'] = 'none';

$add['header_bottom_bar_submenu_font_family'] = '';
$add['header_bottom_bar_submenu_font_weight'] = '';
$add['header_bottom_bar_submenu_font_style'] = '';
$add['header_bottom_bar_submenu_text_transform'] = '';
$add['header_bottom_bar_submenu_font_size'] = '';
$add['header_bottom_bar_submenu_line_height'] = '';
$add['header_bottom_bar_submenu_letter_spacing'] = '';

$add['header_bottom_bar_icon_size'] = '18px';

$add['header_bottom_bar_bg_color'] = '';
$add['header_bottom_bar_border_color'] = '';
$add['header_bottom_bar_text_color'] = '';
$add['header_bottom_bar_link_text_color'] = $colors['heading'];
$add['header_bottom_bar_link_hover_text_color'] = $colors['text'];
$add['header_bottom_bar_menu_highlight_color'] = $colors['accent'];

/**
 * ====================================================
 * Header > Mobile Main Bar
 * ====================================================
 */

$add['header_mobile_main_bar_height'] = '60px';
$add['header_mobile_main_bar_padding'] = '0px 0px 0px 0px';
$add['header_mobile_main_bar_border'] = '0px 0px 1px 0px';

$add['header_mobile_main_bar_items_gutter'] = '12px';

$add['header_mobile_main_bar_icon_size'] = '18px';

$add['header_mobile_main_bar_bg_color'] = $colors['bg'];
$add['header_mobile_main_bar_border_color'] = $colors['border'];
$add['header_mobile_main_bar_link_text_color'] = $colors['heading'];
$add['header_mobile_main_bar_link_hover_text_color'] = $colors['text'];

/**
 * ====================================================
 * Header > Mobile Drawer
 * ====================================================
 */

$add['header_mobile_vertical_bar_position'] = 'left';
$add['header_mobile_vertical_bar_alignment'] = 'left';
$add['header_mobile_vertical_bar_width'] = '300px';
$add['header_mobile_vertical_bar_padding'] = '30px 30px 30px 30px';

$add['header_mobile_vertical_bar_items_gutter'] = '12px';

$add['header_mobile_vertical_bar_font_family'] = '';
$add['header_mobile_vertical_bar_font_weight'] = '';
$add['header_mobile_vertical_bar_font_style'] = '';
$add['header_mobile_vertical_bar_text_transform'] = '';
$add['header_mobile_vertical_bar_font_size'] = '';
$add['header_mobile_vertical_bar_line_height'] = '';
$add['header_mobile_vertical_bar_letter_spacing'] = '';

$add['header_mobile_vertical_bar_menu_font_family'] = '';
$add['header_mobile_vertical_bar_menu_font_weight'] = '';
$add['header_mobile_vertical_bar_menu_font_style'] = '';
$add['header_mobile_vertical_bar_menu_text_transform'] = '';
$add['header_mobile_vertical_bar_menu_font_size'] = '';
$add['header_mobile_vertical_bar_menu_line_height'] = '';
$add['header_mobile_vertical_bar_menu_letter_spacing'] = '';

$add['header_mobile_vertical_bar_submenu_font_family'] = '';
$add['header_mobile_vertical_bar_submenu_font_weight'] = '';
$add['header_mobile_vertical_bar_submenu_font_style'] = '';
$add['header_mobile_vertical_bar_submenu_text_transform'] = '';
$add['header_mobile_vertical_bar_submenu_font_size'] = '';
$add['header_mobile_vertical_bar_submenu_line_height'] = '';
$add['header_mobile_vertical_bar_submenu_letter_spacing'] = '';

$add['header_mobile_vertical_bar_icon_size'] = '18px';

$add['header_mobile_vertical_bar_bg_color'] = '';
$add['header_mobile_vertical_bar_border_color'] = '';
$add['header_mobile_vertical_bar_text_color'] = '';
$add['header_mobile_vertical_bar_link_text_color'] = $colors['heading'];
$add['header_mobile_vertical_bar_link_hover_text_color'] = $colors['text'];
$add['header_mobile_vertical_bar_menu_highlight_color'] = $colors['accent'];

/**
 * ====================================================
 * Page Header (Title Bar)
 * ====================================================
 */

$add['page_header'] = 0;

$add['page_header_container'] = 'default';
$add['page_header_padding'] = '80px 0px 80px 0px';
$add['page_header_border'] = '0px 0px 1px 0px';

$add['page_header_layout'] = 'center';

$add['page_header_breadcrumb'] = 1;
$add['breadcrumb_plugin'] = 'breadcrumb-trail';

$add['page_header_title_font_family'] = '';
$add['page_header_title_font_weight'] = '';
$add['page_header_title_font_style'] = '';
$add['page_header_title_text_transform'] = '';
$add['page_header_title_font_size'] = '';
$add['page_header_title_line_height'] = '';
$add['page_header_title_letter_spacing'] = '';

$add['page_header_breadcrumb_font_family'] = '';
$add['page_header_breadcrumb_font_weight'] = '';
$add['page_header_breadcrumb_font_style'] = '';
$add['page_header_breadcrumb_text_transform'] = '';
$add['page_header_breadcrumb_font_size'] = '0.9rem';
$add['page_header_breadcrumb_line_height'] = '';
$add['page_header_breadcrumb_letter_spacing'] = '';

$add['page_header_bg_color'] = $colors['subtle'];
$add['page_header_border_color'] = '';
$add['page_header_title_text_color'] = '';
$add['page_header_breadcrumb_text_color'] = '';
$add['page_header_breadcrumb_link_text_color'] = $colors['text'];
$add['page_header_breadcrumb_link_hover_text_color'] = $colors['accent'];

$add['page_header_bg_image'] = '';
$add['page_header_bg_attachment'] = 'scroll';
$add['page_header_bg_overlay_opacity'] = '';

/**
 * ====================================================
 * Content & Sidebar > Section
 * ====================================================
 */

$add['content_container'] = 'default';
$add['content_layout'] = 'right-sidebar';
$add['content_padding'] = '80px 0px 80px 0px';
$add['content_narrow_width'] = '720px';

/**
 * ====================================================
 * Content & Sidebar > Main Content Area
 * ====================================================
 */

$add['content_main_padding'] = '0px 0px 0px 0px';
$add['content_main_border'] = '0px 0px 0px 0px';

$add['content_main_bg_color'] = '';
$add['content_main_border_color'] = '';

/**
 * ====================================================
 * Content & Sidebar > Sidebar Area
 * ====================================================
 */

$add['sidebar_width'] = '25%';
$add['sidebar_gap'] = '60px';

$add['sidebar_widgets_mode'] = 'merged';
$add['sidebar_widgets_gap'] = '40px';
$add['sidebar_padding'] = '0px 0px 0px 0px';
$add['sidebar_border'] = '0px 0px 0px 0px';

$add['sidebar_font_family'] = '';
$add['sidebar_font_weight'] = '';
$add['sidebar_font_style'] = '';
$add['sidebar_text_transform'] = '';
$add['sidebar_font_size'] = '';
$add['sidebar_line_height'] = '';
$add['sidebar_letter_spacing'] = '';

$add['sidebar_widget_title_font_family'] = '';
$add['sidebar_widget_title_font_weight'] = '';
$add['sidebar_widget_title_font_style'] = '';
$add['sidebar_widget_title_text_transform'] = '';
$add['sidebar_widget_title_font_size'] = '';
$add['sidebar_widget_title_line_height'] = '';
$add['sidebar_widget_title_letter_spacing'] = '';

$add['sidebar_widget_title_alignment'] = 'left';
$add['sidebar_widget_title_decoration'] = 'border-bottom';

$add['sidebar_bg_color'] = '';
$add['sidebar_border_color'] = '';
$add['sidebar_text_color'] = '';
$add['sidebar_link_text_color'] = '';
$add['sidebar_link_hover_text_color'] = '';
$add['sidebar_widget_title_text_color'] = '';
$add['sidebar_widget_title_bg_color'] = '';
$add['sidebar_widget_title_border_color'] = '';

/**
 * ====================================================
 * Footer > Builder
 * ====================================================
 */

$add['footer_widgets_bar'] = 0;

$add['footer_elements_bottom_left'] = array();
$add['footer_elements_bottom_center'] = array( 'copyright' );
$add['footer_elements_bottom_right'] = array();

/**
 * ====================================================
 * Footer > Widgets Bar
 * ====================================================
 */

$add['footer_bottom_bar_merged'] = 0;

$add['footer_widgets_bar_container'] = 'default';
$add['footer_widgets_bar_padding'] = '60px 0px 60px 0px';
$add['footer_widgets_bar_border'] = '1px 0px 0px 0px';

$add['footer_widgets_bar_columns_gutter'] = '15px';
$add['footer_widgets_bar_widgets_gap'] = '40px';

$add['footer_widgets_bar_font_family'] = '';
$add['footer_widgets_bar_font_weight'] = '';
$add['footer_widgets_bar_font_style'] = '';
$add['footer_widgets_bar_text_transform'] = '';
$add['footer_widgets_bar_font_size'] = '';
$add['footer_widgets_bar_line_height'] = '';
$add['footer_widgets_bar_letter_spacing'] = '';

$add['footer_widgets_bar_widget_title_font_family'] = '';
$add['footer_widgets_bar_widget_title_font_weight'] = '';
$add['footer_widgets_bar_widget_title_font_style'] = '';
$add['footer_widgets_bar_widget_title_text_transform'] = '';
$add['footer_widgets_bar_widget_title_font_size'] = '';
$add['footer_widgets_bar_widget_title_line_height'] = '';
$add['footer_widgets_bar_widget_title_letter_spacing'] = '';

$add['footer_widgets_bar_widget_title_alignment'] = 'left';
$add['footer_widgets_bar_widget_title_decoration'] = 'border-bottom';

$add['footer_widgets_bar_bg_color'] = $colors['subtle'];
$add['footer_widgets_bar_border_color'] = '';
$add['footer_widgets_bar_text_color'] = '';
$add['footer_widgets_bar_link_text_color'] = '';
$add['footer_widgets_bar_link_hover_text_color'] = '';
$add['footer_widgets_bar_widget_title_text_color'] = '';
$add['footer_widgets_bar_widget_title_bg_color'] = '';
$add['footer_widgets_bar_widget_title_border_color'] = '';

/**
 * ====================================================
 * Footer > Bottom Bar
 * ====================================================
 */

$add['footer_bottom_bar_container'] = 'default';
$add['footer_bottom_bar_padding'] = '25px 0px 25px 0px';
$add['footer_bottom_bar_border'] = '1px 0px 0px 0px';

$add['footer_bottom_bar_font_family'] = '';
$add['footer_bottom_bar_font_weight'] = '';
$add['footer_bottom_bar_font_style'] = '';
$add['footer_bottom_bar_text_transform'] = '';
$add['footer_bottom_bar_font_size'] = '';
$add['footer_bottom_bar_line_height'] = '';
$add['footer_bottom_bar_letter_spacing'] = '';

$add['footer_bottom_bar_bg_color'] = $colors['subtle'];
$add['footer_bottom_bar_border_color'] = '';
$add['footer_bottom_bar_text_color'] = '';
$add['footer_bottom_bar_link_text_color'] = '';
$add['footer_bottom_bar_link_hover_text_color'] = '';

/**
 * ====================================================
 * Footer > Copyright
 * ====================================================
 */

$add['footer_copyright_content'] = 'Copyright &copy; {{year}}, {{sitename}} &mdash; designed by {{themeauthor}}';

/**
 * ====================================================
 * Footer > Social
 * ====================================================
 */

$add['footer_social_links'] = array( 'facebook', 'twitter', 'instagram' );
$add['footer_social_links_target'] = 'self';

/**
 * ====================================================
 * Blog > Posts Index
 * ====================================================
 */

$add['blog_index_loop_mode'] = 'default';
$add['blog_index_navigation_mode'] = 'pagination';

/**
 * ====================================================
 * Blog > Single Post
 * ====================================================
 */

$add['blog_single_author_bio'] = 1;
$add['blog_single_navigation'] = 1;

/**
 * ====================================================
 * Blog > Post Layout: Default
 * ====================================================
 */

$add['entry_featured_media_position'] = 'before-entry-header';
$add['entry_featured_media_ignore_padding'] = 0;
$add['entry_header'] = array( 'header-meta', 'title' );
$add['entry_header_meta'] = '{{date}}';
$add['entry_footer_meta'] = 'Posted in {{categories}} &nbsp;&bull;&nbsp; {{comments}}';

/**
 * ====================================================
 * Blog > Post Layout: Grid
 * ====================================================
 */

$add['blog_index_grid_columns'] = 2;
$add['blog_index_grid_columns_gutter'] = '15px';
$add['entry_grid_padding'] = '15px 15px 15px 15px';

$add['entry_grid_featured_media_position'] = 'before-entry-header';
$add['entry_grid_header'] = array( 'header-meta', 'title' );
$add['entry_grid_header_meta'] = '{{date}}';
$add['entry_grid_footer_meta'] = 'Posted in {{categories}} &nbsp;&bull;&nbsp; {{comments}}';
$add['entry_grid_excerpt_length'] = 30;

$defaults = array_merge_recursive( $defaults, $add );