<?php
/**
 * Page entry template.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<article id="page-<?php the_ID(); ?>" <?php post_class( apply_filters( 'suki/frontend/entry/page_classes', array( 'entry', 'entry-page', 'entry-layout-default' ) ) ); ?> role="article">
	<div class="entry-wrapper">
		<?php
		/**
		 * Hook: suki/frontend/entry/before_header
		 *
		 * @hooked suki_entry_featured_media - 10
		 */
		do_action( 'suki/frontend/entry/before_header' );
		
		if ( has_action( 'suki/frontend/entry/header' ) ) :
		?>
			<header class="entry-header <?php echo esc_attr( 'suki-text-align-' . suki_get_theme_mod( 'entry_header_alignment' ) ); ?>">
				<?php
				/**
				 * Hook: suki/frontend/entry/header
				 *
				 * @hooked suki_entry_title - 10
				 */
				do_action( 'suki/frontend/entry/header' );
				?>
			</header>
		<?php
		endif;

		/**
		 * Hook: suki/frontend/entry/after_header
		 */
		do_action( 'suki/frontend/entry/after_header' );
		?>

		<div class="entry-content">
			<?php
			/**
			 * Hook: suki/frontend/entry/before_content
			 */
			do_action( 'suki/frontend/entry/before_content' );

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
			 * Hook: suki/frontend/entry/after_content
			 */
			do_action( 'suki/frontend/entry/after_content' );
			?>
		</div>

		<?php
		/**
		 * Hook: suki/frontend/entry/before_footer
		 */
		do_action( 'suki/frontend/entry/before_footer' );
		
		if ( has_action( 'suki/frontend/entry/footer' ) ) :
		?>
			<footer class="entry-footer <?php echo esc_attr( 'suki-text-align-' . suki_get_theme_mod( 'entry_footer_alignment' ) ); ?>">
				<?php
				/**
				 * Hook: suki/frontend/entry/footer
				 */
				do_action( 'suki/frontend/entry/footer' );
				?>
			</footer>
		<?php
		endif;

		/**
		 * Hook: suki/frontend/entry/after_footer
		 */
		do_action( 'suki/frontend/entry/after_footer' );
		?>
	</div>
</article>
