<?php
/**
 * Header section template rendering functions.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Header
 */
if ( ! function_exists( 'suki_header' ) ) {
	/**
	 * Render header.
	 *
	 * Notes:
	 * - Action Hooks API is used to to register footer sections and allow further modifications in Child Theme or 3rd party plugin.
	 * - `aria-label`, `itemscope`, `itemtype` attributes are added manually.
	 * - Theme uses `.suki-header` class to add / override styles.
	 *
	 * @param boolean $do_blocks Parse blocks or not.
	 * @param boolean $echo      Render or return.
	 * @return string
	 */
	function suki_header( $do_blocks = true, $echo = true ) {
		// Abort if header has no attached action.
		if ( ! has_action( 'suki/frontend/header' ) ) {
			return;
		}

		ob_start();

		$classes = 'suki-header site-header';
		?>
		<!-- wp:group {
			"tagName":"header",
			"layout":{
				"type":"default"
			},
			"style":{
				"spacing":{
					"blockGap":"0px"
				}
			},
			"className":"suki-header site-header"
		} --><header id="masthead" class="wp-block-group suki-header site-header" aria-label="<?php esc_attr_e( 'Site Header', 'suki' ); ?>" itemscope itemtype="https://schema.org/WPHeader">

			<?php
			/**
			 * Hook: suki/frontend/header
			 *
			 * @hooked suki_header_desktop - 10
			 * @hooked suki_header_mobile - 10
			 */
			do_action( 'suki/frontend/header' );
			?>

		</header><!-- /wp:group -->
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
 * Desktop header
 */
if ( ! function_exists( 'suki_header_desktop' ) ) {
	/**
	 * Render desktop header.
	 *
	 * @param boolean $do_blocks Parse blocks or not.
	 * @param boolean $echo      Render or return.
	 * @return string
	 */
	function suki_header_desktop( $do_blocks = true, $echo = true ) {
		// Abort if "disabled desktop header" option is enabled.
		if ( boolval( suki_get_current_page_setting( 'disable_header' ) ) ) {
			return;
		}

		ob_start();

		/**
		 * Filter: suki/frontend/header_classes
		 *
		 * @param array $classes Classes array.
		 */
		$classes = apply_filters(
			'suki/frontend/header_classes',
			array(
				'suki-header-desktop',
				'suki-show-on-' . suki_get_theme_mod( 'header_mobile_visibility' ),
			)
		);

		$classes = implode( ' ', $classes );
		?>
		<!-- wp:group {
			"layout":{
				"type":"flex",
				"orientation":"vertical",
				"justifyContent":"stretch"
			},
			"style":{
				"spacing":{
					"blockGap":"0px"
				}
			},
			"className":"<?php echo esc_attr( $classes ); ?>"
		} --><div id="header" class="wp-block-group <?php echo esc_attr( $classes ); ?>">

			<?php
			// Header Top Bar (if not merged).
			if ( ! boolval( suki_get_theme_mod( 'header_top_bar_merged' ) ) ) {
				suki_header_desktop__top_bar( false );
			}

			// Header Main Bar.
			suki_header_desktop__main_bar( false );

			// Header Bottom Bar (if not merged).
			if ( ! boolval( suki_get_theme_mod( 'header_bottom_bar_merged' ) ) ) {
				suki_header_desktop__bottom_bar( false );
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
 * Desktop header - Top bar
 */
if ( ! function_exists( 'suki_header_desktop__top_bar' ) ) {
	/**
	 * Render desktop header top bar.
	 *
	 * Notes:
	 * - Theme uses `.suki-header-top-bar` class to add / override styles.
	 * - Theme uses `.suki-header-row` class to add / override styles.
	 *
	 * @param boolean $do_blocks Parse blocks or not.
	 * @param boolean $echo      Render or return.
	 * @return string
	 */
	function suki_header_desktop__top_bar( $do_blocks = true, $echo = true ) {
		// Get elements and make sure they are valid elements.
		$elements = array(
			'left'   => array_intersect( suki_get_theme_mod( 'header_elements_top_left', array() ), array_keys( suki_get_header_builder_elements() ) ),
			'center' => array_intersect( suki_get_theme_mod( 'header_elements_top_center', array() ), array_keys( suki_get_header_builder_elements() ) ),
			'right'  => array_intersect( suki_get_theme_mod( 'header_elements_top_right', array() ), array_keys( suki_get_header_builder_elements() ) ),
		);

		$has_center_column = 0 < count( $elements['center'] );

		// Abort if desktop header top bar has no element.
		if ( 1 > array_sum( array_map( 'count', $elements ) ) ) {
			return;
		}

		ob_start();

		$container = suki_get_theme_mod( 'header_top_bar_container' );

		$content_size = '';
		if ( 'full' === $container ) {
			$content_size = '100%';
		} elseif ( 'wide' === $container ) {
			$content_size = 'var(--wp--style--global--wide-size)';
		}

		$padding = suki_get_theme_mod( 'header_top_bar_padding' );
		$border  = suki_get_theme_mod( 'header_top_bar_border' );

		$bg_color     = suki_parse_color_value_for_block_attributes( suki_get_theme_mod( 'header_top_bar_bg_color' ), 'background' );
		$text_color   = suki_parse_color_value_for_block_attributes( suki_get_theme_mod( 'header_top_bar_text_color' ), 'text' );
		$border_color = suki_parse_color_value_for_block_attributes( suki_get_theme_mod( 'header_top_bar_border_color' ), 'border' );
		$link_color   = suki_parse_color_value_for_block_attributes( suki_get_theme_mod( 'header_top_bar_link_color' ), 'link' );

		/**
		 * Filter: suki/frontend/header_top_bar_classes
		 *
		 * @param array $classes Classes array.
		 */
		$classes = apply_filters( 'suki/frontend/header_top_bar_classes', array( 'suki-header-top-bar', 'suki-header-section--horizontal' ) );

		$classes = array_merge(
			$classes,
			$bg_color['classes'],
			$text_color['classes'],
			$border_color['classes'],
			$link_color['classes'],
		);

		$styles = array(
			'min-height'          => '100%',
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
			"elements":{
				"link":{
					"color":{
						"text":"<?php echo esc_attr( false !== $link_color['preset_value'] ? 'var:preset|color|' . $link_color['preset_value'] : $link_color['custom_value'] ); ?>"
					}
				}
			},
			"style":{
				"dimensions":{
					"minHeight":"100%"
				},
				"layout":{
					"selfStretch":"fixed",
					"flexSize":"<?php echo esc_attr( suki_get_theme_mod( 'header_top_bar_height' ) ); ?>"
				}
			},
			"className":"<?php suki_element_class( $classes, false ); ?>"
		} --><div class="wp-block-group <?php suki_element_class( $classes, false ); ?>" <?php suki_element_style( $styles ); ?>>

			<!-- wp:group {
				"layout":{
					"type":"flex",
					"flexWrap":"nowrap",
					"justifyContent":"space-between"
				},
				"style":{
					"dimensions":{
						"minHeight":"100%"
					}
				}
			} --><div class="wp-block-group" style="min-height:100%">

				<?php
				/**
				 * Render left, center, and right columns.
				 *
				 * - If center column has no element, do not render.
				 * - If center column has element, the left and right columns will have fixed width to keep the center column centered horizontally.
				 */
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
					} --><div class="wp-block-group" style="min-height:100%">

						<?php
						foreach ( $elements[ $column ] as $element ) {
							suki_header_element( $element, false );
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

if ( ! function_exists( 'suki_header_desktop__main_bar' ) ) {
	/**
	 * Render desktop header main bar.
	 *
	 * Notes:
	 * - Theme uses `.suki-header-main-bar` class to add / override styles.
	 * - Theme uses `.suki-header-row` class to add / override styles.
	 *
	 * @param boolean $do_blocks Parse blocks or not.
	 * @param boolean $echo      Render or return.
	 * @return string
	 */
	function suki_header_desktop__main_bar( $do_blocks = true, $echo = true ) {
		// Get elements and make sure they are valid elements.
		$elements = array(
			'left'   => array_intersect( suki_get_theme_mod( 'header_elements_main_left', array() ), array_keys( suki_get_header_builder_elements() ) ),
			'center' => array_intersect( suki_get_theme_mod( 'header_elements_main_center', array() ), array_keys( suki_get_header_builder_elements() ) ),
			'right'  => array_intersect( suki_get_theme_mod( 'header_elements_main_right', array() ), array_keys( suki_get_header_builder_elements() ) ),
		);

		$has_center_column = 0 < count( $elements['center'] );

		// Abort if desktop header main bar has no element.
		if ( 1 > array_sum( array_map( 'count', $elements ) ) ) {
			return;
		}

		ob_start();

		$container = suki_get_theme_mod( 'header_main_bar_container' );

		$content_size = '';
		if ( 'full' === $container ) {
			$content_size = '100%';
		} elseif ( 'wide' === $container ) {
			$content_size = 'var(--wp--style--global--wide-size)';
		}

		$padding = suki_get_theme_mod( 'header_main_bar_padding' );
		$border  = suki_get_theme_mod( 'header_main_bar_border' );

		$bg_color     = suki_parse_color_value_for_block_attributes( suki_get_theme_mod( 'header_main_bar_bg_color' ), 'background' );
		$text_color   = suki_parse_color_value_for_block_attributes( suki_get_theme_mod( 'header_main_bar_text_color' ), 'text' );
		$border_color = suki_parse_color_value_for_block_attributes( suki_get_theme_mod( 'header_main_bar_border_color' ), 'border' );
		$link_color   = suki_parse_color_value_for_block_attributes( suki_get_theme_mod( 'header_main_bar_link_color' ), 'link' );

		/**
		 * Filter: suki/frontend/header_main_bar_classes
		 *
		 * @param array $classes Classes array.
		 */
		$classes = apply_filters( 'suki/frontend/header_main_bar_classes', array( 'suki-header-main-bar', 'suki-header-section--horizontal' ) );

		$classes = array_merge(
			$classes,
			$bg_color['classes'],
			$text_color['classes'],
			$border_color['classes'],
			$link_color['classes'],
		);

		$styles = array(
			'min-height'          => '100%',
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
			"style": {
				"dimensions":{
					"minHeight":"100%"
				},
				"layout":{
					"selfStretch":"fixed",
					"flexSize":"<?php echo esc_attr( suki_get_theme_mod( 'header_main_bar_height' ) ); ?>"
				},
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
			"className":"<?php suki_element_class( $classes, false ); ?>"
		} --><div class="wp-block-group <?php suki_element_class( $classes, false ); ?>" <?php suki_element_style( $styles ); ?>>

			<?php
			if ( boolval( suki_get_theme_mod( 'header_top_bar_merged' ) ) || boolval( suki_get_theme_mod( 'header_bottom_bar_merged' ) ) ) {
				?>
				<!-- wp:group {
					"layout":{
						"type":"flex",
						"orientation":"vertical",
						"justifyContent":"stretch",
						"justifyContent":"space-between"
					},
					"style":{
						"dimensions":{
							"minHeight":"100%"
						},
						"spacing":{
							"blockGap":"0px"
						}
					}
				} --><div class="wp-block-group" style="min-height:100%">
					<?php
			}

			// Header Top Bar (if merged).
			if ( boolval( suki_get_theme_mod( 'header_top_bar_merged' ) ) ) {
				suki_header_desktop__top_bar( false );

				$top_bar_gap = suki_get_theme_mod( 'header_top_bar_merged_gap' );

				if ( 0 < $top_bar_gap ) {
					?>
					<!-- wp:spacer {
						"height":"<?php echo esc_attr( $top_bar_gap ); ?>"
					} --><div style="height:<?php echo esc_attr( $top_bar_gap ); ?>" aria-hidden="true" class="wp-block-spacer"></div><!-- /wp:spacer -->
					<?php
				}
			}
			?>

			<!-- wp:group {
				"layout":{
					"type":"flex",
					"flexWrap":"nowrap",
					"justifyContent":"space-between"
				},
				"style":{
					"dimensions":{
						"minHeight":"100%"
					}
				}
			} --><div class="wp-block-group" style="min-height:100%">

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
					} --><div class="wp-block-group" style="min-height:100%">

						<?php
						foreach ( $elements[ $column ] as $element ) {
							suki_header_element( $element, false );
						}
						?>

					</div><!-- /wp:group -->
					<?php
				}
				?>

			</div><!-- /wp:group -->

			<?php
			// Header Bottom Bar (if merged).
			if ( boolval( suki_get_theme_mod( 'header_bottom_bar_merged' ) ) ) {
				$bottom_bar_gap = suki_get_theme_mod( 'header_bottom_bar_merged_gap' );

				if ( 0 < $bottom_bar_gap ) {
					?>
					<!-- wp:spacer {
						"height":"<?php echo esc_attr( $bottom_bar_gap ); ?>"
					} --><div style="height:<?php echo esc_attr( $bottom_bar_gap ); ?>" aria-hidden="true" class="wp-block-spacer"></div><!-- /wp:spacer -->
					<?php
				}

				suki_header_desktop__bottom_bar( false );
			}
			?>

			<?php
			if ( boolval( suki_get_theme_mod( 'header_top_bar_merged' ) ) || boolval( suki_get_theme_mod( 'header_bottom_bar_merged' ) ) ) {
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
}

if ( ! function_exists( 'suki_header_desktop__bottom_bar' ) ) {
	/**
	 * Render desktop header bottom bar.
	 *
	 * Notes:
	 * - Theme uses `.suki-header-bottom-bar` class to add / override styles.
	 * - Theme uses `.suki-header-row` class to add / override styles.
	 *
	 * @param boolean $do_blocks Parse blocks or not.
	 * @param boolean $echo      Render or return.
	 * @return string
	 */
	function suki_header_desktop__bottom_bar( $do_blocks = true, $echo = true ) {
		// Get elements and make sure they are valid elements.
		$elements = array(
			'left'   => array_intersect( suki_get_theme_mod( 'header_elements_bottom_left', array() ), array_keys( suki_get_header_builder_elements() ) ),
			'center' => array_intersect( suki_get_theme_mod( 'header_elements_bottom_center', array() ), array_keys( suki_get_header_builder_elements() ) ),
			'right'  => array_intersect( suki_get_theme_mod( 'header_elements_bottom_right', array() ), array_keys( suki_get_header_builder_elements() ) ),
		);

		$has_center_column = 0 < count( $elements['center'] );

		// Abort if desktop header bottom bar has no element.
		if ( 1 > array_sum( array_map( 'count', $elements ) ) ) {
			return;
		}

		ob_start();

		$container = suki_get_theme_mod( 'header_bottom_bar_container' );

		$content_size = '';
		if ( 'full' === $container ) {
			$content_size = '100%';
		} elseif ( 'wide' === $container ) {
			$content_size = 'var(--wp--style--global--wide-size)';
		}

		$padding = suki_get_theme_mod( 'header_bottom_bar_padding' );
		$border  = suki_get_theme_mod( 'header_bottom_bar_border' );

		$bg_color     = suki_parse_color_value_for_block_attributes( suki_get_theme_mod( 'header_bottom_bar_bg_color' ), 'background' );
		$text_color   = suki_parse_color_value_for_block_attributes( suki_get_theme_mod( 'header_bottom_bar_text_color' ), 'text' );
		$border_color = suki_parse_color_value_for_block_attributes( suki_get_theme_mod( 'header_bottom_bar_border_color' ), 'border' );
		$link_color   = suki_parse_color_value_for_block_attributes( suki_get_theme_mod( 'header_bottom_bar_link_color' ), 'link' );

		/**
		 * Filter: suki/frontend/header_bottom_bar_classes
		 *
		 * @param array $classes Classes array.
		 */
		$classes = apply_filters( 'suki/frontend/header_bottom_bar_classes', array( 'suki-header-bottom-bar', 'suki-header-section--horizontal' ) );

		$classes = array_merge(
			$classes,
			$bg_color['classes'],
			$text_color['classes'],
			$border_color['classes'],
			$link_color['classes'],
		);

		$styles = array(
			'min-height'          => '100%',
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
			"style": {
				"dimensions":{
					"minHeight":"100%"
				},
				"layout":{
					"selfStretch":"fixed",
					"flexSize":"<?php echo esc_attr( suki_get_theme_mod( 'header_bottom_bar_height' ) ); ?>"
				},
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
			"className":"<?php echo esc_attr( $classes ); ?>"
		} --><div class="wp-block-group <?php echo esc_attr( $classes ); ?>" <?php suki_element_style( $styles ); ?>>

			<!-- wp:group {
				"layout":{
					"type":"flex",
					"flexWrap":"nowrap",
					"justifyContent":"space-between"
				},
				"style":{
					"dimensions":{
						"minHeight":"100%"
					}
				}
			} --><div class="wp-block-group" style="min-height:100%">

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
						}
					} --><div class="wp-block-group">

						<?php
						foreach ( $elements[ $column ] as $element ) {
							suki_header_element( $element, false );
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
 * Mobile header
 */
if ( ! function_exists( 'suki_header_mobile' ) ) {
	/**
	 * Render mobile header.
	 *
	 * @param boolean $do_blocks Parse blocks or not.
	 * @param boolean $echo      Render or return.
	 * @return string
	 */
	function suki_header_mobile( $do_blocks = true, $echo = true ) {
		// Abort if "disabled mobile header" option is enabled.
		if ( boolval( suki_get_current_page_setting( 'disable_header_mobile' ) ) ) {
			return;
		}

		ob_start();

		/**
		 * Filter: suki/frontend/header_mobile_classes
		 *
		 * @param array $classes Classes array.
		 */
		$classes = apply_filters(
			'suki/frontend/header_mobile_classes',
			array(
				'suki-header-mobile',
				'suki-hide-on-' . suki_get_theme_mod( 'header_mobile_visibility' ),
			)
		);

		$classes = implode( ' ', $classes );
		?>
		<!-- wp:group {
			"layout":{
				"type":"flex",
				"orientation":"vertical",
				"justifyContent":"stretch"
			},
			"style":{
				"spacing":{
					"blockGap":"0px"
				}
			},
			"className":"<?php echo esc_attr( $classes ); ?>"
		} --><div id="mobile-header" class="wp-block-group <?php echo esc_attr( $classes ); ?>">

			<?php
			// Mobile main bar.
			suki_header_mobile__main_bar( false );

			// Mobile popup.
			suki_header_mobile__popup( false );
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

if ( ! function_exists( 'suki_header_mobile__main_bar' ) ) {
	/**
	 * Render mobile header main bar.
	 *
	 * @param boolean $do_blocks Parse blocks or not.
	 * @param boolean $echo      Render or return.
	 * @return string
	 */
	function suki_header_mobile__main_bar( $do_blocks = true, $echo = true ) {
		// Get elements and make sure they are valid elements.
		$elements = array(
			'left'   => array_intersect( suki_get_theme_mod( 'header_mobile_elements_main_left', array() ), array_keys( suki_get_header_mobile_builder_elements() ) ),
			'center' => array_intersect( suki_get_theme_mod( 'header_mobile_elements_main_center', array() ), array_keys( suki_get_header_mobile_builder_elements() ) ),
			'right'  => array_intersect( suki_get_theme_mod( 'header_mobile_elements_main_right', array() ), array_keys( suki_get_header_mobile_builder_elements() ) ),
		);

		$has_center_column = 0 < count( $elements['center'] );

		// Abort if mobile header main bar has no element.
		if ( 1 > array_sum( array_map( 'count', $elements ) ) ) {
			return;
		}

		ob_start();

		/**
		 * Filter: suki/frontend/header_mobile_main_bar_classes
		 *
		 * @param array $classes Classes array.
		 */
		$classes = apply_filters( 'suki/frontend/header_mobile_main_bar_classes', array( 'suki-header-mobile-main-bar' ) );

		$classes = implode( ' ', $classes );
		?>
		<!-- wp:group {
			"className":"<?php echo esc_attr( $classes ); ?>"
		} --><div class="wp-block-group <?php echo esc_attr( $classes ); ?>">

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
						}
					} --><div class="wp-block-group">

						<?php
						foreach ( $elements[ $column ] as $element ) {
							suki_header_element( $element, false );
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

if ( ! function_exists( 'suki_header_mobile__popup' ) ) {
	/**
	 * Render mobile header popup.
	 *
	 * @param boolean $do_blocks Parse blocks or not.
	 * @param boolean $echo      Render or return.
	 * @return string
	 */
	function suki_header_mobile__popup( $do_blocks = true, $echo = true ) {
		// Get elements and make sure they are valid elements.
		$elements = array(
			'top' => array_intersect( suki_get_theme_mod( 'header_mobile_elements_vertical_top', array() ), array_keys( suki_get_header_mobile_builder_elements() ) ),
		);

		// Abort if mobile header popup has no element.
		if ( 1 > array_sum( array_map( 'count', $elements ) ) ) {
			return;
		}

		ob_start();

		/**
		 * Filter: suki/frontend/header_mobile_vertical_classes
		 *
		 * @param array $classes Classes array.
		 */
		$classes = apply_filters( 'suki/frontend/header_mobile_vertical_classes', array( 'suki-header-mobile-popup', 'suki-popup' ) );

		$classes = implode( ' ', $classes );
		?>
		<div id="mobile-header-popup" class="<?php echo esc_attr( $classes ); ?>">

			<div class="suki-popup__background suki-popup__close">
				<button class="suki-popup__close suki-toggle"><?php suki_icon( 'close' ); ?></button>
			</div>

			<!-- wp:group {
				"className":"suki-header-section--vertical suki-popup__content",
				"layout":{
					"type":"flex",
					"orientation":"vertical",
				}
			} --><div class="wp-block-group suki-header-section--vertical suki-popup__content">

				<!-- wp:group {
					"className":"suki-header-vertical-column",
					"layout":{
						"type":"flex",
						"orientation":"vertical",
						"justifyContent":"<?php echo esc_attr( suki_get_theme_mod( 'header_mobile_vertical_bar_position' ) ); ?>"
					}
				} --><div class="suki-header-vertical-column">

					<?php
					foreach ( array_keys( $elements ) as $row ) {
						$classes = 'suki-header-vertical-row suki-header-vertical-row--' . $row;
						?>
						<!-- wp:group {
							"className":"<?php echo esc_attr( $classes ); ?>",
							"layout":{
								"type":"flex",
								"orientation":"vertical",
								"justifyContent":"<?php echo esc_attr( suki_get_theme_mod( 'header_mobile_vertical_bar_alignment' ) ); ?>"
							}
						} --><div class="wp-block-group <?php echo esc_attr( $classes ); ?>">

							<?php
							foreach ( $elements[ $row ] as $element ) {
								suki_header_element( $element, false );
							}
							?>

						</div><!-- /wp:group -->
						<?php
					}
					?>

				</div><!-- /wp:group -->

				<button class="suki-popup__close suki-toggle"><?php suki_icon( 'close' ); ?></button>

			</div><!-- /wp:group -->

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

/**
 * Header element
 */
if ( ! function_exists( 'suki_header_element' ) ) {
	/**
	 * Wrapper function to print HTML markup for all header element.
	 *
	 * @param string  $element Element slug.
	 * @param boolean $do_blocks Parse blocks or not.
	 * @param boolean $echo      Render or return.
	 * @return string
	 */
	function suki_header_element( $element, $do_blocks = true, $echo = true ) {
		// Classify element into its type.
		$type = preg_replace( '/-\d$/', '', $element );

		// Get header element template.
		switch ( $type ) {
			case 'menu':
				$html = wp_nav_menu(
					array(
						'theme_location' => 'header-' . $element,
						'menu_class'     => 'suki-header-' . $element . ' suki-header-menu menu suki-hover-menu',
						'container'      => false,
						'fallback_cb'    => 'suki_unassigned_menu',
						/* translators: %s: menu number. */
						'items_wrap'     => '<ul class="%2$s" itemscope itemtype="https://schema.org/SiteNavigationElement" aria-label="' . sprintf( esc_attr__( 'Header Menu %s', 'suki' ), str_replace( 'menu-', '', $element ) ) . '">%3$s</ul>',
						'echo'           => false,
					)
				);
				break;

			case 'mobile-menu':
				$html = wp_nav_menu(
					array(
						'theme_location' => 'header-' . $element,
						'menu_class'     => 'suki-header-' . $element . ' suki-header-menu menu suki-toggle-menu',
						'container'      => false,
						'fallback_cb'    => 'suki_unassigned_menu',
						'items_wrap'     => '<ul class="%2$s" itemscope itemtype="https://schema.org/SiteNavigationElement" aria-label="' . esc_attr__( 'Mobile Header Menu', 'suki' ) . '">%3$s</ul>',
						'echo'           => false,
					)
				);
				break;

			case 'logo':
				ob_start();

				$tag = is_front_page() ? 'h1' : 'div'; // Use <h1> in front page, otherwise use <div>.

				/**
				 * Filter: suki/frontend/logo_url
				 *
				 * @param string $logo_url Logo URL.
				 */
				$logo_url = apply_filters( 'suki/frontend/logo_url', home_url( '/' ) );
				?>
				<<?php echo esc_attr( $tag ); ?>>
					<a href="<?php echo esc_url( $logo_url ); ?>" class="<?php echo esc_attr( 'suki-header-' . $element ); ?> suki-logo site-branding site-title suki-title" rel="home">
						<?php
						/**
						 * Hook: suki/frontend/logo
						 *
						 * @hooked suki_default_logo - 10
						 */
						do_action( 'suki/frontend/logo' );
						?>
					</a>
				</<?php echo esc_attr( $tag ); ?>>
				<?php
				$html = ob_get_clean();
				break;

			case 'mobile-logo':
				ob_start();

				/**
				 * Filter: suki/frontend/logo_url
				 *
				 * @param string $logo_url Logo URL.
				 */
				$logo_url = apply_filters( 'suki/frontend/logo_url', home_url( '/' ) );
				?>
				<div>
					<a href="<?php echo esc_url( $logo_url ); ?>" class="<?php echo esc_attr( 'suki-header-' . $element ); ?> suki-logo site-branding site-title" rel="home">
						<?php
						/**
						 * Hook: suki/frontend/mobile_logo
						 *
						 * @hooked suki_default_mobile_logo - 10
						 */
						do_action( 'suki/frontend/mobile_logo' );
						?>
					</a>
				</div>
				<?php
				$html = ob_get_clean();
				break;

			case 'mobile-vertical-toggle':
				ob_start();
				?>
				<button class="<?php echo esc_attr( 'suki-header-' . $element ); ?> suki-popup-toggle suki-toggle" data-target="mobile-header-popup" aria-expanded="false">
					<?php suki_icon( 'menu', array( 'class' => 'suki-menu-icon' ) ); ?>
					<span class="screen-reader-text"><?php esc_html_e( 'Mobile Menu', 'suki' ); ?></span>
				</button>
				<?php
				$html = ob_get_clean();
				break;

			case 'search-bar':
				ob_start();
				?>
				<div class="<?php echo esc_attr( 'suki-header-' . $element ); ?>">
					<?php get_search_form(); ?>
				</div>
				<?php
				$html = ob_get_clean();
				break;

			case 'search-dropdown':
				ob_start();
				?>
				<div class="<?php echo esc_attr( 'suki-header-' . $element ); ?> suki-header-search menu suki-toggle-menu">
					<div class="menu-item">
						<button class="suki-sub-menu-toggle suki-toggle" aria-expanded="false">
							<?php suki_icon( 'search', array( 'class' => 'suki-menu-icon' ) ); ?>
							<span class="screen-reader-text"><?php esc_html_e( 'Search', 'suki' ); ?></span>
						</button>
						<div class="sub-menu"><?php get_search_form(); ?></div>
					</div>
				</div>
				<?php
				$html = ob_get_clean();
				break;

			case 'social':
				ob_start();
				$items = suki_get_theme_mod( 'header_social_links', array() );

				if ( ! empty( $items ) ) {
					$target = '_' . suki_get_theme_mod( 'header_social_links_target' );
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
					<ul class="<?php echo esc_attr( 'suki-header-' . $element ); ?> suki-social-links">
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
					"className":"<?php echo esc_attr( 'suki-header-' . $element ); ?>"
				} --><div class="<?php echo esc_attr( 'suki-header-' . $element ); ?>">

					<?php echo do_shortcode( suki_get_theme_mod( 'header_' . str_replace( '-', '_', $element ) . '_content' ) ); ?>

				</div><!-- /wp:group -->
				<?php
				$html = ob_get_clean();
				break;

			default:
				$html = '';
				break;
		}

		/**
		 * Filter: suki/frontend/header_element
		 *
		 * @param string $html    HTML markup.
		 * @param string $element Element slug.
		 */
		$html = apply_filters( 'suki/frontend/header_element', $html, $element );

		/**
		 * Filter: suki/frontend/header_element/{$element}
		 *
		 * @param string $html    HTML markup.
		 * @param string $element Element slug.
		 */
		$html = apply_filters( 'suki/frontend/header_element/' . $element, $html, $element );

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

if ( ! function_exists( 'suki_logo' ) ) {
	/**
	 * Print HTML markup for specified site logo.
	 *
	 * @param integer $logo_image_id Logo image ID.
	 * @param boolean $echo          Render or return the HTML tags.
	 * @return string
	 */
	function suki_logo( $logo_image_id = null, $echo = true ) {
		// Default to site name.
		$html = get_bloginfo( 'name', 'display' );

		// Try to get logo image.
		if ( ! empty( $logo_image_id ) ) {
			$mime = get_post_mime_type( $logo_image_id );

			$logo_image = wp_get_attachment_image(
				$logo_image_id,
				'full',
				0,
				array(
					'alt' => get_bloginfo( 'name', 'display' ),
				)
			);

			// Replace logo HTML if logo image is found.
			if ( ! empty( $logo_image ) ) {
				$html = $logo_image;
			}
		}

		// Render or return.
		if ( boolval( $echo ) ) {
			echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		} else {
			return $html;
		}
	}
}

if ( ! function_exists( 'suki_default_logo' ) ) {
	/**
	 * Print / return HTML markup for default logo.
	 */
	function suki_default_logo() {
		?>
		<span class="suki-logo suki-logo--default"><?php suki_logo( suki_get_theme_mod( 'custom_logo' ) ); ?></span>
		<?php
	}
}

if ( ! function_exists( 'suki_default_mobile_logo' ) ) {
	/**
	 * Print / return HTML markup for default mobile logo.
	 */
	function suki_default_mobile_logo() {
		$mobile_logo = suki_get_theme_mod( 'custom_logo_mobile' );

		if ( empty( $mobile_logo ) ) {
			$mobile_logo = suki_get_theme_mod( 'custom_logo' );
		}
		?>
		<span class="suki-logo suki-logo--default"><?php suki_logo( $mobile_logo ); ?></span>
		<?php
	}
}
