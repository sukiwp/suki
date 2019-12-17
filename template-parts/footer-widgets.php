<?php
/**
 * Footer widgets section template.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$columns = intval( suki_get_theme_mod( 'footer_widgets_bar' ) );

if ( 1 > $columns ) {
	return;
}

$print_row = 0;
for ( $i = 1; $i <= $columns; $i++ ) {
	if ( is_active_sidebar( 'footer-widgets-' . $i ) ) {
		$print_row = true;
		break;
	}
}
?>
<div id="suki-footer-widgets-bar" class="<?php echo esc_attr( implode( ' ', apply_filters( 'suki/frontend/footer_widgets_bar_classes', array( 'suki-footer-widgets-bar', 'suki-footer-section', 'suki-section' ) ) ) ); ?>">
	<div class="suki-footer-widgets-bar-inner suki-section-inner">
		<div class="suki-wrapper">
			<?php if ( $print_row ) : ?>
				<div class="suki-footer-widgets-bar-row <?php echo esc_attr( 'suki-footer-widgets-bar-columns-' . suki_get_theme_mod( 'footer_widgets_bar' ) ); ?>">
					<?php for ( $i = 1; $i <= $columns; $i++ ) : ?>
						<div class="suki-footer-widgets-bar-column-<?php echo esc_attr( $i ); ?> suki-footer-widgets-bar-column">
							<?php if ( is_active_sidebar( 'footer-widgets-' . $i ) ) {
								dynamic_sidebar( 'footer-widgets-' . $i );
							} ?>
						</div>
					<?php endfor; ?>
				</div>
			<?php endif; ?>

			<?php
			// Bottom Bar (if merged)
			if ( intval( suki_get_theme_mod( 'footer_bottom_bar_merged' ) ) ) {
				suki_footer_bottom();
			}
			?>

		</div>
	</div>
</div>