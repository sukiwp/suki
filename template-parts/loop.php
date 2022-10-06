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

// Build thumbnail markup.
$thumbnail_size  = suki_get_theme_mod( 'entry_thumbnail_size', 'full' );
$thumbnail_block = '
<!-- wp:post-featured-image {
	"isLink":true,
	' . ( 'full' !== $thumbnail_size ? '"width":"' . get_option( $thumbnail_size . '_size_w' ) . 'px",' : '' ) . '
	' . ( 'full' !== $thumbnail_size ? '"height":"' . get_option( $thumbnail_size . '_size_h' ) . 'px",' : '' ) . '
	"className":"entry-thumbnail' . ( boolval( suki_get_theme_mod( 'entry_thumbnail_wide' ) ) ? ' alignwide' : '' ) . '"
} /-->
'
?>
<!-- wp:query {
	"query":{
		"inherit":true
	},
	"layout":{
		"inherit":true
	}
} --><div class="wp-block-query">

	<!-- wp:post-template {
		"className":"suki-loop suki-loop-default alignfull"
	} -->

		<!-- wp:group {
			"className":"entry-layout-default",
			"layout":{
				"inherit":true
			}
		} --><div class="wp-block-group entry-layout-default">

			<?php
			/**
			 * Featured image (before header)
			 */
			if ( 'before' === suki_get_theme_mod( 'entry_thumbnail_position' ) ) {
				echo $thumbnail_block; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			/**
			 * Entry header
			 */
			if ( 0 < count( suki_get_theme_mod( 'entry_header', array() ) ) ) {
				?>
				<!-- wp:group {
					"align":"full",
					"className":"entry-header",
					"layout":{
						"inherit":true
					}
				} --><div class="wp-block-group alignfull entry-header">
					<?php
					foreach ( suki_get_theme_mod( 'entry_header' ) as $element ) {
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
				echo $thumbnail_block; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
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
						"align":"full",
						"className":"entry-excerpt",
						"layout":{
							"inherit":true
						}
					} -->
					<div class="wp-block-group alignfull entry-excerpt">
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
					"align":"full",
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
					"align":"full",
					"className":"entry-footer",
					"layout":{
						"inherit":true
					}
				} --><div class="wp-block-group alignfull entry-footer">
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
