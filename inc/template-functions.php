<?php
/**
 * Custom functions to modify frontend templates via hooks.
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
 * Template hooks
 * ====================================================
 */

/**
 * Attach template functions into the proper template hooks.
 * All template functions can be found on 'inc/template-tags.php' file.
 */
function suki_template_hooks() {
	$is_title_in_page_header = false;

	if ( intval( suki_get_current_page_setting( 'page_header' ) ) ) {
		foreach ( array( 'left', 'center', 'right' ) as $pos ) {
			if ( in_array( 'title', suki_get_theme_mod( 'page_header_elements_' . $pos, array() ) ) ) {
				$is_title_in_page_header = true;
				break;
			}
		}
	}

	/**
	 * ====================================================
	 * Global hooks
	 * ====================================================
	 */

	// Add "skip to content" link before canvas.
	add_action( 'suki/frontend/before_canvas', 'suki_skip_to_content_link', 1 );
	
	// Add mobile vertical header link before canvas.
	add_action( 'suki/frontend/before_canvas', 'suki_mobile_vertical_header', 10 );

	// Add main header.
	add_action( 'suki/frontend/header', 'suki_main_header', 10 );
	
	// Add mobile header.
	add_action( 'suki/frontend/header', 'suki_mobile_header', 10 );

	// Add default logo.
	add_action( 'suki/frontend/logo', 'suki_default_logo', 10 );

	// Add default mobile logo.
	add_action( 'suki/frontend/mobile_logo', 'suki_default_mobile_logo', 10 );

	// Add page header after header section.
	add_action( 'suki/frontend/after_header', 'suki_page_header', 10 );

	// Add main footer.
	add_action( 'suki/frontend/footer', 'suki_main_footer', 10 );

	// Add scroll to top button.
	add_action( 'suki/frontend/after_canvas', 'suki_scroll_to_top', 10 );

	// Add do_shortcode to all kind of archive description.
	add_filter( 'term_description', 'do_shortcode' );
	add_filter( 'get_the_post_type_description', 'do_shortcode' );
	add_filter( 'get_the_author_description', 'do_shortcode' );

	/**
	 * ====================================================
	 * Content default (post / page) hooks
	 * ====================================================
	 */

	// Add featured media.
	add_action( 'suki/frontend/entry/' . str_replace( '-entry-', '_', suki_get_theme_mod( 'entry_featured_media_position' ) ), 'suki_entry_featured_media', 10 );

	// Add entry header elements.
	if ( ! is_singular() || ! $is_title_in_page_header ) {
		if ( ! intval( suki_get_current_page_setting( 'content_hide_title' ) ) ) {

			if ( is_page() ) {
				add_action( 'suki/frontend/entry/header', 'suki_entry_title', 10 );
			} else {
				$priority = 10;
				foreach ( suki_get_theme_mod( 'entry_header', array() ) as $element ) {
					$function = 'suki_entry_' . str_replace( '-', '_', $element );

					// If function exists, attach to hook.
					if ( function_exists( $function ) ) {
						add_action( 'suki/frontend/entry/header', $function, $priority );
					}

					// Increment priority number.
					$priority = $priority + 10;
				}
			}
			
		}
	}

	// Add entry footer elements.
	if ( ! is_page() ) {
		$priority = 10;
		foreach ( suki_get_theme_mod( 'entry_footer', array() ) as $element ) {
			$function = 'suki_entry_' . str_replace( '-', '_', $element );

			// If function exists, attach to hook.
			if ( function_exists( $function ) ) {
				add_action( 'suki/frontend/entry/footer', $function, $priority );
			}

			// Increment priority number.
			$priority = $priority + 10;
		}
	}

	/**
	 * ====================================================
	 * Content search hooks
	 * ====================================================
	 */

	// Add title to search result entry header.
	add_action( 'suki/frontend/entry_search/header', 'suki_entry_small_title', 10 );

	/**
	 * ====================================================
	 * Content grid hooks
	 * ====================================================
	 */

	// Add featured media.
	add_action( 'suki/frontend/entry_grid/' . str_replace( '-entry-', '_', suki_get_theme_mod( 'entry_grid_featured_media_position' ) ), 'suki_entry_grid_featured_media', 10 );

	// Add grid entry header elements.
	$priority = 10;
	foreach ( suki_get_theme_mod( 'entry_grid_header', array() ) as $element ) {
		$function = 'suki_entry_grid_' . str_replace( '-', '_', $element );

		// If function exists, attach to hook.
		if ( function_exists( $function ) ) {
			add_action( 'suki/frontend/entry_grid/header', $function, $priority );
		}

		// Increment priority number.
		$priority = $priority + 10;
	}

	// Add grid entry footer elements.
	$priority = 10;
	foreach ( suki_get_theme_mod( 'entry_grid_footer', array() ) as $element ) {
		$function = 'suki_entry_grid_' . str_replace( '-', '_', $element );

		// If function exists, attach to hook.
		if ( function_exists( $function ) ) {
			add_action( 'suki/frontend/entry_grid/footer', $function, $priority );
		}

		// Increment priority number.
		$priority = $priority + 10;
	}

	/**
	 * ====================================================
	 * Comments area hooks
	 * ====================================================
	 */
	
	// Add comments title.
	add_action( 'suki/frontend/before_comments_list', 'suki_comments_title', 10 );
	
	// Add comments navigation.
	add_action( 'suki/frontend/before_comments_list', 'suki_comments_navigation', 20 );
	add_action( 'suki/frontend/after_comments_list', 'suki_comments_navigation', 10 );

	// Add "comments closed" notice.
	add_action( 'suki/frontend/after_comments_list', 'suki_comments_closed', 20 );

	/**
	 * ====================================================
	 * All index pages hooks
	 * ====================================================
	 */

	if ( is_archive() || is_home() || is_search() ) {

		if ( is_archive() ) {
			// Add archive header.
			add_action( 'suki/frontend/before_main', 'suki_archive_header', 10 );

			// Add archive title into archive header.
			if ( ! $is_title_in_page_header ) {
				add_action( 'suki/frontend/archive_header', 'suki_archive_title', 10 );
			}

			if ( '' !== trim( get_the_archive_description() ) ) {
				// Add archive description into archive header.
				add_action( 'suki/frontend/archive_header', 'suki_archive_description', 20 );
			}
		}

		if ( is_search() ) {
			// Add search results header.
			add_action( 'suki/frontend/before_main', 'suki_search_header', 10 );

			// Add archive title into search results header.
			if ( ! $is_title_in_page_header ) {
				add_action( 'suki/frontend/search_header', 'suki_search_title', 10 );
			}

			// Add search form into archive header.
			add_action( 'suki/frontend/search_header', 'suki_search_form', 20 );
		}

		// Add navigation after the loop.
		add_action( 'suki/frontend/after_main', 'suki_loop_navigation', 10 );
	}

	/**
	 * ====================================================
	 * All singular post hooks
	 * ====================================================
	 */

	if ( is_singular() ) {
		// Add tags.
		add_action( 'suki/frontend/entry/before_footer', 'suki_entry_tags', 10 );

		// Add author bio.
		add_action( 'suki/frontend/after_main', 'suki_single_post_author_bio', 10 );
		
		// Add post navigation.
		add_action( 'suki/frontend/after_main', 'suki_single_post_navigation', 15 );

		// Add comments.
		add_action( 'suki/frontend/after_main', 'suki_entry_comments', 20 );
	}
}
add_action( 'wp', 'suki_template_hooks', 20 );

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

	// Filter to modify oembed HTML attributes.
	$atts = apply_filters( 'suki/frontend/oembed_attributes', $atts );

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
	// Search page
	if ( is_search() ) {
		return 30;
	}

	// Posts page
	elseif ( ( is_home() || is_archive() ) && 'post' === get_post_type() ) {
		$layout = suki_get_theme_mod( 'blog_index_loop_mode' );

		if ( 'default' === $layout ) {
			$key = 'entry_excerpt_length';
		} else {
			$key = 'entry_' . $layout . '_excerpt_length';
		}

		return intval( suki_get_theme_mod( $key, $length ) );
	}

	// Else
	return $length;
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
	// Only add to menu item that has sub menu.
	if ( in_array( 'menu-item-has-children', $item->classes ) || in_array( 'page_item_has_children', $item->classes ) ) {
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
			$sign = suki_icon( 0 < $depth ? 'chevron-right' : 'chevron-down', array( 'class' => 'suki-dropdown-sign' ), false );
		}
	}

	return '<span class="suki-menu-item-title">' . $title . '</span>' . trim( $sign );
}
add_filter( 'nav_menu_item_title', 'suki_nav_menu_item_title', 99, 4 );

