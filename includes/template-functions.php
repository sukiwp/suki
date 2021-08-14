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
 * All template functions can be found on 'includes/template-tags.php' file.
 */
function suki_template_hooks() {
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

	// Add main footer.
	add_action( 'suki/frontend/footer', 'suki_main_footer', 10 );

	// Add scroll to top button.
	add_action( 'suki/frontend/after_canvas', 'suki_scroll_to_top', 10 );

	// Add do_shortcode to all kind of archive description.
	add_filter( 'term_description', 'do_shortcode' );
	add_filter( 'get_the_post_type_description', 'do_shortcode' );
	add_filter( 'get_the_author_description', 'do_shortcode' );

	// Add content header elements on currently loaded page.
	$priority = 10;
	foreach ( suki_get_current_page_setting( 'content_header', array() ) as $element ) {
		add_action( 'suki/frontend/content_header', function() use( $element ) {
			// This action can't be modified or removed, because it uses anonymous function.
			suki_content_header_element( $element );
		}, $priority );

		// Increment priority number.
		$priority = $priority + 10;
	}

	/**
	 * ====================================================
	 * Post Layout: Default
	 * ====================================================
	 */

	// Add thumbnail before or after content header.
	add_action( 'suki/frontend/entry/' . suki_get_theme_mod( 'entry_thumbnail_position' ) . '_header', 'suki_entry_thumbnail', 10 );

	// Add entry header elements.
	$priority = 10;
	foreach ( suki_get_theme_mod( 'entry_header', array() ) as $element ) {
		add_action( 'suki/frontend/entry/header', function() use( $element ) {
			// This action can't be modified or removed, because it uses anonymous function.
			suki_entry_header_footer_element( $element );
		}, $priority );

		// Increment priority number.
		$priority = $priority + 10;
	}

	// Add entry footer elements.
	$priority = 10;
	foreach ( suki_get_theme_mod( 'entry_footer', array() ) as $element ) {
		add_action( 'suki/frontend/entry/footer', function() use( $element ) {
			// This action can't be modified or removed, because it uses anonymous function.
			suki_entry_header_footer_element( $element );
		}, $priority );

		// Increment priority number.
		$priority = $priority + 10;
	}

	/**
	 * ====================================================
	 * Post Layout: Grid
	 * ====================================================
	 */

	// Add thumbnail before or after content header.
	add_action( 'suki/frontend/entry_grid/' . suki_get_theme_mod( 'entry_grid_thumbnail_position' ) . '_header', 'suki_entry_grid_thumbnail', 10 );

	// Add entry grid header elements.
	$priority = 10;
	foreach ( suki_get_theme_mod( 'entry_grid_header', array() ) as $element ) {
		add_action( 'suki/frontend/entry_grid/header', function() use( $element ) {
			// This action can't be modified or removed, because it uses anonymous function.
			suki_entry_header_footer_element( $element, 'grid' );
		}, $priority );

		// Increment priority number.
		$priority = $priority + 10;
	}

	// Add entry grid footer elements.
	$priority = 10;
	foreach ( suki_get_theme_mod( 'entry_grid_footer', array() ) as $element ) {
		add_action( 'suki/frontend/entry_grid/footer', function() use( $element ) {
			// This action can't be modified or removed, because it uses anonymous function.
			suki_entry_header_footer_element( $element, 'grid' );
		}, $priority );

		// Increment priority number.
		$priority = $priority + 10;
	}

	/**
	 * ====================================================
	 * Search Results Item
	 * ====================================================
	 */

	// Add title to search result entry header.
	add_action( 'suki/frontend/entry_search/header', 'suki_entry_small_title', 10 );

	/**
	 * ====================================================
	 * All archive page hooks
	 * ====================================================
	 */

	if ( is_archive() || is_home() || is_search() ) {
		/**
		 * ====================================================
		 * Archive Content Header
		 * ====================================================
		 */

		// Add content header before main content.
		if ( ! intval( suki_get_current_page_setting( 'hero' ) ) ) {
			// Only add if content header is not disabled.
			if ( ! intval( suki_get_current_page_setting( 'disable_content_header' ) ) ) {
				// Add content header on non blog page OR if "Show content header on blog page" option is enabled.
				if ( ! is_home() || intval( suki_get_theme_mod( 'post_archive_home_content_header' ) ) ) {
					add_action( 'suki/frontend/before_main', 'suki_content_header', 10 );
				}
			}
		}

		/**
		 * ====================================================
		 * Archive Navigation
		 * ====================================================
		 */

		// Add navigation after the loop.
		add_action( 'suki/frontend/after_main', 'suki_archive_navigation', 10 );
	}

	/**
	 * ====================================================
	 * All "singular" page hooks
	 * ====================================================
	 */

	if ( is_singular() ) {
		/**
		 * ====================================================
		 * Comments for all singular pages
		 * ====================================================
		 */

		// Add comments.
		add_action( 'suki/frontend/after_main', 'suki_comments', 20 );
			
		// Add comments title.
		add_action( 'suki/frontend/before_comments_list', 'suki_comments_title', 10 );
		
		// Add comments navigation.
		add_action( 'suki/frontend/before_comments_list', 'suki_comments_navigation', 20 );
		add_action( 'suki/frontend/after_comments_list', 'suki_comments_navigation', 10 );

		// Add "comments closed" notice.
		add_action( 'suki/frontend/after_comments_list', 'suki_comments_closed', 20 );

		/**
		 * ====================================================
		 * Static page
		 * ====================================================
		 */

		if ( is_page() ) {
			// Add content header to content section.
			if ( ! intval( suki_get_current_page_setting( 'hero' ) ) ) {
				// Only add if content header is not disabled.
				if ( ! intval( suki_get_current_page_setting( 'disable_content_header' ) ) ) {
					add_action( 'suki/frontend/page_content/header', 'suki_content_header', 10 );
				}
			}

			// Add thumbnail before or after content header.
			if ( ! intval( suki_get_current_page_setting( 'disable_thumbnail' ) ) && post_type_supports( 'page', 'thumbnail' ) ) {
				add_action( 'suki/frontend/page_content/' . suki_get_theme_mod( 'page_single_content_thumbnail_position' ) . '_header', 'suki_thumbnail', 10 );
			}
		}

		/**
		 * ====================================================
		 * Singular page (post and other post types)
		 * ====================================================
		 */

		else {
			// Add content header to content section.
			if ( ! intval( suki_get_current_page_setting( 'hero' ) ) ) {
				// Only add if content header is not disabled.
				if ( ! intval( suki_get_current_page_setting( 'disable_content_header' ) ) ) {
					add_action( 'suki/frontend/post_content/header', 'suki_content_header', 10 );
				}
			}

			// Add thumbnail before or after content header.
			if ( ! intval( suki_get_current_page_setting( 'disable_thumbnail' ) ) && post_type_supports( get_post_type(), 'thumbnail' ) ) {
				add_action( 'suki/frontend/post_content/' . suki_get_theme_mod( get_post_type() . '_single_content_thumbnail_position' ) . '_header', 'suki_thumbnail', 10 );
			}

			// Single post page.
			if ( is_singular( 'post' ) ) {
				// Add post footer.
				$priority = 10;
				foreach ( suki_get_theme_mod( 'post_single_content_footer', array() ) as $element ) {
					add_action( 'suki/frontend/post_content/footer', function() use( $element ) {
						// This action can't be modified or removed, because it uses anonymous function.
						suki_post_single_content_footer_element( $element );
					}, $priority );
	
					// Increment priority number.
					$priority = $priority + 10;
				}
	
				// Add author bio.
				if ( intval( suki_get_theme_mod( 'blog_single_author_bio' ) ) ) {
					add_action( 'suki/frontend/after_main', 'suki_post_author_bio', 10 );
				}
				
				// Add post navigation.
				if ( intval( suki_get_theme_mod( 'blog_single_navigation' ) ) ) {
					add_action( 'suki/frontend/after_main', 'suki_post_navigation', 15 );
				}
			}
		}
	}

}
add_action( 'wp', 'suki_template_hooks', 20 );

