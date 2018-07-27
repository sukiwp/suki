<?php
/**
 * Custom helper functions to process data.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * ====================================================
 * Helper functions
 * ====================================================
 */

/**
 * PHP custom function: suki_array_value()
 *
 * @param array $item
 * @param mixed $index
 * @param mixed $fallback
 * @return mixed
 */
function suki_array_value( $array, $index, $fallback = null ) {
	if ( ! is_array( $array ) ) {
		return null;
	}

	return isset( $array[ $index ] ) ? $array[ $index ] : $fallback;
}

/**
 * Return boolean whether Suki Pro is activated.
 *
 * @return boolean
 */
function suki_is_pro() {
	return class_exists( 'Suki_Pro' );
}

/**
 * Return boolean whether theme should render any kind of Suki Pro modules teaser.
 *
 * @return boolean
 */
function suki_show_pro_teaser() {
	return apply_filters( 'suki/pro/show_teaser', ! suki_is_pro() );
}

/**
 * Wrapper function to get page settings of the specified post ID.
 *
 * @param string $key
 * @param integer $post_id
 * @return mixed
 */
function suki_get_page_setting_by_post_id( $key, $post_id ) {
	if ( ! is_numeric( $post_id ) ) {
		return;
	}

	$post = get_post( $post_id );

	// Abort if no post found.
	if ( empty( $post ) ) {
		return null;
	}

	// Get individual settings merged with global customizer settings.
	$settings = wp_parse_args( get_post_meta( $post->ID, '_suki_page_settings', true ), suki_get_theme_mod( 'page_settings_' . $post->post_type . '_singular', array() ) );

	// Merge with fallback settings.
	$settings = wp_parse_args( $settings, suki_get_fallback_page_settings() );

	// Get value for specified key.
	$value = suki_array_value( $settings, $key );

	return $value;
}

/**
 * Wrapper function to get current page settings.
 *
 * @return array
 */
function suki_get_current_page_settings() {
	$settings = array();

	// Blog posts index page
	if ( is_home() ) {
		$settings = suki_get_theme_mod( 'page_settings_post_archive', array() );
	}
	// Other post types index page
	elseif ( is_post_type_archive() ) {
		$obj = get_queried_object();
		$settings = suki_get_theme_mod( 'page_settings_' . $obj->name . '_archive', array() );
	}
	// Static page
	elseif ( is_page() ) {
		$obj = get_queried_object();
		$settings = wp_parse_args( get_post_meta( $obj->ID, '_suki_page_settings', true ), suki_get_theme_mod( 'page_settings_static', array() ) );
	}
	// Single post page (any post type)
	elseif ( is_singular() ) {
		$obj = get_queried_object();
		$settings = wp_parse_args( get_post_meta( $obj->ID, '_suki_page_settings', true ), suki_get_theme_mod( 'page_settings_' . $obj->post_type . '_singular', array() ) );
	}
	// Time based Archive page
	elseif ( is_year() || is_month() || is_date() || is_time() ) {
		$settings = suki_get_theme_mod( 'page_settings_post_archive', array() );
	}
	// Author based Archive page
	elseif ( is_author() ) {
		$settings = suki_get_theme_mod( 'page_settings_post_archive', array() );
	}
	// Other archive page
	elseif ( is_archive() ) {
		$obj = get_queried_object();
		$post_type = 'post';
		
		global $wp_taxonomies;
		if ( isset( $wp_taxonomies[ $obj->taxonomy ] ) ) {
			$post_types = $wp_taxonomies[ $obj->taxonomy ]->object_type;
			$post_type_archive_settings = suki_get_theme_mod( 'page_settings_' . $post_types[0] . '_archive', array() );
		}

		$term_meta_settings = get_term_meta( $obj->term_id, 'suki_page_settings', true );
		if ( '' === $term_meta_settings ) {
			$term_meta_settings = array();
		}
		
		$settings = wp_parse_args( $term_meta_settings, $post_type_archive_settings );
	}
	// Search page
	elseif ( is_search() ) {
		$settings = suki_get_theme_mod( 'page_settings_search', array() );
	}
	// 404 page
	elseif ( is_404() ) {
		$settings = suki_get_theme_mod( 'page_settings_404', array() );
	}

	// Merge with fallback settings.
	$settings = wp_parse_args( $settings, suki_get_fallback_page_settings() );

	return apply_filters( 'suki/frontend/current_page_settings', $settings );
}