/**
 * Add 'suki-menu-item-link' class to menu item's anchor tag.
 *
 * @param array $atts
 * @param WP_Post $item
 * @param stdClass $args
 * @param int $depth
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
 * Add SVG icon to search textbox.
 *
 * @param string $from
 * @return string
 */
function suki_get_search_form_add_icon( $form ) {
	$form = preg_replace( '/placeholder="(.*?)"/', 'placeholder="' . esc_attr__( 'Search&hellip;', 'suki' ) . '"', $form );
	$form = preg_replace( '/<\/form>/', suki_icon( 'search', array( 'class' => 'suki-search-icon' ), false ) . '</form>', $form );

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

	// Add font smoothing class.
	if ( intval( suki_get_theme_mod( 'font_smoothing' ) ) ) {
		$classes['font_smoothing'] = esc_attr( 'suki-font-smoothing-1' );
	}

	return $classes;
}
add_filter( 'body_class', 'suki_body_classes' );

/**
 * Add custom classes to the array of mobile vertical header classes.
 *
 * @param array $classes
 * @return array
 */
function suki_header_mobile_vertical_classes( $classes ) {
	$classes['display'] = esc_attr( 'suki-header-mobile-vertical-display-' . suki_get_theme_mod( 'header_mobile_vertical_bar_display' ) );

	$classes['position'] = esc_attr( 'suki-header-mobile-vertical-position-' . suki_get_theme_mod( 'header_mobile_vertical_bar_position' ) );

	$classes['alignment'] = esc_attr( 'suki-text-align-' . suki_get_theme_mod( 'header_mobile_vertical_bar_alignment' ) );

	return $classes;
}
add_filter( 'suki/frontend/header_mobile_vertical_classes', 'suki_header_mobile_vertical_classes' );

