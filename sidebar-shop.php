<?php
/**
 * WooCommerce sidebar template.
 *
 * @package Suki
 * @since 2.0.0 Remove `sidebar-inner` wrapping tag and add `aria-label`.
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<!-- wp:group {
	"tagName":"aside",
	"className":"sidebar"
} --><aside class="wp-block-group sidebar sidebar-shop" aria-label="<?php esc_attr_e( 'Shop Sidebar', 'suki' ); ?>" itemscope itemtype="https://schema.org/WPSideBar">

	<?php
	/**
	 * Hook: suki/frontend/before_sidebar
	 */
	do_action( 'suki/frontend/before_sidebar' );

	/**
	 * Sidebar elements.
	 */
	if ( is_active_sidebar( 'sidebar-shop' ) ) {
		dynamic_sidebar( 'sidebar-shop' );
	}

	/**
	 * Hook: suki/frontend/after_sidebar
	 */
	do_action( 'suki/frontend/after_sidebar' );
	?>

</aside><!-- /wp:group -->
<?php
echo do_blocks( ob_get_clean() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