/**
 * Wrapper function to get current page setting of specified key.
 *
 * @param string $key
 * @return array
 */
function suki_get_current_page_setting( $key ) {
	$value = null;
	
	$settings = suki_get_current_page_settings();

	$value = suki_array_value( $settings, $key );

	return $value;
}

/**
 * Wrapper function to get theme info.
 *
 * @param string $key
 * @return string
 */
function suki_get_theme_info( $key ) {
	return Suki::instance()->get_info( $key );
}

/**
 * Wrapper function to get theme_mod value.
 *
 * @param string $key
 * @param mixed $default
 * @return mixed
 */
function suki_get_theme_mod( $key, $default = null ) {
	return Suki_Customizer::instance()->get_setting_value( $key, $default );
}

/**
 * Minify CSS string.
 * ref: https://github.com/GaryJones/Simple-PHP-CSS-Minification
 *
 * @param array $css
 * @return string
 */
function suki_minify_css_string( $css ) {
	// Normalize whitespace
	$css = preg_replace( '/\s+/', ' ', $css );

	// Remove spaces before and after comment
	$css = preg_replace( '/(\s+)(\/\*(.*?)\*\/)(\s+)/', '$2', $css );

	// Remove comment blocks, everything between /* and */, unless
	// preserved with /*! ... */ or /** ... */
	$css = preg_replace( '~/\*(?![\!|\*])(.*?)\*/~', '', $css );

	// Remove ; before }
	$css = preg_replace( '/;(?=\s*})/', '', $css );

	// Remove space after , : ; { } */ >
	$css = preg_replace( '/(,|:|;|\{|}|\*\/|>) /', '$1', $css );

	// Remove space before , ; { } ( ) >
	$css = preg_replace( '/ (,|;|\{|}|\(|\)|>)/', '$1', $css );

	// Strips leading 0 on decimal values (converts 0.5px into .5px)
	$css = preg_replace( '/(:| )0\.([0-9]+)(%|rem|em|ex|px|in|cm|mm|pt|pc)/i', '${1}.${2}${3}', $css );

	// Strips units if value is 0 (converts 0px to 0)
	$css = preg_replace( '/(:| )(\.?)0(%|rem|em|ex|px|in|cm|mm|pt|pc)/i', '${1}0', $css );

	// Converts all zeros value into short-hand
	$css = preg_replace( '/0 0 0 0/', '0', $css );

	// Shortern 6-character hex color codes to 3-character where possible
	$css = preg_replace( '/#([a-f0-9])\\1([a-f0-9])\\2([a-f0-9])\\3/i', '#\1\2\3', $css );

	return trim( $css );
}

/**
 * Build CSS string from array structure.
 *
 * @param array $css_array
 * @return string
 */
function suki_convert_css_array_to_string( $css_array ) {
	$final_css = '';

	foreach ( $css_array as $media => $selectors ) {
		// Add media query open tag.
		if ( 'global' !== $media ) {
			$final_css .= $media. '{';
		}

		// Iterate properties.
		foreach ( $selectors as $selector => $properties ) {
			$final_css .= $selector . '{';

			$i = 1;
			foreach ( $properties as $property => $value ) {
				$final_css .= $property . ':' . $value;

				if ( $i !== count( $properties ) ) {
					$final_css .= ';';
				}

				$i++;
			}

			$final_css .= '}';
		}

		// Add media query closing tag.
		if ( 'global' !== $media ) {
			$final_css .= '}';
		}
	}

	// Minify CSS.
	$final_css = suki_minify_css_string( $final_css );

	return $final_css;
}

