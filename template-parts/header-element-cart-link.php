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
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

$cart = WC()->cart;

if ( empty( $cart ) ) {
	return;
}

// Amount
$amount_position = suki_get_theme_mod( 'header_cart_amount', '' );
$amount_html = '';
if ( '' !== $amount_position ) {
	$classes = array();
	$hide_devices = array_diff( array( 'desktop', 'tablet', 'mobile' ), suki_get_theme_mod( 'header_cart_amount_visibility' ) );
	foreach( $hide_devices as $device ) {
		$classes[] = esc_attr( 'suki-hide-on-' . $device );
	}

	ob_start();
	?>
	<span class="cart-amount <?php echo esc_attr( implode( ' ', $classes ) ); ?>"><?php echo $cart->get_cart_total(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
	<?php
	$amount_html = ob_get_clean();
}
?>
<div class="<?php echo esc_attr( 'suki-header-' . $element ); ?> suki-header-cart menu">
	<div class="menu-item">
		<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="cart-link suki-menu-item-link">
			<span class="screen-reader-text"><?php esc_html_e( 'Shopping Cart', 'suki' ); ?></span>

			<?php if ( 'before' === $amount_position ) {
				echo $amount_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			} ?>

			<span class="cart-icon">
				<?php suki_icon( 'cart', array( 'class' => 'suki-menu-icon' ) ); ?>
			</span>

			<span class="cart-count" data-count="<?php echo esc_attr( $cart->get_cart_contents_count() ); ?>"><?php echo $cart->get_cart_contents_count(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>

			<?php if ( 'after' === $amount_position ) {
				echo $amount_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			} ?>
		</a>
	</div>
</div>