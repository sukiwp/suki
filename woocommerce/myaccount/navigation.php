<?php
/**
 * My Account navigation
 *
 * Modifications:
 * - Add wrapper ("suki-woocommerce-MyAccount-sidebar").
 * - Add user avatar and name ("suki-woocommerce-MyAccount-user").
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="suki-woocommerce-MyAccount-sidebar">

	<div class="suki-woocommerce-MyAccount-user">
		<?php
		$user = wp_get_current_user();
		echo get_avatar( $user->user_ID, 60 );
		?>
		<strong class="name"><?php echo esc_html( $user->display_name ); ?></strong>
	</div>

	<?php do_action( 'woocommerce_before_account_navigation' ); ?>

	<nav class="woocommerce-MyAccount-navigation">
		<ul>
			<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
				<li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
					<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( $label ); ?></a>
				</li>
			<?php endforeach; ?>
		</ul>
	</nav>

	<?php do_action( 'woocommerce_after_account_navigation' ); ?>

</div>
