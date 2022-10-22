<?php
/**
 * Template: Loop search
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<!-- wp:query {
	"query":{
		"inherit":true
	},
	"layout":{
		"inherit":true
	}
} --><div class="wp-block-query">

	<!-- wp:post-template {
		"style":{
			"spacing":{
				"blockGap":"3em"
			}
		},
		"className":"suki-loop suki-loop--layout-search"
	} -->

		<!-- wp:group {
			"tagName":"article",
			"className":"entry entry--layout-search"
		} --><article class="wp-block-group entry entry--layout-search">

			<!-- wp:post-title {
				"level":2,
				"isLink":true,
				"className":"entry-title suki-small-title"
			} /-->

			<!-- wp:post-excerpt /-->

		</article><!-- /wp:group -->

	<!-- /wp:post-template -->

	<?php
	/**
	 * Pagination
	 */
	suki_loop_navigation( suki_get_theme_mod( 'post_archive_navigation_mode' ), false );
	?>

	<!-- wp:query-no-results -->
		<!-- wp:paragraph -->
		<p><?php esc_html_e( 'Nothing found.', 'suki' ); ?></p>
		<!-- /wp:paragraph -->
	<!-- /wp:query-no-results -->

</div><!-- /wp:query -->
