<?php
/**
 * Footer bottom section template.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$cols = array( 'left', 'center', 'right' );

$elements = array();
$count = 0;

foreach ( $cols as $col ) {
	$elements[ $col ] = suki_get_theme_mod( 'footer_elements_bottom_' . $col, array() );
	$count += empty( $elements[ $col ] ) ? 0 : count( $elements[ $col ] );
}

if ( 1 > $count ) {
	return;
}

?>
<div id="suki-footer-bottom-bar" class="<?php echo esc_attr( implode( ' ', apply_filters( 'suki/frontend/footer_bottom_bar_classes', array( 'suki-footer-bottom-bar', 'site-info', 'suki-footer-section', 'suki-section' ) ) ) ); ?>">
	<div class="suki-footer-bottom-bar-inner suki-section-inner">
		<div class="suki-wrapper">
			<div class="suki-footer-bottom-bar-row suki-footer-row <?php echo esc_attr( ( 0 < count( $elements['center'] ) ) ? 'suki-footer-row-with-center' : '' ); ?>">
				<?php foreach ( $cols as $col ) : ?>
					<?php
					// Skip center column if it's empty
					if ( 'center' === $col && 0 === count( $elements[ $col ] ) ) {
						continue;
					}
					?>
					<div class="suki-footer-bottom-bar-<?php echo esc_attr( $col ); ?> suki-footer-bottom-bar-column">
						<?php
						// Print all elements inside the column.
						foreach ( $elements[ $col ] as $element ) {
							suki_footer_element( $element );
						}
						?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>