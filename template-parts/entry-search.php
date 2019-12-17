<?php
/**
 * Search results entry template.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( apply_filters( 'suki/frontend/entry_search/post_classes', array( 'entry', 'entry-layout-search', 'entry-small' ) ) ); ?> role="article">
	<div class="entry-wrapper">
		<?php
		/**
		 * Hook: suki/frontend/entry_search/before_header
		 */
		do_action( 'suki/frontend/entry_search/before_header' );
		
		if ( has_action( 'suki/frontend/entry_search/header' ) ) :
		?>
			<header class="entry-header">
				<?php
				/**
				 * Hook: suki/frontend/entry_search/header
				 *
				 * @hooked suki_entry_search_title - 10
				 */
				do_action( 'suki/frontend/entry_search/header' );
				?>
			</header>
		<?php
		endif;

		/**
		 * Hook: suki/frontend/entry_search/after_header
		 */
		do_action( 'suki/frontend/entry_search/after_header' );
		?>

		<div class="entry-content entry-excerpt">
			<?php
			/**
			 * Hook: suki/frontend/entry_search/before_content
			 */
			do_action( 'suki/frontend/entry_search/before_content' );

			/**
			 * Excerpt
			 */

			the_excerpt();

			// Content pagination (if exists)
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'suki' ),
				'after'  => '</div>',
			) );
			
			/**
			 * Hook: suki/frontend/entry_search/after_content
			 */
			do_action( 'suki/frontend/entry_search/after_content' );
			?>
		</div>

		<?php
		/**
		 * Hook: suki/frontend/entry_search/before_footer
		 */
		do_action( 'suki/frontend/entry_search/before_footer' );
		
		if ( has_action( 'suki/frontend/entry_search/footer' ) ) :
		?>
			<footer class="entry-footer">
				<?php
				/**
				 * Hook: suki/frontend/entry_search/footer
				 */
				do_action( 'suki/frontend/entry_search/footer' );
				?>
			</footer>
		<?php
		endif;

		/**
		 * Hook: suki/frontend/entry_search/after_footer
		 */
		do_action( 'suki/frontend/entry_search/after_footer' );
		?>
	</div>
</article>
