<?php
/**
 * Footer section template rendering functions.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Footer section
 */
if ( ! function_exists( 'suki_footer' ) ) {
	/**
	 * Render footer.
	 *
	 * Notes:
	 * - Action Hooks API is used to to register footer sections and allow further modifications in Child Theme or 3rd party plugin.
	 * - `suki-header` CSS class handles these styles: blockGap (0px).
	 * - `aria-label`, `itemscope`, `itemtype` attributes are added manually.
	 *
	 * @param boolean $do_blocks Parse blocks or not.
	 * @param boolean $echo      Render or return.
	 * @return string
	 */
	function suki_footer( $do_blocks = true, $echo = true ) {
		ob_start();

		if ( has_action( 'suki/frontend/footer' ) ) { // Footer has at least 1 attached action.
			?>
			<!-- wp:group {
				"tagName":"footer",
				"layout":{
					"type":"default"
				},
				"style":{
					"spacing":{
						"blockGap":"0px"
					}
				},
				"className":"suki-footer site-footer"
			} --><footer id="colophon" class="wp-block-group suki-footer site-footer" aria-label="<?php esc_attr_e( 'Site Footer', 'suki' ); ?>" itemscope itemtype="https://schema.org/WPFooter">

				<?php
				/**
				 * Hook: suki/frontend/footer
				 *
				 * @hooked suki_footer_widgets - 10
				 * @hooked suki_footer_bottom - 10
				 */
				do_action( 'suki/frontend/footer' );
				?>

			</footer><!-- /wp:group -->
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
 * Footer widgets
 */
if ( ! function_exists( 'suki_footer_widgets' ) ) {
	/**
	 * Render footer widgets area.
	 *
	 * @param boolean $do_blocks Parse blocks or not.
	 * @param boolean $echo      Render or return.
	 * @return string
	 */
	function suki_footer_widgets( $do_blocks = true, $echo = true ) {
		// Abort if "disabled footer widgets" option is enabled.
		if ( boolval( suki_get_current_page_setting( 'disable_footer_widgets' ) ) ) {
			return;
		}

		$columns = intval( suki_get_theme_mod( 'footer_widgets_bar' ) );

		// Abort if columns number is set to 0.
		if ( 1 > $columns ) {
			return;
		}

		ob_start();

		$container = suki_get_theme_mod( 'footer_widgets_bar_container' );

		$content_size = '';
		if ( 'full' === $container ) {
			$content_size = '100%';
		} elseif ( 'wide' === $container ) {
			$content_size = 'var(--wp--style--global--wide-size)';
		}

		$padding = suki_get_theme_mod( 'footer_widgets_bar_padding' );
		$border  = suki_get_theme_mod( 'footer_widgets_bar_border' );

		$bg_color     = suki_parse_color_value_for_block_attributes( suki_get_theme_mod( 'footer_widgets_bar_bg_color' ), 'background' );
		$text_color   = suki_parse_color_value_for_block_attributes( suki_get_theme_mod( 'footer_widgets_bar_text_color' ), 'text' );
		$border_color = suki_parse_color_value_for_block_attributes( suki_get_theme_mod( 'footer_widgets_bar_border_color' ), 'border' );
		$link_color   = suki_parse_color_value_for_block_attributes( suki_get_theme_mod( 'footer_widgets_bar_link_color' ), 'link' );

		$classes = array_merge(
			$bg_color['classes'],
			$text_color['classes'],
			$border_color['classes'],
			$link_color['classes'],
		);

		$styles = array(
			'padding-top'         => $padding[0],
			'padding-right'       => $padding[1],
			'padding-bottom'      => $padding[2],
			'padding-left'        => $padding[3],
			'border-top-width'    => $border[0],
			'border-right-width'  => $border[1],
			'border-bottom-width' => $border[2],
			'border-left-width'   => $border[3],
			'background-color'    => $bg_color['custom_value'],
			'color'               => $text_color['custom_value'],
			'border-color'        => $border_color['custom_value'],
		);
		?>
		<!-- wp:group {
			"layout":{
				"type":"constrained",
				"contentSize":"<?php echo esc_attr( $content_size ); ?>"
			},
			"styles": {
				"border":{
					"top":{
						"color":"<?php echo esc_attr( false !== $border_color['preset_value'] ? 'var:preset|color|' . $border_color['preset_value'] : $border_color['custom_value'] ); ?>",
						"width":"<?php echo esc_attr( $border[0] ); ?>"
					},
					"right":{
						"color":"<?php echo esc_attr( false !== $border_color['preset_value'] ? 'var:preset|color|' . $border_color['preset_value'] : $border_color['custom_value'] ); ?>",
						"width":"<?php echo esc_attr( $border[1] ); ?>"
					},
					"bottom":{
						"color":"<?php echo esc_attr( false !== $border_color['preset_value'] ? 'var:preset|color|' . $border_color['preset_value'] : $border_color['custom_value'] ); ?>",
						"width":"<?php echo esc_attr( $border[2] ); ?>"
					},
					"left":{
						"color":"<?php echo esc_attr( false !== $border_color['preset_value'] ? 'var:preset|color|' . $border_color['preset_value'] : $border_color['custom_value'] ); ?>",
						"width":"<?php echo esc_attr( $border[3] ); ?>"
					}
				},
				"color":{
					"background":"<?php echo esc_attr( $bg_color['custom_value'] ); ?>",
					"text":"<?php echo esc_attr( $text_color['custom_value'] ); ?>"
				},
				"elements":{
					"link":{
						"color":{
							"text":"<?php echo esc_attr( false !== $link_color['preset_value'] ? 'var:preset|color|' . $link_color['preset_value'] : $link_color['custom_value'] ); ?>"
						}
					}
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
			"textColor":"<?php echo esc_attr( $text_color['preset_value'] ); ?>",
			"backgroundColor":"<?php echo esc_attr( $bg_color['preset_value'] ); ?>",
			"className":"suki-footer-widgets-bar <?php suki_element_class( $classes, false ); ?>"
		} --><div class="wp-block-group suki-footer-widgets-bar <?php suki_element_class( $classes, false ); ?>" <?php suki_element_style( $styles ); ?>>

			<!-- wp:columns {
				"verticalAlignment":"top"
			} --><div class="wp-block-columns are-vertically-aligned-top">

				<?php
				for ( $i = 1; $i <= $columns; $i++ ) {
					?>
					<!-- wp:column {
						"verticalAlignment":"top",
						"className":"<?php echo esc_attr( 'suki-footer-widgets-bar__column--' . $i ); ?>"
					} --><div class="wp-block-column is-vertically-aligned-top <?php echo esc_attr( 'suki-footer-widgets-bar__column--' . $i ); ?>">

						<?php
						if ( is_active_sidebar( 'footer-widgets-' . $i ) ) {
							dynamic_sidebar( 'footer-widgets-' . $i );
						}
						?>

					</div><!-- /wp:column -->
					<?php
				}
				?>

			</div><!-- /wp:columns -->

			<?php
			if ( boolval( suki_get_theme_mod( 'footer_bottom_bar_merged' ) ) ) {
				$bottom_bar_gap = suki_get_theme_mod( 'footer_bottom_bar_merged_gap' );

				if ( 0 < $bottom_bar_gap ) {
					?>
					<!-- wp:spacer {
						"height":"<?php echo esc_attr( $bottom_bar_gap ); ?>"
					} --><div style="height:<?php echo esc_attr( $bottom_bar_gap ); ?>" aria-hidden="true" class="wp-block-spacer"></div><!-- /wp:spacer -->
					<?php
				}

				suki_footer_bottom( false );
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
 * Footer bottom
 */
if ( ! function_exists( 'suki_footer_bottom' ) ) {
	/**
	 * Render footer bottom bar.
	 *
	 * @param boolean $do_blocks Parse blocks or not.
	 * @param boolean $echo      Render or return.
	 * @return string
	 */
	function suki_footer_bottom( $do_blocks = true, $echo = true ) {
		// Abort if "disabled footer bottom" option is enabled.
		if ( boolval( suki_get_current_page_setting( 'disable_footer_bottom' ) ) ) {
			return;
		}

		// Get elements and make sure they are valid elements.
		$elements = array(
			'left'   => array_intersect( suki_get_theme_mod( 'footer_elements_bottom_left', array() ), array_keys( suki_get_footer_builder_elements() ) ),
			'center' => array_intersect( suki_get_theme_mod( 'footer_elements_bottom_center', array() ), array_keys( suki_get_footer_builder_elements() ) ),
			'right'  => array_intersect( suki_get_theme_mod( 'footer_elements_bottom_right', array() ), array_keys( suki_get_footer_builder_elements() ) ),
		);

		$has_center_column = 0 < count( $elements['center'] );

		// Abort if footer bottom has no element.
		if ( 1 > array_sum( array_map( 'count', $elements ) ) ) {
			return;
		}

		ob_start();

		$container = suki_get_theme_mod( 'footer_bottom_bar_container' );

		$content_size = '';
		if ( 'full' === $container ) {
			$content_size = '100%';
		} elseif ( 'wide' === $container ) {
			$content_size = 'var(--wp--style--global--wide-size)';
		}

		$padding = suki_get_theme_mod( 'footer_bottom_bar_padding' );
		$border  = suki_get_theme_mod( 'footer_bottom_bar_border' );

		$bg_color     = suki_parse_color_value_for_block_attributes( suki_get_theme_mod( 'footer_bottom_bar_bg_color' ), 'background' );
		$text_color   = suki_parse_color_value_for_block_attributes( suki_get_theme_mod( 'footer_bottom_bar_text_color' ), 'text' );
		$border_color = suki_parse_color_value_for_block_attributes( suki_get_theme_mod( 'footer_bottom_bar_border_color' ), 'border' );
		$link_color   = suki_parse_color_value_for_block_attributes( suki_get_theme_mod( 'footer_bottom_bar_link_color' ), 'link' );

		$classes = array_merge(
			$bg_color['classes'],
			$text_color['classes'],
			$border_color['classes'],
			$link_color['classes'],
		);

		$styles = array(
			'padding-top'         => $padding[0],
			'padding-right'       => $padding[1],
			'padding-bottom'      => $padding[2],
			'padding-left'        => $padding[3],
			'border-top-width'    => $border[0],
			'border-right-width'  => $border[1],
			'border-bottom-width' => $border[2],
			'border-left-width'   => $border[3],
			'background-color'    => $bg_color['custom_value'],
			'color'               => $text_color['custom_value'],
			'border-color'        => $border_color['custom_value'],
		);
		?>
		<!-- wp:group {
			"layout":{
				"type":"constrained",
				"contentSize":"<?php echo esc_attr( $content_size ); ?>"
			},
			"styles": {
				"border":{
					"top":{
						"color":"<?php echo esc_attr( false !== $border_color['preset_value'] ? 'var:preset|color|' . $border_color['preset_value'] : $border_color['custom_value'] ); ?>",
						"width":"<?php echo esc_attr( $border[0] ); ?>"
					},
					"right":{
						"color":"<?php echo esc_attr( false !== $border_color['preset_value'] ? 'var:preset|color|' . $border_color['preset_value'] : $border_color['custom_value'] ); ?>",
						"width":"<?php echo esc_attr( $border[1] ); ?>"
					},
					"bottom":{
						"color":"<?php echo esc_attr( false !== $border_color['preset_value'] ? 'var:preset|color|' . $border_color['preset_value'] : $border_color['custom_value'] ); ?>",
						"width":"<?php echo esc_attr( $border[2] ); ?>"
					},
					"left":{
						"color":"<?php echo esc_attr( false !== $border_color['preset_value'] ? 'var:preset|color|' . $border_color['preset_value'] : $border_color['custom_value'] ); ?>",
						"width":"<?php echo esc_attr( $border[3] ); ?>"
					}
				},
				"color":{
					"background":"<?php echo esc_attr( $bg_color['custom_value'] ); ?>",
					"text":"<?php echo esc_attr( $text_color['custom_value'] ); ?>"
				},
				"elements":{
					"link":{
						"color":{
							"text":"<?php echo esc_attr( false !== $link_color['preset_value'] ? 'var:preset|color|' . $link_color['preset_value'] : $link_color['custom_value'] ); ?>"
						}
					}
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
			"textColor":"<?php echo esc_attr( $text_color['preset_value'] ); ?>",
			"backgroundColor":"<?php echo esc_attr( $bg_color['preset_value'] ); ?>",
			"className":"suki-footer-bottom-bar <?php suki_element_class( $classes, false ); ?>"
		} --><div class="wp-block-group suki-footer-bottom-bar <?php suki_element_class( $classes, false ); ?>" <?php suki_element_style( $styles ); ?>>

			<!-- wp:group {
				"layout":{
					"type":"flex",
					"flexWrap":"nowrap",
					"justifyContent":"space-between"
				}
			} --><div class="wp-block-group">

				<?php
				foreach ( array_keys( $elements ) as $column ) {
					// Skip center column if it's empty.
					if ( 'center' === $column && ! $has_center_column ) {
						continue;
					}
					?>
					<!-- wp:group {
						"layout":{
							"type":"flex",
							"flexWrap":"nowrap",
							"justifyContent":"<?php echo esc_attr( $column ); ?>"
						},
						"style":{
							"dimensions":{
								"minHeight":"100%"
							},
							"layout":{
								"selfStretch":"<?php echo esc_attr( 'center' !== $column && $has_center_column ? 'fixed' : 'fit' ); ?>",
								"flexSize":"<?php echo esc_attr( 'center' !== $column && $has_center_column ? '50%' : 'null' ); ?>"
							}
						}
					} --><div class="wp-block-group">

						<?php
						foreach ( $elements[ $column ] as $element ) {
							suki_footer_element( $element, false );
						}
						?>

					</div><!-- /wp:group -->
					<?php
				}
				?>

			</div><!-- /wp:group -->

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
 * Footer bottom element
 */
if ( ! function_exists( 'suki_footer_element' ) ) {
	/**
	 * Render footer element.
	 *
	 * @param string  $element Element slug.
	 * @param boolean $do_blocks Parse blocks or not.
	 * @param boolean $echo      Render or return.
	 * @return string
	 */
	function suki_footer_element( $element, $do_blocks = true, $echo = true ) {
		// Abort if element slug is empty.
		if ( empty( $element ) ) {
			return;
		}

		// Classify element into its type.
		$type = preg_replace( '/-\d$/', '', $element );

		// Get footer element template.
		switch ( $type ) {
			case 'copyright':
				ob_start();
				$copyright = suki_get_theme_mod( 'footer_copyright_content' );
				$copyright = str_replace( '{{year}}', gmdate( 'Y' ), $copyright );
				$copyright = str_replace( '{{sitename}}', '<a href="' . esc_url( home_url() ) . '">' . get_bloginfo( 'name' ) . '</a>', $copyright );
				$copyright = str_replace( '{{theme}}', '<a href="' . suki_get_theme_info( 'url' ) . '">' . suki_get_theme_info( 'name' ) . '</a>', $copyright );
				$copyright = str_replace( '{{themeauthor}}', '<a href="' . suki_get_theme_info( 'author_url' ) . '">' . suki_get_theme_info( 'author' ) . '</a>', $copyright );
				$copyright = str_replace( '{{theme_author}}', '<a href="' . suki_get_theme_info( 'author_url' ) . '">' . suki_get_theme_info( 'author' ) . '</a>', $copyright );
				?>
				<!-- wp:group {
					"layout":{
						"type":"default"
					},
					"className":"<?php echo esc_attr( 'suki-footer-' . $element ); ?>"
				} --><div class="<?php echo esc_attr( 'suki-footer-' . $element ); ?>">

					<?php echo do_shortcode( $copyright ); ?>

				</div><!-- /wp:group -->
				<?php
				$html = ob_get_clean();
				break;

			case 'menu':
				$html = wp_nav_menu(
					array(
						'theme_location' => 'footer-' . $element,
						'menu_class'     => 'suki-footer-' . $element . ' suki-footer-menu menu suki-hover-menu',
						'container'      => false,
						'depth'          => -1,
						'fallback_cb'    => 'suki_unassigned_menu',
						/* translators: %s: menu number. */
						'items_wrap'     => '<ul class="%2$s" itemscope itemtype="https://schema.org/SiteNavigationElement" aria-label="' . sprintf( esc_attr__( 'Footer Menu %s', 'suki' ), str_replace( 'menu-', '', $element ) ) . '">%3$s</ul>',
						'echo'           => false,
					)
				);
				break;

			case 'social':
				ob_start();
				$items = suki_get_theme_mod( 'footer_social_links', array() );

				if ( ! empty( $items ) ) {
					$target = '_' . suki_get_theme_mod( 'footer_social_links_target' );
					$attrs  = array();

					foreach ( $items as $item ) {
						$url = suki_get_theme_mod( 'social_' . $item );

						$attrs[] = array(
							'type'   => $item,
							'url'    => ! empty( $url ) ? $url : '#',
							'target' => $target,
						);
					}
					?>
					<ul class="<?php echo esc_attr( 'suki-footer-' . $element ); ?> suki-social-links">
						<?php
						suki_social_links(
							$attrs,
							array(
								'before_link' => '<li>',
								'after_link'  => '</li>',
								'link_class'  => 'suki-menu-icon',
							)
						);
						?>
					</ul>
					<?php
				}
				$html = ob_get_clean();
				break;

			case 'html':
				ob_start();
				?>
				<!-- wp:group {
					"layout":{
						"type":"default"
					},
					"className":"<?php echo esc_attr( 'suki-footer-' . $element ); ?>"
				} --><div class="<?php echo esc_attr( 'suki-footer-' . $element ); ?>">

					<?php echo do_shortcode( suki_get_theme_mod( 'footer_' . str_replace( '-', '_', $element ) . '_content' ) ); ?>

				</div><!-- /wp:group -->
				<?php
				$html = ob_get_clean();
				break;

			default:
				$html = '';
				break;
		}

		/**
		 * Filter: suki/frontend/footer_element
		 *
		 * @param string $html    HTML markup.
		 * @param string $element Element slug.
		 */
		$html = apply_filters( 'suki/frontend/footer_element', $html, $element );

		/**
		 * Filter: suki/frontend/footer_element/{$element}
		 *
		 * @param string $html HTML markup.
		 */
		$html = apply_filters( 'suki/frontend/footer_element/' . $element, $html );

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
 * Scroll to top
 */
if ( ! function_exists( 'suki_scroll_to_top' ) ) {
	/**
	 * Render scroll to top.
	 *
	 * @param boolean $do_blocks Parse blocks or not.
	 * @param boolean $echo      Render or return.
	 * @return string
	 */
	function suki_scroll_to_top( $do_blocks = true, $echo = true ) {
		if ( ! boolval( suki_get_theme_mod( 'scroll_to_top' ) ) ) {
			return;
		}

		/**
		 * Filter: suki/frontend/scroll_to_top_classes
		 *
		 * @param array $classes CSS classes array.
		 */
		$classes = apply_filters( 'suki/frontend/scroll_to_top_classes', array( 'suki-scroll-to-top' ) );

		ob_start();
		?>
		<a href="#page" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
			<?php suki_icon( 'chevron-up' ); ?>
			<span class="screen-reader-text"><?php esc_html_e( 'Back to Top', 'suki' ); ?></span>
		</a>
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
