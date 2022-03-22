<?php
/**
 * Template filters declarations.
 *
 * @package Suki
 * @since 2.0.0 Declare moved filters from the deprecated template-functions.php
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ====================================================
 * Taxonomy descriptions support shortcode
 * ====================================================
 */

// Add do_shortcode to all kind of archive description.
add_filter( 'term_description', 'do_shortcode' );
add_filter( 'get_the_post_type_description', 'do_shortcode' );
add_filter( 'get_the_author_description', 'do_shortcode' );

/**
 * ====================================================
 * Archive title filters
 * ====================================================
 */

/**
 * Modify archive title prefix.
 *
 * @param string $prefix Prefix text.
 * @return string
 */
function suki_archive_title_prefix( $prefix ) {
	// Use gravatar as author archive title prefix.
	if ( is_author() ) {
		$prefix = '<div class="suki-author-archive-avatar">' . get_avatar( get_the_author_meta( 'ID' ), 120, '', get_the_author_meta( 'display_name' ) ) . '</div>';
	}

	// Modify title prefix for post type archive page.
	if ( is_post_type_archive() ) {
		$prefix = '';
	}

	return $prefix;
}
add_filter( 'get_the_archive_title_prefix', 'suki_archive_title_prefix' );

/**
 * ====================================================
 * Read more link filters
 * ====================================================
 */

/**
 * Modify "read more" HTML output.
 * Used on entry default.
 *
 * @param integer $link "Read more" link markup.
 * @return integer
 */
function suki_read_more( $link ) {
	$display = suki_get_theme_mod( 'entry_read_more_display' );

	// Return empty string if display is set to "None".
	if ( '' !== $display ) {
		return '';
	}

	// Display "Button" needs a "button" class.
	if ( 'button' === $display ) {
		$link = preg_replace( '/class="(.*?)"/', 'class="$1 ' . esc_attr( $display ) . '"', $link );
	}

	// Change the read more text.
	$text = esc_html( suki_get_theme_mod( 'entry_read_more_text' ) );
	if ( empty( $text ) ) {
		$text = esc_html__( 'Read more', 'suki' );
	}
	$link = preg_replace( '/\(more&hellip;\)/', $text, $link );

	// Add wrapping <p>.
	$link = '<p class="suki-read-more more-link-wrapper">' . $link . '</p>';

	return $link;
}
add_filter( 'the_content_more_link', 'suki_read_more' );

/**
 * Set blog post's excerpt words limit according to the displayed post layout.
 *
 * @param integer $length Excerpt text length.
 * @return integer
 */
function suki_excerpt_length( $length ) {
	// Search page.
	if ( is_search() ) {
		return 30; // Fixed value for search results.
	}

	// Posts page.
	if ( ( is_home() || is_archive() ) && 'post' === get_post_type() ) {
		$layout = suki_get_theme_mod( 'blog_index_loop_mode' );

		if ( 'default' === $layout ) {
			$key = 'entry_excerpt_length';
		} else {
			$key = 'entry_' . $layout . '_excerpt_length';
		}

		return intval( suki_get_theme_mod( $key, $length ) );
	}

	// Else.
	return $length;
}
add_filter( 'excerpt_length', 'suki_excerpt_length' );

/**
 * Modify blog post's excerpt end string.
 *
 * @param string $more Excerpt more text.
 * @return string
 */
function suki_excerpt_more( $more ) {
	return ' &hellip;';
}
add_filter( 'excerpt_more', 'suki_excerpt_more' );

/**
 * ====================================================
 * Menu filters
 * ====================================================
 */

/**
 * Add dropdown caret to accordion menu item.
 *
 * @param string   $item_output Starting navigation menu markup.
 * @param WP_Post  $item        Menu item object.
 * @param integer  $depth       Menu item depth in the menu hierarchy.
 * @param stdClass $args        Arguments object.
 * @return string
 */
