<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Modifications:
 * - Remove "woocommerce_output_all_notices" from "woocommerce_before_single_product" hook.
 * - Call "woocommerce_output_all_notices" just before "woocommerce_before_single_product" hook (hard coded).
 * - Add filter to inject classes into product wrapper.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

woocommerce_output_all_notices();

/**
 * Hook: woocommerce_before_single_product.
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( apply_filters( 'suki/frontend/woocommerce/single_product_classes', '' ), $product ); ?>>
	<?php
	/**
	 * Suki Content Header (when Hero section is not active)
	 *
	 * Available elements:
	 * - Breadcrumb
	 * - Title
	 */
	if ( ! intval( suki_get_current_page_setting( 'hero' ) ) ) {
		suki_content_header();
	}
	?>

	<?php
	/**
	 * Hook: woocommerce_before_single_product_summary.
	 *
	 * @hooked woocommerce_show_product_images - 20
     * @hooked woocommerce_show_product_sale_flash - 21
	 */
	do_action( 'woocommerce_before_single_product_summary' );
	?>

	<div class="summary entry-summary">
		<?php
		/**
		 * Hook: woocommerce_single_product_summary.
		 *
		 * @hooked woocommerce_template_single_title - 5
		 * @hooked woocommerce_template_single_rating - 10
		 * @hooked woocommerce_template_single_price - 10
		 * @hooked woocommerce_template_single_excerpt - 20
		 * @hooked woocommerce_template_single_add_to_cart - 30
		 * @hooked woocommerce_template_single_meta - 40
		 * @hooked woocommerce_template_single_sharing - 50
		 * @hooked WC_Structured_Data::generate_product_data() - 60
		 */
		do_action( 'woocommerce_single_product_summary' );
		?>
	</div>

	<?php
	/**
	 * Hook: woocommerce_after_single_product_summary.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 * @hooked woocommerce_output_related_products - 20
	 */
	do_action( 'woocommerce_after_single_product_summary' );
	?>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
