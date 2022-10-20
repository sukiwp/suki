<?php
/**
 * Global single post (and custom post types) page template.
 *
 * @package Suki
 * @since 2.0.0
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Header template
 */
get_header();

/**
 * Content
 */

ob_start();

the_post();
?>
<!-- wp:group {
	"tagName":"article",
	"className":"entry entry--layout-default"
} --><article class="wp-block-group entry entry--layout-default">

	<?php
	/**
	 * Content header
	 */
	if (
		has_action( 'suki/frontend/' . get_post_type() . '_content/header' ) ||
		( has_post_thumbnail() && in_array( suki_get_current_page_setting( 'content_thumbnail_position' ), array( 'before', 'after' ), true ) )
	) {
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
				"inherit":"true"
			}
		} --><div class="wp-block-group entry-header" style="margin-bottom:calc(1.5 * var(--wp--style--block-gap))">

			<?php
			/**
			 * Featured image (before header)
			 */
			if ( has_post_thumbnail() && 'before' === suki_get_current_page_setting( 'content_thumbnail_position' ) ) {
				?>
				<!-- wp:post-featured-image {
					"align":"<?php echo esc_attr( boolval( suki_get_current_page_setting( 'content_thumbnail_wide' ) ) ? 'wide' : 'none' ); ?>",
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
			 * Hook: suki/frontend/{post_type}_content/header
			 */
			do_action( 'suki/frontend/' . get_post_type() . '_content/header' );

			/**
			 * Featured image (after header)
			 */
			if ( has_post_thumbnail() && 'after' === suki_get_current_page_setting( 'content_thumbnail_position' ) ) {
				?>
				<!-- wp:post-featured-image {
					"align":"<?php echo esc_attr( boolval( suki_get_current_page_setting( 'content_thumbnail_wide' ) ) ? 'wide' : 'none' ); ?>",
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
	 * Content
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
			"inherit":"true"
		}
	} /-->
	<?php

	/**
	 * Content footer
	 */
	if ( has_action( 'suki/frontend/' . get_post_type() . '_content/footer' ) ) {
		?>
		<!-- wp:group {
			"style":{
				"spacing":{
					"margin":{
						"top":"calc(1.5 * var(--wp--style--block-gap))"
					}
				}
			},
			"className":"entry-footer",
			"layout":{
				"inherit":"true"
			}
		} --><div class="wp-block-group entry-footer" style="margin-top:calc(1.5 * var(--wp--style--block-gap))">

			<?php
			/**
			 * Hook: suki/frontend/{post_type}_content/footer
			 */
			do_action( 'suki/frontend/' . get_post_type() . '_content/footer' );
			?>

		</div><!-- /wp:group -->
		<?php
	}
	?>

</article><!-- /wp:group -->
<?php
suki_content( ob_get_clean() );

/**
 * Footer template
 */
get_footer();
