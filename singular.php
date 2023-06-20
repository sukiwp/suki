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
 * Canvas
 */

// Build main content.
ob_start();

the_post();

$container = suki_get_current_page_setting( 'content_container' );
if ( suki_current_page_has_sidebar() && 'narrow' === $container ) {
	$container = 'wide';
}

$content_size = '';
if ( 'full' === $container ) {
	$content_size = '100%';
} elseif ( 'wide' === $container ) {
	$content_size = 'var(--wp--style--global--wide-size)';
}

/**
 * Content header
 */
if (
	has_action( 'suki/frontend/' . get_post_type() . '_content/header' ) ||
	( has_post_thumbnail() && in_array( suki_get_current_page_setting( 'content_thumbnail_position' ), array( 'before', 'after' ), true ) )
) {
	?>
	<!-- wp:group {
		"layout":{
			<?php
			if ( suki_current_page_has_sidebar() ) {
				?>
				"type":"default"
				<?php
			} else {
				?>
				"type":"constrained",
				"contentSize":"<?php echo esc_attr( $content_size ); ?>"
				<?php
			}
			?>
		},
		"style":{
			"spacing":{
				"margin":{
					"bottom":"2rem"
				},
				"blockGap":"0.75rem"
			}
		}
	} --><div class="wp-block-group" style="margin-bottom:2rem">

		<?php
		/**
		 * Featured image (before header)
		 */
		if ( has_post_thumbnail() && 'before' === suki_get_current_page_setting( 'content_thumbnail_position' ) ) {
			?>
			<!-- wp:post-featured-image {
				<?php
				if ( ! suki_current_page_has_sidebar() ) {
					?>
					"align":"<?php echo esc_attr( boolval( suki_get_current_page_setting( 'content_thumbnail_wide' ) ) ? 'wide' : 'none' ); ?>",
					<?php
				}
				?>
				"style":{
					"spacing":{
						"margin":{
							"bottom":"2rem"
						}
					}
				}
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
				<?php
				if ( ! suki_current_page_has_sidebar() ) {
					?>
					"align":"<?php echo esc_attr( boolval( suki_get_current_page_setting( 'content_thumbnail_wide' ) ) ? 'wide' : 'none' ); ?>",
					<?php
				}
				?>
				"style":{
					"spacing":{
						"margin":{
							"top":"2rem"
						}
					}
				}
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
	"layout":{
		<?php
		if ( suki_current_page_has_sidebar() ) {
			?>
			"type":"default"
			<?php
		} else {
			?>
			"type":"constrained",
			"contentSize":"<?php echo esc_attr( $content_size ); ?>"
			<?php
		}
		?>
	},
	"style":{
		"spacing":{
			"margin":{
				"top":"2rem",
				"bottom":"2rem"
			}
		}
	}
} /-->
<?php

/**
 * Content footer
 */
if ( has_action( 'suki/frontend/' . get_post_type() . '_content/footer' ) ) {
	?>
	<!-- wp:group {
		"layout":{
			<?php
			if ( suki_current_page_has_sidebar() ) {
				?>
				"type":"default"
				<?php
			} else {
				?>
				"type":"constrained",
				"contentSize":"<?php echo esc_attr( $content_size ); ?>"
				<?php
			}
			?>
		},
		"style":{
			"spacing":{
				"margin":{
					"top":"2rem"
				},
				"blockGap":"0.75rem"
			}
		}
	} --><div class="wp-block-group" style="margin-top:2rem">

		<?php
		/**
		 * Hook: suki/frontend/{post_type}_content/footer
		 */
		do_action( 'suki/frontend/' . get_post_type() . '_content/footer' );
		?>

	</div><!-- /wp:group -->
	<?php
}

$main_content = ob_get_clean();

// Render Canvas.
suki_canvas(
	// Get Content section.
	suki_content( $main_content, '', false, false )
);

/**
 * Footer template
 */
get_footer();
