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

		if ( is_archive() || is_home() || is_search() ) {
			// Render posts navigation.
			switch ( $mode ) {
				case 'page-numbers':
					$html = '
					<!-- wp:query-pagination {
						"paginationArrow":"arrow",
						"layout":{
							"type":"flex",
							"justifyContent":"center",
							"orientation":"horizontal"
						},
						"className":"suki-archive-navigation"
					} -->

						<!-- wp:query-pagination-previous {
							"label":" "
						} /-->

						<!-- wp:query-pagination-numbers /-->

						<!-- wp:query-pagination-next {
							"label":" "
						} /-->

					<!-- /wp:query-pagination -->
					';
					break;

				case 'prev-next':
				default:
					$html = '
					<!-- wp:query-pagination {
						"paginationArrow":"arrow",
						"layout":{
							"type":"flex",
							"justifyContent":"space-between",
							"orientation":"horizontal"
						},
						"className":"suki-archive-navigation"
					} -->

						<!-- wp:query-pagination-previous {
							"label":"' . esc_html__( 'Newer Posts', 'suki' ) . '"
						} /-->

						<!-- wp:query-pagination-next {
							"label":"' . esc_html__( 'Older Posts', 'suki' ) . '"
						} /-->

					<!-- /wp:query-pagination -->
					';
					break;
			}
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
