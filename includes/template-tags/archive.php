<?php
/**
 * Archive pages template rendering functions.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Loop
 */
if ( ! function_exists( 'suki_loop' ) ) {
	/**
	 * Render posts loop.
	 *
	 * @since 2.0.0
	 *
	 * @param string  $layout    Loop layout.
	 * @param boolean $do_blocks Parse blocks or not.
	 * @param boolean $echo      Render or return.
	 * @return string
	 */
	function suki_loop( $layout = 'default', $do_blocks = true, $echo = true ) {
		ob_start();
		suki_get_template_part( 'loop', $layout );
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

/**
 * Loop navigation
 */
if ( ! function_exists( 'suki_loop_navigation' ) ) {
	/**
	 * Render posts loop navigation.
	 *
	 * @since 2.0.0
	 *
	 * @param string  $mode      Navigation mode.
	 * @param boolean $do_blocks Parse blocks or not.
	 * @param boolean $echo      Render or return.
	 * @return string
	 */
	function suki_loop_navigation( $mode = 'prev-next', $do_blocks = true, $echo = true ) {
		ob_start();

		?>
		<!-- wp:group {
			"style":{
				"spacing":{
					"margin":{
						"top":"calc(3 * var(--wp--style--block-gap))"
					}
				}
			},
			"className":"suki-loop__navigation",
			"layout":{
				"inherit":true
			}
		} --><div class="wp-block-group suki-loop__navigation" style="margin-top:calc(3 * var(--wp--style--block-gap))">

			<?php
			switch ( $mode ) {
				case 'page-numbers':
					?>
					<!-- wp:query-pagination {
						"paginationArrow":"arrow",
						"layout":{
							"type":"flex",
							"justifyContent":"center",
							"orientation":"horizontal"
						}
					} -->

						<!-- wp:query-pagination-numbers /-->

					<!-- /wp:query-pagination -->
					<?php
					break;

				case 'prev-next':
				default:
					?>
					<!-- wp:query-pagination {
						"paginationArrow":"arrow",
						"layout":{
							"type":"flex",
							"justifyContent":"space-between",
							"orientation":"horizontal"
						}
					} -->

						<!-- wp:query-pagination-previous {
							"label":"<?php echo esc_attr__( 'Newer Posts', 'suki' ); ?>"
						} /-->

						<!-- wp:query-pagination-next {
							"label":"<?php echo esc_attr__( 'Older Posts', 'suki' ); ?>"
						} /-->

					<!-- /wp:query-pagination -->
					<?php
					break;
			}
			?>
		</div>
		<?php
		$html = ob_get_clean();

		// Remove tag white space, used for detecting :empty on CSS (:has is not yet supported by major browsers).
		// We can't put the margin on the Query Pagination block, because it doesn't support margin yet.
		$html = preg_replace( '/>\s+</', '><', $html );

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
