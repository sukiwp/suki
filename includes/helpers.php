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
 * Return script data as defined on the generated `/assets/scripts/[name].asset.php` file.
 *
 * @since 2.0.0
 *
 * @param string $script_name Script name.
 * @return array
 */
function suki_get_script_data( $script_name ) {
	// Define the asset file path.
	$script_asset_path = trailingslashit( get_template_directory() ) . 'assets/scripts/' . $script_name . '.asset.php';

	// Get dependencies and version from the asset file.
	$script_data = include $script_asset_path;

	$directory_url = trailingslashit( get_template_directory_uri() ) . 'assets/scripts';
	$directory_dir = trailingslashit( get_template_directory() ) . 'assets/scripts';

	// Add the CSS file URL to the returned data (if exists).
	if ( file_exists( trailingslashit( $directory_dir ) . $script_name . '.css' ) ) {
		$script_data['css_file_url'] = trailingslashit( $directory_url ) . $script_name . '.css';
	}

	// Add the JS file URL to the returned data (if exists).
	if ( file_exists( trailingslashit( $directory_dir ) . $script_name . '.js' ) ) {
		$script_data['js_file_url'] = trailingslashit( $directory_url ) . $script_name . '.js';
	}

	return $script_data;
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
		( ! is_home() || boolval( suki_get_theme_mod( 'post_archive_home_content_header' ) ) ) && // Not blog posts home, or content header is allowed in blog posts home.
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
 * ====================================================
 * Data set functions
 * ====================================================
 */

/**
 * Return array of module categories.
 *
 * @return array
 */
function suki_get_module_categories() {
	return array(
		'layout'      => array(
			'label' => esc_html__( 'Layout', 'suki' ),
			'icon'  => 'layout',
		),
		'assets'      => array(
			'label' => esc_html__( 'Assets and Branding', 'suki' ),
			'icon'  => 'superhero-alt',
		),
		'seo'         => array(
			'label' => esc_html__( 'SEO and Performance', 'suki' ),
			'icon'  => 'dashboard',
		),
		'blog'        => array(
			'label' => esc_html__( 'Blog', 'suki' ),
			'icon'  => 'welcome-write-blog',
		),
		'woocommerce' => array(
			'label' => esc_html__( 'WooCommerce', 'suki' ),
			'icon'  => 'cart',
		),
	);
}

/**
 * Return array of supported Suki Pro modules.
 *
 * @return array
 */
function suki_get_pro_modules() {
	$modules = apply_filters(
		'suki/pro/modules',
		array(
			'header-elements-plus'              => array(
				'label'    => esc_html__( 'Header Elements Plus', 'suki' ),
				'category' => 'layout',
				'settings' => array(
					'label' => esc_html__( 'Build Header', 'suki' ),
					'url'   => add_query_arg( array( 'autofocus[panel]' => 'suki_panel_header' ), admin_url( 'customize.php' ) ),
				),
			),
			'header-vertical'                   => array(
				'label'    => esc_html__( 'Vertical Header', 'suki' ),
				'category' => 'layout',
				'settings' => array(
					'label' => esc_html__( 'Configure', 'suki' ),
					'url'   => add_query_arg( array( 'autofocus[section]' => 'suki_section_header_vertical' ), admin_url( 'customize.php' ) ),
				),
			),
			'header-transparent'                => array(
				'label'    => esc_html__( 'Transparent Header', 'suki' ),
				'category' => 'layout',
				'settings' => array(
					'label' => esc_html__( 'Configure', 'suki' ),
					'url'   => add_query_arg( array( 'autofocus[section]' => 'suki_section_header_transparent' ), admin_url( 'customize.php' ) ),
				),
			),
			'header-sticky'                     => array(
				'label'    => esc_html__( 'Sticky Header', 'suki' ),
				'category' => 'layout',
				'settings' => array(
					'label' => esc_html__( 'Configure', 'suki' ),
					'url'   => add_query_arg( array( 'autofocus[section]' => 'suki_section_header_sticky' ), admin_url( 'customize.php' ) ),
				),
			),
			'header-alt-colors'                 => array(
				'label'    => esc_html__( 'Alternate Header Colors', 'suki' ),
				'category' => 'layout',
				'settings' => array(
					'label' => esc_html__( 'Configure', 'suki' ),
					'url'   => add_query_arg( array( 'autofocus[section]' => 'suki_section_header_alt_colors' ), admin_url( 'customize.php' ) ),
				),
			),
			'header-mega-menu'                  => array(
				'label'    => esc_html__( 'Header Mega Menu', 'suki' ),
				'category' => 'layout',
				'settings' => array(
					'label' => esc_html__( 'Manage Mega Menu', 'suki' ),
					'url'   => add_query_arg( array( 'autofocus[section]' => 'suki_section_header_mega_menu' ), admin_url( 'customize.php' ) ),
				),
			),
			'sidebar-sticky'                    => array(
				'label'    => esc_html__( 'Sticky Sidebar', 'suki' ),
				'category' => 'layout',
				'settings' => array(
					'label' => esc_html__( 'Configure', 'suki' ),
					'url'   => add_query_arg( array( 'autofocus[section]' => 'suki_section_sidebar_sticky' ), admin_url( 'customize.php' ) ),
				),
			),
			'footer-widgets-columns-width'      => array(
				'label'    => esc_html__( 'Footer Columns Width', 'suki' ),
				'category' => 'layout',
				'settings' => array(
					'label' => esc_html__( 'Configure', 'suki' ),
					'url'   => add_query_arg( array( 'autofocus[panel]' => 'suki_panel_footer' ), admin_url( 'customize.php' ) ),
				),
			),
			'preloader-screen'                  => array(
				'label'    => esc_html__( 'Preloader Screen', 'suki' ),
				'category' => 'layout',
				'settings' => array(
					'label' => esc_html__( 'Configure', 'suki' ),
					'url'   => add_query_arg( array( 'autofocus[section]' => 'suki_section_preloader_screen' ), admin_url( 'customize.php' ) ),
				),
			),
			'custom-blocks'                     => array(
				'label'    => esc_html__( 'Custom Blocks (Hooks)', 'suki' ),
				'category' => 'layout',
				'settings' => array(
					'label' => esc_html__( 'Manage Custom Blocks', 'suki' ),
					'url'   => add_query_arg( array( 'post_type' => 'suki_block' ), admin_url( 'edit.php' ) ),
				),
			),

			'custom-fonts'                      => array(
				'label'    => esc_html__( 'Custom Fonts', 'suki' ),
				'category' => 'assets',
				'settings' => array(
					'label' => esc_html__( 'Manage Custom Fonts', 'suki' ),
					'url'   => add_query_arg( array( 'autofocus[section]' => 'suki_section_custom_fonts' ), admin_url( 'customize.php' ) ),
				),
			),
			'custom-icons'                      => array(
				'label'    => esc_html__( 'Custom Icons', 'suki' ),
				'category' => 'assets',
				'settings' => array(
					'label' => esc_html__( 'Manage Custom Fonts', 'suki' ),
					'url'   => add_query_arg( array( 'autofocus[section]' => 'suki_section_custom_icons' ), admin_url( 'customize.php' ) ),
				),
			),
			'white-label'                       => array(
				'label'    => esc_html__( 'White Label', 'suki' ),
				'category' => 'assets',
			),

			'blog-layout-plus'                  => array(
				'label'    => esc_html__( 'Blog Layout Plus', 'suki' ),
				'category' => 'blog',
				'settings' => array(
					'label' => esc_html__( 'Configure', 'suki' ),
					'url'   => add_query_arg( array( 'autofocus[panel]' => 'suki_panel_blog' ), admin_url( 'customize.php' ) ),
				),
			),
			'blog-featured-posts'               => array(
				'label'    => esc_html__( 'Blog Featured Posts', 'suki' ),
				'category' => 'blog',
				'settings' => array(
					'label' => esc_html__( 'Configure', 'suki' ),
					'url'   => add_query_arg( array( 'autofocus[panel]' => 'suki_section_blog_featured_posts' ), admin_url( 'customize.php' ) ),
				),
			),
			'blog-related-posts'                => array(
				'label'    => esc_html__( 'Blog Related Posts', 'suki' ),
				'category' => 'blog',
				'settings' => array(
					'label' => esc_html__( 'Configure', 'suki' ),
					'url'   => add_query_arg( array( 'autofocus[section]' => 'suki_section_blog_related_posts' ), admin_url( 'customize.php' ) ),
				),
			),

			'woocommerce-layout-plus'           => array(
				'label'    => esc_html__( 'Woo Layout Plus', 'suki' ),
				'category' => 'woocommerce',
			),
			'woocommerce-ajax-add-to-cart'      => array(
				'label'    => esc_html__( 'Woo AJAX Add To Cart', 'suki' ),
				'category' => 'woocommerce',
			),
			'woocommerce-quick-view'            => array(
				'label'    => esc_html__( 'Woo Quick View', 'suki' ),
				'category' => 'woocommerce',
			),
			'woocommerce-off-canvas-filters'    => array(
				'label'    => esc_html__( 'Woo Off-Canvas Filters', 'suki' ),
				'category' => 'woocommerce',
			),
			'woocommerce-checkout-optimization' => array(
				'label'    => esc_html__( 'Woo Optimized Checkout', 'suki' ),
				'category' => 'woocommerce',
			),
		)
	);

	return $modules;
}

/**
 * Return list of public post types.
 *
 * @param string $context Return context: native or custom or all post types.
 * @return array
 */
function suki_get_public_post_types( $context = 'all' ) {
	// Native post types.
	$native_post_types = array( 'post', 'page' );

	// Custom post types.
	$custom_post_types = get_post_types(
		array(
			'public'             => true,
			'publicly_queryable' => true,
			'rewrite'            => true,
			'_builtin'           => false,
		),
		'names'
	);
	$custom_post_types = array_values( $custom_post_types );

	switch ( $context ) {
		case 'custom':
			$return = $custom_post_types;
			break;

		case 'native':
			$return = $native_post_types;
			break;

		default:
			$return = array_merge( $native_post_types, $custom_post_types );
			break;
	}

	return $return;
}

/**
 * Return all available fonts.
 *
 * @return array
 */
function suki_get_all_font_groups() {
	/**
	 * Filter: suki/dataset/font_groups
	 *
	 * @param array $groups Fonts array.
	 */
	$groups = apply_filters(
		'suki/dataset/font_groups',
		array(
			'web_safe_fonts' => esc_html__( 'Web Safe Fonts', 'suki' ),
		)
	);

	return $groups;
}

/**
 * Return all available fonts.
 *
 * @return array
 */
function suki_get_all_fonts() {
	/**
	 * Filter: suki/dataset/fonts
	 *
	 * @param array $fonts Fonts array.
	 */
	$fonts = apply_filters(
		'suki/dataset/fonts',
		array(
			'web_safe_fonts' => suki_get_web_safe_fonts(),
		)
	);

	return $fonts;
}

/**
 * Return array of Web Safe Fonts choices.
 *
 * @return array
 */
function suki_get_web_safe_fonts() {
	/**
	 * Filter: suki/dataset/web_safe_fonts
	 *
	 * @param array $fonts Fonts array.
	 */
	$fonts = apply_filters(
		'suki/dataset/web_safe_fonts',
		array(
			// System.
			'Default System Font' => '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif',

			// Sans Serif.
			'Arial'               => 'Arial, "Helvetica Neue", Helvetica, sans-serif',
			'Helvetica'           => '"Helvetica Neue", Helvetica, Arial, sans-serif',
			'Tahoma'              => 'Tahoma, Geneva, sans-serif',
			'Trebuchet MS'        => '"Trebuchet MS", Helvetica, sans-serif',
			'Verdana'             => 'Verdana, Geneva, sans-serif',

			// Serif.
			'Georgia'             => 'Georgia, serif',
			'Times New Roman'     => '"Times New Roman", Times, serif',

			// Monospace.
			'Courier New'         => '"Courier New", Courier, monospace',
			'Lucida Console'      => '"Lucida Console", Monaco, monospace',
		)
	);

	return $fonts;
}

/**
 * Return array of social media types (based on Simple Icons).
 *
 * @param boolean $sort Sort the array or not.
 * @return array
 */
function suki_get_social_media_types( $sort = false ) {
	/**
	 * Filter: suki/dataset/social_media_types
	 *
	 * @param array $fonts Social media array.
	 */
	$social_types = apply_filters(
		'suki/dataset/social_media_types',
		array(
			// Social network.
			'facebook'  => 'Facebook',
			'instagram' => 'Instagram',
			'linkedin'  => 'LinkedIn',
			'twitter'   => 'Twitter',
			'pinterest' => 'Pinterest',
			'vk'        => 'VK',

			// Portfolio.
			'behance'   => 'Behance',
			'dribbble'  => 'Dribbble',

			// Publishing.
			'medium'    => 'Medium',
			'wordpress' => 'WordPress',

			// Messenger.
			'messenger' => 'Messenger',
			'skype'     => 'Skype',
			'slack'     => 'Slack',
			'telegram'  => 'Telegram',
			'whatsapp'  => 'WhatsApp',

			// Programming.
			'github'    => 'GitHub',
			'gitlab'    => 'GitLab',
			'bitbucket' => 'Bitbucket',

			// Audio & Video.
			'vimeo'     => 'Vimeo',
			'youtube'   => 'Youtube',

			// Others.
			'rss'       => 'RSS',
		)
	);

	if ( $sort ) {
		ksort( $social_types );
	}

	return $social_types;
}

/**
 * Return array of icons choices.
 *
 * @return array
 */
function suki_get_all_icons() {
	/**
	 * Filter: suki/dataset/icons
	 *
	 * @param array $icons Icons array.
	 */
	$icons = apply_filters(
		'suki/dataset/icons',
		array(
			'theme_icons'  => array(
				'search'        => esc_html_x( 'Search', 'icon label', 'suki' ),
				'close'         => esc_html_x( 'Close', 'icon label', 'suki' ),
				'menu'          => esc_html_x( 'Menu', 'icon label', 'suki' ),
				'chevron-down'  => esc_html_x( 'Dropdown Arrow -- Down', 'icon label', 'suki' ),
				'chevron-right' => esc_html_x( 'Dropdown Arrow -- Right', 'icon label', 'suki' ),
				'cart'          => esc_html_x( 'Shopping Cart', 'icon label', 'suki' ),
			),
			'social_icons' => suki_get_social_media_types( true ),
		)
	);

	return $icons;
}

/**
 * Return array of image sizes.
 *
 * @return array
 */
function suki_get_all_image_sizes() {
	$labels = array(
		'thumbnail'    => esc_html__( 'Thumbnail', 'suki' ),
		'medium'       => esc_html__( 'Medium', 'suki' ),
		'medium_large' => esc_html__( 'Medium Large', 'suki' ),
		'large'        => esc_html__( 'Large', 'suki' ),
	);

	$sizes = array(
		'full' => esc_html__( 'Full', 'suki' ),
	);

	foreach ( get_intermediate_image_sizes() as $slug ) {
		if ( isset( $labels[ $slug ] ) ) {
			$sizes[ $slug ] = $labels[ $slug ];
		} else {
			$sizes[ $slug ] = $slug;
		}
	}

	return $sizes;
}
