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
 * Header section
 */
if ( ! function_exists( 'suki_header' ) ) {
	/**
	 * Render header.
	 *
	 * @param boolean $echo      Render or return.
	 * @param boolean $do_blocks Parse blocks or not.
	 * @return string
	 */
	function suki_header( $echo = true, $do_blocks = true ) {
		$html = '
		<!-- wp:pattern {
			"slug":"suki/header--customizer"
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
 * Desktop header
 */
if ( ! function_exists( 'suki_header_desktop' ) ) {
	/**
	 * Render desktop header.
	 *
	 * @param boolean $echo      Render or return.
	 * @param boolean $do_blocks Parse blocks or not.
	 * @return string
	 */
	function suki_header_desktop( $echo = true, $do_blocks = true ) {
		if ( boolval( suki_get_current_page_setting( 'disable_header' ) ) ) {
			return;
		}

		ob_start();
		?>
		<!-- wp:group {
			"className":"suki-header-desktop suki-show-on-desktop"
		} --><div id="header" class="suki-header-desktop suki-show-on-desktop">

			<?php
			// Header Top Bar (if not merged).
			if ( ! boolval( suki_get_theme_mod( 'header_top_bar_merged' ) ) ) {
				suki_header_desktop__top_bar();
			}

			// Header Main Bar.
			suki_header_desktop__main_bar();

			// Header Bottom Bar (if not merged).
			if ( ! boolval( suki_get_theme_mod( 'header_bottom_bar_merged' ) ) ) {
				suki_header_desktop__bottom_bar();
			}
			?>

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


if ( ! function_exists( 'suki_header_element' ) ) {
	/**
	 * Wrapper function to print HTML markup for all header element.
	 *
	 * @param string  $element Element slug.
	 * @param boolean $echo      Render or return.
	 * @param boolean $do_blocks Parse blocks or not.
	 * @return string
	 */
	function suki_header_element( $element, $echo = true, $do_blocks = true ) {
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