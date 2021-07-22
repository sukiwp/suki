<?php
/**
 * Main header bottom bar template.
 *
 * Passed variables:
 *
 * @type boolean $merged Whether it's a merged header bar.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$elements = array();
$count = 0;
$cols = array( 'left', 'center', 'right' );

foreach ( $cols as $col ) {
	$elements[ $col ] = suki_get_theme_mod( 'header_elements_bottom_' . $col, array() );
	$count += count( $elements[ $col ] );
}

if ( 1 > $count ) {
	return;
}
?>
<div id="suki-header-bottom-bar" class="<?php echo esc_attr( implode( ' ', apply_filters( 'suki/frontend/header_bottom_bar_classes', array( 'suki-header-bottom-bar', 'suki-header-section', 'suki-section' ) ) ) ); ?>">

	<?php if ( $merged ) : ?>
		<div class="suki-wrapper">
			<div class="suki-header-bottom-bar-inner suki-section-inner">
	<?php else: ?>
		<div class="suki-header-bottom-bar-inner suki-section-inner">
			<div class="suki-wrapper">
	<?php endif; ?>

				<div class="suki-header-bottom-bar-row suki-header-row <?php echo esc_attr( ( 0 < count( $elements['center'] ) ) ? 'suki-header-row-with-center' : '' ); ?>">
					<?php foreach ( $cols as $col ) : ?>
						<?php
						// Skip center column if it's empty
						if ( 'center' === $col && 0 === count( $elements[ $col ] ) ) {
							continue;
						}
						?>
						<div class="<?php echo esc_attr( 'suki-header-bottom-bar-' . $col ); ?> suki-header-column">
							<?php
							// Print all elements inside the column.
							foreach ( $elements[ $col ] as $element ) {
								suki_header_element( $element );
							}
							?>
						</div>
					<?php endforeach; ?>
				</div>

			</div>
		</div>
</div>