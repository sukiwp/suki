<?php
/**
 * Content section template rendering functions.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Content section
 */
if ( ! function_exists( 'suki_content' ) ) {
	/**
	 * Render content section with the specified main content.
	 *
	 * @param string  $main_content Main content.
	 * @param boolean $echo         Render or return.
	 * @param boolean $do_blocks    Parse blocks or not.
	 * @return string
	 */
	function suki_content( $main_content, $echo = true, $do_blocks = true ) {
		$has_sidebar = 'narrow' !== suki_get_current_page_setting( 'content_container' ) && in_array( suki_get_current_page_setting( 'content_layout' ), array( 'left-sidebar', 'right-sidebar' ), true );

		$content_classes = implode(
			' ',
			array(
				'suki-content',
				'site-content',
				'suki-section-' . suki_get_current_page_setting( 'content_container' ),
				$has_sidebar ? 'suki-content-layout-' . suki_get_current_page_setting( 'content_layout' ) : '',
			)
		);

		/**
		 * Content section
		 *
		 * Note: Styles are configured via CSS class and Customizer options.
		 */
		ob_start();
		?>
		<!-- wp:group {
			"align":"full",
			"className":"<?php echo esc_attr( $content_classes ); ?>",
			"layout":{
				"inherit":true
			}
		} --><div id="content" class="wp-block-group alignfull <?php echo esc_attr( $content_classes ); ?>">

			<?php
			/**
			 * Hook: suki/frontend/before_content
			 */
			do_action( 'suki/frontend/before_content' );

			/**
			 * Content with sidebar wrapper -- Open
			 *
			 * Note: Styles are configured via CSS class and Customizer options.
			 */
			if ( $has_sidebar ) {
				?>
				<!-- wp:columns {
					"verticalAlignment":"top",
					"className":"suki-content-sidebar-columns"
				} --><div class="wp-block-columns are-vertically-aligned-top suki-content-sidebar-columns">

					<!-- wp:column {
						"verticalAlignment":"top",
						"className":"suki-main-column"
					} --><div class="wp-block-column is-vertically-aligned-top suki-main-column">
				<?php
			}

			/**
			 * Main content
			 */
			?>
			<!-- wp:group {
				"tagName":"main",
				"align":"full",
				"className":"site-main",
				"layout":{
					"inherit":true
				}
			} --><main id="primary" class="wp-block-group alignfull site-main">

				<?php
				/**
				 * Hook: suki/frontend/before_main
				 */
				do_action( 'suki/frontend/before_main' );

				/**
				 * Main content
				 */
				echo $main_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

				/**
				 * Hook: suki/frontend/after_main
				 */
				do_action( 'suki/frontend/after_main' );
				?>

			</main><!-- /wp:group -->
			<?php

			/**
			 * Content with sidebar wrapper -- Close
			 */
			if ( $has_sidebar ) {
				?>
					</div><!-- /wp:column -->

					<!-- wp:column {
						"verticalAlignment":"top",
						"className":"suki-sidebar-column"
					} --><div class="wp-block-column is-vertically-aligned-top suki-sidebar-column">

						<?php
						/**
						 * Sidebar
						 */
						get_sidebar();
						?>

					</div><!-- /wp:column -->

				</div><!-- /wp:columns -->
				<?php
			}

			/**
			 * Hook: suki/frontend/after_content
			 */
			do_action( 'suki/frontend/after_content' );
			?>

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
 * Content header element
 */
if ( ! function_exists( 'suki_content_header_element' ) ) {
	/**
	 * Render content header element.
	 *
	 * @param string  $element   Element slug.
	 * @param string  $alignment Element alignment (left, center, or right).
	 * @param boolean $echo      Render or return.
	 * @param boolean $do_blocks Parse blocks or not.
	 * @return string
	 */
	function suki_content_header_element( $element, $alignment = 'left', $echo = true, $do_blocks = true ) {
		// Abort if element slug is empty.
		if ( empty( $element ) ) {
			return;
		}

		switch ( $element ) {
			case 'title':
				// Singular pages.
				if ( is_singular() ) {
					$title = get_the_title();
				}

				// Search results page.
				if ( is_search() ) {
					// Get custom title format.
					$title = suki_get_current_page_setting( 'title_text' );

					// If empty, use default format.
					if ( empty( $title ) ) {
						$title = esc_html__( 'Search results for: "{{keyword}}"', 'suki' );
					}

					// Parse title format.
					$title = preg_replace( '/\{\{keyword\}\}/', '<span>' . get_search_query() . '</span>', $title );
				}

				// Blog posts page.
				if ( is_home() ) {
					// Get custom title format.
					$title = suki_get_current_page_setting( 'title_text' );

					if ( ! empty( $title ) ) {
						// Parse title format.
						$title = str_replace( '{{post_type}}', get_post_type_object( get_post_type() )->labels->name, $title );
					} else {
						// Check if "Your homepage displays" set to "Your latest posts".
						if ( 'posts' === get_option( 'show_on_front' ) ) {
							// Use site tagline.
							$title = get_bloginfo( 'description' );
						} else {
							// Use the defined blog page title.
							$title = get_the_title( get_option( 'page_for_posts' ) );
						}
					}
				}

				// Posts type archive pages.
				if ( is_post_type_archive() ) {
					// Get custom title format.
					$title = suki_get_current_page_setting( 'title_text' );

					if ( ! empty( $title ) ) {
						// Parse format.
						$title = str_replace( '{{post_type}}', get_post_type_object( get_post_type() )->labels->name, $title );
					} else {
						// Use default archive title from WordPress.
						$title = get_the_archive_title();
					}
				}

				// Taxonomy archive pages.
				if ( is_category() || is_tag() || is_tax() ) {
					// Get custom title format.
					$title = suki_get_current_page_setting( 'tax_title_text' );

					if ( ! empty( $title ) ) {
						// Parse format.
						$title = str_replace( '{{taxonomy}}', get_taxonomy( $term_obj->taxonomy )->labels->singular_name, $title );
						$title = str_replace( '{{term}}', get_queried_object()->name, $title );
					} else {
						// Use default archive title from WordPress.
						$title = get_the_archive_title(); // Default title.
					}
				}

				// Wrap title text.
				if ( ! empty( $title ) ) {
					$html = '
					<!-- wp:heading {
						"textAlign":"' . $alignment . '
						"className":"entry-title suki-title"
					} --><h2 class="has-text-align-' . $alignment . ' entry-title suki-title">' . $title . '</h2><!-- /wp:heading -->
					';
				}
				break;

			case 'archive-description':
				// We can't replace this with Gutenberg block yet, because it doesn't cover Author and Post Type archive description.
				if ( ! is_post_type_archive() ) {
					$desc = trim( get_the_archive_description() );

					if ( ! empty( $desc ) ) {
						$html = '
						<!-- wp:paragraph {
							"align":"' . $alignment . '"
						} --><p class="has-text-align-' . $alignment . '">
							' . $desc . '
						</p><!-- /wp:paragraph -->
						';
					}
				}
				break;

			case 'search-form':
				// We can't replace this with Gutenberg block yet, because the Search block style is not same as our theme's search bar.
				$html = get_search_form( array( 'echo' => false ) );
				break;

			case 'header-meta':
				$html = suki_entry_meta( suki_get_current_page_setting( 'content_header_meta' ), $alignment, false, false );
				break;

			case 'hr':
				$html = '
				<!-- wp:separator {
					"className":"is-style-wide"
				} --><hr class="wp-block-separator has-alpha-channel-opacity is-style-wide"/><!-- /wp:separator -->
				';
				break;

			default:
				$html = '';
				break;
		}

		/**
		 * Filter: suki/frontend/content_header_element
		 *
		 * @param string $html    HTML markup.
		 * @param string $element Element slug.
		 */
		$html = apply_filters( 'suki/frontend/content_header_element', $html, $element );

		/**
		 * Filter: suki/frontend/content_header_element/{$element}
		 *
		 * @param string $html HTML markup.
		 */
		$html = apply_filters( 'suki/frontend/content_header_element/' . $element, $html );

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
 * Content footer element
 */
if ( ! function_exists( 'suki_content_footer_element' ) ) {
	/**
	 * Render content footer element.
	 *
	 * @param string  $element   Element slug.
	 * @param string  $alignment Element alignment (left, center, or right).
	 * @param boolean $echo      Render or return.
	 * @param boolean $do_blocks Parse blocks or not.
	 * @return string
	 */
	function suki_content_footer_element( $element, $alignment = 'left', $echo = true, $do_blocks = true ) {
		// Abort if element slug is empty.
		if ( empty( $element ) ) {
			return;
		}

		switch ( $element ) {
			case 'tags':
				$html = '
				<!-- wp:post-terms {
					"term":"post_tag",
					"textAlign":"' . $alignment . '"
				} /-->
				';
				break;

			case 'footer-meta':
				$html = suki_entry_meta( suki_get_current_page_setting( 'content_footer_meta' ), $alignment, false, false );
				break;

			case 'hr':
				$html = '
				<!-- wp:separator {
					"className":"is-style-wide"
				} --><hr class="wp-block-separator has-alpha-channel-opacity is-style-wide"/><!-- /wp:separator -->
				';
				break;

			default:
				$html = '';
				break;
		}

		/**
		 * Filter: suki/frontend/content_footer_element
		 *
		 * @param string $html    HTML markup.
		 * @param string $element Element slug.
		 */
		$html = apply_filters( 'suki/frontend/content_footer_element', $html, $element );

		/**
		 * Filter: suki/frontend/content_footer_element/{$element}
		 *
		 * @param string $html HTML markup.
		 */
		$html = apply_filters( 'suki/frontend/content_footer_element/' . $element, $html );

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
 * Archive navigation
 */
if ( ! function_exists( 'suki_archive_navigation' ) ) {
	/**
	 * Render posts loop navigation.
	 *
	 * @param boolean $echo      Render or return.
	 * @param boolean $do_blocks Parse blocks or not.
	 * @return string
	 */
	function suki_archive_navigation( $echo = true, $do_blocks = true ) {
		if ( ! is_archive() && ! is_home() && ! is_search() ) {
			return;
		}

		// Render posts navigation.
		switch ( suki_get_theme_mod( 'blog_index_navigation_mode' ) ) {
			case 'pagination':
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
 * Post navigation
 */
if ( ! function_exists( 'suki_singular_navigation' ) ) {
	/**
	 * Render singular prev / next post navigation in single post page.
	 *
	 * @since 2.0.0
	 *
	 * @param boolean $echo      Render or return.
	 * @param boolean $do_blocks Parse blocks or not.
	 * @return string
	 */
	function suki_singular_navigation( $echo = true, $do_blocks = true ) {
		$html = '
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
			} --><h2 class="screen-reader-text">' . esc_html__( 'Post Navigation', 'suki' ) . '</h2><!-- /wp:heading -->

			<!-- wp:post-navigation-link {
				"type":"previous",
				"label":" ",
				"showTitle":true
			} /-->

			<!-- wp:post-navigation-link {
				"label":" ",
				"showTitle":true
			} /-->

		</div><!-- /wp:group -->
		';

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
	 * @param boolean $echo      Render or return.
	 * @param boolean $do_blocks Parse blocks or not.
	 * @return string
	 */
	function suki_author_bio( $echo = true, $do_blocks = true ) {
		$html = '
		<!-- wp:post-author {
			"avatarSize":96,
			"showBio":true,
			"className":"suki-author-bio"
		} /-->
		';

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
	 * @since 2.0.0
	 *
	 * @param boolean $echo      Render or return.
	 * @param boolean $do_blocks Parse blocks or not.
	 */
	function suki_comments( $echo = true, $do_blocks = true ) {
		$html = '
		<!-- wp:comments-query-loop {
			"className":"suki-comments"
		} --><div class="wp-block-comments-query-loop suki-comments">

			<!-- wp:comments-title /-->

			<!-- wp:comment-template {
				"className":"suki-comments__template"
			} -->

				<!-- wp:group {
					"layout":{
						"type":"flex",
						"orientation":"vertical"
					}
				} --><div class="wp-block-group">

					<!-- wp:group {
						"layout":{
							"type":"flex",
							"flexWrap":"nowrap"
						},
						"style":{
							"spacing":{
								"blockGap":"1em"
							}
						}
					} --><div class="wp-block-group">

						<!-- wp:avatar {
							"size":50,
							"style":{
								"border":{
									"radius":"50%"
								}
							}
						} /-->
				
						<!-- wp:group {
							"layout":{
								"type":"default"
							}
						} --><div class="wp-block-group">

							<!-- wp:comment-author-name {
								"className":"suki-h6"
							} /-->
				
							<!-- wp:group {
								"style":{
									"spacing":{
										"margin":{
											"top":"0px",
											"bottom":"0px"
										},
										"blockGap":"0.75em"
									}
								},
								"className":"suki-meta suki-reverse-link-color",
								"layout":{
									"type":"flex"
								}
							} --><div class="wp-block-group suki-meta suki-reverse-link-color" style="margin-top:0px;margin-bottom:0px">
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
				"layout":{
					"type":"flex",
					"orientation":"horizontal",
					"justifyContent":"center"
				},
				"className":"suki-comments__pagination"
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
		';

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
