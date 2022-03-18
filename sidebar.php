<?php
/**
 * Global sidebar template.
 *
 * @package Suki
 * @since 2.0.0 Remove `sidebar-inner` wrapping tag and add `aria-label`.
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<aside id="secondary" class="<?php suki_element_class( 'sidebar', array( 'sidebar' ) ); ?>" aria-label="<?php esc_attr_e( 'Sidebar', 'suki' ); ?>" itemscope itemtype="https://schema.org/WPSideBar">
	<?php
	/**
	 * Hook: suki/frontend/before_sidebar
	 */
	do_action( 'suki/frontend/before_sidebar' );

	/**
	 * Sidebar elements.
	 */
	if ( is_active_sidebar( 'sidebar' ) ) {
		dynamic_sidebar( 'sidebar' );
	}

	/**
	 * Hook: suki/frontend/after_sidebar
	 */
	do_action( 'suki/frontend/after_sidebar' );
	?>
</aside>
