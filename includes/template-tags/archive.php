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
			"layout":{
				"type":"default"
			},
			"style":{
				"spacing":{
					"margin":{
						"bottom":"4rem"
					},
					"blockGap":"0.75rem"
				}
			}
		} --><div class="wp-block-group" style="margin-bottom:4rem">

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
	 * Note:
	 * - Theme uses `suki-loop--layout-default` class to add / override styles.
	 * - Theme uses `suki-small-title` class to add / override styles.
	 *
	 * @todo `core/query` doesn't support `blockGap` yet, check again later.
	 *
	 * @since 2.0.0
	 *
	 * @param boolean $do_blocks Parse blocks or not.
	 * @param boolean $echo      Render or return.
	 * @return string
	 */
	function suki_loop__default( $do_blocks = true, $echo = true ) {
		ob_start();

		$container = suki_get_current_page_setting( 'content_container' );
		if ( suki_current_page_has_sidebar() && 'narrow' === $container ) {
			$container = 'wide';
		}

		$content_size = '';
		if ( 'full' === $container ) {
			$content_size = '100%';
		} elseif ( 'wide' === $container ) {
			$content_size = 'var(--wp--style--global--wide-size)';
		}

		$items_gap = suki_get_theme_mod( 'blog_index_default_items_gap' );
		?>
		<!-- wp:query {
			"query":{
				"type":"default"
			},
			"layout":{
				"type":"default"
			}
		} --><div class="wp-block-query">

			<!-- wp:post-template {
				"className":"suki-loop suki-loop--layout-default"
			} -->

				<!-- wp:group {
					"tagName":"article",
					"style":{
						"spacing":{
							"margin":{
								"bottom":"<?php echo esc_attr( $items_gap ); ?>"
							}
						}
					}
				} --><article class="wp-block-group" style="margin-bottom:<?php echo esc_attr( $items_gap ); ?>">

					<?php
					/**
					 * Entry header
					 */
					if ( 0 < count( suki_get_theme_mod( 'entry_header', array() ) ) || in_array( suki_get_theme_mod( 'entry_thumbnail_position' ), array( 'before', 'after' ), true ) ) {
						?>
						<!-- wp:group {
							"layout":{
								<?php
								if ( suki_current_page_has_sidebar() ) {
									?>
									"type":"default"
									<?php
								} else {
									?>
									"type":"constrained",
									"contentSize":"<?php echo esc_attr( $content_size ); ?>"
									<?php
								}
								?>
							},
							"style":{
								"spacing":{
									"margin":{
										"bottom":"2rem"
									},
									"blockGap":"0.75rem"
								}
							}
						} --><div class="wp-block-group" style="margin-bottom:2rem">

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
												"bottom":"2rem"
											}
										}
									}
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
												"top":"2rem"
											}
										}
									}
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
								"layout":{
									<?php
									if ( suki_current_page_has_sidebar() ) {
										?>
										"type":"default"
										<?php
									} else {
										?>
										"type":"constrained",
										"contentSize":"<?php echo esc_attr( $content_size ); ?>"
										<?php
									}
									?>
								},
								"style":{
									"spacing":{
										"margin":{
											"top":"2rem",
											"bottom":"2rem"
										}
									}
								}
							} -->
							<div class="wp-block-group">
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
							"layout":{
								<?php
								if ( suki_current_page_has_sidebar() ) {
									?>
									"type":"default"
									<?php
								} else {
									?>
									"type":"constrained",
									"contentSize":"<?php echo esc_attr( $content_size ); ?>"
									<?php
								}
								?>
							},
							"style":{
								"spacing":{
									"margin":{
										"top":"2rem",
										"bottom":"2rem"
									}
								}
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
							"layout":{
								<?php
								if ( suki_current_page_has_sidebar() ) {
									?>
									"type":"default"
									<?php
								} else {
									?>
									"type":"constrained",
									"contentSize":"<?php echo esc_attr( $content_size ); ?>"
									<?php
								}
								?>
							},
							"style":{
								"spacing":{
									"margin":{
										"top":"2rem"
									},
									"blockGap":"0.75rem"
								}
							}
						} --><div class="wp-block-group" style="margin-top:2rem">

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
	 * Note:
	 * - Theme uses `suki-loop--layout-grid` class to add / override styles.
	 * - Theme uses `suki-small-title` class to add / override styles.
	 *
	 * @todo `core/query` doesn't support `blockGap` yet, check again later.
	 *
	 * @since 2.0.0
	 *
	 * @param boolean $do_blocks Parse blocks or not.
	 * @param boolean $echo      Render or return.
	 * @return string
	 */
	function suki_loop__grid( $do_blocks = true, $echo = true ) {
		ob_start();

		$padding       = suki_get_theme_mod( 'entry_grid_same_padding' );
		$border        = suki_get_theme_mod( 'entry_grid_same_border' );
		$border_radius = suki_get_theme_mod( 'entry_grid_same_border_radius' );
		$same_height   = suki_get_theme_mod( 'entry_grid_same_height' );
		?>
		<!-- wp:query {
			"query":{
				"type":"default"
			},
			"displayLayout":{
				"type":"flex",
				"columns":<?php echo esc_attr( suki_get_theme_mod( 'blog_index_grid_columns' ) ); ?>
			},
			"layout":{
				"type":"default"
			}
		} --><div class="wp-block-query">

			<!-- wp:post-template {
				"className":"suki-loop suki-loop--layout-grid"
			} -->

				<!-- wp:group {
					"tagName":"article"
				} --><article class="wp-block-group">

					<?php
					/**
					 * Entry header
					 */
					if ( 0 < count( suki_get_theme_mod( 'entry_grid_header', array() ) ) || in_array( suki_get_theme_mod( 'entry_grid_thumbnail_position' ), array( 'before', 'after' ), true ) ) {
						?>
						<!-- wp:group {
							"style":{
								"spacing":{
									"margin":{
										"bottom":"1.25rem"
									},
									"blockGap":"0.75rem"
								}
							}
						} --><div class="wp-block-group" style="margin-bottom:1.25rem">

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
												"bottom":"1.25rem"
											}
										}
									},
									"className":"<?php echo esc_attr( boolval( suki_get_theme_mod( 'entry_grid_thumbnail_ignore_padding' ) ) ? 'suki-entry-thumbnail--ignore-padding' : '' ); ?>"
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
												"top":"1.25rem"
											}
										}
									},
									"className":"<?php echo esc_attr( boolval( suki_get_theme_mod( 'entry_grid_thumbnail_ignore_padding' ) ) ? 'suki-entry-thumbnail--ignore-padding' : '' ); ?>"
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
							"style":{
								"spacing":{
									"margin":{
										"top":"1.25rem"
									},
									"blockGap":"0.75rem"
								}
							}
						} --><div class="wp-block-group" style="margin-top:1.25rem">

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
	 * Note:
	 * - Theme uses `suki-small-title` class to add / override styles.
	 *
	 * @todo `core/query` doesn't support `blockGap` yet, check again later.
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
				"type":"default"
			},
			"layout":{
				"type":"default"
			}
		} --><div class="wp-block-query">

			<!-- wp:post-template {
				"className":"suki-loop suki-loop--layout-search"
			} -->

				<!-- wp:group {
					"tagName":"article",
					"style":{
						"spacing":{
							"margin":{
								"bottom":"3rem"
							}
						}
					}
				} --><article class="wp-block-group" style="margin-bottom:3rem">

					<!-- wp:post-title {
						"level":2,
						"isLink":true,
						"className":"suki-small-title"
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
			"layout":{
				"type":"default"
			},
			"style":{
				"spacing":{
					"margin":{
						"top":"4rem"
					}
				}
			}
		} --><div class="wp-block-group" style="margin-top:4rem">

			<?php
			switch ( $mode ) {
				case 'page-numbers':
					?>
					<!-- wp:query-pagination {
						"paginationArrow":"arrow",
						"layout":{
							"type":"flex",
							"justifyContent":"center"
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
							"justifyContent":"space-between"
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
