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
					"className":"entry-title ' . ( 'default' === $layout ? 'suki-title' : 'suki-small-title' ) . '"
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
					"className":"is-style-wide"
				} --><hr class="wp-block-separator has-alpha-channel-opacity is-style-wide"/><!-- /wp:separator -->
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
 * Entry thumbnail
 */
if ( ! function_exists( 'suki_entry_thumbnail' ) ) {
	/**
	 * Render entry thumbnail.
	 *
	 * @param string  $size      Thumbnail size (`thumbnail`, `medium`, `large`, `full`).
	 * @param boolean $is_wide   Use wide alignment or not.
	 * @param boolean $do_blocks Parse blocks or not.
	 * @param boolean $echo      Render or return.
	 * @return string
	 */
	function suki_entry_thumbnail( $size = 'thumbnail', $is_wide = false, $do_blocks = true, $echo = true ) {
		$html = '
		<!-- wp:group {
			"className":"entry-thumbnail",
			"layout":{
				"inherit":true
			}
		} --><div class="wp-block-group entry-thumbnail">

			<!-- wp:post-featured-image {
				' . esc_attr( boolval( $is_wide ) ? '"align":"wide",' : '' ) . '
				' . esc_attr( 'full' !== $size ? '"width":"' . get_option( $size . '_size_w' ) . 'px",' : '' ) . '
				' . esc_attr( 'full' !== $size ? '"height":"' . get_option( $size . '_size_h' ) . 'px",' : '' ) . '
				"isLink":true
			} /-->

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
 * Entry meta
 */
if ( ! function_exists( 'suki_entry_meta' ) ) {
	/**
	 * Render entry meta.
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

		// Wrap the first and last elements.
		$text = '<span>' . $text . '</span>';

		// Open and close wrap for syntax.
		$text = str_replace( '{{', '</span>{{', $text );
		$text = str_replace( '}}', '}}<span>', $text );

		// Remove blank parts.
		$text = str_replace( '<span></span>', '', $text );

		/**
		 * Convert syntax tag to blocks
		 */

		// Get all smart tags.
		preg_match_all( '/{{(.*?)}}/', $text, $matches, PREG_SET_ORDER );

		// Iterate each smart tag and convert it to real HTML.
		foreach ( $matches as $match ) {
			$meta = suki_entry_meta_element( $match[1], false, false );

			$text = str_replace( $match[0], $meta, $text );
		}

		/**
		 * Build HTML
		 */

		$html = '
		<!-- wp:group {
			"className":"entry-meta suki-meta suki-reverse-link-color has-text-align-' . $alignment . '",
			"layout":{
				"type":"flex",
				"flexWrap":"wrap",
				"verticalAlignment":"top",
				"justifyContent":"' . $alignment . '"
			}
		} --><div class="wp-block-group entry-meta suki-meta suki-reverse-link-color has-text-align-' . $alignment . '">
			' . $text . '
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
					"isLink":true,
					"className":"entry-meta__date"
				} /-->
				';
				break;

			case 'author':
				$html = '
				<!-- wp:post-author {
					"showAvatar":false
				} /-->
				';
				break;

			case 'avatar':
				$html = '
				<!-- wp:avatar {
					"size":' . apply_filters( 'suki/frontend/entry_author_bio_avatar_size', 80 ) . ',
					"className":"entry-meta__avatar"
				} /-->
				';
				break;

			case 'categories':
				$html = '
				<!-- wp:post-terms {
					"term":"category",
					"className":"entry-meta__categories"
				} /-->
				';
				break;

			case 'tags':
				$html = '
				<!-- wp:post-terms {
					"term":"post_tag",
					"className":"entry-meta__tags"
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
				$html = '<span>' . $element . '</span>';
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
