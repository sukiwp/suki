<?php
/**
 * Template Name: Page Builder (theme)
 *
 * Page template for displaying content built by Page Builder plugins, such as Elementor, Brizy, etc.
 * The template doesn't use default theme's content container, you can specify the container for each section on the Page Builder.
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