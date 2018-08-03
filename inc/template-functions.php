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
	/**
	 * ====================================================
	 * Global hooks
	 * ====================================================
	 */

	/**
	 * suki/frontend/before_canvas hook
	 *
	 * @see suki_skip_to_content_link()
	 * @see suki_top_popups()
	 */
	add_action( 'suki/frontend/before_canvas', 'suki_skip_to_content_link', 1 );
	add_action( 'suki/frontend/before_canvas', 'suki_top_popups', 10 );

	/**
	 * suki/frontend/top_popups hook
	 *
	 * @see suki_mobile_vertical_header()
	 */
	add_action( 'suki/frontend/top_popups', 'suki_mobile_vertical_header', 10 );

	/**
	 * suki/frontend/header hook
	 *
	 * @see suki_main_header()
	 * @see suki_mobile_header()
	 */
	add_action( 'suki/frontend/header', 'suki_main_header', 10 );
	add_action( 'suki/frontend/header', 'suki_mobile_header', 10 );

	/**
	 * suki/frontend/after_header hook
	 *
	 * @see suki_page_header()
	 */
	add_action( 'suki/frontend/after_header', 'suki_page_header', 10 );

	/**
	 * suki/frontend/footer hook
	 *
	 * @see suki_main_footer()
	 */
	add_action( 'suki/frontend/footer', 'suki_main_footer', 10 );

	/**
	 * ====================================================
	 * Content page hooks
	 * ====================================================
	 */

	if ( is_page() ) {
		/**
		 * suki/frontend/entry_page/before_header hook
		 * 
		 * @see suki_entry_featured_media()
		 */
		if ( 'before-entry-header' === suki_get_theme_mod( 'entry_featured_media_position' ) ) {
			add_action( 'suki/frontend/entry_page/before_header', 'suki_entry_featured_media', 10 );
		}

		/**
		 * suki/frontend/entry_page/header hook
		 *
		 * @see suki_entry_title()
		 */
		if ( ! suki_get_theme_mod( 'page_header' ) || suki_get_current_page_setting( 'page_header_keep_content_header' ) || suki_get_current_page_setting( 'disable_page_header' ) ) {
			add_action( 'suki/frontend/entry_page/header', 'suki_entry_title', 10 );
		}

		/**
		 * suki/frontend/entry_page/after_header hook
		 * 
		 * @see suki_entry_featured_media()
		 */
		if ( 'after-entry-header' === suki_get_theme_mod( 'entry_featured_media_position' ) ) {
			add_action( 'suki/frontend/entry_page/after_header', 'suki_entry_featured_media', 10 );
		}
	}

	/**
	 * ====================================================
	 * Content default (blog post) hooks
	 * ====================================================
	 */

	/**
	 * suki/frontend/entry/before_header hook
	 * 
	 * @see suki_entry_featured_media()
	 */
	if ( 'before-entry-header' === suki_get_theme_mod( 'entry_featured_media_position' ) ) {
		add_action( 'suki/frontend/entry/before_header', 'suki_entry_featured_media', 10 );
	}

	/**
	 * suki/frontend/entry/header hook
	 * 
	 * @see suki_entry_header_meta()
	 * @see suki_entry_title()
	 */
	if ( ! is_singular() || ! suki_get_theme_mod( 'page_header' ) || suki_get_current_page_setting( 'page_header_keep_content_header' ) || suki_get_current_page_setting( 'disable_page_header' ) ) {
		$priority = 10;
		foreach ( suki_get_theme_mod( 'entry_header' ) as $element ) {
			$function = 'suki_entry_' . str_replace( '-', '_', $element );

			// If function exists, attach to hook.
			if ( function_exists( $function ) ) {
				add_action( 'suki/frontend/entry/header', $function, $priority );
			}

			// Increment priority number.
			$priority = $priority + 10;
		}
	}

	/**
	 * suki/frontend/entry/after_header hook
	 * 
	 * @see suki_entry_featured_media()
	 */
	if ( 'after-entry-header' === suki_get_theme_mod( 'entry_featured_media_position' ) ) {
		add_action( 'suki/frontend/entry/after_header', 'suki_entry_featured_media', 10 );
	}

	/**
	 * suki/frontend/entry/footer hook
	 * 
	 * @see suki_entry_footer_meta()
	 */
	add_action( 'suki/frontend/entry/footer', 'suki_entry_footer_meta', 10 );

	/**
	 * ====================================================
	 * Content search hooks
	 * ====================================================
	 */

	/**
	 * suki/frontend/entry_search/header hook
	 * 
	 * @see suki_entry_small_title()
	 */
	add_action( 'suki/frontend/entry_search/header', 'suki_entry_small_title', 10 );

	/**
	 * ====================================================
	 * Content grid hooks
	 * ====================================================
	 */

	/**
	 * suki/frontend/entry_grid/before_header hook
	 * 
	 * @see suki_entry_featured_media()
	 */
	if ( 'before-entry-header' === suki_get_theme_mod( 'entry_grid_featured_media_position' ) ) {
		add_action( 'suki/frontend/entry_grid/before_header', 'suki_entry_grid_featured_media', 10 );
	}

	/**
	 * suki/frontend/entry_grid_header hook
	 * 
	 * @see suki_entry_grid_header_meta()
	 * @see suki_entry_grid_title()
	 */
	$priority = 10;
	foreach ( suki_get_theme_mod( 'entry_grid_header' ) as $element ) {
		$function = 'suki_entry_grid_' . str_replace( '-', '_', $element );

		// If function exists, attach to hook.
		if ( function_exists( $function ) ) {
			add_action( 'suki/frontend/entry_grid/header', $function, $priority );
		}

		// Increment priority number.
		$priority = $priority + 10;
	}

	/**
	 * suki/frontend/entry_grid/after_header hook
	 * 
	 * @see suki_entry_featured_media()
	 */
	if ( 'after-entry-header' === suki_get_theme_mod( 'entry_grid_featured_media_position' ) ) {
		add_action( 'suki/frontend/entry_grid/after_header', 'suki_entry_grid_featured_media', 10 );
	}

	/**
	 * suki/frontend/entry_grid/footer hook
	 * 
	 * @see suki_entry_grid_footer_meta()
	 */
	add_action( 'suki/frontend/entry_grid/footer', 'suki_entry_grid_footer_meta', 10 );

	/**
	 * ====================================================
	 * Comments area hooks
	 * ====================================================
	 */
	
	/**
	 * suki/frontend/before_comments_list hook
	 * 
	 * @see suki_comments_title()
	 * @see suki_comments_navigation()
	 */
	add_action( 'suki/frontend/before_comments_list', 'suki_comments_title', 10 );
	add_action( 'suki/frontend/before_comments_list', 'suki_comments_navigation', 20 );

	/**
	 * suki/frontend/after_comments_list hook
	 * 
	 * @see suki_comments_navigation()
	 * @see suki_comments_closed()
	 */
	add_action( 'suki/frontend/after_comments_list', 'suki_comments_navigation', 10 );
	add_action( 'suki/frontend/after_comments_list', 'suki_comments_closed', 20 );

	/**
	 * ====================================================
	 * All index pages hooks
	 * ====================================================
	 */

	if ( is_archive() || is_home() || is_search() ) {
		if ( ! suki_get_theme_mod( 'page_header' ) || suki_get_current_page_setting( 'page_header_keep_content_header' ) || suki_get_current_page_setting( 'disable_page_header' ) ) {
			/**
			 * suki/frontend/before_main hook
			 * 
			 * @see suki_loop_navigation()
			 */
			add_action( 'suki/frontend/before_main', 'suki_content_header', 10 );
		}

		/**
		 * suki/frontend/after_main hook
		 * 
		 * @see suki_loop_navigation()
		 */
		add_action( 'suki/frontend/after_main', 'suki_loop_navigation', 10 );
	}

	/**
	 * ====================================================
	 * All singular post hooks
	 * ====================================================
	 */

	if ( is_singular() ) {
		/**
		 * suki/frontend/entry/before_footer hook
		 * 
		 * @see suki_entry_tags()
		 */
		add_action( 'suki/frontend/entry/before_footer', 'suki_entry_tags', 10 );

		/**
		 * suki/frontend/after_main hook
		 * 
		 * @see suki_single_post_author_bio()
		 * @see suki_single_post_navigation()
		 * @see suki_entry_comments()
		 */
		if ( suki_get_theme_mod( 'blog_single_author_bio' ) ) {
			add_action( 'suki/frontend/after_main', 'suki_single_post_author_bio', 10 );
		}
		if ( suki_get_theme_mod( 'blog_single_navigation' ) ) {
			add_action( 'suki/frontend/after_main', 'suki_single_post_navigation', 15 );
		}
		add_action( 'suki/frontend/after_main', 'suki_entry_comments', 20 );
	}
}
add_action( 'wp', 'suki_template_hooks' );

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
add_filter( 'suki/frontend/header_mobile_vertical_bar_classes', 'suki_header_mobile_vertical_bar_classes' );

