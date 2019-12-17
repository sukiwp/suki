<?php
/**
 * Page header section template.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$elements = array();
$count = 0;
$cols = array( 'left', 'center', 'right' );

foreach ( $cols as $col ) {
	$elements[ $col ] = suki_get_theme_mod( 'page_header_elements_' . $col );
	$count += count( $elements[ $col ] );
}

if ( 1 > $count ) {
	return;
}
?>
<div class="<?php echo esc_attr( implode( ' ', apply_filters( 'suki/frontend/page_header_classes', array( 'suki-page-header' ) ) ) ); ?>">
	<div class="suki-page-header-inner suki-section-inner">
		<div class="suki-wrapper">
			<div class="suki-page-header-row <?php echo esc_attr( ( 0 < count( $elements['center'] ) ) ? 'suki-page-header-row-with-center' : '' ); ?>">
				<?php foreach ( $cols as $col ) : ?>
					<?php
					// Skip center column if it's empty
					if ( 'center' === $col && 0 === count( $elements[ $col ] ) ) {
						continue;
					}
					?>
					<div class="suki-page-header-<?php echo esc_attr( $col ); ?> suki-page-header-column <?php echo esc_attr( 0 === count( $elements[ $col ] ) ? 'suki-page-header-column-empty' : '' ); ?>">
						<?php
						// Print all elements inside the column.
						foreach ( $elements[ $col ] as $element ) {
							suki_page_header_element( $element );
						}
						?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>