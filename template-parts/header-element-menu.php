<?php
/**
 * Header menu template.
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
<nav class="<?php echo esc_attr( 'suki-header-' . $element ); ?> suki-header-menu site-navigation" role="navigation" itemscope itemtype="https://schema.org/SiteNavigationElement" aria-label="<?php /* translators: %s: menu number. */ echo esc_attr( sprintf( esc_html__( 'Header Menu %s', 'suki' ), str_replace( 'menu-', '', $element ) ) ); ?>">
	<?php wp_nav_menu( array(
		'theme_location' => 'header-' . $element,
		'menu_class'     => 'menu suki-hover-menu',
		'container'      => false,
		'fallback_cb'    => 'suki_unassigned_menu',
	) ); ?>
</nav>