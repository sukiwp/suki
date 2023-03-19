<?php
/**
 * Plugin compatibility: WooCommerce
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WooCommerce compatibility class.
 */
class Suki_Compatibility_WooCommerce {

	/**
	 * Singleton instance
	 *
	 * @var Suki_Compatibility_WooCommerce
	 */
	private static $instance;

	/**
	 * ====================================================
	 * Singleton & constructor functions
	 * ====================================================
	 */

	/**
	 * Get singleton instance.
	 *
	 * @return Suki_Compatibility_WooCommerce
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Class constructor
	 */
	protected function __construct() {
		/**
		 * Theme supports
		 */

		// Add theme supports.
		add_action( 'after_setup_theme', array( $this, 'add_theme_supports' ) );

		/**
		 * Compatibility CSS
		 */

		// Replace WooCommerce classic CSS with our own CSS.
		add_filter( 'woocommerce_enqueue_styles', array( $this, 'modify_css' ) );

		// Add dynamic CSS.
		add_filter( 'suki/frontend/woocommerce/dynamic_css', array( $this, 'add_dynamic_css' ) );

		// Enqueue dynamic CSS.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_dynamic_css' ) );

		// Replace WooCommerce blocks CSS with our own CSS.
		add_action( 'init', array( $this, 'modify_blocks_css' ) );

		// Add CSS for editor page.
		add_action( 'admin_init', array( $this, 'enqueue_editor_css' ) );

		/**
		 * Customizer
		 */

		// Add options.
		add_action( 'customize_register', array( $this, 'register_customizer_settings' ) );

		// Add default values.
		add_filter( 'suki/customizer/setting_defaults', array( $this, 'add_customizer_setting_defaults' ) );

		// Add option outputs.
		add_filter( 'suki/customizer/setting_outputs', array( $this, 'add_customizer_setting_outputs' ) );

		// Add option contexts.
		add_filter( 'suki/customizer/control_contexts', array( $this, 'add_control_contexts' ) );

		// Add preview contexts.
		add_filter( 'suki/customizer/preview_contexts', array( $this, 'add_preview_contexts' ) );

		// Add header builder elements (Customizer).
		add_filter( 'suki/dataset/header_builder/elements', array( $this, 'add_header_builder_elements' ) );

		// Add mobile header builder elements (Customizer).
		add_filter( 'suki/dataset/header_mobile_builder/elements', array( $this, 'add_header_mobile_builder_elements' ) );

		add_filter( 'suki/dataset/product_single_content_header_elements', array( $this, 'modify_content_header_elements_choices_on_product_single_page' ) );
		add_filter( 'suki/dataset/customizer_page_types/custom', array( $this, 'modify_custom_page_settings_types' ) );

		/**
		 * Frontend
		 */

		// Register `sidebar-shop` sidebar.
		add_action( 'widgets_init', array( $this, 'register_sidebars' ) );

		// Template hooks.
		add_action( 'init', array( $this, 'modify_template_hooks' ) );

		// Template hooks (after `init` hook run).
		add_action( 'template_redirect', array( $this, 'modify_template_hooks_after_init' ), 20 ); // Priority is set to 20, because theme's actions are registered at 10.

		// Render header elements.
		add_filter( 'suki/frontend/header_element/cart-link', array( $this, 'get_header_element__cart_link' ) );
		add_filter( 'suki/frontend/header_element/cart-dropdown', array( $this, 'get_header_element__cart_dropdown' ) );

		/**
		 * Page settings.
		 */

		add_filter( 'suki/page_settings/excluded_post_ids', array( $this, 'exclude_page_settings_on_shop_page' ), 10, 2 );

		add_filter( 'update_option_woocommerce_cart_page_id', array( $this, 'set_default_page_settings_on_woocommerce_pages' ), 10, 3 );
		add_filter( 'update_option_woocommerce_checkout_page_id', array( $this, 'set_default_page_settings_on_woocommerce_pages' ), 10, 3 );
		add_filter( 'update_option_woocommerce_myaccount_page_id', array( $this, 'set_default_page_settings_on_woocommerce_pages' ), 10, 3 );
	}

	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

	/**
	 * Define WooCommerce theme's supports.
	 */
	public function add_theme_supports() {
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-slider' );
		add_theme_support( 'wc-product-gallery-lightbox' );
	}

	/**
	 * Replace WooCommerce classic CSS with our own CSS.
	 *
	 * @param array $styles Styles array.
	 * @return array
	 */
	public function modify_css( $styles ) {
		// Disable woocommerce-layout.css as layout related styles will be included in our own CSS.
		$styles['woocommerce-layout']['src'] = false;

		// Disable woocommerce-smallscreen.css as responsive styles will be included in our own CSS.
		$styles['woocommerce-smallscreen']['src'] = false;

		// Replace woocommerce-general.css with our own CSS.
		// Our CSS includes all general, layout, and smallscreen CSS.
		$styles['woocommerce-general']['src']     = trailingslashit( SUKI_CSS_URL ) . 'woocommerce' . SUKI_ASSETS_SUFFIX . '.css';
		$styles['woocommerce-general']['version'] = SUKI_VERSION;

		return $styles;
	}

	/**
	 * Add dynamic CSS from customizer settings into the inline CSS.
	 *
	 * @param string $css CSS string.
	 * @return string
	 */
	public function add_dynamic_css( $css ) {
		// Skip adding dynamic CSS on customizer preview frame.
		if ( is_customize_preview() ) {
			return $css;
		}

		$outputs  = include trailingslashit( SUKI_INCLUDES_DIR ) . 'compatibilities/woocommerce/customizer/outputs.php';
		$defaults = include trailingslashit( SUKI_INCLUDES_DIR ) . 'compatibilities/woocommerce/customizer/defaults.php';

		$generated_css = Suki_Customizer::instance()->convert_outputs_to_css_string( $outputs, $defaults );

		if ( ! empty( $generated_css ) ) {
			$css .= "\n/* Theme + WooCommerce Dynamic CSS */\n" . $generated_css;
		}

		return $css;
	}

	/**
	 * Enqueue dynamic CSS.
	 */
	public function enqueue_dynamic_css() {
		// Inline CSS.
		wp_add_inline_style( 'woocommerce-general', trim( apply_filters( 'suki/frontend/woocommerce/dynamic_css', '' ) ) );
	}

	/**
	 * Replace WooCommerce blocks CSS with our own CSS.
	 */
	public function modify_blocks_css() {
		wp_deregister_style( 'wc-blocks-style' );
		wp_register_style( 'wc-blocks-style', trailingslashit( SUKI_CSS_URL ) . 'woocommerce-blocks' . SUKI_ASSETS_SUFFIX . '.css', array(), SUKI_VERSION );
		wp_style_add_data( 'wc-blocks-style', 'rtl', 'replace' );
		wp_style_add_data( 'wc-blocks-style', 'suffix', SUKI_ASSETS_SUFFIX );
	}