/**
 * Add custom classes to the array of header top bar section classes.
 *
 * @param array $classes
 * @return array
 */
function suki_header_top_bar_classes( $classes ) {
	$classes['container'] = esc_attr( 'suki-section-' . suki_get_theme_mod( 'header_top_bar_container' ) );
	$classes['menu_highlight'] = esc_attr( 'suki-header-menu-highlight-' . suki_get_theme_mod( 'header_top_bar_menu_highlight' ) );

	if ( intval( suki_get_theme_mod( 'header_top_bar_merged' ) ) ) {
		$classes['merged'] = 'suki-section-merged';
	}

	return $classes;
}
add_filter( 'suki/frontend/header_top_bar_classes', 'suki_header_top_bar_classes' );

/**
 * Add custom classes to the array of header main bar section classes.
 *
 * @param array $classes
 * @return array
 */
function suki_header_main_bar_classes( $classes ) {
	$classes['container'] = esc_attr( 'suki-section-' . suki_get_theme_mod( 'header_main_bar_container' ) );
	$classes['menu_highlight'] = esc_attr( 'suki-header-menu-highlight-' . suki_get_theme_mod( 'header_main_bar_menu_highlight' ) );

	if ( intval( suki_get_theme_mod( 'header_top_bar_merged' ) ) ) {
		$classes['top_bar_merged'] = 'suki-header-main-bar-with-top-bar';
	}

	if ( intval( suki_get_theme_mod( 'header_bottom_bar_merged' ) ) ) {
		$classes['bottom_bar_merged'] = 'suki-header-main-bar-with-bottom-bar';
	}

	return $classes;
}
add_filter( 'suki/frontend/header_main_bar_classes', 'suki_header_main_bar_classes' );

/**
 * Add custom classes to the array of header bottom bar section classes.
 *
 * @param array $classes
 * @return array
 */
function suki_header_bottom_bar_classes( $classes ) {
	$classes['container'] = esc_attr( 'suki-section-' . suki_get_theme_mod( 'header_bottom_bar_container' ) );
	$classes['menu_highlight'] = esc_attr( 'suki-header-menu-highlight-' . suki_get_theme_mod( 'header_bottom_bar_menu_highlight' ) );

	if ( intval( suki_get_theme_mod( 'header_bottom_bar_merged' ) ) ) {
		$classes['merged'] = 'suki-section-merged';
	}

	return $classes;
}
add_filter( 'suki/frontend/header_bottom_bar_classes', 'suki_header_bottom_bar_classes' );

/**
 * Add custom classes to the array of page header section classes.
 *
 * @param array $classes
 * @return array
 */
function suki_page_header_classes( $classes ) {
	$classes['container'] = esc_attr( 'suki-section-' . suki_get_theme_mod( 'page_header_container' ) );

	return $classes;
}
add_filter( 'suki/frontend/page_header_classes', 'suki_page_header_classes' );

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
add_filter( 'suki/frontend/content_classes', 'suki_content_classes' );

/**
 * Add custom classes to the array of posts loop classes.
 *
 * @param array $classes
 * @return array
 */
function suki_loop_classes( $classes ) {
	$classes['mode'] = esc_attr( 'suki-loop-' . suki_get_theme_mod( 'blog_index_loop_mode' ) );

	// Grid
	if ( 'grid' == suki_get_theme_mod( 'blog_index_loop_mode' ) ) {
		$classes['blog_index_grid_columns'] = esc_attr( 'suki-loop-grid-' . suki_get_theme_mod( 'blog_index_grid_columns' ) . '-columns' );

		if ( intval( suki_get_theme_mod( 'entry_grid_same_height' ) ) ) {
			$classes['entry_grid_same_height'] = 'suki-loop-grid-same-height';
		}
	}

	return $classes;
}
add_filter( 'suki/frontend/loop_classes', 'suki_loop_classes' );

