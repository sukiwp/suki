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
	 * @param boolean $do_blocks    Parse blocks or not.
	 * @param boolean $echo         Render or return.
	 * @return string
	 */
	function suki_content( $main_content, $do_blocks = true, $echo = true ) {
		$has_sidebar = 'narrow' !== suki_get_current_page_setting( 'content_container' ) && in_array( suki_get_current_page_setting( 'content_layout' ), array( 'left-sidebar', 'right-sidebar' ), true );

		$classes = implode(
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
			"className":"<?php echo esc_attr( $classes ); ?>",
			"layout":{
				"inherit":true
			}
		} --><div id="content" class="wp-block-group alignfull <?php echo esc_attr( $classes ); ?>">

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
 * Hero section
 */
if ( ! function_exists( 'suki_hero' ) ) {
	/**
	 * Render page header section.
	 *
	 * @param boolean $do_blocks Parse blocks or not.
	 * @param boolean $echo      Render or return.
	 * @return string
	 */
	function suki_hero( $do_blocks = true, $echo = true ) {
		ob_start();

		$classes = 'suki-hero ' . esc_attr( 'suki-section-' . suki_get_current_page_setting( 'hero_container' ) );

		if (
			boolval( suki_get_current_page_setting( 'hero' ) ) && // Hero section is enabled.
			has_action( 'suki/frontend/hero' ) // Hero section has at least 1 attached action.
		) {
			?>
			<!-- wp:group {
				"align":"full",
				"className":"<?php echo esc_attr( $classes ); ?>",
				"layout":{
					"inherit":true
				}
			} --><div id="hero" class="wp-block-group alignfull <?php echo esc_attr( $classes ); ?>" role="region" aria-label="<?php esc_attr_e( 'Hero Section', 'suki' ); ?>">

				<?php
				/**
				 * Hook: suki/frontend/hero
				 *
				 * @hooked suki_content_header - 10
				 */
				do_action( 'suki/frontend/hero' );
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
						"level":1,
						"textAlign":"' . $alignment . '
						"className":"entry-title suki-title"
					} --><h2 class="has-text-align-' . $alignment . ' entry-title suki-title">' . $title . '</h2><!-- /wp:heading -->
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
