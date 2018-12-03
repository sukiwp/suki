<?php
/**
 * Customizer default values.
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$colors = Suki_Customizer::instance()->get_default_colors();

$add = array();

/**
 * ====================================================
 * WooCommerce > Store Notice
 * ====================================================
 */

$add['woocommerce_demo_store_notice_bg_color'] = $colors['accent'];
$add['woocommerce_demo_store_notice_text_color'] = $colors['white'];

/**
 * ====================================================
 * WooCommerce > Product Catalog
 * ====================================================
 */

$add['woocommerce_index_posts_per_page'] = 12;
$add['woocommerce_index_grid_columns'] = 4;

$add['woocommerce_index_page_title'] = 1;
$add['woocommerce_index_breadcrumb'] = 1;
$add['woocommerce_index_filter'] = 1;
$add['woocommerce_products_grid_item_add_to_cart'] = 0;

/**
 * ====================================================
 * WooCommerce > Single Product
 * ====================================================
 */

$add['woocommerce_single_breadcrumb'] = 1;

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
 * WooCommerce > Cart
 * ====================================================
 */

$add['woocommerce_cart_cross_sells'] = 1;
$add['woocommerce_cart_cross_sells_grid_columns'] = 4;

/**
 * ====================================================
 * WooCommerce > Checkout
 * ====================================================
 */

$add['woocommerce_checkout_two_columns'] = 1;

/**
 * ====================================================
 * WooCommerce > Products Grid
 * ====================================================
 */

$add['woocommerce_products_grid_columns_gutter'] = '15px';
$add['woocommerce_products_grid_text_alignment'] = 'left';

/**
 * ====================================================
 * WooCommerce > Other Elements
 * ====================================================
 */

$add['woocommerce_sale_badge_bg_color'] = $colors['accent'];
$add['woocommerce_sale_badge_text_color'] = $colors['white'];

$add['woocommerce_review_star_color'] = $colors['accent'];

$add['woocommerce_alt_button_bg_color'] = $colors['accent'];
$add['woocommerce_alt_button_border_color'] = $colors['accent'];
$add['woocommerce_alt_button_text_color'] = $colors['white'];
$add['woocommerce_alt_button_hover_bg_color'] = $colors['accent_2'];
$add['woocommerce_alt_button_hover_border_color'] = $colors['accent_2'];
$add['woocommerce_alt_button_hover_text_color'] = $colors['white'];

$defaults = array_merge_recursive( $defaults, $add );