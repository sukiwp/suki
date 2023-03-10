<?php
/**
 * Custom helper functions that can be used globally.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ====================================================
 * PHP compatibility functions
 * ====================================================
 */

if ( ! function_exists( 'str_starts_with' ) ) {
	/**
	 * Polyfill for `str_starts_with()` function added in PHP 8.0.
	 *
	 * Performs a case-sensitive check indicating if the haystack begins with needle.
	 *
	 * @param string $haystack The string to search in.
	 * @param string $needle   The substring to search for in the `$haystack`.
	 * @return bool True if `$haystack` starts with `$needle`, otherwise false.
	 */
	function str_starts_with( $haystack, $needle ) {
		if ( '' === $needle ) {
			return true;
		}

		return 0 === strpos( $haystack, $needle );
	}
}

if ( ! function_exists( 'str_ends_with' ) ) {
	/**
	 * Polyfill for `str_ends_with()` function added in PHP 8.0.
	 *
	 * Performs a case-sensitive check indicating if the haystack ends with needle.
	 *
	 * @param string $haystack The string to search in.
	 * @param string $needle   The substring to search for in the `$haystack`.
	 * @return bool True if `$haystack` ends with `$needle`, otherwise false.
	 */
	function str_ends_with( $haystack, $needle ) {
		if ( '' === $haystack && '' !== $needle ) {
			return false;
		}

		$len = strlen( $needle );

		return 0 === substr_compare( $haystack, $needle, -$len, $len );
	}
}

/**
 * ====================================================
 * Helper functions
 * ====================================================
 */

/**
 * Check if specified key exists on an array, then return the value.
 * Otherwise return the specified fallback value, or null if no fallback is specified.
 *
 * @param array $array    Array of values.
 * @param mixed $key      Key of requested value.
 * @param mixed $fallback Fallback value if value key is not found in the array (optional, default to null).
 * @return mixed
 */
function suki_array_value( $array, $key, $fallback = null ) {
	if ( ! is_array( $array ) ) {
		return null;
	}

	return isset( $array[ $key ] ) ? $array[ $key ] : $fallback;
}

/**
 * Recursively flatten a multi-dimensional array into a one-dimensional array.
 *
 * @param array $array Array to be flatened.
 * @return array
 */
function suki_flatten_array( $array ) {
	$flattened = array();

	foreach ( $array as $key => $value ) {
		if ( is_array( $value ) ) {
			$flattened = array_merge( $flattened, suki_flatten_array( $value ) );
		} else {
			$flattened[ strval( $key ) ] = $value;
		}
	}

	return $flattened;
}

/**
 * Split dimension value into an array of number and unit.
 *
 * @param string $dimension Dimension string.
 * @return array
 */
function suki_split_dimension( $dimension ) {
	$number = floatval( $dimension );
	$unit   = str_replace( $number, '', $dimension );

	return array( $number, $unit );
}

/**
 * Scale a dimension value and preserve the units.
 *
 * @param float  $multiplier Multiplier.
 * @param string $dimension  Dimension string.
 * @return string
 */
function suki_scale_dimension( $multiplier, $dimension ) {
	$splitted_dimension = suki_split_dimension( $dimension );

	$scaled_dimension = $splitted_dimension[0] * $multiplier . $splitted_dimension[1];

	return $scaled_dimension;
}

/**
 * Convert associative array into simple array.
 * For example:
 *
 * Input array:
 *     array(
 *         'foo'   => 'bar',
 *         'lorem' => 'ipsum',
 *     )
 *
 * Output array:
 *     array(
 *         array(
 *             'value' => 'foo',
 *             'label' => 'bar',
 *         ),
 *         array(
 *             'value' => 'lorem',
 *             'label' => 'ipsum',
 *         ),
 *     )
 *
 * @param array  $assoc_array    The associative array to be converted.
 * @param string $left_key_name  Key string that will store the `key` from each associative array item.
 * @param string $right_key_name Key string that will store the `value` from each associative array item (If `value` is an array, this will be ignored).
 */
