<?php
/**
 * Posts Query Pagination / Navigation with Page Numbers Links
 *
 * @package Suki
 */

ob_start();
?>
<!-- wp:query-pagination {
	"paginationArrow":"arrow",
	"layout":{
		"type":"flex",
		"justifyContent":"center",
		"orientation":"horizontal"
	},
	"className":"suki-archive-navigation"
} -->

	<!-- wp:query-pagination-previous {
		"label":" "
	} /-->

	<!-- wp:query-pagination-numbers /-->

	<!-- wp:query-pagination-next {
		"label":" "
	} /-->

<!-- /wp:query-pagination -->
<?php
$content = ob_get_clean();

return array(
	'title'      => esc_html__( 'Posts Query Pagination / Navigation with Page Numbers Links', 'suki' ),
	'categories' => array( 'query' ),
	'blockTypes' => array( 'core/query' ),
	'content'    => $content,
);
