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

?>
<!-- wp:query {
	"query":{
		"inherit":true
	},
	"displayLayout":{
		"type":"flex",
		"columns":<?php echo esc_attr( suki_get_theme_mod( 'blog_index_grid_columns' ) ); ?>
	},
	"layout":{
		"inherit":true
	}
} --><div class="wp-block-query">

	<!-- wp:post-template {
		"className":"suki-loop suki-loop--layout-grid"
	} -->

		<!-- wp:group --><div class="wp-block-group">

			<?php
			/**
			 * Featured image (before header)
			 */
			if ( 'before' === suki_get_theme_mod( 'entry_grid_thumbnail_position' ) ) {
				?>
				<!-- wp:post-featured-image {
					"isLink":true,
					"className":"entry-thumbnail <?php echo esc_attr( boolval( suki_get_theme_mod( 'entry_grid_thumbnail_ignore_padding' ) ) ? 'suki-ignore-padding' : '' ); ?>"
				} /-->
				<?php
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
				?>
				<!-- wp:post-featured-image {
					"isLink":true,
					"className":"entry-thumbnail <?php echo esc_attr( boolval( suki_get_theme_mod( 'entry_grid_thumbnail_ignore_padding' ) ) ? 'suki-ignore-padding' : '' ); ?>"
				} /-->
				<?php
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