/**
 * Build Google Fonts embed URL from specified fonts
 *
 * @param array $google_fonts
 * @return string
 */
function suki_build_google_fonts_embed_url( $google_fonts = array() ) {
	if ( empty( $google_fonts ) ) {
		return '';
	}

	// Basic embed link.
	$link = '//fonts.googleapis.com/css';
	$args = array();

	// Add font families.
	$families = array();
	foreach ( $google_fonts as $name ) {
		// Add font family and all variants.
		$families[] = str_replace( ' ', '+', $name ) . ':100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i';
	}
	$args['family'] = implode( '|', $families );

	// Add font subsets.
	$subsets = array_merge( array( 'latin' ), suki_get_theme_mod( 'google_fonts_subsets', array() ) );
	$args['subset'] = implode( ',', $subsets );

	return esc_url( add_query_arg( $args, $link ) );
}

/**
 * Get more accurate value of content width in pixels, based on current page's content layout and content column's padding and border.
 *
 * @global integer $content_width
 * @param string $content_layout
 * @return integer
 */
function suki_get_content_width_by_layout( $content_layout = 'right-sidebar' ) {
	$content_width = floatval( suki_get_theme_mod( 'container_width' ) );

	// Modify content width based on current page content layout.
	switch ( $content_layout ) {
	 	case 'narrow':
			$content_width = floatval( suki_get_theme_mod( 'narrow_content_width' ) );
	 		break;
	 	
	 	case 'left-sidebar':
	 	case 'right-sidebar':
	 		// Sidebar width
	 		$sidebar_width = suki_get_theme_mod( 'sidebar_width' );
	 		if ( false !== strpos( $sidebar_width, '%' ) ) {
	 			// %
				$sidebar_width = $content_width * ( floatval( $sidebar_width ) / 100 );
	 		} else {
	 			// px
	 			$sidebar_width = floatval( $sidebar_width );
	 		}

	 		// Sidebar gap
	 		$sidebar_gap = suki_get_theme_mod( 'sidebar_gap' );
	 		if ( false !== strpos( $sidebar_gap, '%' ) ) {
	 			// %
				$sidebar_gap = $content_width * ( floatval( $sidebar_gap ) / 100 );
	 		} else {
	 			// px
	 			$sidebar_gap = floatval( $sidebar_gap );
	 		}

	 		$content_width = $content_width - $sidebar_width - $sidebar_gap;
	 		break;
	}

	// // Modify content width based on its padding.
	// $content_padding = suki_get_theme_mod( 'content_padding' );
	// $paddings = explode( ' ', $content_padding );
	// if ( isset( $paddings[1] ) ) {
	// 	$content_width -= floatval( $paddings[1] );
	// }
	// if ( isset( $paddings[3] ) ) {
	// 	$content_width -= floatval( $paddings[3] );
	// }

	// // Modify content width based on its border.
	// $content_border = suki_get_theme_mod( 'content_border' );
	// $borders = explode( ' ', $content_border );
	// if ( isset( $borders[1] ) ) {
	// 	$content_width -= floatval( $borders[1] );
	// }
	// if ( isset( $borders[3] ) ) {
	// 	$content_width -= floatval( $borders[3] );
	// }

	return $content_width;
}

/**
 * ====================================================
 * Data set functions
 * ====================================================
 */

/**
 * Return fallback values of page settings.
 * 
 * @return array
 */
function suki_get_fallback_page_settings() {
	return apply_filters( 'suki/dataset/fallback_page_settings', array(
		'content_container' => 'default',
		'content_layout'    => 'right-sidebar',
	) );
}

/**
 * Return all available fonts.
 * 
 * @return array
 */
function suki_get_all_fonts() {
	return apply_filters( 'suki/dataset/all_fonts', array(
		'web_safe_fonts' => suki_get_web_safe_fonts(),
		'google_fonts' => suki_get_google_fonts(),
	) );
}

/**
 * Return array of selected Google Fonts list.
 * Selected fonts are configurable from Appearance > Suki > Settings > Fonts page.
 * 
 * @return array
 */
