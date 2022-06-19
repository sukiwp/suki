<?php
/**
 * Header shopping cart link template.
 *
 * Passed variables:
 *
 * @type string $element Header element.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

$cart = WC()->cart;

if ( empty( $cart ) ) {
	return;
}
?>
<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="<?php echo esc_attr( 'suki-header-' . $element ); ?> suki-header-cart cart-link suki-menu-item-link">
	<span class="screen-reader-text"><?php esc_html_e( 'Shopping Cart', 'suki' ); ?></span>

	<?php suki_icon( 'cart', array( 'class' => 'cart-icon suki-menu-icon' ) ); ?>

	<span class="cart-count" data-count="<?php echo esc_attr( $cart->get_cart_contents_count() ); ?>">
		<?php echo $cart->get_cart_contents_count(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</span>

	<?php
	$classes = array();

	$amount_position = suki_get_theme_mod( 'header_cart_amount', '' );

	$amount_html = '';
	if ( '' !== $amount_position ) {
		$classes[] = $amount_position;

		$hide_devices = array_diff( array( 'desktop', 'tablet', 'mobile' ), suki_get_theme_mod( 'header_cart_amount_visibility' ) );

		foreach ( $hide_devices as $device ) {
			$classes[] = esc_attr( 'suki-hide-on-' . $device );
		}
	}
	?>
	<span class="cart-amount <?php echo esc_attr( implode( ' ', $classes ) ); ?>">
		<?php echo $cart->get_cart_total(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</span>
</a>