/**
 * ====================================================
 * Template rendering filters
 * ====================================================
 */

/**
 * Modify archive title based as configured in the Customizer.
 *
 * @param string $title
 * @param string $original_title
 * @param string $prefix
 * @return string
 */
function suki_custom_archive_title( $title, $original_title, $prefix ) {
	// Set default title for Blog page.
	if ( is_home() ) {
		// If blog page is also the front page, use tagline
		if ( is_front_page() ) {
			$title = get_bloginfo( 'description' );
		}
		// If blog page is set to static page, use the static page title.
		else {
			$title = get_the_title( get_option( 'page_for_posts' ) );
		}
	}

	// Fetch custom title that is configured from Customizer.
	if ( is_post_type_archive() || is_home() ) {
		$custom_title = suki_get_current_page_setting( 'title_text' );

		if ( ! empty( $custom_title ) ) {
			$post_type_obj = get_post_type_object( get_post_type() );

			$custom_title = str_replace( '{{post_type}}', $post_type_obj->labels->name, $custom_title );
		}
	}
	elseif ( is_category() || is_tag() || is_tax() ) {
		$custom_title = suki_get_current_page_setting( 'tax_title_text' );

		if ( ! empty( $custom_title ) ) {
			$term_obj = get_queried_object();
			$taxonomy_obj = get_taxonomy( $term_obj->taxonomy );

			$custom_title = str_replace( '{{taxonomy}}', $taxonomy_obj->labels->singular_name, $custom_title );
			$custom_title = str_replace( '{{term}}', $term_obj->name, $custom_title );
		}
	}

	// If custom title is detected, use it.
	if ( ! empty( $custom_title ) ) {
		$title = $custom_title;
	}

	return $title;
}
add_filter( 'get_the_archive_title', 'suki_custom_archive_title', 10, 3 );

