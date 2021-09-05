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
if ( ! defined( 'ABSPATH' ) ) exit;

// Remove content wrapper on this page template.
add_filter( 'suki/frontend/show_content_wrapper', '__return_false' );

get_header();

?>
<div id="content" class="site-content">

	<?php
	/**
	 * Hero
	 */
	if ( intval( suki_get_current_page_setting( 'hero' ) ) ) {
		suki_hero();
	}
	?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?> role="article">
		<?php
		while ( have_posts() ) :
			the_post();

			// Print the content.
			the_content();
		endwhile;
		?>
	</article>
</div>
<?php

get_footer();