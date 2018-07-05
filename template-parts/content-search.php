<?php
/**
 * Template part for displaying search results item.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Suki
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry entry-layout-search entry-small' ); ?> role="article">
	<div class="entry-wrapper">
		<?php
		/**
		 * Hook: suki_before_entry_search_header
		 */
		do_action( 'suki_before_entry_search_header' );
		
		if ( has_action( 'suki_entry_search_header' ) ) :
		?>
			<header class="entry-header">
				<?php
				/**
				 * Hook: suki_entry_search_header
				 *
				 * @hooked suki_entry_search_title - 10
				 */
				do_action( 'suki_entry_search_header' );
				?>
			</header>
		<?php
		endif;

		/**
		 * Hook: suki_after_entry_search_header
		 */
		do_action( 'suki_after_entry_search_header' );
		?>

		<div class="entry-excerpt">
			<?php
			/**
			 * Hook: suki_before_entry_search_content
			 */
			do_action( 'suki_before_entry_search_content' );
			
			// Print the content.
			the_excerpt();

			// Print content pagination, if exists.
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'suki' ),
				'after'  => '</div>',
			) );
			
			/**
			 * Hook: suki_after_entry_search_content
			 */
			do_action( 'suki_after_entry_search_content' );
			?>
		</div>

		<?php
		/**
		 * Hook: suki_before_entry_search_footer
		 */
		do_action( 'suki_before_entry_search_footer' );
		
		if ( has_action( 'suki_entry_search_footer' ) ) :
		?>
			<footer class="entry-footer">
				<?php
				/**
				 * Hook: suki_entry_search_footer
				 */
				do_action( 'suki_entry_search_footer' );
				?>
			</footer>
		<?php
		endif;

		/**
		 * Hook: suki_after_entry_search_footer
		 */
		do_action( 'suki_after_entry_search_footer' );
		?>
	</div>
</article>
