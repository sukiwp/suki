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
	"align":"full",
	"layout":{
		"inherit":true
	}
} --><div class="wp-block-query">

	<!-- wp:post-template {
		"className":"suki-loop suki-loop-search alignfull"
	} -->

		<!-- wp:group --><div class="wp-block-group">

			<!-- wp:post-title {
				"level":2,
				"isLink":true,
				"className":"entry-title suki-small-title'"
			} /-->

			<!-- wp:post-excerpt /-->

		</div><!-- /wp:group -->

		<!-- wp:spacer {
			"height":"2em",
			"className":"suki-loop-search__spacer"
		} --><div style="height:2em" aria-hidden="true" class="wp-block-spacer suki-loop-search__spacer"></div><!-- /wp:spacer -->

	<!-- /wp:post-template -->

	<?php
	/**
	 * Pagination
	 */
	suki_loop_navigation( suki_get_theme_mod( 'post_archive_pagination_layout' ), false );
	?>

	<!-- wp:query-no-results -->
		<!-- wp:paragraph -->
		<p><?php esc_html_e( 'Nothing found.', 'suki' ); ?></p>
		<!-- /wp:paragraph -->
	<!-- /wp:query-no-results -->

</div><!-- /wp:query -->
