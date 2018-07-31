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
		add_action( 'widgets_init', array( $this, 'register_sidebars' ) );

		// Compatibility CSS
		add_action( 'suki/frontend/before_enqueue_main_css', array( $this, 'enqueue_css' ) );

		// Customizer settings & values
		add_action( 'customize_register', array( $this, 'register_customizer_settings' ) );
		add_filter( 'suki/customizer/setting_defaults', array( $this, 'add_customizer_setting_defaults' ) );
		add_filter( 'suki/customizer/setting_postmessages', array( $this, 'add_customizer_setting_postmessages' ) );

		// Template tags
		add_filter( 'suki/frontend/header_element', array( $this, 'header_element' ), 10, 2 );

		// Template hooks
		add_action( 'init', array( $this, 'modify_template_hooks' ) );
		add_action( 'wp', array( $this, 'modify_template_hooks_based_on_customizer' ) );
		
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
	 * Register additional sidebar for WooCommerce.
	 */
	public function register_sidebars() {
		register_sidebar( array(
			'name'          => esc_html__( 'Sidebar Shop', 'suki' ),
			'id'            => 'sidebar-shop',
			'description'   => esc_html__( 'Sidebar used in WooCommerce pages', 'suki' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title h4">',
			'after_title'   => '</h2>',
		) );
	}

	/**
	 * Register customizer sections, settings, and controls.
	 *
	 * @param WP_Customize_Manager $wp_customize
	 */
	public function register_customizer_settings( $wp_customize ) {
		$defaults = Suki_Customizer::instance()->get_setting_defaults();
		
		require_once( SUKI_INCLUDES_PATH . '/compatibilities/woocommerce/customizer/options/_sections.php' );
		require_once( SUKI_INCLUDES_PATH . '/compatibilities/woocommerce/customizer/options/header.php' );
		require_once( SUKI_INCLUDES_PATH . '/compatibilities/woocommerce/customizer/options/woocommerce--store-notice.php' );
		require_once( SUKI_INCLUDES_PATH . '/compatibilities/woocommerce/customizer/options/woocommerce--product-catalog.php' );
		require_once( SUKI_INCLUDES_PATH . '/compatibilities/woocommerce/customizer/options/woocommerce--product-single.php' );
		require_once( SUKI_INCLUDES_PATH . '/compatibilities/woocommerce/customizer/options/woocommerce--cart.php' );
		require_once( SUKI_INCLUDES_PATH . '/compatibilities/woocommerce/customizer/options/woocommerce--checkout.php' );
		require_once( SUKI_INCLUDES_PATH . '/compatibilities/woocommerce/customizer/options/woocommerce--products-grid.php' );
		require_once( SUKI_INCLUDES_PATH . '/compatibilities/woocommerce/customizer/options/woocommerce--other-elements.php' );
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
	 * Enqueue compatibility CSS.
	 */
	public function enqueue_css() {
		wp_enqueue_style( 'suki-woocommerce', SUKI_CSS_URL . '/compatibilities/woocommerce' . SUKI_ASSETS_SUFFIX . '.css', array(), SUKI_VERSION );
		wp_style_add_data( 'suki-woocommerce', 'rtl', 'replace' );
	}
	
	/**
	 * Add default values for all Customizer settings.
	 *
	 * @param array $defaults
	 * @return array
	 */
	public function add_customizer_setting_defaults( $defaults = array() ) {
		include( SUKI_INCLUDES_PATH . '/compatibilities/woocommerce/customizer/defaults.php' );

		return $defaults;
	}

	/**
	 * Add postmessage rules for some Customizer settings.
	 *
	 * @param array $postmessages
	 * @return array
	 */
	public function add_customizer_setting_postmessages( $postmessages = array() ) {
		include( SUKI_INCLUDES_PATH . '/compatibilities/woocommerce/customizer/postmessages.php' );

		return $postmessages;
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
			$ids[ $post->ID ] = '<p><a href="' . esc_url( add_query_arg( array( 'autofocus[section]' => 'suki_section_page_settings_product_archive', 'url' => get_permalink( wc_get_page_id( 'shop' ) ) ), admin_url( 'customize.php' ) ) ) . '">' .  esc_html__( 'Edit Page settings here', 'suki' ) . '</a></p>';
		}

		return $ids;
	}

	/**
	 * Modify filters for WooCommerce template rendering.
	 */
	public function modify_template_hooks() {
		/**
		 * Global template hooks
		 */

		// Add content wrapper.
		add_action( 'woocommerce_before_main_content', 'suki_content_open', 1 );
		add_action( 'woocommerce_sidebar', 'suki_content_close', 999 );

		// Change main content (primary) wrapper.
		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
		remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
		add_action( 'woocommerce_before_main_content', 'suki_primary_open' );
		add_action( 'woocommerce_after_main_content', 'suki_primary_close' );

		// Add count to Cart menu item.
		add_filter( 'nav_menu_item_title', array( $this, 'add_count_to_cart_menu_item' ), 10, 4 );

		// Change sale badge tags.
		add_filter( 'woocommerce_sale_flash', array( $this, 'change_sale_badge_markup' ), 99, 3 );

		// Demo Store notice.
		remove_action( 'wp_footer', 'woocommerce_demo_store' );
		add_action( 'suki/frontend/before_header', 'woocommerce_demo_store' );

		// Change mobile devices breakpoint.
		add_filter( 'woocommerce_style_smallscreen_breakpoint', array( $this, 'set_smallscreen_breakpoint' ) );

		// Change gravatar size on reviews.
		add_filter( 'woocommerce_review_gravatar_size', array( $this, 'set_review_gravatar_size' ) );

		// Add cart fragments.
		add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'update_header_cart' ) );

		/**
		 * Shop page's template hooks
		 */

		// Add spacer before mail products loop.
		add_action( 'woocommerce_before_shop_loop', array( $this, 'render_before_shop_loop' ), 999 );

		// Reposition sale badge on products grid item.
		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
		add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 1 );

		// Separate <a> tag for product image and title on products grid item.
		remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
		add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 9 );
		add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 11 );
		add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 1 );
		add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 999 );

		// Add wrapper to products grid item.
		add_action( 'woocommerce_before_shop_loop_item', array( $this, 'render_loop_item_wrapper' ), 1 );
		add_action( 'woocommerce_after_shop_loop_item', array( $this, 'render_loop_item_wrapper_end' ), 999 );

		// Products loop
		add_filter( 'loop_shop_per_page', array( $this, 'set_loop_posts_per_page' ) );
		add_filter( 'loop_shop_columns', array( $this, 'set_loop_columns' ) );

		/**
		 * Products page's template hooks
		 */

		// Wrap images and summary
		add_action( 'woocommerce_before_single_product_summary', array( $this, 'render_product_images_summary_wrapper' ), 1 );
		add_action( 'woocommerce_after_single_product_summary', array( $this, 'render_product_images_summary_wrapper_end' ), 1 );

		// Reposition sale badge on product page.
		remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
		add_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 21 );

		// Set product images thumbnails columns.
		add_filter( 'woocommerce_product_thumbnails_columns', array( $this, 'set_product_thumbnails_columns' ) );

		// Related products
		add_filter( 'woocommerce_related_products_args', array( $this, 'set_related_products_args' ) );
		add_filter( 'woocommerce_related_products_columns', array( $this, 'set_related_products_columns' ) );
		add_filter( 'woocommerce_output_related_products_args', array( $this, 'set_related_products_display_args' ) );

		// Up sells
		add_filter( 'woocommerce_up_sells_columns', array( $this, 'set_up_sells_columns' ) );
		add_filter( 'woocommerce_upsell_display_args', array( $this, 'set_up_sells_display_args' ) );

		/**
		 * Checkout page's template hooks
		 */

		// Split into 2 columns.
		add_action( 'woocommerce_checkout_before_customer_details', array( $this, 'render_checkout_wrapper' ), 1 );
		add_action( 'woocommerce_checkout_before_customer_details', array( $this, 'render_checkout_wrapper_column_1' ), 1 );
		add_action( 'woocommerce_checkout_after_customer_details', array( $this, 'render_checkout_wrapper_column_1_end' ), 999 );
		add_action( 'woocommerce_checkout_after_customer_details', array( $this, 'render_checkout_wrapper_column_2' ), 999 );
		add_action( 'woocommerce_checkout_after_order_review', array( $this, 'render_checkout_wrapper_column_2_end' ), 999 );
		add_action( 'woocommerce_checkout_after_order_review', array( $this, 'render_checkout_wrapper_end' ), 999 );

		/**
		 * Cart page's template hooks
		 */

		// Cross sells columns
		add_filter( 'woocommerce_cross_sells_columns', array( $this, 'set_cart_page_cross_sells_columns' ) );

		/**
		 * My Account page's template hooks
		 */

		// Add account avatar and name into side navigation.
		add_filter( 'woocommerce_before_account_navigation', array( $this, 'render_account_wrapper' ), 1 );
		add_filter( 'woocommerce_before_account_navigation', array( $this, 'render_account_sidebar_wrapper' ) );
		add_filter( 'woocommerce_after_account_navigation', array( $this, 'render_account_sidebar_wrapper_end' ) );
	}

	/**
	 * Modify filters for WooCommerce template rendering based on Customizer settings.
	 */
	public function modify_template_hooks_based_on_customizer() {
		/**
		 * Global template hooks
		 */

		// Keep / remove "add to cart" button on products grid.
		if ( ! suki_get_theme_mod( 'woocommerce_products_grid_item_add_to_cart' ) ) {
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
		}

		/**
		 * Shop page's template hooks
		 */

		if ( is_shop() || is_product_taxonomy() ) {
			// Keep / remove page title.
			if ( ! suki_get_theme_mod( 'woocommerce_index_page_title' ) ) {
				add_filter( 'woocommerce_show_page_title', '__return_false' );
			}

			// Keep / remove breadcrumb.
			if ( ! suki_get_theme_mod( 'woocommerce_index_breadcrumb' ) ) {
				remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
			}

			// Keep / remove products loop filter on products grid.
			if ( ! suki_get_theme_mod( 'woocommerce_index_filter' ) ) {
				remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
				remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
			}
		}

		/**
		 * Products page's template hooks
		 */

		if ( is_product() ) {
			// Keep / remove breadcrumb.
			if ( ! suki_get_theme_mod( 'woocommerce_single_breadcrumb' ) ) {
				remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
			} else {
				remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
				add_action( 'woocommerce_single_product_summary', 'woocommerce_breadcrumb', 1 );
			}

			// Keep / remove gallery.
			if ( ! suki_get_theme_mod( 'woocommerce_single_gallery' ) ) {
				remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
			}

			// Keep / remove gallery zoom module.
			if ( ! suki_get_theme_mod( 'woocommerce_single_gallery_zoom' ) ) {
				remove_theme_support( 'wc-product-gallery-zoom' );
			}

			// Keep / remove gallery lightbox module.
			if ( ! suki_get_theme_mod( 'woocommerce_single_gallery_lightbox' ) ) {
				remove_theme_support( 'wc-product-gallery-lightbox' );
			}

			// Keep / remove tabs.
			if ( ! suki_get_theme_mod( 'woocommerce_single_tabs' ) ) {
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
			}

			// Keep / remove up-sells.
			if ( ! suki_get_theme_mod( 'woocommerce_single_up_sells' ) ) {
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
			}

			// Keep / remove up-sells.
			if ( ! suki_get_theme_mod( 'woocommerce_single_related' ) ) {
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
			}
		}
	}
	
	/**
	 * ====================================================
	 * Global Page Hook functions
	 * ====================================================
	 */

	/**
	 * Add blank <div> to clear shop filters floating.
	 */
	public function render_before_shop_loop() {
		?><div class="suki-before-shop-loop-clear"></div><?php
	}

	/**
	 * Add opening product wrapper tag to products loop item.
	 */
	public function render_loop_item_wrapper() {
		?><div class="suki-product-wrapper"><?php
	}

	/**
	 * Add closing product wrapper tag to products loop item.
	 */
	public function render_loop_item_wrapper_end() {
		?></div><?php
	}

	/**
	 * Add items count to Cart menu item.
	 *
	 * @param string $title
	 * @param WP_Post $item
	 * @param array $args
	 * @param integer $depth
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
				$title = str_replace( '{{count}}', '(<span class="shopping-cart-count suki-menu-icon" data-count="' . $count . '"><strong>' . $count . '</strong></span>)', $title );
			}
		}

		return $title;
	}

	/**
	 * Improve sale badge HTML markup.
	 *
	 * @param string $html
	 * @param WP_Post $post
	 * @param WC_Product $product
	 */
	public function change_sale_badge_markup( $html, $post, $product ) {
		$html = preg_replace( '/<span class="onsale">(.*)<\/span>/', '<span class="onsale"><span>$1</span></span>', $html );

		return $html;
	}

	/**
	 * Add markup for shopping cart header element.
	 *
	 * @param string $html
	 * @param string $element
	 * @return string
	 */
	public function header_element( $html, $element ) {
		// Check if the specified element is a shopping cart.
		if ( ! in_array( $element, array( 'shopping-cart-dropdown', 'shopping-cart-link' ) ) ) {
			return $html;
		}

		ob_start();
		switch ( $element ) {
			case 'shopping-cart-dropdown':
				if ( class_exists( 'WooCommerce' ) ) :
					$cart = WC()->cart;

					if ( empty( $cart ) ) return;

					$count = $cart->get_cart_contents_count();
					?>
					<div class="<?php echo esc_attr( 'suki-header-' . $element ); ?> suki-header-shopping-cart menu suki-toggle-menu">
						<div class="menu-item">
							<button class="shopping-cart-link suki-sub-menu-toggle suki-toggle">
								<?php suki_icon( 'shopping-cart', array( 'class' => 'suki-menu-icon' ) ); ?>
								<span class="screen-reader-text"><?php esc_html_e( 'Shopping Cart', 'suki' ); ?></span>
								<span class="shopping-cart-count suki-menu-icon" data-count="<?php echo esc_attr( $count ); ?>"><strong><?php echo $count; // WPCS: XSS OK ?></strong></span>
							</button>
							<?php add_filter( 'woocommerce_widget_cart_is_hidden', '__return_false', 10 ); ?>
							<div class="sub-menu">
								<?php the_widget( 'WC_Widget_Cart', array(
									'title'         => '',
									'hide_if_empty' => false,
								) ); ?>
							</div>
							<?php remove_filter( 'woocommerce_widget_cart_is_hidden', '__return_false', 10 ); ?>
						</div>
					</div>
					<?php
				endif;
				break;

			case 'shopping-cart-link':
				if ( class_exists( 'WooCommerce' ) ) :
					$cart = WC()->cart;

					if ( empty( $cart ) ) return;

					$count = $cart->get_cart_contents_count();
					?>
					<div class="<?php echo esc_attr( 'suki-header-' . $element ); ?> suki-header-shopping-cart menu">
						<div class="menu-item">
							<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="shopping-cart-link">
								<?php suki_icon( 'shopping-cart', array( 'class' => 'suki-menu-icon' ) ); ?>
								<span class="shopping-cart-count suki-menu-icon" data-count="<?php echo esc_attr( $count ); ?>"><strong><?php echo $count; // WPCS: XSS OK ?></strong></span>
							</a>
						</div>
					</div>
					<?php
				endif;
				break;
		}
		$html = ob_get_clean();

		return $html;
	}

	/**
	 * ====================================================
	 * Shop Page Hook functions
	 * ====================================================
	 */

	/**
	 * Set products loop posts per page.
	 * 
	 * @param integer $posts_per_page
	 * @return integer
	 */
	public function set_loop_posts_per_page( $posts_per_page ) {
		return suki_get_theme_mod( 'woocommerce_index_posts_per_page' );
	}

	/**
	 * Set products loop columns.
	 * 
	 * @param integer $cols
	 * @return integer
	 */
	public function set_loop_columns( $cols ) {
		return suki_get_theme_mod( 'woocommerce_index_grid_columns' );
	}

	/**
	 * ====================================================
	 * Product Page Hook functions
	 * ====================================================
	 */

	/**
	 * Add opening wrapper tag to wrap product images + summary.
	 */
	public function render_product_images_summary_wrapper() {
		?><div class="suki-woocommerce-product-images-summary-wrapper"><?php
	}

	/**
	 * Add closing wrapper tag to wrap product images + summary.
	 */
	public function render_product_images_summary_wrapper_end() {
		?></div><?php
	}

	/**
	 * Product thumbnails columns in single product page.
	 * 
	 * @param integer $columns
	 * @return integer
	 */
	public function set_product_thumbnails_columns( $columns ) {
		return 8;
	}

	/**
	 * Keep / remove related products.
	 * 
	 * @param array $args Array of arguments
	 */
	public function set_related_products_args( $args ) {
		if ( 0 == suki_get_theme_mod( 'woocommerce_single_related_posts_per_page' ) ) {
			return array();
		}
		return $args;
	}
	
	/**
	 * Set related products columns.
	 * 
	 * @param integer $columns Number of columns
	 */
	public function set_related_products_columns( $columns ) {
		return suki_get_theme_mod( 'woocommerce_single_related_grid_columns' );
	}

	/**
	 * Set related products arguments.
	 * 
	 * @param array $args Array of arguments
	 */
	public function set_related_products_display_args( $args ) {
		$args['posts_per_page'] = suki_get_theme_mod( 'woocommerce_single_related_posts_per_page' );
		$args['columns'] = suki_get_theme_mod( 'woocommerce_single_related_grid_columns' );

		return $args;
	}

	/**
	 * Set up-sells columns.
	 * 
	 * @param integer $columns Number of columns
	 */
	public function set_up_sells_columns( $columns ) {
		return suki_get_theme_mod( 'woocommerce_single_up_sells_grid_columns' );
	}
	
	/**
	 * Set up-sells products arguments.
	 * 
	 * @param array $args Array of arguments
	 */
	public function set_up_sells_display_args( $args ) {
		$args['columns'] = suki_get_theme_mod( 'woocommerce_single_up_sells_grid_columns' );

		return $args;
	}

	/**
	 * ====================================================
	 * Checkout Page Hook functions
	 * ====================================================
	 */

	/**
	 * Add opening wrapper tag to wrap checkout form.
	 */
	public function render_checkout_wrapper() {
		?>
		<div class="suki-woocommerce-checkout-wrapper <?php echo esc_attr( 'suki-woocommerce-checkout-' . ( suki_get_theme_mod( 'woocommerce_checkout_two_columns' ) ? '2-columns' : '1-column' ) ); ?>">
		<?php
	}

	/**
	 * Add opening wrapper tag to wrap checkout form column 1.
	 */
	public function render_checkout_wrapper_column_1() {
		?>
		<div class="suki-woocommerce-checkout-col-1">
		<?php
	}

	/**
	 * Add closing wrapper tag to wrap checkout form column 1.
	 */
	public function render_checkout_wrapper_column_1_end() {
		?>
		</div>
		<?php
	}

	/**
	 * Add opening wrapper tag to wrap checkout form column 2.
	 */
	public function render_checkout_wrapper_column_2() {
		?>
		<div class="suki-woocommerce-checkout-col-2">
		<?php
	}

	/**
	 * Add closing wrapper tag to wrap checkout form column 2.
	 */
	public function render_checkout_wrapper_column_2_end() {
		$checkout = WC()->checkout;

		if ( $checkout->get_checkout_fields() ) : ?>
			</div>
		<?php endif;
	}

	/**
	 * Add closing wrapper tag to wrap checkout form.
	 */
	public function render_checkout_wrapper_end() {
		$checkout = WC()->checkout;

		if ( $checkout->get_checkout_fields() ) : ?>
			</div>
		<?php endif;
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
	 */
	public function set_cart_page_cross_sells_columns( $columns ) {
		return suki_get_theme_mod( 'woocommerce_cart_cross_sells_grid_columns' );
	}

	/**
	 * ====================================================
	 * My Account Page Hook functions
	 * ====================================================
	 */

	/**
	 * Add opening wrapper tag to wrap my account page.
	 */
	public function render_account_wrapper() {
		?>
		<div class="suki-woocommerce-MyAccount">
		<?php
	}

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

	/**
	 * Add closing wrapper tag to wrap my account page.
	 */
	public function render_account_wrapper_end() {
		?>
		</div>
		<?php
	}


	/**
	 * ====================================================
	 * AJAX functions
	 * ====================================================
	 */

	/**
	 * AJAX update items count on header cart menu & icon.
	 */
	public function update_header_cart( $fragments ) {
		$count = WC()->cart->get_cart_contents_count();
		$fragments['.shopping-cart-count'] = '<span class="shopping-cart-count suki-menu-icon" data-count="' . $count . '"><strong>' . $count . '</strong></span>';
		
		return $fragments;
	}
}

Suki_Compatibility_WooCommerce::instance();