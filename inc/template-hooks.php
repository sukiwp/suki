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
	 * @see suki_footer_widgets()
	 * @see suki_footer_bottom()
	 */
	add_action( 'suki/frontend/footer', 'suki_footer_widgets', 10 );
	add_action( 'suki/frontend/footer', 'suki_footer_bottom', 10 );

	/**
	 * ====================================================
	 * Static page hooks
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
	 * Content default hooks
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

	if ( is_home() || is_archive() || is_search() || is_404() ) {
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
	 * Single post hooks
	 * ====================================================
	 */

	if ( is_single() ) {
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

	/**
	 * ====================================================
	 * Single page hooks
	 * ====================================================
	 */

	if ( is_page() ) {
		/**
		 * suki/frontend/after_main hook
		 * 
		 * @see suki_entry_comments()
		 */
		add_action( 'suki/frontend/after_main', 'suki_entry_comments', 20 );
	}
}
add_action( 'template_redirect', 'suki_template_hooks' );