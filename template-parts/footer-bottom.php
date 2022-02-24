<?php
/**
 * Footer bottom section template.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="<?php suki_element_class( 'footer_bottom_bar', array( 'suki-footer-bottom-bar', 'suki-block-container', 'site-info' ) ); ?>">
	<div class="<?php suki_element_class( 'footer_bottom_bar_inner', array( 'suki-footer-row', 'wp-block-columns' ) ); ?>">
		<?php
		foreach ( array( 'left', 'center', 'right' ) as $column ) {
			$elements = suki_get_theme_mod( 'footer_elements_bottom_' . $column, array() );

			// Skip center column if it's empty.
			if ( 'center' === $column && 0 === count( $elements ) ) {
				continue;
			}
			?>
			<div class="<?php echo esc_attr( 'suki-footer-column-' . $column . ' suki-footer-column wp-block-column' ); ?>">
				<?php
				// Print elements.
				foreach ( $elements as $element ) {
					suki_footer_element( $element );
				}
				?>
			</div>
			<?php
		}
		?>
	</div>
</div>
