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

$thumbnail_position = suki_get_current_page_setting( 'content_thumbnail_position' );
?>
<!-- wp:group {
	"className":"entry entry-layout-default",
} --><div class="wp-block-group entry entry-layout-default">

	<?php
	/**
	 * Featured image (before header)
	 */
	if ( 'before' === $thumbnail_position ) {
		suki_content_thumbnail();
	}

	/**
	 * Content header
	 */

	if ( has_action( 'suki/frontend/' . get_post_type() . '_content/header' ) ) {
		?>
		<!-- wp:group {
			"className":"entry-header",
			"layout":{
				"inherit":"true"
			}
		} --><div class="wp-block-group entry-header">

			<?php
			/**
			 * Hook: suki/frontend/{post_type}_content/header
			 */
			do_action( 'suki/frontend/' . get_post_type() . '_content/header' );
			?>

		</div><!-- /wp:group -->
		<?php
	}

	/**
	 * Content
	 */
	?>
	<!-- wp:post-content {
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
			"className":"entry-footer",
			"layout":{
				"inherit":"true"
			}
		} --><div class="wp-block-group entry-footer">

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

</div><!-- /wp:group -->
<?php
suki_content( ob_get_clean() );

/**
 * Footer template
 */
get_footer();
