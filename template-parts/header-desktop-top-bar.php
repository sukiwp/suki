<?php
/**
 * Main header top bar template.
 *
 * Passed variables:
 *
 * @type boolean $merged whether it's a merged header bar.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$elements = array();
$count = 0;
$cols = array( 'left', 'center', 'right' );

foreach ( $cols as $col ) {
	$elements[ $col ] = suki_get_theme_mod( 'header_elements_top_' . $col, array() );
	$count += count( $elements[ $col ] );
}

if ( 1 > $count ) {
	return;
}

$attrs_array = apply_filters( 'suki/frontend/header_top_bar_attrs', array(
	'data-height' => intval( suki_get_theme_mod( 'header_top_bar_height' ) ),
) );
$attrs = '';
foreach ( $attrs_array as $key => $value ) {
	$attrs .= ' ' . $key . '="' . esc_attr( $value ) . '"';
}

?>
<div id="suki-header-top-bar" class="<?php echo esc_attr( implode( ' ', apply_filters( 'suki/frontend/header_top_bar_classes', array( 'suki-header-top-bar', 'suki-header-section', 'suki-section' ) ) ) ); ?>" <?php echo $attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>

	<?php if ( $merged ) : ?>
		<div class="suki-wrapper">
			<div class="suki-header-top-bar-inner suki-section-inner">
	<?php else: ?>
		<div class="suki-header-top-bar-inner suki-section-inner">
			<div class="suki-wrapper">
	<?php endif; ?>

			<div class="suki-header-top-bar-row suki-header-row <?php echo esc_attr( ( 0 < count( $elements['center'] ) ) ? 'suki-header-row-with-center' : '' ); ?>">
				<?php foreach ( $cols as $col ) : ?>
					<?php
					// Skip center column if it's empty
					if ( 'center' === $col && 0 === count( $elements[ $col ] ) ) {
						continue;
					}
					?>
					<div class="<?php echo esc_attr( 'suki-header-top-bar-' . $col ); ?> suki-header-column">
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