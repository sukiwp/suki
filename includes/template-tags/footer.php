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
	 * @param boolean $echo      Render or return.
	 * @param boolean $do_blocks Parse blocks or not.
	 * @return string
	 */
	function suki_footer( $echo = true, $do_blocks = true ) {
		$html = '
		<!-- wp:pattern {
			"slug":"suki/footer--customizer"
		} -->
		';

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
	 * @param boolean $echo      Render or return.
	 * @param boolean $do_blocks Parse blocks or not.
	 * @return string
	 */
	function suki_footer_widgets( $echo = true, $do_blocks = true ) {
		if ( boolval( suki_get_current_page_setting( 'disable_footer_widgets' ) ) ) {
			return;
		}

		// Get widgets area count.
		$columns = intval( suki_get_theme_mod( 'footer_widgets_bar' ) );
		if ( 1 > $columns ) {
			return;
		}

		// Check widgets area.
		$has_widgets = false;
		for ( $i = 1; $i <= $columns; $i++ ) {
			if ( is_active_sidebar( 'footer-widgets-' . $i ) ) {
				$has_widgets = true;
				break;
			}
		}
		if ( ! $has_widgets ) {
			return;
		}

		$html = '
		<!-- wp:pattern {
			"slug":"suki/footer-widgets--customizer"
		} -->
		';

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
	 * @param boolean $echo      Render or return.
	 * @param boolean $do_blocks Parse blocks or not.
	 * @return string
	 */
	function suki_footer_bottom( $echo = true, $do_blocks = true ) {
		if ( boolval( suki_get_current_page_setting( 'disable_footer_bottom' ) ) ) {
			return;
		}

		// Count elements on all columns.
		$count = count( suki_get_theme_mod( 'footer_elements_bottom_left', array() ) ) + count( suki_get_theme_mod( 'footer_elements_bottom_center', array() ) ) + count( suki_get_theme_mod( 'footer_elements_bottom_right', array() ) );

		// Abort if no element found in this section.
		if ( 1 > $count ) {
			return;
		}

		$html = '
		<!-- wp:pattern {
			"slug":"suki/footer-bottom--customizer"
		} -->
		';

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


if ( ! function_exists( 'suki_footer_element' ) ) {
	/**
	 * Render each footer element.
	 *
	 * @param string  $element Element slug.
	 * @param boolean $echo      Render or return.
	 * @param boolean $do_blocks Parse blocks or not.
	 * @return string
	 */
	function suki_footer_element( $element, $echo = true, $do_blocks = true ) {
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
	 * @param boolean $echo      Render or return.
	 * @param boolean $do_blocks Parse blocks or not.
	 * @return string
	 */
	function suki_scroll_to_top( $echo = true, $do_blocks = true ) {
		if ( ! boolval( suki_get_theme_mod( 'scroll_to_top' ) ) ) {
			return;
		}

		ob_start();
		?>
		<a href="#page" class="<?php echo esc_attr( implode( ' ', apply_filters( 'suki/frontend/scroll_to_top_classes', array( 'suki-scroll-to-top' ) ) ) ); ?>">
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
