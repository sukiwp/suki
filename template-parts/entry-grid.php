<?php
/**
 * Grid post entry template.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<article class="<?php suki_post_class( array( 'wp-block-post', 'entry', 'entry-layout-grid', 'entry-small' ) ); ?>">
	<?php
	/**
	 * Hook: suki/frontend/entry_grid/before_header
	 */
	do_action( 'suki/frontend/entry_grid/before_header' );

	if ( has_action( 'suki/frontend/entry_grid/header' ) ) {
		?>
		<header class="entry-header <?php echo esc_attr( 'has-text-align-' . suki_get_theme_mod( 'entry_header_alignment' ) ); ?>">
			<?php
			/**
			 * Hook: suki/frontend/entry_grid/header
			 */
			do_action( 'suki/frontend/entry_grid/header' );
			?>
		</header>
		<?php
	}

	/**
	 * Hook: suki/frontend/entry_grid/after_header
	 */
	do_action( 'suki/frontend/entry_grid/after_header' );

	/**
	 * Main content - excerpt
	 */
	if ( 0 < intval( suki_get_theme_mod( 'entry_excerpt_length' ) ) ) {
		echo do_blocks( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			'
			<!-- wp:post-excerpt {
				"moreText":"' . esc_js( suki_get_theme_mod( 'entry_grid_read_more_text' ) ) . '"
			} /-->
			'
		);
	}

	/**
	 * Hook: suki/frontend/entry_grid/before_footer
	 */
	do_action( 'suki/frontend/entry_grid/before_footer' );

	if ( has_action( 'suki/frontend/entry_grid/footer' ) ) {
		?>
		<footer class="entry-footer <?php echo esc_attr( 'has-text-align-' . suki_get_theme_mod( 'entry_footer_alignment' ) ); ?>">
			<?php
			/**
			 * Hook: suki/frontend/entry_grid/footer
			 */
			do_action( 'suki/frontend/entry_grid/footer' );
			?>
		</footer>
		<?php
	}

	/**
	 * Hook: suki/frontend/entry_grid/after_footer
	 */
	do_action( 'suki/frontend/entry_grid/after_footer' );
	?>
</article>
