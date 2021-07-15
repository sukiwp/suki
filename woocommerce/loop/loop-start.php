<?php
/**
 * Product Loop Start
 *
 * Modifications:
 * - Add class filter for more advanced features and styling.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<ul class="products columns-<?php echo esc_attr( wc_get_loop_prop( 'columns' ) ); ?> <?php echo esc_attr( implode( ' ', apply_filters( 'suki/frontend/woocommerce/loop_classes', array() ) ) ); ?>">
