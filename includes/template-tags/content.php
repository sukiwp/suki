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
 * Render content section with the specified main content.
 *
 * Notes:
 * - Theme uses `.suki-content-sidebar-columns` class to add / override styles.
 * - Theme uses `.suki-sidebar-column` class to add / override styles.
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
	if ( suki_current_page_has_hero_section() ) {
		suki_hero( false );
	}

	/**
	 * Content section
	 *
	 * Note: Styles are configured via Customizer options.
	 */

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

	$padding = suki_get_theme_mod( 'content_padding' );

	$styles = array(
		'padding-top'    => $padding[0],
		'padding-right'  => $padding[1],
		'padding-bottom' => $padding[2],
		'padding-left'   => $padding[3],
	);
	?>
	<!-- wp:group {
		"style":{
			"layout":{
				"selfStretch":"fill",
				"flexSize":null
			},
			"spacing":{
				"padding":{
					"top":"<?php echo esc_attr( $padding[0] ); ?>",
					"right":"<?php echo esc_attr( $padding[1] ); ?>",
					"bottom":"<?php echo esc_attr( $padding[2] ); ?>",
					"left":"<?php echo esc_attr( $padding[3] ); ?>"
				}
			}
		},
		"layout":{
			<?php
			if ( suki_current_page_has_sidebar() ) {
				?>
				"type":"constrained",
				"contentSize":"<?php echo esc_attr( $content_size ); ?>"
				<?php
			} else {
				?>
				"type":"default"
				<?php
			}
			?>
		},
		"className":"suki-content site-content"
	} --><div id="content" class="wp-block-group suki-content site-content" <?php suki_element_style( $styles ); ?>>

		<?php
		/**
		 * Before main and sidebar
		 */
		if ( has_action( 'suki/frontend/before_primary_and_sidebar' ) ) {
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
				}
			} --><div class="wp-block-group">

				<?php
				/**
				 * Hook: suki/frontend/before_primary_and_sidebar
				 */
				do_action( 'suki/frontend/before_primary_and_sidebar' );
				?>

			</div><!-- /wp:group -->
			<?php
		}

		/**
		 * Content with sidebar wrapper -- Open
		 *
		 * Note: Styles are configured via CSS class and Customizer options.
		 */
		if ( suki_current_page_has_sidebar() ) {
			$sidebar_gap = suki_get_theme_mod( 'sidebar_gap' );

			$classes = 'suki-content-sidebar-columns suki-content-sidebar-columns--' . suki_get_current_page_setting( 'content_layout' );
			?>
			<!-- wp:columns {
				"style":{
					"spacing":{
						"blockGap":{
							"top":"<?php echo esc_attr( $sidebar_gap ); ?>",
							"left":"<?php echo esc_attr( $sidebar_gap ); ?>"
						}
					}
				},
				"className":"<?php echo esc_attr( $classes ); ?>"
			} --><div class="wp-block-columns <?php echo esc_attr( $classes ); ?>">

				<!-- wp:column {
					"className":"suki-main-column"
				} --><div class="wp-block-column suki-main-column">
			<?php
		}

		/**
		 * Main area
		 */
		?>
		<!-- wp:group {
			"tagName":"main",
			"layout":"default",
			"style":{
				"dimensions":{
					"minHeight":"100%"
				}
			},
			"className":"site-main"
		} --><main id="primary" class="wp-block-group site-main" style="min-height:100%">

			<?php
			/**
			 * Before main content
			 */
			if ( has_action( 'suki/frontend/before_main' ) ) {
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
			$sidebar_width = suki_get_theme_mod( 'sidebar_width' );
			?>
				</div><!-- /wp:column -->

				<!-- wp:column {
					"width":"<?php echo esc_attr( $sidebar_width ); ?>",
					"className":"suki-sidebar-column"
				} --><div class="wp-block-column suki-sidebar-column" style="flex-basis:<?php echo esc_attr( $sidebar_width ); ?>">

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

		/**
		 * After main and sidebar
		 */
		if ( has_action( 'suki/frontend/after_primary_and_sidebar' ) ) {
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
				}
			} --><div class="wp-block-group">

				<?php
				/**
				 * Hook: suki/frontend/after_primary_and_sidebar
				 */
				do_action( 'suki/frontend/after_primary_and_sidebar' );
				?>

			</div><!-- /wp:group -->
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

