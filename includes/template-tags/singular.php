<?php
/**
 * Singular pages template rendering functions.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Post navigation
 */
if ( ! function_exists( 'suki_singular_navigation' ) ) {
	/**
	 * Render singular prev / next post navigation in single post page.
	 *
	 * @since 2.0.0
	 *
	 * @param boolean $do_blocks Parse blocks or not.
	 * @param boolean $echo      Render or return.
	 * @return string
	 */
	function suki_singular_navigation( $do_blocks = true, $echo = true ) {
		ob_start();
		?>
		<!-- wp:group {
			"className":"suki-post-navigation",
			"layout":{
				"type":"flex",
				"flexWrap":"nowrap",
				"justifyContent":"space-between"
			}
		} --><div class="wp-block-group suki-post-navigation">

			<!-- wp:heading {
				"className":"screen-reader-text"
			} --><h2 class="screen-reader-text"><?php esc_html_e( 'Navigation', 'suki' ); ?></h2><!-- /wp:heading -->

			<!-- wp:post-navigation-link {
				"type":"previous",
				"label":" ",
				"showTitle":true,
				"className":"has-text-align-left"
			} /-->

			<!-- wp:post-navigation-link {
				"label":" ",
				"showTitle":true,
				"className":"has-text-align-right"
			} /-->

		</div><!-- /wp:group -->
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

/**
 * Author bio
 */
if ( ! function_exists( 'suki_author_bio' ) ) {
	/**
	 * Render singular author bio.
	 * Note: `entry-author` class is used to style the element.
	 *
	 * @since 2.0.0
	 *
	 * @param boolean $do_blocks Parse blocks or not.
	 * @param boolean $echo      Render or return.
	 * @return string
	 */
	function suki_author_bio( $do_blocks = true, $echo = true ) {
		ob_start();
		?>
		<!-- wp:post-author {
			"avatarSize":96,
			"showBio":true,
			"style":{
				"spacing":{
					"margin":{
						"top":"calc(3 * var(--wp--style--block-gap))"
					},
					"padding":{
						"top":"var(--wp--style--block-gap)",
						"right":"var(--wp--style--block-gap)",
						"bottom":"var(--wp--style--block-gap)",
						"left":"var(--wp--style--block-gap)"
					}
				}
			},
			"className":"suki-author-bio"
		} /-->
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

/**
 * Comments
 */
if ( ! function_exists( 'suki_comments' ) ) {
	/**
	 * Print singular comments.
	 *
	 * Notes:
	 * - Comment meta's `blockGap` (0px) is set via `suki-comment__meta` class to avoid late generated inline CSS.
	 *
	 * @since 2.0.0
	 *
	 * @param boolean $do_blocks Parse blocks or not.
	 * @param boolean $echo      Render or return.
	 */
	function suki_comments( $do_blocks = true, $echo = true ) {
		ob_start();
		?>
		<!-- wp:comments-query-loop {
			"style":{
				"spacing":{
					"margin":{
						"top":"calc(3 * var(--wp--style--block-gap))"
					}
				}
			},
			"className":"suki-comments"
		} --><div class="wp-block-comments-query-loop suki-comments" style="margin-top:calc(3 * var(--wp--style--block-gap))">

			<!-- wp:comments-title /-->

			<!-- wp:comment-template {
				"className":"suki-comments__list"
			} -->

				<!-- wp:group {
					"className":"suki-comment"
				} --><div class="wp-block-group suki-comment">

					<!-- wp:group {
						"className":"suki-comment__header",
						"layout":{
							"type":"flex",
							"flexWrap":"nowrap"
						}
					} --><div class="wp-block-group suki-comment__header">

						<!-- wp:avatar {
							"size":50,
							"className":"suki-comment__avatar",
							"style":{
								"border":{
									"radius":"50%"
								}
							}
						} /-->

						<!-- wp:group {
							"style":{
								"spacing":{
									"blockGap":"0px"
								}
							},
							"className":"suki-comment__meta"
						} --><div class="wp-block-group suki-comment__meta">

							<!-- wp:comment-author-name /-->

							<!-- wp:group {
								"className":"suki-meta suki-reverse-link-color",
								"layout":{
									"type":"flex"
								}
							} --><div class="wp-block-group suki-meta suki-reverse-link-color">

								<!-- wp:comment-date /-->

								<!-- wp:comment-edit-link /-->

							</div><!-- /wp:group -->

						</div><!-- /wp:group -->

					</div><!-- /wp:group -->

					<!-- wp:comment-content /-->

					<!-- wp:comment-reply-link {
						"className":"suki-meta suki-reverse-link-color"
					} /-->

				</div><!-- /wp:group -->

			<!-- /wp:comment-template -->

			<!-- wp:comments-pagination {
				"paginationArrow":"arrow",
				"className":"suki-comments__pagination",
				"layout":{
					"type":"flex",
					"orientation":"horizontal",
					"justifyContent":"center"
				}
			} -->

				<!-- wp:comments-pagination-previous {
					"label":" "
				} /-->

				<!-- wp:comments-pagination-numbers /-->

				<!-- wp:comments-pagination-next {
					"label":" "
				} /-->

			<!-- /wp:comments-pagination -->

			<!-- wp:post-comments-form {
				"className":"suki-comments__form"
			} /-->

		</div><!-- /wp:comments-query-loop -->
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