	/**
	 * Add CSS for editor page.
	 */
	public function enqueue_editor_css() {
		add_editor_style( 'assets/css/woocommerce-blocks' . SUKI_ASSETS_SUFFIX . '.css' );
	}

	/**
	 * Register customizer sections, settings, and controls.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer Manager object.
	 */
	public function register_customizer_settings( $wp_customize ) {
		$defaults = Suki_Customizer::instance()->get_setting_defaults();

		require_once trailingslashit( SUKI_INCLUDES_DIR ) . 'compatibilities/woocommerce/customizer/structures/sections.php';
		require_once trailingslashit( SUKI_INCLUDES_DIR ) . 'compatibilities/woocommerce/customizer/structures/header--cart.php';
		require_once trailingslashit( SUKI_INCLUDES_DIR ) . 'compatibilities/woocommerce/customizer/structures/woocommerce--store-notice.php';
		require_once trailingslashit( SUKI_INCLUDES_DIR ) . 'compatibilities/woocommerce/customizer/structures/woocommerce--product-catalog.php';
		require_once trailingslashit( SUKI_INCLUDES_DIR ) . 'compatibilities/woocommerce/customizer/structures/woocommerce--product-single.php';
		require_once trailingslashit( SUKI_INCLUDES_DIR ) . 'compatibilities/woocommerce/customizer/structures/woocommerce--cart.php';
		require_once trailingslashit( SUKI_INCLUDES_DIR ) . 'compatibilities/woocommerce/customizer/structures/woocommerce--checkout.php';
		require_once trailingslashit( SUKI_INCLUDES_DIR ) . 'compatibilities/woocommerce/customizer/structures/woocommerce--products-grid.php';
		require_once trailingslashit( SUKI_INCLUDES_DIR ) . 'compatibilities/woocommerce/customizer/structures/woocommerce--other-elements.php';
	}

	/**
	 * Add default values for all Customizer settings.
	 *
	 * @param array $defaults Defaults values array.
	 * @return array
	 */
	public function add_customizer_setting_defaults( $defaults = array() ) {
		$add = include trailingslashit( SUKI_INCLUDES_DIR ) . 'compatibilities/woocommerce/customizer/defaults.php';

		return array_merge_recursive( $defaults, $add );
	}

	/**
	 * Add postmessage rules for some Customizer settings.
	 *
	 * @param array $outputs Outputs array.
	 * @return array
	 */
	public function add_customizer_setting_outputs( $outputs = array() ) {
		$add = include trailingslashit( SUKI_INCLUDES_DIR ) . 'compatibilities/woocommerce/customizer/outputs.php';

		return array_merge_recursive( $outputs, $add );
	}

	/**
	 * Add dependency contexts for some Customizer settings.
	 * Triggered via filter to allow modification by users.
	 *
	 * @param array $contexts Contexts array.
	 * @return array
	 */
	public function add_control_contexts( $contexts = array() ) {
		$add = include trailingslashit( SUKI_INCLUDES_DIR ) . 'compatibilities/woocommerce/customizer/contexts.php';

		return array_merge_recursive( $contexts, $add );
	}

	/**
	 * Allow others to add more preview contexts.
	 *
	 * @param array $contexts Contexts array.
	 * @return array
	 */
	public function add_preview_contexts( $contexts = array() ) {
		// Add Customizer’s preview contexts for Cart and Checkout pages.
		$contexts['woocommerce_cart']     = esc_url( wc_get_cart_url() );
		$contexts['woocommerce_checkout'] = esc_url( wc_get_checkout_url() );

		return $contexts;
	}

	/**
	 * Add header shopping cart as Header Builder elements.
	 *
	 * @param array $elements Elements array.
	 * @return array
	 */
	public function add_header_builder_elements( $elements ) {
		$elements['cart-link'] = array(
			'icon'              => 'cart',
			'label'             => esc_html__( 'Cart Link', 'suki' ),
			'unsupported_areas' => array(),
		);

		$elements['cart-dropdown'] = array(
			'icon'              => 'cart',
			'label'             => esc_html__( 'Cart Dropdown', 'suki' ),
			'unsupported_areas' => array(),
		);

		return $elements;
	}

	/**
	 * Add header shopping cart as Mobile Header Builder elements.
	 *
	 * @param array $elements Elements array.
	 * @return array
	 */
	public function add_header_mobile_builder_elements( $elements ) {
		$elements['cart-link'] = array(
			'icon'              => 'cart',
			'label'             => esc_html__( 'Cart Link', 'suki' ),
			'unsupported_areas' => array( 'vertical_top' ),
		);

		$elements['cart-dropdown'] = array(
			'icon'              => 'cart',
			'label'             => esc_html__( 'Cart Dropdown', 'suki' ),
			'unsupported_areas' => array( 'vertical_top' ),
		);

		return $elements;
	}

	/**
	 * Modify content header elements for WooCommerce archive and singular pages.
	 *
	 * @param array $choices Choices array.
	 * @return array
	 */
	public function modify_content_header_elements_choices_on_product_single_page( $choices ) {
		// Add product rating.
		$choices['product-rating'] = esc_html__( 'Product rating', 'suki' );

		// Remove excerpt.
		if ( isset( $choices['excerpt'] ) ) {
			unset( $choices['excerpt'] );
		}

		return $choices;
	}

	/**
	 * Modify post type data for page settings.
	 *
	 * @param array $data Data array.
	 * @return array
	 */
	public function modify_custom_page_settings_types( $data ) {
		$data['product_archive']['section']      = 'woocommerce_product_catalog';
		$data['product_archive']['auto_options'] = false;

		$data['product_single']['section']      = 'woocommerce_product_single';
		$data['product_single']['auto_options'] = false;

		return $data;
	}

