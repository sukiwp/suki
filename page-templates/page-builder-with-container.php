<?php
/**
 * Template Name: [Theme] Page Builder with Container
 *
 * Page template for Page Builder plugins that doesn't have their own content container / wrapper functionalities, for example:
 * - Visual Composer
 * - Site Origin
 *
 * The template use theme's default container.
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

	<div class="suki-wrapper">
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
</div>
<?php

get_footer();