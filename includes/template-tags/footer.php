<?php
/**
 * Footer section template rendering functions.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Scroll to top
 */
if ( ! function_exists( 'suki_scroll_to_top' ) ) {
	/**
	 * Render scroll to top.
	 *
	 * @param boolean $echo      Render or return.
	 * @param boolean $do_blocks Parse blocks or not.
	 * @return string
	 */
	function suki_scroll_to_top( $echo = true, $do_blocks = true ) {
		if ( ! boolval( suki_get_theme_mod( 'scroll_to_top' ) ) ) {
			return;
		}

		ob_start();
		?>
		<a href="#page" class="<?php echo esc_attr( implode( ' ', apply_filters( 'suki/frontend/scroll_to_top_classes', array( 'suki-scroll-to-top' ) ) ) ); ?>">
			<?php suki_icon( 'chevron-up' ); ?>
			<span class="screen-reader-text"><?php esc_html_e( 'Back to Top', 'suki' ); ?></span>
		</a>
		<?php
		$html = ob_get_clean();

		/**
		 * Result
		 */

		// Parse blocks.
		if ( boolval( $do_blocks ) ) {
			$html = do_blocks( $html );
		}

		// Render or return.
		if ( boolval( $echo ) ) {
			echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		} else {
			return $html;
		}
	}
}
