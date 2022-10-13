<?php
/**
 * Template: Loop grid
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<!-- wp:query {
	"query":{
		"inherit":true
	},
	"displayLayout":{
		"type":"flex",
		"columns":<?php echo esc_attr( suki_get_theme_mod( 'blog_index_grid_columns' ) ); ?>
	},
	"layout":{
		"inherit":true
	}
} --><div class="wp-block-query">

	<!-- wp:post-template {
		"className":"suki-loop suki-loop--layout-grid"
	} -->

		<!-- wp:group {
			"tagName":"article",
			"className":"entry entry--layout-grid"
		} --><article class="wp-block-group entry entry--layout-grid">

			<?php
			/**
			 * Entry header
			 */
			if ( 0 < count( suki_get_theme_mod( 'entry_grid_header', array() ) ) || in_array( suki_get_theme_mod( 'entry_grid_thumbnail_position' ), array( 'before', 'after' ), true ) ) {
				?>
				<!-- wp:group {
					"className":"entry-header"
				} --><div class="wp-block-group entry-header">

					<?php
					/**
					 * Featured image (before entry header)
					 */
					if ( 'before' === suki_get_theme_mod( 'entry_grid_thumbnail_position' ) ) {
						?>
						<!-- wp:post-featured-image {
							"isLink":true,
							"style":{
								"spacing":{
									"margin":{
										"bottom":"var(--wp--style--block-gap)"
									}
								}
							},
							"className":"entry-thumbnail <?php echo esc_attr( boolval( suki_get_theme_mod( 'entry_grid_thumbnail_ignore_padding' ) ) ? 'suki-ignore-padding' : '' ); ?>"
						} /-->
						<?php
					}

					/**
					 * Entry headaer
					 */
					foreach ( suki_get_theme_mod( 'entry_grid_header' ) as $element ) {
						suki_entry_header_footer_element( $element, 'grid', suki_get_theme_mod( 'entry_grid_header_alignment', 'left' ), false );
					}

					/**
					 * Featured image (after entry header)
					 */
					if ( 'after' === suki_get_theme_mod( 'entry_grid_thumbnail_position' ) ) {
						?>
						<!-- wp:post-featured-image {
							"isLink":true,
							"style":{
								"spacing":{
									"margin":{
										"top":"var(--wp--style--block-gap)"
									}
								}
							},
							"className":"entry-thumbnail <?php echo esc_attr( boolval( suki_get_theme_mod( 'entry_grid_thumbnail_ignore_padding' ) ) ? 'suki-ignore-padding' : '' ); ?>"
						} /-->
						<?php
					}
					?>

				</div><!-- /wp:group -->
				<?php
			}

			/**
			 * Main content - excerpt
			 */
			if ( 0 < intval( suki_get_theme_mod( 'entry_grid_excerpt_length' ) ) ) {
				?>
				<!-- wp:post-excerpt {
					"moreText":"<?php echo esc_attr( suki_get_theme_mod( 'entry_grid_read_more_text' ) ); ?>"
				} /-->
				<?php
			}

			/**
			 * Entry footer
			 */
			if ( 0 < count( suki_get_theme_mod( 'entry_grid_footer', array() ) ) ) {
				?>
				<!-- wp:group {
					"className":"entry-footer"
				} --><div class="wp-block-group entry-footer">

					<?php
					foreach ( suki_get_theme_mod( 'entry_grid_footer' ) as $element ) {
						suki_entry_header_footer_element( $element, 'grid', suki_get_theme_mod( 'entry_grid_footer_alignment', 'left' ), false );
					}
					?>

				</div><!-- /wp:group -->
				<?php
			}
			?>

		</article><!-- /wp:group -->

	<!-- /wp:post-template -->

	<?php
	/**
	 * Pagination
	 */
	suki_loop_navigation( suki_get_theme_mod( 'post_archive_pagination_layout' ), false );
	?>

	<!-- wp:query-no-results -->
		<!-- wp:paragraph -->
		<p><?php esc_html_e( 'Nothing found.', 'suki' ); ?></p>
		<!-- /wp:paragraph -->
	<!-- /wp:query-no-results -->

</div><!-- /wp:query -->
