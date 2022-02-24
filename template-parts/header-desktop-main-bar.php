<?php
/**
 * Main header main bar template.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$elements = array();
$columns  = array( 'left', 'center', 'right' );
$count    = 0;

// Fetch elements on all columns.
foreach ( $columns as $column ) {
	$elements[ $column ] = suki_get_theme_mod( 'header_elements_main_' . $column, array() );

	$count += count( $elements[ $column ] );
}

// Abort if no element found in this section.
if ( 1 > $count ) {
	return;
}

?>
<div class="<?php suki_element_class( 'header_main_bar', array( 'suki-header-main-bar', 'suki-header-section', 'suki-block-container' ) ); ?>">
	<?php
	// Header Top Bar (if merged).
	if ( intval( suki_get_theme_mod( 'header_top_bar_merged' ) ) ) {
		suki_header_desktop__top_bar( true );
	}
	?>

	<div class="<?php suki_element_class( 'header_main_bar_inner', array( 'suki-header-row', 'wp-block-columns', 'is-not-stacked-on-mobile' ) ); ?>">
		<?php
		foreach ( $columns as $column ) {
			// Skip center column if it's empty.
			if ( 'center' === $column && 0 === count( $elements[ $column ] ) ) {
				continue;
			}
			?>
			<div class="<?php echo esc_attr( 'suki-header-column-' . $column . ' suki-header-column wp-block-column' ); ?>">
				<?php
				// Print elements.
				foreach ( $elements[ $column ] as $element ) {
					suki_header_element( $element );
				}
				?>
			</div>
			<?php
		}
		?>
	</div>

	<?php
	// Header Bottom Bar (if merged).
	if ( intval( suki_get_theme_mod( 'header_bottom_bar_merged' ) ) ) {
		suki_header_desktop__bottom_bar( true );
	}
	?>
</div>
