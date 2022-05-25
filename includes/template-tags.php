<?php
/**
 * Render template functions.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ====================================================
 * Global template functions
 * ====================================================
 */

if ( ! function_exists( 'suki_skip_to_content_link' ) ) {
	/**
	 * Render skip to content link.
	 */
	function suki_skip_to_content_link() {
		?>
		<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'suki' ); ?></a>
		<?php
	}
}

if ( ! function_exists( 'suki_unassigned_menu' ) ) {
	/**
	 * Fallback HTML if there is no nav menu assigned to a navigation location.
	 */
	function suki_unassigned_menu() {
		// Abort if current user has no access to edit menus.
		if ( ! is_user_logged_in() || ! current_user_can( 'edit_theme_options' ) ) {
			return;
		}
		?>
		<a href="<?php echo esc_attr( add_query_arg( 'action', 'locations', admin_url( 'nav-menus.php' ) ) ); ?>" class="suki-menu-item-link">
			<em><?php esc_html_e( 'Add a menu', 'suki' ); ?></em>
		</a>
		<?php
	}
}

if ( ! function_exists( 'suki_element_class' ) ) {
	/**
	 * Print element classes from specified default classes array and classes added via the provided filter.
	 *
	 * @param string       $element Element key.
	 * @param string|array $classes Classes array.
	 * @param boolean      $echo    Render or return.
	 * @return string
	 */
	function suki_element_class( $element, $classes = array(), $echo = true ) {
		// Build filter tag.
		$filter = 'suki/frontend/' . str_replace( '-', '_', $element ) . '_classes';

		// Convert string parameter $classes to array.
		if ( is_string( $classes ) ) {
			$classes = explode( ' ', $classes );
		}

		/**
		 * Filter: suki/frontend/{$element}_classes
		 *
		 * @param array $classes Classes array.
		 */
		$classes = apply_filters( $filter, $classes );

		// Convert array to string.
		$classes_string = implode( ' ', $classes );

		// Render or return.
		if ( boolval( $echo ) ) {
			echo esc_attr( $classes_string );
		} else {
			return esc_attr( $classes_string );
		}
	}
}

if ( ! function_exists( 'suki_post_class' ) ) {
	/**
	 * Print post classes from specified default classes array, WordPress post classes, and classes added via the provided filter.
	 *
	 * @uses suki_element_class()
	 *
	 * @param string|array $classes Classes array.
	 * @param boolean      $echo    Render or return.
	 * @return string
	 */
	function suki_post_class( $classes = array(), $echo = true ) {
		// Convert string parameter $classes to array.
		if ( is_string( $classes ) ) {
			$classes = explode( ' ', $classes );
		}

		// Render or return classes via `suki_element_class` function.
		return suki_element_class( 'post_' . get_the_ID(), array_merge( get_post_class(), $classes ), $echo );
	}
}

if ( ! function_exists( 'suki_inline_svg' ) ) {
	/**
	 * Print / return inline SVG HTML tags.
	 *
	 * @param string  $svg_file SVG file path.
	 * @param boolean $echo     Render or return.
	 * @return string
	 */
	function suki_inline_svg( $svg_file, $echo = true ) {
		// Return empty if no SVG file path is provided.
		if ( empty( $svg_file ) ) {
			return;
		}

		// Get SVG markup.
		$html = file_get_contents( $svg_file );

		// Remove XML encoding tag.
		// This should not be printed on inline SVG.
		$html = preg_replace( '/<\?xml(?:.*?)\?>/', '', $html );

		// Add width attribute if not found in the SVG markup.
		// Width value is extracted from viewBox attribute.
		if ( ! preg_match( '/<svg.*?width.*?>/', $html ) ) {
			if ( preg_match( '/<svg.*?viewBox="0 0 ([0-9.]+) ([0-9.]+)".*?>/', $html, $matches ) ) {
				$html = preg_replace( '/<svg (.*?)>/', '<svg $1 width="' . $matches[1] . '" height="' . $matches[2] . '">', $html );
			}
		}

		// Remove <title> from SVG markup.
		// Site name would be added as a screen reader text to represent the logo.
		$html = preg_replace( '/<title>.*?<\/title>/', '', $html );

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

			/**
			 * Filter: suki/frontend/logo/use_inline_svg
			 *
			 * @param boolean $use_inline_svg Use inline or not.
			 */
			$use_inline_svg = apply_filters( 'suki/frontend/logo/use_inline_svg', false );

			// Build logo image tag.
			if ( 'image/svg+xml' === $mime && $use_inline_svg ) {
				$logo_image = suki_inline_svg( get_attached_file( $logo_image_id ), false );
			} else {
				$logo_image = wp_get_attachment_image(
					$logo_image_id,
					'full',
					0,
					array(
						'alt' => get_bloginfo( 'name', 'display' ),
					)
				);
			}

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
		<div class="suki-default-logo suki-logo"><?php suki_logo( suki_get_theme_mod( 'custom_logo' ) ); ?></div>
		<?php
	}
}

