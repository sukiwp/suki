<?php
/**
 * Posts Query Pagination / Navigation with Previous and Next Links
 *
 * @package Suki
 */

ob_start();
?>
<!-- wp:query-pagination {
	"paginationArrow":"arrow",
	"layout":{
		"type":"flex",
		"justifyContent":"space-between",
		"orientation":"horizontal"
	},
	"className":"suki-archive-navigation"
} -->

	<!-- wp:query-pagination-previous {
		"label":"<?php esc_html_e( 'Newer Posts', 'suki' ); ?>"
	} /-->

	<!-- wp:query-pagination-next {
		"label":"<?php esc_html_e( 'Older Posts', 'suki' ); ?>"
	} /-->

<!-- /wp:query-pagination -->
<?php
$content = ob_get_clean();

return array(
	'title'      => esc_html__( 'Posts Query Pagination / Navigation with Previous and Next Links', 'suki' ),
	'categories' => array( 'pagination' ),
	'blockTypes' => array( 'core/query' ),
	'content'    => $content,
);
