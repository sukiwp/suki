<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Suki
 */

?>

<article id="page-<?php the_ID(); ?>" <?php post_class( 'entry entry-page entry-layout-default' ); ?> role="article">
	<div class="entry-wrapper">
		<?php
		/**
		 * Hook: suki_before_static_page_header
		 *
		 * @hooked suki_entry_featured_media - 10
		 */
		do_action( 'suki_before_static_page_header' );
		
		if ( has_action( 'suki_static_page_header' ) ) :
		?>
			<header class="entry-header">
				<?php
				/**
				 * Hook: suki_static_page_header
				 *
				 * @hooked suki_entry_title - 10
				 */
				do_action( 'suki_static_page_header' );
				?>
			</header>
		<?php
		endif;

		/**
		 * Hook: suki_after_static_page_header
		 */
		do_action( 'suki_after_static_page_header' );
		?>

		<div class="entry-content">
			<?php
			/**
			 * Hook: suki_before_static_page_content
			 */
			do_action( 'suki_before_static_page_content' );

			// Print the content.
			the_content();

			// Print content pagination, if exists.
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'suki' ),
				'after'  => '</div>',
			) );

			/**
			 * Hook: suki_after_static_page_content
			 */
			do_action( 'suki_after_static_page_content' );
			?>
		</div>

		<?php
		/**
		 * Hook: suki_before_static_page_footer
		 */
		do_action( 'suki_before_static_page_footer' );
		
		if ( has_action( 'suki_static_page_footer' ) ) :
		?>
			<footer class="entry-footer">
				<?php
				/**
				 * Hook: suki_static_page_footer
				 */
				do_action( 'suki_static_page_footer' );
				?>
			</footer>
		<?php
		endif;

		/**
		 * Hook: suki_after_static_page_footer
		 */
		do_action( 'suki_after_static_page_footer' );
		?>
	</div>
</article>
