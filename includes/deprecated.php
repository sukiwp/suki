<?php
/**
 * Deprecated functions and hooks.
 *
 * @package Suki
 *
 * @since 2.0.0
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ====================================================
 * v2.0.0
 * ====================================================
 */

/**
 * Rename `suki_main_header` to `suki_header_desktop`.
 */
function suki_main_header() {
	_deprecated_function( __FUNCTION__, '2.0.0', 'suki_header_desktop' );

	suki_header_desktop();
}

/**
 * Rename `suki_main_header__top_bar` to `suki_header_desktop__top_bar`.
 */
function suki_main_header__top_bar() {
	_deprecated_function( __FUNCTION__, '2.0.0', 'suki_header_desktop__top_bar' );

	suki_header_desktop__top_bar();
}

/**
 * Rename `suki_main_header__main_bar` to `suki_header_desktop__main_bar`.
 */
function suki_main_header__main_bar() {
	_deprecated_function( __FUNCTION__, '2.0.0', 'suki_header_desktop__main_bar' );

	suki_header_desktop__main_bar();
}

/**
 * Rename `suki_main_header__bottom_bar` to `suki_header_desktop__bottom_bar`.
 */
function suki_main_header__bottom_bar() {
	_deprecated_function( __FUNCTION__, '2.0.0', 'suki_header_desktop__bottom_bar' );

	suki_header_desktop__bottom_bar();
}

/**
 * Rename `suki_mobile_header` to `suki_header_mobile`.
 */
function suki_mobile_header() {
	_deprecated_function( __FUNCTION__, '2.0.0', 'suki_header_mobile' );

	suki_header_mobile();
}

/**
 * Rename `suki_mobile_vertical_header` to `suki_header_mobile__popup`.
 */
function suki_mobile_vertical_header() {
	_deprecated_function( __FUNCTION__, '2.0.0', 'suki_header_mobile__popup' );

	suki_header_mobile__popup();
}

/**
 * Rename `suki_default_mobile_logo` to `suki_default_logo_mobile`.
 */
function suki_default_mobile_logo() {
	_deprecated_function( __FUNCTION__, '2.0.0', 'suki_default_logo_mobile' );

	suki_default_logo_mobile();
}

/**
 * Rename `suki_post_single_content_footer_element` to `suki_content_footer_element`.
 */
function suki_post_single_content_footer_element() {
	_deprecated_function( __FUNCTION__, '2.0.0', 'suki_content_footer_element' );

	suki_content_footer_element();
}

/**
 * Remove `suki_post_tags`.
 */
function suki_post_tags() {
	_deprecated_function( __FUNCTION__, '2.0.0' );

	echo do_blocks( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		'
		<!-- wp:post-terms {
			"term":"post_tag"
		} /-->
		'
	);
}

/**
 * Remove `suki_post_footer_meta`.
 */
function suki_post_footer_meta() {
	_deprecated_function( __FUNCTION__, '2.0.0' );

	suki_entry_meta( suki_get_current_page_setting( 'content_footer_meta' ) );
}

/**
 * Remove `suki_post_header_meta`.
 */
function suki_post_header_meta() {
	_deprecated_function( __FUNCTION__, '2.0.0' );

	suki_entry_meta( suki_get_current_page_setting( 'content_header_meta' ) );
}

/**
 * Rename `suki_thumbnail` to `suki_singular_thumbnail`.
 */
function suki_thumbnail() {
	_deprecated_function( __FUNCTION__, '2.0.0', 'suki_singular_thumbnail' );

	suki_singular_thumbnail();
}

/**
 * Rename `suki_post_author_bio` to `suki_author_bio`.
 */
function suki_post_author_bio() {
	_deprecated_function( __FUNCTION__, '2.0.0', 'suki_author_bio' );

	suki_author_bio();
}

/**
 * Rename `suki_post_navigation` to `suki_singular_navigation`.
 */
function suki_post_navigation() {
	_deprecated_function( __FUNCTION__, '2.0.0', 'suki_singular_navigation' );

	suki_singular_navigation();
}

/**
 * Remove `suki_comments_title`.
 */
function suki_comments_title() {
	_deprecated_function( __FUNCTION__, '2.0.0' );
}

/**
 * Remove `suki_comments_navigation`.
 */
function suki_comments_navigation() {
	_deprecated_function( __FUNCTION__, '2.0.0' );
}

/**
 * Remove `suki_comments_closed`.
 */
function suki_comments_closed() {
	_deprecated_function( __FUNCTION__, '2.0.0' );
}

/**
 * Remove `suki_entry_title`.
 */
function suki_entry_title() {
	_deprecated_function( __FUNCTION__, '2.0.0' );

	echo do_blocks( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		'
		<!-- wp:post-title {
			"className":"entry-title suki-title"
		} /-->
		'
	);
}

/**
 * Remove `suki_entry_small_title`.
 */
function suki_entry_small_title() {
	_deprecated_function( __FUNCTION__, '2.0.0' );

	echo do_blocks( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		'
		<!-- wp:post-title {
			"className":"entry-title suki-small-title"
		} /-->
		'
	);
}

/**
 * Remove `suki_entry_excerpt`.
 */
function suki_entry_excerpt() {
	_deprecated_function( __FUNCTION__, '2.0.0' );

	echo do_blocks( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		'
		<!-- wp:post-excerpt /-->
		'
	);
}


