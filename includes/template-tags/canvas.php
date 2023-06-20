<?php
/**
 * Canvas template rendering functions.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render content section with the specified main content.
 *
 * Notes:
 * - Theme uses `.suki-boxed-page` class to add / override styles.
 *
 * @todo Remove additional `core/group` block to wrap the `suki-canvas` when `core/cover` block already supports layout's content width options.
 *
 * @param string  $page_content Page content.
 * @param boolean $do_blocks    Parse blocks or not.
 * @param boolean $echo         Render or return.
 * @return string
 */
function suki_canvas( $page_content, $do_blocks = true, $echo = true ) {
	ob_start();

	/**
	 * Hook: suki/frontend/before_canvas
	 *
	 * @hooked suki_skip_to_content_link - 1
	 */
	do_action( 'suki/frontend/before_canvas' );

	/**
	 * Boxed page wrapper -- Open.
	 */
	$page_layout = suki_get_theme_mod( 'page_layout' );
	if ( 'boxed' === $page_layout ) {
		$bg_color = suki_parse_color_value_for_block_attributes( suki_get_theme_mod( 'outside_bg_color' ), 'background' );

		$bg_image          = suki_get_theme_mod( 'outside_bg_image' );
		$bg_image_url      = wp_get_original_image_url( $bg_image );
		$bg_image_parallax = boolval( suki_get_theme_mod( 'outside_bg_parallax' ) );
		$bg_image_repeat   = boolval( suki_get_theme_mod( 'outside_bg_repeat' ) );

		$bg_color_overlay_dim = suki_get_theme_mod( 'outside_bg_color_overlay_dim', 0 );

		$block_styles = array(
			'min-height'     => '0vh',
			'padding-top'    => '0',
			'padding-right'  => '0',
			'padding-bottom' => '0',
			'padding-left'   => '0',
		);

		$block_classes = array(
			boolval( $bg_image_parallax ) ? 'has-parallax' : '',
			boolval( $bg_image_repeat ) ? 'is-repeated' : '',
		);

		$overlay_styles = array(
			'background-color' => $bg_color['custom_value'],
		);

		$overlay_classes = array_merge(
			$bg_color['classes'],
			array(
				'has-background-dim-' . ( ! empty( $bg_image_url ) ? $bg_color_overlay_dim : 100 ),
				'has-background-dim',
			)
		);
		?>
		<!-- wp:cover {
			<?php
			// Background image.
			if ( ! empty( $bg_image_url ) ) {
				?>
				"url":"<?php echo esc_attr( $bg_image_url ); ?>",
				"id":<?php echo esc_attr( $bg_image ); ?>,
				"dimRatio":0,
				<?php
				if ( boolval( $bg_image_parallax ) ) {
					?>
					"hasParallax":true,
					<?php
				}
				if ( boolval( $bg_image_repeat ) ) {
					?>
					"isRepeated":true,
					<?php
				}
			}
			// Background color.
			if ( false !== $bg_color['custom_value'] ) {
				?>
				"customOverlayColor":"<?php echo esc_attr( $bg_color['custom_value'] ); ?>",
				<?php
			} else {
				?>
				"overlayColor":"<?php echo esc_attr( $bg_color['preset_value'] ); ?>",
				<?php
			}
			?>
			"minHeight":0,
			"minHeightUnit":"vh",
			"contentPosition":"center center",
			"isDark":false,
			"style":{
				"spacing":{
					"padding":{
						"top":"0",
						"right":"0",
						"bottom":"0",
						"left":"0"
					}
				}
			},
			"className":"suki-boxed-page"
		} --><div class="wp-block-cover is-light suki-boxed-page <?php suki_element_class( $block_classes, false ); ?>" <?php suki_element_style( $block_styles ); ?>>

			<span aria-hidden="true" class="wp-block-cover__background <?php suki_element_class( $overlay_classes, false ); ?>" <?php suki_element_style( $overlay_styles ); ?>></span>

			<?php
			if ( ! empty( $bg_image_url ) ) {
				$bg_image_classes = array(
					'wp-image-' . $bg_image,
				);
				if ( boolval( $bg_image_parallax ) || boolval( $bg_image_repeat ) ) {
					if ( boolval( $bg_image_parallax ) ) {
						$bg_image_classes[] = 'has-parallax';
					}
					if ( boolval( $bg_image_repeat ) ) {
						$bg_image_classes[] = 'is-repeated';
					}
					?>
					<div role="img" class="wp-block-cover__image-background <?php echo esc_attr( implode( ' ', $bg_image_classes ) ); ?>" style="background-position:50% 50%;background-image:url(<?php echo esc_attr( $bg_image_url ); ?>)"></div>
					<?php
				} else {
					?>
					<img class="wp-block-cover__image-background <?php echo esc_attr( implode( ' ', $bg_image_classes ) ); ?>" alt="" src="<?php echo esc_attr( $bg_image_url ); ?>" data-object-fit="cover"/>
					<?php
				}
			}
			?>

			<div class="wp-block-cover__inner-container">

				<!-- wp:group {
					"layout":{
						"type":"flex",
						"flexWrap":"nowrap",
						"justifyContent":"center"
					}
				} --><div class="wp-block-group">
		<?php
	}
	?>

	<?php
	$canvas_bg_color   = suki_parse_color_value_for_block_attributes( suki_get_theme_mod( 'page_bg_color' ), 'background' );
	$canvas_text_color = suki_parse_color_value_for_block_attributes( suki_get_theme_mod( 'body_text_color' ), 'text' );

	$canvas_styles = array(
		'min-height'       => '100vh',
		'background-color' => $canvas_bg_color['custom_value'],
	);

	$canvas_classes = array_merge(
		$canvas_bg_color['classes'],
		$canvas_text_color['classes'],
	);
	?>
	<!-- wp:group {
		"layout":{
			"type":"flex",
			"orientation":"vertical",
			"justifyContent":"stretch"
		},
		"style":{
			<?php
			if ( 'boxed' === $page_layout ) {
				?>
				"layout":{
					"selfStretch":"fixed",
					"flexSize":"<?php echo esc_attr( suki_get_theme_mod( 'boxed_page_width' ) ); ?>"
				},
				<?php
			}
			?>
			"dimensions":{
				"minHeight":"100vh"
			},
			"spacing":{
				"blockGap":"0"
			},
			"style":{
				"color":{
					"text":"<?php echo esc_attr( $canvas_text_color['custom_value'] ); ?>",
					"background":"<?php echo esc_attr( $canvas_bg_color['custom_value'] ); ?>"
				}
			},
			"textColor":"<?php echo esc_attr( $canvas_text_color['preset_value'] ); ?>",
			"backgroundColor":"<?php echo esc_attr( $canvas_bg_color['preset_value'] ); ?>",
			"className":"suki-canvas"
		}
	} --><div id="canvas" class="wp-block-group suki-canvas <?php suki_element_class( $canvas_classes, false ); ?>" <?php suki_element_style( $canvas_styles ); ?>>

		<?php
		/**
		 * Hook: suki/frontend/before_header
		 */
		do_action( 'suki/frontend/before_header' );

		/**
		 * Header
		 */
		suki_header();

		/**
		 * Hook: suki/frontend/after_header
		 */
		do_action( 'suki/frontend/after_header' );

		/**
		 * Page content
		 */
		echo $page_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		/**
		 * Hook: suki/frontend/before_footer
		 */
		do_action( 'suki/frontend/before_footer' );

		/**
		 * Footer
		 */
		suki_footer();

		/**
		 * Hook: suki/frontend/after_footer
		 */
		do_action( 'suki/frontend/after_footer' );
		?>

	</div><!-- /wp:group -->
	<?php

	/**
	 * Boxed page wrapper -- Close.
	 */
	if ( 'boxed' === $page_layout ) {
		?>
				</div><!-- /wp:group -->
			</div>

		</div><!-- /wp:cover -->
		<?php
	}

	/**
	 * Hook: suki/frontend/after_canvas
	 */
	do_action( 'suki/frontend/after_canvas' );

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
