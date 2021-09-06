<?php
/**
 * Customizer default values.
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$colors = suki_get_default_colors();

$add = array();

/**
 * ====================================================
 * WooCommerce > Store Notice
 * ====================================================
 */

$add['woocommerce_demo_store_notice_bg_color'] = '';
$add['woocommerce_demo_store_notice_text_color'] = '';

/**
 * ====================================================
 * WooCommerce > Shop (Products Catalog) Page
 * ====================================================
 */

$add['product_archive_content_header'] = array( 'title', 'archive-description' );

$add['woocommerce_index_posts_per_page'] = 12;
$add['woocommerce_index_grid_columns'] = 4;

// $add['woocommerce_index_page_title'] = 1;
// $add['woocommerce_index_breadcrumb'] = 1;
$add['woocommerce_index_results_count'] = 1;
$add['woocommerce_index_sort_filter'] = 1;
$add['woocommerce_products_grid_item_add_to_cart'] = 0;

/**
 * ====================================================
 * WooCommerce > Single Product Page
 * ====================================================
 */

$add['product_single_content_header'] = array();
$add['product_single_content_header_alignment'] = 'left';

$add['woocommerce_single_meta'] = 1;

$add['woocommerce_single_gallery'] = 1;
$add['woocommerce_single_gallery_width'] = '60%';
$add['woocommerce_single_gallery_gap'] = '40px';
$add['woocommerce_single_gallery_zoom'] = 1;
$add['woocommerce_single_gallery_lightbox'] = 1;

$add['woocommerce_single_tabs'] = 1;

$add['woocommerce_single_up_sells'] = 1;
$add['woocommerce_single_up_sells_grid_columns'] = 4;

$add['woocommerce_single_related'] = 1;
$add['woocommerce_single_related_posts_per_page'] = 4;
$add['woocommerce_single_related_grid_columns'] = 4;

/**
 * ====================================================
 * WooCommerce > Cart Page
 * ====================================================
 */

$add['woocommerce_cart_layout'] = '2-columns';

$add['woocommerce_cart_cross_sells'] = 1;
$add['woocommerce_cart_cross_sells_position'] = 'after_cart_table';
$add['woocommerce_cart_cross_sells_grid_columns'] = 4;

/**
 * ====================================================
 * WooCommerce > Checkout Page
 * ====================================================
 */

$add['woocommerce_checkout_layout'] = '2-columns';

/**
 * ====================================================
 * WooCommerce > Products Grid
 * ====================================================
 */

$add['woocommerce_products_grid_rows_gutter'] = '15px';
$add['woocommerce_products_grid_columns_gutter'] = '15px';
$add['woocommerce_products_grid_text_alignment'] = 'left';

/**
 * ====================================================
 * WooCommerce > Breadcrumb
 * ====================================================
 */

$add['woocommerce_breadcrumb_use_theme_module'] = 1;

/**
 * ====================================================
 * WooCommerce > Other Elements
 * ====================================================
 */

$add['woocommerce_sale_badge_bg_color'] = '';
$add['woocommerce_sale_badge_text_color'] = '';

$add['woocommerce_review_star_color'] = '';

$add['woocommerce_alt_button_bg_color'] = '';
$add['woocommerce_alt_button_border_color'] = '';
$add['woocommerce_alt_button_text_color'] = '';
$add['woocommerce_alt_button_hover_bg_color'] = '';
$add['woocommerce_alt_button_hover_border_color'] = '';
$add['woocommerce_alt_button_hover_text_color'] = '';

return $add;