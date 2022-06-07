<?php
/**
 * Footer widgets section template.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$columns = intval( suki_get_theme_mod( 'footer_widgets_bar' ) );

// Abort if no column defined.
if ( 1 > $columns ) {
	return;
}

?>
<div class="<?php suki_element_class( 'footer_widgets_bar', array( 'suki-footer-widgets-bar', 'suki-container' ) ); ?>">
	<div class="<?php suki_element_class( 'footer_widgets_bar_inner', array( 'suki-footer-widgets-bar-columns-' . $columns, 'suki-footer-widgets-bar-columns', 'wp-block-columns' ) ); ?>">
		<?php
		for ( $i = 1; $i <= $columns; $i++ ) {
			?>
			<div class="suki-footer-widgets-column-<?php echo esc_attr( $i ); ?> suki-footer-widgets-bar-column wp-block-column">
				<?php
				if ( is_active_sidebar( 'footer-widgets-' . $i ) ) {
					dynamic_sidebar( 'footer-widgets-' . $i );
				}
				?>
			</div>
			<?php
		}
		?>
	</div>

	<?php
	// Bottom Bar (if merged).
	if ( boolval( suki_get_theme_mod( 'footer_bottom_bar_merged' ) ) ) {
		suki_footer_bottom();
	}
	?>
</div>
