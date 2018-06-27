<?php
/**
 * Template part for displaying post content in "Grid" layout archive page.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Suki
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry entry-layout-grid entry-small' ); ?> role="article">
	<div class="entry-wrapper">
		<?php
		/**
		 * Hook: suki_before_entry_grid_header
		 *
		 * @hooked suki_entry_grid_featured_media - 10
		 */
		do_action( 'suki_before_entry_grid_header' );
		
		if ( has_action( 'suki_entry_grid_header' ) ) :
		?>
			<header class="entry-header">
				<?php
				/**
				 * Hook: suki_entry_grid_header
				 *
				 * @hooked suki_entry_grid_header_meta - 10
				 * @hooked suki_entry_grid_title - 20
				 */
				do_action( 'suki_entry_grid_header' );
				?>
			</header>
		<?php
		endif;

		/**
		 * Hook: suki_after_entry_grid_header
		 */
		do_action( 'suki_after_entry_grid_header' );
		?>

		<div class="entry-excerpt">
			<?php
			/**
			 * Hook: suki_before_entry_grid_content
			 */
			do_action( 'suki_before_entry_grid_content' );

			// Print the content.
			the_excerpt();

			// Print content pagination, if exists.
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'suki' ),
				'after'  => '</div>',
			) );

			/**
			 * Hook: suki_after_entry_grid_content
			 */
			do_action( 'suki_after_entry_grid_content' );
			?>
		</div>

		<?php
		/**
		 * Hook: suki_before_entry_grid_footer
		 */
		do_action( 'suki_before_entry_grid_footer' );

		if ( has_action( 'suki_entry_grid_footer' ) ) :
		?>
			<footer class="entry-footer">
				<?php
				/**
				 * Hook: suki_entry_grid_footer
				 * 
				 * @hooked suki_entry_grid_footer_meta - 10
				 */
				do_action( 'suki_entry_grid_footer' );
				?>
			</footer>
		<?php
		endif;

		/**
		 * Hook: suki_after_entry_grid_footer
		 */
		do_action( 'suki_after_entry_grid_footer' );
		?>
	</div>
</article>
