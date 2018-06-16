<?php
/**
 * The sidebar containing Shop (WooCommerce) widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

// Get current page content layout, skip sidebar if not needed in the layout.
if ( ! in_array( suki_get_current_page_setting( 'content_layout' ), array( 'left-sidebar', 'right-sidebar' ) ) ) return;
?>
<aside id="secondary" class="widget-area sidebar <?php echo esc_attr( implode( ' ', apply_filters( 'suki_sidebar_classes', array() ) ) ); ?>" role="complementary" itemtype="https://schema.org/WPSideBar" itemscope>
	<?php if ( is_active_sidebar( 'sidebar-shop' ) ) : ?>
		<div class="sidebar-inner">
			<?php
			/**
			 * Hook: suki_before_sidebar
			 */
			do_action( 'suki_before_sidebar' );
			
			dynamic_sidebar( 'sidebar-shop' );

			/**
			 * Hook: suki_after_sidebar
			 */
			do_action( 'suki_after_sidebar' );
			?>
		</div>
	<?php endif; ?>
</aside>