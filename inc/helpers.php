<?php
/**
 * Custom helper functions that can be used globally.
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
 * Check if specified key exists on an array, then return the value.
 * Otherwise return the specified fallback value, or null if no fallback is specified.
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
 * Recursively flatten a multi-dimensional array into a one-dimensional array.
 *
 * @param array @array
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

	return apply_filters( 'suki/pro/show_teaser', $show );
}

/**
 * Modified version of the original `get_template_part` function.
 * Add filters to allow 3rd party plugins to override the template files.
 *
 * @param string $slug
 * @param string $name
 * @param array $variables
 * @param boolean $echo
 */
function suki_get_template_part( $slug, $name = null, $variables = array(), $echo = true ) {
	/**
	 * Get fallback template file name.
	 */

	// Native WordPress action.
	do_action( 'get_template_part_' . $slug, $slug, $name );

	$templates = array();
	if ( isset( $name ) ) {
		$templates[] = $slug . '-' . $name . '.php';
	}

	$templates[] = $slug . '.php';

	// Native WordPress action.
	do_action( 'get_template_part', $slug, $name, $templates );

	/**
	 * Get the final template file path.
	 */

	$template_file_path = false;

	// Iterate through the templates.
	foreach ( $templates as $template ) {
		/**
		 * Child Theme
		 */

		// Check the template file in Child Theme.
		if ( file_exists( get_stylesheet_directory() . '/template-parts/' . $template ) ) {
			$template_file_path = get_stylesheet_directory() . '/template-parts/' . $template;
			break;
		}

		/**
		 * Custom paths
		 */

		// Allow themes or plugins to add their own paths.
		$custom_paths = apply_filters( 'suki/frontend/template_dirs', array() );

		// Sort the custom paths by key number.
		// Lower key number = higher priority.
		ksort( $custom_paths );

		// Iterate through the custom paths and use the path if it exists.
		foreach ( $custom_paths as $custom_path ) {
			$temp = trailingslashit( $custom_path ) . $template;

			if ( file_exists( $temp ) ) {
				$template_file_path = $temp;
				break 2; // break from 2 iteration levels, which are the $custom path and $templates.
			}
		}

		/**
		 * Parent Theme
		 */

		// Check the template file in Parent Theme.
		if ( file_exists( get_template_directory() . '/template-parts/' . $template ) ) {
			$template_file_path = get_template_directory() . '/template-parts/' . $template;
			break;
		}

		// Last resort, check the template file in WordPress theme compatibility files (very unlikely to reach here).
		elseif ( file_exists( ABSPATH . WPINC . '/theme-compat/' . $template ) ) {
			$template_file_path = ABSPATH . WPINC . '/theme-compat/' . $template;
			break;
		}
	}

	// Abort if no valid template file found.
	if ( empty( $template_file_path ) ) {
		return;
	}

	/**
	 * Pass custom variables to the template file.
	 */

	foreach ( (array) $variables as $key => $value ) {
		set_query_var( $key, $value );
	}

	/**
	 * Return or print the template part.
	 */

	if ( ! $echo ) {
		ob_start();
	}

	load_template( $template_file_path, false );

	if ( ! $echo ) {
		return ob_get_clean();
	}
}

/**
 * Wrapper function to get page setting value of the specified post ID.
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

	// Get the value.
	$value = suki_array_value( $settings, $key, '' );

	// Get fallback settings.
	$fallback_settings = suki_get_fallback_page_settings();

	// If the setting value is empty string and it has fallback value, use fallback value.
	if ( '' === $value && array_key_exists( $key, $fallback_settings ) ) {
		$value = suki_array_value( $fallback_settings, $key );
	}

	return $value;
}

/**
 * Wrapper function to get page setting of specified key.
 *
 * @param string $key
 * @return array
 */
