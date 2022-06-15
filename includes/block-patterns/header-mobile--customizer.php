<?php
/**
 * [Customizer] Mobile Header
 *
 * @package Suki
 */

ob_start();

$elements = array(
	'main'     => array(
		'left'   => suki_get_theme_mod( 'header_mobile_elements_main_left', array() ),
		'center' => suki_get_theme_mod( 'header_mobile_elements_main_center', array() ),
		'right'  => suki_get_theme_mod( 'header_mobile_elements_main_right', array() ),
	),
	'vertical' => array(
		'top' => suki_get_theme_mod( 'header_mobile_elements_vertical_top', array() ),
	),
);

if (
	! boolval( suki_get_current_page_setting( 'disable_header_mobile' ) ) &&
	0 < array_sum( array_map( 'count', $elements ) )
) {
	?>
	<!-- wp:group {
		"align":"full",
		"className":"suki-header-mobile suki-hide-on-desktop"
	} --><div id="mobile-header" class="wp-block-group alignfull suki-header-mobile suki-hide-on-desktop">

		<!-- wp:group {
			"className":"suki-header-mobile-main-bar"
		} --><div class="wp-block-group suki-header-mobile-main-bar">

			<!-- wp:group {
				"className":"suki-header-row",
				"layout":{
					"type":"flex",
					"flexWrap":"nowrap",
					"justifyContent":"space-between"
				}
			} --><div class="wp-block-group suki-header-row">

				<?php
				foreach ( array_keys( $elements['main'] ) as $column ) {
					// Skip center column if it's empty.
					if ( 'center' === $column && 0 === count( $elements ) ) {
						continue;
					}
					?>
					<!-- wp:group {
						"className":"suki-header-column-<?php echo esc_attr( $column ); ?> suki-header-column",
						"layout":{
							"type":"flex",
							"flexWrap":"nowrap",
							"justifyContent":"<?php echo esc_attr( $column ); ?>"
						}
					} --><div class="wp-block-group suki-header-column-<?php echo esc_attr( $column ); ?> suki-header-column">

						<?php
						foreach ( $elements['main'][ $column ] as $element ) {
							suki_header_element( $element, true, false );
						}
						?>

					</div><!-- /wp:group -->
					<?php
				}
				?>

			</div><!-- /wp:group -->

		</div><!-- /wp:group -->

	</div><!-- /wp:group -->
	<?php
}
$content = ob_get_clean();

return array(
	'title'      => esc_html__( '[Customizer] Mobile Header', 'suki' ),
	'categories' => array( 'header' ),
	'blockTypes' => array( 'core/template-part/header' ),
	'content'    => $content,
);
