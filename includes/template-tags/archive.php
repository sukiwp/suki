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
 * Content header on archive page's <main> tag.
 */
if ( ! function_exists( 'suki_archive_header' ) ) {
	/**
	 * Render content header on archive page's <main> tag.
	 *
	 * @param boolean $do_blocks Parse blocks or not.
	 * @param boolean $echo      Render or return.
	 * @return string
	 */
	function suki_archive_header( $do_blocks = true, $echo = true ) {
		$elements = suki_get_current_page_setting( 'content_header', array() );

		if ( 1 > count( $elements ) ) {
			return;
		}

		?>
		<!-- wp:group {
			"style":{
				"spacing":{
					"margin":{
						"bottom":"calc(3 * var(--wp--style--block-gap))"
					}
				}
			},
			"className":"suki-content-header"
		} --><div class="wp-block-group suki-content-header" style="margin-bottom:calc(3 * var(--wp--style--block-gap))">

			<?php
			suki_content_header( false );
			?>

		</div><!-- /wp:group -->
		<?php
	}
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

		/**
		 * Hook: suki/frontend/loop_{layout}
		 */
		do_action( 'suki/frontend/loop_' . $layout );

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
 * Default loop layout
 */
if ( ! function_exists( 'suki_loop__default' ) ) {
	/**
	 * Render posts loop in `default` layout.
	 *
	 * @since 2.0.0
	 *
	 * @param boolean $do_blocks Parse blocks or not.
	 * @param boolean $echo      Render or return.
	 * @return string
	 */
	function suki_loop__default( $do_blocks = true, $echo = true ) {
		ob_start();
		?>
		<!-- wp:query {
			"query":{
				"inherit":true
			}
		} --><div class="wp-block-query">

			<!-- wp:post-template {
				"className":"suki-loop suki-loop--layout-default"
			} -->

				<!-- wp:group {
					"tagName":"article",
					"className":"entry entry--layout-default"
				} --><article class="wp-block-group entry entry--layout-default">

					<?php
					/**
					 * Entry header
					 */
					if ( 0 < count( suki_get_theme_mod( 'entry_header', array() ) ) || in_array( suki_get_theme_mod( 'entry_thumbnail_position' ), array( 'before', 'after' ), true ) ) {
						?>
						<!-- wp:group {
							"style":{
								"spacing":{
									"margin":{
										"bottom":"calc(1.5 * var(--wp--style--block-gap))"
									}
								}
							},
							"className":"entry-header",
							"layout":{
								"inherit":true
							}
						} --><div class="wp-block-group entry-header" style="margin-bottom:calc(1.5 * var(--wp--style--block-gap))">

							<?php
							/**
							 * Featured image (before content header)
							 */
							if ( 'before' === suki_get_theme_mod( 'entry_thumbnail_position' ) ) {
								?>
								<!-- wp:post-featured-image {
									"align":"<?php echo esc_attr( boolval( suki_get_theme_mod( 'entry_thumbnail_wide' ) ) ? 'wide' : 'none' ); ?>",
									"isLink":true,
									"style":{
										"spacing":{
											"margin":{
												"bottom":"calc(1.5 * var(--wp--style--block-gap))"
											}
										}
									},
									"className":"entry-thumbnail"
								} /-->
								<?php
							}

							/**
							 * Content Header
							 */
							foreach ( suki_get_theme_mod( 'entry_header', array() ) as $element ) {
								suki_entry_header_footer_element( $element, 'default', suki_get_theme_mod( 'entry_header_alignment', 'left' ), false );
							}

							/**
							 * Featured image (after content header)
							 */
							if ( 'after' === suki_get_theme_mod( 'entry_thumbnail_position' ) ) {
								?>
								<!-- wp:post-featured-image {
									"align":"<?php echo esc_attr( boolval( suki_get_theme_mod( 'entry_thumbnail_wide' ) ) ? 'wide' : 'none' ); ?>",
									"isLink":true,
									"style":{
										"spacing":{
											"margin":{
												"top":"calc(1.5 * var(--wp--style--block-gap))"
											}
										}
									},
									"className":"entry-thumbnail"
								} /-->
								<?php
							}
							?>

						</div><!-- /wp:group -->
						<?php
					}

					/**
					 * Main content
					 */
					if ( 'excerpt' === suki_get_theme_mod( 'entry_content' ) ) {
						/**
						 * Main content - excerpt
						 */
						if ( 0 < intval( suki_get_theme_mod( 'entry_excerpt_length' ) ) ) {
							?>
							<!-- wp:group {
								"style":{
									"spacing":{
										"margin":{
											"top":"calc(1.5 * var(--wp--style--block-gap))",
											"bottom":"calc(1.5 * var(--wp--style--block-gap))"
										}
									}
								},
								"className":"entry-excerpt",
								"layout":{
									"inherit":true
								}
							} -->
							<div class="wp-block-group entry-excerpt">
								<!-- wp:post-excerpt {
									"moreText":"<?php echo esc_attr( suki_get_theme_mod( 'entry_read_more_text' ) ); ?>"
								} /-->
							</div><!-- /wp:group -->
							<?php
						}
					} else {
						/**
						 * Main content - full content
						 */
						?>
						<!-- wp:post-content {
							"style":{
								"spacing":{
									"margin":{
										"top":"calc(1.5 * var(--wp--style--block-gap))",
										"bottom":"calc(1.5 * var(--wp--style--block-gap))"
									}
								}
							},
							"layout":{
								"inherit":true
							}
						} /-->
						<?php
					}

					/**
					 * Entry footer
					 */
					if ( 0 < count( suki_get_theme_mod( 'entry_footer', array() ) ) ) {
						?>
						<!-- wp:group {
							"style":{
								"spacing":{
									"margin":{
										"top":"calc(1.5 * var(--wp--style--block-gap))"
									}
								}
							},
							"className":"entry-footer suki-content-footer",
							"layout":{
								"inherit":true
							}
						} --><div class="wp-block-group entry-footer" style="margin-top:calc(1.5 * var(--wp--style--block-gap))">

							<?php
							foreach ( suki_get_theme_mod( 'entry_footer' ) as $element ) {
								suki_entry_header_footer_element( $element, 'default', suki_get_theme_mod( 'entry_footer_alignment', 'left' ), false );
							}
							?>

						</div><!-- /wp:group -->
						<?php
					}
					?>

				</article><!-- /wp:group -->

			<!-- /wp:post-template -->

			<?php
			/**
			 * Pagination
			 */
			suki_loop_navigation( suki_get_theme_mod( 'post_archive_navigation_mode' ), false );
			?>

			<!-- wp:query-no-results -->
				<!-- wp:paragraph -->
				<p><?php esc_html_e( 'Nothing found.', 'suki' ); ?></p>
				<!-- /wp:paragraph -->
			<!-- /wp:query-no-results -->

		</div><!-- /wp:query -->
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
 * Grid loop layout
 */
if ( ! function_exists( 'suki_loop__grid' ) ) {
	/**
	 * Render posts loop in `grid` layout.
	 *
	 * @since 2.0.0
	 *
	 * @param boolean $do_blocks Parse blocks or not.
	 * @param boolean $echo      Render or return.
	 * @return string
	 */
	function suki_loop__grid( $do_blocks = true, $echo = true ) {
		ob_start();
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

				<!-- wp:group {
					"tagName":"article",
					"className":"entry entry--layout-grid"
				} --><article class="wp-block-group entry entry--layout-grid">

					<?php
					/**
					 * Entry header
					 */
					if ( 0 < count( suki_get_theme_mod( 'entry_grid_header', array() ) ) || in_array( suki_get_theme_mod( 'entry_grid_thumbnail_position' ), array( 'before', 'after' ), true ) ) {
						?>
						<!-- wp:group {
							"className":"entry-header"
						} --><div class="wp-block-group entry-header">

							<?php
							/**
							 * Featured image (before entry header)
							 */
							if ( 'before' === suki_get_theme_mod( 'entry_grid_thumbnail_position' ) ) {
								?>
								<!-- wp:post-featured-image {
									"isLink":true,
									"style":{
										"spacing":{
											"margin":{
												"bottom":"var(--wp--style--block-gap)"
											}
										}
									},
									"className":"entry-thumbnail <?php echo esc_attr( boolval( suki_get_theme_mod( 'entry_grid_thumbnail_ignore_padding' ) ) ? 'suki-entry-thumbnail--ignore-padding' : '' ); ?>"
								} /-->
								<?php
							}

							/**
							 * Entry header
							 */
							foreach ( suki_get_theme_mod( 'entry_grid_header' ) as $element ) {
								suki_entry_header_footer_element( $element, 'grid', suki_get_theme_mod( 'entry_grid_header_alignment', 'left' ), false );
							}

							/**
							 * Featured image (after entry header)
							 */
							if ( 'after' === suki_get_theme_mod( 'entry_grid_thumbnail_position' ) ) {
								?>
								<!-- wp:post-featured-image {
									"isLink":true,
									"style":{
										"spacing":{
											"margin":{
												"top":"var(--wp--style--block-gap)"
											}
										}
									},
									"className":"entry-thumbnail <?php echo esc_attr( boolval( suki_get_theme_mod( 'entry_grid_thumbnail_ignore_padding' ) ) ? 'suki-entry-thumbnail--ignore-padding' : '' ); ?>"
								} /-->
								<?php
							}
							?>

						</div><!-- /wp:group -->
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

				</article><!-- /wp:group -->

			<!-- /wp:post-template -->

			<?php
			/**
			 * Pagination
			 */
			suki_loop_navigation( suki_get_theme_mod( 'post_archive_navigation_mode' ), false );
			?>

			<!-- wp:query-no-results -->
				<!-- wp:paragraph -->
				<p><?php esc_html_e( 'Nothing found.', 'suki' ); ?></p>
				<!-- /wp:paragraph -->
			<!-- /wp:query-no-results -->

		</div><!-- /wp:query -->
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
 * Search loop layout
 */
if ( ! function_exists( 'suki_loop__search' ) ) {
	/**
	 * Render posts loop in `search` layout.
	 *
	 * @since 2.0.0
	 *
	 * @param boolean $do_blocks Parse blocks or not.
	 * @param boolean $echo      Render or return.
	 * @return string
	 */
	function suki_loop__search( $do_blocks = true, $echo = true ) {
		ob_start();
		?>
		<!-- wp:query {
			"query":{
				"inherit":true
			},
			"layout":{
				"inherit":true
			}
		} --><div class="wp-block-query">

			<!-- wp:post-template {
				"style":{
					"spacing":{
						"blockGap":"3em"
					}
				},
				"className":"suki-loop suki-loop--layout-search"
			} -->

				<!-- wp:group {
					"tagName":"article",
					"className":"entry entry--layout-search"
				} --><article class="wp-block-group entry entry--layout-search">

					<!-- wp:post-title {
						"level":2,
						"isLink":true,
						"className":"entry-title suki-small-title"
					} /-->

					<!-- wp:post-excerpt /-->

					</article><!-- /wp:group -->

		<!-- /wp:post-template -->

		<?php
		/**
		 * Pagination
		 */
		suki_loop_navigation( suki_get_theme_mod( 'post_archive_navigation_mode' ), false );
		?>

		<!-- wp:query-no-results -->
			<!-- wp:paragraph -->
			<p><?php esc_html_e( 'Nothing found.', 'suki' ); ?></p>
			<!-- /wp:paragraph -->
		<!-- /wp:query-no-results -->

		</div><!-- /wp:query -->
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
