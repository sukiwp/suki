<?php
/**
 * Template: Loop grid
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Build thumbnail markup.
$thumbnail_size  = suki_get_theme_mod( 'entry_grid_thumbnail_size', 'full' );
$thumbnail_block = '
<!-- wp:post-featured-image {
	"isLink":true,
	' . ( 'full' !== $thumbnail_size ? '"width":' . get_option( $thumbnail_size . '_size_w' ) . ',' : '' ) . '
	' . ( 'full' !== $thumbnail_size ? '"height":' . get_option( $thumbnail_size . '_size_h' ) . ',' : '' ) . '
	"className":"entry-thumbnail' . ( boolval( suki_get_theme_mod( 'entry_grid_thumbnail_ignore_padding' ) ) ? ' suki-ignore-padding' : '' ) . '"
} /-->
';
?>
<!-- wp:query {
	"query":{
		"inherit":true
	},
	"displayLayout":{
		"type":"flex",
		"columns":<?php echo esc_attr( suki_get_theme_mod( 'blog_index_grid_columns' ) ); ?>
	},
	"align":"full",
	"layout":{
		"inherit":true
	}
} --><div class="wp-block-query">

	<!-- wp:post-template {
		"className":"suki-loop suki-loop-grid"
	} -->

		<!-- wp:group --><div class="wp-block-group">

			<?php
			/**
			 * Featured image (before header)
			 */
			if ( 'before' === suki_get_theme_mod( 'entry_grid_thumbnail_position' ) ) {
				echo $thumbnail_block; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			/**
			 * Entry header
			 */
			if ( 0 < count( suki_get_theme_mod( 'entry_grid_header', array() ) ) ) {
				?>
				<!-- wp:group {
					"className":"entry-header"
				} --><div class="wp-block-group entry-header">
					<?php
					foreach ( suki_get_theme_mod( 'entry_grid_header' ) as $element ) {
						suki_entry_header_footer_element( $element, 'grid', suki_get_theme_mod( 'entry_grid_header_alignment', 'left' ), false );
					}
					?>
				</div><!-- /wp:group -->
				<?php
			}

			/**
			 * Featured image (after header)
			 */
			if ( 'after' === suki_get_theme_mod( 'entry_grid_thumbnail_position' ) ) {
				echo $thumbnail_block; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			/**
			 * Main content - excerpt
			 */
			if ( 0 < intval( suki_get_theme_mod( 'entry_grid_excerpt_length' ) ) ) {
				?>
				<!-- wp:post-excerpt {
					"moreText":"<?php echo esc_attr( suki_get_theme_mod( 'entry_grid_read_more_text' ) ); ?>"
				} /-->
				<?php
			}

			/**
			 * Entry footer
			 */
			if ( 0 < count( suki_get_theme_mod( 'entry_grid_footer', array() ) ) ) {
				?>
				<!-- wp:group {
					"className":"entry-footer"
				} --><div class="wp-block-group entry-footer">
					<?php
					foreach ( suki_get_theme_mod( 'entry_grid_footer' ) as $element ) {
						suki_entry_header_footer_element( $element, 'grid', suki_get_theme_mod( 'entry_grid_footer_alignment', 'left' ), false );
					}
					?>
				</div><!-- /wp:group -->
				<?php
			}
			?>

		</div><!-- /wp:group -->

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
