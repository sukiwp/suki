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
	 * Hero section contains content header elements and only visible visually. Screen reader will ignore this section due to the `aria-hidden="true"` attribute.
	 * When hero section is active, theme will add another visually hidden content header (with `.screen-reader-text` class) inside the `<main>` tag.
	 * This provides better semantic hierarchy.
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
				$container = suki_get_current_page_setting( 'content_container' ) . ' .suki-hero--inherit-content-container';
			}

			$classes = 'suki-hero entry-header ' . esc_attr( 'suki-section--' . $container );
			?>
			<!-- wp:group {
				"className":"<?php echo esc_attr( $classes ); ?>",
				"layout":{
					"inherit":true
				}
			} --><div id="hero" class="wp-block-group <?php echo esc_attr( $classes ); ?>" aria-hidden="true">

				<?php
				foreach ( $elements as $element ) {
					suki_content_header_element( $element, suki_get_current_page_setting( 'content_header_alignment' ), false );
				}
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
			if ( suki_current_page_has_hero_section() ) {
				$classes = suki_current_page_has_hero_section() ? 'screen-reader-text' : '';
				?>
				<!-- wp:group {
					"className":"<?php echo esc_attr( $classes ); ?>"
				} --><div class="wp-block-group <?php echo esc_attr( $classes ); ?>">

					<?php
					foreach ( $elements as $element ) {
						suki_content_header_element( $element, suki_get_current_page_setting( 'content_header_alignment' ), false );
					}
					?>

				</div><!-- /wp:group -->
				<?php
			} else {
				foreach ( $elements as $element ) {
					suki_content_header_element( $element, suki_get_current_page_setting( 'content_header_alignment' ), false );
				}
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
 * Content thumbnail
 */
if ( ! function_exists( 'suki_content_thumbnail' ) ) {
	/**
	 * Render content thumbnail.
	 *
	 * @param boolean $do_blocks Parse blocks or not.
	 * @param boolean $echo      Render or return.
	 * @return string
	 */
	function suki_content_thumbnail( $do_blocks = true, $echo = true ) {
		ob_start();
		?>
		<!-- wp:group {
			"className":"entry-thumbnail",
			"layout":{
				"inherit":true
			}
		} --><div class="wp-block-group entry-thumbnail">

			<!-- wp:post-featured-image {
					<?php echo esc_attr( boolval( suki_get_current_page_setting( 'content_thumbnail_wide' ) ) ? '"align":"wide",' : '' ); ?>
				"className":"entry-thumbnail"
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
					$level = is_front_page() ? 2 : 1; // In front page, logo is the <h1>, so we use <h2> for this title.

					$html = '
					<!-- wp:heading {
						"level":' . $level . ',
						"textAlign":"' . $alignment . ',
						"className":"entry-title suki-title"
					} --><h' . $level . ' class="has-text-align-' . $alignment . ' entry-title suki-title">' . $title . '</h' . $level . '><!-- /wp:heading -->
					';
				}
				break;

			case 'archive-description':
				// We can't replace this with Gutenberg block yet, because it doesn't cover Author and Post Type archive description.
				if ( ! is_post_type_archive() ) {
					$html = trim( get_the_archive_description() );
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
