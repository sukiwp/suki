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
	 * @param boolean $echo      Render or return.
	 * @param boolean $do_blocks Parse blocks or not.
	 * @return string
	 */
	function suki_entry_header_footer_element( $element, $layout = 'default', $alignment = 'left', $echo = true, $do_blocks = true ) {
		// Set fallback layout to "default".
		if ( empty( $layout ) ) {
			$layout = 'default';
		}

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
	 * @param boolean $echo      Render or return.
	 * @param boolean $do_blocks Parse blocks or not.
	 * @return string
	 */
	function suki_entry_thumbnail( $echo = true, $do_blocks = true ) {
		$size = suki_get_theme_mod( 'entry_thumbnail_size', 'full' );

		$html = '
		<!-- wp:post-featured-image {
			"isLink":true,
			' . ( 'full' !== $size ? '"width":' . get_option( $size . '_size_w' ) . ',' : '' ) . '
			' . ( 'full' !== $size ? '"height":' . get_option( $size . '_size_h' ) . ',' : '' ) . '
			' . ( boolval( suki_get_theme_mod( 'entry_thumbnail_wide' ) ) ? '"align":"wide",' : '' ) . '
			"className":"' . suki_element_class( 'entry/thumbnail', array( 'entry-thumbnail' ), false ) . '"
		} /-->
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
	 * @param boolean $echo      Render or return.
	 * @param boolean $do_blocks Parse blocks or not.
	 * @return string
	 */
	function suki_entry_meta( $text, $alignment = 'left', $echo = true, $do_blocks = true ) {
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
			"style":{
				"spacing":{
					"blockGap":"0px"
				}
			},
			"className":"entry-meta suki-meta suki-reverse-link-color",
			"layout":{
				"type":"flex",
				"flexWrap":"wrap",
				"verticalAlignment":"top",
				"justifyContent":"' . $alignment . '"
			}
		} --><div class="wp-block-group entry-meta suki-meta suki-reverse-link-color">
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
	 * @param boolean $echo      Render or return.
	 * @param boolean $do_blocks Parse blocks or not.
	 * @return string
	 */
	function suki_entry_meta_element( $element, $echo = true, $do_blocks = true ) {
		switch ( $element ) {
			case 'date':
				$html = '
				<!-- wp:post-date {
					"format":null,
					"isLink":true,
					"className":"entry-meta__date"
				} /-->
				';
				break;

			case 'author':
				$html = '
				<!-- wp:post-author {
					"showAvatar":false,
					"className":"entry-meta__author"
				} /-->
				';
				break;

			case 'avatar':
				$html = '
				<!-- wp:post-author {
					"avatarSize":48,
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
				<!-- wp:comments-title {
					"showPostTitle":false,
					"level":6,
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
