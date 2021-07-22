<?php
/**
 * Single post entry template.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<div id="post-<?php the_ID(); ?>" <?php post_class( apply_filters( 'suki/frontend/post_content/classes', array( 'entry' ) ) ); ?> role="article">
	<div class="entry-wrapper">
		<?php
		/**
		 * Hook: suki/frontend/post_content/before_header
		 */
		do_action( 'suki/frontend/post_content/before_header' );
		
		if ( has_action( 'suki/frontend/post_content/header' ) ) :
		?>
			<header class="entry-header <?php echo esc_attr( 'suki-text-align-' . suki_get_theme_mod( 'post_single_content_header_alignment' ) ); ?>">
				<?php
				/**
				 * Hook: suki/frontend/post_content/header
				 */
				do_action( 'suki/frontend/post_content/header' );
				?>
			</header>
		<?php
		endif;

		/**
		 * Hook: suki/frontend/post_content/after_header
		 */
		do_action( 'suki/frontend/post_content/after_header' );
		?>

		<div class="entry-content">
			<?php
			/**
			 * Hook: suki/frontend/post_content/before_content
			 */
			do_action( 'suki/frontend/post_content/before_content' );

			// Print the content.
			the_content();

			// Print content pagination, if exists.
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'suki' ),
				'after'  => '</div>',
			) );
			
			/**
			 * Hook: suki/frontend/post_content/after_content
			 */
			do_action( 'suki/frontend/post_content/after_content' );
			?>
		</div>

		<?php
		/**
		 * Hook: suki/frontend/post_content/before_footer
		 */
		do_action( 'suki/frontend/post_content/before_footer' );
		
		if ( has_action( 'suki/frontend/post_content/footer' ) ) :
		?>
			<footer class="entry-footer <?php echo esc_attr( 'suki-text-align-' . suki_get_theme_mod( 'post_single_content_footer_alignment' ) ); ?>">
				<?php
				/**
				 * Hook: suki/frontend/post_content/footer
				 */
				do_action( 'suki/frontend/post_content/footer' );
				?>
			</footer>
		<?php
		endif;

		/**
		 * Hook: suki/frontend/post_content/after_footer
		 */
		do_action( 'suki/frontend/post_content/after_footer' );
		?>
	</div>
</div>