if ( ! function_exists( 'suki_default_logo_mobile' ) ) {
	/**
	 * Print / return HTML markup for default mobile logo.
	 */
	function suki_default_logo_mobile() {
		?>
		<span class="suki-default-logo suki-logo"><?php suki_logo( suki_get_theme_mod( 'custom_logo_mobile' ) ); ?></span>
		<?php
	}
}

if ( ! function_exists( 'suki_icon' ) ) {
	/**
	 * Print / return HTML markup for specified icon type in SVG format.
	 *
	 * @param string  $key  Icon slug.
	 * @param array   $args Array of parameters.
	 * @param boolean $echo Render or return the HTML tags.
	 * @return string
	 */
	function suki_icon( $key, $args = array(), $echo = true ) {
		$args = wp_parse_args(
			$args,
			array(
				'title' => '',
				'class' => '',
			)
		);

		$classes = implode( ' ', array( 'suki-icon', $args['class'] ) );

		// Get SVG path.
		$path = get_template_directory() . '/assets/icons/' . $key . '.svg';

		/**
		 * Filter: suki/frontend/svg_icon_path
		 *
		 * @param string $path SVG icon path.
		 * @param string $key  Icon key.
		 */
		$path = apply_filters( 'suki/frontend/svg_icon_path', $path, $key );

		/**
		 * Filter: suki/frontend/svg_icon_path/{$key}
		 *
		 * @param string $path SVG icon path.
		 */
		$path = apply_filters( 'suki/frontend/svg_icon_path/' . $key, $path );

		// Get SVG markup.
		if ( file_exists( $path ) ) {
			$svg = suki_inline_svg( $path, false );
		} else {
			$svg = suki_inline_svg( get_template_directory() . '/assets/icons/_fallback.svg', false ); // Fallback SVG markup.
		}

		/**
		 * Filter: suki/frontend/svg_icon
		 *
		 * @param string $path SVG icon HTML markup.
		 * @param string $key  Icon key.
		 */
		$svg = apply_filters( 'suki/frontend/svg_icon', $svg, $key );

		/**
		 * Filter: suki/frontend/svg_icon/{$key}
		 *
		 * @param string $path SVG icon HTML markup.
		 */
		$svg = apply_filters( 'suki/frontend/svg_icon/' . $key, $svg );

		// Wrap the icon with "suki-icon" span tag.
		$html = '<span class="' . esc_attr( $classes ) . '" title="' . esc_attr( $args['title'] ) . '" aria-hidden="true">' . $svg . '</span>';

		// Render or return.
		if ( boolval( $echo ) ) {
			echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		} else {
			return $html;
		}
	}
}

