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
 * [DEPRECATED]
 *
 * @deprecated 2.0.0 Replace `suki_build_google_fonts_embed_url` with `Suki_Google_Fonts::instance()->generate_embed_url`.
 *
 * @param array $google_fonts Array of Google Fonts families.
 */
function suki_build_google_fonts_embed_url( $google_fonts = array() ) {
	_deprecated_argument( __FUNCTION__, '2.0.0', 'Suki_Google_Fonts::instance()->generate_embed_url' );

	if ( class_exists( 'Suki_Google_Fonts' ) ) {
		return Suki_Google_Fonts::instance()->generate_embed_url( $google_fonts );
	}
}

/**
 * [DEPRECATED]
 *
 * @deprecated 2.0.0 Return array of selected Google Fonts list.
 */
function suki_get_google_fonts() {
	_deprecated_argument( __FUNCTION__, '2.0.0', 'Suki_Google_Fonts::instance()->get_fonts_list' );

	if ( class_exists( 'Suki_Google_Fonts' ) ) {
		return Suki_Google_Fonts::instance()->get_fonts_list();
	}
}

/**
 * [DEPRECATED]
 *
 * @deprecated 2.0.0 Replace `suki_get_google_fonts_subsets` with `Suki_Google_Fonts::instance()->get_subsets`.
 */
function suki_get_google_fonts_subsets() {
	_deprecated_argument( __FUNCTION__, '2.0.0', 'Suki_Google_Fonts::instance()->get_subsets' );

	if ( class_exists( 'Suki_Google_Fonts' ) ) {
		return Suki_Google_Fonts::instance()->get_subsets();
	}
}

/**
 * [DEPRECATED]
 *
 * @deprecated 2.0.0 Replace `suki_get_post_types_for_page_settings` with `suki_get_public_post_types`.
 *
 * @param string $context Context of returned values.
 */
function suki_get_post_types_for_page_settings( $context = 'all' ) {
	_deprecated_function( __FUNCTION__, '2.0.0', 'suki_get_public_post_types' );

	return suki_get_public_post_types( $context );
}

/**
 * [DEPRECATED]
 *
 * @deprecated 2.0.0 Replace `suki_main_header` with `suki_header_desktop`.
 */
function suki_main_header() {
	_deprecated_function( __FUNCTION__, '2.0.0', 'suki_header_desktop' );

	suki_header_desktop();
}

/**
 * [DEPRECATED]
 *
 * @deprecated 2.0.0 Replace `suki_main_header__top_bar` with `suki_header_desktop__top_bar`.
 */
function suki_main_header__top_bar() {
	_deprecated_function( __FUNCTION__, '2.0.0', 'suki_header_desktop__top_bar' );

	suki_header_desktop__top_bar();
}

/**
 * [DEPRECATED]
 *
 * @deprecated 2.0.0 Replace `suki_main_header__main_bar` with `suki_header_desktop__main_bar`.
 */
function suki_main_header__main_bar() {
	_deprecated_function( __FUNCTION__, '2.0.0', 'suki_header_desktop__main_bar' );

	suki_header_desktop__main_bar();
}

/**
 * [DEPRECATED]
 *
 * @deprecated 2.0.0 Replace `suki_main_header__bottom_bar` with `suki_header_desktop__bottom_bar`.
 */
function suki_main_header__bottom_bar() {
	_deprecated_function( __FUNCTION__, '2.0.0', 'suki_header_desktop__bottom_bar' );

	suki_header_desktop__bottom_bar();
}

/**
 * [DEPRECATED]
 *
 * @deprecated 2.0.0 Replace `suki_mobile_header` with `suki_header_mobile`.
 */
function suki_mobile_header() {
	_deprecated_function( __FUNCTION__, '2.0.0', 'suki_header_mobile' );

	suki_header_mobile();
}

/**
 * [DEPRECATED]
 *
 * @deprecated 2.0.0 Replace `suki_mobile_vertical_header` with `suki_header_mobile__popup`.
 */
function suki_mobile_vertical_header() {
	_deprecated_function( __FUNCTION__, '2.0.0', 'suki_header_mobile__popup' );

	suki_header_mobile__popup();
}

/**
 * [DEPRECATED]
 *
 * @deprecated 2.0.0 Replace `suki_default_mobile_logo` with `suki_default_logo_mobile`.
 */
function suki_default_mobile_logo() {
	_deprecated_function( __FUNCTION__, '2.0.0', 'suki_default_logo_mobile' );

	suki_default_logo_mobile();
}

