<?php
/**
 * Layout block support flag.
 *
 * @package Suki
 * @since 2.0.0
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add custom styles for block layout support.
 *
 * This filter is used because we disabled the original layout styles via `add_theme_support( 'disable-layout-styles' )`.
 *
 * Suki is not a block-based theme yet, so WordPress processed the layout support CSS very late.
 * The original layout CSS are enqueued in `wp_footer` hook and it might cause FOUC (Flash of Unstyled Content).
 *
 * Therefore, we will handle the layout support CSS by ourself.
 * We will add a `<style>` tag just before the block tag.
 * This way, the CSS will always be added before the block elements, so there is no FOUC.
 *
 * Possible issues:
 * - CSS targeting element with `:nth-child`, `first-child`, and `last-child` might wrongly target the added `<style>` tag.
 *
 * @see wp_render_layout_support_flag
 *
 * @param string $block_content Block content.
 * @param array  $block         Block object.
 */
function suki_render_layout_support_styles( $block_content, $block ) {
	$block_type     = WP_Block_Type_Registry::get_instance()->get_registered( $block['blockName'] );
	$support_layout = block_has_support( $block_type, array( '__experimentalLayout' ), false );

	if ( ! $support_layout ) {
		return $block_content;
	}

	$block_gap              = wp_get_global_settings( array( 'spacing', 'blockGap' ) );
	$global_layout_settings = wp_get_global_settings( array( 'layout' ) );
	$has_block_gap_support  = isset( $block_gap ) ? null !== $block_gap : false;
	$default_block_layout   = _wp_array_get( $block_type->supports, array( '__experimentalLayout', 'default' ), array() );
	$used_layout            = isset( $block['attrs']['layout'] ) ? $block['attrs']['layout'] : $default_block_layout;

	if ( isset( $used_layout['inherit'] ) && $used_layout['inherit'] ) {
		if ( ! $global_layout_settings ) {
			return $block_content;
		}
	}

	$block_classname = wp_get_block_default_classname( $block['blockName'] );
	$container_class = wp_unique_id( 'wp-container-' );

	// Set the correct layout type for blocks using legacy content width.
	if ( isset( $used_layout['inherit'] ) && $used_layout['inherit'] || isset( $used_layout['contentSize'] ) && $used_layout['contentSize'] ) {
		$used_layout['type'] = 'constrained';
	}

	/*
	 * Theme's custom styling
	 */
	if ( current_theme_supports( 'disable-layout-styles' ) ) {
		$gap_value = _wp_array_get( $block, array( 'attrs', 'style', 'spacing', 'blockGap' ) );

		/*
		 * Skip if gap value contains unsupported characters.
		 * Regex for CSS value borrowed from `safecss_filter_attr`, and used here
		 * to only match against the value, not the CSS attribute.
		 */
		if ( is_array( $gap_value ) ) {
			foreach ( $gap_value as $key => $value ) {
				$gap_value[ $key ] = $value && preg_match( '%[\\\(&=}]|/\*%', $value ) ? null : $value;
			}
		} else {
			$gap_value = $gap_value && preg_match( '%[\\\(&=}]|/\*%', $gap_value ) ? null : $gap_value;
		}

		$fallback_gap_value = _wp_array_get( $block_type->supports, array( 'spacing', 'blockGap', '__experimentalDefault' ), '0.5em' );
		$block_spacing      = _wp_array_get( $block, array( 'attrs', 'style', 'spacing' ), null );

		/*
		 * If a block's block.json skips serialization for spacing or spacing.blockGap,
		 * don't apply the user-defined value to the styles.
		 */
		$should_skip_gap_serialization = wp_should_skip_block_supports_serialization( $block_type, 'spacing', 'blockGap' );

		/**
		 * Theme's generated CSS
		 *
		 * @see wp_get_layout_style
		 */

		$selector = ".$block_classname.$container_class";
		$layout   = $used_layout;

		$layout_type   = isset( $used_layout['type'] ) ? $used_layout['type'] : 'default';
		$layout_styles = array();

		if ( 'default' === $layout_type ) {
			/**
			 * Mode: Flow (default).
			 */

			if ( $has_block_gap_support ) {
				if ( is_array( $gap_value ) ) {
					$gap_value = isset( $gap_value['top'] ) ? $gap_value['top'] : null;
				}
				if ( null !== $gap_value && ! $should_skip_gap_serialization ) {
					// Get spacing CSS variable from preset value if provided.
					if ( is_string( $gap_value ) && str_contains( $gap_value, 'var:preset|spacing|' ) ) {
						$index_to_splice = strrpos( $gap_value, '|' ) + 1;
						$slug            = _wp_to_kebab_case( substr( $gap_value, $index_to_splice ) );
						$gap_value       = "var(--wp--preset--spacing--$slug)";
					}

					// Add inline styles.
					$layout_styles[ "$selector>*+*" ]['margin-block-start'] = $gap_value;
				}
			}
		} elseif ( 'constrained' === $layout_type ) {
			/**
			 * Mode: Constrained.
			 */

			$content_size    = isset( $layout['contentSize'] ) ? $layout['contentSize'] : '';
			$wide_size       = isset( $layout['wideSize'] ) ? $layout['wideSize'] : '';
			$justify_content = isset( $layout['justifyContent'] ) ? $layout['justifyContent'] : 'center';

			$all_max_width_value  = $content_size ? $content_size : $wide_size;
			$wide_max_width_value = $wide_size ? $wide_size : $content_size;

			// Make sure there is a single CSS rule, and all tags are stripped for security.
			$all_max_width_value  = safecss_filter_attr( explode( ';', $all_max_width_value )[0] );
			$wide_max_width_value = safecss_filter_attr( explode( ';', $wide_max_width_value )[0] );

			if ( $content_size || $wide_size ) {
				// Add inline styles.
				$layout_styles[ "$selector > :where(:not(.alignleft):not(.alignright):not(.alignfull))" ]['max-width'] = $all_max_width_value;
				$layout_styles[ "$selector > .alignwide" ]['max-width'] = $wide_max_width_value;

				if ( isset( $block_spacing ) ) {
					$block_spacing_values = wp_style_engine_get_styles(
						array(
							'spacing' => $block_spacing,
						)
					);

					/*
					 * Handle negative margins for alignfull children of blocks with custom padding set.
					 * They're added separately because padding might only be set on one side.
					 */
					if ( isset( $block_spacing_values['declarations']['padding-right'] ) ) {
						$padding_right = $block_spacing_values['declarations']['padding-right'];
						$layout_styles[ "$selector > .alignfull" ]['margin-right'] = "calc($padding_right * -1)";
					}
					if ( isset( $block_spacing_values['declarations']['padding-left'] ) ) {
						$padding_left = $block_spacing_values['declarations']['padding-left'];
						$layout_styles[ "$selector > .alignfull" ]['margin-left'] = "calc($padding_right * -1)";
					}
				}
			}

			if ( 'left' === $justify_content ) {
				$layout_styles[ "$selector > :where(:not(.alignleft):not(.alignright):not(.alignfull))" ]['margin-left'] = '0 !important';
			}

			if ( 'right' === $justify_content ) {
				$layout_styles[ "$selector > :where(:not(.alignleft):not(.alignright):not(.alignfull))" ]['margin-right'] = '0 !important';
			}

			if ( $has_block_gap_support ) {
				if ( is_array( $gap_value ) ) {
					$gap_value = isset( $gap_value['top'] ) ? $gap_value['top'] : null;
				}
				if ( null !== $gap_value && ! $should_skip_gap_serialization ) {
					// Get spacing CSS variable from preset value if provided.
					if ( is_string( $gap_value ) && str_contains( $gap_value, 'var:preset|spacing|' ) ) {
						$index_to_splice = strrpos( $gap_value, '|' ) + 1;
						$slug            = _wp_to_kebab_case( substr( $gap_value, $index_to_splice ) );
						$gap_value       = "var(--wp--preset--spacing--$slug)";
					}

					// Add inline styles.
					$layout_styles[ "$selector>*+*" ]['margin-block-start'] = $gap_value;
				}
			}
		} elseif ( 'flex' === $layout_type ) {
			/**
			 * Mode: Flex.
			 */

			if ( $has_block_gap_support && isset( $gap_value ) ) {
				$combined_gap_value = '';
				$gap_sides          = is_array( $gap_value ) ? array( 'top', 'left' ) : array( 'top' );

				foreach ( $gap_sides as $gap_side ) {
					$process_value = is_string( $gap_value ) ? $gap_value : _wp_array_get( $gap_value, array( $gap_side ), $fallback_gap_value );
					// Get spacing CSS variable from preset value if provided.
					if ( is_string( $process_value ) && str_contains( $process_value, 'var:preset|spacing|' ) ) {
						$index_to_splice = strrpos( $process_value, '|' ) + 1;
						$slug            = _wp_to_kebab_case( substr( $process_value, $index_to_splice ) );
						$process_value   = "var(--wp--preset--spacing--$slug)";
					}
					$combined_gap_value .= "$process_value ";
				}
				$gap_value = trim( $combined_gap_value );

				if ( null !== $gap_value && ! $should_skip_gap_serialization ) {
					$layout_styles[ "$selector" ]['gap'] = $gap_value;
				}
			}
		}

		if ( ! empty( $layout_styles ) ) {
			$style = suki_convert_css_array_to_string( array( 'global' => $layout_styles ) );
		}

		// Only add container class and enqueue block support styles if unique styles were generated.
		if ( ! empty( $style ) ) {
			$block_content = preg_replace(
				'/' . preg_quote( 'class="', '/' ) . '/',
				'class="' . esc_attr( $container_class ) . ' ',
				$block_content,
				1
			);

			$block_content = '<style id="suki-css--' . $container_class . '" style="display:none">' . $style . '</style>' . $block_content;
		}
	}

	return $block_content;
}
add_filter( 'render_block', 'suki_render_layout_support_styles', 10, 2 );
