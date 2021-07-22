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
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<div class="<?php echo esc_attr( 'suki-header-' . $element ); ?> site-branding menu">
	<div class="site-title menu-item h1">
		<a href="<?php echo esc_url( apply_filters( 'suki/frontend/logo_url', home_url( '/' ) ) ); ?>" rel="home" class="suki-menu-item-link">
			<?php
			/**
			 * Hook: suki/frontend/mobile_logo
			 *
			 * @hooked suki_default_mobile_logo - 10
			 */
			do_action( 'suki/frontend/mobile_logo' );
			?>
		</a>
	</div>
</div>