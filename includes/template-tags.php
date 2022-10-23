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
		<a href="<?php echo esc_attr( add_query_arg( 'action', 'locations', admin_url( 'nav-menus.php' ) ) ); ?>">
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
		<div class="suki-default-logo"><?php suki_logo( suki_get_theme_mod( 'custom_logo' ) ); ?></div>
		<?php
	}
}

if ( ! function_exists( 'suki_default_logo_mobile' ) ) {
	/**
	 * Print / return HTML markup for default mobile logo.
	 */
	function suki_default_logo_mobile() {
		$mobile_logo = suki_get_theme_mod( 'custom_logo_mobile' );

		if ( empty( $mobile_logo ) ) {
			$mobile_logo = suki_get_theme_mod( 'custom_logo' );
		}
		?>
		<span class="suki-default-logo"><?php suki_logo( $mobile_logo ); ?></span>
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

require_once trailingslashit( SUKI_INCLUDES_DIR ) . 'template-tags/header.php';
require_once trailingslashit( SUKI_INCLUDES_DIR ) . 'template-tags/footer.php';
require_once trailingslashit( SUKI_INCLUDES_DIR ) . 'template-tags/content.php';
require_once trailingslashit( SUKI_INCLUDES_DIR ) . 'template-tags/post.php';
require_once trailingslashit( SUKI_INCLUDES_DIR ) . 'template-tags/archive.php';
require_once trailingslashit( SUKI_INCLUDES_DIR ) . 'template-tags/singular.php';
