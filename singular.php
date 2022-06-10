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
 * Hero
 */
suki_hero();

/**
 * Content
 */

// Initiate the post early, so hero section can use post meta data.
the_post();

ob_start();
?>
<!-- wp:group {
	"tagName":"article",
	"align":"full",
	"style":{
		"spacing":{
			"blockGap":"calc(1.5 * var(--wp--style--block-gap))"
		}
	},
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
	 * Content header
	 */
	if (
		! boolval( suki_get_current_page_setting( 'disable_content_header' ) ) &&
		! boolval( suki_get_current_page_setting( 'hero' ) ) &&
		( ! is_home() || boolval( suki_get_theme_mod( 'post_archive_home_content_header' ) ) ) &&
		0 < count( suki_get_current_page_setting( 'content_header', array() ) )
	) {
		?>
		<!-- wp:group {
			"className":"entry-header suki-content-header",
			"style":{
				"spacing":{
					"blockGap":"0.75rem"
				}
			}
		} --><div class="wp-block-group entry-header suki-content-header">

			<?php
			foreach ( suki_get_current_page_setting( 'content_header', array() ) as $element ) {
				suki_content_header_element( $element, suki_get_current_page_setting( 'content_header_alignment' ), true, false );
			}
			?>

		</div><!-- /wp:group -->
		<?php
	}

	/**
	 * Hook: suki/frontend/{post_type}_content/after_header
	 *
	 * @see suki_singular_thumbnail() [10]
	 */
	do_action( 'suki/frontend/' . get_post_type() . '_content/after_header' );
	?>

	<!-- wp:post-content {
		"className":"entry-content"
	} /-->

	<?php
	/**
	 * Hook: suki/frontend/{post_type}_content/before_footer
	 */
	do_action( 'suki/frontend/' . get_post_type() . '_content/before_footer' );

	/**
	 * Content footer
	 */
	if ( 0 < count( suki_get_current_page_setting( 'content_footer', array() ) ) ) {
		?>
		<!-- wp:group {
			"className":"entry-footer suki-content-footer",
			"style":{
				"spacing":{
					"blockGap":"0.75rem"
				}
			}
		} --><div class="wp-block-group entry-footer suki-content-footer">

			<?php
			foreach ( suki_get_current_page_setting( 'content_footer', array() ) as $element ) {
				suki_content_footer_element( $element, suki_get_current_page_setting( 'content_footer_alignment' ), true, false );
			}
			?>

		</div><!-- /wp:group -->  
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
