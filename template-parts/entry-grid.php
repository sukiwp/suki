<?php
/**
 * Grid post entry template.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( apply_filters( 'suki/frontend/entry_grid/post_classes', array( 'entry', 'entry-layout-grid', 'entry-small' ) ) ); ?> role="article">
	<div class="entry-wrapper">
		<?php
		/**
		 * Hook: suki/frontend/entry_grid/before_header
		 *
		 * @hooked suki_entry_grid_featured_media - 10
		 */
		do_action( 'suki/frontend/entry_grid/before_header' );
		
		if ( has_action( 'suki/frontend/entry_grid/header' ) ) :
		?>
			<header class="entry-header <?php echo esc_attr( 'suki-text-align-' . suki_get_theme_mod( 'entry_grid_header_alignment' ) ); ?>">
				<?php
				/**
				 * Hook: suki/frontend/entry_grid/header
				 *
				 * @hooked suki_entry_grid_header_meta - 10
				 * @hooked suki_entry_grid_title - 20
				 */
				do_action( 'suki/frontend/entry_grid/header' );
				?>
			</header>
		<?php
		endif;

		/**
		 * Hook: suki/frontend/entry_grid/after_header
		 */
		do_action( 'suki/frontend/entry_grid/after_header' );
		?>

		<div class="entry-content entry-excerpt">
			<?php
			/**
			 * Hook: suki/frontend/entry_grid/before_content
			 */
			do_action( 'suki/frontend/entry_grid/before_content' );

			/**
			 * Excerpt
			 */
			if ( 0 < intval( suki_get_theme_mod( 'entry_grid_excerpt_length' ) ) ) {
				// Excerpt
				the_excerpt();

				// Read more
				if ( '' !== suki_get_theme_mod( 'entry_grid_read_more_display' ) ) {
					?>
					<p>
						<a href="<?php echo esc_url( get_the_permalink() ); ?>" class="<?php echo esc_attr( suki_get_theme_mod( 'entry_grid_read_more_display' ) ); ?>">
							<?php
							$text = suki_get_theme_mod( 'entry_grid_read_more_text' );
							if ( empty( $text ) ) {
								$text = esc_html__( 'Read more', 'suki' );
							}

							echo esc_html( $text );
							?>
						</a>
					</p>
					<?php
				}
			}

			/**
			 * Hook: suki/frontend/entry_grid/after_content
			 */
			do_action( 'suki/frontend/entry_grid/after_content' );
			?>
		</div>

		<?php
		/**
		 * Hook: suki/frontend/entry_grid/before_footer
		 */
		do_action( 'suki/frontend/entry_grid/before_footer' );

		if ( has_action( 'suki/frontend/entry_grid/footer' ) ) :
		?>
			<footer class="entry-footer <?php echo esc_attr( 'suki-text-align-' . suki_get_theme_mod( 'entry_grid_footer_alignment' ) ); ?>">
				<?php
				/**
				 * Hook: suki/frontend/entry_grid/footer
				 * 
				 * @hooked suki_entry_grid_footer_meta - 10
				 */
				do_action( 'suki/frontend/entry_grid/footer' );
				?>
			</footer>
		<?php
		endif;

		/**
		 * Hook: suki/frontend/entry_grid/after_footer
		 */
		do_action( 'suki/frontend/entry_grid/after_footer' );
		?>
	</div>
</article>