function suki_get_google_fonts() {
	ob_start();
	include( SUKI_INCLUDES_PATH . '/list/google-fonts.json' );
	return json_decode( ob_get_clean(), true );
}

/**
 * Return array of Google Fonts subsets.
 * 
 * @return array
 */
function suki_get_google_fonts_subsets() {
	return apply_filters( 'suki/dataset/google_fonts_subsets', array(
		// 'latin'        => esc_html__( 'Latin (default)', 'suki' ), // always chosen by default
		'latin-ext'    => esc_html__( 'Latin Extended', 'suki' ),
		'arabic'       => esc_html__( 'Arabic', 'suki' ),
		'bengali'      => esc_html__( 'Bengali', 'suki' ),
		'cyrillic'     => esc_html__( 'Cyrillic', 'suki' ),
		'cyrillic-ext' => esc_html__( 'Cyrillic Extended', 'suki' ),
		'devaganari'   => esc_html__( 'Devaganari', 'suki' ),
		'greek'        => esc_html__( 'Greek', 'suki' ),
		'greek-ext'    => esc_html__( 'Greek Extended', 'suki' ),
		'gujarati'     => esc_html__( 'Gujarati', 'suki' ),
		'gurmukhi'     => esc_html__( 'Gurmukhi', 'suki' ),
		'hebrew'       => esc_html__( 'Hebrew', 'suki' ),
		'kannada'      => esc_html__( 'Kannada', 'suki' ),
		'khmer'        => esc_html__( 'Khmer', 'suki' ),
		'malayalam'    => esc_html__( 'Malayalam', 'suki' ),
		'myanmar'      => esc_html__( 'Myanmar', 'suki' ),
		'oriya'        => esc_html__( 'Oriya', 'suki' ),
		'sinhala'      => esc_html__( 'Sinhala', 'suki' ),
		'tamil'        => esc_html__( 'Tamil', 'suki' ),
		'telugu'       => esc_html__( 'Telugu', 'suki' ),
		'thai'         => esc_html__( 'Thai', 'suki' ),
		'vietnamese'   => esc_html__( 'Vietnamese', 'suki' ),
	) );
}

/**
 * Return array of Web Safe Fonts choices.
 * 
 * @return array
 */
function suki_get_web_safe_fonts() {
	return apply_filters( 'suki/dataset/web_safe_fonts', array(
		// System
		'Default System Font' => "-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen-Sans, Ubuntu, Cantarell, 'Helvetica Neue', sans-serif",

		// Sans Serif
		'Arial' => "Arial, 'Helvetica Neue', Helvetica, sans-serif",
		'Helvetica' => "'Helvetica Neue', Helvetica, Arial, sans-serif",
		'Tahoma' => "Tahoma, Geneva, sans-serif",
		'Trebuchet MS' => "'Trebuchet MS', Helvetica, sans-serif",
		'Verdana' => "Verdana, Geneva, sans-serif",

		// Serif
		'Georgia' => "Georgia, serif",
		'Times New Roman' => "'Times New Roman', Times, serif",

		// Monospace
		'Courier New' => "'Courier New', Courier, monospace",
		'Lucida Console' => "'Lucida Console', Monaco, monospace",
	) );
}

/**
 * Return array of social media types (based on Simple Icons).
 * 
 * @return array
 */
function suki_get_social_media_types() {
	return apply_filters( 'suki/dataset/social_media_types', array(
		'facebook' => 'Facebook',
		'instagram' => 'Instagram',
		'google-plus' => 'Google Plus',
		'linkedin' => 'LinkedIn',
		'twitter' => 'Twitter',
		'pinterest' => 'Pinterest',
		'vk' => 'VK',
		'behance' => 'Behance',
		'dribbble' => 'Dribbble',
		'medium' => 'Medium',
		'github' => 'Github',
		'vimeo' => 'Vimeo',
		'youtube' => 'Youtube',
		'rss' => 'RSS',
	) );
}