function suki_convert_associative_array_into_simple_array( $assoc_array = array(), $left_key_name = 'value', $right_key_name = 'label' ) {
	if ( ! is_array( $assoc_array ) ) {
		return array();
	}

	$simple_array = array();

	foreach ( $assoc_array as $left => $right ) {
		$item = array();

		if ( is_array( $right ) ) {
			$item = $right;
		} else {
			$item[ $right_key_name ] = $right;
		}

		$item[ $left_key_name ] = $left;

		$simple_array[] = $item;
	}

	return $simple_array;
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
	$show = true;

	// Automatically hide teaser when Suki Pro is installed or SUKI_HIDE_PRO_TEASER constant is set to true.
	if ( ( defined( 'SUKI_HIDE_PRO_TEASER' ) && SUKI_HIDE_PRO_TEASER ) || suki_is_pro() ) {
		$show = false;
	}

	/**
	 * Filter: suki/pro/show_teaser
	 *
	 * @param boolean $show Show Suki Pro teaser message or not.
	 */
	$show = apply_filters( 'suki/pro/show_teaser', $show );

	return $show;
}

/**
 * Return global breakpoints.
 *
 * @param string  $device    Device type.
 * @param integer $increment Increment to the actual breakpoint value.
 * @return integer
 */
function suki_get_breakpoint( $device, $increment = 0 ) {
	switch ( $device ) {
		case 'mobile':
		case 'phone':
			$breakpoint = 500;
			break;

		case 'tablet':
			$breakpoint = 768;
			break;

		default:
			$breakpoint = 1024;
			break;
	}

	return $breakpoint + intval( $increment );
}

/**
 * Return the current loaded page context.
 *
 * @return string
 */
function suki_get_current_page_context() {
	// Abort if it's an admin page.
	if ( is_admin() ) {
		return;
	}

	$current_page_context = '';

	// Frontend pages.
	if ( is_404() ) {
		$current_page_context = 'error_404';
	} elseif ( is_search() && ! is_archive() ) { // WooCommerce search results page is considered as archive.
		$current_page_context = 'search_results';
	} elseif ( is_singular() ) {
		$current_page_context = get_post_type() . '_single';
	} elseif ( is_post_type_archive() ) {
		$current_page_context = get_post_type() . '_archive';
	} elseif ( is_category() || is_tag() || is_tax() ) {
		$current_page_context = get_taxonomy( get_queried_object()->taxonomy )->object_type[0] . '_archive';
	} elseif ( is_author() || is_date() || is_home() ) {
		$current_page_context = 'post_archive';
	}

	return $current_page_context;
}

/**
 * Wrapper function to get page setting of specified key.
 *
 * @param string $key     Key of requested page setting value.
 * @param mixed  $default Default value.
 * @return array
 */
function suki_get_current_page_setting( $key, $default = null ) {
	// Return null if no key specified.
	if ( empty( $key ) ) {
		return null;
	}

	// Get current page context.
	$current_page_context = suki_get_current_page_context();

	// Get the value from Customizer Page Settings.
	$value = suki_get_theme_mod( $current_page_context . '_' . $key );

	/**
	 * Filter: suki/page_settings/setting_value
	 *
	 * @param mixed  $value     Setting value.
	 * @param string $key       Setting key.
	 * @param string $current_page_context Page type.
	 */
	$value = apply_filters( 'suki/page_settings/setting_value', $value, $key, $current_page_context );

	/**
	 * Filter: suki/page_settings/setting_value/{$key}
	 *
	 * @param mixed  $value     Setting value.
	 * @param string $current_page_context Page type.
	 */
	$value = apply_filters( 'suki/page_settings/setting_value/' . $key, $value, $current_page_context );

	// Last fallback, if the value is empty, try to use the global value.
	if ( '' === $value || is_null( $value ) ) {
		$value = suki_get_theme_mod( $key, $default );
	}

	return $value;
}

/**
 * Return boolean whether current loaded page has hero section.
 *
 * @return boolean
 */
function suki_current_page_has_hero_section() {
	if (
		boolval( suki_get_current_page_setting( 'hero' ) ) && // Hero section is active.
		! boolval( suki_get_current_page_setting( 'disable_content_header' ) ) && // Content header is not disabled.
		0 < count( suki_get_current_page_setting( 'content_header', array() ) ) // Content header has at least 1 element.
	) {
		return true;
	}

	return false;
}

