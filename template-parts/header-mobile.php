<?php
/**
 * Mobile header sections template.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<div id="mobile-header" class="<?php echo esc_attr( implode( ' ', apply_filters( 'suki/frontend/header_mobile_classes', array( 'suki-header-mobile', 'suki-header' ) ) ) ); ?>">
	<?php
	$elements = array();
	$count = 0;
	$cols = array( 'left', 'center', 'right' );

	foreach ( $cols as $col ) {
		$elements[ $col ] = suki_get_theme_mod( 'header_mobile_elements_main_' . $col, array() );
		$count += count( $elements[ $col ] );
	}

	if ( 1 > $count ) {
		return;
	}

	$attrs_array = apply_filters( 'suki/frontend/header_mobile_main_bar_attrs', array(
		'data-height' => intval( suki_get_theme_mod( 'header_mobile_main_bar_height' ) ),
	) );
	$attrs = '';
	foreach ( $attrs_array as $key => $value ) {
		$attrs .= ' ' . $key . '="' . esc_attr( $value ) . '"';
	}

	?>
	<div id="suki-header-mobile-main-bar" class="<?php echo esc_attr( implode( ' ', apply_filters( 'suki/frontend/header_mobile_main_bar_classes', array( 'suki-header-mobile-main-bar', 'suki-header-section', 'suki-section', 'suki-section-default' ) ) ) ); ?>" <?php echo $attrs; // WPCS: XSS OK ?>>
		<div class="suki-header-mobile-main-bar-inner suki-section-inner">
			<div class="suki-wrapper">
				<div class="suki-header-mobile-main-bar-row suki-header-row <?php echo esc_attr( ( 0 < count( $elements['center'] ) ) ? 'suki-header-row-with-center' : '' ); ?>">
					<?php foreach ( $cols as $col ) : ?>
						<?php
						// Skip center column if it's empty
						if ( 'center' === $col && 0 === count( $elements[ $col ] ) ) {
							continue;
						}
						?>
						<div class="<?php echo esc_attr( 'suki-header-mobile-main-bar-' . $col ); ?> suki-header-column">
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
</div>