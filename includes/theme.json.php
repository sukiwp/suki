<?php
/**
 * Server-side theme.json
 *
 * @package Suki
 * @since 2.0.0
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add more configurations to theme.json.
 *
 * @param WP_Theme_JSON_Data $theme_json Theme JSON data object.
 * @return WP_Theme_JSON_Data
 */
function suki_theme_json( $theme_json ) {
	// Get all fonts list.
	$fonts = suki_flatten_array( suki_get_all_fonts() );

	// settings > layout.
	$settings__layout = array(
		'contentSize' => suki_get_theme_mod( 'container_narrow_width' ),
		'wideSize'    => suki_get_theme_mod( 'container_wide_width' ),
	);

	// // settings > typography > fontFamilies.
	// $settings__typography__font_families = array();
	// foreach ( $fonts as $font_name => $font_stack ) {
	// $settings__typography__font_families[] = array(
	// 'fontFamily' => $font_stack,
	// 'name'       => $font_name,
	// 'slug'       => sanitize_title( $font_name ), // e.g. "System Font" will be converted to "system-font".
	// );
	// }

	// // settings > color > palette.
	// $settings__color__palette = array();

	// $colors = array(
	// 'base'       => esc_html__( 'Base', 'suki' ),
	// 'base-2'     => esc_html__( 'Base 2', 'suki' ),
	// 'base-3'     => esc_html__( 'Base 3', 'suki' ),
	// 'contrast'   => esc_html__( 'Contrast', 'suki' ),
	// 'contrast-2' => esc_html__( 'Contrast 2', 'suki' ),
	// 'contrast-3' => esc_html__( 'Contrast 3', 'suki' ),
	// 'primary'    => esc_html__( 'Primary', 'suki' ),
	// 'primary-2'  => esc_html__( 'Primary 2', 'suki' ),
	// );
	// foreach ( $colors as $slug => $name ) {
	// $settings__color__palette[] = array(
	// 'slug'  => $slug,
	// 'color' => suki_get_theme_mod( 'color_' . str_replace( '-', '_', $slug ) ),
	// 'name'  => $name,
	// );
	// }

	// // styles > color.
	// $styles__color = array(
	// 'background' => suki_get_theme_mod( 'page_bg_color' ),
	// 'color'      => suki_get_theme_mod( 'body_text_color' ),
	// );

	// styles > spacing.
	$styles__spacing = array(
		'blockGap' => suki_get_theme_mod( 'block_spacing' ),
	);

	// // styles > typography.
	// $styles__typography = array(
	// 'fontFamily'    => suki_array_value( $fonts, suki_get_theme_mod( 'body_font_family' ) ),
	// 'fontSize'      => suki_get_theme_mod( 'body_font_size' ),
	// 'fontStyle'     => suki_get_theme_mod( 'body_font_style' ),
	// 'fontWeight'    => suki_get_theme_mod( 'body_font_weight' ),
	// 'lineHeight'    => suki_get_theme_mod( 'body_line_height' ),
	// 'letterSpacing' => suki_get_theme_mod( 'body_letter_spacing' ),
	// 'textTransform' => suki_get_theme_mod( 'body_text_transform' ),
	// );

	// // styles > elements.
	// $styles__elements = array(
	// 'link'    => array(
	// 'color'  => array(
	// 'text' => suki_get_theme_mod( 'link_text_color' ),
	// ),
	// ':hover' => array(
	// 'color' => array(
	// 'text' => suki_get_theme_mod( 'link_hover_text_color' ),
	// ),
	// ),
	// ':focus' => array(
	// 'color' => array(
	// 'text' => suki_get_theme_mod( 'link_hover_text_color' ),
	// ),
	// ),
	// ),
	// 'heading' => array(
	// 'color' => array(
	// 'text' => suki_get_theme_mod( 'heading_text_color' ),
	// ),
	// ),
	// 'h1'      => array(
	// 'typography' => array(
	// 'fontFamily'    => suki_get_theme_mod( 'h1_font_family' ),
	// 'fontSize'      => suki_get_theme_mod( 'h1_font_size' ),
	// 'fontStyle'     => suki_get_theme_mod( 'h1_font_style' ),
	// 'fontWeight'    => suki_get_theme_mod( 'h1_font_weight' ),
	// 'lineHeight'    => suki_get_theme_mod( 'h1_line_height' ),
	// 'letterSpacing' => suki_get_theme_mod( 'h1_letter_spacing' ),
	// 'textTransform' => suki_get_theme_mod( 'h1_text_transform' ),
	// ),
	// ),
	// 'h2'      => array(
	// 'typography' => array(
	// 'fontFamily'    => suki_get_theme_mod( 'h2_font_family' ),
	// 'fontSize'      => suki_get_theme_mod( 'h2_font_size' ),
	// 'fontStyle'     => suki_get_theme_mod( 'h2_font_style' ),
	// 'fontWeight'    => suki_get_theme_mod( 'h2_font_weight' ),
	// 'lineHeight'    => suki_get_theme_mod( 'h2_line_height' ),
	// 'letterSpacing' => suki_get_theme_mod( 'h2_letter_spacing' ),
	// 'textTransform' => suki_get_theme_mod( 'h2_text_transform' ),
	// ),
	// ),
	// 'h3'      => array(
	// 'typography' => array(
	// 'fontFamily'    => suki_get_theme_mod( 'h3_font_family' ),
	// 'fontSize'      => suki_get_theme_mod( 'h3_font_size' ),
	// 'fontStyle'     => suki_get_theme_mod( 'h3_font_style' ),
	// 'fontWeight'    => suki_get_theme_mod( 'h3_font_weight' ),
	// 'lineHeight'    => suki_get_theme_mod( 'h3_line_height' ),
	// 'letterSpacing' => suki_get_theme_mod( 'h3_letter_spacing' ),
	// 'textTransform' => suki_get_theme_mod( 'h3_text_transform' ),
	// ),
	// ),
	// 'h4'      => array(
	// 'typography' => array(
	// 'fontFamily'    => suki_get_theme_mod( 'h4_font_family' ),
	// 'fontSize'      => suki_get_theme_mod( 'h4_font_size' ),
	// 'fontStyle'     => suki_get_theme_mod( 'h4_font_style' ),
	// 'fontWeight'    => suki_get_theme_mod( 'h4_font_weight' ),
	// 'lineHeight'    => suki_get_theme_mod( 'h4_line_height' ),
	// 'letterSpacing' => suki_get_theme_mod( 'h4_letter_spacing' ),
	// 'textTransform' => suki_get_theme_mod( 'h4_text_transform' ),
	// ),
	// ),
	// 'h5'      => array(
	// 'typography' => array(
	// 'fontFamily'    => suki_get_theme_mod( 'h5_font_family' ),
	// 'fontSize'      => suki_get_theme_mod( 'h5_font_size' ),
	// 'fontStyle'     => suki_get_theme_mod( 'h5_font_style' ),
	// 'fontWeight'    => suki_get_theme_mod( 'h5_font_weight' ),
	// 'lineHeight'    => suki_get_theme_mod( 'h5_line_height' ),
	// 'letterSpacing' => suki_get_theme_mod( 'h5_letter_spacing' ),
	// 'textTransform' => suki_get_theme_mod( 'h5_text_transform' ),
	// ),
	// ),
	// 'h6'      => array(
	// 'typography' => array(
	// 'fontFamily'    => suki_get_theme_mod( 'h6_font_family' ),
	// 'fontSize'      => suki_get_theme_mod( 'h6_font_size' ),
	// 'fontStyle'     => suki_get_theme_mod( 'h6_font_style' ),
	// 'fontWeight'    => suki_get_theme_mod( 'h6_font_weight' ),
	// 'lineHeight'    => suki_get_theme_mod( 'h6_line_height' ),
	// 'letterSpacing' => suki_get_theme_mod( 'h6_letter_spacing' ),
	// 'textTransform' => suki_get_theme_mod( 'h6_text_transform' ),
	// ),
	// ),
	// 'button'  => array(
	// 'border'     => array(
	// 'radius' => suki_get_theme_mod( 'button_border_radius' ),
	// 'color'  => suki_get_theme_mod( 'button_border_color' ),
	// 'style'  => 'solid',
	// 'width'  => suki_get_theme_mod( 'button_border' ),
	// ),
	// 'color'      => array(
	// 'background' => suki_get_theme_mod( 'button_bg_color' ),
	// 'text'       => suki_get_theme_mod( 'button_text_color' ),
	// ),
	// 'spacing'    => array(
	// 'padding' => implode( ' ', suki_get_theme_mod( 'button_padding' ) ),
	// ),
	// 'typography' => array(
	// 'fontFamily'    => suki_get_theme_mod( 'button_font_family' ),
	// 'fontSize'      => suki_get_theme_mod( 'button_font_size' ),
	// 'fontStyle'     => suki_get_theme_mod( 'button_font_style' ),
	// 'fontWeight'    => suki_get_theme_mod( 'button_font_weight' ),
	// 'lineHeight'    => suki_get_theme_mod( 'button_line_height' ),
	// 'letterSpacing' => suki_get_theme_mod( 'button_letter_spacing' ),
	// 'textTransform' => suki_get_theme_mod( 'button_text_transform' ),
	// ),
	// ':hover'     => array(
	// 'border' => array(
	// 'color' => suki_get_theme_mod( 'button_hover_border_color' ),
	// ),
	// 'color'  => array(
	// 'background' => suki_get_theme_mod( 'button_hover_bg_color' ),
	// 'text'       => suki_get_theme_mod( 'button_hover_text_color' ),
	// ),
	// ),
	// ':focus'     => array(
	// 'border' => array(
	// 'color' => suki_get_theme_mod( 'button_hover_border_color' ),
	// ),
	// 'color'  => array(
	// 'background' => suki_get_theme_mod( 'button_hover_bg_color' ),
	// 'text'       => suki_get_theme_mod( 'button_hover_text_color' ),
	// ),
	// ),
	// ),
	// 'caption' => array(),
	// 'cite'    => array(),
	// );

	// // styles > blocks.
	// $styles__blocks = array(
	// 'core/heading' => array(
	// 'elements' => array(
	// 'link' => array(
	// ':hover' => array(
	// 'color' => array(
	// 'text' => suki_get_theme_mod( 'heading_link_hover_text_color' ),
	// ),
	// ),
	// ':focus' => array(
	// 'color' => array(
	// 'text' => suki_get_theme_mod( 'heading_link_hover_text_color' ),
	// ),
	// ),
	// ),
	// ),
	// ),
	// );

	/**
	 * Merge with new additional data
	 */

	$new_data = array(
		'version'  => 2, // REQUIRED, even if we don't change this value.
		'settings' => array(
			'layout'     => $settings__layout,
			'color'      => array(
				// 'palette' => $settings__color__palette,
			),
			'typography' => array(
				// 'fontFamilies' => $settings__typography__font_families,
			),
		),
		'styles'   => array(
			'spacing' => $styles__spacing,
			// 'color'      => $styles__color,
			// 'typography' => $styles__typography,
			// 'elements'   => $styles__elements,
			// 'blocks'     => $styles__blocks,
		),
	);

	return $theme_json->update_with( $new_data );
}
add_filter( 'wp_theme_json_data_theme', 'suki_theme_json' );
