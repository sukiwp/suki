<?php
/**
 * Page entry template.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<div id="page-<?php the_ID(); ?>" <?php post_class( apply_filters( 'suki/frontend/page_entry/classes', array( 'entry', 'entry-page' ) ) ); ?> role="article">
	<div class="entry-wrapper">
		<?php
		/**
		 * Hook: suki/frontend/page_entry/before_header
		 *
		 * @hooked suki_entry_thumbnail - 10
		 */
		do_action( 'suki/frontend/page_entry/before_header' );
		
		if ( has_action( 'suki/frontend/page_entry/header' ) ) :
		?>
			<header class="entry-header <?php echo esc_attr( 'suki-text-align-' . suki_get_theme_mod( 'page_single_content_header_alignment' ) ); ?>">
				<?php
				/**
				 * Hook: suki/frontend/page_entry/header
				 *
				 * @hooked suki_content_header - 10
				 */
				do_action( 'suki/frontend/page_entry/header' );
				?>
			</header>
		<?php
		endif;

		/**
		 * Hook: suki/frontend/page_entry/after_header
		 *
		 * @hooked suki_entry_thumbnail - 10
		 */
		do_action( 'suki/frontend/page_entry/after_header' );
		?>

		<div class="entry-content">
			<?php
			/**
			 * Hook: suki/frontend/page_entry/before_content
			 */
			do_action( 'suki/frontend/page_entry/before_content' );

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
			 * Hook: suki/frontend/page_entry/after_content
			 */
			do_action( 'suki/frontend/page_entry/after_content' );
			?>
		</div>

		<?php
		/**
		 * Hook: suki/frontend/page_entry/before_footer
		 */
		do_action( 'suki/frontend/page_entry/before_footer' );
		
		if ( has_action( 'suki/frontend/page_entry/footer' ) ) :
		?>
			<footer class="entry-footer <?php echo esc_attr( 'suki-text-align-' . suki_get_theme_mod( 'page_single_content_footer_alignment' ) ); ?>">
				<?php
				/**
				 * Hook: suki/frontend/page_entry/footer
				 */
				do_action( 'suki/frontend/page_entry/footer' );
				?>
			</footer>
		<?php
		endif;

		/**
		 * Hook: suki/frontend/page_entry/after_footer
		 */
		do_action( 'suki/frontend/page_entry/after_footer' );
		?>
	</div>
</div>
