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

		$markups = suki_get_svg_icon_markups();

		if ( isset( $markups[ $key ] ) ) {
			$svg = $markups[ $key ];
			$svg = suki_clean_svg_markup( $svg );
		} else {
			$svg = '<svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 64 64"><path d="M46.14,43.31a2,2,0,0,1-2.83,2.83L32,34.83,20.69,46.14a2,2,0,1,1-2.83-2.83L29.17,32,17.86,20.69a2,2,0,1,1,2.83-2.83L32,29.17,43.31,17.86a2,2,0,1,1,2.83,2.83L34.83,32ZM0,4V7H4V6A2,2,0,0,1,6,4H7V0H4A4,4,0,0,0,0,4ZM4,27H0V17H4ZM4,47H0V37H4ZM6,60H7v4H4a4,4,0,0,1-4-4V57H4v1A2,2,0,0,0,6,60ZM17,0H27V4H17ZM37,0H47V4H37ZM64,4V7H60V6a2,2,0,0,0-2-2H57V0h3A4,4,0,0,1,64,4ZM60,17h4V27H60Zm0,20h4V47H60ZM17,60H27v4H17Zm43-3h4v3a4,4,0,0,1-4,4H57V60h1a2,2,0,0,0,2-2ZM37,60H47v4H37Z"/></svg>';
		}

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