/**
 * Modify archive title prefix.
 * 
 * @param string $prefix
 * @return string
 */
function suki_archive_title_prefix( $prefix ) {
	// Use gravatar as author archive title prefix.
	if ( is_author() ) {
		$prefix = '<div class="suki-author-archive-avatar">' . get_avatar( get_the_author_meta( 'ID' ), 120, '', get_the_author_meta( 'display_name' ) ) . '</div>';
	}

	// Modify title prefix for post type archive page.
	elseif ( is_post_type_archive() ) {
		$prefix = '';
	}

	return $prefix;
}
add_filter( 'get_the_archive_title_prefix', 'suki_archive_title_prefix' );

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
	// Read more
	if ( '' !== suki_get_theme_mod( 'entry_read_more_display' ) ) {
		// Add read more class
		$link = preg_replace( '/class="(.*?)"/', 'class="$1 ' . esc_attr( suki_get_theme_mod( 'entry_read_more_display' ) ) . '"', $link );

		// Change read more text
		$text = esc_html( suki_get_theme_mod( 'entry_read_more_text' ) );
		if ( empty( $text ) ) {
			$text = esc_html__( 'Read more', 'suki' );
		}
		$link = preg_replace( '/\(more&hellip;\)/', $text, $link );
	} else {
		$link = '';
	}

	return $link;
}
add_filter( 'the_content_more_link', 'suki_read_more' );

/**
 * Set blog post's excerpt words limit to unlimited, used on Content Header.
 * 
 * @param integer $length
 * @return integer
 */
function suki_excerpt_length_full( $length ) {
	return 999999; // Show full excerpt text.
}
// This filter will be triggered on `suki_excerpt` function.

/**
 * Set blog post's excerpt words limit according to the displayed post layout.
 * 
 * @param integer $length
 * @return integer
 */
function suki_excerpt_length( $length ) {
	// Search page
	if ( is_search() ) {
		return 30; // Fixed value for search results
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
	return ' &hellip;';
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
 * Add a class to post wrapper if the content is built using Gutenberg.
 *
 * @param array $classes
 * @return array
 */
function suki_post_class_is_gutenberg( $classes ) {
	if ( is_singular() && has_blocks() ) {
		$classes['gutenberg'] = 'suki-gutenberg-content';
	}

	return $classes;
}
add_filter( 'post_class', 'suki_post_class_is_gutenberg' );

/**
 * Add custom classes to the array of mobile vertical header classes.
 *
 * @param array $classes
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
 * Add custom classes to the array of hero section classes.
 *
 * @param array $classes
 * @return array
 */
function suki_hero_classes( $classes ) {
	$classes['container'] = esc_attr( 'suki-section-' . suki_get_current_page_setting( 'hero_container' ) );

	return $classes;
}
add_filter( 'suki/frontend/hero_classes', 'suki_hero_classes' );

/**
 * Add custom classes to the array of content header classes.
 *
 * @param array $classes
 * @return array
 */
function suki_content_header_classes( $classes ) {
	$classes['alignment'] = esc_attr( 'suki-text-align-' . suki_get_current_page_setting( 'content_header_alignment' ) );

	return $classes;
}
add_filter( 'suki/frontend/content_header_classes', 'suki_content_header_classes' );

/**
 * Add custom classes to the array of content section classes.
 *
 * @param array $classes
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
	if ( intval( suki_get_theme_mod( 'entry_thumbnail_wide' ) ) ) {
		$classes['alignwide'] = 'alignwide';
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
	if ( intval( suki_get_theme_mod( 'entry_grid_thumbnail_ignore_padding' ) ) ) {
		$classes['ignore_padding'] = 'suki-entry-thumbnail-ignore-padding';
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