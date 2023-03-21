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
		ob_start();

		$columns = intval( suki_get_theme_mod( 'footer_widgets_bar' ) );

		if (
			! boolval( suki_get_current_page_setting( 'disable_footer_widgets' ) ) && // Footer widgets is not disabled.
			0 < $columns // Footer widgets has at least 1 column.
		) {
			?>
			<!-- wp:group {
				"className":"suki-footer-widgets-bar <?php echo esc_attr( 'suki-section--' . suki_get_current_page_setting( 'footer_widgets_bar_container' ) ); ?>",
				"layout":{
					"inherit":true
				}
			} --><div class="wp-block-group suki-footer-widgets-bar <?php echo esc_attr( 'suki-section--' . suki_get_current_page_setting( 'footer_widgets_bar_container' ) ); ?>">

				<!-- wp:columns {
					"verticalAlignment":"top",
					"className":"suki-footer-widgets-bar__columns"
				} --><div class="wp-block-columns are-vertically-aligned-top suki-footer-widgets-bar__columns">

					<?php
					for ( $i = 1; $i <= $columns; $i++ ) {
						?>
						<!-- wp:column {
							"verticalAlignment":"top",
							"className":"suki-footer-widgets-bar__column--<?php echo esc_attr( $i ); ?> suki-footer-widgets-bar__column"
						} --><div class="wp-block-column is-vertically-aligned-top suki-footer-widgets-bar__column--<?php echo esc_attr( $i ); ?> suki-footer-widgets-bar__column">

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
					suki_footer_bottom( false );
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
		ob_start();

		// Get elements and make sure they are valid elements.
		$elements = array(
			'left'   => array_intersect( suki_get_theme_mod( 'footer_elements_bottom_left', array() ), array_keys( suki_get_footer_builder_elements() ) ),
			'center' => array_intersect( suki_get_theme_mod( 'footer_elements_bottom_center', array() ), array_keys( suki_get_footer_builder_elements() ) ),
			'right'  => array_intersect( suki_get_theme_mod( 'footer_elements_bottom_right', array() ), array_keys( suki_get_footer_builder_elements() ) ),
		);

		$classes = 'suki-footer-bottom-bar suki-section--' . suki_get_current_page_setting( 'footer_bottom_bar_container' );

		if (
			! boolval( suki_get_current_page_setting( 'disable_footer_bottom' ) ) && // Footer bottom is not disabled.
			0 < array_sum( array_map( 'count', $elements ) ) // Footer bottom contains at least 1 element.
		) {
			?>
			<!-- wp:group {
				"className":"<?php echo esc_attr( $classes ); ?>",
				"layout":{
					"inherit":true
				}
			} --><div class="wp-block-group <?php echo esc_attr( $classes ); ?>">

				<!-- wp:group {
					"className":"suki-footer-bottom-row suki-footer-row",
					"layout":{
						"type":"flex",
						"flexWrap":"nowrap",
						"justifyContent":"space-between"
					}
				} --><div class="wp-block-group suki-footer-bottom-row suki-footer-row">

					<?php
					foreach ( array_keys( $elements ) as $column ) {
						// Skip center column if it's empty.
						if ( 'center' === $column && 0 === count( $elements[ $column ] ) ) {
							continue;
						}

						$classes = implode(
							' ',
							array_merge(
								array(
									'suki-footer-column', // Used for additional styles via theme's CSS.
									'suki-footer-column--' . $column, // Used for additional styles via theme's CSS.
								),
								count( $elements[ $column ] ) === 0 ? array(
									'suki-footer-column--empty', // Used for additional styles via theme's CSS.
								) : array()
							)
						);
						?>
						<!-- wp:group {
							"className":"<?php echo esc_attr( $classes ); ?>",
							"layout":{
								"type":"flex",
								"flexWrap":"nowrap",
								"justifyContent":"<?php echo esc_attr( $column ); ?>"
							}
						} --><div class="wp-block-group <?php echo esc_attr( $classes ); ?>">

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
				<div class="<?php echo esc_attr( 'suki-footer-' . $element ); ?>">
					<?php echo do_shortcode( $copyright ); ?>
				</div>
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
				<div class="<?php echo esc_attr( 'suki-footer-' . $element ); ?>">
					<?php echo do_shortcode( suki_get_theme_mod( 'footer_' . str_replace( '-', '_', $element ) . '_content' ) ); ?>
				</div>
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
