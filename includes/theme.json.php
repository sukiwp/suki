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
	// Font families.
	$font_families = array();
	foreach ( suki_flatten_array( suki_get_all_fonts() ) as $font_name => $font_stack ) {
		$font_families[] = array(
			'fontFamily' => $font_stack,
			'name'       => $font_name,
			'slug'       => sanitize_title( $font_name ),
		);
	}

	// Color palette.
	$palette = array();
	for ( $i = 1; $i <= 8; $i++ ) {
		$palette[] = array(
			'slug'  => 'suki-color-' . $i,
			'color' => suki_get_theme_mod( 'color_palette_' . $i ), // var(--color-palette-$i).
			'name'  => suki_get_theme_mod( 'color_palette_' . $i . '_name' ),
		);
	}

	/**
	 * Build new data
	 */

	$new_data = array(
		'version'  => 2,
		'settings' => array(
			'color'      => array(
				'palette' => $palette,
			),
			'typography' => array(
				'fontFamilies' => $font_families,
			),
		),
	);

	return $theme_json->update_with( $new_data );
}
add_filter( 'wp_theme_json_data_theme', 'suki_theme_json' );
