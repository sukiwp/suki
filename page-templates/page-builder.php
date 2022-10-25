<?php
/**
 * Template Name: [Theme] Page Builder
 *
 * Page template for Page Builder plugins that have their own content container / wrapper functionalities, for example:
 * - Elementor
 * - Brizy
 *
 * The template doesn't use theme's default container, you can specify the container for each section on the Page Builder.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

the_post();

ob_start();
?>
<!-- wp:group {
	"tagName":"main",
	"className":"site-content"
} --><main id="content" class="wp-block-group site-content">

	<!-- wp:post-content /-->

</main><!-- /wp:group -->
<?php
$html = ob_get_clean();

$html = do_blocks( $html );

echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

get_footer();
