<?php
/**
 * Template part for displaying post content in single.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Suki
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry entry-layout-default' ); ?>>
	<div class="entry-wrapper">
		<?php
		/**
		 * Hook: suki_before_entry_header
		 *
		 * @hooked suki_entry_featured_media - 10
		 */
		do_action( 'suki_before_entry_header' );
		
		if ( has_action( 'suki_entry_header' ) ) :
		?>
			<header class="entry-header">
				<?php
				/**
				 * Hook: suki_entry_header
				 *
				 * @hooked suki_entry_header_meta - 10
				 * @hooked suki_entry_title - 20
				 */
				do_action( 'suki_entry_header' );
				?>
			</header>
		<?php
		endif;

		/**
		 * Hook: suki_after_entry_header
		 */
		do_action( 'suki_after_entry_header' );
		?>

		<div class="entry-content">
			<?php
			/**
			 * Hook: suki_before_entry_content
			 */
			do_action( 'suki_before_entry_content' );
			?>

			<?php
			// Print the content.
			the_content( esc_html__( 'Read more', 'suki' ) );

			// Print content pagination, if exists.
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'suki' ),
				'after'  => '</div>',
			) );
			?>

			<?php
			/**
			 * Hook: suki_after_entry_content
			 */
			do_action( 'suki_after_entry_content' );
			?>
		</div>

		<?php
		/**
		 * Hook: suki_before_entry_footer
		 */
		do_action( 'suki_before_entry_footer' );
		
		if ( has_action( 'suki_entry_footer' ) ) :
		?>
			<footer class="entry-footer">
				<?php
				/**
				 * Hook: suki_entry_footer
				 * 
				 * @hooked suki_entry_footer_meta - 10
				 */
				do_action( 'suki_entry_footer' );
				?>
			</footer>
		<?php
		endif;

		/**
		 * Hook: suki_after_entry_footer
		 */
		do_action( 'suki_after_entry_footer' );
		?>
	</div>
</article>
