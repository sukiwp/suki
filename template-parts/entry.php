<?php
/**
 * Default entry template.
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
	 * Hook: suki/frontend/entry/before_header
	 */
	do_action( 'suki/frontend/entry/before_header' );

	if ( has_action( 'suki/frontend/entry/header' ) ) {
		?>
		<header class="entry-header suki-block-container <?php echo esc_attr( 'has-text-align-' . suki_get_theme_mod( 'entry_header_alignment' ) ); ?>">
			<?php
			/**
			 * Hook: suki/frontend/entry/header
			 */
			do_action( 'suki/frontend/entry/header' );
			?>
		</header>
		<?php
	}

	/**
	 * Hook: suki/frontend/entry/after_header
	 */
	do_action( 'suki/frontend/entry/after_header' );

	/**
	 * Main content
	 */
	if ( 'excerpt' === suki_get_theme_mod( 'entry_content' ) ) {
		/**
		 * Main content - excerpt
		 */
		if ( 0 < intval( suki_get_theme_mod( 'entry_excerpt_length' ) ) ) {
			echo do_blocks( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				'
				<!-- wp:post-excerpt {
					"moreText":"' . esc_js( suki_get_theme_mod( 'entry_read_more_text' ) ) . '"
				} /-->
				'
			);
		}
	} else {
		/**
		 * Main content - full content
		 */
		echo do_blocks( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			'
			<!-- wp:post-content {
				"layout":{
					"inherit":true
				}
			} /-->
			'
		);
	}

	/**
	 * Hook: suki/frontend/entry/before_footer
	 */
	do_action( 'suki/frontend/entry/before_footer' );

	if ( has_action( 'suki/frontend/entry/footer' ) ) {
		?>
		<footer class="entry-footer suki-block-container <?php echo esc_attr( 'has-text-align-' . suki_get_theme_mod( 'entry_footer_alignment' ) ); ?>">
			<?php
			/**
			 * Hook: suki/frontend/entry/footer
			 */
			do_action( 'suki/frontend/entry/footer' );
			?>
		</footer>
		<?php
	}

	/**
	 * Hook: suki/frontend/entry/after_footer
	 */
	do_action( 'suki/frontend/entry/after_footer' );
	?>
</article>
