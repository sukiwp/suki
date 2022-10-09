<?php
/**
 * Template: Loop default
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
	}
} --><div class="wp-block-query">

	<!-- wp:post-template {
		"className":"suki-loop suki-loop-default"
	} -->

		<!-- wp:group {
			"className":"entry-layout-default"
		} --><div class="wp-block-group entry-layout-default">

			<?php
			/**
			 * Featured image (before header)
			 */
			if ( 'before' === suki_get_theme_mod( 'entry_thumbnail_position' ) ) {
				?>
				<!-- wp:group {
					"className":"entry-thumbnail",
					"layout":{
						"inherit":true
					}
				} --><div class="wp-block-group entry-thumbnail">

					<!-- wp:post-featured-image {
						"align":"<?php echo esc_attr( boolval( suki_get_theme_mod( 'entry_thumbnail_wide' ) ) ? 'wide' : 'none' ); ?>",
						"isLink":true
					} /-->

				</div><!-- /wp:group -->
				<?php
			}

			/**
			 * Entry header
			 */
			if ( 0 < count( suki_get_theme_mod( 'entry_footer', array() ) ) ) {
				?>
				<!-- wp:group {
					"className":"entry-header",
					"layout":{
						"inherit":true
					}
				} --><div class="wp-block-group entry-header">

					<?php
					foreach ( suki_get_theme_mod( 'entry_header', array() ) as $element ) {
						suki_entry_header_footer_element( $element, 'default', suki_get_theme_mod( 'entry_header_alignment', 'left' ), false );
					}
					?>

				</div><!-- /wp:group -->
				<?php
			}

			/**
			 * Featured image (after header)
			 */
			if ( 'after' === suki_get_theme_mod( 'entry_thumbnail_position' ) ) {
				?>
				<!-- wp:group {
					"className":"entry-thumbnail",
					"layout":{
						"inherit":true
					}
				} --><div class="wp-block-group entry-thumbnail">

					<!-- wp:post-featured-image {
						"align":"<?php echo esc_attr( boolval( suki_get_theme_mod( 'entry_thumbnail_wide' ) ) ? 'wide' : 'none' ); ?>",
						"isLink":true
					} /-->

				</div><!-- /wp:group -->
				<?php
			}

			/**
			 * Main content
			 */
			if ( 'excerpt' === suki_get_theme_mod( 'entry_content' ) ) {
				/**
				 * Main content - excerpt
				 */
				if ( 0 < intval( suki_get_theme_mod( 'entry_excerpt_length' ) ) ) {
					?>
					<!-- wp:group {
						"className":"entry-excerpt",
						"layout":{
							"inherit":true
						}
					} -->
					<div class="wp-block-group entry-excerpt">
						<!-- wp:post-excerpt {
							"moreText":"<?php echo esc_attr( suki_get_theme_mod( 'entry_read_more_text' ) ); ?>"
						} /-->
					</div><!-- /wp:group -->
					<?php
				}
			} else {
				/**
				 * Main content - full content
				 */
				?>
				<!-- wp:post-content {
					"layout":{
						"inherit":true
					}
				} /-->
				<?php
			}

			/**
			 * Entry footer
			 */
			if ( 0 < count( suki_get_theme_mod( 'entry_footer', array() ) ) ) {
				?>
				<!-- wp:group {
					"className":"entry-footer",
					"layout":{
						"inherit":true
					}
				} --><div class="wp-block-group entry-footer">

					<?php
					foreach ( suki_get_theme_mod( 'entry_footer' ) as $element ) {
						suki_entry_header_footer_element( $element, 'default', suki_get_theme_mod( 'entry_footer_alignment', 'left' ), false );
					}
					?>

				</div><!-- /wp:group -->
				<?php
			}
			?>

		</div><!-- /wp:group -->

		<!-- wp:spacer {
			"height":"<?php echo esc_attr( suki_get_theme_mod( 'blog_index_default_items_gap', '5em' ) ); ?>",
			"className":"suki-loop-default__spacer"
		} --><div style="height:<?php echo esc_attr( suki_get_theme_mod( 'blog_index_default_items_gap', '5em' ) ); ?>" aria-hidden="true" class="wp-block-spacer suki-loop-default__spacer"></div><!-- /wp:spacer -->

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
