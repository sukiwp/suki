<?php
/**
 * Functions that return dataset.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ====================================================
 * Dataset functions
 * ====================================================
 */

/**
 * Return array of module categories.
 *
 * @return array
 */
function suki_get_module_categories() {
	return array(
		'layout'      => esc_html__( 'Layout', 'suki' ),
		'assets'      => esc_html__( 'Assets and Branding', 'suki' ),
		'seo'         => esc_html__( 'SEO and Performance', 'suki' ),
		'blog'        => esc_html__( 'Blog', 'suki' ),
		'woocommerce' => esc_html__( 'WooCommerce', 'suki' ),
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
				'label'    => esc_html__( 'Custom Blocks', 'suki' ),
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
		suki_get_default_social_media_types()
	);

	if ( $sort ) {
		ksort( $social_types );
	}

	return $social_types;
}

/**
 * Return array of default social media types.
 *
 * @return array
 */
function suki_get_default_social_media_types() {
	return array(
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
	);
}

/**
 * Return array of UI icon names.
 */
function suki_get_ui_icon_types() {
	/**
	 * Filter: suki/dataset/icons
	 *
	 * @param array $icons Icons array.
	 */
	$icons = apply_filters(
		'suki/dataset/icons',
		array(
			// UI icons.
			'search'        => esc_html_x( 'Search', 'icon label', 'suki' ),
			'close'         => esc_html_x( 'Close', 'icon label', 'suki' ),
			'menu'          => esc_html_x( 'Menu', 'icon label', 'suki' ),
			'chevron-down'  => esc_html_x( 'Dropdown Arrow -- Down', 'icon label', 'suki' ),
			'chevron-right' => esc_html_x( 'Dropdown Arrow -- Right', 'icon label', 'suki' ),
			'cart'          => esc_html_x( 'Shopping Cart', 'icon label', 'suki' ),

			// Pro UI icons.
			'address'       => esc_html_x( 'Address', 'icon label', 'suki' ),
			'email'         => esc_html_x( 'Email', 'icon label', 'suki' ),
			'phone'         => esc_html_x( 'Phone', 'icon label', 'suki' ),
			'time'          => esc_html_x( 'Time', 'icon label', 'suki' ),
			'filter'        => esc_html_x( 'Filter', 'icon label', 'suki' ),
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

/**
 * Return array of desktop header builder areas.
 *
 * @return array
 */
function suki_get_header_builder_areas() {
	/**
	 * Filter: suki/dataset/header_builder/areas
	 *
	 * @param array Array of areas for Header Builder.
	 */
	$areas = apply_filters(
		'suki/dataset/header_builder/areas',
		array(
			'top_left'      => array(
				'label'    => esc_html__( 'Top - Left', 'suki' ),
				'location' => 'horizontal',
			),
			'top_center'    => array(
				'label'    => esc_html__( 'Top - Center', 'suki' ),
				'location' => 'horizontal',
			),
			'top_right'     => array(
				'label'    => esc_html__( 'Top - Right', 'suki' ),
				'location' => 'horizontal',
			),
			'main_left'     => array(
				'label'    => esc_html__( 'Main - Left', 'suki' ),
				'location' => 'horizontal',
			),
			'main_center'   => array(
				'label'    => esc_html__( 'Main - Center', 'suki' ),
				'location' => 'horizontal',
			),
			'main_right'    => array(
				'label'    => esc_html__( 'Main - Right', 'suki' ),
				'location' => 'horizontal',
			),
			'bottom_left'   => array(
				'label'    => esc_html__( 'Bottom - Left', 'suki' ),
				'location' => 'horizontal',
			),
			'bottom_center' => array(
				'label'    => esc_html__( 'Bottom - Center', 'suki' ),
				'location' => 'horizontal',
			),
			'bottom_right'  => array(
				'label'    => esc_html__( 'Bottom - Right', 'suki' ),
				'location' => 'horizontal',
			),
		)
	);

	if ( ! is_array( $areas ) ) {
		$areas = array();
	}

	return $areas;
}

/**
 * Return array of desktop header builder elements.
 *
 * @return array
 */
function suki_get_header_builder_elements() {
	/**
	 * Filter: suki/dataset/header_builder/elements
	 *
	 * @param array Array of elements for Header Builder.
	 */
	$elements = apply_filters(
		'suki/dataset/header_builder/elements',
		array(
			'logo'            => array(
				'icon'              => 'admin-home',
				'label'             => esc_html__( 'Logo', 'suki' ),
				'unsupported_areas' => array(),
			),
			'menu-1'          => array(
				'icon'              => 'admin-links',
				/* translators: %s: instance number. */
				'label'             => sprintf( esc_html__( 'Menu %s', 'suki' ), 1 ),
				'unsupported_areas' => array(),
			),
			'html-1'          => array(
				'icon'              => 'editor-code',
				/* translators: %s: instance number. */
				'label'             => sprintf( esc_html__( 'HTML %s', 'suki' ), 1 ),
				'unsupported_areas' => array(),
			),
			'search-bar'      => array(
				'icon'              => 'search',
				'label'             => esc_html__( 'Search Bar', 'suki' ),
				'unsupported_areas' => array(),
			),
			'search-dropdown' => array(
				'icon'              => 'search',
				'label'             => esc_html__( 'Search Dropdown', 'suki' ),
				'unsupported_areas' => array(),
			),
			'social'          => array(
				'icon'              => 'twitter',
				'label'             => esc_html__( 'Social', 'suki' ),
				'unsupported_areas' => array(),
			),
		)
	);

	if ( ! is_array( $elements ) ) {
		$elements = array();
	}

	return $elements;
}

/**
 * Return array of mobile header builder areas.
 *
 * @return array
 */
function suki_get_header_mobile_builder_areas() {
	/**
	 * Filter: suki/dataset/header_mobile_builder/areas
	 *
	 * @param array Array of areas for Header Builder.
	 */
	$areas = apply_filters(
		'suki/dataset/header_mobile_builder/areas',
		array(
			'main_left'    => array(
				'label'    => esc_html__( 'Mobile - Left', 'suki' ),
				'location' => 'horizontal',
			),
			'main_center'  => array(
				'label'    => esc_html__( 'Mobile - Center', 'suki' ),
				'location' => 'horizontal',
			),
			'main_right'   => array(
				'label'    => esc_html__( 'Mobile - Right', 'suki' ),
				'location' => 'horizontal',
			),
			'vertical_top' => array(
				'label'    => esc_html__( 'Mobile - Popup', 'suki' ),
				'location' => 'vertical',
			),
		)
	);

	if ( ! is_array( $areas ) ) {
		$areas = array();
	}

	return $areas;
}

/**
 * Return array of mobile header builder elements.
 *
 * @return array
 */
function suki_get_header_mobile_builder_elements() {
	/**
	 * Filter: suki/dataset/header_mobile_builder/elements
	 *
	 * @param array Array of elements for Header Builder.
	 */
	$elements = apply_filters(
		'suki/dataset/header_mobile_builder/elements',
		array(
			'mobile-logo'            => array(
				'icon'              => 'admin-home',
				'label'             => esc_html__( 'Mobile Logo', 'suki' ),
				'unsupported_areas' => array( 'vertical_top' ),
			),
			'mobile-menu'            => array(
				'icon'              => 'admin-links',
				'label'             => esc_html__( 'Mobile Menu', 'suki' ),
				'unsupported_areas' => array( 'main_left', 'main_center', 'main_right' ),
			),
			'html-1'                 => array(
				'icon'              => 'editor-code',
				/* translators: %s: instance number. */
				'label'             => sprintf( esc_html__( 'HTML %s', 'suki' ), 1 ),
				'unsupported_areas' => array(),
			),
			'search-bar'             => array(
				'icon'              => 'search',
				'label'             => esc_html__( 'Search Bar', 'suki' ),
				'unsupported_areas' => array( 'main_left', 'main_center', 'main_right' ),
			),
			'search-dropdown'        => array(
				'icon'              => 'search',
				'label'             => esc_html__( 'Search Dropdown', 'suki' ),
				'unsupported_areas' => array( 'vertical_top' ),
			),
			'social'                 => array(
				'icon'              => 'twitter',
				'label'             => esc_html__( 'Social', 'suki' ),
				'unsupported_areas' => array(),
			),
			'mobile-vertical-toggle' => array(
				'icon'              => 'menu',
				'label'             => esc_html__( 'Toggle', 'suki' ),
				'unsupported_areas' => array( 'vertical_top' ),
			),
		)
	);

	if ( ! is_array( $elements ) ) {
		$elements = array();
	}

	return $elements;
}

/**
 * Return array of footer builder areas.
 *
 * @return array
 */
function suki_get_footer_builder_areas() {
	/**
	 * Filter: suki/dataset/footer_builder/areas
	 *
	 * @param array Array of areas for Footer Builder.
	 */
	$areas = apply_filters(
		'suki/dataset/footer_builder/areas',
		array(
			'bottom_left'   => array(
				'label'    => esc_html__( 'Left', 'suki' ),
				'location' => 'horizontal',
			),
			'bottom_center' => array(
				'label'    => esc_html__( 'Center', 'suki' ),
				'location' => 'horizontal',
			),
			'bottom_right'  => array(
				'label'    => esc_html__( 'Right', 'suki' ),
				'location' => 'horizontal',
			),
		)
	);

	if ( ! is_array( $areas ) ) {
		$areas = array();
	}

	return $areas;
}

/**
 * Return array of footer builder elements.
 *
 * @return array
 */
function suki_get_footer_builder_elements() {
	/**
	 * Filter: suki/dataset/footer_builder/elements
	 *
	 * @param array Array of elements for Footer Builder.
	 */
	$elements = apply_filters(
		'suki/dataset/footer_builder/elements',
		array(
			'copyright' => array(
				'icon'              => 'editor-code',
				'label'             => esc_html__( 'Copyright', 'suki' ),
				'unsupported_areas' => array(),
			),
			'menu-1'    => array(
				'icon'              => 'admin-links',
				/* translators: %s: instance number. */
				'label'             => sprintf( esc_html__( 'Footer Menu %s', 'suki' ), 1 ),
				'unsupported_areas' => array(),
			),
			'html-1'    => array(
				'icon'              => 'editor-code',
				/* translators: %s: instance number. */
				'label'             => sprintf( esc_html__( 'HTML %s', 'suki' ), 1 ),
				'unsupported_areas' => array(),
			),
			'social'    => array(
				'icon'              => 'twitter',
				'label'             => esc_html__( 'Social', 'suki' ),
				'unsupported_areas' => array(),
			),
		)
	);

	if ( ! is_array( $elements ) ) {
		$elements = array();
	}

	return $elements;
}

/**
 * Return array of SVG icons markup.
 *
 * @return array
 */
function suki_get_svg_icon_markups() {
	/**
	 * Filter: suki/dataset/svg_icons
	 *
	 * @param array Array of SVG icons markup.
	 */
	return apply_filters(
		'suki/dataset/svg_icon_markups',
		suki_get_default_svg_icon_markups()
	);
}

/**
 * Return array of default SVG icons markup.
 *
 * @return array
 */
function suki_get_default_svg_icon_markups() {
	return array(
		// UI icons.
		'search'        => '<svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 64 64"><path d="M26,46.1a20,20,0,1,1,20-20A20,20,0,0,1,26,46.1ZM63.4,58.5,48.2,43.3a3.67,3.67,0,0,0-2-.8A26.7,26.7,0,0,0,52,26a26,26,0,1,0-9.6,20.2,4.64,4.64,0,0,0,.8,2L58.4,63.4a1.93,1.93,0,0,0,2.8,0l2.1-2.1A1.86,1.86,0,0,0,63.4,58.5Z"/></svg>',
		'close'         => '<svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 64 64"><path d="M36.2,32,56,12.2a1.93,1.93,0,0,0,0-2.8L54.6,8a1.93,1.93,0,0,0-2.8,0L32,27.8,12.2,8A1.93,1.93,0,0,0,9.4,8L8,9.4a1.93,1.93,0,0,0,0,2.8L27.8,32,8,51.8a1.93,1.93,0,0,0,0,2.8L9.4,56a1.93,1.93,0,0,0,2.8,0L32,36.2,51.8,56a1.93,1.93,0,0,0,2.8,0L56,54.6a1.93,1.93,0,0,0,0-2.8Z"/></svg>',
		'menu'          => '<svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 64 64"><path d="M60,35H4a2,2,0,0,1-2-2V31a2,2,0,0,1,2-2H60a2,2,0,0,1,2,2v2A2,2,0,0,1,60,35Zm0-22H4a2,2,0,0,1-2-2V9A2,2,0,0,1,4,7H60a2,2,0,0,1,2,2v2A2,2,0,0,1,60,13Zm0,44H4a2,2,0,0,1-2-2V53a2,2,0,0,1,2-2H60a2,2,0,0,1,2,2v2A2,2,0,0,1,60,57Z"/></svg>',
		'chevron-down'  => '<svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 64 64"><path d="M32,43.71a3,3,0,0,1-2.12-.88L12.17,25.12a2,2,0,0,1,0-2.83l1.42-1.41a2,2,0,0,1,2.82,0L32,36.47,47.59,20.88a2,2,0,0,1,2.82,0l1.42,1.41a2,2,0,0,1,0,2.83L34.12,42.83A3,3,0,0,1,32,43.71Z"/></svg>',
		'chevron-right' => '<svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 64 64"><path d="M43.71,32a3,3,0,0,1-.88,2.12L25.12,51.83a2,2,0,0,1-2.83,0l-1.41-1.42a2,2,0,0,1,0-2.82L36.47,32,20.88,16.41a2,2,0,0,1,0-2.82l1.41-1.42a2,2,0,0,1,2.83,0L42.83,29.88A3,3,0,0,1,43.71,32Z"/></svg>',
		'cart'          => '<svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 64 64"><circle cx="20" cy="58" r="6"/><circle cx="46" cy="58" r="6"/><path d="M63.41,11.2A3,3,0,0,0,61,10H14.84L14,2.6A3,3,0,0,0,11,0H2A2,2,0,0,0,0,2V4A2,2,0,0,0,2,6H8.3L13,47.4A3,3,0,0,0,16,50H53a2,2,0,0,0,2-2V46a2,2,0,0,0-2-2H18.7l-.79-7h37.3A2.8,2.8,0,0,0,58,34.8l5.9-21A3.05,3.05,0,0,0,63.41,11.2Z"/></svg>',

		// Pro UI icons.
		'address'       => '<svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 64 64"><path d="M32,0A24,24,0,0,0,8,24c0,5.49,3.6,13.52,11,24.52,5.27,7.84,10.46,14.13,10.68,14.39a3,3,0,0,0,4.62,0c.22-.26,5.41-6.55,10.68-14.39,7.41-11,11-19,11-24.52A24,24,0,0,0,32,0Zm0,34A10,10,0,1,1,42,24,10,10,0,0,1,32,34Z"/></svg>',
		'email'         => '<svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 64 64"><path d="M32,35.7,64,16.9V10a2,2,0,0,0-2-2H2a2,2,0,0,0-2,2v6.9Zm1,4a1.82,1.82,0,0,1-2,0L0,21.5V54a2,2,0,0,0,2,2H62a2,2,0,0,0,2-2V21.5Z"/></svg>',
		'phone'         => '<svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 64 64"><path d="M55.28,44.55c-3.89-3.31-7.84-5.32-11.68-2l-2.29,2C39.63,46,36.51,52.75,24.45,39S19.56,23,21.25,21.59l2.3-2c3.82-3.31,2.38-7.47-.38-11.77L21.51,5.23C18.75,1,15.72-1.85,11.9,1.44L9.83,3.25A19.26,19.26,0,0,0,2.25,16c-1.38,9.08,3,19.49,13,30.91S35,64.1,44.2,64A19.58,19.58,0,0,0,58,58.32l2.07-1.8c3.83-3.3,1.45-6.67-2.44-10Z"/></svg>',
		'time'          => '<svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 64 64"><path d="M32,0A32,32,0,1,0,64,32,32,32,0,0,0,32,0Zm0,56A24,24,0,1,1,56,32,24,24,0,0,1,32,56ZM45.55,39.89a2,2,0,0,1-2.68.9L30.66,34.68A3,3,0,0,1,29,32V13a2,2,0,0,1,2-2h2a2,2,0,0,1,2,2V30.15l10.55,5.27a2,2,0,0,1,.9,2.68Z"/></svg>',
		'filter'        => '<svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 64 64"><rect x="2" y="29" width="60" height="6" rx="2"/><rect x="2" y="7" width="60" height="6" rx="2"/><rect x="2" y="51" width="60" height="6" rx="2"/><circle cx="37" cy="10" r="6" fill="#fff"/><path d="M37,7a3,3,0,1,1-3,3,3,3,0,0,1,3-3m0-6a9,9,0,1,0,9,9,9,9,0,0,0-9-9Z"/><circle cx="17" cy="32" r="6" fill="#fff"/><path d="M17,29a3,3,0,1,1-3,3,3,3,0,0,1,3-3m0-6a9,9,0,1,0,9,9,9,9,0,0,0-9-9Z"/><circle cx="47" cy="54" r="6" fill="#fff"/><path d="M47,51a3,3,0,1,1-3,3,3,3,0,0,1,3-3m0-6a9,9,0,1,0,9,9,9,9,0,0,0-9-9Z"/></svg>',

		// Social icons.
		'behance'       => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M6.938 4.503c.702 0 1.34.06 1.92.188.577.13 1.07.33 1.485.61.41.28.733.65.96 1.12.225.47.34 1.05.34 1.73 0 .74-.17 1.36-.507 1.86-.338.5-.837.9-1.502 1.22.906.26 1.576.72 2.022 1.37.448.66.665 1.45.665 2.36 0 .75-.13 1.39-.41 1.93-.28.55-.67 1-1.16 1.35-.48.348-1.05.6-1.67.767-.61.165-1.252.254-1.91.254H0V4.51h6.938v-.007zM16.94 16.665c.44.428 1.073.643 1.894.643.59 0 1.1-.148 1.53-.447.424-.29.68-.61.78-.94h2.588c-.403 1.28-1.048 2.2-1.9 2.75-.85.56-1.884.83-3.08.83-.837 0-1.584-.13-2.272-.4-.673-.27-1.24-.65-1.72-1.14-.464-.49-.823-1.08-1.077-1.77-.253-.69-.373-1.45-.373-2.27 0-.803.135-1.54.403-2.23.27-.7.644-1.28 1.12-1.79.495-.51 1.063-.895 1.736-1.194s1.4-.433 2.22-.433c.91 0 1.69.164 2.38.523.67.34 1.22.82 1.66 1.4.44.586.75 1.26.94 2.02.19.75.25 1.54.21 2.38h-7.69c0 .84.28 1.632.71 2.065l-.08.03zm-10.24.05c.317 0 .62-.03.906-.093.29-.06.548-.165.763-.3.21-.135.39-.328.52-.583.13-.24.19-.57.19-.96 0-.75-.22-1.29-.64-1.62-.43-.32-.99-.48-1.69-.48H3.24v4.05H6.7v-.03zm13.607-5.65c-.352-.385-.94-.592-1.657-.592-.468 0-.855.074-1.166.238-.302.15-.55.35-.74.59-.19.24-.317.48-.392.75-.075.26-.12.5-.135.71h4.762c-.07-.75-.33-1.3-.68-1.69v.01zM6.52 10.45c.574 0 1.05-.134 1.425-.412.374-.27.554-.72.554-1.338 0-.344-.07-.625-.18-.846-.13-.22-.3-.39-.5-.512-.21-.124-.45-.21-.72-.257-.27-.053-.56-.074-.84-.074H3.23v3.44h3.29zm9.098-4.958h5.968v1.454h-5.968V5.48v.01z"/></svg>',
		'bitbucket'     => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M.778 1.211c-.424-.006-.772.334-.778.758 0 .045.002.09.01.134l3.263 19.811c.084.499.515.867 1.022.872H19.95c.382.004.708-.271.77-.646l3.27-20.03c.068-.418-.216-.813-.635-.881-.045-.008-.089-.011-.133-.01L.778 1.211zM14.52 15.528H9.522L8.17 8.464h7.561l-1.211 7.064z"/></svg>',
		'dribbble'      => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 24C5.385 24 0 18.615 0 12S5.385 0 12 0s12 5.385 12 12-5.385 12-12 12zm10.12-10.358c-.35-.11-3.17-.953-6.384-.438 1.34 3.684 1.887 6.684 1.992 7.308 2.3-1.555 3.936-4.02 4.395-6.87zm-6.115 7.808c-.153-.9-.75-4.032-2.19-7.77l-.066.02c-5.79 2.015-7.86 6.025-8.04 6.4 1.73 1.358 3.92 2.166 6.29 2.166 1.42 0 2.77-.29 4-.814zm-11.62-2.58c.232-.4 3.045-5.055 8.332-6.765.135-.045.27-.084.405-.12-.26-.585-.54-1.167-.832-1.74C7.17 11.775 2.206 11.71 1.756 11.7l-.004.312c0 2.633.998 5.037 2.634 6.855zm-2.42-8.955c.46.008 4.683.026 9.477-1.248-1.698-3.018-3.53-5.558-3.8-5.928-2.868 1.35-5.01 3.99-5.676 7.17zM9.6 2.052c.282.38 2.145 2.914 3.822 6 3.645-1.365 5.19-3.44 5.373-3.702-1.81-1.61-4.19-2.586-6.795-2.586-.825 0-1.63.1-2.4.285zm10.335 3.483c-.218.29-1.935 2.493-5.724 4.04.24.49.47.985.68 1.486.08.18.15.36.22.53 3.41-.43 6.8.26 7.14.33-.02-2.42-.88-4.64-2.31-6.38z"/></svg>',
		'facebook'      => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M23.9981 11.9991C23.9981 5.37216 18.626 0 11.9991 0C5.37216 0 0 5.37216 0 11.9991C0 17.9882 4.38789 22.9522 10.1242 23.8524V15.4676H7.07758V11.9991H10.1242V9.35553C10.1242 6.34826 11.9156 4.68714 14.6564 4.68714C15.9692 4.68714 17.3424 4.92149 17.3424 4.92149V7.87439H15.8294C14.3388 7.87439 13.8739 8.79933 13.8739 9.74824V11.9991H17.2018L16.6698 15.4676H13.8739V23.8524C19.6103 22.9522 23.9981 17.9882 23.9981 11.9991Z"/></svg>',
		'github'        => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/></svg>',
		'gitlab'        => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M4.844.904a1.007 1.007 0 00-.955.692l-2.53 7.783c0 .007-.005.012-.007.02L.07 13.335a1.437 1.437 0 00.522 1.607l11.072 8.045a.566.566 0 00.67-.004l11.074-8.04a1.436 1.436 0 00.522-1.61l-1.26-3.867a.547.547 0 00-.031-.104l-2.526-7.775a1.004 1.004 0 00-.957-.684.987.987 0 00-.949.69l-2.406 7.408H8.203l-2.41-7.408a.987.987 0 00-.943-.69h-.006zm-.006 1.42l2.174 6.678H2.674l2.164-6.678zm14.328 0l2.168 6.678h-4.342l2.174-6.678zm-10.594 7.81h6.862l-2.15 6.618L12 20.693 8.572 10.135zm-5.515.005h4.322l3.086 9.5-7.408-9.5zm13.568 0h4.326l-6.703 8.588-.709.914 2.959-9.108.127-.394zM2.1 10.762l6.978 8.947-7.818-5.682a.305.305 0 01-.112-.341l.952-2.924zm19.8 0l.952 2.922a.305.305 0 01-.11.341v.002l-7.82 5.68.025-.035 6.953-8.91Z"/></svg>',
		'instagram'     => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/></svg>',
		'linkedin'      => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>',
		'medium'        => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M0 0v24h24V0H0zm19.938 5.686L18.651 6.92a.376.376 0 0 0-.143.362v9.067a.376.376 0 0 0 .143.361l1.257 1.234v.271h-6.322v-.27l1.302-1.265c.128-.128.128-.165.128-.36V8.99l-3.62 9.195h-.49L6.69 8.99v6.163a.85.85 0 0 0 .233.707l1.694 2.054v.271H3.815v-.27L5.51 15.86a.82.82 0 0 0 .218-.707V8.027a.624.624 0 0 0-.203-.527L4.019 5.686v-.27h4.674l3.613 7.923 3.176-7.924h4.456v.271z"/></svg>',
		'messenger'     => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M0 11.64C0 4.95 5.24 0 12 0s12 4.95 12 11.64-5.24 11.64-12 11.64c-1.21 0-2.38-.16-3.47-.46a.96.96 0 0 0-.64.05L5.5 23.92a.96.96 0 0 1-1.35-.85l-.07-2.14a.97.97 0 0 0-.32-.68A11.39 11.39 0 0 1 0 11.64zm8.32-2.19l-3.52 5.6c-.35.53.32 1.14.82.75l3.79-2.87c.26-.2.6-.2.87 0l2.8 2.1c.84.63 2.04.4 2.6-.48l3.52-5.6c.35-.53-.32-1.13-.82-.75l-3.79 2.87c-.25.2-.6.2-.86 0l-2.8-2.1a1.8 1.8 0 0 0-2.61.48z"/></svg>',
		'pinterest'     => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.162-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.401.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.354-.629-2.758-1.379l-.749 2.848c-.269 1.045-1.004 2.352-1.498 3.146 1.123.345 2.306.535 3.55.535 6.607 0 11.985-5.365 11.985-11.987C23.97 5.39 18.592.026 11.985.026L12.017 0z"/></svg>',
		'rss'           => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M19.199 24C19.199 13.467 10.533 4.8 0 4.8V0c13.165 0 24 10.835 24 24h-4.801zM3.291 17.415c1.814 0 3.293 1.479 3.293 3.295 0 1.813-1.485 3.29-3.301 3.29C1.47 24 0 22.526 0 20.71s1.475-3.294 3.291-3.295zM15.909 24h-4.665c0-6.169-5.075-11.245-11.244-11.245V8.09c8.727 0 15.909 7.184 15.909 15.91z"/></svg>',
		'skype'         => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12.069 18.874c-4.023 0-5.82-1.979-5.82-3.464 0-.765.561-1.296 1.333-1.296 1.723 0 1.273 2.477 4.487 2.477 1.641 0 2.55-.895 2.55-1.811 0-.551-.269-1.16-1.354-1.429l-3.576-.895c-2.88-.724-3.403-2.286-3.403-3.751 0-3.047 2.861-4.191 5.549-4.191 2.471 0 5.393 1.373 5.393 3.199 0 .784-.688 1.24-1.453 1.24-1.469 0-1.198-2.037-4.164-2.037-1.469 0-2.292.664-2.292 1.617s1.153 1.258 2.157 1.487l2.637.587c2.891.649 3.624 2.346 3.624 3.944 0 2.476-1.902 4.324-5.722 4.324m11.084-4.882l-.029.135-.044-.24c.015.045.044.074.059.12.12-.675.181-1.363.181-2.052 0-1.529-.301-3.012-.898-4.42-.569-1.348-1.395-2.562-2.427-3.596-1.049-1.033-2.247-1.856-3.595-2.426-1.318-.631-2.801-.93-4.328-.93-.72 0-1.444.07-2.143.204l.119.06-.239-.033.119-.025C8.91.274 7.829 0 6.731 0c-1.789 0-3.47.698-4.736 1.967C.729 3.235.032 4.923.032 6.716c0 1.143.292 2.265.844 3.258l.02-.124.041.239-.06-.115c-.114.645-.172 1.299-.172 1.955 0 1.53.3 3.017.884 4.416.568 1.362 1.378 2.576 2.427 3.609 1.034 1.05 2.247 1.857 3.595 2.442 1.394.6 2.877.898 4.404.898.659 0 1.334-.06 1.977-.179l-.119-.062.24.046-.135.03c1.002.569 2.126.871 3.294.871 1.783 0 3.459-.69 4.733-1.963 1.259-1.259 1.962-2.951 1.962-4.749 0-1.138-.299-2.262-.853-3.266"/></svg>',
		'slack'         => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M5.042 15.165a2.528 2.528 0 0 1-2.52 2.523A2.528 2.528 0 0 1 0 15.165a2.527 2.527 0 0 1 2.522-2.52h2.52v2.52zM6.313 15.165a2.527 2.527 0 0 1 2.521-2.52 2.527 2.527 0 0 1 2.521 2.52v6.313A2.528 2.528 0 0 1 8.834 24a2.528 2.528 0 0 1-2.521-2.522v-6.313zM8.834 5.042a2.528 2.528 0 0 1-2.521-2.52A2.528 2.528 0 0 1 8.834 0a2.528 2.528 0 0 1 2.521 2.522v2.52H8.834zM8.834 6.313a2.528 2.528 0 0 1 2.521 2.521 2.528 2.528 0 0 1-2.521 2.521H2.522A2.528 2.528 0 0 1 0 8.834a2.528 2.528 0 0 1 2.522-2.521h6.312zM18.956 8.834a2.528 2.528 0 0 1 2.522-2.521A2.528 2.528 0 0 1 24 8.834a2.528 2.528 0 0 1-2.522 2.521h-2.522V8.834zM17.688 8.834a2.528 2.528 0 0 1-2.523 2.521 2.527 2.527 0 0 1-2.52-2.521V2.522A2.527 2.527 0 0 1 15.165 0a2.528 2.528 0 0 1 2.523 2.522v6.312zM15.165 18.956a2.528 2.528 0 0 1 2.523 2.522A2.528 2.528 0 0 1 15.165 24a2.527 2.527 0 0 1-2.52-2.522v-2.522h2.52zM15.165 17.688a2.527 2.527 0 0 1-2.52-2.523 2.526 2.526 0 0 1 2.52-2.52h6.313A2.527 2.527 0 0 1 24 15.165a2.528 2.528 0 0 1-2.522 2.523h-6.313z"/></svg>',
		'telegram'      => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M23.91 3.79L20.3 20.84c-.25 1.21-.98 1.5-2 .94l-5.5-4.07-2.66 2.57c-.3.3-.55.56-1.1.56-.72 0-.6-.27-.84-.95L6.3 13.7l-5.45-1.7c-1.18-.35-1.19-1.16.26-1.75l21.26-8.2c.97-.43 1.9.24 1.53 1.73z"/></svg>',
		'twitter'       => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M23.954 4.569c-.885.389-1.83.654-2.825.775 1.014-.611 1.794-1.574 2.163-2.723-.951.555-2.005.959-3.127 1.184-.896-.959-2.173-1.559-3.591-1.559-2.717 0-4.92 2.203-4.92 4.917 0 .39.045.765.127 1.124C7.691 8.094 4.066 6.13 1.64 3.161c-.427.722-.666 1.561-.666 2.475 0 1.71.87 3.213 2.188 4.096-.807-.026-1.566-.248-2.228-.616v.061c0 2.385 1.693 4.374 3.946 4.827-.413.111-.849.171-1.296.171-.314 0-.615-.03-.916-.086.631 1.953 2.445 3.377 4.604 3.417-1.68 1.319-3.809 2.105-6.102 2.105-.39 0-.779-.023-1.17-.067 2.189 1.394 4.768 2.209 7.557 2.209 9.054 0 13.999-7.496 13.999-13.986 0-.209 0-.42-.015-.63.961-.689 1.8-1.56 2.46-2.548l-.047-.02z"/></svg>',
		'vimeo'         => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M23.977 6.416c-.105 2.338-1.739 5.543-4.894 9.609-3.268 4.247-6.026 6.37-8.29 6.37-1.409 0-2.578-1.294-3.553-3.881L5.322 11.4C4.603 8.816 3.834 7.522 3.01 7.522c-.179 0-.806.378-1.881 1.132L0 7.197c1.185-1.044 2.351-2.084 3.501-3.128C5.08 2.701 6.266 1.984 7.055 1.91c1.867-.18 3.016 1.1 3.447 3.838.465 2.953.789 4.789.971 5.507.539 2.45 1.131 3.674 1.776 3.674.502 0 1.256-.796 2.265-2.385 1.004-1.589 1.54-2.797 1.612-3.628.144-1.371-.395-2.061-1.614-2.061-.574 0-1.167.121-1.777.391 1.186-3.868 3.434-5.757 6.762-5.637 2.473.06 3.628 1.664 3.493 4.797l-.013.01z"/></svg>',
		'vk'            => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M15.684 0H8.316C1.592 0 0 1.592 0 8.316v7.368C0 22.408 1.592 24 8.316 24h7.368C22.408 24 24 22.408 24 15.684V8.316C24 1.592 22.391 0 15.684 0zm3.692 17.123h-1.744c-.66 0-.864-.525-2.05-1.727-1.033-1-1.49-1.135-1.744-1.135-.356 0-.458.102-.458.593v1.575c0 .424-.135.678-1.253.678-1.846 0-3.896-1.118-5.335-3.202C4.624 10.857 4.03 8.57 4.03 8.096c0-.254.102-.491.593-.491h1.744c.44 0 .61.203.78.677.863 2.49 2.303 4.675 2.896 4.675.22 0 .322-.102.322-.66V9.721c-.068-1.186-.695-1.287-.695-1.71 0-.204.17-.407.44-.407h2.744c.373 0 .508.203.508.643v3.473c0 .372.17.508.271.508.22 0 .407-.136.813-.542 1.254-1.406 2.151-3.574 2.151-3.574.119-.254.322-.491.763-.491h1.744c.525 0 .644.27.525.643-.22 1.017-2.354 4.031-2.354 4.031-.186.305-.254.44 0 .78.186.254.796.779 1.203 1.253.745.847 1.32 1.558 1.473 2.05.17.49-.085.744-.576.744z"/></svg>',
		'whatsapp'      => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>',
		'wordpress'     => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M21.469 6.825c.84 1.537 1.318 3.3 1.318 5.175 0 3.979-2.156 7.456-5.363 9.325l3.295-9.527c.615-1.54.82-2.771.82-3.864 0-.405-.026-.78-.07-1.11m-7.981.105c.647-.03 1.232-.105 1.232-.105.582-.075.514-.93-.067-.899 0 0-1.755.135-2.88.135-1.064 0-2.85-.15-2.85-.15-.585-.03-.661.855-.075.885 0 0 .54.061 1.125.09l1.68 4.605-2.37 7.08L5.354 6.9c.649-.03 1.234-.1 1.234-.1.585-.075.516-.93-.065-.896 0 0-1.746.138-2.874.138-.2 0-.438-.008-.69-.015C4.911 3.15 8.235 1.215 12 1.215c2.809 0 5.365 1.072 7.286 2.833-.046-.003-.091-.009-.141-.009-1.06 0-1.812.923-1.812 1.914 0 .89.513 1.643 1.06 2.531.411.72.89 1.643.89 2.977 0 .915-.354 1.994-.821 3.479l-1.075 3.585-3.9-11.61.001.014zM12 22.784c-1.059 0-2.081-.153-3.048-.437l3.237-9.406 3.315 9.087c.024.053.05.101.078.149-1.12.393-2.325.609-3.582.609M1.211 12c0-1.564.336-3.05.935-4.39L7.29 21.709C3.694 19.96 1.212 16.271 1.211 12M12 0C5.385 0 0 5.385 0 12s5.385 12 12 12 12-5.385 12-12S18.615 0 12 0"/></svg>',
		'youtube'       => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path class="a" d="M23.495 6.205a3.007 3.007 0 0 0-2.088-2.088c-1.87-.501-9.396-.501-9.396-.501s-7.507-.01-9.396.501A3.007 3.007 0 0 0 .527 6.205a31.247 31.247 0 0 0-.522 5.805 31.247 31.247 0 0 0 .522 5.783 3.007 3.007 0 0 0 2.088 2.088c1.868.502 9.396.502 9.396.502s7.506 0 9.396-.502a3.007 3.007 0 0 0 2.088-2.088 31.247 31.247 0 0 0 .5-5.783 31.247 31.247 0 0 0-.5-5.805zM9.609 15.601V8.408l6.264 3.602z"/></svg>',
	);
}
