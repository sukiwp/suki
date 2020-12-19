<?php
/**
 * Single post entry template.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<div id="post-<?php the_ID(); ?>" <?php post_class( apply_filters( 'suki/frontend/single_entry/classes', array( 'entry', 'entry-single' ) ) ); ?> role="article">
	<div class="entry-wrapper">
		<?php
		/**
		 * Hook: suki/frontend/single_entry/before_header
		 *
		 * @hooked suki_entry_thumbnail - 10
		 */
		do_action( 'suki/frontend/single_entry/before_header' );
		
		if ( has_action( 'suki/frontend/single_entry/header' ) ) :
		?>
			<header class="entry-header <?php echo esc_attr( 'suki-text-align-' . suki_get_theme_mod( 'post_single_content_header_alignment' ) ); ?>">
				<?php
				/**
				 * Hook: suki/frontend/single_entry/header
				 *
				 * @hooked suki_content_header - 10
				 */
				do_action( 'suki/frontend/single_entry/header' );
				?>
			</header>
		<?php
		endif;

		/**
		 * Hook: suki/frontend/single_entry/after_header
		 *
		 * @hooked suki_entry_thumbnail - 10
		 */
		do_action( 'suki/frontend/single_entry/after_header' );
		?>

		<div class="entry-content">
			<?php
			/**
			 * Hook: suki/frontend/single_entry/before_content
			 */
			do_action( 'suki/frontend/single_entry/before_content' );

			// Print the content.
			the_content();

			// Print content pagination, if exists.
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'suki' ),
				'after'  => '</div>',
			) );
			
			/**
			 * Hook: suki/frontend/single_entry/after_content
			 */
			do_action( 'suki/frontend/single_entry/after_content' );
			?>
		</div>

		<?php
		/**
		 * Hook: suki/frontend/single_entry/before_footer
		 */
		do_action( 'suki/frontend/single_entry/before_footer' );
		
		if ( has_action( 'suki/frontend/single_entry/footer' ) ) :
		?>
			<footer class="entry-footer <?php echo esc_attr( 'suki-text-align-' . suki_get_theme_mod( 'post_single_content_footer_alignment' ) ); ?>">
				<?php
				/**
				 * Hook: suki/frontend/single_entry/footer
				 * 
				 * @hooked suki_entry_tags - 10
				 * @hooked suki_entry_footer_meta - 20
				 */
				do_action( 'suki/frontend/single_entry/footer' );
				?>
			</footer>
		<?php
		endif;

		/**
		 * Hook: suki/frontend/single_entry/after_footer
		 */
		do_action( 'suki/frontend/single_entry/after_footer' );
		?>
	</div>
</div>
