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
		"style":{
			"spacing":{
				"blockGap":"6em"
			}
		},
		"className":"suki-loop suki-loop--layout-default"
	} -->

		<!-- wp:group {
			"tagName":"article",
			"className":"entry entry--layout-default"
		} --><article class="wp-block-group entry entry--layout-default">

			<?php
			/**
			 * Entry header
			 */
			if ( 0 < count( suki_get_theme_mod( 'entry_header', array() ) ) || in_array( suki_get_theme_mod( 'entry_thumbnail_position' ), array( 'before', 'after' ), true ) ) {
				?>
				<!-- wp:group {
					"style":{
						"spacing":{
							"margin":{
								"bottom":"calc(1.5 * var(--wp--style--block-gap))"
							}
						}
					},
					"className":"entry-header",
					"layout":{
						"inherit":true
					}
				} --><div class="wp-block-group entry-header" style="margin-bottom:calc(1.5 * var(--wp--style--block-gap))">

					<?php
					/**
					 * Featured image (before content header)
					 */
					if ( 'before' === suki_get_theme_mod( 'entry_thumbnail_position' ) ) {
						?>
						<!-- wp:post-featured-image {
							"align":"<?php echo esc_attr( boolval( suki_get_theme_mod( 'entry_thumbnail_wide' ) ) ? 'wide' : 'none' ); ?>",
							"isLink":true,
							"style":{
								"spacing":{
									"margin":{
										"bottom":"calc(1.5 * var(--wp--style--block-gap))"
									}
								}
							},
							"className":"entry-thumbnail"
						} /-->
						<?php
					}

					/**
					 * Content Header
					 */
					foreach ( suki_get_theme_mod( 'entry_header', array() ) as $element ) {
						suki_entry_header_footer_element( $element, 'default', suki_get_theme_mod( 'entry_header_alignment', 'left' ), false );
					}

					/**
					 * Featured image (after content header)
					 */
					if ( 'after' === suki_get_theme_mod( 'entry_thumbnail_position' ) ) {
						?>
						<!-- wp:post-featured-image {
							"align":"<?php echo esc_attr( boolval( suki_get_theme_mod( 'entry_thumbnail_wide' ) ) ? 'wide' : 'none' ); ?>",
							"isLink":true,
							"style":{
								"spacing":{
									"margin":{
										"top":"calc(1.5 * var(--wp--style--block-gap))"
									}
								}
							},
							"className":"entry-thumbnail"
						} /-->
						<?php
					}
					?>

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
						"style":{
							"spacing":{
								"margin":{
									"top":"calc(1.5 * var(--wp--style--block-gap))",
									"bottom":"calc(1.5 * var(--wp--style--block-gap))"
								}
							}
						},
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
					"style":{
						"spacing":{
							"margin":{
								"top":"calc(1.5 * var(--wp--style--block-gap))",
								"bottom":"calc(1.5 * var(--wp--style--block-gap))"
							}
						}
					},
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
					"style":{
						"spacing":{
							"margin":{
								"top":"calc(1.5 * var(--wp--style--block-gap))"
							}
						}
					},
					"className":"entry-footer suki-content-footer",
					"layout":{
						"inherit":true
					}
				} --><div class="wp-block-group entry-footer" style="margin-top:calc(1.5 * var(--wp--style--block-gap))">

					<?php
					foreach ( suki_get_theme_mod( 'entry_footer' ) as $element ) {
						suki_entry_header_footer_element( $element, 'default', suki_get_theme_mod( 'entry_footer_alignment', 'left' ), false );
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
