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

// Initiate the post early, so hero section can use post meta data.
the_post();

/**
 * Hero
 */
suki_hero();

/**
 * Content
 */

ob_start();

$thumbnail_block = '
<!-- wp:post-featured-image {
	' . ( boolval( suki_get_current_page_setting( 'content_thumbnail_wide' ) ) ? '"align":"wide",' : '' ) . '
	"className":"entry-thumbnail"
} /-->
';
?>
<!-- wp:group {
	"tagName":"article",
	"align":"full",
	"className":"entry entry-layout-default",
	"layout":{
		"inherit":true
	}
} --><article class="wp-block-group alignfull entry entry-layout-default">

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
	suki_content_header();

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
		"className":"entry-content"
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
	suki_content_footer();

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
