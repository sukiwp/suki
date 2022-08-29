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

	// Add destop header.
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

	// Add footer widgets.
	add_action( 'suki/frontend/footer', 'suki_footer_widgets', 10 );

	// Add footer bottom.
	add_action( 'suki/frontend/footer', 'suki_footer_bottom', 10 );

	/**
	 * ====================================================
	 * Hero hooks
	 * ====================================================
	 */

	// Add content header to hero section.
	if (
		boolval( suki_get_current_page_setting( 'hero' ) ) && // Hero section is active.
		! boolval( suki_get_current_page_setting( 'disable_content_header' ) ) && // Content header is not disabled.
		( ! is_home() || boolval( suki_get_theme_mod( 'post_archive_home_content_header' ) ) ) && // Not blog posts home, or content header is allowed in blog posts home.
		0 < count( suki_get_current_page_setting( 'content_header', array() ) ) // Content header has at least 1 element.
	) {
		// Add content header to Hero section.
		add_action( 'suki/frontend/hero', 'suki_content_header', 10 );
	}

	/**
	 * ====================================================
	 * All archive page hooks
	 * ====================================================
	 */

	if ( is_archive() || is_home() || is_search() ) {
		// Add content header to main content.
		if (
			! boolval( suki_get_current_page_setting( 'hero' ) ) && // Hero section is not active.
			! boolval( suki_get_current_page_setting( 'disable_content_header' ) ) && // Content header is not disabled.
			( ! is_home() || boolval( suki_get_theme_mod( 'post_archive_home_content_header' ) ) ) && // Not blog posts home, or content header is allowed in blog posts home.
			0 < count( suki_get_current_page_setting( 'content_header', array() ) ) // Content header has at least 1 element.
		) {
			add_action( 'suki/frontend/before_main', 'suki_content_header', 10 );
		}
	}

	/**
	 * ====================================================
	 * All "singular" page hooks (all post types)
	 * ====================================================
	 */

	if ( is_singular() ) {
		// Add content header to main content.
		if (
			! boolval( suki_get_current_page_setting( 'hero' ) ) && // Hero section is not active.
			! boolval( suki_get_current_page_setting( 'disable_content_header' ) ) && // Content header is not disabled.
			( ! is_home() || boolval( suki_get_theme_mod( 'post_archive_home_content_header' ) ) ) && // Not blog posts home, or content header is allowed in blog posts home.
			0 < count( suki_get_current_page_setting( 'content_header', array() ) ) // Content header has at least 1 element.
		) {
			add_action( 'suki/frontend/' . get_post_type() . '_content/header', 'suki_content_header', 10 );
		}

		// Add content footer elements.
		if ( 0 < count( suki_get_current_page_setting( 'content_header', array() ) ) ) { // Content footer has at least 1 element.
			add_action( 'suki/frontend/' . get_post_type() . '_content/footer', 'suki_content_footer', 10 );
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
}
add_action( 'template_redirect', 'suki_template_hooks', 20 );
