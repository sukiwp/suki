<?php
/**
 * Default entry template.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( apply_filters( 'suki/frontend/entry/post_classes', array( 'entry', 'entry-layout-default' ) ) ); ?> role="article">
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
				 * @hooked suki_entry_header_meta - 10
				 * @hooked suki_entry_title - 20
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

			// If it's included in a single post page.
			if ( is_single() ) {
				// Print the content.
				the_content();

				// Print content pagination, if exists.
				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'suki' ),
					'after'  => '</div>',
				) );
			}
			// If it's included in a posts archive page.
			else {
				if ( 0 < intval( suki_get_theme_mod( 'entry_excerpt_length' ) ) ) {
					// Excerpt
					the_excerpt();

					// Read more
					if ( '' !== suki_get_theme_mod( 'entry_read_more_display' ) ) {
						?>
						<p>
							<a href="<?php echo esc_url( get_the_permalink() ); ?>" class="<?php echo esc_attr( suki_get_theme_mod( 'entry_read_more_display' ) ); ?>">
								<?php
								$text = suki_get_theme_mod( 'entry_read_more_text' );
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
			}
			
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
				 * 
				 * @hooked suki_entry_footer_meta - 10
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