function suki_walker_nav_menu_start_el( $item_output, $item, $depth, $args ) {
	// Only add to menu item that has sub menu.
	if ( in_array( 'menu-item-has-children', $item->classes, true ) || in_array( 'page_item_has_children', $item->classes, true ) ) {
		// Only add to toggle menu.
		if ( is_integer( strpos( $args->menu_class, 'suki-toggle-menu' ) ) ) {
			$sign = '<button class="suki-sub-menu-toggle suki-toggle">' . suki_icon( 'chevron-down', array( 'class' => 'suki-dropdown-sign' ), false ) . '<span class="screen-reader-text">' . esc_html__( 'Expand / Collapse', 'suki' ) . '</span></button>';

			$item_output .= trim( $sign );
		}
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'suki_walker_nav_menu_start_el', 99, 4 );

/**
 * Add <span> wrapping tag and dropdown caret to menu item title.
 *
 * @param string   $title Menu item title text.
 * @param WP_Post  $item  Menu item object.
 * @param stdClass $args  Arguments object.
 * @param integer  $depth Menu item depth in the menu hierarchy.
 * @return string
 */
function suki_nav_menu_item_title( $title, $item, $args, $depth ) {
	$sign = '';

	// Only add to menu item that has sub menu.
	if ( in_array( 'menu-item-has-children', $item->classes, true ) || in_array( 'page_item_has_children', $item->classes, true ) ) {
		// Only add to hover menu.
		if ( is_integer( strpos( $args->menu_class, 'suki-hover-menu' ) ) ) {
			$sign = suki_icon( 0 < $depth ? 'chevron-right' : 'chevron-down', array( 'class' => 'suki-dropdown-sign' ), false );
		}
	}

	return '<span class="suki-menu-item-title">' . $title . '</span>' . trim( $sign );
}
add_filter( 'nav_menu_item_title', 'suki_nav_menu_item_title', 99, 4 );

/**
 * Add 'suki-menu-item-link' class to menu item's anchor tag.
 *
 * @param array    $atts  Array of attributes.
 * @param WP_Post  $item  Menu item object.
 * @param stdClass $args  Arguments object.
 * @param integer  $depth Menu item depth in the menu hierarchy.
 */
function suki_nav_menu_link_attributes( $atts, $item, $args, $depth ) {
	if ( ! isset( $atts['class'] ) ) {
		$atts['class'] = '';
	}

	$atts['class'] = 'suki-menu-item-link ' . $atts['class'];

	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'suki_nav_menu_link_attributes', 10, 4 );

/**
 * ====================================================
 * Search form filters
 * ====================================================
 */

/**
 * Add SVG icon to search textbox.
 *
 * @param string $form Search form HTML markup.
 * @return string
 */
function suki_get_search_form_add_icon( $form ) {
	$form = preg_replace( '/placeholder="(.*?)"/', 'placeholder="' . esc_attr__( 'Search&hellip;', 'suki' ) . '"', $form );
	$form = preg_replace( '/<input type="search"(.*?)>/', '$0' . suki_icon( 'search', array( 'class' => 'suki-search-icon' ), false ), $form );

	return $form;
}
add_filter( 'get_search_form', 'suki_get_search_form_add_icon' );

/**
 * ====================================================
 * Blog elements
 * ====================================================
 */

/**
 * Modify tagcloud arguments.
 *
 * @param array $args Array of arguments.
 * @return array
 */
function suki_widget_tag_cloud_args( $args ) {
	$args['smallest'] = 0.75;
	$args['default']  = 1;
	$args['largest']  = 1.75;
	$args['unit']     = 'em';

	return $args;
}
add_filter( 'widget_tag_cloud_args', 'suki_widget_tag_cloud_args' );

/**
 * ====================================================
 * Element classes filters
 * ====================================================
 */

/**
 * Add custom classes to the array of body classes.
 *
 * @param array $classes Array of classes.
 * @return array
 */
function suki_body_classes( $classes ) {
	// Add a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Add a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Add page layout class.
	$classes['page_layout'] = esc_attr( 'suki-page-layout-' . suki_get_theme_mod( 'page_layout' ) );

	// Add theme version.
	$classes['theme_version'] = esc_attr( 'suki-ver-' . str_replace( '.', '-', SUKI_VERSION ) );

	// Add font smoothing class.
	if ( boolval( suki_get_theme_mod( 'font_smoothing' ) ) ) {
		$classes['font_smoothing'] = esc_attr( 'suki-font-smoothing-1' );
	}

	return $classes;
}
add_filter( 'body_class', 'suki_body_classes' );

/**
 * Add custom classes to the array of mobile vertical header classes.
 *
 * @param array $classes Array of classes.
 * @return array
 */
function suki_header_mobile_vertical_classes( $classes ) {
	$display = suki_get_theme_mod( 'header_mobile_vertical_bar_display' );

	$classes['display'] = esc_attr( 'suki-header-mobile-vertical-display-' . $display );

	if ( 'full-screen' === $display ) {
		$classes['position'] = esc_attr( 'suki-header-mobile-vertical-position-' . suki_get_theme_mod( 'header_mobile_vertical_bar_full_screen_position' ) );
	} else {
		$classes['position'] = esc_attr( 'suki-header-mobile-vertical-position-' . suki_get_theme_mod( 'header_mobile_vertical_bar_position' ) );
	}

	$classes['alignment'] = esc_attr( 'has-text-align-' . suki_get_theme_mod( 'header_mobile_vertical_bar_alignment' ) );

	return $classes;
}
add_filter( 'suki/frontend/header_mobile_vertical_classes', 'suki_header_mobile_vertical_classes' );

/**
 * Add custom classes to the array of header top bar section classes.
 *
 * @param array $classes Array of classes.
 * @return array
 */
function suki_header_top_bar_classes( $classes ) {
	$classes['container']      = esc_attr( 'suki-section-' . suki_get_theme_mod( 'header_top_bar_container' ) );
	$classes['menu_highlight'] = esc_attr( 'suki-header-menu-highlight-' . suki_get_theme_mod( 'header_top_bar_menu_highlight' ) );

	if ( boolval( suki_get_theme_mod( 'header_top_bar_merged' ) ) ) {
		$classes['merged'] = 'suki-section-merged';
	}

	return $classes;
}
add_filter( 'suki/frontend/header_top_bar_classes', 'suki_header_top_bar_classes' );

/**
 * Add custom classes to the array of header main bar section classes.
 *
 * @param array $classes Array of classes.
 * @return array
 */
function suki_header_main_bar_classes( $classes ) {
	$classes['container']      = esc_attr( 'suki-section-' . suki_get_theme_mod( 'header_main_bar_container' ) );
	$classes['menu_highlight'] = esc_attr( 'suki-header-menu-highlight-' . suki_get_theme_mod( 'header_main_bar_menu_highlight' ) );

	if ( boolval( suki_get_theme_mod( 'header_top_bar_merged' ) ) ) {
		$classes['top_bar_merged'] = 'suki-header-main-bar-with-top-bar';
	}

	if ( boolval( suki_get_theme_mod( 'header_bottom_bar_merged' ) ) ) {
		$classes['bottom_bar_merged'] = 'suki-header-main-bar-with-bottom-bar';
	}

	return $classes;
}
add_filter( 'suki/frontend/header_main_bar_classes', 'suki_header_main_bar_classes' );

/**
 * Add custom classes to the array of header bottom bar section classes.
 *
 * @param array $classes Array of classes.
 * @return array
 */
function suki_header_bottom_bar_classes( $classes ) {
	$classes['container']      = esc_attr( 'suki-section-' . suki_get_theme_mod( 'header_bottom_bar_container' ) );
	$classes['menu_highlight'] = esc_attr( 'suki-header-menu-highlight-' . suki_get_theme_mod( 'header_bottom_bar_menu_highlight' ) );

	if ( boolval( suki_get_theme_mod( 'header_bottom_bar_merged' ) ) ) {
		$classes['merged'] = 'suki-section-merged';
	}

	return $classes;
}
add_filter( 'suki/frontend/header_bottom_bar_classes', 'suki_header_bottom_bar_classes' );

/**
 * Add custom classes to the array of hero section classes.
 *
 * @param array $classes Array of classes.
 * @return array
 */
function suki_hero_classes( $classes ) {
	$classes['container'] = esc_attr( 'suki-section-' . ( 'inherit' === suki_get_current_page_setting( 'hero_container' ) ? suki_get_current_page_setting( 'content_container' ) : suki_get_current_page_setting( 'hero_container' ) ) );

	return $classes;
}
add_filter( 'suki/frontend/hero_classes', 'suki_hero_classes' );

/**
 * Add custom classes to the array of content header classes.
 *
 * @param array $classes Array of classes.
 * @return array
 */
function suki_content_header_classes( $classes ) {
	$classes['alignment'] = esc_attr( 'has-text-align-' . suki_get_current_page_setting( 'content_header_alignment' ) );

	return $classes;
}
add_filter( 'suki/frontend/content_header_classes', 'suki_content_header_classes' );

/**
 * Add custom classes to the array of content section classes.
 *
 * @param array $classes Array of classes.
 * @return array
 */
function suki_content_classes( $classes ) {
	$classes['container'] = esc_attr( 'suki-section-' . suki_get_current_page_setting( 'content_container' ) );

	if ( 'narrow' === suki_get_current_page_setting( 'content_container' ) ) {
		$classes['content_layout'] = 'suki-content-layout-wide';
	} else {
		$classes['content_layout'] = esc_attr( 'suki-content-layout-' . suki_get_current_page_setting( 'content_layout' ) );
	}

	return $classes;
}
add_filter( 'suki/frontend/content_classes', 'suki_content_classes' );

/**
 * Add custom classes to the array of posts loop classes.
 *
 * @param array $classes Array of classes.
 * @return array
 */
function suki_loop_classes( $classes ) {
	$classes['mode'] = esc_attr( 'suki-loop-' . suki_get_theme_mod( 'blog_index_loop_mode' ) );

	switch ( suki_get_theme_mod( 'blog_index_loop_mode' ) ) {
		// Default post layout.
		case 'default':
			$classes['alignment'] = 'alignfull';
			break;

		// Grid post layout.
		case 'grid':
			$classes['grid'] = esc_attr( 'is-flex-container' );

			$classes['grid_columns'] = esc_attr( 'columns-' . suki_get_theme_mod( 'blog_index_grid_columns' ) );

			if ( boolval( suki_get_theme_mod( 'entry_grid_same_height' ) ) ) {
				$classes['grid_same_height'] = 'suki-loop-grid-same-height';
			}
			break;
	}

	return $classes;
}
add_filter( 'suki/frontend/loop_classes', 'suki_loop_classes' );

/**
 * Add custom classes to entry grid thumbnail.
 *
 * @param array $classes Array of classes.
 * @return array
 */
function suki_entry_grid_thumbnail_classes( $classes ) {
	if ( boolval( suki_get_theme_mod( 'entry_grid_thumbnail_ignore_padding' ) ) ) {
		$classes['ignore_padding'] = 'suki-entry-thumbnail-ignore-padding';
	}

	return $classes;
}
add_filter( 'suki/frontend/entry_grid/thumbnail_classes', 'suki_entry_grid_thumbnail_classes' );

/**
 * Add custom classes to the array of sidebar classes.
 *
 * @param array $classes Array of classes.
 * @return array
 */
function suki_sidebar_classes( $classes ) {
	$classes['widgets_mode']            = esc_attr( 'suki-sidebar-widgets-mode-' . suki_get_theme_mod( 'sidebar_widgets_mode' ) );
	$classes['widget_title_alignment']  = esc_attr( 'suki-widget-title-alignment-' . suki_get_theme_mod( 'sidebar_widget_title_alignment' ) );
	$classes['widget_title_decoration'] = esc_attr( 'suki-widget-title-decoration-' . suki_get_theme_mod( 'sidebar_widget_title_decoration' ) );

	return $classes;
}
add_filter( 'suki/frontend/sidebar_classes', 'suki_sidebar_classes' );

/**
 * Add custom classes to the array of footer widgets classes.
 *
 * @param array $classes Array of classes.
 * @return array
 */
function suki_footer_widgets_classes( $classes ) {
	$classes['container']               = esc_attr( 'suki-section-' . suki_get_theme_mod( 'footer_widgets_bar_container' ) );
	$classes['widget_title_alignment']  = esc_attr( 'suki-widget-title-alignment-' . suki_get_theme_mod( 'footer_widgets_bar_widget_title_alignment' ) );
	$classes['widget_title_decoration'] = esc_attr( 'suki-widget-title-decoration-' . suki_get_theme_mod( 'footer_widgets_bar_widget_title_decoration' ) );

	if ( boolval( suki_get_theme_mod( 'footer_bottom_bar_merged' ) ) ) {
		$classes['bottom_bar_merged'] = 'suki-footer-widgets-bar-with-bottom-bar';
	}

	return $classes;
}
add_filter( 'suki/frontend/footer_widgets_bar_classes', 'suki_footer_widgets_classes' );

/**
 * Add custom classes to the array of footer bottom bar classes.
 *
 * @param array $classes Array of classes.
 * @return array
 */
function suki_footer_bottom_classes( $classes ) {
	$classes['container'] = esc_attr( 'suki-section-' . suki_get_theme_mod( 'footer_bottom_bar_container' ) );

	if ( boolval( suki_get_theme_mod( 'footer_bottom_bar_merged' ) ) ) {
		$classes['merged'] = 'suki-section-merged';
	}

	return $classes;
}
add_filter( 'suki/frontend/footer_bottom_bar_classes', 'suki_footer_bottom_classes' );

/**
 * Add custom classes to the array of footer bottom bar classes.
 *
 * @param array $classes Array of classes.
 * @return array
 */
function suki_scroll_to_top_classes( $classes ) {
	$classes['position'] = esc_attr( 'suki-scroll-to-top-position-' . suki_get_theme_mod( 'scroll_to_top_position' ) );
	$classes['display']  = esc_attr( 'suki-scroll-to-top-display-' . suki_get_theme_mod( 'scroll_to_top_display' ) );

	$hide_devices = array_diff( array( 'desktop', 'tablet', 'mobile' ), suki_get_theme_mod( 'scroll_to_top_visibility' ) );

	foreach ( $hide_devices as $device ) {
		$classes[ 'hide_on_' . $device ] = esc_attr( 'suki-hide-on-' . $device );
	}

	return $classes;
}
add_filter( 'suki/frontend/scroll_to_top_classes', 'suki_scroll_to_top_classes' );