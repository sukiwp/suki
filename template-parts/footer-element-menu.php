<?php
/**
 * Footer menu template.
 *
 * Passed variables:
 *
 * @type string $element Footer element.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wp_nav_menu(
	array(
		'theme_location' => 'footer-' . $element,
		'menu_class'     => 'suki-footer-' . $element . ' suki-footer-menu menu',
		'container'      => false,
		'depth'          => -1,
		'fallback_cb'    => 'suki_unassigned_menu',
		/* translators: %s: menu number. */
		'items_wrap'     => '<ul class="%2$s" itemscope itemtype="https://schema.org/SiteNavigationElement" aria-label="' . sprintf( esc_attr__( 'Footer Menu %s', 'suki' ), str_replace( 'menu-', '', $element ) ) . '">%3$s</ul>',
	)
);
