<?php
/**
 * [Customizer] Footer Widgets
 *
 * @package Suki
 */

ob_start();

$columns = intval( suki_get_theme_mod( 'footer_widgets_bar' ) );

if (
	! boolval( suki_get_current_page_setting( 'disable_footer_widgets' ) ) &&
	0 < $columns
) {
	?>
	<!-- wp:group {
		"align":"full",
		"className":"suki-footer-widgets-bar <?php echo esc_attr( 'suki-section-' . suki_get_current_page_setting( 'footer_widgets_bar_container' ) ); ?>",
		"layout":{
			"inherit":true
		}
	} --><div class="wp-block-group alignfull suki-footer-widgets-bar <?php echo esc_attr( 'suki-section-' . suki_get_current_page_setting( 'footer_widgets_bar_container' ) ); ?>">

		<!-- wp:columns {
			"verticalAlignment":"top",
			"className":"suki-footer-widgets-columns"
		} --><div class="wp-block-columns are-vertically-aligned-top suki-footer-widgets-columns">

			<?php
			for ( $i = 1; $i <= $columns; $i++ ) {
				?>
				<!-- wp:column {
					"verticalAlignment":"top",
					"className":"suki-footer-widgets-column-<?php echo esc_attr( $i ); ?> suki-footer-widgets-column"
				} --><div class="wp-block-column is-vertically-aligned-top suki-footer-widgets-column-<?php echo esc_attr( $i ); ?> suki-footer-widgets-column">

					<?php
					if ( is_active_sidebar( 'footer-widgets-' . $i ) ) {
						dynamic_sidebar( 'footer-widgets-' . $i );
					}
					?>

				</div><!-- /wp:column -->
				<?php
			}
			?>

		</div><!-- /wp:columns -->

		<?php
		if ( boolval( suki_get_theme_mod( 'footer_bottom_bar_merged' ) ) ) {
			?>
			<!-- wp:pattern {
				"slug":"suki/footer-bottom--customizer"
			} /-->
			<?php
		}
		?>

	</div><!-- /wp:group -->
	<?php
}
$content = ob_get_clean();

return array(
	'title'      => esc_html__( '[Customizer] Footer Widgets', 'suki' ),
	'categories' => array( 'footer' ),
	'blockTypes' => array( 'core/template-part/footer' ),
	'content'    => $content,
);
