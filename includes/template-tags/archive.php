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
		$html = '';

		// Render posts navigation.
		switch ( $mode ) {
			case 'page-numbers':
				$html = '
				<!-- wp:group {
					"className":"suki-loop__navigation",
					"layout":{
						"inherit":true
					}
				} --><div class="wp-block-group suki-loop__navigation">

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

				</div><!-- /wp:group -->
				';
				break;

			case 'prev-next':
			default:
				$html = '
				<!-- wp:group {
					"className":"suki-loop__navigation",
					"layout":{
						"inherit":true
					}
				} --><div class="wp-block-group suki-loop__navigation">

					<!-- wp:query-pagination {
						"paginationArrow":"arrow",
						"layout":{
							"type":"flex",
							"justifyContent":"space-between",
							"orientation":"horizontal"
						}
					} -->

						<!-- wp:query-pagination-previous {
							"label":"' . esc_html__( 'Newer Posts', 'suki' ) . '"
						} /-->

						<!-- wp:query-pagination-next {
							"label":"' . esc_html__( 'Older Posts', 'suki' ) . '"
						} /-->

					<!-- /wp:query-pagination -->

				</div><!-- /wp:group -->
				';
				break;
		}

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
