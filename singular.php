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

$thumbnail_block = '
<!-- wp:post-featured-image {
	' . ( boolval( suki_get_current_page_setting( 'content_thumbnail_wide' ) ) ? '"align":"wide",' : '' ) . '
	"className":"entry-thumbnail"
} /-->
';
?>
<!-- wp:group {
	"tagName":"article",
	"className":"entry entry-layout-default",
	"layout":{
		"inherit":true
	}
} --><article class="wp-block-group entry entry-layout-default">

	<?php
	/**
	 * Hook: suki/frontend/{post_type}_content/before_header
	 */
	do_action( 'suki/frontend/' . get_post_type() . '_content/before_header' );

	/**
	 * Featured image (before header)
	 */
	if ( 'before' === suki_get_theme_mod( 'entry_thumbnail_position' ) ) {
		echo $thumbnail_block; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Content header
	 */
	if ( has_action( 'suki/frontend/' . get_post_type() . '_content/header' ) ) {
		?>
		<!-- wp:group {
			"tagName":"header",
			"className":"entry-header suki-content-header",
			"layout":{
				"inherit":"true"
			}
		} --><header class="wp-block-group entry-header suki-content-header">

			<?php
			/**
			 * Hook: suki/frontend/{post_type}_content/header
			 */
			do_action( 'suki/frontend/' . get_post_type() . '_content/header' );
			?>

		</header><!-- /wp:group -->
		<?php
	}

	/**
	 * Featured image (after header)
	 */
	if ( 'after' === suki_get_theme_mod( 'entry_thumbnail_position' ) ) {
		echo $thumbnail_block; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Hook: suki/frontend/{post_type}_content/after_header
	 */
	do_action( 'suki/frontend/' . get_post_type() . '_content/after_header' );
	?>

	<!-- wp:post-content {
		"layout":{
			"inherit":"true"
		}
	} /-->

	<?php
	if ( 'before' === suki_get_current_page_setting( 'thumbnail_position' ) ) {
		?>
		<!-- wp:post-featured-image {
			' . ( boolval( suki_get_current_page_setting( 'content_thumbnail_wide' ) ) ? '"align":"wide",' : '' ) . '
			"className":"entry-thumbnail"
		} /-->
		<?php
	}

	/**
	 * Hook: suki/frontend/{post_type}_content/before_footer
	 */
	do_action( 'suki/frontend/' . get_post_type() . '_content/before_footer' );

	/**
	 * Content footer
	 */
	if ( has_action( 'suki/frontend/' . get_post_type() . '_content/footer' ) ) {
		?>
		<!-- wp:group {
			"tagName":"footer",
			"className":"entry-footer suki-content-footer",
			"layout":{
				"inherit":"true"
			}
		} --><footer class="wp-block-group entry-footer suki-content-footer">

			<?php
			/**
			 * Hook: suki/frontend/{post_type}_content/footer
			 */
			do_action( 'suki/frontend/' . get_post_type() . '_content/footer' );
			?>

		</footer><!-- /wp:group -->
		<?php
	}

	/**
	 * Hook: suki/frontend/{post_type}_content/after_footer
	 */
	do_action( 'suki/frontend/' . get_post_type() . '_content/after_footer' );
	?>

</article><!-- /wp:group -->
<?php
suki_content( ob_get_clean() );

/**
 * Footer template
 */
get_footer();
