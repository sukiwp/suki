<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * Modifications:
 * - Remove "woocommerce_output_all_notices" from "woocommerce_before_shop_loop" hook.
 * - Call "woocommerce_output_all_notices" just before "woocommerce_before_shop_loop" hook (hard coded).
 * - Add wrapper to "woocommerce_before_shop_loop" hook ("suki-woocommerce-before-shop-loop").
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );
?>
<header class="woocommerce-products-header">
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
	 * Hook: woocommerce_archive_description.
	 *
	 * @hooked woocommerce_taxonomy_archive_description - 10
	 * @hooked woocommerce_product_archive_description - 10
	 */
	do_action( 'woocommerce_archive_description' );
	?>
</header>
<?php
if ( woocommerce_product_loop() ) {

	woocommerce_output_all_notices();
	
	if ( has_action( 'woocommerce_before_shop_loop' ) ) {
		?>
		<div class="suki-woocommerce-before-shop-loop suki-products-filters">
			<?php
			/**
			 * Hook: woocommerce_before_shop_loop.
			 *
			 * @hooked woocommerce_result_count - 20
			 * @hooked woocommerce_catalog_ordering - 30
			 */
			do_action( 'woocommerce_before_shop_loop' );
			?>
		</div>
		<?php
	}

	woocommerce_product_loop_start();

	if ( wc_get_loop_prop( 'total' ) ) {
		while ( have_posts() ) {
			the_post();

			/**
			 * Hook: woocommerce_shop_loop.
			 */
			do_action( 'woocommerce_shop_loop' );

			wc_get_template_part( 'content', 'product' );
		}
	}

	woocommerce_product_loop_end();

	/**
	 * Hook: woocommerce_after_shop_loop.
	 *
	 * @hooked woocommerce_pagination - 10
	 */
	do_action( 'woocommerce_after_shop_loop' );
} else {
	/**
	 * Hook: woocommerce_no_products_found.
	 *
	 * @hooked wc_no_products_found - 10
	 */
	do_action( 'woocommerce_no_products_found' );
}

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action( 'woocommerce_sidebar' );

get_footer( 'shop' );
