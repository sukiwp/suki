<?php
/**
 * The template for displaying single Elementor's Template (elementor_library) post type in "section" or "page" type.
 *
 * @package Suki Pro
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>
		<div id="canvas" class="suki-canvas">
			<div id="page" class="site">
				<?php
				while ( have_posts() ) :
					the_post();
					the_content();
				endwhile;
				?>
			</div>
		</div>
		<?php wp_footer(); ?>
	</body>
</html>