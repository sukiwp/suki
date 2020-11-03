<?php
/**
 * Single post entry template.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( apply_filters( 'suki/frontend/entry_single/classes', array( 'entry', 'entry-single' ) ) ); ?> role="article">
	<div class="entry-wrapper">
		<?php
		/**
		 * Hook: suki/frontend/entry_single/before_header
		 */
		do_action( 'suki/frontend/entry_single/before_header' );
		
		if ( has_action( 'suki/frontend/entry_single/header' ) ) :
		?>
			<header class="entry-header <?php echo esc_attr( 'suki-text-align-' . suki_get_theme_mod( 'entry_single_header_alignment' ) ); ?>">
				<?php
				/**
				 * Hook: suki/frontend/entry_single/header
				 *
				 * @hooked suki_entry_title - 10
				 * @hooked suki_entry_header_meta - 20
				 * @hooked suki_entry_featured_media - 30
				 */
				do_action( 'suki/frontend/entry_single/header' );
				?>
			</header>
		<?php
		endif;

		/**
		 * Hook: suki/frontend/entry_single/after_header
		 */
		do_action( 'suki/frontend/entry_single/after_header' );
		?>

		<div class="entry-content">
			<?php
			/**
			 * Hook: suki/frontend/entry_single/before_content
			 */
			do_action( 'suki/frontend/entry_single/before_content' );

			// Print the content.
			the_content();

			// Print content pagination, if exists.
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'suki' ),
				'after'  => '</div>',
			) );
			
			/**
			 * Hook: suki/frontend/entry_single/after_content
			 */
			do_action( 'suki/frontend/entry_single/after_content' );
			?>
		</div>

		<?php
		/**
		 * Hook: suki/frontend/entry_single/before_footer
		 */
		do_action( 'suki/frontend/entry_single/before_footer' );
		
		if ( has_action( 'suki/frontend/entry_single/footer' ) ) :
		?>
			<footer class="entry-footer <?php echo esc_attr( 'suki-text-align-' . suki_get_theme_mod( 'entry_single_footer_alignment' ) ); ?>">
				<?php
				/**
				 * Hook: suki/frontend/entry_single/footer
				 * 
				 * @hooked suki_entry_tags - 10
				 * @hooked suki_entry_footer_meta - 20
				 */
				do_action( 'suki/frontend/entry_single/footer' );
				?>
			</footer>
		<?php
		endif;

		/**
		 * Hook: suki/frontend/entry_single/after_footer
		 */
		do_action( 'suki/frontend/entry_single/after_footer' );
		?>
	</div>
</article>
