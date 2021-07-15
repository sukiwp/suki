<?php
/**
 * The template for displaying product search form
 *
 * Modifications:
 * - Wrap textbox input with <label>.
 * - Add search icon inside the <label> wrapper.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<form role="search" method="get" class="woocommerce-product-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="hidden" name="post_type" value="product" />
	<label for="woocommerce-product-search-field-<?php echo isset( $index ) ? absint( $index ) : 0; ?>">
		<span class="screen-reader-text"><?php esc_html_e( 'Search for:', 'woocommerce' ); ?></span>
		<input type="search" id="woocommerce-product-search-field-<?php echo isset( $index ) ? absint( $index ) : 0; ?>" class="search-field" placeholder="<?php echo esc_attr__( 'Search products&hellip;', 'woocommerce' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
		<?php suki_icon( 'search', array( 'class' => 'suki-search-icon' ) ); ?>
	</label>
	<button type="submit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'woocommerce' ); ?>"><?php echo esc_html_x( 'Search', 'submit button', 'woocommerce' ); ?></button>
</form>