	/**
	 * Register additional sidebar for WooCommerce.
	 */
	public function register_sidebars() {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Sidebar Shop', 'suki' ),
				'id'            => 'sidebar-shop',
				'description'   => esc_html__( 'Sidebar that replaces the default sidebar when on WooCommerce pages.', 'suki' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			)
		);
	}

	/**
	 * Modify filters for WooCommerce template rendering.
	 */
	public function modify_template_hooks() {
		/**
		 * Responsive breakpoint
		 */

		// Change mobile devices breakpoint.
		add_filter( 'woocommerce_style_smallscreen_breakpoint', array( $this, 'set_smallscreen_breakpoint' ) );

		/**
		 * Header elements
		 */

		// Add count to Cart menu item.
		add_filter( 'nav_menu_item_title', array( $this, 'add_count_to_cart_menu_item' ), 10, 4 );

		/**
		 * Cart
		 */

		// Add cart fragments.
		add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'update_header_cart' ) );

		/**
		 * Product search widget
		 */

		// Modify product search widget.
		add_filter( 'get_product_search_form', array( $this, 'change_product_search_form_markup' ) );

		/**
		 * Product search widget
		 */

		// Modify flexslider settings on single product page.
		add_filter( 'woocommerce_single_product_carousel_options', array( $this, 'change_single_product_carousel_options' ) );

		/**
		 * Page title.
		 */

		// Modify page title.
		add_filter( 'woocommerce_page_title', array( $this, 'modify_page_title' ) );

		/**
		 * Breadcrumb
		 */

		// Modify original WooCommerce breadcrumb configuration.
		add_filter( 'woocommerce_breadcrumb_defaults', array( $this, 'modify_breadcrumb_defaults' ) );

		// Whether to use theme's breadcrumb or WooCommerce original breadcrumb.
		add_filter( 'suki/frontend/breadcrumb', array( $this, 'modify_breadcrumb_html' ) );

		// Change "Products" in theme's breadcrumb trails to Shop page's title.
		add_filter( 'suki/frontend/breadcrumb_trail', array( $this, 'modify_theme_breadcrumb_trails' ) );

		/**
		 * Content header elements
		 */

		// Modify Content Header element.
		add_filter( 'suki/frontend/content_header_element', array( $this, 'modify_content_header_elements' ), 10, 3 );

		/**
		 * WooCommerce template wrapper
		 */

		// Remove breadcrumb from its original position.
		// It might be readded via Content Header.
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

		// Change main content (primary) wrapper.
		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
		remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
		add_action( 'woocommerce_before_main_content', array( $this, 'render_template_wrapper' ), 10 );
		add_action( 'woocommerce_after_main_content', array( $this, 'render_template_wrapper_end' ), 10 );

		/**
		 * Quantity input field
		 */

		// Add plus and minus buttons to the quantity input.
		add_action( 'woocommerce_after_quantity_input_field', array( $this, 'render_quantity_plus_minus_buttons' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'render_quantity_plus_minus_buttons_scripts' ) );

		/**
		 * Products loop
		 */

		// Add filter for adding class to products grid wrapper.
		add_filter( 'woocommerce_product_loop_start', array( $this, 'change_loop_start_markup' ) );

		// Remove the original link wrapper.
		// The original link wrapper wraps thumbnail, title, rating, and price altogether.
		// We will wrap both thumbnail and title separately as links.
		remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

		// Add wrapper to products grid filters.
		add_action( 'woocommerce_before_shop_loop', array( $this, 'render_loop_filters_wrapper' ), 11 );
		add_action( 'woocommerce_before_shop_loop', array( $this, 'render_loop_filters_wrapper_end' ), 999 );

		// Add product thumbnail wrapper.
		// This wrapper is needed for more advanced features like quick view, hover product image, etc.
		add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'render_loop_product_thumbnail_wrapper' ), 1 );
		add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'render_loop_product_thumbnail_wrapper_end' ), 999 );

		// Move sale badge position to before the newly added custom thumbnail wrapper.
		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
		add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 2 );

		// Add a link wrapper to the product thumbnail.
		add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 9 );
		add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 19 );

		// Add a link wrapper to the product title.
		add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 1 );
		add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 999 );

		// Products loop configuration.
		add_filter( 'loop_shop_per_page', array( $this, 'set_loop_posts_per_page' ) );
		add_filter( 'loop_shop_columns', array( $this, 'set_loop_columns' ) );

		// Add text alignment class on products loop item.
		add_filter( 'woocommerce_post_class', array( $this, 'add_loop_item_alignment_class' ) );

		/**
		 * Shop page
		 */

		// Remove title from its original position.
		// It might be readded via Content Header.
		add_filter( 'woocommerce_show_page_title', '__return_false' );

		// Remove archive description from its original position.
		// It might be readded via Content Header.
		remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );

		/**
		 * Product page
		 */

		// Modify "added to cart" message.
		add_filter( 'wc_add_to_cart_message_html', array( $this, 'change_add_to_cart_message_markup' ), 10, 3 );

		// Add wrapper to product images gallery.
		// This wrapper is needed for more advanced features and styling.
		add_action( 'woocommerce_before_single_product_summary', array( $this, 'render_product_images_wrapper' ), 19 );
		add_action( 'woocommerce_before_single_product_summary', array( $this, 'render_product_images_wrapper_end' ), 29 );

		// Move sale badge position to after images for better CSS handling based on the thumbnail layout.
		remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
		add_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 21 );

		// Set product images thumbnails columns.
		add_filter( 'woocommerce_product_thumbnails_columns', array( $this, 'set_product_thumbnails_columns' ) );

		// Add wrapper to single product add to cart form.
		add_filter( 'woocommerce_before_add_to_cart_form', array( $this, 'render_add_to_cart_form_wrapper' ) );
		add_filter( 'woocommerce_after_add_to_cart_form', array( $this, 'render_add_to_cart_form_wrapper_end' ) );

		// Set review avatar size.
		add_filter( 'woocommerce_review_gravatar_size', array( $this, 'set_review_avatar_size' ) );

		// Related products.
		add_filter( 'woocommerce_related_products_args', array( $this, 'set_related_products_args' ) );
		add_filter( 'woocommerce_related_products_columns', array( $this, 'set_related_products_columns' ) );
		add_filter( 'woocommerce_output_related_products_args', array( $this, 'set_related_products_display_args' ) );

		// Up sells.
		add_filter( 'woocommerce_up_sells_columns', array( $this, 'set_up_sells_columns' ) );
		add_filter( 'woocommerce_upsell_display_args', array( $this, 'set_up_sells_display_args' ) );

		/**
		 * Cart page's template hooks
		 */

		// Cross sells columns.
		add_filter( 'woocommerce_cross_sells_columns', array( $this, 'set_cart_page_cross_sells_columns' ) );

		/**
		 * Checkout page's template hooks
		 */

		// Add checkout class.
		add_filter( 'suki/frontend/woocommerce/checkout_classes', array( $this, 'add_checkout_classes' ) );

		/**
		 * My Account page's template hooks
		 */

		// Add account avatar and name into side navigation.
		add_filter( 'woocommerce_before_account_navigation', array( $this, 'render_account_sidebar_wrapper' ), 1 );
		add_filter( 'woocommerce_after_account_navigation', array( $this, 'render_account_sidebar_wrapper_end' ), 999 );
	}

	/**
	 * Modify filters for WooCommerce template rendering based on Customizer settings.
	 */
	public function modify_template_hooks_after_init() {
		/**
		 * Global template hooks
		 */

		// Keep / remove "add to cart" button on products grid.
		if ( ! boolval( suki_get_theme_mod( 'woocommerce_products_grid_item_add_to_cart' ) ) ) {
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
		}

		// Keep / remove gallery zoom module.
		if ( ! boolval( suki_get_theme_mod( 'woocommerce_single_gallery_zoom' ) ) ) {
			remove_theme_support( 'wc-product-gallery-zoom' );
		}

		// Keep / remove gallery lightbox module.
		if ( ! boolval( suki_get_theme_mod( 'woocommerce_single_gallery_lightbox' ) ) ) {
			remove_theme_support( 'wc-product-gallery-lightbox' );
		}

		/**
		 * Shop page's template hooks
		 */

		if ( is_shop() || is_product_taxonomy() ) {
			// Remove theme's archive header.
			remove_action( 'suki/frontend/before_main', 'suki_archive_header', 10 );

			// Add content header.
			// Available elements: title, breadcrumb.
			if ( ! boolval( suki_get_current_page_setting( 'hero' ) ) ) {
				add_action( 'woocommerce_archive_description', array( $this, 'render_archive_header' ), 0 );
			}

			// Keep / remove products count filter.
			if ( ! boolval( suki_get_theme_mod( 'woocommerce_index_results_count' ) ) ) {
				remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
			}

			// Keep / remove products sorting filter.
			if ( ! boolval( suki_get_theme_mod( 'woocommerce_index_sort_filter' ) ) ) {
				remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
			}
		}

		/**
		 * Products page's template hooks
		 */

		if ( is_product() ) {
			// Add content header.
			// Available elements: title, breadcrumb, rating.
			if ( ! boolval( suki_get_current_page_setting( 'hero' ) ) ) {
				add_action( 'woocommerce_before_single_product_summary', array( $this, 'render_product_header' ), 1 );
			}

			// Keep / remove title on summary column.
			// Remove if title is active in Content Header.
			if ( in_array( 'title', suki_get_current_page_setting( 'content_header' ), true ) ) {
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
			}

			// Keep / remove rating on summary column.
			// Remove if rating is active in Content Header.
			if ( in_array( 'product-rating', suki_get_current_page_setting( 'content_header' ), true ) ) {
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
			}

			// Keep / remove gallery.
			if ( ! boolval( suki_get_current_page_setting( 'woocommerce_single_gallery' ) ) ) {
				remove_action( 'woocommerce_before_single_product_summary', array( $this, 'render_product_gallery_wrapper' ), 19 );
				remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
				remove_action( 'woocommerce_before_single_product_summary', array( $this, 'render_product_gallery_wrapper_end' ), 29 );
			}

			// Keep / remove tabs.
			if ( ! boolval( suki_get_current_page_setting( 'woocommerce_single_tabs' ) ) ) {
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
			}

			// Keep / remove up-sells.
			if ( ! boolval( suki_get_current_page_setting( 'woocommerce_single_up_sells' ) ) ) {
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
			}

			// Keep / remove up-sells.
			if ( ! boolval( suki_get_current_page_setting( 'woocommerce_single_related' ) ) ) {
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
			}
		}

		/**
		 * Cart page's template hooks
		 */

		if ( is_cart() ) {
			// Remove cross sells from its original position.
			remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display', 10 );

			// Re-add cross-sells.
			if ( boolval( suki_get_theme_mod( 'woocommerce_cart_cross_sells' ) ) ) {
				add_action( 'woocommerce_' . suki_get_theme_mod( 'woocommerce_cart_cross_sells_position' ), 'woocommerce_cross_sell_display', 10 );
			}

			// If 2 columns layout is enabled.
			if ( '2-columns' === suki_get_theme_mod( 'woocommerce_cart_layout' ) ) {
				add_action( 'woocommerce_before_cart', array( $this, 'render_cart_2_columns_wrapper' ), 999 );

					add_action( 'woocommerce_before_cart', array( $this, 'render_cart_2_columns_left_wrapper' ), 999 );
					add_action( 'woocommerce_before_cart_collaterals', array( $this, 'render_cart_2_columns_left_wrapper_end' ), 1 );

					add_action( 'woocommerce_before_cart_collaterals', array( $this, 'render_cart_2_columns_right_wrapper' ), 1 );
					add_action( 'woocommerce_after_cart', array( $this, 'render_cart_2_columns_right_wrapper_end' ), 1 );

				add_action( 'woocommerce_after_cart', array( $this, 'render_cart_2_columns_wrapper_end' ), 1 );
			}
		}

		/**
		 * Checkout page's template hooks
		 */

		if ( is_checkout() ) {
			// If 2 columns layout is enabled.
			if ( '2-columns' === suki_get_theme_mod( 'woocommerce_checkout_layout' ) ) {
				add_action( 'woocommerce_checkout_before_customer_details', array( $this, 'render_checkout_2_columns_wrapper' ), 1 );

					add_action( 'woocommerce_checkout_before_customer_details', array( $this, 'render_checkout_2_columns_left_wrapper' ), 1 );
					add_action( 'woocommerce_checkout_after_customer_details', array( $this, 'render_checkout_2_columns_left_wrapper_end' ), 999 );

					add_action( 'woocommerce_checkout_before_order_review_heading', array( $this, 'render_checkout_2_columns_right_wrapper' ), 1 );
					add_action( 'woocommerce_checkout_after_order_review', array( $this, 'render_checkout_2_columns_right_wrapper_end' ), 999 );

				add_action( 'woocommerce_checkout_after_order_review', array( $this, 'render_checkout_2_columns_wrapper_end' ), 999 );
			}
		}
	}

	/**
	 * Return header cart link HTML markup.
	 */
	public function get_header_element__cart_link() {
		if ( ! class_exists( 'WooCommerce' ) ) {
			return;
		}

		$cart = WC()->cart;

		if ( empty( $cart ) ) {
			return;
		}

		ob_start();
		?>
		<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="suki-header-cart-link suki-header-cart cart-link suki-menu-item-link">
			<span class="screen-reader-text"><?php esc_html_e( 'Shopping Cart', 'suki' ); ?></span>

			<?php suki_icon( 'cart', array( 'class' => 'cart-icon suki-menu-icon' ) ); ?>

			<span class="cart-count" data-count="<?php echo esc_attr( $cart->get_cart_contents_count() ); ?>">
				<?php echo $cart->get_cart_contents_count(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</span>

			<?php
			$classes = array();

			$amount_position = suki_get_theme_mod( 'header_cart_amount', '' );

			$amount_html = '';
			if ( '' !== $amount_position ) {
				$classes[] = $amount_position;

				$hide_devices = array_diff( array( 'desktop', 'tablet', 'mobile' ), suki_get_theme_mod( 'header_cart_amount_visibility' ) );

				foreach ( $hide_devices as $device ) {
					$classes[] = esc_attr( 'suki-hide-on-' . $device );
				}
			}
			?>
			<span class="cart-amount <?php echo esc_attr( implode( ' ', $classes ) ); ?>">
				<?php echo $cart->get_cart_total(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</span>
		</a>
		<?php
		$html = ob_get_clean();

		return $html;
	}

	/**
	 * Return header cart dropdown HTML markup.
	 */
	public function get_header_element__cart_dropdown() {
		if ( ! class_exists( 'WooCommerce' ) ) {
			return;
		}

		$cart = WC()->cart;

		if ( empty( $cart ) ) {
			return;
		}

		/**
		 * Build cart dropdown HTML.
		 */
		ob_start();
		the_widget(
			'WC_Widget_Cart',
			array(
				'title'         => '',
				'hide_if_empty' => false,
			)
		);
		$dropdown_html = ob_get_clean();
		if ( ! empty( $dropdown_html ) ) {
			$is_dropdown = true;
		} else {
			$is_dropdown = false;
		}

		/**
		 * Build cart amount HTML.
		 */
		$amount_position = suki_get_theme_mod( 'header_cart_amount', '' );

		$amount_html = '';

		if ( '' !== $amount_position ) {
			$classes = array();

			$hide_devices = array_diff( array( 'desktop', 'tablet', 'mobile' ), suki_get_theme_mod( 'header_cart_amount_visibility' ) );

			foreach ( $hide_devices as $device ) {
				$classes[] = esc_attr( 'suki-hide-on-' . $device );
			}

			$amount_html = '<span class="cart-amount ' . esc_attr( implode( ' ', $classes ) ) . '">' . $cart->get_cart_total() . '</span>';
		}

		ob_start();
		?>
		<div class="suki-header-cart-dropdown suki-header-cart menu <?php echo $is_dropdown ? esc_attr( 'suki-toggle-menu' ) : ''; ?>">
			<div class="menu-item">
				<?php
				if ( $is_dropdown ) {
					?>
					<button class="cart-link suki-menu-item-link suki-sub-menu-toggle suki-toggle" aria-expanded="false">
					<?php
				} else {
					?>
					<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="cart-link suki-menu-item-link">
					<?php
				}
				?>

				<span class="screen-reader-text"><?php esc_html_e( 'Shopping Cart', 'suki' ); ?></span>

				<?php
				if ( 'before' === $amount_position ) {
					echo $amount_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
				?>

				<span class="cart-icon">
					<?php suki_icon( 'cart', array( 'class' => 'suki-menu-icon' ) ); ?>
				</span>

				<span class="cart-count" data-count="<?php echo esc_attr( $cart->get_cart_contents_count() ); ?>"><?php echo $cart->get_cart_contents_count(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>

				<?php
				if ( 'after' === $amount_position ) {
					echo $amount_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
				?>

				<?php
				if ( $is_dropdown ) {
					?>
					</button>
					<div class="sub-menu">
						<?php echo $dropdown_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
					<?php
				} else {
					?>
					</a>
					<?php
				}
				?>
			</div>
		</div>
		<?php
		$html = ob_get_clean();

		return $html;
	}

	/**
	 * Exclude page settings meta box on shop page.
	 *
	 * @param array $ids Post IDs.
	 * @return array
	 */
	public function exclude_page_settings_on_shop_page( $ids ) {
		$ids[] = wc_get_page_id( 'shop' );

		return $ids;
	}

	/**
	 * Set default values of Dynamic page layout settings for Cart, Checkout, and My Acount pages.
	 *
	 * @param integer $old_value Old value.
	 * @param integer $value     New value.
	 * @param string  $option    Option.
	 */
	public function set_default_page_settings_on_woocommerce_pages( $old_value, $value, $option ) {
		// Abort if the changed option key is not WooCommerce's cart, checkout, and myaccount page ID.
		if ( ! in_array( $option, array( 'woocommerce_cart_page_id', 'woocommerce_checkout_page_id', 'woocommerce_myaccount_page_id' ), true ) ) {
			return;
		}

		// Get the settings, if exists.
		$page_settings = get_post_meta( $value, 'suki_page_settings', true );
		if ( empty( $page_settings ) ) {
			$page_settings = array();
		}

		// If "Container Width" is not set yet, set it to the default value.
		if ( ! isset( $page_settings['content_container'] ) ) {
			$page_settings['content_container'] = 'wide';
		}

		// If "Container Width" is not set yet, set it to the default value.
		if ( ! isset( $page_settings['content_layout'] ) ) {
			$page_settings['content_layout'] = 'no-sidebar';
		}

		// Update the post meta.
		update_post_meta( $value, 'suki_page_settings', $page_settings );
	}

	/**
	 * ====================================================
	 * Global Filters functions
	 * ====================================================
	 */

	/**
	 * Mobile screen breakpoint.
	 *
	 * @param string $px Screen size in px.
	 * @return string
	 */
	public function set_smallscreen_breakpoint( $px ) {
		return suki_get_breakpoint( 'tablet', -1 );
	}

	/**
	 * Add items count to Cart menu item.
	 *
	 * @param string  $title Title string.
	 * @param WP_Post $item  Post object.
	 * @param array   $args  Arguments array.
	 * @param integer $depth Depth level.
	 * @return string
	 */
	public function add_count_to_cart_menu_item( $title, $item, $args, $depth ) {
		// Add items count to "Cart" menu.
		if ( 'page' === $item->object && get_option( 'woocommerce_cart_page_id' ) === $item->object_id ) {
			if ( strpos( $title, '{{count}}' ) ) {
				$cart = WC()->cart;
				if ( ! empty( $cart ) ) {
					$count = $cart->cart_contents_count;
				} else {
					$count = 0;
				}
				$title = str_replace( '{{count}}', '(<span class="cart-count" data-count="' . $count . '">' . $count . '</span>)', $title );
			}
		}

		return $title;
	}

	/**
	 * AJAX update items count on header cart menu & icon.
	 *
	 * @param array $fragments Fragments array.
	 * @return array
	 */
	public function update_header_cart( $fragments ) {
		$count = WC()->cart->get_cart_contents_count();

		$fragments['.cart-count'] = '<span class="cart-count" data-count="' . $count . '">' . $count . '</span>';

		return $fragments;
	}

	/**
	 * Improve products loop wrapper HTML markup.
	 *
	 * @param string $html HTML markup string.
	 * @return string
	 */
	public function change_loop_start_markup( $html ) {
		// Add custom filter to allow further class modification.
		$html = preg_replace( '/(class=".*?)"/', '$1 ' . implode( ' ', apply_filters( 'suki/frontend/woocommerce/loop_classes', array() ) ) . '"', $html );

		return $html;
	}

	/**
	 * Add SVG icon to product search widget HTML.
	 *
	 * @param string $html HTML markup string.
	 * @return string
	 */
	public function change_product_search_form_markup( $html ) {
		// Add search icon.
		$html = preg_replace( '/<\/form>/', suki_icon( 'search', array( 'class' => 'suki-search-icon' ), false ) . '</form>', $html );

		return $html;
	}

	/**
	 * Modify "added to cart" message.
	 *
	 * @param string  $html     HTML markup string.
	 * @param array   $products Products array.
	 * @param boolean $show_qty Show quantity or not.
	 * @return string
	 */
	public function change_add_to_cart_message_markup( $html, $products, $show_qty ) {
		// Swap position of text and link.
		$html = preg_replace( '/(<a .*?>.*?<\/a>) (.*)/', '$2 $1', $html );

		return $html;
	}

	/**
	 * Modify flexslider settings on single product page.
	 *
	 * @param array $options Options array.
	 * @return array
	 */
	public function change_single_product_carousel_options( $options ) {
		$options['animation']      = 'fade';
		$options['animationSpeed'] = 250;

		return $options;
	}

	/**
	 * Modify page title text.
	 *
	 * @param string $page_title Page title text.
	 * @return string
	 */
	public function modify_page_title( $page_title ) {
		if ( is_tax() ) {
			$customized_format = suki_get_theme_mod( 'product_archive_tax_title_text' );

			if ( ! empty( $customized_format ) ) {
				$term_obj     = get_queried_object();
				$taxonomy_obj = get_taxonomy( $term_obj->taxonomy );

				$page_title = $customized_format;
				$page_title = str_replace( '{{taxonomy}}', $taxonomy_obj->labels->singular_name, $page_title );
				$page_title = str_replace( '{{term}}', $term_obj->name, $page_title );
			}
		}

		return $page_title;
	}

	/**
	 * Modify breadcrumb.
	 *
	 * @param array $defaults Default configurations array.
	 * @return array
	 */
	public function modify_breadcrumb_defaults( $defaults ) {
		$defaults['delimiter'] = '<span class="suki-woocommerce-breadcrumb__delimiter"></span>';

		return $defaults;
	}

	/**
	 * Modify breadcrumb.
	 *
	 * @param string $html HTML markup string.
	 * @return string
	 */
	public function modify_breadcrumb_html( $html ) {
		// Make sure it's WooCommerce page.
		if ( is_woocommerce() ) {
			// If user chose not to use theme's breadcrumb, use WooCommerce breadcrumb.
			if ( ! boolval( suki_get_theme_mod( 'woocommerce_breadcrumb_use_theme_module' ) ) ) {
				ob_start();
				woocommerce_breadcrumb();
				$html = ob_get_clean();
			}
		}

		return $html;
	}

	/**
	 * Change "Products" in theme's breadcrumb trails to Shop page's title.
	 *
	 * @param array $items Breadcrumb items array.
	 * @return array
	 */
	public function modify_theme_breadcrumb_trails( $items ) {
		// Make sure it's WooCommerce page.
		if ( is_woocommerce() ) {
			// If there's archive page in the trail, change it.
			if ( isset( $items['post_type_archive'] ) ) {
				$items['post_type_archive']['label'] = get_the_title( wc_get_page_id( 'shop' ) );
			}

			// Build product categories trails on single product page.
			if ( is_product() ) {
				$terms = wc_get_product_terms(
					get_the_ID(),
					'product_cat',
					array(
						'orderby' => 'parent',
						'order'   => 'DESC',
					)
				);

				if ( $terms ) {
					$main_term = $terms[0];

					$parents = get_ancestors( $main_term->term_id, 'product_cat' );

					// Add parent categories.
					$i = count( $parents );
					while ( $i > 0 ) {
						$parent_term = get_term( $parents[ $i - 1 ], 'product_cat' );

						$cat_items[ 'term_parent__' . $i ] = array(
							'label' => $parent_term->name,
							'url'   => get_term_link( $parent_term ),
						);

						$i--;
					}

					// Add direct main category.
					$cat_items['term'] = array(
						'label' => $main_term->name,
						'url'   => get_category_link( $main_term ),
					);

					// Insert the product categories into trails.
					$items = array_merge(
						array_slice( $items, 0, count( $items ) - 1 ),
						$cat_items,
						array_slice( $items, count( $items ) - 1, null )
					);
				}
			}
		}

		return $items;
	}

	/**
	 * Add text alignment class on loop start tag.
	 *
	 * @param array $classes Classes array.
	 * @return array
	 */
	public function add_loop_item_alignment_class( $classes ) {
		$classes['text_alignment'] = esc_attr( 'has-text-align-' . suki_get_theme_mod( 'woocommerce_products_grid_text_alignment' ) );

		return $classes;
	}

	/**
	 * Modify content header elements markup.
	 *
	 * @param string $html      HTML markup string.
	 * @param string $element   Element slug.
	 * @param string $alignment Element alignment (left, center, or right).
	 * @return array
	 */
	public function modify_content_header_elements( $html, $element, $alignment ) {
		// Abort if current loaded page is not a WooCommerce page.
		if ( ! is_woocommerce() ) {
			return $html;
		}

		switch ( $element ) {
			case 'title':
				if ( ! is_product() ) {
					$level = is_front_page() ? 2 : 1; // In front page, logo is the <h1>, so we use <h2> for this title.

					$html = '
					<!-- wp:heading {
						"level":' . esc_attr( $level ) . ',
						"textAlign":"' . esc_attr( $alignment ) . '",
						"className":"entry-title suki-title"
					} --><h' . esc_attr( $level ) . ' class="has-text-align-' . esc_attr( $alignment ) . ' entry-title suki-title">' . woocommerce_page_title( false ) . '</h' . esc_attr( $level ) . '><!-- /wp:heading -->
					';
				}
				break;

			case 'archive-description':
				ob_start();
				woocommerce_taxonomy_archive_description();
				$html = ob_get_clean();
				break;

			case 'product-rating':
				wc_setup_product_data( get_queried_object() );

				ob_start();
				woocommerce_template_single_rating();
				$html = ob_get_clean();
				break;
		}

		return $html;
	}

	/**
	 * ====================================================
	 * Global Hooks functions
	 * ====================================================
	 */

	/**
	 * Render opening template wrapper.
	 */
	public function render_template_wrapper() {
		?>
		<div class="woocommerce">
		<?php
	}

	/**
	 * Render closing template wrapper.
	 */
	public function render_template_wrapper_end() {
		?>
		</div>
		<?php
	}

	/**
	 * Render plus and minus buttons to the quantity input.
	 */
	public function render_quantity_plus_minus_buttons() {
		?>
		<span class="suki-qty-increment suki-qty-minus" data-operator="-" role="button" tabindex="0">-</span>
		<span class="suki-qty-increment suki-qty-plus" data-operator="+" role="button" tabindex="0">+</span>
		<?php
	}

	/**
	 * Render plus and minus buttons to the quantity input via JS.
	 */
	public function render_quantity_plus_minus_buttons_scripts() {
		// Add inline JS to initiate quantity plus minus UI.
		// This javascript uses jQuery to hook into WooCommerce event callback (WooCommerce uses jQuery).
		ob_start();
		?>
		(function() {
			'use strict';

			const handleWooCommerceQuantityIncrementButtons = ( e ) => {
				// Only handle "suki-qty-increment" button.
				if ( e.target.classList.contains( 'suki-qty-increment' ) ) {
					// Prevent default handlers on click and touch event.
					if ( 'click' === e.type || 'touchend' === e.type ) {
						e.preventDefault();
					}

					// Abort if keydown is not enter or space key.
					else if ( 'keydown' === e.type && 13 !== e.which && 32 !== e.which ) {
						return;
					}

					const $button = e.target;
					const $input = $button.parentElement.querySelector( '.qty' );
					const step = parseInt( $input.step ) || 1;
					const min = parseInt( $input.min ) || 0;
					const max = parseInt( $input.max ) || Number.MAX_SAFE_INTEGER;
					const operator = $button.dataset.operator;

					// Adjust the input value according to the clicked button.
					if ( '-' === operator ) {
						const oldValue = parseInt( $input.value ) || 0;
						const newValue = oldValue - step;

						if ( min > newValue ) {
							$input.value = parseInt( min );
						} else {
							$input.value = parseInt( newValue );
						}
					} else {
						const oldValue = parseInt( $input.value ) || 0;
						const newValue = oldValue + step;

						if ( max < newValue ) {
							$input.value = parseInt( max );
						} else {
							$input.value = parseInt( newValue );
						}
					}

					// Trigger "change" event on the input field (use old fashioned way for IE compatibility).
					const event = document.createEvent( 'HTMLEvents' );
					event.initEvent( 'change', true, false);
					$input.dispatchEvent( event );
				}
			};

			document.body.addEventListener( 'click', handleWooCommerceQuantityIncrementButtons );
			document.body.addEventListener( 'touchend', handleWooCommerceQuantityIncrementButtons );
			document.body.addEventListener( 'keydown', handleWooCommerceQuantityIncrementButtons );
		})();
		<?php
		$js = ob_get_clean();

		// Add right after WooCommerce main js.
		wp_add_inline_script( 'woocommerce', $js );
	}

	/**
	 * ====================================================
	 * Shop Page Hook functions
	 * ====================================================
	 */

	/**
	 * Render products archive header.
	 */
	public function render_archive_header() {
		ob_start();
		?>
		<!-- wp:group {
			"className":"suki-content-header"
		} --><div class="wp-block-group suki-content-header">

			<?php
			suki_content_header( false );
			?>

		</div><!-- /wp:group -->
		<?php
		$html = ob_get_clean();

		echo do_blocks( $html ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Render opening products filters wrapper tag.
	 */
	public function render_loop_filters_wrapper() {
		?>
		<div class="suki-woocommerce-loop__filters">
		<?php
	}

	/**
	 * Render closing products filters wrapper tag.
	 */
	public function render_loop_filters_wrapper_end() {
		?>
		</div>
		<?php
	}

	/**
	 * Add opening product image wrapper tag.
	 */
	public function render_loop_product_thumbnail_wrapper() {
		?>
		<div class="<?php echo esc_attr( implode( ' ', apply_filters( 'suki/frontend/woocommerce/loop_item_thumbnail_classes', array( 'suki-woocommerce-loop-item__thumbnail' ) ) ) ); ?>">
		<?php
	}

	/**
	 * Add closing product image wrapper tag.
	 */
	public function render_loop_product_thumbnail_wrapper_end() {
		?>
		</div>
		<?php
	}

	/**
	 * Set products loop posts per page.
	 *
	 * @param integer $posts_per_page Number of posts per page.
	 * @return integer
	 */
	public function set_loop_posts_per_page( $posts_per_page ) {
		return intval( suki_get_theme_mod( 'woocommerce_index_posts_per_page' ) );
	}

	/**
	 * Set products loop columns.
	 *
	 * @param integer $cols Number of columns.
	 * @return integer
	 */
	public function set_loop_columns( $cols ) {
		return intval( suki_get_theme_mod( 'woocommerce_index_grid_columns' ) );
	}

	/**
	 * ====================================================
	 * Product Page Hook functions
	 * ====================================================
	 */

	/**
	 * Render products product header.
	 */
	public function render_product_header() {
		ob_start();
		?>
		<!-- wp:group {
			"style":{
				"spacing":{
					"margin":{
						"bottom":"calc(2 * var(--wp--style--block-gap))"
					}
				}
			},
			"className":"suki-content-header"
		} --><div class="wp-block-group suki-content-header" style="margin-bottom:calc(2 * var(--wp--style--block-gap))">

			<?php
			suki_content_header( false );
			?>

		</div><!-- /wp:group -->
		<?php
		$html = ob_get_clean();

		echo do_blocks( $html ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Render opening product images wrapper tag.
	 */
	public function render_product_images_wrapper() {
		?>
		<div class="suki-woocommerce-product__images">
		<?php
	}

	/**
	 * Render closing product images wrapper tag.
	 */
	public function render_product_images_wrapper_end() {
		?>
		</div>
		<?php
	}

	/**
	 * Add class on single product gallery whether it contains single image or multiple images.
	 *
	 * @param array $classes Classes array.
	 * @return array
	 */
	public function add_single_product_gallery_class( $classes ) {
		global $product;

		$gallery_ids = $product->get_gallery_image_ids();

		if ( 0 < count( $gallery_ids ) ) {
			$classes['gallery_multiple_images'] = esc_attr( 'suki-woocommerce-single-gallery-multiple-images' );
		}

		return $classes;
	}

	/**
	 * Set Product thumbnails columns in single product page.
	 *
	 * @param integer $columns Number of columns.
	 * @return integer
	 */
	public function set_product_thumbnails_columns( $columns ) {
		return 8;
	}

	/**
	 * Add opening add to cart form's wrapper tag.
	 */
	public function render_add_to_cart_form_wrapper() {
		?>
		<div class="<?php echo esc_attr( implode( ' ', apply_filters( 'suki/frontend/woocommerce/add_to_cart_form_classes', array( 'suki-woocommerce-product__add-to-cart' ) ) ) ); ?>">
		<?php
	}

	/**
	 * Add closing add to cart form's wrapper tag.
	 */
	public function render_add_to_cart_form_wrapper_end() {
		?>
		</div>
		<?php
	}

	/**
	 * Set review avatar size.
	 *
	 * @param string $size Avatar size in pixel.
	 * @return string
	 */
	public function set_review_avatar_size( $size ) {
		return '50';
	}

	/**
	 * Keep / remove related products.
	 *
	 * @param array $args Arguments array.
	 * @return array
	 */
	public function set_related_products_args( $args ) {
		if ( 0 === intval( suki_get_theme_mod( 'woocommerce_single_related_posts_per_page' ) ) ) {
			return array();
		}

		return $args;
	}

	/**
	 * Set related products columns.
	 *
	 * @param integer $columns Number of columns.
	 * @return integer
	 */
	public function set_related_products_columns( $columns ) {
		return intval( suki_get_theme_mod( 'woocommerce_single_related_grid_columns' ) );
	}

	/**
	 * Set related products arguments.
	 *
	 * @param array $args Arguments array.
	 * @return array
	 */
	public function set_related_products_display_args( $args ) {
		// phpcs:ignore WordPress.WP.PostsPerPage.posts_per_page_posts_per_page
		$args['posts_per_page'] = intval( suki_get_theme_mod( 'woocommerce_single_related_posts_per_page' ) );
		$args['columns']        = intval( suki_get_theme_mod( 'woocommerce_single_related_grid_columns' ) );

		return $args;
	}

	/**
	 * Set up-sells columns.
	 *
	 * @param integer $columns Number of columns.
	 * @return integer
	 */
	public function set_up_sells_columns( $columns ) {
		return intval( suki_get_theme_mod( 'woocommerce_single_up_sells_grid_columns' ) );
	}

	/**
	 * Set up-sells products arguments.
	 *
	 * @param array $args Arguments array.
	 * @return array
	 */
	public function set_up_sells_display_args( $args ) {
		$args['columns'] = intval( suki_get_theme_mod( 'woocommerce_single_up_sells_grid_columns' ) );

		return $args;
	}

	/**
	 * ====================================================
	 * Cart Page Hook functions
	 * ====================================================
	 */

	/**
	 * Add opening 2 columns cart wrapper tag.
	 */
	public function render_cart_2_columns_wrapper() {
		?>
		<div class="suki-woocommerce-cart-2-columns">
		<?php
	}

	/**
	 * Add closing 2 columns cart wrapper tag.
	 */
	public function render_cart_2_columns_wrapper_end() {
		?>
		</div>
		<?php
	}

	/**
	 * Add opening 2 columns cart left columns wrapper tag.
	 */
	public function render_cart_2_columns_left_wrapper() {
		?>
		<div class="suki-woocommerce-cart-2-columns__column suki-woocommerce-cart-2-columns__column--left">
		<?php
	}

	/**
	 * Add closing 2 columns cart left columns wrapper tag.
	 */
	public function render_cart_2_columns_left_wrapper_end() {
		?>
		</div>
		<?php
	}

	/**
	 * Add opening 2 columns cart right columns wrapper tag.
	 */
	public function render_cart_2_columns_right_wrapper() {
		?>
		<div class="suki-woocommerce-cart-2-columns__column suki-woocommerce-cart-2-columns__column--right">
		<?php
	}

	/**
	 * Add opening 2 columns cart right columns wrapper tag.
	 */
	public function render_cart_2_columns_right_wrapper_end() {
		?>
		</div>
		<?php
	}

	/**
	 * Set cross-sells columns.
	 *
	 * @param integer $columns Number of columns.
	 * @return integer
	 */
	public function set_cart_page_cross_sells_columns( $columns ) {
		return intval( suki_get_theme_mod( 'woocommerce_cart_cross_sells_grid_columns' ) );
	}

	/**
	 * ====================================================
	 * Checkout Page Hook functions
	 * ====================================================
	 */

	/**
	 * Add opening 2 columns checkout wrapper tag.
	 */
	public function render_checkout_2_columns_wrapper() {
		?>
		<div class="suki-woocommerce-checkout-2-columns">
		<?php
	}

	/**
	 * Add closing 2 columns checkout wrapper tag.
	 */
	public function render_checkout_2_columns_wrapper_end() {
		?>
		</div>
		<?php
	}

	/**
	 * Add opening 2 columns checkout left columns wrapper tag.
	 */
	public function render_checkout_2_columns_left_wrapper() {
		?>
		<div class="suki-woocommerce-checkout-2-columns__column--left">
		<?php
	}

	/**
	 * Add closing 2 columns checkout left columns wrapper tag.
	 */
	public function render_checkout_2_columns_left_wrapper_end() {
		?>
		</div>
		<?php
	}

	/**
	 * Add opening 2 columns checkout right columns wrapper tag.
	 */
	public function render_checkout_2_columns_right_wrapper() {
		?>
		<div class="suki-woocommerce-checkout-2-columns__column--right">
		<?php
	}

	/**
	 * Add opening 2 columns checkout right columns wrapper tag.
	 */
	public function render_checkout_2_columns_right_wrapper_end() {
		?>
		</div>
		<?php
	}

	/**
	 * ====================================================
	 * My Account Page Hook functions
	 * ====================================================
	 */

	/**
	 * Render opening wrapper tag to wrap account sidebar.
	 */
	public function render_account_sidebar_wrapper() {
		$user = wp_get_current_user();
		?>
		<div class="suki-woocommerce-account__sidebar">
			<div class="suki-woocommerce-account__user-info">
				<?php echo get_avatar( $user->ID, 50 ); ?>
				<strong class="name"><?php echo esc_html( $user->display_name ); ?></strong>
			</div>
		<?php
	}

	/**
	 * Render closing wrapper tag to wrap account sidebar.
	 */
	public function render_account_sidebar_wrapper_end() {
		?>
		</div>
		<?php
	}
}

Suki_Compatibility_WooCommerce::instance();
