<?php
/**
 * Mobile header logo template.
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

?>
<<?php echo is_front_page() && is_home() ? 'h1' : 'div'; ?> class="<?php echo esc_attr( 'suki-header-' . $element ); ?> site-branding site-title">
	<a href="<?php echo esc_url( apply_filters( 'suki/frontend/logo_url', home_url( '/' ) ) ); ?>" rel="home">
		<?php
		/**
		 * Hook: suki/frontend/mobile_logo
		 *
		 * @hooked suki_default_mobile_logo - 10
		 */
		do_action( 'suki/frontend/mobile_logo' );
		?>
	</a>
</<?php echo is_front_page() && is_home() ? 'h1' : 'div'; ?>>
