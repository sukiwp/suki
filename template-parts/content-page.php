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
		 * Hook: suki/frontend/entry_page/before_header
		 *
		 * @hooked suki_entry_featured_media - 10
		 */
		do_action( 'suki/frontend/entry_page/before_header' );
		
		if ( has_action( 'suki/frontend/entry_page/header' ) ) :
		?>
			<header class="entry-header <?php echo esc_attr( 'suki-text-align-' . suki_get_theme_mod( 'entry_header_alignment' ) ); ?>">
				<?php
				/**
				 * Hook: suki/frontend/entry_page/header
				 *
				 * @hooked suki_entry_title - 10
				 */
				do_action( 'suki/frontend/entry_page/header' );
				?>
			</header>
		<?php
		endif;

		/**
		 * Hook: suki/frontend/entry_page/after_header
		 */
		do_action( 'suki/frontend/entry_page/after_header' );
		?>

		<div class="entry-content">
			<?php
			/**
			 * Hook: suki/frontend/entry_page/before_content
			 */
			do_action( 'suki/frontend/entry_page/before_content' );

			// Print the content.
			the_content();

			// Print content pagination, if exists.
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'suki' ),
				'after'  => '</div>',
			) );

			/**
			 * Hook: suki/frontend/entry_page/after_content
			 */
			do_action( 'suki/frontend/entry_page/after_content' );
			?>
		</div>

		<?php
		/**
		 * Hook: suki/frontend/entry_page/before_footer
		 */
		do_action( 'suki/frontend/entry_page/before_footer' );
		
		if ( has_action( 'suki/frontend/entry_page/footer' ) ) :
		?>
			<footer class="entry-footer">
				<?php
				/**
				 * Hook: suki/frontend/entry_page/footer
				 */
				do_action( 'suki/frontend/entry_page/footer' );
				?>
			</footer>
		<?php
		endif;

		/**
		 * Hook: suki/frontend/entry_page/after_footer
		 */
		do_action( 'suki/frontend/entry_page/after_footer' );
		?>
	</div>
</article>
