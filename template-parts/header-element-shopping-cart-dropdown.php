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
		<?php if ( $is_dropdown ) : ?>
			<button class="shopping-cart-link suki-menu-item-link suki-sub-menu-toggle suki-toggle" aria-expanded="false">
		<?php else: ?>
			<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="shopping-cart-link suki-menu-item-link">
		<?php endif; ?>
				<span class="screen-reader-text"><?php esc_html_e( 'Shopping Cart', 'suki' ); ?></span>

				<?php if ( 'before' === suki_get_theme_mod( 'header_cart_amount' ) ) : ?>
					<span class="shopping-cart-amount"><?php echo $cart->get_cart_total(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
				<?php endif; ?>

				<span class="shopping-cart-icon">
					<?php suki_icon( 'shopping-cart', array( 'class' => 'suki-menu-icon' ) ); ?>
				</span>
				
				<span class="shopping-cart-count" data-count="<?php echo esc_attr( $cart->get_cart_contents_count() ); ?>"><?php echo $cart->get_cart_contents_count(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>

				<?php if ( 'after' === suki_get_theme_mod( 'header_cart_amount' ) ) : ?>
					<span class="shopping-cart-amount"><?php echo $cart->get_cart_total(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
				<?php endif; ?>
		<?php if ( $is_dropdown ) : ?>
			</button>
		<?php else: ?>
			</a>
		<?php endif; ?>

		<?php if ( $is_dropdown ) : ?>
			<div class="sub-menu"><?php echo $widget; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
		<?php endif; ?>
	</div>
</div>