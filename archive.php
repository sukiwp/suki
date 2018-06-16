<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) :

			if ( has_action( 'suki_page_header' ) ) :
			?>
				<header class="page-header">
					<?php
					/**
					 * Hook: suki_page_header
					 * 
					 * @hooked suki_archive_title - 10
					 * @hooked suki_archive_description - 20
					 */
					do_action( 'suki_page_header' );
					?>
				</header>
			<?php
			endif;

			/**
			 * Hook: suki_before_main
			 */
			do_action( 'suki_before_main' );
			?>
			
			<div id="loop" class="suki-loop <?php echo esc_attr( implode( ' ', apply_filters( 'suki_loop_classes', array() ) ) ); ?>">
				<?php
				// Start the loop.
				while ( have_posts() ) : the_post();

					// Render post content using selected layout on Customizer.
					get_template_part( 'template-parts/content', suki_get_theme_mod( 'blog_index_loop_mode' ) );

				endwhile;
				?>
			</div>

			<?php
			/**
			 * Hook: suki_after_main
			 * 
			 * @hooked suki_loop_navigation - 10
			 */
			do_action( 'suki_after_main' );

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

	</main>
</div>

<?php
get_sidebar();
get_footer();
