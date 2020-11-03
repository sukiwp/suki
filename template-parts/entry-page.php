<?php
/**
 * Page entry template.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<article id="page-<?php the_ID(); ?>" <?php post_class( apply_filters( 'suki/frontend/entry_page/classes', array( 'entry', 'entry-page' ) ) ); ?> role="article">
	<div class="entry-wrapper">
		<?php
		/**
		 * Hook: suki/frontend/entry_page/before_header
		 */
		do_action( 'suki/frontend/entry_page/before_header' );
		
		if ( has_action( 'suki/frontend/entry_page/header' ) ) :
		?>
			<header class="entry-header <?php echo esc_attr( 'suki-text-align-' . suki_get_theme_mod( 'entry_page_header_alignment' ) ); ?>">
				<?php
				/**
				 * Hook: suki/frontend/entry_page/header
				 *
				 * @hooked suki_entry_title - 10
				 * @hooked suki_entry_featured_media - 20
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

			/**
			 * Excerpt
			 */

			the_content();

			// Content pagination (if exists)
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
			<footer class="entry-footer <?php echo esc_attr( 'suki-text-align-' . suki_get_theme_mod( 'entry_page_footer_alignment' ) ); ?>">
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