function suki_get_current_page_setting( $key ) {
	$settings = array();

	// Blog posts index page
	if ( is_home() ) {
		$settings = suki_get_theme_mod( 'page_settings_post_archive', array() );
	}

	// Search page
	elseif ( is_search() ) {
		$settings = suki_get_theme_mod( 'page_settings_search', array() );
	}

	// Other post types index page
	elseif ( is_post_type_archive() ) {
		$obj = get_queried_object();

		if ( $obj ) {
			$settings = suki_get_theme_mod( 'page_settings_' . $obj->name . '_archive', array() );
		}
	}
		
	// Time based Archive page
	// Author based Archive page
	elseif ( is_date() || is_author() ) {
		$settings = suki_get_theme_mod( 'page_settings_post_archive', array() );
	}
		
	// Other archive page
	elseif ( is_archive() ) {
		$obj = get_queried_object();

		if ( $obj ) {
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
	}

	// Error 404 page
	elseif ( is_404() ) {
		$settings = suki_get_theme_mod( 'page_settings_error_404' );

		$settings = wp_parse_args( array(
			'content_container' => 'narrow', // Error 404 page always uses Narrow layout.
			'content_layout'    => 'wide', // Error 404 page always has no sidebar.
		), $settings );
	}

	// Single post page (any post type)
	elseif ( is_singular() ) {
		$obj = get_queried_object();

		if ( $obj ) {
			$settings = wp_parse_args( get_post_meta( $obj->ID, '_suki_page_settings', true ), suki_get_theme_mod( 'page_settings_' . $obj->post_type . '_singular', array() ) );
		}
	}

	// Get the value.
	$value = suki_array_value( $settings, $key, '' );

	// Get fallback settings.
	$fallback_settings = suki_get_fallback_page_settings();

	// If the setting value is empty string and it has fallback value, use fallback value.
	if ( '' === $value && array_key_exists( $key, $fallback_settings ) ) {
		$value = suki_array_value( $fallback_settings, $key );
	}

	$value = apply_filters( 'suki/page_settings/setting_value', $value, $key );
	$value = apply_filters( 'suki/page_settings/setting_value/' . $key, $value );

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
 * modified:
 * - add: rem to units
 * - add: remove space after (
 * - remove: remove space before (
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

	// Remove space after , : ; { } ( */ >
	$css = preg_replace( '/(,|:|;|\{|}|\(|\*\/|>) /', '$1', $css );

	// Remove space before , ; { } ) >
	$css = preg_replace( '/ (,|;|\{|}|\)|>)/', '$1', $css );

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
 * @param boolean $minify
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
			$final_css .= $media. '{';
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

	if ( $minify ) {
		$final_css = suki_minify_css_string( $final_css );
	}

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
	$link = ( is_ssl() ? 'https:' : 'http:' ) . '//fonts.googleapis.com/css';
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

	return esc_attr( add_query_arg( $args, $link ) );
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
	return apply_filters( 'suki/module_categories', array(
		'layout'      => esc_html__( 'Layout Modules', 'suki' ),
		'assets'      => esc_html__( 'Assets & Branding Modules', 'suki' ),
		'blog'        => esc_html__( 'Blog Modules', 'suki' ),
		'woocommerce' => esc_html__( 'WooCommerce Integration Modules', 'suki' ),
	) );
}

/**
 * Return array of default Suki theme modules.
 * 
 * @return array
 */
function suki_get_theme_modules() {
	return array(
		'page-container' => array(
			'label'    => esc_html__( 'Page Canvas Layout', 'suki' ),
			'category' => 'layout',
			'actions'  => array(
				'settings' => array(
					'label' => esc_html__( 'Customize', 'suki' ),
					'url'   => add_query_arg( array( 'autofocus[section]' => 'suki_section_page_container' ), admin_url( 'customize.php' ) ),
				),
			),
		),
		'header' => array(
			'label'    => esc_html__( 'Header Layout', 'suki' ),
			'category' => 'layout',
			'actions'  => array(
				'settings' => array(
					'label' => esc_html__( 'Customize', 'suki' ),
					'url'   => add_query_arg( array( 'autofocus[panel]' => 'suki_panel_header' ), admin_url( 'customize.php' ) ),
				),
			),
		),
		'page-header' => array(
			'label'    => esc_html__( 'Page Header Layout', 'suki' ),
			'category' => 'layout',
			'actions'  => array(
				'settings' => array(
					'label' => esc_html__( 'Customize', 'suki' ),
					'url'   => add_query_arg( array( 'autofocus[section]' => 'suki_section_page_header' ), admin_url( 'customize.php' ) ),
				),
			),
		),
		'content-sidebar' => array(
			'label'    => esc_html__( 'Content & Sidebar Layout', 'suki' ),
			'category' => 'layout',
			'actions'  => array(
				'settings' => array(
					'label' => esc_html__( 'Customize', 'suki' ),
					'url'   => add_query_arg( array( 'autofocus[panel]' => 'suki_panel_content' ), admin_url( 'customize.php' ) ),
				),
			),
		),
		'footer' => array(
			'label'    => esc_html__( 'Footer Builder', 'suki' ),
			'category' => 'layout',
			'actions'  => array(
				'settings' => array(
					'label' => esc_html__( 'Customize', 'suki' ),
					'url'   => add_query_arg( array( 'autofocus[panel]' => 'suki_panel_footer' ), admin_url( 'customize.php' ) ),
				),
			),
		),
		'page-settings' => array(
			'label'    => esc_html__( 'Dynamic Page Layout', 'suki' ),
			'category' => 'layout',
			'actions'  => array(
				'settings' => array(
					'label' => esc_html__( 'Customize', 'suki' ),
					'url'   => add_query_arg( array( 'autofocus[panel]' => 'suki_panel_page_settings' ), admin_url( 'customize.php' ) ),
				),
			),
		),

		'color-palette' => array(
			'label'    => esc_html__( 'Color Palette', 'suki' ),
			'category' => 'assets',
			'actions'  => array(
				'settings' => array(
					'label' => esc_html__( 'Customize', 'suki' ),
					'url'   => add_query_arg( array( 'autofocus[section]' => 'suki_section_color_palette' ), admin_url( 'customize.php' ) ),
				),
			),
		),
		'general-styles' => array(
			'label'    => esc_html__( 'General Typography & Colors', 'suki' ),
			'category' => 'assets',
			'actions'  => array(
				'settings' => array(
					'label' => esc_html__( 'Customize', 'suki' ),
					'url'   => add_query_arg( array( 'autofocus[panel]' => 'suki_panel_general_styles' ), admin_url( 'customize.php' ) ),
				),
			),
		),
		'google-fonts' => array(
			'label'    => esc_html__( 'Google Fonts', 'suki' ),
			'category' => 'assets',
			'actions'  => array(
				'settings' => array(
					'label' => esc_html__( 'Customize', 'suki' ),
					'url'   => add_query_arg( array( 'autofocus[section]' => 'suki_section_google_fonts' ), admin_url( 'customize.php' ) ),
				),
			),
		),
		'social-links' => array(
			'label'    => esc_html__( 'Social Links', 'suki' ),
			'category' => 'assets',
			'actions'  => array(
				'settings' => array(
					'label' => esc_html__( 'Customize', 'suki' ),
					'url'   => add_query_arg( array( 'autofocus[section]' => 'suki_section_social' ), admin_url( 'customize.php' ) ),
				),
			),
		),

		'blog' => array(
			'label'    => esc_html__( 'Blog Layout Basic', 'suki' ),
			'category' => 'blog',
			'actions'  => array(
				'settings' => array(
					'label' => esc_html__( 'Customize', 'suki' ),
					'url'   => add_query_arg( array( 'autofocus[panel]' => 'suki_panel_blog' ), admin_url( 'customize.php' ) ),
				),
			),
		),

		'woocommerce' => array(
			'label'    => esc_html__( 'WC Layout Basic', 'suki' ),
			'category' => 'woocommerce',
			'actions'  => array(
				'settings' => array(
					'label' => esc_html__( 'Customize', 'suki' ),
					'url'   => add_query_arg( array( 'autofocus[panel]' => 'woocommerce' ), admin_url( 'customize.php' ) ),
				),
			),
		),
	);
}

/**
 * Return array of supported Suki Pro modules.
 * 
 * @return array
 */
function suki_get_pro_modules() {
	$url = add_query_arg( array( 'utm_source' => 'suki-dashboard', 'utm_medium' => 'learn-more', 'utm_campaign' => 'theme-pro-modules-list' ), trailingslashit( SUKI_PRO_URL ) );

	return apply_filters( 'suki/pro/modules', array(
		'header-elements-plus' => array(
			'label'    => esc_html__( 'Header Elements Plus', 'suki' ),
			'category' => 'layout',
		),
		'header-vertical' => array(
			'label'    => esc_html__( 'Vertical Header', 'suki' ),
			'category' => 'layout',
		),
		'header-transparent' => array(
			'label'    => esc_html__( 'Transparent Header', 'suki' ),
			'category' => 'layout',
		),
		'header-sticky' => array(
			'label'    => esc_html__( 'Sticky Header', 'suki' ),
			'category' => 'layout',
		),
		'header-alt-colors' => array(
			'label'    => esc_html__( 'Alternate Header Colors', 'suki' ),
			'category' => 'layout',
		),
		'header-mega-menu' => array(
			'label'    => esc_html__( 'Header Mega Menu', 'suki' ),
			'category' => 'layout',
		),
		'footer-widgets-columns-width' => array(
			'label'    => esc_html__( 'Footer Widgets Columns Width', 'suki' ),
			'category' => 'layout',
		),
		'preloader-screen' => array(
			'label'    => esc_html__( 'Preloader Screen', 'suki' ),
			'category' => 'layout',
		),
		'custom-blocks' => array(
			'label'    => esc_html__( 'Custom Blocks (Hooks)', 'suki' ),
			'category' => 'layout',
		),

		'custom-fonts' => array(
			'label'    => esc_html__( 'Custom Fonts', 'suki' ),
			'category' => 'assets',
		),
		'custom-icons' => array(
			'label'    => esc_html__( 'Custom Icons', 'suki' ),
			'category' => 'assets',
		),
		'white-label' => array(
			'label'    => esc_html__( 'White Label', 'suki' ),
			'category' => 'assets',
		),

		'woocommerce-layout-plus' => array(
			'label'    => esc_html__( 'WC Layout Plus', 'suki' ),
			'category' => 'woocommerce',
		),
		'woocommerce-ajax-add-to-cart' => array(
			'label'    => esc_html__( 'WC AJAX Add To Cart', 'suki' ),
			'category' => 'woocommerce',
		),
		'woocommerce-quick-view' => array(
			'label'    => esc_html__( 'WC Quick View', 'suki' ),
			'category' => 'woocommerce',
		),
		'woocommerce-off-canvas-filters' => array(
			'label'    => esc_html__( 'WC Off-Canvas Filters', 'suki' ),
			'category' => 'woocommerce',
		),
		'woocommerce-checkout-optimization' => array(
			'label'    => esc_html__( 'WC Checkout Optimization', 'suki' ),
			'category' => 'woocommerce',
		),

		'blog-layout-plus' => array(
			'label'    => esc_html__( 'Blog Layout Plus', 'suki' ),
			'category' => 'blog',
		),
		'blog-featured-posts' => array(
			'label'    => esc_html__( 'Blog Featured Posts', 'suki' ),
			'category' => 'blog',
		),
		'blog-related-posts' => array(
			'label'    => esc_html__( 'Blog Related Posts', 'suki' ),
			'category' => 'blog',
		),
	) );
}

/**
 * Return fallback values of page settings.
 * 
 * @return array
 */
function suki_get_fallback_page_settings() {
	return apply_filters( 'suki/dataset/fallback_page_settings', array(
		'content_container'     => suki_get_theme_mod( 'content_container', 'default' ),
		'content_layout'        => suki_get_theme_mod( 'content_layout', 'right-sidebar' ),
		'content_header_layout' => suki_get_theme_mod( 'content_header_layout', 'before_main' ),
		'page_header'           => suki_get_theme_mod( 'page_header', 0 ),
		'page_header_bg_image'  => suki_get_theme_mod( 'page_header_bg_image', '' ),
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
		'custom_fonts'   => array(),
		'google_fonts'   => suki_get_google_fonts(),
	) );
}

/**
 * Return array of selected Google Fonts list.
 * Selected fonts are configurable from Appearance > Suki > Settings > Fonts page.
 * 
 * @return array
 */
function suki_get_google_fonts() {
	global $wp_filesystem;
	if ( empty( $wp_filesystem ) ) {
		require_once ABSPATH . '/wp-admin/includes/file.php';
		WP_Filesystem();
	}

	$json = $wp_filesystem->get_contents( SUKI_INCLUDES_DIR . '/lists/google-fonts.json' );
	
	return json_decode( $json, true );
}

/**
 * Return array of Google Fonts subsets.
 * 
 * @return array
 */
function suki_get_google_fonts_subsets() {
	return array(
		// 'latin' always chosen by default
		'latin-ext' => 'Latin Extended',
		'arabic' => 'Arabic',
		'bengali' => 'Bengali',
		'cyrillic' => 'Cyrillic',
		'cyrillic-ext' => 'Cyrillic Extended',
		'devaganari' => 'Devaganari',
		'greek' => 'Greek',
		'greek-ext' => 'Greek Extended',
		'gujarati' => 'Gujarati',
		'gurmukhi' => 'Gurmukhi',
		'hebrew' => 'Hebrew',
		'kannada' => 'Kannada',
		'khmer' => 'Khmer',
		'malayalam' => 'Malayalam',
		'myanmar' => 'Myanmar',
		'oriya' => 'Oriya',
		'sinhala' => 'Sinhala',
		'tamil' => 'Tamil',
		'telugu' => 'Telugu',
		'thai' => 'Thai',
		'vietnamese' => 'Vietnamese',
	);
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
 * @param boolean $group
 * @return array
 */
function suki_get_social_media_types( $group = false ) {
	return apply_filters( 'suki/dataset/social_media_types', array(
		// Social network
		'facebook' => 'Facebook',
		'instagram' => 'Instagram',
		// 'google-plus' => 'Google+',
		'linkedin' => 'LinkedIn',
		'twitter' => 'Twitter',
		'pinterest' => 'Pinterest',
		'vk' => 'VK',

		// Portfolio
		'behance' => 'Behance',
		'dribbble' => 'Dribbble',

		// Publishing
		'medium' => 'Medium',
		'wordpress' => 'WordPress',

		// Messenger
		'messenger' => 'Messenger',
		'skype' => 'Skype',
		'slack' => 'Slack',
		'telegram' => 'Telegram',
		'whatsapp' => 'WhatsApp',

		// Programming
		'github' => 'GitHub',
		'gitlab' => 'GitLab',
		'bitbucket' => 'Bitbucket',

		// Audio & Video
		'vimeo' => 'Vimeo',
		'youtube' => 'Youtube',

		// Others
		'rss' => 'RSS',
	) );
}

/**
 * Return array of icons choices.
 * 
 * @return array
 */
function suki_get_all_icons() {
	return apply_filters( 'suki/dataset/all_icons', array(
		'theme_icons' => array(
			'search' => esc_html_x( 'Search', 'icon label', 'suki' ),
			'close' => esc_html_x( 'Close', 'icon label', 'suki' ),
			'menu' => esc_html_x( 'Menu', 'icon label', 'suki' ),
			'chevron-down' => esc_html_x( 'Dropdown Arrow -- Down', 'icon label', 'suki' ),
			'chevron-right' => esc_html_x( 'Dropdown Arrow -- Right', 'icon label', 'suki' ),
			'shopping-cart' => esc_html_x( 'Shopping Cart', 'icon label', 'suki' ),
		),
		'social_icons' => suki_get_social_media_types(),
	) );
}