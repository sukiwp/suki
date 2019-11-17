<?php
/**
 * Header logo template.
 *
 * Passed variables:
 *
 * @type string $slug Header element slug.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<div class="<?php echo esc_attr( 'suki-header-' . $slug ); ?> site-branding menu">
	<<?php echo is_front_page() && is_home() ? 'h1' : 'div'; ?> class="site-title menu-item h1">
		<a href="<?php echo esc_url( apply_filters( 'suki/frontend/logo_url', home_url( '/' ) ) ); ?>" rel="home" class="suki-menu-item-link">
			<?php
			/**
			 * Hook: suki/frontend/logo
			 *
			 * @hooked suki_default_logo - 10
			 */
			do_action( 'suki/frontend/logo' );
			?>
		</a>
	</<?php echo is_front_page() && is_home() ? 'h1' : 'div'; ?>>
</div>