/**
 * Add custom classes to entry thumbnail.
 *
 * @param array $classes
 * @return array
 */
function suki_entry_thumbnail_classes( $classes ) {
	if ( intval( suki_get_theme_mod( 'entry_featured_media_ignore_padding' ) ) ) {
		$classes['entry_featured_media_ignore_padding'] = 'suki-entry-thumbnail-ignore-padding';
	}

	return $classes;
}
add_filter( 'suki/frontend/entry/thumbnail_classes', 'suki_entry_thumbnail_classes' );

/**
 * Add custom classes to entry grid thumbnail.
 *
 * @param array $classes
 * @return array
 */
function suki_entry_grid_thumbnail_classes( $classes ) {
	if ( intval( suki_get_theme_mod( 'entry_grid_featured_media_ignore_padding' ) ) ) {
		$classes['entry_grid_featured_media_ignore_padding'] = 'suki-entry-thumbnail-ignore-padding';
	}

	return $classes;
}
add_filter( 'suki/frontend/entry_grid/thumbnail_classes', 'suki_entry_grid_thumbnail_classes' );

/**
 * Add custom classes to the array of sidebar classes.
 *
 * @param array $classes
 * @return array
 */
function suki_sidebar_classes( $classes ) {
	$classes['widgets_mode'] = esc_attr( 'suki-sidebar-widgets-mode-' . suki_get_theme_mod( 'sidebar_widgets_mode' ) );
	$classes['widget_title_alignment'] = esc_attr( 'suki-widget-title-alignment-' . suki_get_theme_mod( 'sidebar_widget_title_alignment' ) );
	$classes['widget_title_decoration'] = esc_attr( 'suki-widget-title-decoration-' . suki_get_theme_mod( 'sidebar_widget_title_decoration' ) );

	return $classes;
}
add_filter( 'suki/frontend/sidebar_classes', 'suki_sidebar_classes' );

/**
 * Add custom classes to the array of footer widgets classes.
 *
 * @param array $classes
 * @return array
 */
function suki_footer_widgets_classes( $classes ) {
	$classes['container'] = esc_attr( 'suki-section-' . suki_get_theme_mod( 'footer_widgets_bar_container' ) );
	$classes['widget_title_alignment'] = esc_attr( 'suki-widget-title-alignment-' . suki_get_theme_mod( 'footer_widgets_bar_widget_title_alignment' ) );
	$classes['widget_title_decoration'] = esc_attr( 'suki-widget-title-decoration-' . suki_get_theme_mod( 'footer_widgets_bar_widget_title_decoration' ) );

	if ( intval( suki_get_theme_mod( 'footer_bottom_bar_merged' ) ) ) {
		$classes['bottom_bar_merged'] = 'suki-footer-widgets-bar-with-bottom-bar';
	}

	return $classes;
}
add_filter( 'suki/frontend/footer_widgets_bar_classes', 'suki_footer_widgets_classes' );

/**
 * Add custom classes to the array of footer bottom bar classes.
 *
 * @param array $classes
 * @return array
 */
function suki_footer_bottom_classes( $classes ) {
	$classes['container'] = esc_attr( 'suki-section-' . suki_get_theme_mod( 'footer_bottom_bar_container' ) );

	if ( intval( suki_get_theme_mod( 'footer_bottom_bar_merged' ) ) ) {
		$classes['merged'] = 'suki-section-merged';
	}

	return $classes;
}
add_filter( 'suki/frontend/footer_bottom_bar_classes', 'suki_footer_bottom_classes' );

/**
 * Add custom classes to the array of footer bottom bar classes.
 *
 * @param array $classes
 * @return array
 */
function suki_scroll_to_top_classes( $classes ) {
	$classes['position'] = esc_attr( 'suki-scroll-to-top-position-' . suki_get_theme_mod( 'scroll_to_top_position' ) );
	$classes['display'] = esc_attr( 'suki-scroll-to-top-display-' . suki_get_theme_mod( 'scroll_to_top_display' ) );

	$hide_devices = array_diff( array( 'desktop', 'tablet', 'mobile' ), suki_get_theme_mod( 'scroll_to_top_visibility' ) );

	foreach( $hide_devices as $device ) {
		$classes['hide_on_' . $device ] = esc_attr( 'suki-hide-on-' . $device );
	}

	return $classes;
}
add_filter( 'suki/frontend/scroll_to_top_classes', 'suki_scroll_to_top_classes' );