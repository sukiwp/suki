<?php
/**
 * Header shopping cart dropdown template.
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

// Dropdown
ob_start();
the_widget( 'WC_Widget_Cart', array(
	'title'         => '',
	'hide_if_empty' => false,
) );
$dropdown_html = ob_get_clean();
if ( ! empty( $dropdown_html ) ) {
	$is_dropdown = true;
} else {
	$is_dropdown = false;
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
<div class="<?php echo esc_attr( 'suki-header-' . $element ); ?> suki-header-cart menu <?php echo $is_dropdown ? esc_attr( 'suki-toggle-menu' ) : ''; ?>">
	<div class="menu-item">
		<?php if ( $is_dropdown ) : ?>
			<button class="cart-link suki-menu-item-link suki-sub-menu-toggle suki-toggle" aria-expanded="false">
		<?php else: ?>
			<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="cart-link suki-menu-item-link">
		<?php endif; ?>

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

		<?php if ( $is_dropdown ) : ?>
			</button>
		<?php else: ?>
			</a>
		<?php endif; ?>

		<?php if ( $is_dropdown ) : ?>
			<div class="sub-menu"><?php echo $dropdown_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
		<?php endif; ?>
	</div>
</div>