/**
 * Return boolean whether current loaded page has content + sidebar layout.
 *
 * @return boolean
 */
function suki_current_page_has_sidebar() {
	if (
		'narrow' !== suki_get_current_page_setting( 'content_container' ) &&
		in_array( suki_get_current_page_setting( 'content_layout' ), array( 'left-sidebar', 'right-sidebar' ), true )
	) {
		return true;
	}

	return false;
}

/**
 * Wrapper function to get theme info.
 *
 * @param string $key Key of requested value.
 * @return string
 */
function suki_get_theme_info( $key ) {
	return Suki::instance()->get_info( $key );
}

/**
 * Wrapper function to get theme_mod value.
 *
 * @param string $key     Key of requested value.
 * @param mixed  $default Default value.
 * @return mixed
 */
function suki_get_theme_mod( $key, $default = null ) {
	return Suki_Customizer::instance()->get_setting_value( $key, $default );
}

/**
 * Minify CSS string.
 *
 * Modification:
 * - add: rem, ch, vw, vh to units regex
 * - remove: ex, in, cm, mm, pt, pc from units regex
 * - add: remove space after (
 * - remove: shorten 6-character hex color
 *
 * @link https://github.com/GaryJones/Simple-PHP-CSS-Minification
 *
 * @param array $css Unminified CSS string.
 * @return string
 */
function suki_minify_css_string( $css ) {
	// Normalize whitespace.
	$css = preg_replace( '/\s+/', ' ', $css );

	// Remove spaces before and after comment.
	$css = preg_replace( '/(\s+)(\/\*(.*?)\*\/)(\s+)/', '$2', $css );

	// Remove comment blocks, everything between /* and */, unless.
	// preserved with /*! ... */ or /** ... */.
	$css = preg_replace( '~/\*(?![\!|\*])(.*?)\*/~', '', $css );

	// Remove ; before }.
	$css = preg_replace( '/;(?=\s*})/', '', $css );

	// Remove space after , : ; { } */ > (.
	$css = preg_replace( '/(,|:|;|\{|}|\*\/|>|\() /', '$1', $css );

	// Remove space before , ; { } ( ) >.
	$css = preg_replace( '/ (,|;|\{|}|\(|\)|>)/', '$1', $css );

	// Strips leading 0 on decimal values (converts 0.5px into .5px).
	$css = preg_replace( '/(:| )0\.([0-9]+)(%|em|rem|ch|vw|vh)/i', '${1}.${2}${3}', $css );

	// Strips units if value is 0 (converts 0px to 0).
	$css = preg_replace( '/(:| )(\.?)0(%|em|rem|ch|vw|vh)/i', '${1}0', $css );

	// Converts all zeros value into short-hand.
	$css = preg_replace( '/0 0 0 0/', '0', $css );

	return trim( $css );
}

/**
 * Build CSS string from array structure.
 *
 * @param array   $css_array Array of CSS rules.
 * @param boolean $minify    Minify the CSS or not.
 * @return string
 */
function suki_convert_css_array_to_string( $css_array, $minify = true ) {
	$final_css = '';

	foreach ( $css_array as $media => $selectors ) {
		if ( empty( $selectors ) ) {
			continue;
		}

		// Add media query open tag.
		if ( 'global' !== $media ) {
			$final_css .= $media . '{';
		}

		// Iterate properties.
		foreach ( $selectors as $selector => $properties ) {
			$final_css .= $selector . '{';

			$i = 1;
			foreach ( $properties as $property => $value ) {
				if ( '' === $value ) {
					continue;
				}

				$final_css .= $property . ':' . $value;

				if ( count( $properties ) !== $i ) {
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

	if ( $minify ) {
		$final_css = suki_minify_css_string( $final_css );
	}

	return $final_css;
}

/**
 * Sanitize SVG markup before render.
 *
 * @param string $html SVG markup.
 * @return string
 */
function suki_clean_svg_markup( $html ) {
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
	$html = preg_replace( '/<title>.*?<\/title>/', '', $html );

	return $html;
}
