<?php
/**
 * Posts Query: Default Layout
 *
 * @package Suki
 */

ob_start();

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
	"align":"full",
	"className":"suki-loop suki-loop-default",
	"layout":{
		"inherit":true
	}
} --><div class="wp-block-query alignfull suki-loop suki-loop-default">

	<!-- wp:post-template {
		"className":"alignfull"
	} -->

		<!-- wp:group {
			"align":"full",
			"style":{
				"spacing":{
					"blockGap":"calc(1.5 * var(--wp--style--block-gap))"
				}
			},
			"layout":{
				"inherit":true
			}
		} --><div class="wp-block-group alignfull">

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
					"style":{
						"spacing":{
							"blockGap":"calc( 0.5 * var(--wp--style--block-gap) )"
						}
					},
					"layout":{
						"inherit":true
					}
				} --><div class="wp-block-group alignfull entry-header">
					<?php
					foreach ( suki_get_theme_mod( 'entry_header' ) as $element ) {
						suki_entry_header_footer_element( $element, 'default', suki_get_theme_mod( 'entry_header_alignment', 'left' ), true, false );
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
					"style":{
						"spacing":{
							"blockGap":"calc( 0.5 * var(--wp--style--block-gap) )"
						}
					},
					"layout":{
						"inherit":true
					}
				} --><div class="wp-block-group alignfull entry-footer">
					<?php
					foreach ( suki_get_theme_mod( 'entry_footer' ) as $element ) {
						suki_entry_header_footer_element( $element, 'default', suki_get_theme_mod( 'entry_footer_alignment', 'left' ), true, false );
					}
					?>
				</div><!-- /wp:group -->
				<?php
			}
			?>

		</div><!-- /wp:group -->

	<!-- /wp:post-template -->

	<!-- wp:pattern {
		"slug":"suki/query-pagination--<?php echo esc_attr( suki_get_theme_mod( 'post_archive_pagination_layout' ) ); ?>"
	} /-->

</div><!-- /wp:query -->
<?php
$content = ob_get_clean();

return array(
	'title'      => esc_html__( 'Posts Query: Default Layout', 'suki' ),
	'categories' => array( 'query' ),
	'blockTypes' => array( 'core/query' ),
	'content'    => $content,
);
