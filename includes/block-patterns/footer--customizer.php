<?php
/**
 * [Customizer] Footer
 *
 * @package Suki
 */

ob_start();
?>
<!-- wp:group {
	"tagName":"footer",
	"align":"full",
	"style":{
		"spacing":{
			"blockGap":"0px"
		}
	},
	"className":"suki-footer site-footer",
	"layout":{
		"inherit":true
	}
} --><footer id="colophon" class="wp-block-group alignfull suki-footer site-footer" aria-label="<?php esc_attr_e( 'Site Footer', 'suki' ); ?>" itemscope itemtype="https://schema.org/WPFooter">

	<!-- wp:pattern {
		"slug":"suki/footer-widgets--customizer"
	} /-->

	<?php
	if ( ! boolval( suki_get_theme_mod( 'footer_bottom_bar_merged' ) ) ) {
		?>
		<!-- wp:pattern {
			"slug":"suki/footer-bottom--customizer"
		} /-->
		<?php
	}
	?>

</footer>
<?php
$content = ob_get_clean();

return array(
	'title'      => esc_html__( '[Customizer] Footer', 'suki' ),
	'categories' => array( 'footer' ),
	'blockTypes' => array( 'core/template-part/footer' ),
	'content'    => $content,
);
