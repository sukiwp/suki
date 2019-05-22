<?php
/**
 * Plugin compatibility: WooCommerce
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

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
		// Theme supports
		add_action( 'after_setup_theme', array( $this, 'add_theme_supports' ) );

		// Compatibility CSS
		add_action( 'suki/frontend/before_enqueue_main_css', array( $this, 'enqueue_css' ) );

		// Customizer settings & values
		add_action( 'customize_register', array( $this, 'register_customizer_settings' ) );
		add_filter( 'suki/customizer/setting_defaults', array( $this, 'add_customizer_setting_defaults' ) );
		add_filter( 'suki/customizer/setting_postmessages', array( $this, 'add_customizer_setting_postmessages' ) );

		// Template hooks
		add_action( 'widgets_init', array( $this, 'register_sidebars' ) );
		add_action( 'init', array( $this, 'modify_template_hooks' ) );
		add_action( 'wp', array( $this, 'modify_template_hooks_based_on_page_type' ) );
		
		// Page settings
		add_action( 'suki/admin/metabox/page_settings/disabled_posts', array( $this, 'exclude_shop_page_from_page_settings' ), 10, 2 );
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
	 * Enqueue compatibility CSS.
	 */
	public function enqueue_css() {
		wp_enqueue_style( 'suki-woocommerce', SUKI_CSS_URL . '/compatibilities/woocommerce' . SUKI_ASSETS_SUFFIX . '.css', array(), SUKI_VERSION );
		wp_style_add_data( 'suki-woocommerce', 'rtl', 'replace' );
	}

	/**
	 * Register customizer sections, settings, and controls.
	 *
	 * @param WP_Customize_Manager $wp_customize
	 */
	public function register_customizer_settings( $wp_customize ) {
		$defaults = Suki_Customizer::instance()->get_setting_defaults();
		
		require_once( SUKI_INCLUDES_DIR . '/compatibilities/woocommerce/customizer/options/_sections.php' );
		require_once( SUKI_INCLUDES_DIR . '/compatibilities/woocommerce/customizer/options/woocommerce--store-notice.php' );
		require_once( SUKI_INCLUDES_DIR . '/compatibilities/woocommerce/customizer/options/woocommerce--product-catalog.php' );
		require_once( SUKI_INCLUDES_DIR . '/compatibilities/woocommerce/customizer/options/woocommerce--product-single.php' );
		require_once( SUKI_INCLUDES_DIR . '/compatibilities/woocommerce/customizer/options/woocommerce--cart.php' );
		require_once( SUKI_INCLUDES_DIR . '/compatibilities/woocommerce/customizer/options/woocommerce--checkout.php' );
		require_once( SUKI_INCLUDES_DIR . '/compatibilities/woocommerce/customizer/options/woocommerce--products-grid.php' );
		require_once( SUKI_INCLUDES_DIR . '/compatibilities/woocommerce/customizer/options/woocommerce--other-elements.php' );
	}

	/**
	 * Add default values for all Customizer settings.
	 *
	 * @param array $defaults
	 * @return array
	 */
	public function add_customizer_setting_defaults( $defaults = array() ) {
		include( SUKI_INCLUDES_DIR . '/compatibilities/woocommerce/customizer/defaults.php' );

		return $defaults;
	}

	/**
	 * Add postmessage rules for some Customizer settings.
	 *
	 * @param array $postmessages
	 * @return array
	 */
	public function add_customizer_setting_postmessages( $postmessages = array() ) {
		include( SUKI_INCLUDES_DIR . '/compatibilities/woocommerce/customizer/postmessages.php' );

		return $postmessages;
	}

	/**
	 * Register additional sidebar for WooCommerce.
	 */
	public function register_sidebars() {
		register_sidebar( array(
			'name'          => esc_html__( 'Sidebar Shop', 'suki' ),
			'id'            => 'sidebar-shop',
			'description'   => esc_html__( 'Sidebar that replaces the default sidebar when on WooCommerce pages.', 'suki' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title h4">',
			'after_title'   => '</h2>',
		) );
	}

	/**
	 * Modify filters for WooCommerce template rendering.
	 */
	public function modify_template_hooks() {
		/**
		 * Global template hooks
		 */

		// Change main content (primary) wrapper.
		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
		remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
		add_action( 'woocommerce_before_main_content', 'suki_primary_open' );
		add_action( 'woocommerce_after_main_content', 'suki_primary_close' );

		// Add count to Cart menu item.
		add_filter( 'nav_menu_item_title', array( $this, 'add_count_to_cart_menu_item' ), 10, 4 );

		// Add filter for adding class to products grid wrapper.
		add_filter( 'woocommerce_product_loop_start', array( $this, 'change_loop_start_markup' ) );

		// Change sale badge tags.
		add_filter( 'woocommerce_sale_flash', array( $this, 'change_sale_badge_markup' ), 99, 3 );

		// Demo Store notice.
		remove_action( 'wp_footer', 'woocommerce_demo_store' );
		add_action( 'suki/frontend/before_header', 'woocommerce_demo_store' );

		// Wrap star rating HTML
		add_filter( 'woocommerce_product_get_rating_html', array( $this, 'change_star_rating_markup' ), 10, 3 );

		// Change mobile devices breakpoint.
		add_filter( 'woocommerce_style_smallscreen_breakpoint', array( $this, 'set_smallscreen_breakpoint' ) );

		// Change gravatar size on reviews.
		add_filter( 'woocommerce_review_gravatar_size', array( $this, 'set_review_gravatar_size' ) );

		// Add cart fragments.
		add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'update_header_cart' ) );

		// Product search form widget
		add_filter( 'get_product_search_form', array( $this, 'add_icon_to_product_search_widget' ) );

		// Add text alignment class on products loop.
		add_filter( 'suki/frontend/woocommerce/loop_item_classes', array( $this, 'add_loop_item_alignment_class' ) );

		// Modify "added to cart" message.
		add_filter( 'wc_add_to_cart_message_html', array( $this, 'change_add_to_cart_message_html' ), 10, 3 );

		// Keep / remove "add to cart" button on products grid.
		if ( ! intval( suki_get_theme_mod( 'woocommerce_products_grid_item_add_to_cart' ) ) ) {
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
		}

		/**
		 * Shop page's template hooks
		 */

		// Add wrapper to products grid filters.
		add_action( 'woocommerce_before_shop_loop', array( $this, 'render_loop_filters_wrapper' ), 11 );
		add_action( 'woocommerce_before_shop_loop', array( $this, 'render_loop_filters_wrapper_end' ), 99 );

		// Add wrapper to products grid item.
		add_action( 'woocommerce_before_shop_loop_item', array( $this, 'render_loop_item_wrapper' ), 1 );
		add_action( 'woocommerce_after_shop_loop_item', array( $this, 'render_loop_item_wrapper_end' ), 999 );

		// Reposition sale badge on products grid item.
		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
		add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 1 );

		// Reposition product image and wrap it with custom <div>.
		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
		add_action( 'woocommerce_before_shop_loop_item', array( $this, 'render_loop_product_thumbnail_wrapper' ), 2 );
		add_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 5 );
		add_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_thumbnail', 10 );
		add_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_close', 15 );
		add_action( 'woocommerce_before_shop_loop_item', array( $this, 'render_loop_product_thumbnail_wrapper_end' ), 20 );

		// Wrap the title with link.
		remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
		add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 1 );
		add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 999 );

		// Products loop
		add_filter( 'loop_shop_per_page', array( $this, 'set_loop_posts_per_page' ) );
		add_filter( 'loop_shop_columns', array( $this, 'set_loop_columns' ) );

		/**
		 * Product page's template hooks
		 */

		// Add a new filter to add additional classes to single product wrapper.
		add_action( 'woocommerce_before_single_product', array( $this, 'add_single_product_class' ) );

		// Add class to single product gallery for single image or multiple images.
		add_filter( 'woocommerce_single_product_image_gallery_classes', array( $this, 'add_single_product_gallery_class' ) );

		// Move sale badge
		remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
		add_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 21 );

		// Set product images thumbnails columns.
		add_filter( 'woocommerce_product_thumbnails_columns', array( $this, 'set_product_thumbnails_columns' ) );

		// Add wrapper to single product add to cart form.
		add_filter( 'woocommerce_before_add_to_cart_form', array( $this, 'render_add_to_cart_form_wrapper' ) );
		add_filter( 'woocommerce_after_add_to_cart_form', array( $this, 'render_add_to_cart_form_wrapper_end' ) );

		// Related products
		add_filter( 'woocommerce_related_products_args', array( $this, 'set_related_products_args' ) );
		add_filter( 'woocommerce_related_products_columns', array( $this, 'set_related_products_columns' ) );
		add_filter( 'woocommerce_output_related_products_args', array( $this, 'set_related_products_display_args' ) );

		// Up sells
		add_filter( 'woocommerce_up_sells_columns', array( $this, 'set_up_sells_columns' ) );
		add_filter( 'woocommerce_upsell_display_args', array( $this, 'set_up_sells_display_args' ) );

		/**
		 * Cart page's template hooks
		 */

		// Cross sells columns
		add_filter( 'woocommerce_cross_sells_columns', array( $this, 'set_cart_page_cross_sells_columns' ) );

		/**
		 * Checkout page's template hooks
		 */

		// Split into 2 columns.
		if ( intval( suki_get_theme_mod( 'woocommerce_checkout_two_columns' ) ) ) {
			add_action( 'woocommerce_checkout_before_customer_details', array( $this, 'render_checkout_two_columns_wrapper' ), 1 );
			add_action( 'woocommerce_checkout_before_customer_details', array( $this, 'render_checkout_two_columns__column_1_wrapper' ), 1 );
			add_action( 'woocommerce_checkout_after_customer_details', array( $this, 'render_checkout_two_columns__column_1_wrapper_end' ), 999 );
			add_action( 'woocommerce_checkout_after_customer_details', array( $this, 'render_checkout_two_columns__column_2_wrapper' ), 999 );
			add_action( 'woocommerce_checkout_after_order_review', array( $this, 'render_checkout_two_columns__column_2_wrapper_end' ), 999 );
			add_action( 'woocommerce_checkout_after_order_review', array( $this, 'render_checkout_two_columns_wrapper_end' ), 999 );
		}

		/**
		 * My Account page's template hooks
		 */

		// Add account avatar and name into side navigation.
		add_filter( 'woocommerce_before_account_navigation', array( $this, 'render_account_sidebar_wrapper' ) );
		add_filter( 'woocommerce_after_account_navigation', array( $this, 'render_account_sidebar_wrapper_end' ) );
	}

	/**
	 * Modify filters for WooCommerce template rendering based on Customizer settings.
	 */
	public function modify_template_hooks_based_on_page_type() {
		/**
		 * Shop page's template hooks
		 */

		if ( is_shop() || is_product_taxonomy() ) {
			// Keep / remove page title.
			if ( ! intval( suki_get_theme_mod( 'woocommerce_index_page_title' ) ) ) {
				add_filter( 'woocommerce_show_page_title', '__return_false' );
			}

			// Keep / remove breadcrumb.
			if ( ! intval( suki_get_theme_mod( 'woocommerce_index_breadcrumb' ) ) ) {
				remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
			}

			// Keep / remove products count filter.
			if ( ! intval( suki_get_theme_mod( 'woocommerce_index_results_count' ) ) ) {
				remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
			}

			// Keep / remove products sorting filter.
			if ( ! intval( suki_get_theme_mod( 'woocommerce_index_sort_filter' ) ) ) {
				remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
			}
		}

		/**
		 * Products page's template hooks
		 */

		if ( is_product() ) {
			// Keep / remove breadcrumb.
			if ( ! intval( suki_get_theme_mod( 'woocommerce_single_breadcrumb' ) ) ) {
				remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
			} else {
				remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
				add_action( 'woocommerce_single_product_summary', 'woocommerce_breadcrumb', 1 );
			}

			// Keep / remove gallery.
			if ( ! intval( suki_get_theme_mod( 'woocommerce_single_gallery' ) ) ) {
				remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
			}

			// Keep / remove gallery zoom module.
			if ( ! intval( suki_get_theme_mod( 'woocommerce_single_gallery_zoom' ) ) ) {
				remove_theme_support( 'wc-product-gallery-zoom' );
			}

			// Keep / remove gallery lightbox module.
			if ( ! intval( suki_get_theme_mod( 'woocommerce_single_gallery_lightbox' ) ) ) {
				remove_theme_support( 'wc-product-gallery-lightbox' );
			}

			// Keep / remove tabs.
			if ( ! intval( suki_get_theme_mod( 'woocommerce_single_tabs' ) ) ) {
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
			}

			// Keep / remove up-sells.
			if ( ! intval( suki_get_theme_mod( 'woocommerce_single_up_sells' ) ) ) {
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
			}

			// Keep / remove up-sells.
			if ( ! intval( suki_get_theme_mod( 'woocommerce_single_related' ) ) ) {
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
			}
		}
	}

	/**
	 * Modify page settings metabox.
	 *
	 * @param array $ids
	 * @param array $post
	 * @return array
	 */
	public function exclude_shop_page_from_page_settings( $ids, $post ) {
		if ( $post->ID === wc_get_page_id( 'shop' ) ) {
			$ids[ $post->ID ] = '<p><a href="' . esc_attr( add_query_arg( array( 'autofocus[section]' => 'suki_section_page_settings_product_archive', 'url' => esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ) ), admin_url( 'customize.php' ) ) ) . '">' .  esc_html__( 'Edit Page settings here', 'suki' ) . '</a></p>';
		}

		return $ids;
	}
	
	/**
	 * ====================================================
	 * Global Hook functions
	 * ====================================================
	 */

	/**
	 * Add items count to Cart menu item.
	 *
	 * @param string $title
	 * @param WP_Post $item
	 * @param array $args
	 * @param integer $depth
	 * @return string
	 */
	public function add_count_to_cart_menu_item( $title, $item, $args, $depth ) {
		// Add items count to "Cart" menu.
		if ( 'page' == $item->object && $item->object_id == get_option( 'woocommerce_cart_page_id' ) && class_exists( 'WooCommerce' ) ) {
			if ( strpos( $title, '{{count}}' ) ) {
				$cart = WC()->cart;
				if ( ! empty( $cart ) ) {
					$count = $cart->cart_contents_count;
				} else {
					$count = 0;
				}
				$title = str_replace( '{{count}}', '(<span class="shopping-cart-count" data-count="' . $count . '">' . $count . '</span>)', $title );
			}
		}

		return $title;
	}

	/**
	 * Improve products loop wrapper HTML markup.
	 *
	 * @param string $html
	 * @return string
	 */
	public function change_loop_start_markup( $html ) {
		$html = preg_replace( '/(class=".*?)"/', '$1 ' . implode( ' ', apply_filters( 'suki/frontend/woocommerce/loop_classes', array() ) ) . '"', $html );

		return $html;
	}

	/**
	 * Improve sale badge HTML markup.
	 *
	 * @param string $html
	 * @param WP_Post $post
	 * @param WC_Product $product
	 * @return string
	 */
	public function change_sale_badge_markup( $html, $post, $product ) {
		$html = preg_replace( '/<span class="onsale">(.*)<\/span>/', '<span class="onsale"><span>$1</span></span>', $html );

		return $html;
	}

	/**
	 * Improve star rating HTML markup.
	 *
	 * @param string $html
	 * @param float $rating
	 * @param integer $count
	 * @return string
	 */
	public function change_star_rating_markup( $html, $rating, $count ) {
		if ( ! empty( $html ) ) {
			$html = '<div class="suki-star-rating">' . $html . '</div>';
		}

		return $html;
	}

	/**
	 * Mobile screen breakpoint.
	 * 
	 * @param string $px
	 * @return string
	 */
	public function set_smallscreen_breakpoint( $px ) {
		return '767px';
	}

	/**
	 * Review gravatar size.
	 * 
	 * @param integer $size
	 * @return integer
	 */
	public function set_review_gravatar_size( $size ) {
		return 50;
	}

	/**
	 * AJAX update items count on header cart menu & icon.
	 */
	public function update_header_cart( $fragments ) {
		$count = WC()->cart->get_cart_contents_count();
		$fragments['.shopping-cart-count'] = '<span class="shopping-cart-count" data-count="' . $count . '">' . $count . '</span>';
		
		return $fragments;
	}

	/**
	 * Add SVG icon to product search widget HTML.
	 *
	 * @param string $from
	 * @return string
	 */
	public function add_icon_to_product_search_widget( $form ) {
		$form = preg_replace( '/<\/form>/', suki_icon( 'search', array( 'class' => 'suki-search-icon' ), false ) . '</form>', $form );

		return $form;
	}

	/**
	 * Add text alignment class on loop start tag.
	 *
	 * @param array $classes
	 * @return array
	 */
	public function add_loop_item_alignment_class( $classes ) {
		$classes['text_alignment'] = esc_attr( 'suki-text-align-' . suki_get_theme_mod( 'woocommerce_products_grid_text_alignment' ) );

		return $classes;
	}

	/**
	 * Modify "added to cart" message.
	 *
	 * @param string $message
	 * @param array $products
	 * @param boolean $show_qty
	 * @return string
	 */
	public function change_add_to_cart_message_html( $message, $products, $show_qty ) {
		$message = preg_replace( '/(<a .*?>.*?<\/a>) (.*)/', '$2 $1', $message );

		return $message;
	}
	
	/**
	 * ====================================================
	 * Shop Page Hook functions
	 * ====================================================
	 */

	/**
	 * Add opening products filters wrapper tag.
	 */
	public function render_loop_filters_wrapper() {
		?><div class="suki-products-filters"><?php
	}

	/**
	 * Add closing products filters wrapper tag.
	 */
	public function render_loop_filters_wrapper_end() {
		?></div><?php
	}

	/**
	 * Add opening product wrapper tag to products loop item.
	 */
	public function render_loop_item_wrapper() {
		?><div class="suki-product-wrapper <?php echo esc_attr( implode( ' ', apply_filters( 'suki/frontend/woocommerce/loop_item_classes', array() ) ) ); ?>"><?php
	}

	/**
	 * Add closing product wrapper tag to products loop item.
	 */
	public function render_loop_item_wrapper_end() {
		?></div><?php
	}

	/**
	 * Add opening product image wrapper tag.
	 */
	public function render_loop_product_thumbnail_wrapper() {
		?><div class="suki-product-thumbnail <?php echo esc_attr( implode( ' ', apply_filters( 'suki/frontend/woocommerce/loop_item_thumbnail_classes', array() ) ) ); ?>"><?php
	}

	/**
	 * Add closing product image wrapper tag.
	 */
	public function render_loop_product_thumbnail_wrapper_end() {
		?></div><?php
	}

	/**
	 * Set products loop posts per page.
	 * 
	 * @param integer $posts_per_page
	 * @return integer
	 */
	public function set_loop_posts_per_page( $posts_per_page ) {
		return intval( suki_get_theme_mod( 'woocommerce_index_posts_per_page' ) );
	}

	/**
	 * Set products loop columns.
	 * 
	 * @param integer $cols
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
	 * Add some classes on single product wrapper on single product template.
	 *
	 * @param array $classes
	 * @param array $class
	 * @param integer $post_id
	 * @return array
	 */
	public function add_single_product_class() {
		add_filter( 'post_class', array( $this, 'add_single_product_class_filter' ), 10, 3 );
	}

	/**
	 * Add some classes on single product wrapper via filter.
	 *
	 * @param array $classes
	 * @param array $class
	 * @param integer $post_id
	 * @return array
	 */
	public function add_single_product_class_filter( $classes, $class, $post_id ) {
		$classes = apply_filters( 'suki/frontend/woocommerce/single_product_classes', $classes );
		
		return $classes;
	}

	/**
	 * Add class on single product gallery whether it contains single image or multiple images.
	 *
	 * @param array $classes
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
	 * @param integer $columns
	 * @return integer
	 */
	public function set_product_thumbnails_columns( $columns ) {
		return 8;
	}

	/**
	 * Add opening add to cart form's wrapper tag.
	 */
	public function render_add_to_cart_form_wrapper() {
		?><div class="suki-product-add-to-cart <?php echo esc_attr( implode( ' ', apply_filters( 'suki/frontend/woocommerce/add_to_cart_form_classes', array() ) ) ); ?>"><?php
	}

	/**
	 * Add closing add to cart form's wrapper tag.
	 */
	public function render_add_to_cart_form_wrapper_end() {
		?></div><?php
	}

	/**
	 * Keep / remove related products.
	 * 
	 * @param array $args Array of arguments
	 * @return array
	 */
	public function set_related_products_args( $args ) {
		if ( 0 == intval( suki_get_theme_mod( 'woocommerce_single_related_posts_per_page' ) ) ) {
			return array();
		}

		return $args;
	}
	
	/**
	 * Set related products columns.
	 * 
	 * @param integer $columns Number of columns
	 * @return integer
	 */
	public function set_related_products_columns( $columns ) {
		return intval( suki_get_theme_mod( 'woocommerce_single_related_grid_columns' ) );
	}

	/**
	 * Set related products arguments.
	 * 
	 * @param array $args Array of arguments
	 * @return array
	 */
	public function set_related_products_display_args( $args ) {
		$args['posts_per_page'] = intval( suki_get_theme_mod( 'woocommerce_single_related_posts_per_page' ) );
		$args['columns'] = intval( suki_get_theme_mod( 'woocommerce_single_related_grid_columns' ) );

		return $args;
	}

	/**
	 * Set up-sells columns.
	 * 
	 * @param integer $columns Number of columns
	 * @return integer
	 */
	public function set_up_sells_columns( $columns ) {
		return intval( suki_get_theme_mod( 'woocommerce_single_up_sells_grid_columns' ) );
	}
	
	/**
	 * Set up-sells products arguments.
	 * 
	 * @param array $args Array of arguments
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
	 * Set cross-sells columns.
	 * 
	 * @param integer $columns Number of columns
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
	 * Add opening wrapper tag to wrap checkout form.
	 */
	public function render_checkout_two_columns_wrapper() {
		?>
		<div class="suki-woocommerce-checkout-2-columns">
		<?php
	}

	/**
	 * Add opening wrapper tag to wrap checkout form column 1.
	 */
	public function render_checkout_two_columns__column_1_wrapper() {
		?>
		<div class="suki-woocommerce-checkout-col-1">
		<?php
	}

	/**
	 * Add closing wrapper tag to wrap checkout form column 1.
	 */
	public function render_checkout_two_columns__column_1_wrapper_end() {
		?>
		</div>
		<?php
	}

	/**
	 * Add opening wrapper tag to wrap checkout form column 2.
	 */
	public function render_checkout_two_columns__column_2_wrapper() {
		?>
		<div class="suki-woocommerce-checkout-col-2">
		<?php
	}

	/**
	 * Add closing wrapper tag to wrap checkout form column 2.
	 */
	public function render_checkout_two_columns__column_2_wrapper_end() {
		$checkout = WC()->checkout;

		if ( $checkout->get_checkout_fields() ) : ?>
			</div>
		<?php endif;
	}

	/**
	 * Add closing wrapper tag to wrap checkout form.
	 */
	public function render_checkout_two_columns_wrapper_end() {
		$checkout = WC()->checkout;

		if ( $checkout->get_checkout_fields() ) : ?>
			</div>
		<?php endif;
	}

	/**
	 * ====================================================
	 * My Account Page Hook functions
	 * ====================================================
	 */

	/**
	 * Add opening wrapper tag to wrap account sidebar.
	 */
	public function render_account_sidebar_wrapper() {
		?>
		<div class="suki-woocommerce-MyAccount-sidebar">
			<?php $user = wp_get_current_user(); ?>
			<div class="suki-woocommerce-MyAccount-user">
				<?php echo get_avatar( $user->user_ID, 60 ); ?>
				<div class="info">
					<strong class="name"><?php echo esc_html( $user->display_name ); ?></strong>
					<a href="<?php echo esc_url( wp_logout_url() ); ?>" class="logout"><?php esc_html_e( 'Logout', 'suki' ); ?></a>
				</div>
			</div>
		<?php
	}

	/**
	 * Add closing wrapper tag to wrap account sidebar.
	 */
	public function render_account_sidebar_wrapper_end() {
		?>
		</div>
		<?php
	}
}

Suki_Compatibility_WooCommerce::instance();