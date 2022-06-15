<?php
/**
 * [Customizer] Footer Bottom
 *
 * @package Suki
 */

ob_start();

$elements = array(
	'left'   => suki_get_theme_mod( 'footer_elements_bottom_left', array() ),
	'center' => suki_get_theme_mod( 'footer_elements_bottom_center', array() ),
	'right'  => suki_get_theme_mod( 'footer_elements_bottom_right', array() ),
);

if (
	! boolval( suki_get_current_page_setting( 'disable_footer_bottom' ) ) &&
	0 < array_sum( array_map( 'count', $elements ) )
) {
	?>
	<!-- wp:group {
		"align":"full",
		"className":"suki-footer-bottom-bar <?php echo esc_attr( 'suki-section-' . suki_get_current_page_setting( 'footer_bottom_bar_container' ) ); ?>",
		"layout":{
			"inherit":true
		}
	} --><div class="wp-block-group alignfull suki-footer-bottom-bar <?php echo esc_attr( 'suki-section-' . suki_get_current_page_setting( 'footer_bottom_bar_container' ) ); ?>">

		<!-- wp:group {
			"className":"suki-footer-bottom-row suki-footer-row",
			"layout":{
				"type":"flex",
				"flexWrap":"nowrap",
				"justifyContent":"space-between"
			}
		} --><div class="wp-block-group suki-footer-bottom-row suki-footer-row">

			<?php
			foreach ( array_keys( $elements ) as $column ) {
				// Skip center column if it's empty.
				if ( 'center' === $column && 0 === count( $elements[ $column ] ) ) {
					continue;
				}

				$classes = implode(
					' ',
					array_merge(
						array(
							'suki-footer-column', // Used for additional styles via theme's CSS.
							'suki-footer-column--' . $column, // Used for additional styles via theme's CSS.
						),
						count( $elements[ $column ] ) === 0 ? array(
							'suki-footer-column--empty', // Used for additional styles via theme's CSS.
						) : array()
					)
				);
				?>
				<!-- wp:group {
					"className":"<?php echo esc_attr( $classes ); ?>",
					"layout":{
						"type":"flex",
						"flexWrap":"nowrap",
						"justifyContent":"<?php echo esc_attr( $column ); ?>"
					}
				} --><div class="wp-block-group <?php echo esc_attr( $classes ); ?>">

					<?php
					foreach ( $elements[ $column ] as $element ) {
						suki_footer_element( $element, true, false );
					}
					?>

				</div><!-- /wp:group -->
				<?php
			}
			?>

		</div><!-- /wp:group -->

	</div><!-- /wp:group -->
	<?php
}
$content = ob_get_clean();

return array(
	'title'      => esc_html__( '[Customizer] Footer Bottom', 'suki' ),
	'categories' => array( 'footer' ),
	'blockTypes' => array( 'core/template-part/footer' ),
	'content'    => $content,
);