/**
 * Add custom classes to the array of header top bar section classes.
 *
 * @param array $classes
 * @return array
 */
function suki_header_top_bar_classes( $classes ) {
	$classes['container'] = esc_attr( 'suki-section-' . suki_get_theme_mod( 'header_top_bar_container' ) );
	$classes['menu_highlight'] = esc_attr( 'suki-header-menu-highlight-' . suki_get_theme_mod( 'header_top_bar_menu_highlight' ) );

	if ( suki_get_theme_mod( 'header_top_bar_merged' ) ) {
		$classes['container'] = 'suki-section-merged';
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

	if ( suki_get_theme_mod( 'header_bottom_bar_merged' ) ) {
		$classes['container'] = 'suki-section-merged';
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
	$classes['layout'] = esc_attr( 'suki-page-header-layout-' . suki_get_theme_mod( 'page_header_layout' ) );

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
	if ( 'grid' == suki_get_theme_mod( 'blog_index_loop_mode' ) ) {
		$classes['float-container'] = esc_attr( 'suki-float-container' );
		$classes['blog_index_grid_columns'] = esc_attr( 'suki-loop-grid-' . suki_get_theme_mod( 'blog_index_grid_columns' ) . '-columns' );
	}

	return $classes;
}
add_filter( 'suki/frontend/loop_classes', 'suki_loop_classes' );

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

	if ( suki_get_theme_mod( 'footer_bottom_bar_merged' ) ) {
		$classes['container'] = 'suki-section-merged';
	}

	return $classes;
}
add_filter( 'suki/frontend/footer_bottom_bar_classes', 'suki_footer_bottom_classes' );