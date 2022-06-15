<?php
/**
 * [Customizer] Header Desktop & Mobile
 *
 * @package Suki
 */

ob_start();
?>
<!-- wp:group {
	"tagName":"header",
	"align":"full",
	"style":{
		"spacing":{
			"blockGap":"0px"
		}
	},
	"className":"suki-header site-header",
	"layout":{
		"inherit":true
	}
} --><header id="masthead" class="wp-block-group alignfull suki-header site-header" aria-label="<?php esc_attr_e( 'Site Header', 'suki' ); ?>" itemscope itemtype="https://schema.org/WPHeader">

	<!-- wp:pattern {
		"slug":"suki/header-desktop--customizer"
	} /-->

	<!-- wp:pattern {
		"slug":"suki/header-mobile--customizer"
	} /-->

</header><!-- /wp:group -->
<?php
$content = ob_get_clean();

return array(
	'title'      => esc_html__( '[Customizer] Header Desktop & Mobile', 'suki' ),
	'categories' => array( 'header' ),
	'blockTypes' => array( 'core/template-part/header' ),
	'content'    => $content,
);
