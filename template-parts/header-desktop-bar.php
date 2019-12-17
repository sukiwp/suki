<?php
/**
 * Main header section template.
 *
 * Passed variables:
 *
 * @type string $bar Header section bar slug (top/main/bottom).
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$elements = array();
$count = 0;
$cols = array( 'left', 'center', 'right' );

foreach ( $cols as $col ) {
	$elements[ $col ] = suki_get_theme_mod( 'header_elements_' . $bar . '_' . $col, array() );
	$count += count( $elements[ $col ] );
}

if ( 1 > $count ) {
	return;
}

$attrs_array = apply_filters( 'suki/frontend/header_' . $bar . '_bar_attrs', array(
	'data-height' => intval( suki_get_theme_mod( 'header_' . $bar . '_bar_height' ) ),
) );
$attrs = '';
foreach ( $attrs_array as $key => $value ) {
	$attrs .= ' ' . $key . '="' . esc_attr( $value ) . '"';
}

?>
<div id="suki-header-<?php echo esc_attr( $bar ); ?>-bar" class="<?php echo esc_attr( implode( ' ', apply_filters( 'suki/frontend/header_' . $bar . '_bar_classes', array( 'suki-header-' . $bar . '-bar', 'suki-header-section', 'suki-section' ) ) ) ); ?>" <?php echo $attrs; // WPCS: XSS OK ?>>
	<div class="suki-header-<?php echo esc_attr( $bar ); ?>-bar-inner suki-section-inner">
		<div class="suki-wrapper">

			<?php
			// Top Bar (if merged).
			if ( 'main' === $bar && intval( suki_get_theme_mod( 'header_top_bar_merged' ) ) ) {
				suki_main_header__bar( 'top' );
			}
			?>

			<div class="suki-header-<?php echo esc_attr( $bar ); ?>-bar-row suki-header-row <?php echo esc_attr( ( 0 < count( $elements['center'] ) ) ? 'suki-header-row-with-center' : '' ); ?>">
				<?php foreach ( $cols as $col ) : ?>
					<?php
					// Skip center column if it's empty
					if ( 'center' === $col && 0 === count( $elements[ $col ] ) ) {
						continue;
					}
					?>
					<div class="<?php echo esc_attr( 'suki-header-' . $bar . '-bar-' . $col ); ?> suki-header-column">
						<?php
						// Print all elements inside the column.
						foreach ( $elements[ $col ] as $element ) {
							suki_header_element( $element );
						}
						?>
					</div>
				<?php endforeach; ?>
			</div>

			<?php
			// Bottom Bar (if merged).
			if ( 'main' === $bar && intval( suki_get_theme_mod( 'header_bottom_bar_merged' ) ) ) {
				suki_main_header__bar( 'bottom' );
			}
			?>

		</div>
	</div>
</div>