if ( ! function_exists( 'suki_social_links' ) ) {
	/**
	 * Print / return HTML markup for specified set of social media links.
	 *
	 * @param array   $links Array of social link slugs.
	 * @param array   $args  Array of parameters.
	 * @param boolean $echo  Render or return the HTML tags.
	 * @return string
	 */
	function suki_social_links( $links = array(), $args = array(), $echo = true ) {
		$labels = suki_get_social_media_types( true );

		$args = wp_parse_args(
			$args,
			array(
				'before_link' => '',
				'after_link'  => '',
				'link_class'  => '',
			)
		);

		ob_start();
		foreach ( $links as $link ) {
			echo $args['before_link']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			?>
			<a href="<?php echo esc_url( $link['url'] ); ?>" class="suki-social-link <?php echo esc_attr( 'suki-social-link--' . $link['type'] ); ?>" <?php echo '_blank' === suki_array_value( $link, 'target', '_self' ) ? ' target="_blank" rel="noopener"' : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
				<?php
				suki_icon(
					$link['type'],
					array(
						'title' => $labels[ $link['type'] ],
						'class' => $args['link_class'],
					)
				);
				?>
				<span class="screen-reader-text"><?php echo esc_html( $labels[ $link['type'] ] ); ?></span>
			</a>
			<?php
			echo $args['after_link']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
		$html = ob_get_clean();

		// Render or return.
		if ( boolval( $echo ) ) {
			echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		} else {
			return $html;
		}
	}
}

/**
 * ====================================================
 * Header template functions
 * ====================================================
 */

if ( ! function_exists( 'suki_header' ) ) {
	/**
	 * Render header wrapper.
	 */
	function suki_header() {
		/**
		 * Hook: suki/frontend/before_header
		 */
		do_action( 'suki/frontend/before_header' );

		?>
		<header id="masthead" class="suki-header site-header" aria-label="<?php esc_attr_e( 'Site Header', 'suki' ); ?>" itemscope itemtype="https://schema.org/WPHeader">
			<?php
			/**
			 * Hook: suki/frontend/header
			 *
			 * @hooked suki_header_desktop - 10
			 * @hooked suki_header_mobile - 10
			 */
			do_action( 'suki/frontend/header' );
			?>
		</header>
		<?php

		/**
		 * Hook: suki/frontend/after_header
		 */
		do_action( 'suki/frontend/after_header' );
	}
}

if ( ! function_exists( 'suki_header_desktop' ) ) {
	/**
	 * Render main header.
	 */
	function suki_header_desktop() {
		if ( boolval( suki_get_current_page_setting( 'disable_header' ) ) ) {
			return;
		}

		// Render the template.
		suki_get_template_part( 'header-desktop' );
	}
}

if ( ! function_exists( 'suki_header_desktop__top_bar' ) ) {
	/**
	 * Render header top bar.
	 */
	function suki_header_desktop__top_bar() {
		// Render the template.
		suki_get_template_part( 'header-desktop-top-bar' );
	}
}

if ( ! function_exists( 'suki_header_desktop__main_bar' ) ) {
	/**
	 * Render header main bar.
	 */
	function suki_header_desktop__main_bar() {
		// Render the template.
		suki_get_template_part( 'header-desktop-main-bar' );
	}
}

if ( ! function_exists( 'suki_header_desktop__bottom_bar' ) ) {
	/**
	 * Render header bottom bar.
	 */
	function suki_header_desktop__bottom_bar() {
		// Render the template.
		suki_get_template_part( 'header-desktop-bottom-bar' );
	}
}

if ( ! function_exists( 'suki_header_mobile' ) ) {
	/**
	 * Render mobile header.
	 */
	function suki_header_mobile() {
		if ( boolval( suki_get_current_page_setting( 'disable_header_mobile' ) ) ) {
			return;
		}

		suki_get_template_part( 'header-mobile' );
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

if ( ! function_exists( 'suki_header_element' ) ) {
	/**
	 * Wrapper function to print HTML markup for all header element.
	 *
	 * @param string $element Element slug.
	 */
	function suki_header_element( $element ) {
		// Abort if element slug is empty.
		if ( empty( $element ) ) {
			return;
		}

		// Classify element into its type.
		$type = preg_replace( '/-\d$/', '', $element );

		// Add passing variables.
		$variables = array(
			'element' => $element,
		);

		// Get header element template.
		$html = suki_get_template_part( 'header-element-' . $type, null, $variables, false );

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

		echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

/**
 * ====================================================
 * Hero section template functions
 * ====================================================
 */

if ( ! function_exists( 'suki_hero' ) ) {
	/**
	 * Render page header section.
	 */
	function suki_hero() {
		// Abort if disable content header option is checked on the current loaded page.
		if ( boolval( suki_get_current_page_setting( 'disable_content_header' ) ) ) {
			return;
		}

		// Abort if hero is disabled on the current loaded page.
		if ( ! boolval( suki_get_current_page_setting( 'hero' ) ) ) {
			return;
		}

		// Render the template.
		suki_get_template_part( 'hero' );
	}
}

/**
 * ====================================================
 * Content header template functions
 * ====================================================
 */

if ( ! function_exists( 'suki_content_header' ) ) {
	/**
	 * Render content header.
	 */
	function suki_content_header() {
		// Abort if disable content header option is checked on the current loaded page.
		if ( boolval( suki_get_current_page_setting( 'disable_content_header' ) ) ) {
			return;
		}

		// Render the template.
		suki_get_template_part( 'content-header' );
	}
}

if ( ! function_exists( 'suki_content_header_element' ) ) {
	/**
	 * Render content header element.
	 *
	 * @param string  $element Element slug.
	 * @param boolean $echo    Render or return.
	 * @return string
	 */
	function suki_content_header_element( $element, $echo = true ) {
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
					$html = do_blocks(
						'
						<!-- wp:heading {
							"className":"entry-title suki-title"
						} --><h2 class="entry-title suki-title">' . $title . '</h2><!-- /wp:heading -->
						'
					);
				}
				break;

			case 'archive-description':
				// We can't replace this with Gutenberg block yet, because it doesn't cover Author and Post Type archive description.
				if ( ! is_post_type_archive() ) {
					$desc = trim( get_the_archive_description() );

					if ( ! empty( $desc ) ) {
						$html = '<div class="archive-description">' . $desc . '</div>';
					}
				}
				break;

			case 'search-form':
				// We can't replace this with Gutenberg block yet, because the Search block style is not same as our theme's search bar.
				$html = get_search_form( array( 'echo' => false ) );
				break;

			case 'header-meta':
				$html = suki_entry_meta( suki_get_current_page_setting( 'content_header_meta' ), false );
				break;

			case 'hr':
				$html = do_blocks(
					'
					<!-- wp:separator {
						"className":"is-style-wide"
					} --><hr class="wp-block-separator has-alpha-channel-opacity is-style-wide"/><!-- /wp:separator -->
					'
				);
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

		// Render or return.
		if ( boolval( $echo ) ) {
			echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		} else {
			return $html;
		}
	}
}

if ( ! function_exists( 'suki_content_footer_element' ) ) {
	/**
	 * Render content footer element.
	 *
	 * @param string $element Element slug.
	 */
	function suki_content_footer_element( $element ) {
		// Abort if element slug is empty.
		if ( empty( $element ) ) {
			return;
		}

		switch ( $element ) {
			case 'tags':
				$html = do_blocks(
					'
					<!-- wp:post-terms {
						"term":"post_tag"
					} /-->
					'
				);
				break;

			case 'footer-meta':
				$html = suki_entry_meta( suki_get_current_page_setting( 'content_footer_meta' ), false );
				break;

			case 'hr':
				$html = do_blocks(
					'
					<!-- wp:separator {
						"className":"is-style-wide"
					} --><hr class="wp-block-separator has-alpha-channel-opacity is-style-wide"/><!-- /wp:separator -->
					'
				);
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

		echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

/**
 * ====================================================
 * Content section template functions
 * ====================================================
 */

if ( ! function_exists( 'suki_content_open' ) ) {
	/**
	 * Render content section opening tags.
	 */
	function suki_content_open() {
		if ( 'narrow' === suki_get_current_page_setting( 'content_container' ) ) {
			$template = 'content--open';
		} else {
			switch ( suki_get_current_page_setting( 'content_layout' ) ) {
				case 'left-sidebar':
				case 'right-sidebar':
					$template = 'content-with-sidebar--open';
					break;

				default:
					$template = 'content--open';
					break;
			}
		}

		suki_get_template_part( $template );
	}
}

if ( ! function_exists( 'suki_content_close' ) ) {
	/**
	 * Render content section closing tags.
	 */
	function suki_content_close() {
		if ( 'narrow' === suki_get_current_page_setting( 'content_container' ) ) {
			$template = 'content--close';
		} else {
			switch ( suki_get_current_page_setting( 'content_layout' ) ) {
				case 'left-sidebar':
				case 'right-sidebar':
					$template = 'content-with-sidebar--close';
					break;

				default:
					$template = 'content--close';
					break;
			}
		}

		suki_get_template_part( $template );
	}
}

/**
 * ====================================================
 * Footer template functions
 * ====================================================
 */

if ( ! function_exists( 'suki_footer' ) ) {
	/**
	 * Render footer wrapper.
	 */
	function suki_footer() {
		?>
		<footer id="colophon" class="suki-footer site-footer" aria-label="<?php esc_attr_e( 'Site Footer', 'suki' ); ?>" itemscope itemtype="https://schema.org/WPFooter">
			<?php
			/**
			 * Hook: suki/frontend/footer
			 *
			 * @hooked suki_main_footer - 10
			 */
			do_action( 'suki/frontend/footer' );
			?>
		</footer>
		<?php
	}
}

if ( ! function_exists( 'suki_main_footer' ) ) {
	/**
	 * Render footer sections.
	 */
	function suki_main_footer() {
		// Widgets Bar.
		suki_footer_widgets();

		// Bottom Bar (if not merged).
		if ( ! boolval( suki_get_theme_mod( 'footer_bottom_bar_merged' ) ) ) {
			suki_footer_bottom();
		}
	}
}

if ( ! function_exists( 'suki_footer_widgets' ) ) {
	/**
	 * Render footer widgets area.
	 */
	function suki_footer_widgets() {
		if ( boolval( suki_get_current_page_setting( 'disable_footer_widgets' ) ) ) {
			return;
		}

		// Get widgets area count.
		$columns = intval( suki_get_theme_mod( 'footer_widgets_bar' ) );
		if ( 1 > $columns ) {
			return;
		}

		// Check widgets area.
		$print_row = 0;
		for ( $i = 1; $i <= $columns; $i++ ) {
			if ( is_active_sidebar( 'footer-widgets-' . $i ) ) {
				$print_row = true;
				break;
			}
		}

		// Render the template.
		suki_get_template_part( 'footer-widgets' );
	}
}

if ( ! function_exists( 'suki_footer_bottom' ) ) {
	/**
	 * Render footer bottom bar.
	 */
	function suki_footer_bottom() {
		if ( boolval( suki_get_current_page_setting( 'disable_footer_bottom' ) ) ) {
			return;
		}

		// Count elements on all columns.
		$count = count( suki_get_theme_mod( 'footer_elements_bottom_left', array() ) ) + count( suki_get_theme_mod( 'footer_elements_bottom_center', array() ) ) + count( suki_get_theme_mod( 'footer_elements_bottom_right', array() ) );

		// Abort if no element found in this section.
		if ( 1 > $count ) {
			return;
		}

		// Render the template.
		suki_get_template_part( 'footer-bottom' );
	}
}

if ( ! function_exists( 'suki_footer_element' ) ) {
	/**
	 * Render each footer element.
	 *
	 * @param string $element Element slug.
	 */
	function suki_footer_element( $element ) {
		// Abort if element slug is empty.
		if ( empty( $element ) ) {
			return;
		}

		// Classify element into its type.
		$type = preg_replace( '/-\d$/', '', $element );

		// Add passing variables.
		$variables = array(
			'element' => $element,
			'slug'    => $element,
		); // $slug is fallback attribute name used prior Suki v1.3.

		// Get footer element template.
		$html = suki_get_template_part( 'footer-element-' . $type, null, $variables, false );

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

		echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

if ( ! function_exists( 'suki_scroll_to_top' ) ) {
	/**
	 * Print scroll to top button.
	 */
	function suki_scroll_to_top() {
		if ( ! boolval( suki_get_theme_mod( 'scroll_to_top' ) ) ) {
			return;
		}

		suki_get_template_part( 'scroll-to-top' );
	}
}

/**
 * ====================================================
 * Archive pages template functions
 * ====================================================
 */

if ( ! function_exists( 'suki_archive_navigation' ) ) {
	/**
	 * Render posts loop navigation.
	 */
	function suki_archive_navigation() {
		if ( ! is_archive() && ! is_home() && ! is_search() ) {
			return;
		}

		// Render posts navigation.
		switch ( suki_get_theme_mod( 'blog_index_navigation_mode' ) ) {
			case 'pagination':
				echo do_blocks( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					'
					<!-- wp:query-pagination {
						"paginationArrow":"arrow",
						"layout":{
							"type":"flex",
							"justifyContent":"center",
							"orientation":"horizontal"
						},
						"className":"suki-has-margin-top__300 suki-has-margin-bottom__150"
					} -->

						<!-- wp:query-pagination-previous {
							"label":" "
						} /-->

						<!-- wp:query-pagination-numbers /-->

						<!-- wp:query-pagination-next {
							"label":" "
						} /-->

					<!-- /wp:query-pagination -->
					'
				);
				break;

			default:
				echo do_blocks( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					'
					<!-- wp:query-pagination {
						"paginationArrow":"arrow",
						"layout":{
							"type":"flex",
							"justifyContent":"space-between",
							"orientation":"horizontal"
						},
						"className":"suki-has-margin-block__150"
					} -->

						<!-- wp:query-pagination-previous {
							"label":"' . esc_html__( 'Newer Posts', 'suki' ) . '"
						} /-->

						<!-- wp:query-pagination-next {
							"label":"' . esc_html__( 'Older Posts', 'suki' ) . '"
						} /-->

					<!-- /wp:query-pagination -->
					'
				);
				break;
		}
	}
}

/**
 * ====================================================
 * Singular template functions
 * ====================================================
 */

if ( ! function_exists( 'suki_singular_thumbnail' ) ) {
	/**
	 * Print singular featured image.
	 *
	 * @since 2.0.0
	 */
	function suki_singular_thumbnail() {
		echo do_blocks( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			'
			<!-- wp:post-featured-image {
				' . ( boolval( suki_get_current_page_setting( 'content_thumbnail_wide' ) ) ? '"align":"wide",' : '' ) . '
				"className":"entry-thumbnail"
			} /-->
			'
		);
	}
}

if ( ! function_exists( 'suki_author_bio' ) ) {
	/**
	 * Render singular author bio.
	 *
	 * @since 2.0.0
	 */
	function suki_author_bio() {
		echo do_blocks( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			'
			<!-- wp:post-author {
				"avatarSize":96,
				"showBio":true,
				"style":{
					"spacing":{
						"padding":{
							"top":"1.5rem",
							"right":"1.5rem",
							"bottom":"1.5rem",
							"left":"1.5rem"
						},
						"margin":{
							"top":"3rem"
						}
					}
				},
				"className":"entry-author"
			} /-->
			'
		);
	}
}

if ( ! function_exists( 'suki_singular_navigation' ) ) {
	/**
	 * Render singular prev / next post navigation in single post page.
	 *
	 * @since 2.0.0
	 */
	function suki_singular_navigation() {
		echo do_blocks( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			'
			<!-- wp:group {
				"layout":{
					"type":"flex",
					"flexWrap":"nowrap",
					"justifyContent":"space-between"
				},
				"style":{
					"spacing":{
						"margin":{
							"top":"3rem"
						}
					}
				},
				"className":"navigation post-navigation"
			} --><div class="wp-block-group" style="margin-top:3rem">

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
			'
		);
	}
}

if ( ! function_exists( 'suki_comments' ) ) {
	/**
	 * Print singular comments.
	 *
	 * @since 2.0.0
	 */
	function suki_comments() {
		echo do_blocks( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			'
			<!-- wp:comments-query-loop {
				"className":"suki-has-margin-top__200"
			} --><div class="wp-block-comments-query-loop suki-has-margin-top__200">

				<!-- wp:comments-title /-->

				<!-- wp:comment-template {
					"className":"suki-has-margin-top__200"
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
									"blockGap":"1rem"
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
											"blockGap":"0.75rem"
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
					"className":"suki-has-margin-top__200"
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
					"className":"suki-has-margin-top__200"
				} /-->

			</div><!-- /wp:comments-query-loop -->
			'
		);
	}
}

/**
 * ====================================================
 * Entry header & footer template functions
 * ====================================================
 */

if ( ! function_exists( 'suki_entry_header_footer_element' ) ) {
	/**
	 * Print entry header & footer element.
	 *
	 * @param string $element Element slug.
	 * @param string $layout Layout slug.
	 */
	function suki_entry_header_footer_element( $element, $layout = 'default' ) {
		// Set fallback layout to "default".
		if ( empty( $layout ) ) {
			$layout = 'default';
		}

		// Abort if element slug is empty.
		if ( empty( $element ) ) {
			return;
		}

		$html = '';

		switch ( $element ) {
			case 'title':
				$html = do_blocks( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					'
					<!-- wp:post-title {
						"className":"entry-title ' . ( 'default' === $layout ? 'suki-title' : 'suki-small-title' ) . '"
					} /-->
					'
				);
				break;

			case 'header-meta':
				$html = suki_entry_meta( suki_get_theme_mod( 'entry_' . ( 'default' === $layout ? '' : $layout . '_' ) . 'header_meta' ), false );
				break;

			case 'footer-meta':
				$html = suki_entry_meta( suki_get_theme_mod( 'entry_' . ( 'default' === $layout ? '' : $layout . '_' ) . 'footer_meta' ), false );
				break;
		}

		/**
		 * Filter: suki/frontend/entry_header_footer_element
		 *
		 * @param string $html    HTML markup.
		 * @param string $element Element slug.
		 */
		$html = apply_filters( 'suki/frontend/entry_header_footer_element', $html, $element );

		/**
		 * Filter: suki/frontend/entry_header_footer_element/{$element}
		 *
		 * @param string $html HTML markup.
		 */
		$html = apply_filters( 'suki/frontend/entry_header_footer_element/' . $element, $html );

		echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

if ( ! function_exists( 'suki_entry_meta' ) ) {
	/**
	 * Print entry meta.
	 *
	 * @since 2.0.0 Add $echo parameter with default to true.
	 *
	 * @param string  $text Format text.
	 * @param boolean $echo Render or return.
	 * @return string
	 */
	function suki_entry_meta( $text, $echo = true ) {
		if ( 'post' !== get_post_type() ) {
			return;
		}

		// Remove unneccessary white space on the beginning and the end of the text.
		$text = trim( $text );

		// Abort if format is empty.
		if ( empty( $text ) ) {
			return;
		}

		/**
		 * Parse formatted tags.
		 */

		// Wrap the first and last elements.
		$text = '<span>' . $text . '</span>';

		// Open and close wrap for syntax.
		$text = str_replace( '{{', '</span>{{', $text );
		$text = str_replace( '}}', '}}<span>', $text );

		// Remove blank parts.
		$text = str_replace( '<span></span>', '', $text );

		/**
		 * Convert syntax tag to blocks.
		 */

		// Get all smart tags.
		preg_match_all( '/{{(.*?)}}/', $text, $matches, PREG_SET_ORDER );

		// Iterate each smart tag and convert it to real HTML.
		foreach ( $matches as $match ) {
			$meta = suki_entry_meta_element( $match[1], false );

			$text = str_replace( $match[0], $meta, $text );
		}

		/**
		 * Build return text.
		 */

		$html = do_blocks(
			'
			<!-- wp:group {
				"layout":{
					"type":"flex",
					"flexWrap":"wrap"
				},
				"style":{
					"spacing":{
						"blockGap":"0px"
					}
				},
				"className":"entry-meta suki-meta suki-reverse-link-color"
			} --><div class="wp-block-group entry-meta suki-meta suki-reverse-link-color">

				' . $text . '

			</div><!-- /wp:group -->
			'
		);

		// Render or return.
		if ( boolval( $echo ) ) {
			echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		} else {
			return $html;
		}
	}
}

if ( ! function_exists( 'suki_entry_meta_element' ) ) {
	/**
	 * Print entry meta element.
	 *
	 * @since 2.0.0 Add $echo parameter with default to true.
	 *
	 * @param string  $element Element slug.
	 * @param boolean $echo    Render or return.
	 * @return string
	 */
	function suki_entry_meta_element( $element, $echo = true ) {
		$html = $element;

		switch ( $element ) {
			case 'date':
				$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
				if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
					$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated screen-reader-text" datetime="%3$s">%4$s</time>';
				}
				$time_string = sprintf(
					$time_string,
					esc_attr( get_the_date( 'c' ) ),
					esc_html( get_the_date() ),
					esc_attr( get_the_modified_date( 'c' ) ),
					esc_html( get_the_modified_date() )
				);

				$html = '<span class="entry-meta-date"><a href="' . esc_url( get_permalink() ) . '" class="posted-on">' . $time_string . '</a></span>';
				break;

			case 'author':
				$html = '<span class="entry-meta-author author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author_meta( 'display_name' ) ) . '</a></span>';
				break;

			case 'avatar':
				$avatar_size = 2 * suki_get_theme_mod( 'meta_font_size' );

				/**
				 * Filter: suki/frontend/meta_avatar_size
				 *
				 * @param integer $avatar_size
				 */
				$avatar_size = apply_filters( 'suki/frontend/meta_avatar_size', $avatar_size );

				$html = '<span class="entry-meta-author-avatar">' . get_avatar( get_the_author_meta( 'ID' ), $avatar_size ) . '</span>';
				break;

			case 'categories':
				$html = '<span class="entry-meta-categories cat-links">' . get_the_category_list( esc_html_x( ', ', 'terms list separator', 'suki' ) ) . '</span>';
				break;

			case 'tags':
				$html = '<span class="entry-meta-tags tags-links">' . get_the_tag_list( '', esc_html_x( ', ', 'terms list separator', 'suki' ) ) . '</span>';
				break;

			case 'comments':
				if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
					ob_start();
					comments_popup_link();
					$link = ob_get_clean();

					$html = '<span class="entry-meta-comments comments-link">' . $link . '</span>';
				}
				break;

			default:
				$html = $element;
				break;
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
 * ====================================================
 * Default Post Layout template functions
 * ====================================================
 */

if ( ! function_exists( 'suki_entry_thumbnail' ) ) {
	/**
	 * Print entry thumbnail.
	 */
	function suki_entry_thumbnail() {
		$size = suki_get_theme_mod( 'entry_thumbnail_size', 'full' );

		echo do_blocks( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			'
			<!-- wp:post-featured-image {
				"isLink":true,
				' . ( 'full' !== $size ? '"width":' . get_option( $size . '_size_w' ) . ',' : '' ) . '
				' . ( 'full' !== $size ? '"height":' . get_option( $size . '_size_h' ) . ',' : '' ) . '
				' . ( boolval( suki_get_theme_mod( 'entry_thumbnail_wide' ) ) ? '"align":"wide",' : '' ) . '
				"className":"' . suki_element_class( 'entry/thumbnail', array( 'entry-thumbnail' ), false ) . '"
			} /-->
			'
		);
	}
}

/**
 * ====================================================
 * Grid Post Layout template functions
 * ====================================================
 */

if ( ! function_exists( 'suki_entry_grid_thumbnail' ) ) {
	/**
	 * Print entry grid thumbnail.
	 */
	function suki_entry_grid_thumbnail() {
		$size = suki_get_theme_mod( 'entry_grid_thumbnail_size', 'full' );

		echo do_blocks( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			'
			<!-- wp:post-featured-image {
				"isLink":true,
				' . ( 'full' !== $size ? '"width":' . get_option( $size . '_size_w' ) . ',' : '' ) . '
				' . ( 'full' !== $size ? '"height":' . get_option( $size . '_size_h' ) . ',' : '' ) . '
				' . ( boolval( suki_get_theme_mod( 'entry_grid_thumbnail_wide' ) ) ? '"align":"wide",' : '' ) . '
				"className":"' . suki_element_class( 'entry_grid/thumbnail', array( 'entry-thumbnail' ), false ) . '"
			} /-->
			'
		);
	}
}