/**
 * Render hero section.
 *
 * Notes:
 * - Theme uses `.suki-hero` class to add / override styles.
 *
 * @todo Remove additional `core/group` block to wrap the `suki-canvas` when `core/cover` block already supports layout's content width options.
 *
 * @param boolean $do_blocks Parse blocks or not.
 * @param boolean $echo      Render or return.
 * @return string
 */
function suki_hero( $do_blocks = true, $echo = true ) {
	// Abort if it is a blog posts home and content header is disabled in blog posts home.
	if ( is_home() && ! boolval( suki_get_theme_mod( 'post_archive_home_content_header' ) ) ) {
		return;
	}

	// Abort if Hero section is not enabled.
	if ( ! boolval( suki_get_current_page_setting( 'hero' ) ) ) {
		return;
	}

	ob_start();

	$container = suki_get_current_page_setting( 'hero_container' );
	if ( 'inherit' === $container ) {
		$container = suki_get_current_page_setting( 'content_container' );
	}

	$content_size = '';
	if ( 'full' === $container ) {
		$content_size = '100%';
	} elseif ( 'wide' === $container ) {
		$content_size = 'var(--wp--style--global--wide-size)';
	}

	$min_height = suki_get_theme_mod( 'hero_height' );
	$min_height = empty( $min_height ) ? '0px' : $min_height;

	$padding = suki_get_theme_mod( 'hero_padding' );
	$border  = suki_get_theme_mod( 'hero_border' );

	$bg_mode           = suki_get_current_page_setting( 'hero_bg' );
	$bg_image          = suki_get_current_page_setting( 'hero_bg_image' );
	$bg_image_url      = wp_get_original_image_url( $bg_image );
	$bg_image_parallax = 'fixed' === suki_get_theme_mod( 'hero_bg_attachment' ) ? true : false;

	$has_bg_image = ( 'thumbnail' === $bg_mode && has_post_thumbnail() ) || ! empty( $bg_image_url );

	$bg_color     = suki_parse_color_value_for_block_attributes( suki_get_theme_mod( 'hero_bg_color' ), 'background' );
	$text_color   = suki_parse_color_value_for_block_attributes( suki_get_theme_mod( 'hero_text_color' ), 'text' );
	$border_color = suki_parse_color_value_for_block_attributes( suki_get_theme_mod( 'hero_border_color' ), 'border' );
	$link_color   = suki_parse_color_value_for_block_attributes( suki_get_theme_mod( 'hero_link_color' ), 'link' );

	$bg_color_overlay_dim = suki_get_theme_mod( 'hero_bg_color_overlay_dim', 0 );

	$block_styles = array(
		'min-height'          => $min_height,
		'padding-top'         => '0px',
		'padding-right'       => '0px',
		'padding-bottom'      => '0px',
		'padding-left'        => '0px',
		'border-top-width'    => $border[0],
		'border-right-width'  => $border[1],
		'border-bottom-width' => $border[2],
		'border-left-width'   => $border[3],
		'color'               => $text_color['custom_value'],
		'border-color'        => $border_color['custom_value'],
	);

	$block_classes = array_merge(
		array(
			boolval( $bg_image_parallax ) ? 'has-parallax' : '',
		),
		$text_color['classes'],
		$border_color['classes'],
		$link_color['classes'],
	);

	$overlay_styles = array(
		'background-color' => $bg_color['custom_value'],
	);

	$overlay_classes = array_merge(
		$bg_color['classes'],
		array(
			'has-background-dim-' . ( $has_bg_image ? $bg_color_overlay_dim : 100 ),
			'has-background-dim',
		)
	);

	$inner_styles = array(
		'padding-top'    => $padding[0],
		'padding-right'  => $padding[1],
		'padding-bottom' => $padding[2],
		'padding-left'   => $padding[3],
	);
	?>
	<!-- wp:cover {
		<?php
		// Background image.
		if ( 'thumbnail' === $bg_mode ) {
			// Use featured image as background.
			?>
			"useFeaturedImage":true,
			<?php
		} else {
			// Defined background image.
			if ( ! empty( $bg_image_url ) ) {
				?>
				"url":"<?php echo esc_attr( $bg_image_url ); ?>",
				"id":<?php echo esc_attr( $bg_image ); ?>,
				<?php
			}
		}
		?>
		"isRepeated":false,
		"hasParallax":<?php echo esc_attr( boolval( $bg_image_parallax ) ? 'true' : 'false' ); ?>,
		"contentPosition":"center center",
		<?php
		// Background color.
		if ( false !== $bg_color['custom_value'] ) {
			?>
			"customOverlayColor":"<?php echo esc_attr( $bg_color['custom_value'] ); ?>",
			<?php
		} else {
			?>
			"overlayColor":"<?php echo esc_attr( $bg_color['preset_value'] ); ?>",
			<?php
		}
		?>
		"dimRatio":<?php echo esc_attr( $bg_color_overlay_dim ); ?>,
		"isDark":false,
		<?php
		if ( ! empty( $min_height ) ) {
			$min_height_number = floatval( $min_height );
			$min_height_unit   = str_replace( $min_height_number, '', $min_height );
			?>
			"minHeight":"<?php echo esc_attr( $min_height_number ); ?>",
			"minHeightUnit":"<?php echo esc_attr( $min_height_unit ); ?>",
			<?php
		}
		?>
		"style":{
			"spacing":{
				"padding":{
					"top":"0px",
					"right":"0px",
					"bottom":"0px",
					"left":"0px"
				}
			}
		},
		"className":"suki-hero <?php suki_element_class( $block_classes, false ); ?>"
	} --><div class="wp-block-cover is-light suki-hero <?php suki_element_class( $block_classes, false ); ?>" <?php suki_element_style( $block_styles ); ?>>

		<span aria-hidden="true" class="wp-block-cover__background <?php suki_element_class( $overlay_classes, false ); ?>" <?php suki_element_style( $overlay_styles ); ?>></span>

		<?php
		if ( 'thumbnail' !== $bg_mode && ! empty( $bg_image_url ) ) {
			$bg_classes = array(
				'wp-image-' . $bg_image,
			);
			if ( boolval( $bg_image_parallax ) || boolval( $bg_image_repeat ) ) {
				if ( boolval( $bg_image_parallax ) ) {
					$bg_classes[] = 'has-parallax';
				}
				if ( boolval( $bg_image_repeat ) ) {
					$bg_classes[] = 'is-repeated';
				}
				?>
				<div role="img" class="wp-block-cover__image-background <?php echo esc_attr( implode( ' ', $bg_classes ) ); ?>" style="background-position:50% 50%;background-image:url(<?php echo esc_attr( $bg_image_url ); ?>)"></div>
				<?php
			} else {
				?>
				<img class="wp-block-cover__image-background <?php echo esc_attr( implode( ' ', $bg_classes ) ); ?>" alt="" src="<?php echo esc_attr( $bg_image_url ); ?>" data-object-fit="cover"/>
				<?php
			}
		}
		?>

		<div class="wp-block-cover__inner-container">

			<!-- wp:group {
				"layout":{
					"type":"constrained",
					"contentSize":"<?php echo esc_attr( $content_size ); ?>"
				},
				"style":{
					"spacing":{
						"blockGap":"0.75rem",
						"padding":{
							"top":"<?php echo esc_attr( $padding[0] ); ?>",
							"right":"<?php echo esc_attr( $padding[1] ); ?>",
							"bottom":"<?php echo esc_attr( $padding[2] ); ?>",
							"left":"<?php echo esc_attr( $padding[3] ); ?>"
						}
					}
				}
			} --><div class="wp-block-group" <?php suki_element_style( $inner_styles ); ?>>

				<?php
				suki_content_header( false );
				?>

			</div><!-- /wp:group -->

		</div>

	</div><!-- /wp:cover -->
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

/**
 * Render content header.
 *
 * @param boolean $do_blocks Parse blocks or not.
 * @param boolean $echo      Render or return.
 * @return string
 */
function suki_content_header( $do_blocks = true, $echo = true ) {
	ob_start();

	// Render all content header elements.
	foreach ( suki_get_current_page_setting( 'content_header', array() ) as $element ) {
		suki_content_header_element( $element, suki_get_current_page_setting( 'content_header_alignment' ), false );
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

/**
 * Render content footer.
 *
 * @param boolean $do_blocks Parse blocks or not.
 * @param boolean $echo      Render or return.
 * @return string
 */
function suki_content_footer( $do_blocks = true, $echo = true ) {
	ob_start();

	// Render all content footer elements.
	foreach ( suki_get_current_page_setting( 'content_footer', array() ) as $element ) {
		suki_content_footer_element( $element, suki_get_current_page_setting( 'content_footer_alignment' ), false );
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
					"className":"suki-title"
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
					"className":"suki-title"
				} --><h' . esc_attr( $level ) . ' class="has-text-align-' . esc_attr( $alignment ) . ' suki-title">' . $title . '</h' . esc_attr( $level ) . '><!-- /wp:heading -->
				';
			}

			/**
			 * Archive pages (custom post type, term archive, author archive, date archive).
			 *
			 * Use `core/query-title` block.
			 * The customized text would be applied via `get_the_archive_title` filter.
			 */
			if ( is_archive() ) {
				if ( is_author() ) {
					$title_font_size        = suki_get_theme_mod( 'title_font_size', suki_get_theme_mod( 'h1_font_size' ) );
					$title_font_size_number = floatval( $title_font_size );

					$avatar_size = str_replace( $title_font_size_number, 1.5 * $title_font_size_number, $title_font_size );
					$avatar_gap  = str_replace( $title_font_size_number, 0.5 * $title_font_size_number, $title_font_size );

					$html = '
					<!-- wp:columns {
						"isStackedOnMobile":false,
						"verticalAlignment":"center",
						"style":{
							"spacing":{
								"blockGap":"' . $avatar_gap . '"
							}
						}
					} --><div class="wp-block-columns is-not-stacked-on-mobile are-vertically-aligned-center">

						<!-- wp:column {
							"width":"' . $avatar_size . '",
							"verticalAlignment":"center"
						} --><div class="wp-block-column is-vertically-aligned-center" style="flex-basis:' . $avatar_size . '">

							<!-- wp:avatar {
								"size":96,
								"style":{
									"border":{
										"radius":"50%"
									}
								}
							} /-->

						</div><!-- /wp:column -->

						<!-- wp:column {
							"verticalAlignment":"center"
						} -->
						<div class="wp-block-column is-vertically-aligned-center">

							<!-- wp:query-title {
								"type":"archive",
								"level":' . esc_attr( $level ) . ',
								"textAlign":"' . esc_attr( $alignment ) . '",
								"className":"suki-title"
							} /-->

						</div><!-- /wp:column -->

					</div><!-- /wp:columns -->
					';
				} else {
					$html = '
					<!-- wp:query-title {
						"type":"archive",
						"level":' . esc_attr( $level ) . ',
						"textAlign":"' . esc_attr( $alignment ) . '",
						"className":"suki-title"
					} /-->
					';
				}
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
					"className":"suki-title"
				} --><h' . esc_attr( $level ) . ' class="has-text-align-' . esc_attr( $alignment ) . ' suki-title">' . $title . '</h' . esc_attr( $level ) . '><!-- /wp:heading -->
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
			// TODO: Convert to `Search` block.
			$html = get_search_form( array( 'echo' => false ) );
			break;

		case 'header-meta':
			$html = suki_entry_meta( suki_get_current_page_setting( 'content_header_meta' ), $alignment, false, false );
			break;

		case 'hr':
			$html = '
			<!-- wp:separator {
				"backgroundColor":"base-3",
				"className":"is-style-wide"
			} --><hr class="wp-block-separator has-text-color has-base-3-color has-alpha-channel-opacity has-base-3-background-color has-background is-style-wide"/><!-- /wp:separator -->
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
				"textAlign":"' . $alignment . '",
				"textColor":"contrast-3",
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
			';
			break;

		case 'footer-meta':
			$html = suki_entry_meta( suki_get_current_page_setting( 'content_footer_meta' ), $alignment, false, false );
			break;

		case 'hr':
			$html = '
			<!-- wp:separator {
				"backgroundColor":"base-3",
				"className":"is-style-wide"
			} --><hr class="wp-block-separator has-text-color has-base-3-color has-alpha-channel-opacity has-base-3-background-color has-background is-style-wide"/><!-- /wp:separator -->
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
