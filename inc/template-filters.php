<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * ====================================================
 * HTML Head filters
 * ====================================================
 */

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function suki_pingback_header() {
	if ( is_singular() && pings_open() ) {
		/* translators: %s: pingback url. */
		printf( '<link rel="pingback" href="%s">' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'suki_pingback_header' );

/**
 * Add preconnect for Google Fonts embed fonts.
 *
 * @param array $urls
 * @param string $relation_type
 * @return array $urls
 */
function suki_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'suki-google-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'suki_resource_hints', 10, 2 );

/**
 * ====================================================
 * Template rendering filters
 * ====================================================
 */

/**
 * Modify oembed HTML ouput.
 * 
 * @param string $html
 * @param string $url
 * @param array $attr
 * @param integer $post_id
 * @return string
 */
function suki_oembed_wrapper( $html, $url, $attr, $post_id ) {
	// Default attributes
	$atts = array( 'class' => 'suki-oembed' );

	// Check if the oembed HTML is a video.
	if ( preg_match( '/^<(?:iframe|embed|object)([^>]+)>/', $html, $video_match ) ) {
		$atts['class'] .= ' suki-oembed-video';

		// Extract all attributes (if any).
		if ( preg_match_all( '/(\w+)=[\'\"]?([^\'\"]*)[\'\"]?/', $video_match[1], $atts_matches ) ) {
			// Format all attributes into associative array.
			$video_atts = array();
			for ( $i = 0; $i < count( $atts_matches[1] ); $i++ ) {
				$video_atts[ $atts_matches[1][ $i ] ] = $atts_matches[2][ $i ];
			}

			// Check if there is width & height attributes found, use those values for responsive ratio.
			if ( isset( $video_atts['width'] ) && isset( $video_atts['height'] ) ) {
				$w = intval( $video_atts['width'] );
				$h = intval( $video_atts['height'] );

				$atts['style'] = 'padding-top: ' . round( ( $h / $w * 100 ), 3 ) . '%;';
			}
			// If not found, use default 16:9 ratio.
			else {
				$atts['style'] = 'padding-top: 56.25%;';
			}
		}
	}

	// Filter to modidy oembed HTML attributes.
	$atts = apply_filters( 'suki_oembed_attributes', $atts );

	// Build the attributes HTML.
	$atts_html = '';
	foreach ( $atts as $key => $value ) {
		$atts_html .= ' ' . $key . '="' . esc_attr( $value ) . '"';
	}

	return '<div' . $atts_html . '>' . $html . '</div>';
}
add_filter( 'embed_oembed_html', 'suki_oembed_wrapper', 10, 4 );

/**
 * Modify "read more" HTML output.
 * 
 * @param integer $length
 * @return integer
 */
function suki_read_more( $link ) {
	return '<p class="read-more">' . $link . '</p>';
}
add_filter( 'the_content_more_link', 'suki_read_more' );

/**
 * Modify blog post's excerpt character limit.
 * 
 * @param integer $length
 * @return integer
 */
function suki_excerpt_length( $length ) {
	if ( is_search() ) {
		return 30;
	}

	if ( 'grid' === suki_get_theme_mod( 'blog_index_loop_mode' ) ) {
		return suki_get_theme_mod( 'entry_grid_excerpt_length' );
	} else {
		return $length;
	}
}
add_filter( 'excerpt_length', 'suki_excerpt_length' );

/**
 * Modify blog post's excerpt end string.
 * 
 * @param string $more
 * @return string
 */
function suki_excerpt_more( $more ) {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'suki_excerpt_more' );

/**
 * Add dropdown caret to accordion menu item.
 *
 * @param string $item_output
 * @param WP_Post $item
 * @param integer $depth
 * @param stdClass $args
 * @return string
 */
function suki_walker_nav_menu_start_el( $item_output, $item, $depth, $args ) {
	$sign = '';

	// Only add to menu item that has sub menu.
	if ( in_array( 'menu-item-has-children', $item->classes ) || in_array( 'page_item_has_children', $item->classes ) ) {
		// Only add to toggle menu.
		if ( is_integer( strpos( $args->menu_class, 'suki-toggle-menu' ) ) ) {
			$sign = '<button class="suki-sub-menu-toggle suki-toggle">' . suki_icon( 'submenu-down', array( 'class' => 'suki-dropdown-sign' ), false ) . '<span class="screen-reader-text">' . esc_html__( 'Expand / Collapse', 'suki' ) . '</span></button>';
		}
	}

	return $item_output . trim( $sign );
}
add_filter( 'walker_nav_menu_start_el', 'suki_walker_nav_menu_start_el', 99, 4 );

/**
 * Add <span> wrapping tag and dropdown caret to menu item title.
 *
 * @param string $title
 * @param WP_Post $item
 * @param stdClass $args
 * @param integer $depth
 * @return string
 */
function suki_nav_menu_item_title( $title, $item, $args, $depth ) {
	$sign = '';

	// Only add to menu item that has sub menu.
	if ( in_array( 'menu-item-has-children', $item->classes ) || in_array( 'page_item_has_children', $item->classes ) ) {
		// Only add to hover menu.
		if ( is_integer( strpos( $args->menu_class, 'suki-hover-menu' ) ) ) {
			$sign = suki_icon( 0 < $depth ? 'submenu-right' : 'submenu-down', array( 'class' => 'suki-dropdown-sign' ), false );
		}
	}

	return '<span class="suki-menu-item-title">' . $title . '</span>' . trim( $sign );
}
add_filter( 'nav_menu_item_title', 'suki_nav_menu_item_title', 99, 4 );

/**
 * Add SVG icon to search textbox.
 *
 * @param string $from
 * @return string
 */
function suki_get_search_form_add_icon( $form ) {
	$form = preg_replace( '/<\/form>/', suki_icon( 'search', array( 'class' => 'suki-search-icon' ), false ) . '</form>', $form );

	return $form;
}
add_filter( 'get_search_form', 'suki_get_search_form_add_icon' );
add_filter( 'get_product_search_form', 'suki_get_search_form_add_icon' );

/**
 * ====================================================
 * Blog elements
 * ====================================================
 */

/**
 * Modify tagcloud arguments.
 * 
 * @param array $args
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
 * Add LTR class to the array of body classes.
 *
 * @param array $classes.
 * @return array
 */
function suki_body_ltr_class( $classes ) {
	if ( ! is_rtl() ) {
		$classes[] = 'ltr';
	}

	// RTL class is automatically added by default when RTL mode is active.

	return $classes;
}
add_filter( 'body_class', 'suki_body_ltr_class', -1 );

/**
 * Add custom classes to the array of body classes.
 *
 * @param array $classes.
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

	return $classes;
}
add_filter( 'body_class', 'suki_body_classes' );

/**
 * Add custom classes to the array of mobile vertical header classes.
 *
 * @param array $classes
 * @return array
 */
function suki_header_mobile_vertical_bar_classes( $classes ) {
	$classes['position'] = esc_attr( 'suki-header-vertical-position-' . suki_get_theme_mod( 'header_mobile_vertical_bar_position' ) );
	$classes['alignment'] = esc_attr( 'suki-text-align-' . suki_get_theme_mod( 'header_mobile_vertical_bar_alignment' ) );

	return $classes;
}
add_filter( 'suki_header_mobile_vertical_bar_classes', 'suki_header_mobile_vertical_bar_classes' );

/**
 * Add custom classes to the array of header top bar section classes.
 *
 * @param array $classes
 * @return array
 */
function suki_header_top_bar_classes( $classes ) {
	$classes['container'] = esc_attr( 'suki-section-' . suki_get_theme_mod( 'header_top_bar_container' ) );

	return $classes;
}
add_filter( 'suki_header_top_bar_classes', 'suki_header_top_bar_classes' );

/**
 * Add custom classes to the array of header main bar section classes.
 *
 * @param array $classes
 * @return array
 */
function suki_header_main_bar_classes( $classes ) {
	$classes['container'] = esc_attr( 'suki-section-' . suki_get_theme_mod( 'header_main_bar_container' ) );

	return $classes;
}
add_filter( 'suki_header_main_bar_classes', 'suki_header_main_bar_classes' );

/**
 * Add custom classes to the array of header bottom bar section classes.
 *
 * @param array $classes
 * @return array
 */
function suki_header_bottom_bar_classes( $classes ) {
	$classes['container'] = esc_attr( 'suki-section-' . suki_get_theme_mod( 'header_bottom_bar_container' ) );

	return $classes;
}
add_filter( 'suki_header_bottom_bar_classes', 'suki_header_bottom_bar_classes' );

/**
 * Add custom classes to the array of page title section classes.
 *
 * @param array $classes
 * @return array
 */
function suki_page_title_classes( $classes ) {
	$classes['container'] = esc_attr( 'suki-section-' . suki_get_theme_mod( 'page_title_container' ) );
	$classes['alignment'] = esc_attr( 'suki-page-title-align-' . suki_get_theme_mod( 'page_title_alignment' ) );

	return $classes;
}
add_filter( 'suki_page_title_classes', 'suki_page_title_classes' );

/**
 * Add custom classes to the array of content section classes.
 *
 * @param array $classes
 * @return array
 */
function suki_content_classes( $classes ) {
	$classes['container'] = esc_attr( 'suki-section-' . suki_get_current_page_setting( 'content_container' ) );
	$classes['content_layout'] = esc_attr( 'suki-content-layout-' . suki_get_current_page_setting( 'content_layout' ) );

	return $classes;
}
add_filter( 'suki_content_classes', 'suki_content_classes' );

/**
 * Add custom classes to the array of posts loop classes.
 *
 * @param array $classes
 * @return array
 */
function suki_loop_classes( $classes ) {
	$classes['blog_index_loop_mode'] = esc_attr( 'suki-loop-' . suki_get_theme_mod( 'blog_index_loop_mode' ) );
	if ( 'grid' == suki_get_theme_mod( 'blog_index_loop_mode' ) ) {
		$classes['float-container'] = esc_attr( 'suki-float-container' );
		$classes['blog_index_grid_columns'] = esc_attr( 'suki-loop-grid-' . suki_get_theme_mod( 'blog_index_grid_columns' ) . '-columns' );
	}

	return $classes;
}
add_filter( 'suki_loop_classes', 'suki_loop_classes' );

/**
 * Add custom classes to the array of sidebar classes.
 *
 * @param array $classes
 * @return array
 */
function suki_sidebar_classes( $classes ) {
	$classes['sidebar_widgets_mode'] = esc_attr( 'suki-sidebar-widgets-mode-' . suki_get_theme_mod( 'sidebar_widgets_mode' ) );

	return $classes;
}
add_filter( 'suki_sidebar_classes', 'suki_sidebar_classes' );

/**
 * Add custom classes to the array of footer widgets classes.
 *
 * @param array $classes
 * @return array
 */
function suki_footer_widgets_bar_classes( $classes ) {
	$classes['footer_widgets_bar_container'] = esc_attr( 'suki-section-' . suki_get_theme_mod( 'footer_widgets_bar_container' ) );
	$classes['footer_widget_title_decoration'] = esc_attr( 'suki-widget-title-decoration-' . suki_get_theme_mod( 'footer_widget_title_decoration' ) );

	if ( suki_get_theme_mod( 'footer_bottom_bar_merged' ) ) {
		$classes['footer_bottom_bar_merged'] = esc_attr( 'suki-footer-bar-merged' );
	}

	return $classes;
}
add_filter( 'suki_footer_widgets_bar_classes', 'suki_footer_widgets_bar_classes' );

/**
 * Add custom classes to the array of footer bottom bar classes.
 *
 * @param array $classes
 * @return array
 */
function suki_footer_bottom_bar_classes( $classes ) {
	$classes['footer_bottom_bar_container'] = esc_attr( 'suki-section-' . suki_get_theme_mod( 'footer_bottom_bar_container' ) );

	return $classes;
}
add_filter( 'suki_footer_bottom_bar_classes', 'suki_footer_bottom_bar_classes' );