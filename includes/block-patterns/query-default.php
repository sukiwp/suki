<?php
/**
 * Posts Layout: Default
 *
 * @package Suki
 */

ob_start();
?>

<?php
$content = ob_get_clean();

return array(
	'title'      => esc_html__( 'Posts Layout: Default', 'suki' ),
	'categories' => array( 'query' ),
	'blockTypes' => array( 'core/query' ),
	'content'    => $content,
);
