<?php
/**
 * The template for displaying product content within loops
 *
 * Modifications:
 * - Add product inner wrapper ("suki-product-wrapper").
 * - Add filter to inject classes into "suki-product-wrapper".
 * - Add wrapper to "woocommerce_before_shop_loop_item_title" hook.
 * - Add link wrapper to product thumbnail.
 * - Add link wrapper to product title (hard coded).
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<li <?php wc_product_class( '', $product ); ?>>
	<div class="<?php echo esc_attr( implode( ' ', apply_filters( 'suki/frontend/woocommerce/loop_item_classes', array( 'suki-product-wrapper' ) ) ) ); ?>">
		<?php
		/**
		 * Hook: woocommerce_before_shop_loop_item.
		 */
		do_action( 'woocommerce_before_shop_loop_item' );

		?>
		<div class="<?php echo esc_attr( implode( ' ', apply_filters( 'suki/frontend/woocommerce/loop_item_thumbnail_classes', array( 'suki-product-thumbnail' ) ) ) ); ?>">
			<?php
			/**
			 * Hook: woocommerce_before_shop_loop_item_title.
			 *
			 * @hooked woocommerce_show_product_loop_sale_flash - 1
			 * @hooked woocommerce_template_loop_product_link_open - 9
			 * @hooked woocommerce_template_loop_product_thumbnail - 10
			 * @hooked woocommerce_template_loop_product_link_close - 19
			 */
			do_action( 'woocommerce_before_shop_loop_item_title' );
			?>
		</div>
		<?php
		
		woocommerce_template_loop_product_link_open();
			
			/**
			 * Hook: woocommerce_shop_loop_item_title.
			 *
			 * @hooked woocommerce_template_loop_product_title - 10
			 */
			do_action( 'woocommerce_shop_loop_item_title' );
			
		woocommerce_template_loop_product_link_close();

		/**
		 * Hook: woocommerce_after_shop_loop_item_title.
		 *
		 * @hooked woocommerce_template_loop_rating - 5
		 * @hooked woocommerce_template_loop_price - 10
		 */
		do_action( 'woocommerce_after_shop_loop_item_title' );

		/**
		 * Hook: woocommerce_after_shop_loop_item.
		 *
		 * @hooked woocommerce_template_loop_add_to_cart - 10
		 */
		do_action( 'woocommerce_after_shop_loop_item' );
		?>
	</div>
</li>