/**
 * [DEPRECATED]
 *
 * @deprecated 2.0.0 Replace `suki_post_single_content_footer_element` with `suki_content_footer_element`.
 */
function suki_post_single_content_footer_element() {
	_deprecated_function( __FUNCTION__, '2.0.0', 'suki_content_footer_element' );

	suki_content_footer_element();
}

/**
 * [DEPRECATED]
 *
 * @deprecated 2.0.0 Remove `suki_post_tags`.
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
 * [DEPRECATED]
 *
 * @deprecated 2.0.0 Remove `suki_post_footer_meta`.
 */
function suki_post_footer_meta() {
	_deprecated_function( __FUNCTION__, '2.0.0' );

	suki_entry_meta( suki_get_current_page_setting( 'content_footer_meta' ) );
}

/**
 * [DEPRECATED]
 *
 * @deprecated 2.0.0 Remove `suki_post_header_meta`.
 */
function suki_post_header_meta() {
	_deprecated_function( __FUNCTION__, '2.0.0' );

	suki_entry_meta( suki_get_current_page_setting( 'content_header_meta' ) );
}

/**
 * [DEPRECATED]
 *
 * @deprecated 2.0.0 Replace `suki_thumbnail` with `suki_singular_thumbnail`.
 */
function suki_thumbnail() {
	_deprecated_function( __FUNCTION__, '2.0.0', 'suki_singular_thumbnail' );

	suki_singular_thumbnail();
}

/**
 * [DEPRECATED]
 *
 * @deprecated 2.0.0 Replace `suki_post_author_bio` with `suki_author_bio`.
 */
function suki_post_author_bio() {
	_deprecated_function( __FUNCTION__, '2.0.0', 'suki_author_bio' );

	suki_author_bio();
}

/**
 * [DEPRECATED]
 *
 * @deprecated 2.0.0 Replace `suki_post_navigation` with `suki_singular_navigation`.
 */
function suki_post_navigation() {
	_deprecated_function( __FUNCTION__, '2.0.0', 'suki_singular_navigation' );

	suki_singular_navigation();
}

/**
 * [DEPRECATED]
 *
 * @deprecated 2.0.0 Remove `suki_comments_title`.
 */
function suki_comments_title() {
	_deprecated_function( __FUNCTION__, '2.0.0' );
}

/**
 * [DEPRECATED]
 *
 * @deprecated 2.0.0 Remove `suki_comments_navigation`.
 */
function suki_comments_navigation() {
	_deprecated_function( __FUNCTION__, '2.0.0' );
}

/**
 * [DEPRECATED]
 *
 * @deprecated 2.0.0 Remove `suki_comments_closed`.
 */
function suki_comments_closed() {
	_deprecated_function( __FUNCTION__, '2.0.0' );
}

/**
 * [DEPRECATED]
 *
 * @deprecated 2.0.0 Remove `suki_entry_title`.
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
 * [DEPRECATED]
 *
 * @deprecated 2.0.0 Remove `suki_entry_small_title`.
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
 * [DEPRECATED]
 *
 * @deprecated 2.0.0 Remove `suki_entry_excerpt`.
 */
function suki_entry_excerpt() {
	_deprecated_function( __FUNCTION__, '2.0.0' );

	echo do_blocks( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		'
		<!-- wp:post-excerpt /-->
		'
	);
}

/**
 * [DEPRECATED]
 *
 * @deprecated 2.0.0 Replace `suki_breadcrumb` with `Suki_Breadcrumb::instance()->render_html`.
 *
 * @param boolean $echo Render or return.
 */
function suki_breadcrumb( $echo = true ) {
	_deprecated_function( __FUNCTION__, '2.0.0', 'Suki_Breadcrumb::instance()->render_html' );

	if ( boolval( $echo ) ) {
		Suki_Breadcrumb::instance()->render_html();
	} else {
		Suki_Breadcrumb::instance()->get_html();
	}
}

/**
 * [DEPRECATED]
 *
 * @deprecated 2.0.0 Replace `suki_breadcrumb_native` with `Suki_Breadcrumb::instance()->generate_html__builtin`.
 *
 * @param boolean $echo Render or return.
 */
function suki_breadcrumb_native( $echo = true ) {
	_deprecated_function( __FUNCTION__, '2.0.0', 'Suki_Breadcrumb::instance()->generate_html__builtin' );

	if ( boolval( $echo ) ) {
		echo Suki_Breadcrumb::instance()->generate_html__builtin(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	} else {
		Suki_Breadcrumb::instance()->generate_html__builtin();
	}
}
