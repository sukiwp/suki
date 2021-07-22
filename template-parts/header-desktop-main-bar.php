<?php
/**
 * Main header main bar template.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$elements = array();
$count = 0;
$cols = array( 'left', 'center', 'right' );

foreach ( $cols as $col ) {
	$elements[ $col ] = suki_get_theme_mod( 'header_elements_main_' . $col, array() );
	$count += count( $elements[ $col ] );
}

if ( 1 > $count ) {
	return;
}
?>
<div id="suki-header-main-bar" class="<?php echo esc_attr( implode( ' ', apply_filters( 'suki/frontend/header_main_bar_classes', array( 'suki-header-main-bar', 'suki-header-section', 'suki-section' ) ) ) ); ?>">
	<div class="suki-header-main-bar-inner suki-section-inner">

		<?php
		// Top Bar (if merged).
		if ( intval( suki_get_theme_mod( 'header_top_bar_merged' ) ) ) {
			suki_main_header__top_bar( true );
		}
		?>

		<div class="suki-wrapper">
			<div class="suki-header-main-bar-row suki-header-row <?php echo esc_attr( ( 0 < count( $elements['center'] ) ) ? 'suki-header-row-with-center' : '' ); ?>">
				<?php foreach ( $cols as $col ) : ?>
					<?php
					// Skip center column if it's empty
					if ( 'center' === $col && 0 === count( $elements[ $col ] ) ) {
						continue;
					}
					?>
					<div class="<?php echo esc_attr( 'suki-header-main-bar-' . $col ); ?> suki-header-column">
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

		<?php
		// Bottom Bar (if merged).
		if ( intval( suki_get_theme_mod( 'header_bottom_bar_merged' ) ) ) {
			suki_main_header__bottom_bar( true );
		}
		?>

	</div>
</div>