<?php
/**
 * Template actions declarations.
 *
 * @package Suki
 * @since 2.0.0 Renamed from template-functions.php, move filters declaration into template-filters.php
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

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

	// Add scroll to top button.
	add_action( 'suki/frontend/after_canvas', 'suki_scroll_to_top', 10 );

	/**
	 * ====================================================
	 * Header hooks
	 * ====================================================
	 */

	// Add main header.
	add_action( 'suki/frontend/header', 'suki_header_desktop', 10 );

	// Add mobile header.
	add_action( 'suki/frontend/header', 'suki_header_mobile', 10 );

	// Add default logo.
	add_action( 'suki/frontend/logo', 'suki_default_logo', 10 );

	// Add default mobile logo.
	add_action( 'suki/frontend/mobile_logo', 'suki_default_logo_mobile', 10 );

	/**
	 * ====================================================
	 * Footer hooks
	 * ====================================================
	 */

	// Add main footer.
	add_action( 'suki/frontend/footer', 'suki_main_footer', 10 );

	/**
	 * ====================================================
	 * Hero hooks
	 * ====================================================
	 */

	// If content header is not disabled.
	if ( ! boolval( suki_get_current_page_setting( 'disable_content_header' ) ) ) {
		// If hero section is active.
		if ( boolval( suki_get_current_page_setting( 'hero' ) ) ) {
			// Don't add if it's blog posts page and "Show content header on blog page" option is disabled.
			if ( ! is_home() || boolval( suki_get_theme_mod( 'post_archive_home_content_header' ) ) ) {
				// Add content header to Hero section.
				add_action( 'suki/frontend/hero', 'suki_content_header', 10 );
			}
		}
	}

	/**
	 * ====================================================
	 * All archive page hooks
	 * ====================================================
	 */

	if ( is_archive() || is_home() || is_search() ) {
		// If content header is not disabled.
		if ( ! boolval( suki_get_current_page_setting( 'disable_content_header' ) ) ) {
			// If hero section is not active.
			if ( ! boolval( suki_get_current_page_setting( 'hero' ) ) ) {
				// Add content header before the loop.
				// Don't add if it's blog posts page and "Show content header on blog page" option is disabled.
				if ( ! is_home() || boolval( suki_get_theme_mod( 'post_archive_home_content_header' ) ) ) {
					add_action( 'suki/frontend/before_main', 'suki_content_header', 10 );
				}
			}
		}

		// Add navigation after the loop.
		add_action( 'suki/frontend/after_main', 'suki_archive_navigation', 10 );
	}

	/**
	 * ====================================================
	 * All "singular" page hooks (all post types)
	 * ====================================================
	 */

	if ( is_singular() ) {
		// If content header is not disabled.
		if ( ! boolval( suki_get_current_page_setting( 'disable_content_header' ) ) ) {
			// If hero section is not active.
			if ( ! boolval( suki_get_current_page_setting( 'hero' ) ) ) {
				// Add content header element.
				foreach ( suki_get_current_page_setting( 'content_header', array() ) as $element ) {
					add_action(
						'suki/frontend/' . get_post_type() . '_content/header',
						function() use ( $element ) {
							// This action can't be modified or removed, because it uses anonymous function.
							suki_content_header_element( $element );
						},
						10
					);
				}
			}
		}

		// Add content footer elements.
		foreach ( suki_get_current_page_setting( 'content_footer', array() ) as $element ) {
			add_action(
				'suki/frontend/' . get_post_type() . '_content/footer',
				function() use ( $element ) {
					// This action can't be modified or removed, because it uses anonymous function.
					suki_content_footer_element( $element );
				},
				10
			);
		}

		// Add thumbnail before or after content header.
		if ( ! boolval( suki_get_current_page_setting( 'disable_thumbnail' ) ) && post_type_supports( get_post_type(), 'thumbnail' ) ) {
			add_action( 'suki/frontend/' . get_post_type() . '_content/' . suki_get_current_page_setting( 'content_thumbnail_position' ) . '_header', 'suki_singular_thumbnail', 10 );
		}

		// Post type: post.
		if ( is_singular( 'post' ) ) {
			// Add author bio.
			if ( boolval( suki_get_theme_mod( 'blog_single_author_bio' ) ) ) {
				add_action( 'suki/frontend/after_main', 'suki_author_bio', 10 );
			}

			// Add post navigation.
			if ( boolval( suki_get_theme_mod( 'blog_single_navigation' ) ) ) {
				add_action( 'suki/frontend/after_main', 'suki_singular_navigation', 15 );
			}

			// Add comments.
			add_action( 'suki/frontend/after_main', 'suki_comments', 20 );
		}
	}

	/**
	 * ====================================================
	 * Post Layout: Default
	 * ====================================================
	 */

	// Add thumbnail before or after content header.
	add_action( 'suki/frontend/entry/' . suki_get_theme_mod( 'entry_thumbnail_position' ) . '_header', 'suki_entry_thumbnail', 10 );

	// Add entry header elements.
	foreach ( suki_get_theme_mod( 'entry_header', array() ) as $element ) {
		add_action(
			'suki/frontend/entry/header',
			function() use ( $element ) {
				// This action can't be modified or removed, because it uses anonymous function.
				suki_entry_header_footer_element( $element );
			},
			10
		);
	}

	// Add entry footer elements.
	foreach ( suki_get_theme_mod( 'entry_footer', array() ) as $element ) {
		add_action(
			'suki/frontend/entry/footer',
			function() use ( $element ) {
				// This action can't be modified or removed, because it uses anonymous function.
				suki_entry_header_footer_element( $element );
			},
			10
		);
	}

	/**
	 * ====================================================
	 * Post Layout: Grid
	 * ====================================================
	 */

	// Add thumbnail before or after content header.
	add_action( 'suki/frontend/entry_grid/' . suki_get_theme_mod( 'entry_grid_thumbnail_position' ) . '_header', 'suki_entry_grid_thumbnail', 10 );

	// Add entry grid header elements.
	foreach ( suki_get_theme_mod( 'entry_grid_header', array() ) as $element ) {
		add_action(
			'suki/frontend/entry_grid/header',
			function() use ( $element ) {
				// This action can't be modified or removed, because it uses anonymous function.
				suki_entry_header_footer_element( $element, 'grid' );
			},
			10
		);
	}

	// Add entry grid footer elements.
	foreach ( suki_get_theme_mod( 'entry_grid_footer', array() ) as $element ) {
		add_action(
			'suki/frontend/entry_grid/footer',
			function() use ( $element ) {
				// This action can't be modified or removed, because it uses anonymous function.
				suki_entry_header_footer_element( $element, 'grid' );
			},
			10
		);
	}

	/**
	 * ====================================================
	 * Search Results Item
	 * ====================================================
	 */

	if ( is_search() ) {
		// Add title to search result entry header.
		add_action( 'suki/frontend/entry_search/header', 'suki_entry_small_title', 10 );
	}
}
add_action( 'wp', 'suki_template_hooks', 20 );
