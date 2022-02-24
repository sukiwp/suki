<?php
/**
 * Search results entry template.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<article class="<?php suki_post_class( array( 'wp-block-post', 'entry', 'entry-layout-default' ) ); ?>">
	<?php
	/**
	 * Hook: suki/frontend/entry_search/before_header
	 */
	do_action( 'suki/frontend/entry_search/before_header' );

	if ( has_action( 'suki/frontend/entry_search/header' ) ) {
		?>
		<header class="entry-header">
			<?php
			/**
			 * Hook: suki/frontend/entry_search/header
			 */
			do_action( 'suki/frontend/entry_search/header' );
			?>
		</header>
		<?php
	}

	/**
	 * Hook: suki/frontend/entry_search/after_header
	 */
	do_action( 'suki/frontend/entry_search/after_header' );

	/**
	 * Main content - excerpt
	 */
	echo do_blocks( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		'
		<!-- wp:post-excerpt {
			"moreText":"' . esc_js( suki_get_theme_mod( 'entry_grid_read_more_text' ) ) . '"
		} /-->
		'
	);

	/**
	 * Hook: suki/frontend/entry_search/before_footer
	 */
	do_action( 'suki/frontend/entry_search/before_footer' );

	if ( has_action( 'suki/frontend/entry_search/footer' ) ) {
		?>
		<footer class="entry-footer">
			<?php
			/**
			 * Hook: suki/frontend/entry_search/footer
			 */
			do_action( 'suki/frontend/entry_search/footer' );
			?>
		</footer>
		<?php
	}

	/**
	 * Hook: suki/frontend/entry_search/after_footer
	 */
	do_action( 'suki/frontend/entry_search/after_footer' );
	?>
</article>
