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
		<!-- wp:columns {
			"style":{
				"spacing":{
					"margin":{
						"top":"4em"
					}
				}
			},
			"className":"suki-post-navigation"
		} --><div class="wp-block-columns suki-post-navigation" style="margin-top:4em">

			<!-- wp:column {
				"width":"50%"
			} --><div class="wp-block-column" style="flex-basis:50%">

				<!-- wp:post-navigation-link {
					"type":"previous",
					"textAlign":"left",
					"label":"",
					"showTitle":true,
					"arrow":"arrow",
					"style":{
						"layout":{
							"selfStretch":"fill",
							"flexSize":null
						}
					}
				} /-->

			</div><!-- /wp:column -->

			<!-- wp:column {
				"width":"50%"
			} --><div class="wp-block-column" style="flex-basis:50%">

				<!-- wp:post-navigation-link {
					"type":"next",
					"textAlign":"right",
					"label":"",
					"showTitle":true,
					"arrow":"arrow",
					"style":{
						"layout":{
							"selfStretch":"fill",
							"flexSize":null
						}
					}
				} /-->

			</div><!-- /wp:column -->

		</div><!-- /wp:columns -->
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
		<!-- wp:columns {
			"isStackedOnMobile":false,
			"backgroundColor":"base",
			"borderColor":"base-3",
			"style":{
				"border":{
					"width":"1px"
				},
				"spacing":{
					"margin":{
						"top":"4rem"
					},
					"padding":{
						"top":"1.5rem",
						"right":"1.5rem",
						"bottom":"1.5rem",
						"left":"1.5rem"
					}
				}
			},
			"layout":{
				"type":"flex",
				"flexWrap":"nowrap",
				"verticalAlignment":"top"
			}
		} --><div class="wp-block-columns is-not-stacked-on-mobile has-base-background-color has-background has-base-3-border-color has-border-color" style="border-width:1px;margin-top:4rem;padding-top:1.5rem;padding-right:1.5rem;padding-bottom:1.5rem;padding-left:1.5rem">

			<!-- wp:column {
				"width":"96px"
			} --><div class="wp-block-column" style="flex-basis:96px">

				<!-- wp:avatar {
					"size":96,
					"style":{
						"layout":{
							"selfStretch":"fixed",
							"flexSize":"96px"
						},
						"border":{
							"radius":"50%"
						}
					}
				} /-->

			</div><!-- /wp:column -->

			<!-- wp:column {
				"style":{
					"spacing":{
						"blockGap":"0.5em"
					}
				}
			} --><div class="wp-block-column">

				<!-- wp:post-author-name {
					"isLink":true
				} /-->

				<!-- wp:post-author-biography /-->

			</div><!-- /wp:column -->

		</div><!-- /wp:columns -->
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
						"top":"4rem"
					}
				}
			},
			"className":"suki-comments"
		} --><div class="wp-block-comments-query-loop suki-comments" style="margin-top:4rem">

			<!-- wp:comments-title /-->

			<!-- wp:comment-template -->

				<!-- wp:columns {
					"isStackedOnMobile":false,
					"style":{
						"spacing":{
							"margin":{
								"top":"2.5rem",
								"bottom":"2.5rem"
							},
							"blockGap":"1rem"
						}
					}
				} --><div class="wp-block-columns is-not-stacked-on-mobile" style="margin-top:2.5rem;margin-bottom:2.5rem">

					<!-- wp:column {
						"width":"3rem"
					} --><div class="wp-block-column" style="flex-basis:3rem">

						<!-- wp:avatar {
							"size":50,
							"style":{
								"border":{
									"radius":"50%"
								}
							}
						} /-->

					</div><!-- /wp:column -->

					<!-- wp:column {
						"style":{
							"spacing":{
								"blockGap":"0.75em"
							}
						}
					} --><div class="wp-block-column">

						<!-- wp:comment-author-name /-->

						<!-- wp:group {
							"layout":{
								"type":"flex"
							},
							"textColor":"contrast-3",
							"style":{
								"elements":{
									"link":{
										"color":{
											"text":"var:preset|color|contrast-3"
										}
									}
								},
								"margin":{
									"top":"0px",
									"bottom":"0px"
								},
								"spacing":{
									"blockGap":"0.75em"
								}
							}
						} --><div class="wp-block-group has-contrast-3-color has-text-color has-link-color" style="margin-top:0px;margin-bottom:0px">

							<!-- wp:comment-date {
								"fontSize":"small"
							} /-->

							<!-- wp:comment-edit-link {
								"fontSize":"small"
							} /-->

						</div><!-- /wp:group -->

						<!-- wp:comment-content /-->

						<!-- wp:comment-reply-link {
							"fontSize":"small",
							"style":{
								"elements":{
									"link":{
										"color":{
											"text":"var:preset|color|contrast-3"
										}
									}
								}
							}
						} /-->

					</div><!-- /wp:column -->

				</div><!-- /wp:columns -->

			<!-- /wp:comment-template -->

			<!-- wp:comments-pagination {
				"paginationArrow":"arrow",
				"layout":{
					"type":"flex",
					"justifyContent":"center",
					"verticalAlignment":"top"
				},
				"style":{
					"spacing":{
						"blockGap":"0px"
					}
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
				"style":{
					"spacing":{
						"margin":{
							"top":"2.5rem"
						}
					}
				}
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
