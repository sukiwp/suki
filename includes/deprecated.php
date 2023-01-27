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
 * @deprecated 2.0.0 Use the native `get_template_part` instead, this will remove the `suki/frontend/template_dirs` filter as well.
 *
 * Developer can override the template in Child Theme.
 * Developer can also override the template in a custom plugin using `get_template_part` action and call `locate_template` function,
 *
 * @param string  $slug      Template part slug (not "wp_template_part" post type).
 * @param string  $name      Template variation name.
 * @param array   $variables Array of variables that will be passed to the template part.
 * @param boolean $echo      Print or return the HTML tags.
 */
function suki_get_template_part( $slug, $name = null, $variables = array(), $echo = true ) {
	_deprecated_function( __FUNCTION__, '2.0.0' );

	ob_start();
	get_template_part( $slug, $name, $variables );
	$html = ob_get_clean();

	if ( boolval( $echo ) ) {
		echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	} else {
		return $html;
	}
}

/**
 * [DEPRECATED]
 *
 * @deprecated 2.0.0 Use the new `suki_get_ui_icon_types` for theme icons and `suki_get_social_media_types` for social icons instead.
 *
 * Return array of icons choices.
 *
 * @return array
 */
function suki_get_all_icons() {
	_deprecated_function( __FUNCTION__, '2.0.0' );

	/**
	 * Filter: suki/dataset/icons
	 *
	 * @param array $icons Icons array.
	 */
	$icons = array(
		'theme_icons'  => suki_get_ui_icon_types(),
		'social_icons' => suki_get_social_media_types( true ),
	);

	return $icons;
}

/**
 * [DEPRECATED]
 *
 * @deprecated 2.0.0 Use the new `suki_icon_svg` instead.
 *
 * Print / return inline SVG HTML tags.
 *
 * @param string  $svg_file SVG file path.
 * @param boolean $echo     Render or return.
 * @return string
 */
