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
			$classes = 'suki-header site-header suki-header--mobile-visibility-' . suki_get_theme_mod( 'header_mobile_visibility' );
			?>
			<!-- wp:group {
				"tagName":"header",
				"style":{
					"spacing":{
						"blockGap":"0px"
					}
				},
				"className":"<?php echo esc_attr( $classes ); ?>"
			} --><header id="masthead" class="wp-block-group <?php echo esc_attr( $classes ); ?>" aria-label="<?php esc_attr_e( 'Site Header', 'suki' ); ?>" itemscope itemtype="https://schema.org/WPHeader">

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
				"style":{
					"spacing":{
						"blockGap":"0px"
					}
				},
				"className":"suki-header-desktop"
			} --><div id="header" class="wp-block-group suki-header-desktop">

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

		$classes = suki_element_class( 'header_top_bar', array( 'suki-header-top-bar', 'suki-header-section--horizontal' ), false );

		if ( 0 < array_sum( array_map( 'count', $elements ) ) ) { // Desktop header top bar contains at least 1 element.
			?>
			<!-- wp:group {
				"className":"<?php echo esc_attr( $classes ); ?>",
				"layout":{
					"inherit":true
				}
			} --><div class="wp-block-group <?php echo esc_attr( $classes ); ?>">

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

						$classes = 'suki-header-column suki-header-column--' . $column . ( 0 === count( $elements[ $column ] ) ? ' suki-header-column--empty' : '' );
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

		$classes = suki_element_class( 'header_main_bar', array( 'suki-header-main-bar', 'suki-header-section--horizontal' ), false );

		if ( 0 < array_sum( array_map( 'count', $elements ) ) ) { // Desktop header main bar contains at least 1 element.
			?>
			<!-- wp:group {
				"className":"<?php echo esc_attr( $classes ); ?>",
				"layout":{
					"inherit":true
				}
			} --><div class="wp-block-group <?php echo esc_attr( $classes ); ?>">

				<?php
				if ( boolval( suki_get_theme_mod( 'header_top_bar_merged' ) ) || boolval( suki_get_theme_mod( 'header_bottom_bar_merged' ) ) ) {
					?>
					<!-- wp:group {
						"className":"suki-header-main-bar-merged-wrapper",
						"layout":{
							"type":"flex",
							"orientation":"vertical",
							"flexWrap":"nowrap",
							"justifyContent":"space-between"
						}
					} --><div class="wp-block-group suki-header-main-bar-merged-wrapper">
					<?php
				}

				// Header Top Bar (if merged).
				if ( boolval( suki_get_theme_mod( 'header_top_bar_merged' ) ) ) {
					suki_header_desktop__top_bar( false );
				}
				?>

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

						$classes = 'suki-header-column suki-header-column--' . $column . ( 0 === count( $elements[ $column ] ) ? ' suki-header-column--empty' : '' );
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

				<?php
				// Header Bottom Bar (if merged).
				if ( boolval( suki_get_theme_mod( 'header_bottom_bar_merged' ) ) ) {
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

		$classes = suki_element_class( 'header_bottom_bar', array( 'suki-header-bottom-bar', 'suki-header-section--horizontal' ), false );

		if ( 0 < array_sum( array_map( 'count', $elements ) ) ) { // Desktop header bottom bar contains at least 1 element.
			?>
			<!-- wp:group {
				"className":"<?php echo esc_attr( $classes ); ?>",
				"layout":{
					"inherit":true
				}
			} --><div class="wp-block-group <?php echo esc_attr( $classes ); ?>">

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

						$classes = 'suki-header-column suki-header-column--' . $column . ( 0 === count( $elements[ $column ] ) ? ' suki-header-column--empty' : '' );
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

		if ( ! boolval( suki_get_current_page_setting( 'disable_header_mobile' ) ) ) {
			?>
			<!-- wp:group {
				"style":{
					"spacing":{
						"blockGap":"0px"
					}
				},
				"className":"suki-header-mobile"
			} --><div id="mobile-header" class="wp-block-group suki-header-mobile">

				<?php
				// Mobile main bar.
				suki_header_mobile__main_bar( false );

				// Mobile popup.
				suki_header_mobile__popup( false );
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

if ( ! function_exists( 'suki_header_mobile__main_bar' ) ) {
	/**
	 * Render mobile header main bar.
	 *
	 * @param boolean $do_blocks Parse blocks or not.
	 * @param boolean $echo      Render or return.
	 * @return string
	 */
	function suki_header_mobile__main_bar( $do_blocks = true, $echo = true ) {
		ob_start();

		$elements = array(
			'left'   => suki_get_theme_mod( 'header_mobile_elements_main_left', array() ),
			'center' => suki_get_theme_mod( 'header_mobile_elements_main_center', array() ),
			'right'  => suki_get_theme_mod( 'header_mobile_elements_main_right', array() ),
		);

		$classes = suki_element_class( 'header_mobile_main_bar', array( 'suki-header-mobile-main-bar' ), false );

		if ( 0 < array_sum( array_map( 'count', $elements ) ) ) { // Mobile header main bar contains at least 1 element.
			?>
			<!-- wp:group {
				"className":"<?php echo esc_attr( $classes ); ?>"
			} --><div class="wp-block-group <?php echo esc_attr( $classes ); ?>">

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

if ( ! function_exists( 'suki_header_mobile__popup' ) ) {
	/**
	 * Render mobile header popup.
	 *
	 * @param boolean $do_blocks Parse blocks or not.
	 * @param boolean $echo      Render or return.
	 * @return string
	 */
	function suki_header_mobile__popup( $do_blocks = true, $echo = true ) {
		ob_start();

		$elements = array(
			'top' => suki_get_theme_mod( 'header_mobile_elements_vertical_top', array() ),
		);

		$classes = suki_element_class( 'header_mobile_vertical', array( 'suki-header-mobile-popup', 'suki-popup' ), false );

		if ( 0 < count( $elements ) ) { // Mobile header popup contains at least 1 element.
			?>
			<div id="mobile-header-popup" class="<?php echo esc_attr( $classes ); ?>">

				<div class="suki-popup__background suki-popup__close">
					<button class="suki-popup__close suki-toggle"><?php suki_icon( 'close' ); ?></button>
				</div>

				<!-- wp:group {
					"className":"suki-popup__content",
					"layout":{
						"type":"flex",
						"orientation":"vertical",
					}
				} --><div class="wp-block-group suki-popup__content">

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
				?>
				<<?php echo esc_attr( $tag ); ?>>
					<a href="<?php echo esc_url( apply_filters( 'suki/frontend/logo_url', home_url( '/' ) ) ); ?>" class="<?php echo esc_attr( 'suki-header-' . $element ); ?> suki-logo site-branding site-title suki-title" rel="home">
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
				?>
				<div>
					<a href="<?php echo esc_url( apply_filters( 'suki/frontend/logo_url', home_url( '/' ) ) ); ?>" class="<?php echo esc_attr( 'suki-header-' . $element ); ?> suki-logo site-branding site-title" rel="home">
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
