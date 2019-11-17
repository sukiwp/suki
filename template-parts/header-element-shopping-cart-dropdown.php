<?php
/**
 * Header search dropdown template.
 *
 * Passed variables:
 *
 * @type string $slug Header element slug.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

$cart = WC()->cart;

if ( empty( $cart ) ) {
	return;
}

$count = $cart->get_cart_contents_count();

ob_start();
the_widget( 'WC_Widget_Cart', array(
	'title'         => '',
	'hide_if_empty' => false,
) );
$widget = ob_get_clean();

if ( ! empty( $widget ) ) {
	$is_dropdown = true;
} else {
	$is_dropdown = false;
}
?>
<div class="<?php echo esc_attr( 'suki-header-' . $slug ); ?> suki-header-shopping-cart menu <?php echo $is_dropdown ? esc_attr( 'suki-toggle-menu' ) : ''; ?>">
	<div class="menu-item">
		<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="shopping-cart-link <?php echo $is_dropdown ? esc_attr( 'suki-sub-menu-toggle suki-toggle' ) : ''; ?>">
			<?php suki_icon( 'shopping-cart', array( 'class' => 'suki-menu-icon' ) ); ?>
			<span class="screen-reader-text"><?php esc_html_e( 'Shopping Cart', 'suki' ); ?></span>
			<span class="shopping-cart-count" data-count="<?php echo esc_attr( $count ); ?>"><?php echo $count; // WPCS: XSS OK ?></span>
		</a>

		<?php if ( $is_dropdown ) : ?>
			<div class="sub-menu"><?php echo $widget; // WPCS: XSS OK ?></div>
		<?php endif; ?>
	</div>
</div>