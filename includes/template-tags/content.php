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
	 * @param string  $main_content    Main content.
	 * @param string  $sidebar_context Sidebar context.
	 * @param boolean $do_blocks       Parse blocks or not.
	 * @param boolean $echo            Render or return.
	 * @return string
	 */
	function suki_content( $main_content, $sidebar_context = '', $do_blocks = true, $echo = true ) {
		ob_start();

		/**
		 * Hero section
		 *
		 * Note: Styles are configured via Customizer options.
		 */
		suki_hero( false );

		/**
		 * Content section
		 *
		 * Note: Styles are configured via Customizer options.
		 */

		$classes = implode(
			' ',
			array(
				'suki-content',
				'site-content',
				'suki-section--' . suki_get_current_page_setting( 'content_container' ),
				suki_current_page_has_sidebar() ? 'suki-content--layout-' . suki_get_current_page_setting( 'content_layout' ) : '',
			)
		);
		?>
		<!-- wp:group {
			"className":"<?php echo esc_attr( $classes ); ?>",
			"layout":{
				"inherit":<?php echo esc_attr( suki_current_page_has_sidebar() ? true : false ); ?>
			}
		} --><div id="content" class="wp-block-group <?php echo esc_attr( $classes ); ?>">

			<?php
			/**
			 * Content with sidebar wrapper -- Open
			 *
			 * Note: Styles are configured via CSS class and Customizer options.
			 */
			if ( suki_current_page_has_sidebar() ) {
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
			 * Main area
			 */
			?>
			<!-- wp:group {
				"tagName":"main",
				"className":"site-main"
			} --><main id="primary" class="wp-block-group site-main">

				<?php
				/**
				 * Before main content
				 */
				if ( has_action( 'suki/frontend/before_main' ) ) {
					?>
					<!-- wp:group {
						"layout":{
							"inherit":true
						}
					} --><div class="wp-block-group">

						<?php
						/**
						 * Hook: suki/frontend/before_main
						 */
						do_action( 'suki/frontend/before_main' );
						?>

					</div><!-- /wp:group -->
					<?php
				}

				/**
				 * Main content
				 */
				echo $main_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

				/**
				 * After main content
				 */
				if ( has_action( 'suki/frontend/after_main' ) ) {
					?>
					<!-- wp:group {
						"layout":{
							"inherit":true
						}
					} --><div class="wp-block-group">

						<?php
						/**
						 * Hook: suki/frontend/after_main
						 */
						do_action( 'suki/frontend/after_main' );
						?>

					</div><!-- /wp:group -->
					<?php
				}
				?>

			</main><!-- /wp:group -->
			<?php

			/**
			 * Content with sidebar wrapper -- Close
			 */
			if ( suki_current_page_has_sidebar() ) {
				?>
					</div><!-- /wp:column -->

					<!-- wp:column {
						"verticalAlignment":"top",
						"className":"suki-sidebar-column"
					} --><div class="wp-block-column is-vertically-aligned-top suki-sidebar-column">

						<?php
						/**
						 * Sidebar area
						 */
						get_sidebar( $sidebar_context );
						?>

					</div><!-- /wp:column -->

				</div><!-- /wp:columns -->
				<?php
			}
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
 * Hero section
 */
if ( ! function_exists( 'suki_hero' ) ) {
	/**
	 * Render hero section.
	 *
	 * @param boolean $do_blocks Parse blocks or not.
	 * @param boolean $echo      Render or return.
	 * @return string
	 */
	function suki_hero( $do_blocks = true, $echo = true ) {
		ob_start();

		$elements = suki_get_current_page_setting( 'content_header', array() );

		if ( 0 < count( $elements ) ) { // Content header has at least 1 element.
			$container = suki_get_current_page_setting( 'hero_container' );

			if ( 'content' === $container ) {
				$container = suki_get_current_page_setting( 'content_container' ) . ' suki-hero--inherit-content-container';
			}

			$classes = 'suki-hero entry-header ' . esc_attr( 'suki-section--' . $container );
			?>
			<!-- wp:group {
				"className":"<?php echo esc_attr( $classes ); ?>",
				"layout":{
					"inherit":true
				}
			} --><div id="hero" class="wp-block-group <?php echo esc_attr( $classes ); ?>">

				<?php
				suki_content_header( false );
				?>

			</div><!-- /wp:group -->
			<?php
		}
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
 * Content header
 */
if ( ! function_exists( 'suki_content_header' ) ) {
	/**
	 * Render content header.
	 *
	 * @param boolean $do_blocks Parse blocks or not.
	 * @param boolean $echo      Render or return.
	 * @return string
	 */
	function suki_content_header( $do_blocks = true, $echo = true ) {
		ob_start();

		$elements = suki_get_current_page_setting( 'content_header', array() );

		if ( 0 < count( $elements ) ) { // Content header has at least 1 element.
			foreach ( $elements as $element ) {
				suki_content_header_element( $element, suki_get_current_page_setting( 'content_header_alignment' ), false );
			}
		}
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
 * Content footer
 */
if ( ! function_exists( 'suki_content_footer' ) ) {
	/**
	 * Render content footer.
	 *
	 * @param boolean $do_blocks Parse blocks or not.
	 * @param boolean $echo      Render or return.
	 * @return string
	 */
	function suki_content_footer( $do_blocks = true, $echo = true ) {
		ob_start();

		$elements = suki_get_current_page_setting( 'content_footer', array() );

		if ( 0 < count( $elements ) ) { // Content footer has at least 1 element.
			foreach ( $elements as $element ) {
				suki_content_footer_element( $element, suki_get_current_page_setting( 'content_footer_alignment' ), false );
			}
		}
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
	 * @param boolean $do_blocks Parse blocks or not.
	 * @param boolean $echo      Render or return.
	 * @return string
	 */
	function suki_content_header_element( $element, $alignment = 'left', $do_blocks = true, $echo = true ) {
		// Abort if element slug is empty.
		if ( empty( $element ) ) {
			return;
		}

		$html = '';

		switch ( $element ) {
			case 'title':
				$level = is_front_page() ? 2 : 1; // In front page, logo is the <h1>, so we use <h2> for this title.

				/**
				 * Singular page title.
				 *
				 * Use `core/post-title` block.
				 */
				if ( is_singular() ) {
					$html = '
					<!-- wp:post-title {
						"level":' . esc_attr( $level ) . ',
						"textAlign":"' . esc_attr( $alignment ) . '",
						"className":"entry-title suki-title"
					} /-->
					';
				}

				/**
				 * Search results page.
				 *
				 * Use `core/heading` block, as there `core/query-title` block for `search` type uses a fixed text and can't be modified via any filter.
				 * The customized text is processed here.
				 */
				if ( is_search() ) {
					// Get custom title format.
					$customized_format = suki_get_current_page_setting( 'title_text' );

					if ( ! empty( $customized_format ) ) {
						// Parse format.
						$title = preg_replace( '/\{\{keyword\}\}/', '<span>' . get_search_query() . '</span>', $customized_format );
					} else {
						$title = sprintf(
							/* translators: %s: search keyword. */
							esc_html__( 'Search results for: %s', 'suki' ),
							'<span>' . get_search_query() . '</span>'
						);
					}

					$html = '
					<!-- wp:heading {
						"level":' . esc_attr( $level ) . ',
						"textAlign":"' . esc_attr( $alignment ) . '",
						"className":"entry-title suki-title"
					} --><h' . esc_attr( $level ) . ' class="has-text-align-' . esc_attr( $alignment ) . ' entry-title suki-title">' . $title . '</h' . esc_attr( $level ) . '><!-- /wp:heading -->
					';
				}

				/**
				 * Archive pages (custom post type, term archive, author archive, date archive).
				 *
				 * Use `core/query-title` block.
				 * The customized text would be applied via `get_the_archive_title` filter.
				 */
				if ( is_archive() ) {
					$html = '
					<!-- wp:query-title {
						"type":"archive",
						"level":' . esc_attr( $level ) . ',
						"textAlign":"' . esc_attr( $alignment ) . '",
						"className":"entry-title suki-title"
					} /-->
					';
				}

				/**
				 * Blog posts page.
				 *
				 * Use `core/heading` block, as there is no specific block for blog posts page title.
				 * The customized text is processed here.
				 */
				if ( is_home() ) {
					// Get custom title format.
					$customized_format = suki_get_current_page_setting( 'title_text' );

					if ( ! empty( $customized_format ) ) {
						// Parse title format.
						$title = str_replace( '{{post_type}}', get_post_type_object( get_post_type() )->labels->name, $customized_format );
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

					$html = '
					<!-- wp:heading {
						"level":' . esc_attr( $level ) . ',
						"textAlign":"' . esc_attr( $alignment ) . '",
						"className":"entry-title suki-title"
					} --><h' . esc_attr( $level ) . ' class="has-text-align-' . esc_attr( $alignment ) . ' entry-title suki-title">' . $title . '</h' . esc_attr( $level ) . '><!-- /wp:heading -->
					';
				}
				break;

			case 'archive-description':
				if ( is_author() ) {
					$html = '
					<!-- wp:post-author-biography {
						"textAlign":"' . esc_attr( $alignment ) . '"
					} /-->
					';
				} else {
					$html = '
					<!-- wp:term-description {
						"textAlign":"' . esc_attr( $alignment ) . '"
					} /-->
					';
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
		 * @param string $html      HTML markup.
		 * @param string $element   Element slug.
		 * @param string $alignment Element alignment (left, center, or right).
		 */
		$html = apply_filters( 'suki/frontend/content_header_element', $html, $element, $alignment );

		/**
		 * Filter: suki/frontend/content_header_element/{$element}
		 *
		 * @param string $html      HTML markup.
		 * @param string $alignment Element alignment (left, center, or right).
		 */
		$html = apply_filters( 'suki/frontend/content_header_element/' . $element, $html, $alignment );

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
	 * @param boolean $do_blocks Parse blocks or not.
	 * @param boolean $echo      Render or return.
	 * @return string
	 */
	function suki_content_footer_element( $element, $alignment = 'left', $do_blocks = true, $echo = true ) {
		// Abort if element slug is empty.
		if ( empty( $element ) ) {
			return;
		}

		$html = '';

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
