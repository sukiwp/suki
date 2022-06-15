<?php
/**
 * [Customizer] Mobile Header
 *
 * @package Suki
 */

ob_start();

$elements = array(
	'top'    => array(
		'left'   => suki_get_theme_mod( 'header_elements_top_left', array() ),
		'center' => suki_get_theme_mod( 'header_elements_top_center', array() ),
		'right'  => suki_get_theme_mod( 'header_elements_top_right', array() ),
	),
	'main'   => array(
		'left'   => suki_get_theme_mod( 'header_elements_main_left', array() ),
		'center' => suki_get_theme_mod( 'header_elements_main_center', array() ),
		'right'  => suki_get_theme_mod( 'header_elements_main_right', array() ),
	),
	'bottom' => array(
		'left'   => suki_get_theme_mod( 'header_elements_bottom_left', array() ),
		'center' => suki_get_theme_mod( 'header_elements_bottom_center', array() ),
		'right'  => suki_get_theme_mod( 'header_elements_bottom_right', array() ),
	),
);

if (
	! boolval( suki_get_current_page_setting( 'disable_header_mobile' ) ) &&
	0 < array_sum( array_map( 'count', $elements ) )
) {
	?>
	<!-- wp:group {
		"align":"full",
		"className":"suki-header-desktop suki-show-on-desktop"
		"layout":{
			"inherit":true
		}
	} --><div id="header" class="wp-block-group alignfull suki-header-desktop suki-show-on-desktop">

		<?php
		if ( boolval( suki_get_theme_mod( 'header_top_bar_merged' ) ) ) {
			?>
			<!-- wp:pattern {
				"slug":"suki/header-top--customizer"
			} /-->
			<?php
		}
		?>

		<!-- wp:pattern {
			"slug":"suki/header-main--customizer"
		} /-->

		<?php
		if ( boolval( suki_get_theme_mod( 'header_bottom_bar_merged' ) ) ) {
			?>
			<!-- wp:pattern {
				"slug":"suki/header-bottom--customizer"
			} /-->
			<?php
		}
		?>

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
