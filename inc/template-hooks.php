<?php
/**
 * Template hooks linked to template functions on 'inc/template-tags.php' file.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

function suki_template_hooks() {
	/**
	 * ====================================================
	 * Global hooks
	 * ====================================================
	 */

	/**
	 * suki_before_canvas hook
	 *
	 * @see suki_mobile_vertical_header()
	 * @see suki_popup_background()
	 */
	add_action( 'suki_before_canvas', 'suki_mobile_vertical_header', 10 );
	add_action( 'suki_before_canvas', 'suki_popup_background', 99 );

	/**
	 * suki_header hook
	 *
	 * @see suki_header()
	 */
	add_action( 'suki_header', 'suki_header', 10 );

	/**
	 * suki_footer hook
	 *
	 * @see suki_footer()
	 */
	add_action( 'suki_footer', 'suki_footer', 10 );

	/**
	 * ====================================================
	 * Static page hooks
	 * ====================================================
	 */

	/**
	 * suki_before_static_page_header hook
	 * 
	 * @see suki_entry_featured_media()
	 */
	if ( 'before-entry-header' === suki_get_theme_mod( 'entry_featured_media_position' ) ) {
		add_action( 'suki_before_static_page_header', 'suki_entry_featured_media', 10 );
	}

	/**
	 * suki_static_page_header hook
	 *
	 * @see suki_entry_title()
	 */
	add_action( 'suki_static_page_header', 'suki_entry_title', 10 );

	/**
	 * suki_after_static_page_header hook
	 * 
	 * @see suki_entry_featured_media()
	 */
	if ( 'after-entry-header' === suki_get_theme_mod( 'entry_featured_media_position' ) ) {
		add_action( 'suki_after_static_page_header', 'suki_entry_featured_media', 10 );
	}

	/**
	 * ====================================================
	 * Content default hooks
	 * ====================================================
	 */

	/**
	 * suki_before_entry_header hook
	 * 
	 * @see suki_entry_featured_media()
	 */
	if ( 'before-entry-header' === suki_get_theme_mod( 'entry_featured_media_position' ) ) {
		add_action( 'suki_before_entry_header', 'suki_entry_featured_media', 10 );
	}

	/**
	 * suki_entry_header hook
	 * 
	 * @see suki_entry_header_meta()
	 * @see suki_entry_title()
	 */
	$priority = 10;
	foreach ( suki_get_theme_mod( 'entry_header' ) as $element ) {
		$function = 'suki_entry_' . str_replace( '-', '_', $element );

		// If function exists, attach to hook.
		if ( function_exists( $function ) ) {
			add_action( 'suki_entry_header', $function, $priority );
		}

		// Increment priority number.
		$priority = $priority + 5;
	}

	/**
	 * suki_after_entry_header hook
	 * 
	 * @see suki_entry_featured_media()
	 */
	if ( 'after-entry-header' === suki_get_theme_mod( 'entry_featured_media_position' ) ) {
		add_action( 'suki_after_entry_header', 'suki_entry_featured_media', 10 );
	}

	/**
	 * suki_entry_footer hook
	 * 
	 * @see suki_entry_footer_meta()
	 */
	add_action( 'suki_entry_footer', 'suki_entry_footer_meta', 10 );

	/**
	 * ====================================================
	 * Content grid hooks
	 * ====================================================
	 */

	/**
	 * suki_before_entry_grid_header hook
	 * 
	 * @see suki_entry_featured_media()
	 */
	if ( 'before-entry-header' === suki_get_theme_mod( 'entry_grid_featured_media_position' ) ) {
		add_action( 'suki_before_entry_grid_header', 'suki_entry_grid_featured_media', 10 );
	}

	/**
	 * suki_entry_grid_header hook
	 * 
	 * @see suki_entry_grid_header_meta()
	 * @see suki_entry_grid_title()
	 */
	$priority = 10;
	foreach ( suki_get_theme_mod( 'entry_grid_header' ) as $element ) {
		$function = 'suki_entry_grid_' . str_replace( '-', '_', $element );

		// If function exists, attach to hook.
		if ( function_exists( $function ) ) {
			add_action( 'suki_entry_grid_header', $function, $priority );
		}

		// Increment priority number.
		$priority = $priority + 5;
	}

	/**
	 * suki_after_entry_grid_header hook
	 * 
	 * @see suki_entry_featured_media()
	 */
	if ( 'after-entry-header' === suki_get_theme_mod( 'entry_grid_featured_media_position' ) ) {
		add_action( 'suki_after_entry_grid_header', 'suki_entry_grid_featured_media', 10 );
	}

	/**
	 * suki_entry_grid_footer hook
	 * 
	 * @see suki_entry_grid_footer_meta()
	 */
	add_action( 'suki_entry_grid_footer', 'suki_entry_grid_footer_meta', 10 );

	/**
	 * ====================================================
	 * Comments area hooks
	 * ====================================================
	 */
	
	/**
	 * suki_before_comments_list hook
	 * 
	 * @see suki_comments_title()
	 * @see suki_comments_navigation()
	 */
	add_action( 'suki_before_comments_list', 'suki_comments_title', 10 );
	add_action( 'suki_before_comments_list', 'suki_comments_navigation', 20 );

	/**
	 * suki_after_comments_list hook
	 * 
	 * @see suki_comments_navigation()
	 * @see suki_comments_closed()
	 */
	add_action( 'suki_after_comments_list', 'suki_comments_navigation', 10 );
	add_action( 'suki_after_comments_list', 'suki_comments_closed', 20 );

	/**
	 * ====================================================
	 * Archive hooks
	 * ====================================================
	 */

	if ( is_archive() ) {
		/**
		 * suki_before_main hook
		 * 
		 * @see suki_archive_page_header()
		 */
		add_action( 'suki_before_main', 'suki_archive_page_header', 10 );

		/**
		 * suki_after_main hook
		 * 
		 * @see suki_loop_navigation()
		 */
		add_action( 'suki_after_main', 'suki_loop_navigation', 10 );
	}

	/**
	 * ====================================================
	 * Posts home hooks
	 * ====================================================
	 */

	if ( is_home() ) {
		/**
		 * suki_after_main hook
		 * 
		 * @see suki_loop_navigation()
		 */
		add_action( 'suki_after_main', 'suki_loop_navigation', 10 );
	}

	if ( is_home() && ! is_front_page() ) {
		/**
		 * suki_before_main hook
		 * 
		 * @see suki_home_page_header()
		 */
		add_action( 'suki_before_main', 'suki_home_page_header', 10 );
	}

	/**
	 * ====================================================
	 * Single post hooks
	 * ====================================================
	 */

	if ( is_single() ) {
		/**
		 * suki_before_entry_footer hook
		 * 
		 * @see suki_entry_tags()
		 */
		add_action( 'suki_before_entry_footer', 'suki_entry_tags', 10 );
		
		/**
		 * suki_after_main hook
		 * 
		 * @see suki_single_post_author_bio()
		 * @see suki_single_post_navigation()
		 * @see suki_entry_comments()
		 */

		if ( suki_get_theme_mod( 'blog_single_author_bio' ) ) {
			add_action( 'suki_after_main', 'suki_single_post_author_bio', 10 );
		}

		if ( suki_get_theme_mod( 'blog_single_navigation' ) ) {
			add_action( 'suki_after_main', 'suki_single_post_navigation', 15 );
		}

		add_action( 'suki_after_main', 'suki_entry_comments', 20 );
	}

	/**
	 * ====================================================
	 * Single page hooks
	 * ====================================================
	 */

	if ( is_page() ) {
		/**
		 * suki_after_main hook
		 * 
		 * @see suki_entry_comments()
		 */
		add_action( 'suki_after_main', 'suki_entry_comments', 20 );
	}

	/**
	 * ====================================================
	 * Search page hooks
	 * ====================================================
	 */

	if ( is_search() ) {
		/**
		 * suki_before_main hook
		 * 
		 * @see suki_search_page_header()
		 */
		add_action( 'suki_before_main', 'suki_search_page_header', 10 );

		/**
		 * suki_after_main hook
		 * 
		 * @see suki_loop_navigation()
		 */
		add_action( 'suki_after_main', 'suki_loop_navigation', 10 );
	}

	/**
	 * ====================================================
	 * 404 page hooks
	 * ====================================================
	 */

	if ( is_404() ) {
		/**
		 * suki_before_main hook
		 * 
		 * @see suki_404_page_header()
		 */
		add_action( 'suki_before_main', 'suki_404_page_header', 10 );
	}
}
add_action( 'template_redirect', 'suki_template_hooks' );