function suki_inline_svg( $svg_file, $echo = true ) {
	_deprecated_function( __FUNCTION__, '2.0.0', 'suki_icon_svg' );

	// Return empty if no SVG file path is provided.
	if ( empty( $svg_file ) ) {
		return;
	}

	// Get SVG markup.
	$html = file_get_contents( $svg_file ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents

	// Remove XML encoding tag.
	// This should not be printed on inline SVG.
	$html = preg_replace( '/<\?xml(?:.*?)\?>/', '', $html );

	// Add width attribute if not found in the SVG markup.
	// Width value is extracted from viewBox attribute.
	if ( ! preg_match( '/<svg.*?width.*?>/', $html ) ) {
		if ( preg_match( '/<svg.*?viewBox="0 0 ([0-9.]+) ([0-9.]+)".*?>/', $html, $matches ) ) {
			$html = preg_replace( '/<svg (.*?)>/', '<svg $1 width="' . $matches[1] . '" height="' . $matches[2] . '">', $html );
		}
	}

	// Remove <title> from SVG markup.
	// Site name would be added as a screen reader text to represent the logo.
	$html = preg_replace( '/<title>.*?<\/title>/', '', $html );

	// Render or return.
	if ( boolval( $echo ) ) {
		echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	} else {
		return $html;
	}
}

/**
 * [DEPRECATED]
 *
 * @deprecated 2.0.0 Header builder now uses `suki/dataset/header_builder/elements` and `suki/dataset/header_builder/areas` filter to populate elements.
 *
 * @return array
 */
function suki_get_header_builder_configurations() {
	_deprecated_function( __FUNCTION__, '2.0.0' );

	/**
	 * [DEPRECATED]
	 *
	 * Filter: suki/dataset/header_builder_configurations
	 *
	 * @deprecated 2.0.0
	 *
	 * @param array $config Configurations array.
	 */
	$config = apply_filters_deprecated(
		'suki/dataset/header_builder_configurations',
		array(
			array(
				'locations'   => array(
					'top_left'      => esc_html__( 'Top - Left', 'suki' ),
					'top_center'    => esc_html__( 'Top - Center', 'suki' ),
					'top_right'     => esc_html__( 'Top - Right', 'suki' ),
					'main_left'     => esc_html__( 'Main - Left', 'suki' ),
					'main_center'   => esc_html__( 'Main - Center', 'suki' ),
					'main_right'    => esc_html__( 'Main - Right', 'suki' ),
					'bottom_left'   => esc_html__( 'Bottom - Left', 'suki' ),
					'bottom_center' => esc_html__( 'Bottom - Center', 'suki' ),
					'bottom_right'  => esc_html__( 'Bottom - Right', 'suki' ),
				),
				'choices'     => array(
					'logo'            => '<span class="dashicons dashicons-admin-home"></span>' . esc_html__( 'Logo', 'suki' ),
					/* translators: %s: instance number. */
					'menu-1'          => '<span class="dashicons dashicons-admin-links"></span>' . sprintf( esc_html__( 'Menu %s', 'suki' ), 1 ),
					/* translators: %s: instance number. */
					'html-1'          => '<span class="dashicons dashicons-editor-code"></span>' . sprintf( esc_html__( 'HTML %s', 'suki' ), 1 ),
					'search-bar'      => '<span class="dashicons dashicons-search"></span>' . esc_html__( 'Search Bar', 'suki' ),
					'search-dropdown' => '<span class="dashicons dashicons-search"></span>' . esc_html__( 'Search Dropdown', 'suki' ),
					'social'          => '<span class="dashicons dashicons-twitter"></span>' . esc_html__( 'Social', 'suki' ),
				),
				'limitations' => array(),
			),
		),
		'2.0.0'
	);

	ksort( $config['choices'] );

	return $config;
}

/**
 * [DEPRECATED]
 *
 * @deprecated 2.0.0 Header builder now uses `suki/dataset/header_mobile_builder/elements` and `suki/dataset/header_mobile_builder/areas` filter to populate elements.
 *
 * @return array
 */
function suki_get_header_mobile_builder_configurations() {
	_deprecated_function( __FUNCTION__, '2.0.0' );

	/**
	 * [DEPRECATED]
	 *
	 * Filter: suki/dataset/header_mobile_builder_configurations
	 *
	 * @deprecated 2.0.0
	 *
	 * @param array $config Configurations array.
	 */
	$config = apply_filters_deprecated(
		'suki/dataset/header_mobile_builder_configurations',
		array(
			array(
				'locations'   => array(
					'main_left'    => esc_html__( 'Mobile - Left', 'suki' ),
					'main_center'  => esc_html__( 'Mobile - Center', 'suki' ),
					'main_right'   => esc_html__( 'Mobile - Right', 'suki' ),
					'vertical_top' => esc_html__( 'Mobile - Popup', 'suki' ),
				),
				'choices'     => array(
					'mobile-logo'            => '<span class="dashicons dashicons-admin-home"></span>' . esc_html__( 'Mobile Logo', 'suki' ),
					'mobile-menu'            => '<span class="dashicons dashicons-admin-links"></span>' . esc_html__( 'Mobile Menu', 'suki' ),
					/* translators: %s: instance number. */
					'html-1'                 => '<span class="dashicons dashicons-editor-code"></span>' . sprintf( esc_html__( 'HTML %s', 'suki' ), 1 ),
					'search-bar'             => '<span class="dashicons dashicons-search"></span>' . esc_html__( 'Search Bar', 'suki' ),
					'search-dropdown'        => '<span class="dashicons dashicons-search"></span>' . esc_html__( 'Search Icon', 'suki' ),
					'social'                 => '<span class="dashicons dashicons-twitter"></span>' . esc_html__( 'Social', 'suki' ),
					'mobile-vertical-toggle' => '<span class="dashicons dashicons-menu"></span>' . esc_html__( 'Toggle', 'suki' ),
				),
				'limitations' => array(
					'mobile-logo'            => array( 'vertical_top' ),
					'mobile-menu'            => array( 'main_left', 'main_center', 'main_right' ),
					'search-bar'             => array( 'main_left', 'main_center', 'main_right' ),
					'search-dropdown'        => array( 'vertical_top' ),
					'mobile-vertical-toggle' => array( 'vertical_top' ),
				),
			),
		),
		'2.0.0'
	);

	ksort( $config['choices'] );

	return $config;
}

/**
 * [DEPRECATED]
 *
 * @deprecated 2.0.0 Footer builder now uses `suki/dataset/footer_builder/elements` and `suki/dataset/footer_builder/areas` filter to populate elements.
 *
 * @return array
 */
function suki_get_footer_builder_configurations() {
	_deprecated_function( __FUNCTION__, '2.0.0' );

	/**
	 * [DEPRECATED]
	 *
	 * Filter: suki/dataset/footer_builder_configurations
	 *
	 * @deprecated 2.0.0
	 *
	 * @param array $config Configurations array.
	 */
	$config = apply_filters_deprecated(
		'suki/dataset/footer_builder_configurations',
		array(
			array(
				'locations' => array(
					'bottom_left'   => is_rtl() ? esc_html__( 'Right', 'suki' ) : esc_html__( 'Left', 'suki' ),
					'bottom_center' => esc_html__( 'Center', 'suki' ),
					'bottom_right'  => is_rtl() ? esc_html__( 'Left', 'suki' ) : esc_html__( 'Right', 'suki' ),
				),
				'choices'   => array(
					'copyright' => '<span class="dashicons dashicons-editor-code"></span>' . esc_html__( 'Copyright', 'suki' ),
					/* translators: %s: instance number. */
					'menu-1'    => '<span class="dashicons dashicons-admin-links"></span>' . sprintf( esc_html__( 'Footer Menu %s', 'suki' ), 1 ),
					/* translators: %s: instance number. */
					'html-1'    => '<span class="dashicons dashicons-editor-code"></span>' . sprintf( esc_html__( 'HTML %s', 'suki' ), 1 ),
					'social'    => '<span class="dashicons dashicons-twitter"></span>' . esc_html__( 'Social', 'suki' ),
				),
			),
		),
		'2.0.0',
	);

	ksort( $config['choices'] );

	return $config;
}

/**
 * [DEPRECATED]
 *
 * @deprecated 2.0.0 Default colors in PHP are now available using CSS custom properties names, e.g. var(--color-palette-x).
 *
 * @return array
 */
function suki_get_default_colors() {
	_deprecated_function( __FUNCTION__, '2.0.0' );

	/**
	 * [DEPRECATED]
	 *
	 * Filter: suki/dataset/default_colors
	 *
	 * @deprecated 2.0.0
	 *
	 * @param array $colors Colors array.
	 */
	$colors = apply_filters_deprecated(
		'suki/dataset/default_colors',
		array(
			array(
				'transparent' => 'rgba(0,0,0,0)',
				'white'       => '#ffffff',
				'black'       => '#000000',
				'accent'      => '#0066cc',
				'accent2'     => '#004c99',
				'bg'          => '#ffffff',
				'text'        => '#666666',
				'heading'     => '#333333',
				'subtle'      => 'rgba(0,0,0,0.05)',
				'border'      => 'rgba(0,0,0,0.1)',
			),
		),
		'2.0.0'
	);

	return $colors;
}


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
