<?php
/**
 * Header menu template.
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
<nav class="<?php echo esc_attr( 'suki-header-' . $slug ); ?> suki-header-menu site-navigation" itemtype="https://schema.org/SiteNavigationElement" itemscope role="navigation" aria-label="<?php echo esc_attr( sprintf( esc_html__( 'Header Menu %s', 'suki' ), str_replace( 'menu-', '', $slug ) ) ); ?>">
	<?php wp_nav_menu( array(
		'theme_location' => 'header-' . $slug,
		'menu_class'     => 'menu suki-hover-menu',
		'container'      => false,
		'fallback_cb'    => 'suki_unassigned_menu',
	) ); ?>
</nav>