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
	 * - `suki-header` CSS class handles these styles: blockGap (0px).
	 * - `aria-label`, `itemscope`, `itemtype` attributes are added manually.
	 *
	 * @param boolean $do_blocks Parse blocks or not.
	 * @param boolean $echo      Render or return.
	 * @return string
	 */
	function suki_header( $do_blocks = true, $echo = true ) {
		ob_start();

		if ( has_action( 'suki/frontend/header' ) ) { // Header has at least 1 attached action.
			?>
			<!-- wp:group {
				"tagName":"header",
				"align":"full",
				"className":"suki-header site-header",
				"layout":{
					"inherit":true
				}
			} --><header id="masthead" class="wp-block-group alignfull suki-header site-header" aria-label="<?php esc_attr_e( 'Site Header', 'suki' ); ?>" itemscope itemtype="https://schema.org/WPHeader">

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
		ob_start();

		if ( ! boolval( suki_get_current_page_setting( 'disable_header' ) ) ) {
			?>
			<!-- wp:group {
				"align":"full",
				"className":"suki-header-desktop suki-show-on-desktop"
			} --><div id="header" class="wp-block-group alignfull suki-header-desktop suki-show-on-desktop">

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
 * Desktop header - Top bar
 */
if ( ! function_exists( 'suki_header_desktop__top_bar' ) ) {
	/**
	 * Render desktop header top bar.
	 *
	 * @param boolean $do_blocks Parse blocks or not.
	 * @param boolean $echo      Render or return.
	 * @return string
	 */
	function suki_header_desktop__top_bar( $do_blocks = true, $echo = true ) {
		ob_start();

		$elements = array(
			'left'   => suki_get_theme_mod( 'header_elements_top_left', array() ),
			'center' => suki_get_theme_mod( 'header_elements_top_center', array() ),
			'right'  => suki_get_theme_mod( 'header_elements_top_right', array() ),
		);

		$classes = suki_element_class( 'header_top_bar', array( 'suki-header-top-bar' ), false );

		if ( 0 < array_sum( array_map( 'count', $elements ) ) ) { // Desktop header top bar contains at least 1 element.
			?>
			<!-- wp:group {
				"align":"full",
				"className":"<?php echo esc_attr( $classes ); ?>",
				"layout":{
					"inherit":true
				}
			} --><div class="wp-block-group alignfull <?php echo esc_attr( $classes ); ?>">

				<!-- wp:group {
					"className":"suki-header-row",
					"layout":{
						"type":"flex",
						"flexWrap":"nowrap",
						"justifyContent":"space-between"
					}
				} --><div class="wp-block-group suki-header-row">

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
									'suki-header-column', // Used for additional styles via theme's CSS.
									'suki-header-column--' . $column, // Used for additional styles via theme's CSS.
								),
								count( $elements[ $column ] ) === 0 ? array(
									'suki-header-column--empty', // Used for additional styles via theme's CSS.
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

if ( ! function_exists( 'suki_header_desktop__main_bar' ) ) {
	/**
	 * Render desktop header main bar.
	 *
	 * @param boolean $do_blocks Parse blocks or not.
	 * @param boolean $echo      Render or return.
	 * @return string
	 */
	function suki_header_desktop__main_bar( $do_blocks = true, $echo = true ) {
		ob_start();

		$elements = array(
			'left'   => suki_get_theme_mod( 'header_elements_main_left', array() ),
			'center' => suki_get_theme_mod( 'header_elements_main_center', array() ),
			'right'  => suki_get_theme_mod( 'header_elements_main_right', array() ),
		);

		$classes = suki_element_class( 'header_main_bar', array( 'suki-header-main-bar' ), false );

		if ( 0 < array_sum( array_map( 'count', $elements ) ) ) { // Desktop header main bar contains at least 1 element.
			?>
			<!-- wp:group {
				"align":"full",
				"className":"<?php echo esc_attr( $classes ); ?>",
				"layout":{
					"inherit":true
				}
			} --><div class="wp-block-group alignfull <?php echo esc_attr( $classes ); ?>">

				<!-- wp:group {
					"className":"suki-header-row",
					"layout":{
						"type":"flex",
						"flexWrap":"nowrap",
						"justifyContent":"space-between"
					}
				} --><div class="wp-block-group suki-header-row">

					<?php
					foreach ( array_keys( $elements ) as $column ) {
						// Skip center column if it's empty.
						if ( 'center' === $column && 0 === count( $elements[ $column ] ) ) {
							continue;
						}

						$classes = 'suki-header-column suki-header-column--' . $column . ( 0 < count( $elements[ $column ] ) ? ' suki-header-column--empty' : '' );
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

if ( ! function_exists( 'suki_header_desktop__bottom_bar' ) ) {
	/**
	 * Render desktop header bottom bar.
	 *
	 * @param boolean $do_blocks Parse blocks or not.
	 * @param boolean $echo      Render or return.
	 * @return string
	 */
	function suki_header_desktop__bottom_bar( $do_blocks = true, $echo = true ) {
		ob_start();

		$elements = array(
			'left'   => suki_get_theme_mod( 'header_elements_bottom_left', array() ),
			'center' => suki_get_theme_mod( 'header_elements_bottom_center', array() ),
			'right'  => suki_get_theme_mod( 'header_elements_bottom_right', array() ),
		);

		$classes = suki_element_class( 'header_bottom_bar', array( 'suki-header-bottom-bar' ), false );

		if ( 0 < array_sum( array_map( 'count', $elements ) ) ) { // Desktop header bottom bar contains at least 1 element.
			?>
			<!-- wp:group {
				"align":"full",
				"className":"<?php echo esc_attr( $classes ); ?>",
				"layout":{
					"inherit":true
				}
			} --><div class="wp-block-group alignfull <?php echo esc_attr( $classes ); ?>">

				<!-- wp:group {
					"className":"suki-header-row",
					"layout":{
						"type":"flex",
						"flexWrap":"nowrap",
						"justifyContent":"space-between"
					}
				} --><div class="wp-block-group suki-header-row">

					<?php
					foreach ( array_keys( $elements ) as $column ) {
						// Skip center column if it's empty.
						if ( 'center' === $column && 0 === count( $elements[ $column ] ) ) {
							continue;
						}

						$classes = 'suki-header-column suki-header-column--' . $column . ( 0 < count( $elements[ $column ] ) ? ' suki-header-column--empty' : '' );
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
		ob_start();

		$elements = array(
			'main'     => array(
				'left'   => suki_get_theme_mod( 'header_mobile_elements_main_left', array() ),
				'center' => suki_get_theme_mod( 'header_mobile_elements_main_center', array() ),
				'right'  => suki_get_theme_mod( 'header_mobile_elements_main_right', array() ),
			),
			'vertical' => array(
				'top' => suki_get_theme_mod( 'header_mobile_elements_vertical_top', array() ),
			),
		);

		if (
			! boolval( suki_get_current_page_setting( 'disable_header_mobile' ) ) && // Mobile header is not disabled.
			0 < array_sum( array_map( 'count', $elements ) ) // Mobile header has at least 1 element.
		) {
			?>
			<!-- wp:group {
				"align":"full",
				"className":"suki-header-mobile suki-hide-on-desktop"
			} --><div id="mobile-header" class="wp-block-group alignfull suki-header-mobile suki-hide-on-desktop">

				<!-- wp:group {
					"className":"suki-header-mobile-main-bar"
				} --><div class="wp-block-group suki-header-mobile-main-bar">

					<!-- wp:group {
						"className":"suki-header-row",
						"layout":{
							"type":"flex",
							"flexWrap":"nowrap",
							"justifyContent":"space-between"
						}
					} --><div class="wp-block-group suki-header-row">

						<?php
						foreach ( array_keys( $elements['main'] ) as $column ) {
							// Skip center column if it's empty.
							if ( 'center' === $column && 0 === count( $elements ) ) {
								continue;
							}
							?>
							<!-- wp:group {
								"className":"suki-header-column-<?php echo esc_attr( $column ); ?> suki-header-column",
								"layout":{
									"type":"flex",
									"flexWrap":"nowrap",
									"justifyContent":"<?php echo esc_attr( $column ); ?>"
								}
							} --><div class="wp-block-group suki-header-column-<?php echo esc_attr( $column ); ?> suki-header-column">

								<?php
								foreach ( $elements['main'][ $column ] as $element ) {
									suki_header_element( $element, false );
								}
								?>

							</div><!-- /wp:group -->
							<?php
						}
						?>

					</div><!-- /wp:group -->

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

if ( ! function_exists( 'suki_header_mobile__main_bar' ) ) {
	/**
	 * Render mobile header main bar.
	 */
	function suki_header_mobile__main_bar() {
		// Render the template.
		suki_get_template_part( 'header-mobile-main-bar' );
	}
}

if ( ! function_exists( 'suki_header_mobile__popup' ) ) {
	/**
	 * Render mobile header popup.
	 */
	function suki_header_mobile__popup() {
		// Render the template.
		suki_get_template_part( 'header-mobile-popup' );
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

		// Add passing variables.
		$variables = array(
			'element' => $element,
		);

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
				?>
				<a href="<?php echo esc_url( apply_filters( 'suki/frontend/logo_url', home_url( '/' ) ) ); ?>" class="<?php echo esc_attr( 'suki-header-' . $element ); ?> site-branding site-title suki-title" rel="home">
					<?php
					/**
					 * Hook: suki/frontend/logo
					 *
					 * @hooked suki_default_logo - 10
					 */
					do_action( 'suki/frontend/logo' );
					?>
				</a>
				<?php
				$html = ob_get_clean();
				break;

			case 'mobile-logo':
				ob_start();
				?>
				<a href="<?php echo esc_url( apply_filters( 'suki/frontend/logo_url', home_url( '/' ) ) ); ?>" class="<?php echo esc_attr( 'suki-header-' . $element ); ?> site-branding site-title" rel="home">
					<?php
					/**
					 * Hook: suki/frontend/mobile_logo
					 *
					 * @hooked suki_default_mobile_logo - 10
					 */
					do_action( 'suki/frontend/mobile_logo' );
					?>
				</a>
				<?php
				$html = ob_get_clean();
				break;

			case 'mobile-popup-toggle':
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
				$html = get_search_form(
					array(
						'echo' => false,
					)
				);
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
				<div class="<?php echo esc_attr( 'suki-header-' . $element ); ?>">
					<?php echo do_shortcode( suki_get_theme_mod( 'header_' . str_replace( '-', '_', $element ) . '_content' ) ); ?>
				</div>
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
		 * @param string $html HTML markup.
		 */
		$html = apply_filters( 'suki/frontend/header_element/' . $element, $html );

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
