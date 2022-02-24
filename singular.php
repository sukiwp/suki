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
 * Content wrapper template -- Open
 */
suki_content_open();

/**
 * Hook: suki/frontend/before_main
 */
do_action( 'suki/frontend/before_main' );

/**
 * Main content article
 */
?>
<article class="<?php suki_post_class( array( 'suki-block-container', 'entry', 'entry-layout-default' ) ); ?>">
	<?php
	/**
	 * Hook: suki/frontend/{post_type}_content/before_header
	 *
	 * @see suki_singular_thumbnail() [10]
	 */
	do_action( 'suki/frontend/' . get_post_type() . '_content/before_header' );

	/**
	 * Content header
	 */
	if ( has_action( 'suki/frontend/' . get_post_type() . '_content/header' ) ) {
		?>
		<header class="entry-header suki-content-header suki-block-container <?php echo esc_attr( 'has-text-align-' . suki_get_current_page_setting( 'content_header_alignment' ) ); ?>">
			<?php
			/**
			 * Hook: suki/frontend/{post_type}_content/header
			 *
			 * @see suki_singular_title()       [10]
			 * @see suki_singular_header_meta() [10]
			 * @see suki_breadcrumb()           [10]
			 */
			do_action( 'suki/frontend/' . get_post_type() . '_content/header' );
			?>
		</header>
		<?php
	}

	/**
	 * Hook: suki/frontend/{post_type}_content/after_header
	 *
	 * @see suki_singular_thumbnail() [10]
	 */
	do_action( 'suki/frontend/' . get_post_type() . '_content/after_header' );

	/**
	 * Main content
	 */
	echo do_blocks( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		'
		<!-- wp:post-content {
			"className":"entry-content suki-block-container"
		} /-->
		'
	);

	/**
	 * Hook: suki/frontend/{post_type}_content/before_footer
	 */
	do_action( 'suki/frontend/' . get_post_type() . '_content/before_footer' );

	/**
	 * Content footer
	 */
	if ( has_action( 'suki/frontend/' . get_post_type() . '_content/footer' ) ) {
		?>
		<footer class="entry-footer suki-block-container <?php echo esc_attr( 'has-text-align-' . suki_get_current_page_setting( 'content_footer_alignment' ) ); ?>">
			<?php
			/**
			 * Hook: suki/frontend/{post_type}_content/footer
			 *
			 * @see suki_singular_footer_meta() [10]
			 * @see suki_singular_tags()        [10]
			 */
			do_action( 'suki/frontend/' . get_post_type() . '_content/footer' );
			?>
		</footer>
		<?php
	}

	/**
	 * Hook: suki/frontend/{post_type}_content/after_footer
	 */
	do_action( 'suki/frontend/' . get_post_type() . '_content/after_footer' );
	?>
</article>
<?php

/**
 * Hook: suki/frontend/after_main
 */
do_action( 'suki/frontend/after_main' );

/**
 * Content wrapper template -- Close
 */
suki_content_close();

/**
 * Footer template
 */
get_footer();
