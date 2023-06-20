<?php
/**
 * Post entry template rendering functions.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Post entry header & footer element
 */
if ( ! function_exists( 'suki_entry_header_footer_element' ) ) {
	/**
	 * Render entry header & footer element.
	 *
	 * Note:
	 * - Theme uses `suki-title` class to add / override styles.
	 * - Theme uses `suki-small-title` class to add / override styles.
	 *
	 * @param string  $element   Element slug.
	 * @param string  $layout    Layout slug.
	 * @param string  $alignment Element alignment (left, center, or right).
	 * @param boolean $do_blocks Parse blocks or not.
	 * @param boolean $echo      Render or return.
	 * @return string
	 */
	function suki_entry_header_footer_element( $element, $layout = 'default', $alignment = 'left', $do_blocks = true, $echo = true ) {
		// Set fallback layout to "default".
		if ( empty( $layout ) ) {
			$layout = 'default';
		}

		$html = '';

		switch ( $element ) {
			case 'title':
				$html = '
				<!-- wp:post-title {
					"level":2,
					"isLink":true,
					"textAlign":"' . $alignment . '",
					"className":"' . ( 'default' === $layout ? 'suki-title' : 'suki-small-title' ) . '"
				} /-->
				';
				break;

			case 'header-meta':
				$html = suki_entry_meta( suki_get_theme_mod( 'entry_' . ( 'default' === $layout ? '' : $layout . '_' ) . 'header_meta' ), $alignment, false, false );
				break;

			case 'footer-meta':
				$html = suki_entry_meta( suki_get_theme_mod( 'entry_' . ( 'default' === $layout ? '' : $layout . '_' ) . 'footer_meta' ), $alignment, false, false );
				break;

			case 'hr':
				$html = '
				<!-- wp:separator {
					"backgroundColor":"base-3",
					"className":"is-style-wide"
				} --><hr class="wp-block-separator has-text-color has-base-3-color has-alpha-channel-opacity has-base-3-background-color has-background is-style-wide"/><!-- /wp:separator -->
				';
				break;

			default:
				$html = '';
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
 * Entry meta
 */
if ( ! function_exists( 'suki_entry_meta' ) ) {
	/**
	 * Render entry meta.
	 *
	 * Note:
	 * - Theme uses `suki-meta` class to add / override styles.
	 *
	 * @since 2.0.0 Add $echo parameter with default to true.
	 *
	 * @param string  $text      Format text.
	 * @param string  $alignment Text alignment.
	 * @param boolean $do_blocks Parse blocks or not.
	 * @param boolean $echo      Render or return.
	 * @return string
	 */
	function suki_entry_meta( $text, $alignment = 'left', $do_blocks = true, $echo = true ) {
		// Remove unneccessary white space on the beginning and the end of the text.
		$text = trim( $text );

		// Abort if format is empty.
		if ( empty( $text ) ) {
			return;
		}

		/**
		 * Parse formatted tags
		 */

		// Inject delimiters.
		$text = str_replace( '{{', '<delimiter>{{', $text );
		$text = str_replace( '}}', '}}<delimiter>', $text );

		$nodes = explode( '<delimiter>', $text );

		/**
		 * Convert nodes to blocks
		 */

		// Prepare blocks HTML string.
		$blocks = '';

		// Iterate each smart tag and convert it to real HTML.
		foreach ( $nodes as $i => $node ) {
			if ( str_starts_with( $node, '{{' ) && str_ends_with( $node, '}}' ) ) {
				// If current node is smart tags, convert to the appropriate block.
				$node = str_replace( '{{', '', $node );
				$node = str_replace( '}}', '', $node );

				$blocks .= suki_entry_meta_element( $node, false, false );
			} else {
				// Otherwise, convert to HTML block.
				$blocks .= '<!-- wp:html -->' . $node . '<!-- /wp:html -->';
			}
		}

		/**
		 * Build HTML
		 */

		$html = '
		<!-- wp:group {
			"layout":{
				"type":"flex",
				"flexWrap":"wrap",
				"justifyContent":"' . $alignment . '",
				"verticalAlignment":"top"
			},
			"style":{
				"spacing":{
					"blockGap":"0.25em"
				}
			},
			"className":"suki-meta"
		} --><div class="wp-block-group suki-meta">
			' . $blocks . '
		</div><!-- /wp:group -->
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
 * Entry meta element
 */
if ( ! function_exists( 'suki_entry_meta_element' ) ) {
	/**
	 * Render entry meta element.
	 *
	 * @param string  $element   Element slug.
	 * @param boolean $do_blocks Parse blocks or not.
	 * @param boolean $echo      Render or return.
	 * @return string
	 */
	function suki_entry_meta_element( $element, $do_blocks = true, $echo = true ) {
		$html = '';

		switch ( $element ) {
			case 'date':
				$html = '
				<!-- wp:post-date {
					"isLink":true
				} /-->
				';
				break;

			case 'author':
				$html = '
				<!-- wp:post-author-name {
					"isLink":true
				} /-->
				';
				break;

			case 'avatar':
				$html = '
				<!-- wp:avatar {
					"size":30
				} /-->
				';
				break;

			case 'categories':
				$html = '
				<!-- wp:post-terms {
					"term":"category"
				} /-->
				';
				break;

			case 'tags':
				$html = '
				<!-- wp:post-terms {
					"term":"post_tag"
				} /-->
				';
				break;

			case 'comments':
				$html = '
				<!-- wp:post-comments-link {
					"className":"entry-meta__comments"
				} /-->
				';
				break;

			default:
				$html = '<!-- wp:html -->' . $element . '<!-- /wp:html -->';
				break;
		}

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
