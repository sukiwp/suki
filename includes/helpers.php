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
	 * Get the template part.
	 */

	ob_start();
	load_template( $template_file_path, false );
	$html = ob_get_clean();

	// Allow filters to modify the HTML markup.
	$html = apply_filters( 'suki/template_part/' . $slug . ( ! empty( $name ) ? '-' . $name : '' ), $html );

	/**
	 * Return or print the template part.
	 */

	if ( $echo ) {
		echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	} else {
		return $html;
	}
}

/**
 * Wrapper function to get page setting of specified key.
 *
 * @param string $key
 * @param mixed $default
 * @return array
 */
function suki_get_current_page_setting( $key, $default = null ) {
	// Return null if no key specified.
	if ( empty( $key ) ) {
		return null;
	}

	$settings = array();
	$value = null;

	// Search results page and not archive (WooCommerce search results page is considered as archive).
	if ( is_search() && ! is_archive() ) {
		$value = suki_get_theme_mod( 'search_results_' . $key );
	}

	// Error 404 page
	elseif ( is_404() ) {
		// Set content container and content layout to a fixed value.
		$fixed_settings = array(
			'hero'              => 0,
			'content_container' => 'narrow', // Error 404 page always uses Narrow layout.
			'content_layout'    => 'wide', // Error 404 page always has no sidebar.
		);

		// Use fixed settings if specified key is either "content_container" or "content_layout.
		if ( isset( $fixed_settings[ $key ] ) ) {
			$value = $fixed_settings[ $key ];
		}
		// Otherwise, use the Customizer value.
		else {
			$value = suki_get_theme_mod( 'error_404_' . $key );
		}
	}

	// All kind of posts archive pages
	elseif ( is_home() || is_category() || is_tag() || is_date() || is_author() ) {
		$value = suki_get_theme_mod( 'post_archive_' . $key );
	}

	// Other post types index page
	elseif ( is_post_type_archive() ) {
		$obj = get_queried_object();

		if ( $obj ) {
			$value = suki_get_theme_mod( $obj->name . '_archive_' . $key );
		} else {
			$value = null;
		}
	}
		
	// Custom taxonomy archive pages
	elseif ( is_tax() ) {
		$obj = get_queried_object();

		if ( $obj ) {
			global $wp_taxonomies;

			// Get post type.
			$post_types = $wp_taxonomies[ $obj->taxonomy ]->object_type;
			$post_type = $post_types[0];

			// Get settings on the individual term.
			$individual_settings = wp_parse_args( get_term_meta( $obj->term_id, 'suki_page_settings', true ), array() );

			// Use individual settings if option is specified.
			if ( isset( $individual_settings[ $key ] ) ) {
				$value = $individual_settings[ $key ];
			}
			// Otherwise, use the Customizer value.
			else {
				$value = suki_get_theme_mod( $post_type . '_archive_' . $key );
			}
		} else {
			$value = null;
		}
	}

	// Single post page (any post type)
	elseif ( is_singular() ) {
		$obj = get_queried_object();

		if ( $obj ) {
			// Get settings on the individual post.
			$individual_settings = wp_parse_args( get_post_meta( $obj->ID, '_suki_page_settings', true ), array() );

			// Use individual settings if option is specified.
			if ( isset( $individual_settings[ $key ] ) ) {
				$value = $individual_settings[ $key ];
			}
			// Otherwise, use the Customizer value.
			else {
				$value = suki_get_theme_mod( $obj->post_type . '_single_' . $key );
			}
		} else {
			$value = null;
		}
	}

	// If the value is empty, try to use the global value.
	if ( '' === $value || is_null( $value ) ) {
		$value = suki_get_theme_mod( $key, $default );
	}

	// Allow developers to modify the value via filters.
	$value = apply_filters( 'suki/page_settings/setting_value', $value, $key );
	$value = apply_filters( 'suki/page_settings/setting_value/' . $key, $value );

	// Return the final value.
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
		'hero' => array(
			'label'    => esc_html__( 'Hero Section Layout', 'suki' ),
			'category' => 'layout',
			'actions'  => array(
				'settings' => array(
					'label' => esc_html__( 'Customize', 'suki' ),
					'url'   => add_query_arg( array( 'autofocus[section]' => 'suki_section_hero' ), admin_url( 'customize.php' ) ),
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
			'label'    => esc_html__( 'Footer Layout', 'suki' ),
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
		'sidebar-sticky' => array(
			'label'    => esc_html__( 'Sticky Sidebar', 'suki' ),
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
	) );
}

/**
 * Return list of post types that support Page Settings.
 *
 * @param string $context
 * @return array
 */
function suki_get_post_types_for_page_settings( $context = 'all' ) {
	// Native post types
	$native_post_types = array( 'post', 'page' );

	// Custom post types
	$custom_post_types = get_post_types( array(
		'public'             => true,
		'publicly_queryable' => true,
		'rewrite'            => true,
		'_builtin'           => false,
	), 'names' );
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
 * Return array of configuration for header builder interface in Customizer.
 *
 * @return array
 */
function suki_get_header_builder_configurations() {
	$array = apply_filters( 'suki/dataset/header_builder_configurations', array(
		'locations' => array(
			'top_left'      => is_rtl() ? esc_html__( 'Top - Right', 'suki' ) : esc_html__( 'Top - Left', 'suki' ),
			'top_center'    => esc_html__( 'Top - Center', 'suki' ),
			'top_right'     => is_rtl() ? esc_html__( 'Top - Left', 'suki' ) : esc_html__( 'Top - Right', 'suki' ),
			'main_left'     => is_rtl() ? esc_html__( 'Main - Right', 'suki' ) : esc_html__( 'Main - Left', 'suki' ),
			'main_center'   => esc_html__( 'Main - Center', 'suki' ),
			'main_right'    => is_rtl() ? esc_html__( 'Main - Left', 'suki' ) : esc_html__( 'Main - Right', 'suki' ),
			'bottom_left'   => is_rtl() ? esc_html__( 'Bottom - Right', 'suki' ) : esc_html__( 'Bottom - Left', 'suki' ),
			'bottom_center' => esc_html__( 'Bottom - Center', 'suki' ),
			'bottom_right'  => is_rtl() ? esc_html__( 'Bottom - Left', 'suki' ) : esc_html__( 'Bottom - Right', 'suki' ),
		),
		'choices' => array(
			'logo'            => '<span class="dashicons dashicons-admin-home"></span>' . esc_html__( 'Logo', 'suki' ),
			/* translators: %s: instance number. */
			'menu-1'          => '<span class="dashicons dashicons-admin-links"></span>' . sprintf( esc_html__( 'Menu %s', 'suki' ), 1 ),
			/* translators: %s: instance number. */
			'html-1'          => '<span class="dashicons dashicons-editor-code"></span>' . sprintf( esc_html__( 'HTML %s', 'suki' ), 1 ),
			'search-bar'      => '<span class="dashicons dashicons-search"></span>' . esc_html__( 'Search Bar', 'suki' ),
			'search-dropdown' => '<span class="dashicons dashicons-search"></span>' . esc_html__( 'Search Dropdown', 'suki' ),
			'social'          => '<span class="dashicons dashicons-twitter"></span>' . esc_html__( 'Social', 'suki' ),
			'breadcrumb'      => '<span class="dashicons dashicons-networking"></span>' . esc_html__( 'Breadcrumb', 'suki' ),
		),
		'limitations' => array(),
	) );

	ksort( $array['choices'] );

	return $array;
}

/**
 * Return array of configuration for mobile header builder interface in Customizer.
 *
 * @return array
 */
function suki_get_mobile_header_builder_configurations() {
	$array = apply_filters( 'suki/dataset/mobile_header_builder_configurations', array(
		'locations' => array(
			'main_left'    => is_rtl() ? esc_html__( 'Mobile - Right', 'suki' ) : esc_html__( 'Mobile - Left', 'suki' ),
			'main_center'  => esc_html__( 'Mobile - Center', 'suki' ),
			'main_right'   => is_rtl() ? esc_html__( 'Mobile - Left', 'suki' ) : esc_html__( 'Mobile - Right', 'suki' ),
			'vertical_top' => esc_html__( 'Mobile - Popup', 'suki' ),
		),
		'choices' => array(
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
	) );

	ksort( $array['choices'] );

	return $array;
}

/**
 * Return array of configuration for footer builder interface in Customizer.
 *
 * @return array
 */
function suki_get_footer_builder_configurations() {
	$array = apply_filters( 'suki/dataset/footer_builder_configurations', array(
		'locations' => array(
			'bottom_left'   => is_rtl() ? esc_html__( 'Right', 'suki' ) : esc_html__( 'Left', 'suki' ),
			'bottom_center' => esc_html__( 'Center', 'suki' ),
			'bottom_right'  => is_rtl() ? esc_html__( 'Left', 'suki' ) : esc_html__( 'Right', 'suki' ),
		),
		'choices' => array(
			'copyright' => '<span class="dashicons dashicons-editor-code"></span>' . esc_html__( 'Copyright', 'suki' ),
			/* translators: %s: instance number. */
			'menu-1'    => '<span class="dashicons dashicons-admin-links"></span>' . sprintf( esc_html__( 'Footer Menu %s', 'suki' ), 1 ),
			/* translators: %s: instance number. */
			'html-1'    => '<span class="dashicons dashicons-editor-code"></span>' . sprintf( esc_html__( 'HTML %s', 'suki' ), 1 ),
			'social'    => '<span class="dashicons dashicons-twitter"></span>' . esc_html__( 'Social', 'suki' ),
		),
	) );

	ksort( $array['choices'] );

	return $array;
}

/**
 * Return default theme colors.
 *
 * @return array
 */
function suki_get_default_colors() {
	return apply_filters( 'suki/dataset/default_colors', array(
		'transparent'       => 'rgba(0,0,0,0)',
		'white'             => '#ffffff',
		'black'             => '#000000',
		'accent'            => '#0066cc',
		'accent2'           => '#004c99',
		'bg'                => '#ffffff',
		'text'              => '#666666',
		'heading'           => '#333333',
		'subtle'            => 'rgba(0,0,0,0.05)',
		'border'            => 'rgba(0,0,0,0.1)',
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
	$json = file_get_contents( SUKI_INCLUDES_DIR . '/lists/google-fonts.json' );
	
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
 * @param boolean $sort
 * @return array
 */
function suki_get_social_media_types( $sort = false ) {
	$types = apply_filters( 'suki/dataset/social_media_types', array(
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

	if ( $sort ) {
		ksort( $types );
	}

	return $types;
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
			'cart' => esc_html_x( 'Shopping Cart', 'icon label', 'suki' ),
		),
		'social_icons' => suki_get_social_media_types( true ),
	) );
}

/**
 * Return array of image sizes.
 * 
 * @return array
 */
function suki_get_all_image_sizes() {
	$labels = array(
		'thumbnail' => esc_html__( 'Thumbnail', 'suki' ),
		'medium' => esc_html__( 'Medium', 'suki' ),
		'medium_large' => esc_html__( 'Medium Large', 'suki' ),
		'large' => esc_html__( 'Large', 'suki' ),
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

/**
 * Check if Block Editor is active.
 * Must only be used after plugins_loaded action is fired.
 *
 * @return bool
 */
function suki_get_editor_active() {
    // Gutenberg plugin is installed and activated.
    $gutenberg = ! ( false === has_filter( 'replace_editor', 'gutenberg_init' ) );

    // Block editor since 5.0.
    $block_editor = version_compare( $GLOBALS['wp_version'], '5.0-beta', '>' );

    if ( ! $gutenberg && ! $block_editor ) {
        return false;
    }

    if ( get_classic_editor_plugin_active() ) {
        $editor_option       = get_option( 'classic-editor-replace' );
        $block_editor_active = array( 'no-replace', 'block' );

        return in_array( $editor_option, $block_editor_active, true );
    }

    return true;
}

/**
 * Check if Classic Editor plugin is active.
 *
 * @return bool
 */
function get_classic_editor_plugin_active() {
    if ( ! function_exists( 'is_plugin_active' ) ) {
        include_once ABSPATH . 'wp-admin/includes/plugin.php';
    }

    if ( is_plugin_active( 'classic-editor/classic-editor.php' ) ) {
        return true;
    }

    return false;
}