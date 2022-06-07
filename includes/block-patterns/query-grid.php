<?php
/**
 * Posts Layout: Grid
 *
 * @package Suki
 */

ob_start();
?>

<?php
$content = ob_get_clean();

return array(
	'title'      => esc_html__( 'Posts Layout: Grid', 'suki' ),
	'categories' => array( 'query' ),
	'blockTypes' => array( 'core/query' ),
	'content'    => $content,
);
